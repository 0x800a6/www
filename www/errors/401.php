<?php
http_response_code(401);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Unauthorized | 0x800a6</title>
    <link rel="stylesheet" href="/static/css/vendor/bootstrap-icons.css">
    <link href="/static/css/vendor/fonts/JetBrainsMono-Inter.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a0a0a;
            --bg-secondary: #111111;
            --bg-card: #0f0f0f;
            --neon-cyan: #00ffff;
            --neon-green: #00ff41;
            --neon-purple: #bf00ff;
            --neon-red: #ff0000;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --border-primary: #333333;
            --shadow-neon: 0 0 20px rgba(191, 0, 255, 0.5);
            --shadow-glow: 0 0 30px rgba(191, 0, 255, 0.3);
            --font-mono: "JetBrains Mono", "Fira Code", "Consolas", monospace;
            --font-sans: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .glitch-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(191, 0, 255, 0.03) 50%,
                transparent 70%
            );
            z-index: -1;
            animation: glitch-scan 8s linear infinite;
        }

        @keyframes glitch-scan {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .error-container {
            text-align: center;
            background: var(--bg-card);
            border: 1px solid var(--border-primary);
            border-radius: 12px;
            padding: 3rem 2rem;
            box-shadow: var(--shadow-glow);
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 1rem;
        }

        .terminal-window {
            background: var(--bg-primary);
            border: 1px solid var(--border-primary);
            border-radius: 8px;
            margin-bottom: 2rem;
            overflow: hidden;
            font-family: var(--font-mono);
        }

        .terminal-header {
            background: var(--bg-secondary);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 1px solid var(--border-primary);
        }

        .terminal-buttons {
            display: flex;
            gap: 0.25rem;
        }

        .terminal-buttons span {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .btn-close { background: #ff5f56; }
        .btn-minimize { background: #ffbd2e; }
        .btn-maximize { background: #27ca3f; }

        .terminal-title {
            color: var(--text-secondary);
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }

        .terminal-body {
            padding: 1.5rem;
            background: var(--bg-primary);
        }

        .terminal-line {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .prompt {
            color: var(--neon-green);
            font-weight: 500;
        }

        .command {
            color: var(--neon-cyan);
        }

        .terminal-output {
            color: var(--text-primary);
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .error-code {
            font-size: 4rem;
            font-weight: 700;
            margin: 0;
            color: var(--neon-purple);
            text-shadow: var(--shadow-neon);
            font-family: var(--font-mono);
        }

        .error-message {
            font-size: 1.5rem;
            margin: 1rem 0;
            color: var(--text-primary);
            font-weight: 600;
        }

        .error-description {
            font-size: 1rem;
            margin: 1rem 0 2rem 0;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .home-link {
            display: inline-block;
            background: transparent;
            color: var(--neon-cyan);
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border: 2px solid var(--neon-cyan);
            border-radius: 4px;
            font-family: var(--font-mono);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .home-link::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--neon-cyan);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .home-link:hover::before {
            left: 0;
        }

        .home-link:hover {
            color: var(--bg-primary);
            box-shadow: var(--shadow-neon);
        }

        .cursor-blink {
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 2rem 1rem;
                margin: 0 0.5rem;
            }
            
            .error-code {
                font-size: 3rem;
            }
            
            .terminal-body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="glitch-overlay"></div>
    
    <div class="error-container">
        <div class="terminal-window">
            <div class="terminal-header">
                <div class="terminal-buttons">
                    <span class="btn-close"></span>
                    <span class="btn-minimize"></span>
                    <span class="btn-maximize"></span>
                </div>
                <span class="terminal-title">auth@0x800a6:~$</span>
            </div>
            <div class="terminal-body">
                <div class="terminal-line">
                    <span class="prompt">$</span>
                    <span class="command">ssh user@lrr.sh</span>
                </div>
                <div class="terminal-output">Permission denied (publickey).</div>
                <div class="terminal-line">
                    <span class="prompt">$</span>
                    <span class="command">echo "Authentication required"</span>
                </div>
                <div class="terminal-output">Authentication required</div>
                <div class="terminal-line">
                    <span class="prompt">$</span>
                    <span class="command cursor-blink">_</span>
                </div>
            </div>
        </div>
        
        <h1 class="error-code">401</h1>
        <h2 class="error-message">Unauthorized</h2>
        <p class="error-description">Authentication is required to access this resource. Please log in and try again.</p>
        <a href="/" class="home-link">Go Home</a>
    </div>
</body>
</html>
