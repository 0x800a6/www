package utils

import (
	"os"
	"path/filepath"
)

func GetTemplatePath(path string) string {
	if _, err := os.Stat("templates"); err == nil {
		return path
	}
	return filepath.Join("www", path)
}

func GetPageTitle(path string) string {
	switch path {
	case "/":
		return "Home"
	case "/sitemap":
		return "Sitemap"
	case "/about":
		return "About"
	case "/posts":
		return "Blog"
	case "/resume":
		return "Resume"
	case "/projects":
		return "Projects"
	case "/changelog":
		return "Changelog"
	default:
		return "Page"
	}
}

func Min(a, b int) int {
	if a < b {
		return a
	}
	return b
}
