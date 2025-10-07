package handlers

import (
	"net/http"
)

func VTubersTVProjectsHandler(w http.ResponseWriter, r *http.Request) {
	http.Redirect(w, r, "https://gist.github.com/0x800a6/8348e83de162672e81850b3fe3784d0f", http.StatusFound)
}