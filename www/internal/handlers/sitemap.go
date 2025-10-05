package handlers

import (
	"encoding/xml"
	"fmt"
	"html/template"
	"net/http"
	"time"

	"github.com/0x800a6/www/internal/middleware"
	"github.com/0x800a6/www/internal/models"
	"github.com/0x800a6/www/internal/utils"
)

type SitemapHandler struct {
	BaseURL string
}

func NewSitemapHandler(baseURL string) *SitemapHandler {
	return &SitemapHandler{
		BaseURL: baseURL,
	}
}

func (sh *SitemapHandler) generateSitemap() *models.Sitemap {
	now := time.Now()

	pages := []models.SitePage{
		{
			Path:       "/",
			Title:      "Home",
			LastMod:    now,
			ChangeFreq: "weekly",
			Priority:   "1.0",
		},
		{
			Path:       "/sitemap",
			Title:      "Sitemap",
			LastMod:    now,
			ChangeFreq: "monthly",
			Priority:   "0.5",
		},
		{
			Path:       "/resume",
			Title:      "Resume",
			LastMod:    now,
			ChangeFreq: "monthly",
			Priority:   "0.7",
		},
		{
			Path:       "/projects",
			Title:      "Projects",
			LastMod:    now,
			ChangeFreq: "weekly",
			Priority:   "0.8",
		},
		{
			Path:       "/changelog",
			Title:      "Changelog",
			LastMod:    now,
			ChangeFreq: "weekly",
			Priority:   "0.7",
		},
	}

	urls := make([]models.SitemapURL, len(pages))
	for i, page := range pages {
		urls[i] = models.SitemapURL{
			Loc:        sh.BaseURL + page.Path,
			LastMod:    page.LastMod.Format("2006-01-02"),
			ChangeFreq: page.ChangeFreq,
			Priority:   page.Priority,
		}
	}

	return &models.Sitemap{
		Xmlns: "http://www.sitemaps.org/schemas/sitemap/0.9",
		URLs:  urls,
	}
}

func (sh *SitemapHandler) ServeXML(w http.ResponseWriter, r *http.Request) {
	sitemap := sh.generateSitemap()

	w.Header().Set("Content-Type", "application/xml")
	w.WriteHeader(http.StatusOK)

	fmt.Fprint(w, `<?xml version="1.0" encoding="UTF-8"?>`+"\n")
	encoder := xml.NewEncoder(w)
	encoder.Indent("", "  ")
	if err := encoder.Encode(sitemap); err != nil {
		http.Error(w, "Error generating sitemap", http.StatusInternalServerError)
		return
	}
}

func (sh *SitemapHandler) ServePage(w http.ResponseWriter, r *http.Request, tmplData models.TemplateData) {
	sitemap := sh.generateSitemap()

	var pages []models.SitePage
	for _, url := range sitemap.URLs {
		path := url.Loc
		if len(path) > len(sh.BaseURL) {
			path = path[len(sh.BaseURL):]
		}
		if path == "" {
			path = "/"
		}

		lastMod, _ := time.Parse("2006-01-02", url.LastMod)

		pages = append(pages, models.SitePage{
			Path:       path,
			Title:      utils.GetPageTitle(path),
			LastMod:    lastMod,
			ChangeFreq: url.ChangeFreq,
			Priority:   url.Priority,
		})
	}

	data := tmplData
	data.Page = models.PageData{
		Title:   "Sitemap",
		Content: "sitemap",
		Data:    pages,
	}

	allTmpl, err := template.ParseGlob(utils.GetTemplatePath("templates/*.html"))
	if err != nil {
		http.Error(w, "Template parsing error", http.StatusInternalServerError)
		return
	}

	allTmpl, err = allTmpl.ParseFiles(utils.GetTemplatePath("html/sitemap.html"))
	if err != nil {
		http.Error(w, "Page not found", http.StatusNotFound)
		return
	}

	minifyWriter := middleware.NewMinifyResponseWriter(w)

	w.Header().Set("Content-Type", "text/html; charset=utf-8")
	err = allTmpl.ExecuteTemplate(minifyWriter, "base.html", data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	err = minifyWriter.Flush()
	if err != nil {
	}
}
