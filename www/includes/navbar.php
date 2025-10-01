<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-warning" href="/">
      <span class="brand-symbol">λ</span> Lexi
    </a>

    <!-- Toggler -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navlinks"
      aria-controls="navlinks"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nav links -->
    <div class="collapse navbar-collapse" id="navlinks">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link px-3" href="/#projects">Projects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="/posts">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="/resume">Resume</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="/#about">About</a>
        </li>
        <li class="nav-item d-flex align-items-center gap-2" style="padding-right: 0.75rem;">
          <a href="https://github.com/sponsors/0x800a6" target="_blank" rel="noopener noreferrer" class="social-link" title="Sponsor" style="font-size: 0.95em; padding: 0.2em 0.4em;">
            <i class="bi bi-heart" fill="var(--red)" style="font-size: 1em;"></i>
            <span style="font-size: 0.95em;">Sponsor</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  /* Gruvbox Dark inspired */
  .navbar {
    background-color: var(--bg) !important;
  }

  .navbar-brand {
    color: var(--yellow) !important;
    /* yellow from Gruvbox */
  }

  .navbar-brand .brand-symbol {
    font-family: monospace;
    font-weight: 700;
    color: var(--purple);
    /* pink/purple accent */
    margin-right: 4px;
  }

  .navbar-nav .nav-link {
    color: var(--fg) !important;
    transition: color 0.2s ease;
  }

  .navbar-nav .nav-link:hover {
    color: var(--yellow) !important;
  }

  .navbar-toggler {
    border: 2px solid var(--yellow);
    border-radius: 6px;
    padding: 0.4rem 0.6rem;
    background: transparent;
    transition: all 0.2s ease;
  }

  .navbar-toggler:hover {
    background: var(--border);
    border-color: var(--aqua);
  }

  .navbar-toggler:focus {
    box-shadow: 0 0 0 0.2rem var(--yellow);
    opacity: 0.25;
  }

  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23fabd2f' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    width: 1.2em;
    height: 1.2em;
  }
</style>

<!-- Theme Toggle Script -->
<script src="/static/js/theme-toggle.js"></script>