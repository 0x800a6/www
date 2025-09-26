// ===== PORTFOLIO ANIMATIONS & INTERACTIONS =====
// Built with anime.js for smooth, performant animations

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all animations and interactions
    try {
        initTerminalAnimations();
        initScrollAnimations();
        initSkillBars();
        initGlareEffect();
        initProjectCards();
        initNetworkDiagram();
        initNavigation();
        initTypingEffect();
        initPerformanceOptimizations();
        initAccessibility();
    } catch (error) {
        console.error('Error initializing portfolio:', error);
        // Gracefully degrade if animations fail
        document.body.classList.add('animations-disabled');
    }
});


// ===== TERMINAL ANIMATIONS =====
function initTerminalAnimations() {
    const terminalBody = document.getElementById('terminal-body');
    if (!terminalBody || typeof anime === 'undefined') return;

    // Animate terminal lines appearing
    const terminalLines = terminalBody.querySelectorAll('.terminal-line, .terminal-output');
    
    if (terminalLines.length === 0) return;
    
    try {
        anime({
            targets: terminalLines,
            opacity: [0, 1],
            translateY: [20, 0],
            delay: anime.stagger(500, {start: 1000}),
            duration: 800,
            easing: 'easeOutExpo'
        });
    } catch (error) {
        console.warn('Terminal animation failed:', error);
        // Fallback: show lines immediately
        terminalLines.forEach(line => {
            line.style.opacity = '1';
            line.style.transform = 'translateY(0)';
        });
    }
}

// ===== SCROLL ANIMATIONS =====
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Add animation classes to elements
    const animatedElements = [
        { selector: '.hero-content', class: 'fade-in' },
        { selector: '.hero-terminal', class: 'slide-in-right' },
        { selector: '.about-text', class: 'slide-in-left' },
        { selector: '.about-visual', class: 'slide-in-right' },
        { selector: '.project-card', class: 'scale-in' },
        { selector: '.skill-category', class: 'fade-in' },
        { selector: '.contact-info', class: 'slide-in-left' },
        { selector: '.contact-terminal', class: 'slide-in-right' }
    ];

    animatedElements.forEach(({ selector, class: animClass }) => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(el => {
            el.classList.add(animClass);
            observer.observe(el);
        });
    });

    // Animate section titles
    const sectionTitles = document.querySelectorAll('.section-title');
    sectionTitles.forEach(title => {
        title.classList.add('fade-in');
        observer.observe(title);
    });
}

// ===== SKILL BARS ANIMATION =====
function initSkillBars() {
    const skillBars = document.querySelectorAll('.skill-progress');
    
    const skillObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                const width = progressBar.dataset.width;
                
                anime({
                    targets: progressBar,
                    width: `${width}%`,
                    duration: 1500,
                    easing: 'easeOutExpo',
                    delay: 200
                });
            }
        });
    }, { threshold: 0.5 });

    skillBars.forEach(bar => {
        skillObserver.observe(bar);
    });
}

// ===== RANDOM COLOR GENERATOR =====
function generateRandomHexColor() {
    // Collect various system properties for randomness
    const factors = [
        Date.now(), // Current timestamp
        performance.now(), // High precision timestamp
        navigator.hardwareConcurrency || 4, // CPU cores
        screen.width * screen.height, // Screen resolution
        navigator.language.length, // Language code length
        window.innerWidth * window.innerHeight, // Viewport size
        document.documentElement.scrollHeight, // Page height
        new Date().getTimezoneOffset(), // Timezone offset
        navigator.userAgent.length, // User agent string length
        window.devicePixelRatio || 1, // Device pixel ratio
        performance.memory ? performance.memory.usedJSHeapSize : 0, // Memory usage
        Math.random() * 1000000 // Pure randomness
    ];
    
    // Combine all factors into a single seed
    const seed = factors.reduce((acc, factor) => {
        return acc + (typeof factor === 'number' ? factor : factor.toString().length);
    }, 0);
    
    // Use the seed to generate consistent but random-looking values
    const r = Math.floor((Math.sin(seed * 0.1) * 0.5 + 0.5) * 255);
    const g = Math.floor((Math.sin(seed * 0.2 + 1) * 0.5 + 0.5) * 255);
    const b = Math.floor((Math.sin(seed * 0.3 + 2) * 0.5 + 0.5) * 255);
    
    // Convert to hex
    const toHex = (num) => {
        const hex = Math.floor(num).toString(16);
        return hex.length === 1 ? '0' + hex : hex;
    };
    
    return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
}

// ===== GLARE EFFECT =====
function initGlareEffect() {
    const glareElements = document.querySelectorAll('.glare');
    
    if (glareElements.length === 0) {
        return;
    }
    
    // Generate a random color for this session
    const randomColor = generateRandomHexColor();
    
    // Convert hex to RGB for CSS custom properties
    const hexToRgb = (hex) => {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    };
    
    const rgb = hexToRgb(randomColor);
    if (!rgb) {
        return;
    }
    
    // Set CSS custom properties for the random color
    const root = document.documentElement;
    root.style.setProperty('--glare-random-r', rgb.r);
    root.style.setProperty('--glare-random-g', rgb.g);
    root.style.setProperty('--glare-random-b', rgb.b);
    
    // Create color variants with different opacity levels
    const createColorVariant = (opacity) => `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, ${opacity})`;
    
    root.style.setProperty('--glare-color', createColorVariant(0.3));
    root.style.setProperty('--glare-color-fade', createColorVariant(0.2));
    root.style.setProperty('--glare-color-subtle', createColorVariant(0.1));
    
    glareElements.forEach(element => {
        // Track mouse movement for glare effect
        element.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            
            this.style.setProperty('--mouse-x', `${x}%`);
            this.style.setProperty('--mouse-y', `${y}%`);
        });
    });
}

// ===== PROJECT CARDS INTERACTIONS =====
function initProjectCards() {
    const projectCards = document.querySelectorAll('.project-card');
    
    projectCards.forEach(card => {
        // Hover animations
        card.addEventListener('mouseenter', function() {
            anime({
                targets: this,
                scale: 1.02,
                duration: 300,
                easing: 'easeOutExpo'
            });
            
            // Animate tech tags
            const techTags = this.querySelectorAll('.tech-tag');
            anime({
                targets: techTags,
                scale: [1, 1.1, 1],
                duration: 600,
                delay: anime.stagger(100),
                easing: 'easeInOutQuad'
            });
        });
        
        card.addEventListener('mouseleave', function() {
            anime({
                targets: this,
                scale: 1,
                duration: 300,
                easing: 'easeOutExpo'
            });
        });
        
        // Demo window animations
        const demoWindow = card.querySelector('.demo-window');
        if (demoWindow) {
            const demoLines = demoWindow.querySelectorAll('.demo-line');
            
            card.addEventListener('mouseenter', function() {
                anime({
                    targets: demoLines,
                    opacity: [0, 1],
                    translateX: [-20, 0],
                    delay: anime.stagger(100),
                    duration: 400,
                    easing: 'easeOutExpo'
                });
            });
            }
        });
    }

    
// ===== NETWORK DIAGRAM ANIMATION =====
function initNetworkDiagram() {
    const nodes = document.querySelectorAll('.node');
    const connections = document.querySelectorAll('.connection');
    
    if (nodes.length === 0 || typeof anime === 'undefined') {
        console.warn('Network diagram nodes not found or anime.js not loaded');
        return;
    }
    
    try {
        // Animate all nodes together
        anime({
            targets: nodes,
            scale: [0, 1],
            opacity: [0, 1],
            delay: anime.stagger(200, {start: 1000}),
            duration: 800,
            easing: 'easeOutElastic(1, .8)'
        });
        
        // Animate connections if they exist
        if (connections.length > 0) {
            anime({
                targets: connections,
                strokeDashoffset: [anime.setDashoffset, 0],
                duration: 2000,
                delay: 1500,
                easing: 'easeInOutSine'
            });
        }
        
        // Hover effects for nodes
        nodes.forEach(node => {
            node.addEventListener('mouseenter', function() {
                anime({
                    targets: this,
                    scale: 1.2,
                    duration: 300,
                    easing: 'easeOutExpo'
                });
            });
            
            node.addEventListener('mouseleave', function() {
                anime({
                    targets: this,
                    scale: 1,
                    duration: 300,
                    easing: 'easeOutExpo'
                });
            });
        });
    } catch (error) {
        console.warn('Network diagram animation failed:', error);
        // Fallback: show nodes immediately
        nodes.forEach(node => {
            node.style.opacity = '1';
            node.style.scale = '1';
        });
    }
}

// ===== NAVIGATION INTERACTIONS =====
function initNavigation() {
    const nav = document.getElementById('nav');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Smooth scrolling for navigation links
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Check if this is a hash link (starts with #) for smooth scrolling
            if (targetId.startsWith('#')) {
                e.preventDefault();
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    const offsetTop = targetSection.offsetTop - 80; // Account for fixed nav
                    
                    anime({
                        targets: window,
                        scrollTop: offsetTop,
                        duration: 1000,
                        easing: 'easeInOutExpo'
                    });
                }
            }
            // For external links (like /author-spec, /privacy-manifesto), let them navigate normally
            // No preventDefault() needed - they will navigate to the new page
        });
    });
    
    // Nav background on scroll
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            nav.style.background = 'rgba(10, 10, 10, 0.98)';
            nav.style.backdropFilter = 'blur(20px)';
        } else {
            nav.style.background = 'rgba(10, 10, 10, 0.95)';
            nav.style.backdropFilter = 'blur(10px)';
            }
        });
    }
    

// ===== TYPING EFFECT =====
function initTypingEffect() {
    // Disabled to prevent layout issues
    // The typing effect was causing the lexi.go code block to move around
    return;
}

// ===== PARALLAX EFFECTS =====
function initParallaxEffects() {
    // Disabled to prevent layout issues with the code block
    return;
}

// ===== PARTICLE SYSTEM =====
function initParticleSystem() {
    const canvas = document.createElement('canvas');
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = '-1';
    canvas.style.opacity = '0.1';
    
    document.body.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    let particles = [];
    
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    
    function createParticle() {
        return {
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            vx: (Math.random() - 0.5) * 0.5,
            vy: (Math.random() - 0.5) * 0.5,
            size: Math.random() * 2 + 1,
            opacity: Math.random() * 0.5 + 0.1
        };
    }
    
    function initParticles() {
        particles = [];
        for (let i = 0; i < 50; i++) {
            particles.push(createParticle());
        }
    }
    
    function updateParticles() {
        particles.forEach(particle => {
            particle.x += particle.vx;
            particle.y += particle.vy;
            
            if (particle.x < 0 || particle.x > canvas.width) particle.vx *= -1;
            if (particle.y < 0 || particle.y > canvas.height) particle.vy *= -1;
        });
    }
    
    function drawParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        particles.forEach(particle => {
            ctx.beginPath();
            ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(0, 255, 255, ${particle.opacity})`;
            ctx.fill();
        });
    }
    
    function animate() {
        updateParticles();
        drawParticles();
        requestAnimationFrame(animate);
    }
    
    resizeCanvas();
    initParticles();
    animate();
    
    window.addEventListener('resize', () => {
        resizeCanvas();
        initParticles();
    });
}

// ===== PERFORMANCE OPTIMIZATIONS =====
function initPerformanceOptimizations() {
    // Throttle scroll events
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (!scrollTimeout) {
            scrollTimeout = setTimeout(function() {
                scrollTimeout = null;
                // Scroll-based animations here
            }, 16); // ~60fps
        }
    });
    
    // Preload critical animations
    const criticalElements = document.querySelectorAll('.hero-title, .nav-logo');
    criticalElements.forEach(el => {
        el.style.willChange = 'transform, opacity';
    });
}

// ===== ACCESSIBILITY ENHANCEMENTS =====
function initAccessibility() {
    // Skip to main content link
    const skipLink = document.createElement('a');
    skipLink.href = '#main';
    skipLink.textContent = 'Skip to main content';
    skipLink.style.cssText = `
        position: absolute;
        top: -40px;
        left: 6px;
        background: var(--neon-cyan);
        color: var(--bg-primary);
        padding: 8px;
        text-decoration: none;
            z-index: 10000;
        transition: top 0.3s;
    `;
    
    skipLink.addEventListener('focus', function() {
        this.style.top = '6px';
    });
    
    skipLink.addEventListener('blur', function() {
        this.style.top = '-40px';
    });
    
    document.body.insertBefore(skipLink, document.body.firstChild);
    
    // Keyboard navigation for project cards
    const projectCards = document.querySelectorAll('.project-card');
    projectCards.forEach(card => {
        card.setAttribute('tabindex', '0');
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Reduced motion support
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        // Disable animations for users who prefer reduced motion
        document.documentElement.style.setProperty('--transition-fast', '0.01ms');
        document.documentElement.style.setProperty('--transition-normal', '0.01ms');
        document.documentElement.style.setProperty('--transition-slow', '0.01ms');
    }
}

// ===== LOADING STATE =====
function initLoadingState() {
    // Add loading class to body
    document.body.classList.add('loading');
    
    // Remove loading class when everything is ready
    window.addEventListener('load', function() {
        setTimeout(() => {
            document.body.classList.remove('loading');
            document.body.classList.add('loaded');
        }, 500);
    });
}

// ===== INITIALIZE ALL FEATURES =====
document.addEventListener('DOMContentLoaded', function() {
    // Initialize loading state
    initLoadingState();
    
    // Initialize performance optimizations first
    initPerformanceOptimizations();
    
    // Initialize accessibility features
    initAccessibility();
    
    // Initialize visual effects (only if motion is not reduced)
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        initParallaxEffects();
        initParticleSystem();
    }
});

// ===== UTILITY FUNCTIONS =====
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ===== ERROR HANDLING =====
window.addEventListener('error', function(e) {
    console.error('Portfolio error:', e.error);
    // Gracefully degrade if animations fail
    document.body.classList.add('animations-disabled');
});

// ===== EXPORT FOR TESTING =====
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initTerminalAnimations,
        initScrollAnimations,
        initSkillBars,
        initProjectCards,
        initNetworkDiagram,
        initNavigation,
        initGlitchEffects,
        initTypingEffect
    };
}
