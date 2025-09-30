/**
 * Theme Toggle System
 * Provides light/dark theme switching with localStorage persistence
 */

class ThemeToggle {
  constructor() {
    this.themeKey = "theme-preference";
    this.currentTheme = this.getStoredTheme() || this.getSystemTheme();
    this.init();
  }

  /**
   * Initialize the theme system
   */
  init() {
    this.applyTheme(this.currentTheme);
    this.createToggleButton();
    this.bindEvents();
    this.updateMetaThemeColor();
  }

  /**
   * Get stored theme preference from localStorage
   */
  getStoredTheme() {
    try {
      return localStorage.getItem(this.themeKey);
    } catch (e) {
      console.warn("Could not access localStorage:", e);
      return null;
    }
  }

  /**
   * Get system theme preference
   */
  getSystemTheme() {
    if (
      window.matchMedia &&
      window.matchMedia("(prefers-color-scheme: light)").matches
    ) {
      return "light";
    }
    return "dark";
  }

  /**
   * Store theme preference in localStorage
   */
  storeTheme(theme) {
    try {
      localStorage.setItem(this.themeKey, theme);
    } catch (e) {
      console.warn("Could not store theme preference:", e);
    }
  }

  /**
   * Apply theme to the document
   */
  applyTheme(theme) {
    const html = document.documentElement;

    // Remove existing theme classes
    html.removeAttribute("data-theme");

    // Apply new theme
    if (theme === "light") {
      html.setAttribute("data-theme", "light");
    }

    this.currentTheme = theme;
    this.storeTheme(theme);
    this.updateMetaThemeColor();

    // Dispatch custom event for other scripts
    window.dispatchEvent(
      new CustomEvent("themeChanged", {
        detail: { theme: theme },
      })
    );
  }

  /**
   * Update meta theme-color for mobile browsers
   */
  updateMetaThemeColor() {
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    if (!metaThemeColor) {
      metaThemeColor = document.createElement("meta");
      metaThemeColor.name = "theme-color";
      document.head.appendChild(metaThemeColor);
    }

    // Update theme color based on current theme
    metaThemeColor.content =
      this.currentTheme === "light" ? "#fbf1c7" : "#1d2021";
  }

  /**
   * Create the theme toggle button
   */
  createToggleButton() {
    // Check if toggle already exists
    if (document.querySelector(".theme-toggle")) {
      return;
    }

    const toggle = document.createElement("button");
    toggle.className = "theme-toggle";
    toggle.setAttribute("aria-label", "Toggle theme");
    toggle.setAttribute(
      "title",
      `Switch to ${this.currentTheme === "light" ? "dark" : "light"} theme`
    );

    const icon = document.createElement("i");
    icon.className =
      this.currentTheme === "light" ? "bi bi-moon-fill" : "bi bi-sun-fill";

    const text = document.createElement("span");
    text.className = "toggle-text";
    text.textContent = this.currentTheme === "light" ? "Dark" : "Light";

    toggle.appendChild(icon);
    toggle.appendChild(text);

    // Insert into navbar
    const navbar = document.querySelector(".navbar-nav");
    if (navbar) {
      const toggleItem = document.createElement("li");
      toggleItem.className = "nav-item";
      toggleItem.appendChild(toggle);
      navbar.appendChild(toggleItem);
    }
  }

  /**
   * Bind event listeners
   */
  bindEvents() {
    // Toggle button click
    document.addEventListener("click", (e) => {
      if (e.target.closest(".theme-toggle")) {
        e.preventDefault();
        this.toggleTheme();
      }
    });

    // Listen for system theme changes
    if (window.matchMedia) {
      const mediaQuery = window.matchMedia("(prefers-color-scheme: light)");
      mediaQuery.addEventListener("change", (e) => {
        // Only update if user hasn't set a preference
        if (!this.getStoredTheme()) {
          this.applyTheme(e.matches ? "light" : "dark");
          this.updateToggleButton();
        }
      });
    }

    // Keyboard shortcut (Ctrl/Cmd + Shift + T)
    document.addEventListener("keydown", (e) => {
      if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === "T") {
        e.preventDefault();
        this.toggleTheme();
      }
    });
  }

  /**
   * Toggle between light and dark themes
   */
  toggleTheme() {
    const newTheme = this.currentTheme === "light" ? "dark" : "light";
    this.applyTheme(newTheme);
    this.updateToggleButton();

    // Add a subtle animation effect
    document.body.style.transition = "none";
    setTimeout(() => {
      document.body.style.transition = "";
    }, 100);
  }

  /**
   * Update toggle button appearance
   */
  updateToggleButton() {
    const toggle = document.querySelector(".theme-toggle");
    if (!toggle) return;

    const icon = toggle.querySelector("i");
    const text = toggle.querySelector(".toggle-text");

    if (icon && text) {
      icon.className =
        this.currentTheme === "light" ? "bi bi-moon-fill" : "bi bi-sun-fill";
      text.textContent = this.currentTheme === "light" ? "Dark" : "Light";
      toggle.setAttribute(
        "title",
        `Switch to ${this.currentTheme === "light" ? "dark" : "light"} theme`
      );
    }
  }

  /**
   * Get current theme
   */
  getCurrentTheme() {
    return this.currentTheme;
  }

  /**
   * Set specific theme
   */
  setTheme(theme) {
    if (theme === "light" || theme === "dark") {
      this.applyTheme(theme);
      this.updateToggleButton();
    }
  }
}

// Initialize theme toggle when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  window.themeToggle = new ThemeToggle();
});

// Export for module systems
if (typeof module !== "undefined" && module.exports) {
  module.exports = ThemeToggle;
}
