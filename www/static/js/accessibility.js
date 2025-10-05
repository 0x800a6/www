/**
 * Accessibility Enhancement Script
 * Provides additional accessibility features and improvements
 */

(function () {
  "use strict";

  // Initialize accessibility features when DOM is ready
  document.addEventListener("DOMContentLoaded", function () {
    initAccessibilityFeatures();
  });

  function initAccessibilityFeatures() {
    // Add keyboard navigation for dropdowns
    enhanceDropdownNavigation();

    // Add focus management for modals
    enhanceModalAccessibility();

    // Add announcement region for dynamic content
    addAnnouncementRegion();

    // Enhance form accessibility
    enhanceFormAccessibility();

    // Add reduced motion support
    addReducedMotionSupport();
  }

  /**
   * Enhance dropdown navigation with keyboard support
   */
  function enhanceDropdownNavigation() {
    const dropdowns = document.querySelectorAll(".dropdown");

    dropdowns.forEach(function (dropdown) {
      const toggle = dropdown.querySelector('[data-bs-toggle="dropdown"]');
      const menu = dropdown.querySelector(".dropdown-menu");

      if (!toggle || !menu) return;

      // Handle keyboard navigation
      toggle.addEventListener("keydown", function (e) {
        if (e.key === "ArrowDown" || e.key === "ArrowUp") {
          e.preventDefault();
          const items = menu.querySelectorAll(".dropdown-item");
          if (items.length > 0) {
            const firstItem = items[0];
            firstItem.focus();
          }
        }
      });

      // Handle menu item navigation
      const menuItems = menu.querySelectorAll(".dropdown-item");
      menuItems.forEach(function (item, index) {
        item.addEventListener("keydown", function (e) {
          switch (e.key) {
            case "ArrowDown":
              e.preventDefault();
              const nextItem = menuItems[index + 1] || menuItems[0];
              nextItem.focus();
              break;
            case "ArrowUp":
              e.preventDefault();
              const prevItem =
                menuItems[index - 1] || menuItems[menuItems.length - 1];
              prevItem.focus();
              break;
            case "Escape":
              e.preventDefault();
              toggle.focus();
              toggle.click();
              break;
          }
        });
      });
    });
  }

  /**
   * Enhance modal accessibility
   */
  function enhanceModalAccessibility() {
    const modals = document.querySelectorAll(".modal");

    modals.forEach(function (modal) {
      // Store reference to previously focused element
      let previousFocus;

      modal.addEventListener("shown.bs.modal", function () {
        previousFocus = document.activeElement;

        // Focus the modal's first focusable element
        const focusableElements = modal.querySelectorAll(
          'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        if (focusableElements.length > 0) {
          focusableElements[0].focus();
        }

        // Trap focus within modal
        trapFocus(modal);
      });

      modal.addEventListener("hidden.bs.modal", function () {
        // Return focus to previously focused element
        if (previousFocus) {
          previousFocus.focus();
        }
      });
    });
  }

  /**
   * Trap focus within an element
   */
  function trapFocus(element) {
    const focusableElements = element.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );

    const firstFocusableElement = focusableElements[0];
    const lastFocusableElement =
      focusableElements[focusableElements.length - 1];

    element.addEventListener("keydown", function (e) {
      if (e.key === "Tab") {
        if (e.shiftKey) {
          if (document.activeElement === firstFocusableElement) {
            lastFocusableElement.focus();
            e.preventDefault();
          }
        } else {
          if (document.activeElement === lastFocusableElement) {
            firstFocusableElement.focus();
            e.preventDefault();
          }
        }
      }
    });
  }

  /**
   * Add announcement region for screen readers
   */
  function addAnnouncementRegion() {
    let announcementRegion = document.getElementById("announcement-region");

    if (!announcementRegion) {
      announcementRegion = document.createElement("div");
      announcementRegion.id = "announcement-region";
      announcementRegion.setAttribute("aria-live", "polite");
      announcementRegion.setAttribute("aria-atomic", "true");
      announcementRegion.className = "sr-only";
      document.body.appendChild(announcementRegion);
    }

    // Add method to announce messages
    window.announceToScreenReader = function (message) {
      announcementRegion.textContent = message;
      setTimeout(function () {
        announcementRegion.textContent = "";
      }, 1000);
    };
  }

  /**
   * Enhance form accessibility
   */
  function enhanceFormAccessibility() {
    const forms = document.querySelectorAll("form");

    forms.forEach(function (form) {
      const inputs = form.querySelectorAll("input, select, textarea");

      inputs.forEach(function (input) {
        // Add error handling
        input.addEventListener("invalid", function () {
          this.setAttribute("aria-invalid", "true");
        });

        input.addEventListener("input", function () {
          if (this.checkValidity()) {
            this.setAttribute("aria-invalid", "false");
          }
        });
      });
    });
  }

  /**
   * Add reduced motion support
   */
  function addReducedMotionSupport() {
    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia(
      "(prefers-reduced-motion: reduce)"
    );

    function handleReducedMotion() {
      if (prefersReducedMotion.matches) {
        document.documentElement.style.setProperty(
          "--transition-duration",
          "0.01ms"
        );
        document.documentElement.style.setProperty(
          "--animation-duration",
          "0.01ms"
        );
      } else {
        document.documentElement.style.removeProperty("--transition-duration");
        document.documentElement.style.removeProperty("--animation-duration");
      }
    }

    // Apply on load
    handleReducedMotion();

    // Listen for changes
    prefersReducedMotion.addEventListener("change", handleReducedMotion);
  }

  /**
   * Add high contrast mode support
   */
  function addHighContrastSupport() {
    const prefersHighContrast = window.matchMedia("(prefers-contrast: high)");

    function handleHighContrast() {
      if (prefersHighContrast.matches) {
        document.documentElement.classList.add("high-contrast");
      } else {
        document.documentElement.classList.remove("high-contrast");
      }
    }

    // Apply on load
    handleHighContrast();

    // Listen for changes
    prefersHighContrast.addEventListener("change", handleHighContrast);
  }

  // Initialize high contrast support
  addHighContrastSupport();
})();
