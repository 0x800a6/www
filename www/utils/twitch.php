<?php
class TwitchUtil {
    private $clientId;
    private $clientSecret;
    private $tokenFile;
    private $cacheDir;
    private $cacheDuration = 180; // 3 minutes in seconds

    public function __construct($clientId, $clientSecret, $tokenFile = null) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        
        // Use a writable directory for token storage
        if ($tokenFile === null) {
            // Try to use /tmp first, then fall back to current directory
            $writableDir = is_writable('/tmp') ? '/tmp' : sys_get_temp_dir();
            $this->tokenFile = $writableDir . '/twitch_token_' . md5($clientId) . '.json';
        } else {
            $this->tokenFile = $tokenFile;
        }
        
        // Set up cache directory
        $this->cacheDir = is_writable('/tmp') ? '/tmp' : sys_get_temp_dir();
    }

    private function getAccessToken() {
        // If cached token exists and is valid, reuse it
        if (file_exists($this->tokenFile)) {
            $data = json_decode(file_get_contents($this->tokenFile), true);

            if ($data && isset($data['access_token'], $data['expires_at'])) {
                if (time() < $data['expires_at']) {
                    return $data['access_token']; // Still valid
                }
            }
        }

        // Otherwise, request a new token
        $url = "https://id.twitch.tv/oauth2/token";
        $postData = [
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "grant_type" => "client_credentials"
        ];

        $options = [
            "http" => [
                "header"  => "Content-Type: application/x-www-form-urlencoded\r\n",
                "method"  => "POST",
                "content" => http_build_query($postData)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            throw new Exception("Failed to fetch access token");
        }

        $json = json_decode($result, true);
        if (!isset($json["access_token"])) {
            throw new Exception("Invalid response from Twitch: " . $result);
        }

        // Calculate expiry time
        $expiresIn = $json["expires_in"] ?? 3600; // default 1 hour
        $json["expires_at"] = time() + $expiresIn - 60; // subtract 60s buffer

        // Cache token to file
        $result = file_put_contents($this->tokenFile, json_encode($json));
        if ($result === false) {
            // If we can't write to file, continue without caching
            // This is not critical - the token will still work
        }

        return $json["access_token"];
    }

    private function getCacheFile($username) {
        return $this->cacheDir . '/twitch_live_' . md5($username) . '.json';
    }

    private function getCachedLiveStatus($username) {
        $cacheFile = $this->getCacheFile($username);
        
        if (!file_exists($cacheFile)) {
            return null;
        }
        
        $data = json_decode(file_get_contents($cacheFile), true);
        
        if (!$data || !isset($data['timestamp'], $data['is_live'], $data['stream_info'])) {
            return null;
        }
        
        // Check if cache is still valid (within cache duration)
        if (time() - $data['timestamp'] > $this->cacheDuration) {
            // Cache expired, remove the file
            unlink($cacheFile);
            return null;
        }
        
        return $data;
    }

    private function setCachedLiveStatus($username, $isLive, $streamInfo = null) {
        $cacheFile = $this->getCacheFile($username);
        
        $data = [
            'timestamp' => time(),
            'is_live' => $isLive,
            'stream_info' => $streamInfo
        ];
        
        file_put_contents($cacheFile, json_encode($data));
    }

    public function isLive($username) {
        // Check cache first
        $cached = $this->getCachedLiveStatus($username);
        if ($cached !== null) {
            return $cached['is_live'];
        }

        // Cache miss or expired, fetch from API
        $accessToken = $this->getAccessToken();
        $url = "https://api.twitch.tv/helix/streams?user_login=" . urlencode($username);

        $options = [
            "http" => [
                "header" => "Client-ID: {$this->clientId}\r\n" .
                            "Authorization: Bearer {$accessToken}\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            throw new Exception("Failed to fetch stream info");
        }

        $json = json_decode($result, true);
        $isLive = !empty($json["data"]);

        // Cache the result
        $streamInfo = $isLive ? ($json["data"][0] ?? null) : null;
        $this->setCachedLiveStatus($username, $isLive, $streamInfo);

        return $isLive;
    }

    public function getStreamInfo($username) {
        // Check cache first
        $cached = $this->getCachedLiveStatus($username);
        if ($cached !== null) {
            return $cached['stream_info'];
        }

        // Cache miss or expired, fetch from API
        $accessToken = $this->getAccessToken();
        $url = "https://api.twitch.tv/helix/streams?user_login=" . urlencode($username);

        $options = [
            "http" => [
                "header" => "Client-ID: {$this->clientId}\r\n" .
                            "Authorization: Bearer {$accessToken}\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            throw new Exception("Failed to fetch stream info");
        }

        $json = json_decode($result, true);
        $streamInfo = $json["data"][0] ?? null;
        $isLive = !empty($json["data"]);

        // Cache the result
        $this->setCachedLiveStatus($username, $isLive, $streamInfo);

        return $streamInfo;
    }
}