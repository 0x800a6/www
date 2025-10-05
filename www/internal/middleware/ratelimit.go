package middleware

import (
	"crypto/rand"
	"encoding/hex"
	"fmt"
	"net/http"
	"strings"
	"time"

	"github.com/0x800a6/www/internal/models"
)

func RateLimitMiddleware(limiter *models.RateLimiter) func(http.Handler) http.Handler {
	return func(next http.Handler) http.Handler {
		return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
			if shouldSkipRateLimit(r.URL.Path) {
				next.ServeHTTP(w, r)
				return
			}

			userID := getUserIDFromCookie(r, w)

			if !limiter.Allow(userID) {
				w.Header().Set("X-RateLimit-Limit", fmt.Sprintf("%d", limiter.GetConfig().BurstSize))
				w.Header().Set("X-RateLimit-Remaining", "0")
				w.Header().Set("X-RateLimit-Reset", fmt.Sprintf("%d", time.Now().Add(limiter.GetConfig().WindowSize).Unix()))
				w.Header().Set("Retry-After", fmt.Sprintf("%.0f", limiter.GetConfig().WindowSize.Seconds()))

				http.Redirect(w, r, "/ratelimit", http.StatusTooManyRequests)
				return
			}

			bucket := limiter.GetBucket(userID)
			if bucket != nil {
				remaining := bucket.GetTokens()
				w.Header().Set("X-RateLimit-Limit", fmt.Sprintf("%d", limiter.GetConfig().BurstSize))
				w.Header().Set("X-RateLimit-Remaining", fmt.Sprintf("%d", remaining))
				w.Header().Set("X-RateLimit-Reset", fmt.Sprintf("%d", time.Now().Add(limiter.GetConfig().WindowSize).Unix()))
			}

			next.ServeHTTP(w, r)
		})
	}
}

func shouldSkipRateLimit(path string) bool {
	if strings.HasPrefix(path, "/static/") {
		return true
	}

	if path == "/health" || path == "/metrics" {
		return true
	}

	if path == "/ratelimit" {
		return true
	}

	if path == "/favicon.ico" || path == "/robots.txt" {
		return true
	}

	return false
}

func getUserIDFromCookie(r *http.Request, w http.ResponseWriter) string {
	cookie, err := r.Cookie("user_id")
	if err == nil && cookie.Value != "" {
		return cookie.Value
	}

	userID := generateUserID()

	http.SetCookie(w, &http.Cookie{
		Name:     "user_id",
		Value:    userID,
		Path:     "/",
		MaxAge:   86400 * 30,
		HttpOnly: true,
		Secure:   false,
		SameSite: http.SameSiteLaxMode,
	})

	return userID
}

func generateUserID() string {
	bytes := make([]byte, 8)
	rand.Read(bytes)
	return hex.EncodeToString(bytes)
}
