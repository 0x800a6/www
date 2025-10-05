package models

import (
	"encoding/xml"
	"time"
)

type PageData struct {
	Title   string
	Content string
	Data    interface{}
}

type TemplateData struct {
	Page PageData
	Site struct {
		Name        string
		Description string
		Author      string
		Year        int
	}
}

type SitemapURL struct {
	Loc        string `xml:"loc"`
	LastMod    string `xml:"lastmod"`
	ChangeFreq string `xml:"changefreq"`
	Priority   string `xml:"priority"`
}

type Sitemap struct {
	XMLName xml.Name     `xml:"urlset"`
	Xmlns   string       `xml:"xmlns,attr"`
	URLs    []SitemapURL `xml:"url"`
}

type SitePage struct {
	Path       string
	Title      string
	LastMod    time.Time
	ChangeFreq string
	Priority   string
}

type RateLimiterConfig struct {
	RequestsPerMinute int
	BurstSize         int
	WindowSize        time.Duration
	CleanupInterval   time.Duration
}
