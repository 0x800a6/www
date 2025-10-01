<?php
require_once __DIR__ . '/utils/twitch.php';
require_once __DIR__ . '/utils/env.php';
$avatarUrl = 'https://pbs.twimg.com/profile_images/1962698837543505920/J9zQ83nH_400x400.jpg';

$twitch = new TwitchUtil(get_env_variable("TWITCH_CLIENT_ID"), get_env_variable("TWITCH_CLIENT_SECRET"));

// Check if the query parameter is set
$liveParam = isset($_GET['live']) ? $_GET['live'] : null;
// Check if Cottontail is live
$isLive = false;
$streamInfo = null;

if ($liveParam === '1' || $liveParam === 'true') {
    // Force live, ignore TwitchUtil
    $isLive = true;
    $streamInfo = [
        'title' => 'CottontailVA is live!',
        'viewer_count' => null,
        'game_name' => null,
        // Add more mock info if needed
    ];
} else {
    try {
        $isLive = $twitch->isLive("cottontailva");
        if ($isLive) {
            $streamInfo = $twitch->getStreamInfo("cottontailva");
        }
    } catch (Exception $e) {
        // If there's an error checking live status, default to not live
        $isLive = false;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CottontailVA — Virtual YouTuber & Content Creator</title>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    :root{
      --bg-1:#0a0014; --bg-2:#1a0033; --bg-3:#2d004d; 
      --accent1:#ff6ec7; --accent2:#a8d8ff; --accent3:#ffd93d;
      --glass: rgba(255,255,255,0.08); --glass-border: rgba(255,255,255,0.12);
      --glow-pink: #ff6ec7; --glow-blue: #a8d8ff; --glow-yellow: #ffd93d;
      --text-primary: #ffffff; --text-secondary: rgba(255,255,255,0.8);
      --shadow-soft: 0 8px 32px rgba(0,0,0,0.4);
      --shadow-glow: 0 0 40px rgba(255,110,199,0.3);
    }
    
    *{box-sizing:border-box;margin:0;padding:0}
    
    html,body{
      height:100%;font-family:'Space Grotesk',Quicksand,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;
      color:var(--text-primary);overflow-x:hidden;
      background: 
        radial-gradient(circle at 20% 20%, var(--bg-3), transparent 50%),
        radial-gradient(circle at 80% 80%, var(--bg-2), transparent 50%),
        radial-gradient(circle at 40% 60%, var(--bg-1), transparent 50%),
        linear-gradient(135deg, var(--bg-1), var(--bg-2));
      animation: backgroundShift 20s ease-in-out infinite;
    }

    @keyframes backgroundShift {
      0%, 100% { background-position: 0% 0%, 100% 100%, 50% 50%, 0% 0%; }
      25% { background-position: 25% 25%, 75% 75%, 60% 40%, 10% 10%; }
      50% { background-position: 50% 50%, 50% 50%, 70% 60%, 20% 20%; }
      75% { background-position: 75% 75%, 25% 25%, 40% 70%, 30% 30%; }
    }



    /* Header */
    header {
      padding: 4rem 1rem 4rem; position: relative; z-index: 10;
      background: linear-gradient(180deg, rgba(0,0,0,0.3), transparent);
    }

    /* Profile Section */
    .profile-section {
      max-width: 1200px; margin: 0 auto; display: grid;
      grid-template-columns: 300px 1fr; gap: 3rem; align-items: center;
    }

    .profile-avatar {
      position: relative; display: flex; justify-content: center;
    }

    .avatar-img {
      width: 250px; height: 250px; border-radius: 50%;
      object-fit: cover; border: 4px solid var(--glass-border);
      box-shadow: var(--shadow-soft); transition: transform 0.3s ease;
      position: relative; z-index: 2;
    }

    .avatar-img:hover {
      transform: scale(1.05) rotate(2deg);
    }

    .avatar-glow {
      position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
      width: 280px; height: 280px; border-radius: 50%;
      background: radial-gradient(circle, var(--accent1), transparent 70%);
      opacity: 0.3; animation: pulse 3s ease-in-out infinite;
      z-index: 1;
    }

    /* Live Indicator Styles */
    .live-indicator-ring {
      position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
      width: 270px; height: 270px; border-radius: 50%;
      border: 4px solid #ff0000; box-shadow: 0 0 20px #ff0000;
      animation: livePulse 2s ease-in-out infinite; z-index: 3;
      opacity: 0;
    }

    .live-status-box {
      position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
      background: linear-gradient(45deg, #ff0000, #cc0000); color: white;
      padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem;
      font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
      box-shadow: 0 4px 15px rgba(255, 0, 0, 0.4);
      animation: liveGlow 2s ease-in-out infinite alternate;
      z-index: 4; opacity: 0;
    }

    .live-status-box::before {
      content: ''; position: absolute; left: 8px; top: 50%; transform: translateY(-50%);
      width: 8px; height: 8px; background: white; border-radius: 50%;
      animation: liveBlink 1.5s ease-in-out infinite;
    }

    .live-status-box span {
      margin-left: 15px;
    }

    @keyframes livePulse {
      0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
      50% { transform: translate(-50%, -50%) scale(1.05); opacity: 1; }
    }

    @keyframes liveGlow {
      0% { box-shadow: 0 4px 15px rgba(255, 0, 0, 0.4); }
      100% { box-shadow: 0 4px 25px rgba(255, 0, 0, 0.8); }
    }

    @keyframes liveBlink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    /* Show live indicators when active */
    .profile-avatar.live .live-indicator-ring,
    .profile-avatar.live .live-status-box {
      opacity: 1;
    }

    .profile-info {
      text-align: left;
    }

    .profile-title {
      font-size: 1.3rem; margin: 0.5rem 0 1rem; opacity: 0.9;
      background: linear-gradient(45deg, var(--accent2), var(--accent3));
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }

    .profile-bio {
      font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;
      opacity: 0.9; max-width: 500px;
    }

    .bio-role {
      font-weight: 600; color: var(--accent1); letter-spacing: 0.5px;
      display: inline-flex; align-items: center; gap: 0.3rem;
    }

    .bio-role i {
      font-size: 1rem;
    }

    .bio-role.voice-actress i { color: var(--accent3); }
    .bio-role.vtuber i { color: var(--accent1); }
    .bio-role.singer i { color: var(--accent2); }

    .bio-separator {
      margin: 0 0.5em; color: var(--accent2); font-size: 1.2em;
    }

    .bio-separator.alt { color: var(--accent3); }

    .bio-hashtag {
      font-size: 0.98em; color: var(--accent1);
      display: inline-flex; align-items: center; gap: 0.3rem;
      margin-top: 0.5rem;
    }

    .bio-hashtag i {
      color: var(--accent1);
    }

    .bio-hashtag a {
      color: var(--accent2); text-decoration: underline dotted;
      transition: color 0.3s ease;
    }

    .bio-hashtag a:hover {
      color: var(--accent3);
    }

    /* Social Links */
    .social-links {
      display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;
    }

    .social-link {
      display: flex; align-items: center; gap: 0.5rem;
      padding: 0.8rem 1.2rem; border-radius: 50px;
      background: var(--glass); backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border); color: var(--text-primary);
      text-decoration: none; transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
      font-weight: 600; font-size: 0.9rem;
    }

    .social-link:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .social-link.youtube:hover { background: rgba(255, 0, 0, 0.2); }
    .social-link.twitch:hover { background: rgba(145, 70, 255, 0.2); }
    .social-link.twitter:hover { background: rgba(29, 161, 242, 0.2); }
    .social-link.discord:hover { background: rgba(114, 137, 218, 0.2); }
    .social-link.instagram:hover { background: rgba(225, 48, 108, 0.2); }

    .social-link i {
      font-size: 1.2rem;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;
    }

    .stat-item {
      text-align: center; padding: 1rem; border-radius: 16px;
      background: var(--glass); backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border); transition: transform 0.3s ease;
    }

    .stat-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .stat-number {
      display: block; font-size: 1.8rem; font-weight: 700;
      background: linear-gradient(45deg, var(--accent1), var(--accent2));
      -webkit-background-clip: text; background-clip: text; color: transparent;
      margin-bottom: 0.3rem;
    }

    .stat-label {
      font-size: 0.9rem; opacity: 0.8; text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    header h1 {
      font-size: clamp(2.5rem, 8vw, 5rem); margin: 0; font-weight: 700;
      background: linear-gradient(45deg, var(--accent1), var(--accent2), var(--accent3), var(--accent1));
      background-size: 300% 300%; -webkit-background-clip: text; background-clip: text;
      color: transparent; letter-spacing: 2px; text-shadow: 0 0 30px rgba(255,110,199,0.5);
      animation: gradientShift 3s ease-in-out infinite, textGlow 2s ease-in-out infinite alternate;
      position: relative;
    }
    
    @keyframes gradientShift {
      0%, 100% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
    }
    
    @keyframes textGlow {
      0% { filter: brightness(1) drop-shadow(0 0 20px rgba(255,110,199,0.3)); }
      100% { filter: brightness(1.2) drop-shadow(0 0 40px rgba(255,110,199,0.6)); }
    }

    header::before {
      content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
      width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,110,199,0.1), transparent 70%);
      animation: pulse 4s ease-in-out infinite; z-index: -1;
    }
    
    @keyframes pulse {
      0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
      50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.6; }
    }

    header p {
      margin: 1.5rem 0 0; opacity: 0.9; font-size: 1.2rem;
      text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    /* Main Content */
    main {
      max-width: 1400px; margin: 0 auto; padding: 2rem 1rem; position: relative;
    }

    .content-section {
      text-align: center; margin-bottom: 3rem;
    }

    .section-title {
      font-size: 2.5rem; margin: 0 0 0.5rem; font-weight: 600;
      background: linear-gradient(45deg, var(--accent1), var(--accent2));
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }

    .section-subtitle {
      font-size: 1.1rem; opacity: 0.8; margin-bottom: 2rem;
    }
    
    .gallery {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem; padding: 1rem 0;
    }

    /* Advanced Card Design */
    .card {
      background: var(--glass); backdrop-filter: blur(20px); border-radius: 24px;
      border: 1px solid var(--glass-border); overflow: hidden;
      box-shadow: var(--shadow-soft); transform-style: preserve-3d;
      transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
      position: relative; cursor: pointer;
    }
    
    .card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
      transform: translateX(-100%); transition: transform 0.6s;
    }
    
    .card:hover::before { transform: translateX(100%); }
    
    .card img {
      display: block; width: 100%; height: 280px; object-fit: cover;
      transition: transform 0.4s cubic-bezier(0.23, 1, 0.320, 1);
      filter: brightness(0.9) contrast(1.1);
    }
    
    .card:hover {
      transform: translateY(-20px) rotateX(5deg) rotateY(5deg) scale(1.05);
      box-shadow: 0 25px 50px rgba(0,0,0,0.4), var(--shadow-glow);
    }
    
    .card:hover img {
      transform: scale(1.1); filter: brightness(1.1) contrast(1.2) saturate(1.2);
    }

    /* Card Overlay */
    .card-overlay {
      position: absolute; bottom: 0; left: 0; right: 0;
      background: linear-gradient(transparent, rgba(0,0,0,0.8));
      color: white; padding: 2rem 1.5rem 1.5rem;
      transform: translateY(100%); transition: transform 0.4s cubic-bezier(0.23, 1, 0.320, 1);
      opacity: 0;
    }
    
    .card:hover .card-overlay { 
      transform: translateY(0); 
      opacity: 1;
    }
    
    .card-overlay h3 {
      font-size: 1.3rem; margin: 0 0 0.5rem; font-weight: 600;
      background: linear-gradient(45deg, var(--accent1), var(--accent2));
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    
    .card-overlay p {
      margin: 0; opacity: 0.9; font-size: 0.9rem;
    }

    /* Footer Links */
    .footer-links {
      margin-top: 1.5rem; display: flex; justify-content: center; gap: 1.5rem;
    }
    
    .footer-links a {
      color: var(--text-secondary); font-size: 1.5rem; transition: all 0.3s ease;
      text-decoration: none; padding: 0.5rem; border-radius: 50%;
      background: rgba(255,255,255,0.05); backdrop-filter: blur(10px);
    }
    
    .footer-links a:hover {
      color: var(--accent1); transform: translateY(-3px) scale(1.1);
      background: rgba(255,110,199,0.1); box-shadow: 0 5px 15px rgba(255,110,199,0.3);
    }

    /* Particle Systems */
    .particle-container {
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      pointer-events: none; z-index: 1;
    }
    
    .particle {
      position: absolute; border-radius: 50%; pointer-events: none;
      background: radial-gradient(circle, var(--accent1), transparent);
    }
    
    .floating-orb {
      position: absolute; border-radius: 50%; background: radial-gradient(circle, var(--accent2), transparent);
      animation: float 6s ease-in-out infinite; opacity: 0.6;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(180deg); }
    }


    /* Interactive Elements */
    .interactive-btn {
      position: fixed; top: 2rem; right: 2rem; z-index: 100;
      background: var(--glass); border: 1px solid var(--glass-border);
      color: var(--text-primary); padding: 1rem 1.5rem; border-radius: 50px;
      cursor: pointer; backdrop-filter: blur(20px); transition: all 0.3s ease;
      font-family: inherit; font-weight: 600;
    }
    
    .interactive-btn:hover {
      background: rgba(255,110,199,0.2); transform: scale(1.05);
      box-shadow: 0 10px 30px rgba(255,110,199,0.3);
    }

    /* Footer */
    footer {
      text-align: center; padding: 4rem 1rem 2rem; color: var(--text-secondary);
      position: relative; z-index: 10;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .profile-section {
        grid-template-columns: 1fr; text-align: center; gap: 2rem;
      }
      .profile-info { text-align: center; }
      .stats-grid { grid-template-columns: repeat(4, 1fr); }
    }

    @media (max-width: 768px) {
      .gallery { grid-template-columns: 1fr; gap: 1.5rem; }
      header { padding: 3rem 1rem 2rem; }
      .interactive-btn { top: 1rem; right: 1rem; padding: 0.8rem 1.2rem; }
      .avatar-img { width: 200px; height: 200px; }
      .avatar-glow { width: 230px; height: 230px; }
      .live-indicator-ring { width: 210px; height: 210px; }
      .social-links { justify-content: center; }
      .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.8rem; }
      .bio-role { font-size: 1rem; }
      .bio-separator { font-size: 1.1em; }
    }
    
    @media (max-width: 480px) {
      header { padding: 2rem 1rem 1.5rem; }
      .avatar-img { width: 150px; height: 150px; }
      .avatar-glow { width: 180px; height: 180px; }
      .live-indicator-ring { width: 160px; height: 160px; }
      .live-status-box { font-size: 0.7rem; padding: 0.4rem 0.8rem; }
      .profile-bio { font-size: 1rem; }
      .bio-role { font-size: 0.9rem; }
      .bio-separator { font-size: 1rem; }
      .bio-hashtag { font-size: 0.9rem; }
      .social-links { gap: 0.5rem; }
      .social-link { padding: 0.6rem 1rem; font-size: 0.8rem; }
      .stats-grid { grid-template-columns: 1fr; }
      .card img { height: 200px; }
      .section-title { font-size: 2rem; }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
      :root { --glass: rgba(255,255,255,0.2); --glass-border: rgba(255,255,255,0.4); }
    }
  </style>
</head>
<body>


  <!-- Particle Container -->
  <div class="particle-container" id="particleContainer"></div>

  <!-- Interactive Controls -->
  <button class="interactive-btn" id="toggleParticles" title="Toggle Particles">
    <i class="bi bi-stars"></i>
  </button>

  <!-- Floating Orbs -->
  <div class="floating-orb" style="top: 20%; left: 10%; width: 60px; height: 60px; animation-delay: 0s;"></div>
  <div class="floating-orb" style="top: 60%; right: 15%; width: 40px; height: 40px; animation-delay: 2s;"></div>
  <div class="floating-orb" style="bottom: 30%; left: 20%; width: 80px; height: 80px; animation-delay: 4s;"></div>

  <header>
    <div class="profile-section">
      <div class="profile-avatar<?php echo $isLive ? ' live' : ''; ?>">
        <img src="<?php echo $avatarUrl; ?>" alt="CottontailVA Avatar" class="avatar-img">
        <div class="avatar-glow"></div>
        <?php if ($isLive): ?>
        <div class="live-indicator-ring"></div>
        <div class="live-status-box">
          <span>LIVE</span>
        </div>
        <?php endif; ?>
      </div>
      <div class="profile-info">
        <h1>CottontailVA</h1>
        <p class="profile-title">Virtual YouTuber & Content Creator</p>
        <p class="profile-bio">
          <span class="bio-role voice-actress">
            <i class="bi bi-mic-fill"></i> Voice Actress
          </span>
          <span class="bio-separator">✧</span>
          <span class="bio-role vtuber">
            <i class="bi bi-controller"></i> Vtuber
          </span>
          <span class="bio-separator alt">✧</span>
          <span class="bio-role singer">
            <i class="bi bi-music-note-beamed"></i> Singer
          </span>
          <br>
          <span class="bio-hashtag">
            <i class="bi bi-brush"></i>
            Art hashtag: 
            <a href="https://x.com/search?q=%23cottoncreate&src=hashtag_click" target="_blank" rel="noopener">
              #cottoncreate
            </a>
          </span>
        </p>
        <div class="social-links">
          <a href="https://www.twitch.tv/cottontailva" target="_blank" rel="noopener" class="social-link twitch" aria-label="Twitch Stream">
            <i class="bi bi-twitch"></i>
            <span>Twitch</span>
          </a>
          <a href="https://www.youtube.com/channel/UCgfRDtfK0QDlE0RaDWp5baw" target="_blank" rel="noopener" class="social-link youtube" aria-label="YouTube Channel">
            <i class="bi bi-youtube"></i>
            <span>YouTube</span>
          </a>
          <a href="https://www.instagram.com/cottontailva/" target="_blank" rel="noopener" class="social-link instagram" aria-label="Instagram">
            <i class="bi bi-instagram"></i>
            <span>Instagram</span>
          </a>
          <a href="https://www.reddit.com/r/cottontailva/" target="_blank" rel="noopener" class="social-link reddit" aria-label="Reddit">
            <i class="bi bi-reddit"></i>
            <span>Reddit</span>
          </a>
          <a href="https://onlyfans.com/cottontailva/c1" target="_blank" rel="noopener" class="social-link onlyfans" aria-label="OnlyFans">
            <i class="bi bi-star-fill"></i>
            <span>OnlyFans</span>
          </a>
          <a href="https://www.patreon.com/cottontailva" target="_blank" rel="noopener" class="social-link patreon" aria-label="Patreon">
            <i class="bi bi-cash-stack"></i>
            <span>Patreon</span>
          </a>
          <a href="https://fansly.com/365078231763660800/posts" target="_blank" rel="noopener" class="social-link fansly" aria-label="Fansly">
            <i class="bi bi-stars"></i>
            <span>Fansly</span>
          </a>
          <a href="https://cottontailva.newgrounds.com/" target="_blank" rel="noopener" class="social-link newgrounds" aria-label="Newgrounds">
            <i class="bi bi-joystick"></i>
            <span>Newgrounds</span>
          </a>
          <a href="https://cottontail.gumroad.com/" target="_blank" rel="noopener" class="social-link gumroad" aria-label="Gumroad">
            <i class="bi bi-bag"></i>
            <span>Gumroad</span>
          </a>
          <a href="https://www.tiktok.com/@cottontailva" target="_blank" rel="noopener" class="social-link tiktok" aria-label="TikTok">
            <i class="bi bi-music-note"></i>
            <span>TikTok</span>
          </a>
          <a href="https://open.spotify.com/artist/1GmAM5JVjFw5ESEh3xoqPP" target="_blank" rel="noopener" class="social-link spotify" aria-label="Spotify">
            <i class="bi bi-spotify"></i>
            <span>Spotify</span>
          </a>
        </div>
        
        <div class="stats-grid">
          <div class="stat-item">
            <span class="stat-number">435K +</span>
            <span class="stat-label">YouTube Subs</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">419k+</span>
            <span class="stat-label">Twitch Followers</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">599.9K +</span>
            <span class="stat-label">Twitter Followers</span>
          </div>
        </div>
      </div>
    </div>
  </header>


  <footer>
    <p>Made with ♡ by Lexi (0x800a6)</p> <small>I love you cottontail! - Lexi</small>
  </footer>

  <!-- Advanced Spectacular JavaScript Engine -->
  <script>
    (function(){
      'use strict';
      
      // Configuration - Optimized for performance
      const CONFIG = {
        particleCount: 60, // Reduced from 150
        maxParticles: 120, // Reduced from 300
        animationSpeed: 1,
        particlesEnabled: true,
        performanceMode: true, // Enabled for better performance
        adaptiveQuality: true,
        targetFPS: 60
      };

      // State Management
      const state = {
        mouse: { x: 0, y: 0, prevX: 0, prevY: 0 },
        particles: [],
        anime: null,
        loading: true,
        initialized: false
      };

      // DOM Elements
      const elements = {
        particleContainer: document.getElementById('particleContainer'),
        toggleParticles: document.getElementById('toggleParticles'),
        gallery: document.getElementById('gallery'),
        header: document.querySelector('header h1')
      };

      // Utility Functions
      function ready(fn) {
        if (document.readyState !== 'loading') return fn();
        document.addEventListener('DOMContentLoaded', fn);
      }

      function loadScript(src) {
        return new Promise((resolve, reject) => {
          const script = document.createElement('script');
          script.src = src;
          script.async = true;
          script.onload = resolve;
          script.onerror = reject;
          document.head.appendChild(script);
        });
      }

      function lerp(start, end, factor) {
        return start + (end - start) * factor;
      }

      function random(min, max) {
        return Math.random() * (max - min) + min;
      }

      function distance(x1, y1, x2, y2) {
        return Math.sqrt((x2 - x1) ** 2 + (y2 - y1) ** 2);
      }

      // Particle System
      class Particle {
        constructor() {
          this.reset();
          this.life = 1;
          this.decay = random(0.01, 0.03);
        }

        reset() {
          this.x = random(0, window.innerWidth);
          this.y = random(0, window.innerHeight);
          this.vx = random(-2, 2);
          this.vy = random(-2, 2);
          this.size = random(2, 6);
          this.color = `hsl(${random(280, 320)}, 70%, 60%)`;
          this.alpha = random(0.3, 0.8);
          this.life = 1;
        }

        update() {
          this.x += this.vx;
          this.y += this.vy;
          this.alpha -= this.decay;
          this.life -= this.decay;

          // Simplified mouse interaction for performance
          if (CONFIG.performanceMode) {
            const dist = distance(this.x, this.y, state.mouse.x, state.mouse.y);
            if (dist < 80) {
              const force = (80 - dist) / 80 * 0.005; // Reduced force
              this.vx += (this.x - state.mouse.x) * force;
              this.vy += (this.y - state.mouse.y) * force;
            }
          }

          // Boundary wrapping
          if (this.x < 0) this.x = window.innerWidth;
          if (this.x > window.innerWidth) this.x = 0;
          if (this.y < 0) this.y = window.innerHeight;
          if (this.y > window.innerHeight) this.y = 0;

          // Reset if dead
          if (this.life <= 0) this.reset();
        }

        draw(ctx) {
          ctx.save();
          ctx.globalAlpha = this.alpha;
          ctx.fillStyle = this.color;
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
          ctx.fill();
          ctx.restore();
        }
      }



      // Animation Engine
      class AnimationEngine {
        constructor() {
          this.anime = null;
          this.timeline = null;
          this.init();
        }

        async init() {
          try {
            await loadScript('https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js');
            this.anime = window.anime;
            state.anime = this.anime;
            this.createTimeline();
          } catch (error) {
            console.warn('Anime.js failed to load:', error);
            this.createFallbackAnimations();
          }
        }

        createTimeline() {
          if (!this.anime) return;
          
          // Header animation
          this.anime({
            targets: elements.header,
            scale: [0.8, 1],
            opacity: [0, 1],
            duration: 1500,
            easing: 'easeOutElastic(1, .6)'
          });

          // Cards entrance
          this.anime.timeline()
          .add({
            targets: '.card',
              translateY: [100, 0],
              rotateX: [45, 0],
              opacity: [0, 1],
              delay: this.anime.stagger(200, {start: 500}),
              duration: 1200,
              easing: 'easeOutExpo'
          })
          .add({
              targets: '.floating-orb',
              scale: [0, 1],
              rotate: [0, 360],
              delay: this.anime.stagger(100, {start: 1000}),
              duration: 2000,
              easing: 'easeOutElastic(1, .8)'
            });

          // Continuous animations
          this.startContinuousAnimations();
        }

        startContinuousAnimations() {
          // Floating orbs
          this.anime({
            targets: '.floating-orb',
            translateY: [0, -20, 0],
            duration: 6000,
            easing: 'easeInOutSine',
            loop: true
          });

          // Header glow
          this.anime({
            targets: elements.header,
            filter: [
              'brightness(1) drop-shadow(0 0 20px rgba(255,110,199,0.3))',
              'brightness(1.2) drop-shadow(0 0 40px rgba(255,110,199,0.6))'
            ],
            duration: 3000,
            easing: 'easeInOutSine',
            loop: true,
            direction: 'alternate'
          });
        }

        createFallbackAnimations() {
          // CSS-only fallbacks
          document.querySelectorAll('.card').forEach((card, index) => {
            card.style.animation = `fadeInUp 1s ease-out ${index * 0.2}s both`;
          });
        }
      }

      // Performance Monitor
      class PerformanceMonitor {
        constructor() {
          this.fps = 60;
          this.frameCount = 0;
          this.lastTime = performance.now();
          this.fpsHistory = [];
        }

        update() {
          this.frameCount++;
          const now = performance.now();
          
          if (now - this.lastTime >= 1000) {
            this.fps = Math.round((this.frameCount * 1000) / (now - this.lastTime));
            this.fpsHistory.push(this.fps);
            if (this.fpsHistory.length > 10) this.fpsHistory.shift();
            
            this.frameCount = 0;
            this.lastTime = now;
            
            // Adaptive quality based on FPS
            if (CONFIG.adaptiveQuality) {
              const avgFps = this.fpsHistory.reduce((a, b) => a + b, 0) / this.fpsHistory.length;
              if (avgFps < 45 && CONFIG.particleCount > 30) {
                CONFIG.particleCount = Math.max(30, CONFIG.particleCount - 10);
                console.log('Reducing particles for better performance:', CONFIG.particleCount);
              } else if (avgFps > 55 && CONFIG.particleCount < 100) {
                CONFIG.particleCount = Math.min(100, CONFIG.particleCount + 5);
              }
            }
          }
        }
      }

      // Main Application
      class App {
        constructor() {
          this.animationEngine = null;
          this.particles = [];
          this.performanceMonitor = new PerformanceMonitor();
          this.lastRenderTime = 0;
          this.init();
        }

        async init() {
          // Initialize systems
          this.animationEngine = new AnimationEngine();
          
          // Initialize particles
          this.initParticles();
          
          // Setup event listeners
          this.setupEventListeners();
          
          // Start render loop
          this.startRenderLoop();
          
          // Initialize immediately
          this.hideLoading();
        }

        showLoading() {
          // Loading screen removed
        }

        hideLoading() {
          state.loading = false;
          state.initialized = true;
        }

        initParticles() {
          for (let i = 0; i < CONFIG.particleCount; i++) {
            this.particles.push(new Particle());
          }
        }

        setupEventListeners() {
          // Toggle particles
          elements.toggleParticles.addEventListener('click', () => {
            CONFIG.particlesEnabled = !CONFIG.particlesEnabled;
            elements.toggleParticles.style.opacity = CONFIG.particlesEnabled ? '1' : '0.5';
          });

          // Card interactions
          document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', () => {
              if (state.anime) {
                state.anime({
                  targets: card,
                  scale: [1, 1.05],
                  rotateY: [0, 5],
                  boxShadow: [
                    '0 8px 32px rgba(0,0,0,0.4)',
                    '0 25px 50px rgba(255,110,199,0.3)'
                  ],
                  duration: 400,
                  easing: 'easeOutExpo'
                });
              }
            });

            card.addEventListener('mouseleave', () => {
              if (state.anime) {
                state.anime({
                  targets: card,
                  scale: [1.05, 1],
                  rotateY: [5, 0],
                  boxShadow: [
                    '0 25px 50px rgba(255,110,199,0.3)',
                    '0 8px 32px rgba(0,0,0,0.4)'
                  ],
                  duration: 400,
                  easing: 'easeOutExpo'
                });
              }
            });
          });

          // Window resize
          window.addEventListener('resize', this.handleResize.bind(this));
        }

        handleResize() {
          // Reinitialize particles for new screen size
          this.particles = [];
          this.initParticles();
        }

        startRenderLoop() {
          const render = (currentTime) => {
            if (state.loading) {
              requestAnimationFrame(render);
              return;
            }

            // Throttle rendering for better performance
            const deltaTime = currentTime - this.lastRenderTime;
            if (deltaTime >= 16) { // ~60fps
              // Update performance monitor
              this.performanceMonitor.update();

              // Update particles (only if enabled and performance allows)
              if (CONFIG.particlesEnabled && this.performanceMonitor.fps > 30) {
                this.updateParticles();
              }

              this.lastRenderTime = currentTime;
            }

            requestAnimationFrame(render);
          };
          
          requestAnimationFrame(render);
        }

        updateParticles() {
          const canvas = this.getOrCreateCanvas();
          if (!canvas) return;
          
          const ctx = canvas.getContext('2d');
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          
          // Only update and draw the configured number of particles
          const activeParticles = this.particles.slice(0, CONFIG.particleCount);
          
          activeParticles.forEach(particle => {
            particle.update();
            particle.draw(ctx);
          });
          
          // Remove excess particles if count was reduced
          if (this.particles.length > CONFIG.particleCount) {
            this.particles = this.particles.slice(0, CONFIG.particleCount);
          }
        }

        getOrCreateCanvas() {
          let canvas = document.getElementById('particleCanvas');
          if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.id = 'particleCanvas';
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            canvas.style.pointerEvents = 'none';
            canvas.style.zIndex = '1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            elements.particleContainer.appendChild(canvas);
          }
          return canvas;
        }
      }

      // Initialize everything
      ready(() => {
        new App();
      });

    })();
  </script>
</body>
</html>
