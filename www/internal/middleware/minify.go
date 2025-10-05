package middleware

import (
	"bytes"
	"net/http"

	"github.com/tdewolff/minify/v2"
	"github.com/tdewolff/minify/v2/html"
)

type MinifyResponseWriter struct {
	http.ResponseWriter
	buffer *bytes.Buffer
	minify *minify.M
}

func NewMinifyResponseWriter(w http.ResponseWriter) *MinifyResponseWriter {
	m := minify.New()
	m.AddFunc("text/html", html.Minify)

	return &MinifyResponseWriter{
		ResponseWriter: w,
		buffer:         &bytes.Buffer{},
		minify:         m,
	}
}

func (mrw *MinifyResponseWriter) Write(data []byte) (int, error) {
	return mrw.buffer.Write(data)
}

func (mrw *MinifyResponseWriter) Flush() error {
	minified, err := mrw.minify.Bytes("text/html", mrw.buffer.Bytes())
	if err != nil {
		_, writeErr := mrw.ResponseWriter.Write(mrw.buffer.Bytes())
		return writeErr
	}

	_, err = mrw.ResponseWriter.Write(minified)
	return err
}
