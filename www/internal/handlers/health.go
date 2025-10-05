package handlers

import (
	"encoding/json"
	"net/http"
)

func HealthHandler(w http.ResponseWriter, r *http.Request) {
	w.WriteHeader(http.StatusOK)
	ToJSON(w, map[string]string{"status": "healthy", "service": "go-website"})
}

func ToJSON(w http.ResponseWriter, data interface{}) error {
	w.Header().Set("Content-Type", "application/json")
	enc := json.NewEncoder(w)
	return enc.Encode(data)
}
