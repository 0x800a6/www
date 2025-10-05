/**
 * Theme Toggle System
 * Provides light/dark theme switching with cookie persistence
 */

if (window.themeToggle) {
  // Do nothing - script already loaded
} else {
  class ThemeToggle {
    constructor() {
      this.themeKey = "theme-preference";
      this.currentTheme = this.getStoredTheme() || this.getSystemTheme();
      this.init();
    }

    /**
     * Get cookie value by name
     */
    getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) {
        return parts.pop().split(";").shift();
      }
      return null;
    }

    /**
     * Set cookie with name, value, and expiration
     */
    setCookie(name, value, days = 365) {
      const expires = new Date();
      expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
      document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
    }

    /**
     * Delete cookie by name
     */
    deleteCookie(name) {
      document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;`;
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
     * Get stored theme preference from cookies
     */
    getStoredTheme() {
      try {
        return this.getCookie(this.themeKey);
      } catch (e) {
        console.warn("Could not access cookies:", e);
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
     * Store theme preference in cookies
     */
    storeTheme(theme) {
      try {
        this.setCookie(this.themeKey, theme);
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
      toggle.setAttribute(
        "aria-label",
        `Switch to ${this.currentTheme === "light" ? "dark" : "light"} theme`
      );
      toggle.setAttribute(
        "title",
        `Switch to ${this.currentTheme === "light" ? "dark" : "light"} theme`
      );
      toggle.setAttribute(
        "aria-pressed",
        this.currentTheme === "light" ? "false" : "true"
      );

      const icon = document.createElement("i");
      icon.className =
        this.currentTheme === "light" ? "bi bi-moon-fill" : "bi bi-sun-fill";
      icon.setAttribute("aria-hidden", "true");

      toggle.appendChild(icon);

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
      const toggles = document.querySelectorAll(".theme-toggle");

      toggles.forEach((toggle) => {
        const icon = toggle.querySelector("i");
        const text = toggle.querySelector(".theme-text");

        if (icon) {
          icon.className =
            this.currentTheme === "light"
              ? "bi bi-moon-fill"
              : "bi bi-sun-fill";
          icon.setAttribute("aria-hidden", "true");
          toggle.setAttribute(
            "aria-label",
            `Switch to ${
              this.currentTheme === "light" ? "dark" : "light"
            } theme`
          );
          toggle.setAttribute(
            "title",
            `Switch to ${
              this.currentTheme === "light" ? "dark" : "light"
            } theme`
          );
          toggle.setAttribute(
            "aria-pressed",
            this.currentTheme === "light" ? "false" : "true"
          );
        }

        if (text) {
          text.textContent = this.currentTheme === "light" ? "Dark" : "Light";
        }
      });
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
} // End of else block
