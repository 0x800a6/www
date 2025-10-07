package main

import (
	"log"
	"net/http"
	"time"

	"github.com/0x800a6/www/internal/handlers"
	"github.com/0x800a6/www/internal/middleware"
	"github.com/0x800a6/www/internal/models"
	"github.com/0x800a6/www/internal/utils"
)

func main() {
	rateLimiterConfig := models.RateLimiterConfig{
		RequestsPerMinute: 60,
		BurstSize:         10,
		WindowSize:        15 * time.Second,
		CleanupInterval:   5 * time.Minute,
	}
	rateLimiter := models.NewRateLimiter(rateLimiterConfig)
	defer rateLimiter.Stop()

	tmplData := models.TemplateData{
		Site: struct {
			Name        string
			Description string
			Author      string
			Year        int
		}{
			Name:        "Lexi's Website",
			Description: "Software & Web Developer, Cosplayer, Anime Enthusiast, and Privacy Advocate. Building things on Arch Linux with C, Rust, TypeScript, and more.",
			Author:      "Lexi Rose Rogers",
			Year:        time.Now().Year(),
		},
	}

	sitemapHandler := handlers.NewSitemapHandler("https://lrr.sh")

	mux := http.NewServeMux()

	mux.Handle("/static/", http.StripPrefix("/static/", http.FileServer(http.Dir(utils.GetTemplatePath("static/")))))

	mux.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		handlers.HomeHandler(w, r, tmplData)
	})

	mux.HandleFunc("/sitemap.xml", sitemapHandler.ServeXML)
	mux.HandleFunc("/sitemap", func(w http.ResponseWriter, r *http.Request) {
		sitemapHandler.ServePage(w, r, tmplData)
	})

	mux.HandleFunc("/ratelimit", func(w http.ResponseWriter, r *http.Request) {
		handlers.RateLimitHandler(w, r, tmplData)
	})

	mux.HandleFunc("/resume", func(w http.ResponseWriter, r *http.Request) {
		handlers.ResumeHandler(w, r, tmplData)
	})

	mux.HandleFunc("/projects", func(w http.ResponseWriter, r *http.Request) {
		handlers.ProjectsHandler(w, r, tmplData)
	})

	mux.HandleFunc("/changelog", func(w http.ResponseWriter, r *http.Request) {
		handlers.ChangelogHandler(w, r, tmplData)
	})

	mux.HandleFunc("/changelog.json", func(w http.ResponseWriter, r *http.Request) {
		handlers.ChangelogAPIHandler(w, r, tmplData)
	})

	mux.HandleFunc("/changelog.rss", func(w http.ResponseWriter, r *http.Request) {
		handlers.ChangelogRSSHandler(w, r, tmplData)
	})

	mux.HandleFunc("/changelog.md", func(w http.ResponseWriter, r *http.Request) {
		handlers.ChangelogMarkdownHandler(w, r, tmplData)
	})

	mux.HandleFunc("/vtuberstv", handlers.VTubersTVProjectsHandler)

	mux.HandleFunc("/health", handlers.HealthHandler)
	handler := middleware.RateLimitMiddleware(rateLimiter)(mux)
	handler = middleware.ExtraMiddleware(handler)

	log.Println("Server starting on :8080")
	log.Fatal(http.ListenAndServe(":8080", handler))
}
