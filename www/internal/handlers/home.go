package handlers

import (
	"html/template"
	"net/http"
	"path/filepath"

	"github.com/0x800a6/www/internal/middleware"
	"github.com/0x800a6/www/internal/models"
	"github.com/0x800a6/www/internal/utils"
)

func HomeHandler(w http.ResponseWriter, r *http.Request, tmplData models.TemplateData) {
	data := tmplData
	data.Page = models.PageData{
		Title: "Home",
	}

	htmlFile := filepath.Join("html", "home.html")
	allTmpl, err := template.ParseGlob(utils.GetTemplatePath("templates/*.html"))
	if err != nil {
		http.Error(w, "Template parsing error", http.StatusInternalServerError)
		return
	}

	allTmpl, err = allTmpl.ParseFiles(utils.GetTemplatePath(htmlFile))
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
