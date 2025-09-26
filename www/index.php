<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lexi (0x800a6) - Software Developer</title>
    <meta
      name="description"
      content="Software Developer passionate about systems programming and web technologies. Building efficient systems and meaningful digital experiences."
    />
    <meta
      name="keywords"
      content="software developer, systems programming, web technologies, TypeScript, React, Go, Rust, open source"
    />
    <meta name="author" content="Lexi (0x800a6)" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#0a0a0a" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://lrr.sh/" />
    <meta property="og:title" content="Lexi (0x800a6) - Software Developer" />
    <meta
      property="og:description"
      content="Software Developer passionate about systems programming and web technologies"
    />
    <meta property="og:image" content="https://lrr.sh/static/images/og-image.png" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://lrr.sh/" />
    <meta
      property="twitter:title"
      content="Lexi (0x800a6) - Software Developer"
    />
    <meta
      property="twitter:description"
      content="Software Developer passionate about systems programming and web technologies"
    />
    <meta property="twitter:image" content="https://lrr.sh/static/images/og-image.png" />

    <link rel="stylesheet" href="/static/css/styles.css" />
    <link rel="stylesheet" href="/static/css/vendor/bootstrap-icons.css" />
    <link
      href="/static/css/vendor/fonts/JetBrainsMono-Inter.css"
      rel="stylesheet"
    />
    <link rel="canonical" href="https://lrr.sh/" />
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
              <span class="title-line">Hi, I'm</span>
              <span class="title-name">Lexi</span>
              <span class="title-subtitle">Software Developer</span>
            </h1>
            <p class="hero-description">
              Passionate about
              <span class="highlight">systems programming</span> and
              <span class="highlight">web technologies</span>. Building
              efficient systems and meaningful digital experiences.
            </p>
            <div class="hero-actions">
              <a
                href="#projects"
                class="btn btn-primary"
                aria-label="View my featured projects"
                >View Projects</a
              >
              <a
                href="#contact"
                class="btn btn-secondary"
                aria-label="Get in touch with me"
                >Get In Touch</a
              >
            </div>
          </div>
          <div class="hero-terminal">
            <div
              class="terminal-window"
              role="img"
              aria-label="Interactive terminal showing developer information"
            >
              <div class="terminal-header">
                <div class="terminal-buttons" aria-hidden="true">
                  <span class="btn-close"></span>
                  <span class="btn-minimize"></span>
                  <span class="btn-maximize"></span>
                </div>
                <span class="terminal-title">lexi@0x800a6:~$</span>
              </div>
              <div class="terminal-body" id="terminal-body">
                <div class="terminal-line">
                  <span class="prompt">$</span>
                  <span class="command">whoami</span>
                </div>
                <div class="terminal-output">
                  Software Developer | Systems Programmer | Open Source
                  Contributor
                </div>
                <div class="terminal-line">
                  <span class="prompt">$</span>
                  <span class="command">cat skills.txt</span>
                </div>
                <div class="terminal-output">
                  Go • Rust • C • TypeScript • React • Next.js
                </div>
                <div class="terminal-line">
                  <span class="prompt">$</span>
                  <span class="command">ls projects/</span>
                </div>
                <div class="terminal-output">
                  file_uploader/ website/ vtubers-tv/ open-source/
                </div>
                <div class="terminal-line">
                  <span class="prompt">$</span>
                  <span
                    class="command typing"
                    id="typing-command"
                    aria-live="polite"
                  ></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- About Section -->
      <section class="about" id="about" aria-labelledby="about-title">
        <div class="container">
          <h2 class="section-title" id="about-title">
            <span class="title-number">01</span>
            About Me
          </h2>
          <div class="about-content">
            <div class="about-text">
              <p>
                I'm Lexi (aka <strong>0x800a6</strong>), a software developer
                who loves building efficient systems and meaningful digital
                experiences. My journey began in 2020, evolving into a focus on
                <em>systems programming</em>, <em>performance optimization</em>,
                and <em>modern web technologies</em>.
              </p>
              <p>
                I founded <strong>vtubers.tv</strong>, where I architect
                platform services, design robust TypeScript type systems and
                utilities, and thrive on collaborating with the open source
                community to push boundaries together.
              </p>
              <div class="stats">
                <div class="stat glare">
                  <span class="stat-number">26+</span>
                  <span class="stat-label">Repositories</span>
                </div>
                <div class="stat glare">
                  <span class="stat-number">160+</span>
                  <span class="stat-label">GitHub Stars</span>
                </div>
                <div class="stat glare">
                  <span class="stat-number">2020</span>
                  <span class="stat-label">Started Coding</span>
                </div>
              </div>
            </div>
            <div class="about-visual">
              <div class="code-block">
                <div class="code-header">
                  <span class="code-title">lexi.asm</span>
                </div>
                <div class="code-content">
                  <pre><code><span class="comment">; x86-64 Assembly - Developer Profile</span>
<span class="comment">; Lexi (0x800a6) - Systems Programming</span>

<span class="keyword">section</span> <span class="string">.data</span>
    <span class="variable">name</span>        <span class="keyword">db</span> <span class="string">'Lexi'</span>, <span class="number">0</span>
    <span class="variable">handle</span>      <span class="keyword">db</span> <span class="string">'0x800a6'</span>, <span class="number">0</span>
    <span class="variable">passion</span>     <span class="keyword">db</span> <span class="string">'Systems Programming'</span>, <span class="number">0</span>
    <span class="variable">message</span>     <span class="keyword">db</span> <span class="string">'Building the future, one line at a time'</span>, <span class="number">0</span>
    <span class="variable">skills</span>      <span class="keyword">db</span> <span class="string">'Assembly, Rust, C, TypeScript'</span>, <span class="number">0</span>

<span class="keyword">section</span> <span class="string">.text</span>
    <span class="keyword">global</span> <span class="function">_start</span>

<span class="function">_start</span>:
    <span class="keyword">mov</span> <span class="variable">rax</span>, <span class="number">1</span>
    <span class="keyword">mov</span> <span class="variable">rdi</span>, <span class="number">1</span>
    <span class="keyword">mov</span> <span class="variable">rsi</span>, <span class="variable">message</span>
    <span class="keyword">mov</span> <span class="variable">rdx</span>, <span class="number">38</span>
    <span class="keyword">syscall</span>

    <span class="keyword">mov</span> <span class="variable">rax</span>, <span class="number">60</span>
    <span class="keyword">mov</span> <span class="variable">rdi</span>, <span class="number">0</span>
    <span class="keyword">syscall</span></code></pre>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Projects Section -->
      <section class="projects" id="projects">
        <div class="container">
          <h2 class="section-title">
            <span class="title-number">02</span>
            Featured Projects
          </h2>
          <div class="projects-grid">
            <!-- VTubersTV Project -->
            <div class="project-card glare" data-project="vtubers">
              <div class="project-header">
                <h3 class="project-title">VTubersTV Platform</h3>
                <div class="project-status">Current</div>
              </div>
              <div class="project-description">
                Developing and maintaining scalable backend services for a
                high-traffic VTuber platform. Leading TypeScript type definition
                efforts and improving developer tooling.
              </div>
              <div class="project-tech">
                <span class="tech-tag">TypeScript</span>
                <span class="tech-tag">React</span>
                <span class="tech-tag">Node.js</span>
                <span class="tech-tag">Docker</span>
              </div>
              <div class="project-demo">
                <div class="demo-window">
                  <div class="demo-header">
                    <span class="demo-title">Platform Services</span>
                  </div>
                  <div class="demo-content">
                    <div class="demo-line">
                      <i class="bi bi-check-circle-fill"></i> Backend API
                      Services
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-check-circle-fill"></i> Type Definitions
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-check-circle-fill"></i> Developer Tools
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-check-circle-fill"></i> Open Source
                      Collaboration
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- File Uploader Project -->
            <div class="project-card glare" data-project="uploader">
              <div class="project-header">
                <h3 class="project-title">file_uploader</h3>
                <div class="project-status">Open Source</div>
              </div>
              <div class="project-description">
                Simple and secure file upload service with a focus on privacy
                and ease of use. Built with PHP and designed for developers who
                value security.
              </div>
              <div class="project-tech">
                <span class="tech-tag">PHP</span>
                <span class="tech-tag">Security</span>
                <span class="tech-tag">Privacy</span>
                <span class="tech-tag">Apache2</span>
              </div>
              <div class="project-demo">
                <div class="demo-window">
                  <div class="demo-header">
                    <span class="demo-title">Upload Service</span>
                  </div>
                  <div class="demo-content">
                    <div class="demo-line">$ curl -X POST upload.php</div>
                    <div class="demo-line">
                      <i class="bi bi-check-circle-fill"></i> File validation
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-check-circle-fill"></i> Security checks
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-check-circle-fill"></i> Privacy focused
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Website Project -->
            <div class="project-card glare" data-project="website">
              <div class="project-header">
                <h3 class="project-title">Personal Website</h3>
                <div class="project-status">Portfolio</div>
              </div>
              <div class="project-description">
                Personal website and blog platform, built with performance and
                SEO in mind. Features a hacker-themed design with privacy-first
                principles.
              </div>
              <div class="project-tech">
                <span class="tech-tag">HTML5</span>
                <span class="tech-tag">CSS3</span>
                <span class="tech-tag">JavaScript</span>
                <span class="tech-tag">Privacy</span>
              </div>
              <div class="project-demo">
                <div class="demo-window">
                  <div class="demo-header">
                    <span class="demo-title">Performance Metrics</span>
                  </div>
                  <div class="demo-content">
                    <div class="demo-line">
                      <i class="bi bi-lightning-fill"></i> 100% Lighthouse Score
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-lock-fill"></i> No Trackers
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-phone"></i> Responsive Design
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-universal-access"></i> Accessible
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Open Source Contributions -->
            <div class="project-card glare" data-project="opensource">
              <div class="project-header">
                <h3 class="project-title">Open Source</h3>
                <div class="project-status">Contributor</div>
              </div>
              <div class="project-description">
                Active contributor to 25+ public repositories, focusing on
                systems, web, and developer tools. Advocate for privacy,
                security, and open standards.
              </div>
              <div class="project-tech">
                <span class="tech-tag">Go</span>
                <span class="tech-tag">Rust</span>
                <span class="tech-tag">TypeScript</span>
                <span class="tech-tag">Community</span>
              </div>
              <div class="project-demo">
                <div class="demo-window">
                  <div class="demo-header">
                    <span class="demo-title">GitHub Stats</span>
                  </div>
                  <div class="demo-content">
                    <div class="demo-line">
                      <i class="bi bi-bar-chart-fill"></i> 25+ Repositories
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-star-fill"></i> 160+ Stars
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-tools"></i> Developer Tools
                    </div>
                    <div class="demo-line">
                      <i class="bi bi-globe"></i> Web Technologies
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Skills Section -->
      <section class="skills" id="skills">
        <div class="container">
          <h2 class="section-title">
            <span class="title-number">03</span>
            Technical Skills
          </h2>
          <div class="skills-content">
            <div class="skills-categories">
              <div class="skill-category glare">
                <h3 class="category-title">Systems</h3>
                <div class="skill-items">
                  <div class="skill-item" data-skill="go">
                    <span class="skill-name">Go</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="90"></div>
                    </div>
                  </div>
                  <div class="skill-item" data-skill="rust">
                    <span class="skill-name">Rust</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="85"></div>
                    </div>
                  </div>
                  <div class="skill-item" data-skill="c">
                    <span class="skill-name">C</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="80"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="skill-category glare">
                <h3 class="category-title">Web</h3>
                <div class="skill-items">
                  <div class="skill-item" data-skill="typescript">
                    <span class="skill-name">TypeScript</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="95"></div>
                    </div>
                  </div>
                  <div class="skill-item" data-skill="react">
                    <span class="skill-name">React</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="90"></div>
                    </div>
                  </div>
                  <div class="skill-item" data-skill="nextjs">
                    <span class="skill-name">Next.js</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="85"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="skill-category glare">
                <h3 class="category-title">Tools</h3>
                <div class="skill-items">
                  <div class="skill-item" data-skill="docker">
                    <span class="skill-name">Docker</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="85"></div>
                    </div>
                  </div>
                  <div class="skill-item" data-skill="linux">
                    <span class="skill-name">Linux</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="90"></div>
                    </div>
                  </div>
                  <div class="skill-item" data-skill="vim">
                    <span class="skill-name">Vim</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="80"></div>
                    </div>
                  </div>
                  <div class="skill-item" data-skill="git">
                    <span class="skill-name">Git</span>
                    <div class="skill-bar">
                      <div class="skill-progress" data-width="95"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="skills-visual">
              <div class="network-diagram glare">
                <div class="node node-main" data-node="main">
                  <span>Lexi</span>
                </div>
                <div class="node node-skill" data-node="systems">
                  <span>Systems</span>
                </div>
                <div class="node node-skill" data-node="web">
                  <span>Web</span>
                </div>
                <div class="node node-skill" data-node="tools">
                  <span>Tools</span>
                </div>
                <svg
                  class="connections"
                  viewBox="0 0 100 100"
                  preserveAspectRatio="none"
                >
                  <line
                    x1="50"
                    y1="50"
                    x2="20"
                    y2="20"
                    class="connection"
                  ></line>
                  <line
                    x1="50"
                    y1="50"
                    x2="80"
                    y2="20"
                    class="connection"
                  ></line>
                  <line
                    x1="50"
                    y1="50"
                    x2="50"
                    y2="80"
                    class="connection"
                  ></line>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section class="contact" id="contact">
        <div class="container">
          <h2 class="section-title">
            <span class="title-number">04</span>
            Get In Touch
          </h2>
          <div class="contact-content">
            <div class="contact-info">
              <h3>Let's Connect</h3>
              <p>
                Interested in collaborating on a project? Have questions about
                my work? I'm always open to discussing new opportunities and
                interesting problems.
              </p>
              <div class="contact-methods">
                <a href="mailto:lexi@lrr.sh" class="contact-method glare">
                  <div class="method-icon">
                    <i class="bi bi-envelope-fill"></i>
                  </div>
                  <div class="method-info">
                    <span class="method-label">Email</span>
                    <span class="method-value">lexi@lrr.sh</span>
                  </div>
                </a>
                <a
                  href="https://github.com/0x800a6"
                  class="contact-method glare"
                  target="_blank"
                  rel="noopener"
                >
                  <div class="method-icon"><i class="bi bi-github"></i></div>
                  <div class="method-info">
                    <span class="method-label">GitHub</span>
                    <span class="method-value">github.com/0x800a6</span>
                  </div>
                </a>
                <div class="contact-method glare">
                  <div class="method-icon"><i class="bi bi-key-fill"></i></div>
                  <div class="method-info">
                    <span class="method-label">PGP Key</span>
                    <a
                      href="/static/pgp_key.txt"
                      class="method-value"
                      style="text-decoration: none; color: inherit"
                      target="_blank"
                      rel="noopener"
                      >CBBCF7CA2AB792900F7D770A5C0C5E888156C86B</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="contact-terminal">
              <div class="terminal-window">
                <div class="terminal-header">
                  <div class="terminal-buttons">
                    <span class="btn-close"></span>
                    <span class="btn-minimize"></span>
                    <span class="btn-maximize"></span>
                  </div>
                  <span class="terminal-title">contact@0x800a6:~$</span>
                </div>
                <div class="terminal-body">
                  <div class="terminal-line">
                    <span class="prompt">$</span>
                    <span class="command">echo "Ready to collaborate?"</span>
                  </div>
                  <div class="terminal-output">Ready to collaborate?</div>
                  <div class="terminal-line">
                    <span class="prompt">$</span>
                    <span class="command"
                      >send_message --to lexi@lrr.sh</span
                    >
                  </div>
                  <div class="terminal-output">
                    Message queued for delivery...
                  </div>
                  <div class="terminal-line">
                    <span class="prompt">$</span>
                    <span class="command">verify_pgp --key CBBCF7CA</span>
                  </div>
                  <div class="terminal-output">
                    <i class="bi bi-check-circle-fill"></i> PGP key verified
                  </div>
                  <div class="terminal-line">
                    <span class="prompt">$</span>
                    <span class="command cursor-blink">_</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Privacy Notice -->
      <section class="privacy" id="privacy">
        <div class="container">
          <div class="privacy-content">
            <h3>Privacy First</h3>
            <p>
              <strong
                >No trackers. No analytics. No cookies. No scripts from
                strangers.</strong
              >
            </p>
            <ul>
              <li>This site does not log your IP address</li>
              <li>
                This site does not use Google Analytics or Facebook pixels
              </li>
              <li>
                This site does not load fonts or scripts from outside servers
              </li>
              <li>This site does not fingerprint your browser</li>
              <li>This site does not care who you are</li>
            </ul>
            <div class="privacy-actions">
              <a
                href="/privacy-manifesto"
                class="btn btn-secondary"
                aria-label="Read my complete privacy manifesto"
                >Read Privacy Manifesto</a
              >
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
