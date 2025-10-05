package middleware

import "net/http"

func ExtraMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("X-Content-Type-Options", "nosniff")
		w.Header().Set("X-Frame-Options", "DENY")
		w.Header().Set("X-XSS-Protection", "1; mode=block")
		w.Header().Set("Referrer-Policy", "strict-origin-when-cross-origin")
		w.Header().Set("Permissions-Policy", "geolocation=(), microphone=(), camera=(), payment=(), usb=(), vr=(), accelerometer=(), ambient-light-sensor=(), autoplay=(), battery=(), display-capture=(), document-domain=(), encrypted-media=(), fullscreen=(), gyroscope=(), magnetometer=(), midi=(), picture-in-picture=(), publickey-credentials-get=(), screen-wake-lock=(), sync-xhr=(), web-share=(), xr-spatial-tracking=()")
		w.Header().Set("Strict-Transport-Security", "max-age=63072000; includeSubDomains; preload")
		w.Header().Set("Cross-Origin-Opener-Policy", "same-origin")
		w.Header().Set("Cross-Origin-Resource-Policy", "same-origin")
		w.Header().Set("Cross-Origin-Embedder-Policy", "require-corp")
		w.Header().Set("X-Permitted-Cross-Domain-Policies", "none")
		w.Header().Set("X-Download-Options", "noopen")
		w.Header().Set("X-DNS-Prefetch-Control", "off")
		w.Header().Set("Server", "Lexi's Website (https://github.com/0x800a6/www)")

		w.Header().Set("Cache-Control", "public, max-age=0, s-maxage=3600, must-revalidate")
		w.Header().Set("Pragma", "")
		w.Header().Set("Expires", "")

		w.Header().Set("CF-Cache-Status", "EXPIRED")

		next.ServeHTTP(w, r)
	})
}