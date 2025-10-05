package handlers

import (
	"html/template"
	"net/http"

	"github.com/0x800a6/www/internal/middleware"
	"github.com/0x800a6/www/internal/models"
	"github.com/0x800a6/www/internal/utils"
)

func ResumeHandler(w http.ResponseWriter, r *http.Request, tmplData models.TemplateData) {
	data := tmplData
	data.Page = models.PageData{
		Title:   "Resume",
		Content: "resume",
	}

	allTmpl, err := template.ParseGlob(utils.GetTemplatePath("templates/*.html"))
	if err != nil {
		http.Error(w, "Template parsing error", http.StatusInternalServerError)
		return
	}

	allTmpl, err = allTmpl.ParseFiles(utils.GetTemplatePath("html/resume.html"))
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
