<?php
$bash_rc = file_get_contents('./data/dotfiles/.bashrc');
$vimrc = file_get_contents('./data/dotfiles/.vimrc');
$i3 = file_get_contents('./data/dotfiles/i3_config');
$picom = file_get_contents('./data/dotfiles/picom.conf');
$kitty = file_get_contents('./data/dotfiles/kitty.conf');
$rofi = file_get_contents('./data/dotfiles/spotlight.rasi');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Primary Meta Tags -->
    <title>Dotfiles Showcase | Lexi's Website</title>
    <meta name="title" content="Dotfiles Showcase - Configuration Files" />
    <meta name="description" content="Explore my dotfiles configuration including .bashrc, .vimrc, i3 config, picom, kitty terminal, and rofi spotlight. Minimal, fast, and tuned for developer workflow." />
    <meta name="keywords" content="dotfiles, configuration, bashrc, vimrc, i3wm, picom, kitty terminal, rofi, arch linux, developer setup" />
    <meta name="author" content="Lexi Rose Rogers" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="English" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://lrr.sh/dotfiles" />
    <meta property="og:title" content="Dotfiles Showcase - Configuration Files" />
    <meta property="og:description" content="Explore my dotfiles configuration including .bashrc, .vimrc, i3 config, picom, kitty terminal, and rofi spotlight. Minimal, fast, and tuned for developer workflow." />
    <meta property="og:image" content="https://lrr.sh/static/images/picture.jpg" />
    <meta property="og:site_name" content="Lexi's Website" />
    <meta property="og:locale" content="en_US" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://lrr.sh/dotfiles" />
    <meta property="twitter:title" content="Dotfiles Showcase - Configuration Files" />
    <meta property="twitter:description" content="Explore my dotfiles configuration including .bashrc, .vimrc, i3 config, picom, kitty terminal, and rofi spotlight. Minimal, fast, and tuned for developer workflow." />
    <meta property="twitter:image" content="https://lrr.sh/static/images/picture.jpg" />
    
    <!-- Additional SEO -->
    <link rel="canonical" href="https://lrr.sh/dotfiles" />
    <meta name="theme-color" content="#1d2021" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/static/images/picture.jpg" />
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="/static/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <style>
        .section-title {
        color: var(--green);
        margin-top: 2rem;
        border-bottom: 1px solid #3c3836;
        padding-bottom: 0.5rem;
      }
      .accordion-button {
        background-color: #1d2021;
        color: var(--fg);
        border: 1px solid #3c3836;
        transition: background 0.2s;
      }
      .accordion-button:hover {
        background-color: #3c3836;
        color: var(--aqua);
      }
      .accordion-button:not(.collapsed) {
        background-color: #3c3836;
        color: var(--yellow);
      }
      .accordion-item {
        background-color: #1d2021;
        border: 1px solid #3c3836;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        overflow: hidden;
      }
      .accordion-body {
        background-color: #1d2021;
      }
      pre {
        background-color: #2d3748 !important;
        border-radius: 0.5rem;
        padding: 1rem;
        font-size: 0.9rem;
        line-height: 1.4;
        overflow-x: auto;
        border: 1px solid #3c3836;
        position: relative;
        margin: 0;
      }
      .code-block-container {
        position: relative;
      }
      .copy-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background-color: #4a5568;
        color: white;
        border: none;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
        z-index: 10;
      }
      .copy-btn:hover {
        opacity: 1;
        background-color: #2b6cb0;
      }
      .copy-btn.copied {
        background-color: #38a169;
        opacity: 1;
      }
      pre code {
        font-family: 'Fira Code', 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        background: transparent !important;
      }
      .token.comment,
      .token.prolog,
      .token.doctype,
      .token.cdata {
        color: #6a9955;
      }
      .token.punctuation {
        color: #d4d4d4;
      }
      .token.property,
      .token.tag,
      .token.constant,
      .token.symbol,
      .token.deleted {
        color: #f44747;
      }
      .token.boolean,
      .token.number {
        color: #b5cea8;
      }
      .token.selector,
      .token.attr-name,
      .token.string,
      .token.char,
      .token.builtin,
      .token.inserted {
        color: #ce9178;
      }
      .token.operator,
      .token.entity,
      .token.url,
      .language-css .token.string,
      .style .token.string,
      .token.variable {
        color: #d4d4d4;
      }
      .token.function,
      .token.class-name {
        color: #dcdcaa;
      }
      .token.keyword {
        color: #569cd6;
      }
      .icon {
        margin-right: 0.5rem;
        color: var(--green);
      }
    </style>
  </head>
  <body class="container">
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    <header>
      <h1 id="title">Dotfiles Showcase</h1>
      <p>
        Configs that define my workspace — minimal, fast, and tuned for flow.
      </p>
    </header>

    <!-- Main Content -->
    <div class="container">
      <h2 class="section-title">Configuration Files</h2>

      <div class="accordion" id="dotfilesAccordion">
        <!-- Example dotfile entry -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingBashrc">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseBashrc"
            >
              <span class="icon">🐚</span>.bashrc
            </button>
          </h2>
          <div
            id="collapseBashrc"
            class="accordion-collapse collapse"
            data-bs-parent="#dotfilesAccordion"
          >
            <div class="accordion-body">
              <div class="code-block-container">
                <button class="copy-btn" onclick="copyToClipboard('bash-code')">Copy</button>
                <pre><code id="bash-code" class="language-bash"><?php echo htmlspecialchars(trim($bash_rc)); ?></code></pre>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="headingVimrc">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseVimrc"
            >
              <span class="icon">✏️</span>.vimrc
            </button>
          </h2>
          <div
            id="collapseVimrc"
            class="accordion-collapse collapse"
            data-bs-parent="#dotfilesAccordion"
          >
            <div class="accordion-body">
              <div class="code-block-container">
                <button class="copy-btn" onclick="copyToClipboard('vim-code')">Copy</button>
                <pre><code id="vim-code" class="language-vim"><?php echo htmlspecialchars(trim($vimrc)); ?></code></pre>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="headingI3">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseI3"
            >
              <span class="icon">🪟</span>i3_config
            </button>
          </h2>
          <div
            id="collapseI3"
            class="accordion-collapse collapse"
            data-bs-parent="#dotfilesAccordion"
          >
            <div class="accordion-body">
              <div class="code-block-container">
                <button class="copy-btn" onclick="copyToClipboard('i3-code')">Copy</button>
                <pre><code id="i3-code" class="language-bash"><?php echo htmlspecialchars(trim($i3)); ?></code></pre>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="headingPicom">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapsePicom"
            >
              <span class="icon">🎨</span>picom.conf
            </button>
          </h2>
          <div
            id="collapsePicom"
            class="accordion-collapse collapse"
            data-bs-parent="#dotfilesAccordion"
          >
            <div class="accordion-body">
              <div class="code-block-container">
                <button class="copy-btn" onclick="copyToClipboard('picom-code')">Copy</button>
                <pre><code id="picom-code" class="language-ini"><?php echo htmlspecialchars(trim($picom)); ?></code></pre>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="headingKitty">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseKitty"
            >
              <span class="icon">🐱</span>kitty.conf
            </button>
          </h2>
          <div
            id="collapseKitty"
            class="accordion-collapse collapse"
            data-bs-parent="#dotfilesAccordion"
          >
            <div class="accordion-body">
              <div class="code-block-container">
                <button class="copy-btn" onclick="copyToClipboard('kitty-code')">Copy</button>
                <pre><code id="kitty-code" class="language-bash"><?php echo htmlspecialchars(trim($kitty)); ?></code></pre>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="headingRofi">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseRofi"
            >
              <span class="icon">🔍</span>spotlight.rasi
            </button>
          </h2>
          <div
            id="collapseRofi"
            class="accordion-collapse collapse"
            data-bs-parent="#dotfilesAccordion"
          >
            <div class="accordion-body">
              <div class="code-block-container">
                <button class="copy-btn" onclick="copyToClipboard('rofi-code')">Copy</button>
                <pre><code id="rofi-code" class="language-css"><?php echo htmlspecialchars(trim($rofi)); ?></code></pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/prism.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/components/prism-bash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/components/prism-vim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/components/prism-css.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/components/prism-ini.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/plugins/autoloader/prism-autoloader.min.js"></script>
    <script>
      // Copy to clipboard functionality
      function copyToClipboard(elementId) {
        const codeElement = document.getElementById(elementId);
        const text = codeElement.textContent || codeElement.innerText;
        
        navigator.clipboard.writeText(text).then(function() {
          const button = event.target;
          const originalText = button.textContent;
          button.textContent = 'Copied!';
          button.classList.add('copied');
          
          setTimeout(function() {
            button.textContent = originalText;
            button.classList.remove('copied');
          }, 2000);
        }).catch(function(err) {
          console.error('Could not copy text: ', err);
        });
      }

      // Initialize Prism after DOM is loaded
      document.addEventListener('DOMContentLoaded', function() {
        Prism.highlightAll();
      });

      // Anime.js animations
      anime({
        targets: "#title",
        opacity: [0, 1],
        translateY: [-20, 0],
        easing: "easeOutExpo",
        duration: 800,
      });
      anime({
        targets: ".post",
        opacity: [0, 1],
        translateY: [15, 0],
        delay: anime.stagger(200, { start: 500 }),
        duration: 700,
        easing: "easeOutQuad",
      });
    </script>
  </body>
</html>
