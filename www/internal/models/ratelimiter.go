package models

import (
	"sync"
	"time"
)

type TokenBucket struct {
	capacity    int
	tokens      int
	windowStart time.Time
	windowSize  time.Duration
	mutex       sync.Mutex
}

func NewTokenBucket(capacity int, windowSize time.Duration) *TokenBucket {
	return &TokenBucket{
		capacity:    capacity,
		tokens:      capacity,
		windowStart: time.Now(),
		windowSize:  windowSize,
	}
}

func (tb *TokenBucket) Allow() bool {
	tb.mutex.Lock()
	defer tb.mutex.Unlock()

	now := time.Now()

	if now.Sub(tb.windowStart) >= tb.windowSize {
		tb.windowStart = now
		tb.tokens = tb.capacity
	}

	if tb.tokens > 0 {
		tb.tokens--
		return true
	}
	return false
}

func (tb *TokenBucket) GetTokens() int {
	tb.mutex.Lock()
	defer tb.mutex.Unlock()
	return tb.tokens
}

type RateLimiter struct {
	buckets       map[string]*TokenBucket
	config        RateLimiterConfig
	mutex         sync.RWMutex
	cleanupTicker *time.Ticker
	stopCleanup   chan bool
}

func NewRateLimiter(config RateLimiterConfig) *RateLimiter {
	rl := &RateLimiter{
		buckets:     make(map[string]*TokenBucket),
		config:      config,
		stopCleanup: make(chan bool),
	}

	rl.cleanupTicker = time.NewTicker(config.CleanupInterval)
	go rl.cleanup()

	return rl
}

func (rl *RateLimiter) Allow(userID string) bool {
	rl.mutex.Lock()
	bucket, exists := rl.buckets[userID]
	if !exists {
		bucket = NewTokenBucket(rl.config.BurstSize, rl.config.WindowSize)
		rl.buckets[userID] = bucket
	}
	rl.mutex.Unlock()

	return bucket.Allow()
}

func (rl *RateLimiter) GetBucket(userID string) *TokenBucket {
	rl.mutex.RLock()
	defer rl.mutex.RUnlock()
	return rl.buckets[userID]
}

func (rl *RateLimiter) cleanup() {
	for {
		select {
		case <-rl.cleanupTicker.C:
			rl.mutex.Lock()
			now := time.Now()
			for userID, bucket := range rl.buckets {
				if now.Sub(bucket.windowStart) > time.Hour {
					delete(rl.buckets, userID)
				}
			}
			rl.mutex.Unlock()
		case <-rl.stopCleanup:
			rl.cleanupTicker.Stop()
			return
		}
	}
}

func (rl *RateLimiter) Stop() {
	rl.stopCleanup <- true
}

func (rl *RateLimiter) GetConfig() RateLimiterConfig {
	return rl.config
}
