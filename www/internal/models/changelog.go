package models

import (
	"regexp"
	"strings"
	"time"
)

// ChangelogEntry represents a single changelog entry
type ChangelogEntry struct {
	Version     string    `json:"version"`
	Date        time.Time `json:"date"`
	IsUnreleased bool     `json:"is_unreleased"`
	Changes     []Change  `json:"changes"`
	RawContent  string    `json:"raw_content"`
}

// Change represents a single change within a version
type Change struct {
	Type        string   `json:"type"`
	Description string   `json:"description"`
	Items       []string `json:"items"`
	RawContent  string   `json:"raw_content"`
}

// ChangelogData represents the parsed changelog data
type ChangelogData struct {
	Entries []ChangelogEntry `json:"entries"`
	Total   int              `json:"total"`
}

// ChangelogFilter represents filtering options
type ChangelogFilter struct {
	Version     string    `json:"version"`
	ChangeType  string    `json:"change_type"`
	DateFrom    time.Time `json:"date_from"`
	DateTo      time.Time `json:"date_to"`
	Search      string    `json:"search"`
	ShowUnreleased bool   `json:"show_unreleased"`
}

// ChangelogStats represents statistics about the changelog
type ChangelogStats struct {
	TotalVersions    int                    `json:"total_versions"`
	TotalChanges     int                    `json:"total_changes"`
	ChangeTypeCounts map[string]int         `json:"change_type_counts"`
	VersionCounts    map[string]int         `json:"version_counts"`
	LatestVersion    string                 `json:"latest_version"`
	OldestVersion    string                 `json:"oldest_version"`
	DateRange        struct {
		From time.Time `json:"from"`
		To   time.Time `json:"to"`
	} `json:"date_range"`
}

// ParseChangelog parses markdown changelog content into structured data
func ParseChangelog(content string) (*ChangelogData, error) {
	entries := []ChangelogEntry{}
	
	// Split content into sections by version headers
	versionRegex := regexp.MustCompile(`(?m)^## \[([^\]]+)\](?:\s*-\s*([^\n]+))?$`)
	changeTypeRegex := regexp.MustCompile(`(?m)^### ([A-Za-z]+)$`)
	
	lines := strings.Split(content, "\n")
	currentEntry := ChangelogEntry{}
	currentChange := Change{}
	inChangeSection := false
	
	for _, line := range lines {
		line = strings.TrimSpace(line)
		
		// Check for version header
		if matches := versionRegex.FindStringSubmatch(line); matches != nil {
			// Save previous entry if it exists
			if currentEntry.Version != "" {
				if len(currentChange.Items) > 0 {
					currentEntry.Changes = append(currentEntry.Changes, currentChange)
				}
				entries = append(entries, currentEntry)
			}
			
			// Start new entry
			version := matches[1]
			dateStr := matches[2]
			
			currentEntry = ChangelogEntry{
				Version:      version,
				IsUnreleased: version == "Unreleased",
				Changes:      []Change{},
			}
			
			// Parse date if provided
			if dateStr != "" {
				if date, err := time.Parse("2006-01-02", dateStr); err == nil {
					currentEntry.Date = date
				}
			}
			
			// Collect raw content for this version
			currentEntry.RawContent = line
			inChangeSection = false
			currentChange = Change{}
			continue
		}
		
		// Check for change type header
		if matches := changeTypeRegex.FindStringSubmatch(line); matches != nil {
			// Save previous change if it exists
			if inChangeSection && len(currentChange.Items) > 0 {
				currentEntry.Changes = append(currentEntry.Changes, currentChange)
			}
			
			// Start new change
			changeType := matches[1]
			currentChange = Change{
				Type:       changeType,
				Items:      []string{},
				RawContent: line,
			}
			inChangeSection = true
			continue
		}
		
		// Check for list items
		if inChangeSection && strings.HasPrefix(line, "- ") {
			item := strings.TrimPrefix(line, "- ")
			// Remove markdown formatting
			item = regexp.MustCompile(`\*\*([^*]+)\*\*`).ReplaceAllString(item, "$1")
			item = regexp.MustCompile(`\*([^*]+)\*`).ReplaceAllString(item, "$1")
			item = regexp.MustCompile("`([^`]+)`").ReplaceAllString(item, "$1")
			
			currentChange.Items = append(currentChange.Items, item)
			currentChange.RawContent += "\n" + line
		}
		
		// Add to raw content
		if currentEntry.Version != "" {
			currentEntry.RawContent += "\n" + line
		}
	}
	
	// Save the last entry
	if currentEntry.Version != "" {
		if len(currentChange.Items) > 0 {
			currentEntry.Changes = append(currentEntry.Changes, currentChange)
		}
		entries = append(entries, currentEntry)
	}
	
	return &ChangelogData{
		Entries: entries,
		Total:   len(entries),
	}, nil
}

// FilterChangelog applies filters to changelog data
func (cd *ChangelogData) FilterChangelog(filter ChangelogFilter) *ChangelogData {
	filtered := []ChangelogEntry{}
	
	for _, entry := range cd.Entries {
		// Skip unreleased if not requested
		if entry.IsUnreleased && !filter.ShowUnreleased {
			continue
		}
		
		// Filter by version
		if filter.Version != "" && !strings.Contains(strings.ToLower(entry.Version), strings.ToLower(filter.Version)) {
			continue
		}
		
		// Filter by date range
		if !filter.DateFrom.IsZero() && entry.Date.Before(filter.DateFrom) {
			continue
		}
		if !filter.DateTo.IsZero() && entry.Date.After(filter.DateTo) {
			continue
		}
		
		// Filter by change type and search
		filteredChanges := []Change{}
		for _, change := range entry.Changes {
			// Filter by change type
			if filter.ChangeType != "" && !strings.EqualFold(change.Type, filter.ChangeType) {
				continue
			}
			
			// Filter by search term
			if filter.Search != "" {
				searchLower := strings.ToLower(filter.Search)
				matches := false
				
				// Search in change type
				if strings.Contains(strings.ToLower(change.Type), searchLower) {
					matches = true
				}
				
				// Search in items
				for _, item := range change.Items {
					if strings.Contains(strings.ToLower(item), searchLower) {
						matches = true
						break
					}
				}
				
				if !matches {
					continue
				}
			}
			
			filteredChanges = append(filteredChanges, change)
		}
		
		// Only include entry if it has matching changes or no filters applied
		if len(filteredChanges) > 0 || (filter.ChangeType == "" && filter.Search == "") {
			entry.Changes = filteredChanges
			filtered = append(filtered, entry)
		}
	}
	
	return &ChangelogData{
		Entries: filtered,
		Total:   len(filtered),
	}
}

// GetStats returns statistics about the changelog
func (cd *ChangelogData) GetStats() ChangelogStats {
	stats := ChangelogStats{
		TotalVersions:    len(cd.Entries),
		TotalChanges:     0,
		ChangeTypeCounts: make(map[string]int),
		VersionCounts:    make(map[string]int),
	}
	
	if len(cd.Entries) == 0 {
		return stats
	}
	
	stats.LatestVersion = cd.Entries[0].Version
	stats.OldestVersion = cd.Entries[len(cd.Entries)-1].Version
	
	// Calculate date range
	hasDate := false
	for _, entry := range cd.Entries {
		if !entry.Date.IsZero() {
			if !hasDate {
				stats.DateRange.From = entry.Date
				stats.DateRange.To = entry.Date
				hasDate = true
			} else {
				if entry.Date.Before(stats.DateRange.From) {
					stats.DateRange.From = entry.Date
				}
				if entry.Date.After(stats.DateRange.To) {
					stats.DateRange.To = entry.Date
				}
			}
		}
		
		stats.VersionCounts[entry.Version] = len(entry.Changes)
		
		for _, change := range entry.Changes {
			stats.TotalChanges++
			stats.ChangeTypeCounts[change.Type]++
		}
	}
	
	return stats
}

// GetVersions returns a list of all versions
func (cd *ChangelogData) GetVersions() []string {
	versions := make([]string, len(cd.Entries))
	for i, entry := range cd.Entries {
		versions[i] = entry.Version
	}
	return versions
}

// GetChangeTypes returns a list of all change types
func (cd *ChangelogData) GetChangeTypes() []string {
	changeTypes := make(map[string]bool)
	for _, entry := range cd.Entries {
		for _, change := range entry.Changes {
			changeTypes[change.Type] = true
		}
	}
	
	types := make([]string, 0, len(changeTypes))
	for changeType := range changeTypes {
		types = append(types, changeType)
	}
	return types
}
