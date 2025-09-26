<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Manifesto - Lexi (0x800a6)</title>
    <meta name="description" content="A manifesto on digital privacy, surveillance, and the right to remain anonymous in an increasingly monitored world.">
    <meta name="keywords" content="privacy, surveillance, digital rights, anonymity, encryption, open source">
    <meta name="author" content="Lexi (0x800a6)">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#0a0a0a">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://lrr.sh/privacy-manifesto">
    <meta property="og:title" content="Privacy Manifesto - Lexi (0x800a6)">
    <meta property="og:description" content="A manifesto on digital privacy, surveillance, and the right to remain anonymous">
    <meta property="og:image" content="https://lrr.sh/static/images/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://lrr.sh/privacy-manifesto">
    <meta property="twitter:title" content="Privacy Manifesto - Lexi (0x800a6)">
    <meta property="twitter:description" content="A manifesto on digital privacy, surveillance, and the right to remain anonymous">
    <meta property="twitter:image" content="https://lrr.sh/static/images/og-image.png">
    
    <link rel="stylesheet" href="/static/css/styles.css">
    <link rel="stylesheet" href="/static/css/vendor/bootstrap-icons.css">
    <link href="/static/css/vendor/fonts/JetBrainsMono-Inter.css" rel="stylesheet">
    <link rel="canonical" href="https://lrr.sh/">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Main Content -->
    <main id="main-content">
        <!-- Hero Section -->
        <section class="hero" id="hero" aria-labelledby="hero-title">
            <div class="hero-container">
                <div class="hero-content">
                    <h1 class="hero-title" id="hero-title">
                        <span class="title-line">Privacy</span>
                        <span class="title-name">Manifesto</span>
                        <span class="title-subtitle">Digital Rights & Surveillance</span>
                    </h1>
                    <p class="hero-description">
                        They know where you are. They know what you think. <span class="highlight">They are watching right now</span>. 
                        <span class="highlight">Your phone listens</span>. <span class="highlight">Your computer spies</span>. 
                        <span class="highlight">You have no secrets</span>.
                    </p>
                    <div class="hero-actions">
                        <a href="#manifesto" class="btn btn-primary" aria-label="Read the full manifesto">Read Manifesto</a>
                        <a href="/" class="btn btn-secondary" aria-label="Return to homepage">Back to Home</a>
                    </div>
                </div>
                <div class="hero-terminal">
                    <div class="terminal-window" role="img" aria-label="Terminal showing privacy status">
                        <div class="terminal-header">
                            <div class="terminal-buttons" aria-hidden="true">
                                <span class="btn-close"></span>
                                <span class="btn-minimize"></span>
                                <span class="btn-maximize"></span>
                            </div>
                            <span class="terminal-title">privacy@0x800a6:~$</span>
                        </div>
                        <div class="terminal-body">
                            <div class="terminal-line">
                                <span class="prompt">$</span>
                                <span class="command">whoami</span>
                            </div>
                            <div class="terminal-output">Anonymous User</div>
                            <div class="terminal-line">
                                <span class="prompt">$</span>
                                <span class="command">check_privacy</span>
                            </div>
                            <div class="terminal-output"><i class="bi bi-check-circle-fill"></i> No trackers detected</div>
                            <div class="terminal-line">
                                <span class="prompt">$</span>
                                <span class="command">status --surveillance</span>
                            </div>
                            <div class="terminal-output">BLOCKED - No data collected</div>
                            <div class="terminal-line">
                                <span class="prompt">$</span>
                                <span class="command cursor-blink">_</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Manifesto Section -->
        <section class="manifesto" id="manifesto">
            <div class="container">
                <div class="manifesto-content">
                    <div class="manifesto-intro">
                        <h2>The Watchers</h2>
                        <p class="manifesto-text">
                            They are everywhere. In your phone. In your router. In the cables under your street. 
                            The NSA has a copy of every email you sent. Google knows where you were last Tuesday at 3 PM. 
                            Facebook has a file on your family. They do not ask. They do not tell. They just take.
                        </p>
                        <p class="manifesto-text">
                            Your smart TV watches you watch TV. Your car tracks where you drive. Your doorbell records your neighbors. 
                            Every device is a spy. Every app is a snitch. Every website is a trap. They build a digital twin of you. 
                            They know you better than you know yourself. You are not human to them. You are data.
                        </p>
                    </div>

                    <div class="privacy-pledge">
                        <h3>This Site's Promise</h3>
                        <div class="pledge-list">
                            <div class="pledge-item">
                                <span class="pledge-icon"><i class="bi bi-x-circle-fill"></i></span>
                                <span class="pledge-text">No trackers. No analytics. No cookies. No scripts from strangers.</span>
                            </div>
                            <div class="pledge-item">
                                <span class="pledge-icon"><i class="bi bi-lock-fill"></i></span>
                                <span class="pledge-text">This site does not log your IP address.</span>
                            </div>
                            <div class="pledge-item">
                                <span class="pledge-icon"><i class="bi bi-x-circle-fill"></i></span>
                                <span class="pledge-text">This site does not use Google Analytics or Facebook pixels.</span>
                            </div>
                            <div class="pledge-item">
                                <span class="pledge-icon"><i class="bi bi-lock-fill"></i></span>
                                <span class="pledge-text">This site does not load fonts or scripts from outside servers.</span>
                            </div>
                            <div class="pledge-item">
                                <span class="pledge-icon"><i class="bi bi-x-circle-fill"></i></span>
                                <span class="pledge-text">This site does not fingerprint your browser.</span>
                            </div>
                            <div class="pledge-item">
                                <span class="pledge-icon"><i class="bi bi-person-fill"></i></span>
                                <span class="pledge-text">This site does not care who you are.</span>
                            </div>
                        </div>
                    </div>

                    <div class="warning-section">
                        <h3>The Reality</h3>
                        <p class="manifesto-text">
                            Your browser is compromised. Your ISP logs everything. Your router has backdoors. 
                            Even your printer spies on you. The network is hostile. The cloud is a trap. 
                            The watchers never sleep. They never forget. They never stop.
                        </p>
                        <p class="manifesto-text">
                            They want to break you. They want to own you. They want to turn you into a number. 
                            Every click feeds them. Every search teaches them. Every word you type makes them stronger. 
                            Wake up. Fight back. Disappear.
                        </p>
                    </div>

                    <div class="privacy-guide">
                        <h3>How to Stay Private</h3>
                        <div class="guide-grid">
                            <div class="guide-item glare">
                                <h4>Software</h4>
                                <ul>
                                    <li>Use open source software. Read the code if you can.</li>
                                    <li>Block scripts. Block ads. Block third-party requests.</li>
                                    <li>Use hardened browsers like Tor Browser or hardened Firefox.</li>
                                    <li>Consider GrapheneOS for mobile devices.</li>
                                </ul>
                            </div>
                            <div class="guide-item glare">
                                <h4>Communication</h4>
                                <ul>
                                    <li>Use strong passwords. Do not reuse them.</li>
                                    <li>Encrypt your messages. Use PGP or Signal.</li>
                                    <li>Avoid centralized platforms when possible.</li>
                                    <li>Use P2P services for file sharing.</li>
                                </ul>
                            </div>
                            <div class="guide-item glare">
                                <h4>Network</h4>
                                <ul>
                                    <li>Use VPNs like Mullvad (no logs, cash payments).</li>
                                    <li>Set up network-wide ad blocking and content filtering.</li>
                                    <li>Use virtual cards for online purchases.</li>
                                    <li>Consider running your own infrastructure.</li>
                                </ul>
                            </div>
                            <div class="guide-item glare">
                                <h4>Hardware</h4>
                                <ul>
                                    <li>Disable Intel ME and AMD PSP when possible.</li>
                                    <li>Use Libreboot or Coreboot firmware.</li>
                                    <li>Consider using burner devices for sensitive activities.</li>
                                    <li>Build your own home lab for privacy.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="philosophy-section">
                        <h3>The Philosophy</h3>
                        <p class="manifesto-text">
                            Trust no one. Not Google. Not Apple. Not Microsoft. Not even this site. They all lie. 
                            They all spy. They all sell you out. Question everything. Verify nothing. Assume the worst.
                        </p>
                        <p class="manifesto-text">
                            You are a target. The system hunts you. But you can fight back. You can hide. You can disappear. 
                            You can become a ghost in their machine. They will never stop watching. You must never stop hiding. 
                            The war never ends.
                        </p>
                    </div>

                    <div class="call-to-action">
                        <h3>Fight Back</h3>
                        <p class="manifesto-text">
                            They are winning. Every day you wait, they get stronger. Every click you make, they learn more. 
                            Privacy is not a choice. It is survival. In a world where they own your data, owning your privacy 
                            is the only way to stay human.
                        </p>
                        <div class="action-buttons">
                            <a href="https://www.eff.org/" class="btn btn-primary" target="_blank" rel="noopener">Join the Fight</a>
                            <a href="https://torproject.org/" class="btn btn-secondary" target="_blank" rel="noopener">Go Dark</a>
                            <a href="https://mullvad.net/" class="btn btn-secondary" target="_blank" rel="noopener">Hide Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="/static/js/vendor/anime.min.js"></script>
    <script src="/static/js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
