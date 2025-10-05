package handlers

import (
	"encoding/json"
	"fmt"
	"html/template"
	"net/http"
	"os"
	"path/filepath"
	"strings"
	"time"

	"github.com/0x800a6/www/internal/middleware"
	"github.com/0x800a6/www/internal/models"
	"github.com/0x800a6/www/internal/utils"
	"github.com/yuin/goldmark"
	"github.com/yuin/goldmark/extension"
	"github.com/yuin/goldmark/parser"
	"github.com/yuin/goldmark/renderer/html"
)

// ChangelogHandler handles changelog page requests
func ChangelogHandler(w http.ResponseWriter, r *http.Request, tmplData models.TemplateData) {
	// Load changelog markdown file
	changelogPath := filepath.Join("CHANGELOG.md")
	if _, err := os.Stat(changelogPath); err != nil {
		changelogPath = filepath.Join("..", "CHANGELOG.md")
	}
	
	content, err := os.ReadFile(changelogPath)
	if err != nil {
		http.Error(w, fmt.Sprintf("Changelog not found at %s: %v", changelogPath, err), http.StatusNotFound)
		return
	}
	
	// Parse changelog
	changelogData, err := models.ParseChangelog(string(content))
	if err != nil {
		http.Error(w, "Error parsing changelog", http.StatusInternalServerError)
		return
	}
	
	// Apply filters from query parameters
	filter := models.ChangelogFilter{
		ShowUnreleased: true,
	}
	
	if version := r.URL.Query().Get("version"); version != "" {
		filter.Version = version
	}
	if changeType := r.URL.Query().Get("type"); changeType != "" {
		filter.ChangeType = changeType
	}
	if search := r.URL.Query().Get("search"); search != "" {
		filter.Search = search
	}
	if showUnreleased := r.URL.Query().Get("unreleased"); showUnreleased != "" {
		filter.ShowUnreleased = showUnreleased == "true"
	}
	if dateFrom := r.URL.Query().Get("date_from"); dateFrom != "" {
		if date, err := time.Parse("2006-01-02", dateFrom); err == nil {
			filter.DateFrom = date
		}
	}
	if dateTo := r.URL.Query().Get("date_to"); dateTo != "" {
		if date, err := time.Parse("2006-01-02", dateTo); err == nil {
			filter.DateTo = date
		}
	}
	
	// Apply filters
	filteredData := changelogData.FilterChangelog(filter)
	
	// Get statistics
	stats := changelogData.GetStats()
	versions := changelogData.GetVersions()
	changeTypes := changelogData.GetChangeTypes()
	
	// Prepare template data
	data := tmplData
	data.Page = models.PageData{
		Title:   "Changelog",
		Content: "changelog",
		Data: struct {
			Changelog   *models.ChangelogData
			Stats       models.ChangelogStats
			Versions    []string
			ChangeTypes []string
			Filter      models.ChangelogFilter
		}{
			Changelog:   filteredData,
			Stats:       stats,
			Versions:    versions,
			ChangeTypes: changeTypes,
			Filter:      filter,
		},
	}
	
	// Parse templates
	allTmpl, err := template.ParseGlob(utils.GetTemplatePath("templates/*.html"))
	if err != nil {
		http.Error(w, "Template parsing error", http.StatusInternalServerError)
		return
	}

	
	allTmpl, err = allTmpl.ParseFiles(utils.GetTemplatePath("html/changelog.html"))
	if err != nil {
		http.Error(w, fmt.Sprintf("Template parsing error: %v", err), http.StatusInternalServerError)
		return
	}
	
	// Use minify writer
	minifyWriter := middleware.NewMinifyResponseWriter(w)
	
	w.Header().Set("Content-Type", "text/html; charset=utf-8")
	err = allTmpl.ExecuteTemplate(minifyWriter, "base.html", data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	
	err = minifyWriter.Flush()
	if err != nil {
		// Log error but don't fail the request
	}
}

// ChangelogAPIHandler handles API requests for changelog data
func ChangelogAPIHandler(w http.ResponseWriter, r *http.Request, tmplData models.TemplateData) {
	// Load changelog markdown file
	changelogPath := filepath.Join("CHANGELOG.md")
	if _, err := os.Stat(changelogPath); err != nil {
		changelogPath = filepath.Join("..", "CHANGELOG.md")
	}
	
	content, err := os.ReadFile(changelogPath)
	if err != nil {
		http.Error(w, "Changelog not found", http.StatusNotFound)
		return
	}
	
	// Parse changelog
	changelogData, err := models.ParseChangelog(string(content))
	if err != nil {
		http.Error(w, "Error parsing changelog", http.StatusInternalServerError)
		return
	}
	
	// Apply filters from query parameters
	filter := models.ChangelogFilter{
		ShowUnreleased: true,
	}
	
	if version := r.URL.Query().Get("version"); version != "" {
		filter.Version = version
	}
	if changeType := r.URL.Query().Get("type"); changeType != "" {
		filter.ChangeType = changeType
	}
	if search := r.URL.Query().Get("search"); search != "" {
		filter.Search = search
	}
	if showUnreleased := r.URL.Query().Get("unreleased"); showUnreleased != "" {
		filter.ShowUnreleased = showUnreleased == "true"
	}
	if dateFrom := r.URL.Query().Get("date_from"); dateFrom != "" {
		if date, err := time.Parse("2006-01-02", dateFrom); err == nil {
			filter.DateFrom = date
		}
	}
	if dateTo := r.URL.Query().Get("date_to"); dateTo != "" {
		if date, err := time.Parse("2006-01-02", dateTo); err == nil {
			filter.DateTo = date
		}
	}
	
	// Apply filters
	filteredData := changelogData.FilterChangelog(filter)
	
	// Get statistics
	stats := changelogData.GetStats()
	versions := changelogData.GetVersions()
	changeTypes := changelogData.GetChangeTypes()
	
	// Prepare response data
	responseData := struct {
		Changelog   *models.ChangelogData `json:"changelog"`
		Stats       models.ChangelogStats `json:"stats"`
		Versions    []string              `json:"versions"`
		ChangeTypes []string              `json:"change_types"`
		Filter      models.ChangelogFilter `json:"filter"`
	}{
		Changelog:   filteredData,
		Stats:       stats,
		Versions:    versions,
		ChangeTypes: changeTypes,
		Filter:      filter,
	}
	
	// Set JSON content type
	w.Header().Set("Content-Type", "application/json")
	
	// Encode and send response
	encoder := json.NewEncoder(w)
	encoder.SetIndent("", "  ")
	err = encoder.Encode(responseData)
	if err != nil {
		http.Error(w, "Error encoding response", http.StatusInternalServerError)
		return
	}
}

// ChangelogRSSHandler handles RSS feed requests for changelog
func ChangelogRSSHandler(w http.ResponseWriter, r *http.Request, tmplData models.TemplateData) {
	// Load changelog markdown file
	changelogPath := filepath.Join("CHANGELOG.md")
	if _, err := os.Stat(changelogPath); err != nil {
		changelogPath = filepath.Join("..", "CHANGELOG.md")
	}
	
	content, err := os.ReadFile(changelogPath)
	if err != nil {
		http.Error(w, "Changelog not found", http.StatusNotFound)
		return
	}
	
	// Parse changelog
	changelogData, err := models.ParseChangelog(string(content))
	if err != nil {
		http.Error(w, "Error parsing changelog", http.StatusInternalServerError)
		return
	}
	
	// Generate RSS feed
	rssContent := generateRSSFeed(changelogData, tmplData)
	
	w.Header().Set("Content-Type", "application/rss+xml")
	w.Write([]byte(rssContent))
}

// ChangelogMarkdownHandler handles raw markdown requests
func ChangelogMarkdownHandler(w http.ResponseWriter, r *http.Request, tmplData models.TemplateData) {
	// Load changelog markdown file
	changelogPath := filepath.Join("CHANGELOG.md")
	if _, err := os.Stat(changelogPath); err != nil {
		changelogPath = filepath.Join("..", "CHANGELOG.md")
	}
	
	content, err := os.ReadFile(changelogPath)
	if err != nil {
		http.Error(w, "Changelog not found", http.StatusNotFound)
		return
	}
	
	// Check if HTML conversion is requested
	if r.URL.Query().Get("format") == "html" {
		// Convert markdown to HTML
		md := goldmark.New(
			goldmark.WithExtensions(extension.GFM),
			goldmark.WithParserOptions(
				parser.WithAutoHeadingID(),
			),
			goldmark.WithRendererOptions(
				html.WithHardWraps(),
				html.WithXHTML(),
			),
		)
		
		var buf strings.Builder
		if err := md.Convert(content, &buf); err != nil {
			http.Error(w, "Error converting markdown", http.StatusInternalServerError)
			return
		}
		
		w.Header().Set("Content-Type", "text/html; charset=utf-8")
		w.Write([]byte(buf.String()))
	} else {
		// Return raw markdown
		w.Header().Set("Content-Type", "text/markdown; charset=utf-8")
		w.Write(content)
	}
}

// generateRSSFeed generates RSS feed content for changelog
func generateRSSFeed(changelogData *models.ChangelogData, tmplData models.TemplateData) string {
	var rss strings.Builder
	
	rss.WriteString(`<?xml version="1.0" encoding="UTF-8"?>`)
	rss.WriteString(`<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">`)
	rss.WriteString(`<channel>`)
	rss.WriteString(`<title>` + tmplData.Site.Name + ` - Changelog</title>`)
	rss.WriteString(`<description>` + tmplData.Site.Description + `</description>`)
	rss.WriteString(`<link>https://lrr.sh/changelog</link>`)
	rss.WriteString(`<atom:link href="https://lrr.sh/changelog.rss" rel="self" type="application/rss+xml"/>`)
	rss.WriteString(`<language>en-us</language>`)
	rss.WriteString(`<lastBuildDate>` + time.Now().Format(time.RFC1123Z) + `</lastBuildDate>`)
	
	// Add entries (limit to 20 most recent)
	maxEntries := 20
	if len(changelogData.Entries) < maxEntries {
		maxEntries = len(changelogData.Entries)
	}
	
	for i := 0; i < maxEntries; i++ {
		entry := changelogData.Entries[i]
		
		rss.WriteString(`<item>`)
		rss.WriteString(`<title>Version ` + entry.Version + `</title>`)
		rss.WriteString(`<link>https://lrr.sh/changelog#` + entry.Version + `</link>`)
		rss.WriteString(`<guid>https://lrr.sh/changelog#` + entry.Version + `</guid>`)
		
		if !entry.Date.IsZero() {
			rss.WriteString(`<pubDate>` + entry.Date.Format(time.RFC1123Z) + `</pubDate>`)
		}
		
		// Generate description from changes
		var description strings.Builder
		for _, change := range entry.Changes {
			description.WriteString(`<h3>` + change.Type + `</h3>`)
			description.WriteString(`<ul>`)
			for _, item := range change.Items {
				description.WriteString(`<li>` + item + `</li>`)
			}
			description.WriteString(`</ul>`)
		}
		
		rss.WriteString(`<description><![CDATA[` + description.String() + `]]></description>`)
		rss.WriteString(`</item>`)
	}
	
	rss.WriteString(`</channel>`)
	rss.WriteString(`</rss>`)
	
	return rss.String()
}
