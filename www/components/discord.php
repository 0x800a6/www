<?php
function get_discord_server_data($server_id) {
  // Use system temp directory for cache files
  $cache_file = sys_get_temp_dir() . "/discord_cache_{$server_id}.json";
  $cache_duration = 300; // 5 minutes
  $use_cache = false;
  
  // Check if temp directory is writable
  if (is_writable(sys_get_temp_dir())) {
    $use_cache = true;
    
    // Check if cache exists and is still valid
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_duration) {
      $cached_data = file_get_contents($cache_file);
      $data = json_decode($cached_data, true);
      if ($data) {
        return $data;
      }
    }
  }
  
  // Discord widget API endpoint
  $api_url = "https://discord.com/api/guilds/{$server_id}/widget.json";
  
  // Initialize cURL
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $api_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Website Bot)');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  
  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $curl_error = curl_error($ch);
  curl_close($ch);
  
  // Handle errors
  if ($curl_error) {
    error_log("Discord API cURL error: " . $curl_error);
    return null;
  }
  
  if ($http_code !== 200) {
    error_log("Discord API HTTP error: " . $http_code);
    return null;
  }
  
  if (!$response) {
    error_log("Discord API: Empty response");
    return null;
  }
  
  $data = json_decode($response, true);
  if (!$data) {
    error_log("Discord API: Invalid JSON response");
    return null;
  }
  
  // Cache the successful response (only if cache is enabled)
  if ($use_cache) {
    $cache_result = @file_put_contents($cache_file, $response);
    if ($cache_result === false) {
      error_log("Discord API: Failed to write cache file to " . $cache_file);
    }
  }
  
  return $data;
}

// Get server data
$server_id = '1416241212385394811';
$discord_data = get_discord_server_data($server_id);

// Default values if API fails
$server_name = 'VTubers.TV Community';
$member_count = 'Growing Community';
$server_icon = null;
$online_count = 'Active';
$invite_url = 'https://discord.gg/Gzay9bFR4X'; // Fallback invite

if ($discord_data) {
  $server_name = htmlspecialchars($discord_data['name'] ?? $server_name);
  
  // Handle member count with better formatting
  if (isset($discord_data['presence_count'])) {
    $presence_count = $discord_data['presence_count'];
    $member_count = number_format($presence_count) . ' Online';
    $online_count = number_format($presence_count) . ' Online';
  }
  
  $server_icon = $discord_data['icon'] ?? null;
  
  // Get invite URL if available
  if (isset($discord_data['instant_invite']) && !empty($discord_data['instant_invite'])) {
    $invite_url = $discord_data['instant_invite'];
  }
}
?>

<div class="discord-container">
  <div class="discord-card">
    <div class="discord-header">
      <div class="discord-icon">
          <img src="/static/images/vtubers-tv-logo.png" 
               alt="Server Icon" 
               style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
      </div>
      <div class="discord-title">
        <h3><?php echo $server_name; ?></h3>
        <p class="discord-subtitle"><?php echo $member_count; ?></p>
      </div>
    </div>
    <div class="discord-content">
      <p>Join our vibrant Discord community for VTubers, developers, and creators! Get streaming support, share your avatar creations, discuss revenue strategies, participate in community events, and collaborate on open-source projects. A safe space where VTubers are understood and supported.</p>
      <div class="discord-features">
        <div class="feature">
          <i class="bi bi-people"></i>
          <span><?php echo $online_count; ?></span>
        </div>
        <div class="feature">
          <i class="bi bi-code-slash"></i>
          <span>Dev Discussions</span>
        </div>
        <div class="feature">
          <i class="bi bi-heart"></i>
          <span>VTuber Content</span>
        </div>
        <div class="feature">
          <i class="bi bi-shield-check"></i>
          <span>Safe Community</span>
        </div>
        <div class="feature">
          <i class="bi bi-github"></i>
          <span>Open Source</span>
        </div>
        <div class="feature">
          <i class="bi bi-patch-question"></i>
          <span>Help & Support</span>
        </div>
      </div>
      <a href="<?php echo $invite_url; ?>" target="_blank" rel="noopener noreferrer" class="discord-join-btn">
        <i class="bi bi-discord"></i>
        Join Discord Server
      </a>
    </div>
  </div>
</div>