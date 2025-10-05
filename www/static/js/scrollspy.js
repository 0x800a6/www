/**
 * Enhanced Scrollspy Functionality
 * Provides additional features beyond Bootstrap's default scrollspy
 */

(function () {
  "use strict";

  // Initialize enhanced scrollspy when DOM is ready
  document.addEventListener("DOMContentLoaded", function () {
    initEnhancedScrollspy();
  });

  function initEnhancedScrollspy() {
    // Initialize Bootstrap scrollspy
    const scrollSpyElement = document.querySelector('[data-bs-spy="scroll"]');
    if (scrollSpyElement) {
      // Initialize Bootstrap ScrollSpy
      const scrollSpy = new bootstrap.ScrollSpy(scrollSpyElement, {
        target: "#navigation",
        offset: 100,
      });

      // Add custom scrollspy enhancements
      addScrollspyEnhancements();
      addProgressIndicator();
      addScrollToTopButton();
    }
  }

  /**
   * Add custom scrollspy enhancements
   */
  function addScrollspyEnhancements() {
    const navLinks = document.querySelectorAll(
      '#navigation .nav-link[href^="#"]'
    );
    const sections = document.querySelectorAll("section[id], header[id]");

    // Handle click events for smooth scrolling
    navLinks.forEach(function (link) {
      link.addEventListener("click", function (e) {
        const href = this.getAttribute("href");
        if (href.startsWith("#")) {
          const targetId = href.substring(1);
          const targetElement = document.getElementById(targetId);

          if (targetElement) {
            e.preventDefault();

            // Smooth scroll to target
            targetElement.scrollIntoView({
              behavior: "smooth",
              block: "start",
            });

            // Update URL without jumping
            if (history.pushState) {
              history.pushState(null, null, href);
            }

            // Announce section change to screen readers
            if (window.announceToScreenReader) {
              const sectionTitle =
                targetElement.querySelector("h1, h2, h3") || targetElement;
              const title = sectionTitle.textContent || targetId;
              window.announceToScreenReader(`Navigated to ${title} section`);
            }
          }
        }
      });
    });

    // Add scroll event listener for custom active state management
    let ticking = false;
    function updateActiveSection() {
      const scrollPosition = window.scrollY + 150; // Offset for navbar

      sections.forEach(function (section) {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        const sectionId = section.getAttribute("id");

        if (
          scrollPosition >= sectionTop &&
          scrollPosition < sectionTop + sectionHeight
        ) {
          // Remove active class from all nav links
          navLinks.forEach(function (link) {
            link.classList.remove("active");
          });

          // Add active class to corresponding nav link
          const activeLink = document.querySelector(
            `#navigation .nav-link[href="#${sectionId}"]`
          );
          if (activeLink) {
            activeLink.classList.add("active");
          }
        }
      });

      ticking = false;
    }

    function requestTick() {
      if (!ticking) {
        requestAnimationFrame(updateActiveSection);
        ticking = true;
      }
    }

    window.addEventListener("scroll", requestTick);
  }

  /**
   * Add reading progress indicator
   */
  function addProgressIndicator() {
    // Create progress bar
    const progressBar = document.createElement("div");
    progressBar.id = "scroll-progress";
    progressBar.className = "scroll-progress-bar";
    progressBar.setAttribute("role", "progressbar");
    progressBar.setAttribute("aria-label", "Reading progress");
    progressBar.setAttribute("aria-valuemin", "0");
    progressBar.setAttribute("aria-valuemax", "100");
    progressBar.setAttribute("aria-valuenow", "0");

    document.body.appendChild(progressBar);

    // Update progress on scroll
    let ticking = false;
    function updateProgress() {
      const scrollTop =
        window.pageYOffset || document.documentElement.scrollTop;
      const scrollHeight =
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight;
      const scrollPercent = (scrollTop / scrollHeight) * 100;

      progressBar.style.width = scrollPercent + "%";
      progressBar.setAttribute("aria-valuenow", Math.round(scrollPercent));

      ticking = false;
    }

    function requestProgressUpdate() {
      if (!ticking) {
        requestAnimationFrame(updateProgress);
        ticking = true;
      }
    }

    window.addEventListener("scroll", requestProgressUpdate);
  }

  /**
   * Add scroll to top button
   */
  function addScrollToTopButton() {
    // Create scroll to top button
    const scrollToTopBtn = document.createElement("button");
    scrollToTopBtn.id = "scroll-to-top";
    scrollToTopBtn.className = "scroll-to-top-btn";
    scrollToTopBtn.setAttribute("aria-label", "Scroll to top");
    scrollToTopBtn.setAttribute("title", "Scroll to top");
    scrollToTopBtn.innerHTML =
      '<i class="bi bi-arrow-up" aria-hidden="true"></i>';

    document.body.appendChild(scrollToTopBtn);

    // Show/hide button based on scroll position
    let ticking = false;
    function toggleScrollToTop() {
      const scrollTop =
        window.pageYOffset || document.documentElement.scrollTop;

      if (scrollTop > 300) {
        scrollToTopBtn.classList.add("visible");
      } else {
        scrollToTopBtn.classList.remove("visible");
      }

      ticking = false;
    }

    function requestScrollToggle() {
      if (!ticking) {
        requestAnimationFrame(toggleScrollToTop);
        ticking = true;
      }
    }

    window.addEventListener("scroll", requestScrollToggle);

    // Add click handler
    scrollToTopBtn.addEventListener("click", function () {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });

      // Focus the skip link after scrolling
      setTimeout(function () {
        const skipLink = document.querySelector(
          '.skip-link[href="#main-content"]'
        );
        if (skipLink) {
          skipLink.focus();
        }
      }, 500);

      // Announce to screen readers
      if (window.announceToScreenReader) {
        window.announceToScreenReader("Scrolled to top of page");
      }
    });

    // Handle keyboard navigation
    scrollToTopBtn.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        this.click();
      }
    });
  }

  /**
   * Add section navigation for long pages
   */
  function addSectionNavigation() {
    const longPages = ["projects", "resume"];
    const currentPage = window.location.pathname.split("/").pop() || "index";

    if (longPages.includes(currentPage)) {
      const sections = document.querySelectorAll("section[id]");

      if (sections.length > 3) {
        // Create section navigation
        const sectionNav = document.createElement("nav");
        sectionNav.className = "section-navigation";
        sectionNav.setAttribute("aria-label", "Section navigation");

        const navList = document.createElement("ul");
        navList.className = "section-nav-list";

        sections.forEach(function (section) {
          const sectionId = section.getAttribute("id");
          const sectionTitle = section.querySelector("h1, h2, h3");

          if (sectionTitle && sectionId) {
            const listItem = document.createElement("li");
            const link = document.createElement("a");
            link.href = `#${sectionId}`;
            link.textContent = sectionTitle.textContent;
            link.className = "section-nav-link";

            link.addEventListener("click", function (e) {
              e.preventDefault();
              section.scrollIntoView({
                behavior: "smooth",
                block: "start",
              });
            });

            listItem.appendChild(link);
            navList.appendChild(listItem);
          }
        });

        sectionNav.appendChild(navList);

        // Insert after main content
        const mainContent = document.querySelector("#main-content");
        if (mainContent) {
          mainContent.appendChild(sectionNav);
        }
      }
    }
  }

  // Initialize section navigation for appropriate pages
  addSectionNavigation();
})();
