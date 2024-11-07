// Import required libraries
import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import SmoothScroll from 'smooth-scroll';
import '@google/model-viewer';

// Initialize Alpine.js
window.Alpine = Alpine;

// Add custom Alpine directives and magic properties
Alpine.directive('tooltip', (el, { expression }) => {
    tippy(el, {
        content: expression,
        arrow: true
    });
});

// Add custom Alpine data
Alpine.data('navigation', () => ({
    isOpen: false,
    scrolled: false,
    init() {
        this.handleScroll();
        window.addEventListener('scroll', () => this.handleScroll());
    },
    handleScroll() {
        this.scrolled = window.pageYOffset > 20;
    }
}));

// Start Alpine.js first
Alpine.start();

// Initialize AOS with optimized settings after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
        easing: 'ease-in-out-cubic',
        delay: 100,
        disable: 'mobile',
    });

    // Initialize other components
    initializeModelViewer();
    setupIntersectionObservers();
    initializeStats();
    initializeLazyLoading();
    setupEventListeners();
});

// Model Viewer Setup
function initializeModelViewer() {
    const modelViewer = document.querySelector('model-viewer');
    if (modelViewer) {
        modelViewer.addEventListener('load', () => {
            modelViewer.dismissPoster();
            modelViewer.cameraOrbit = '45deg 55deg 2m';
            modelViewer.fieldOfView = '30deg';
            modelViewer.exposure = 0.5;
            modelViewer.shadowIntensity = 1;
            modelViewer.shadowSoftness = 1;
        });

        modelViewer.addEventListener('error', (error) => {
            console.error('Error loading model:', error);
            handleModelError(modelViewer);
        });
    }
}

function handleModelError(modelViewer) {
    modelViewer.style.display = 'none';
    const fallbackContainer = document.createElement('div');
    fallbackContainer.className = 'fallback-container';
    fallbackContainer.innerHTML = `
        <img src="/images/fallback-3d.png" alt="3D Model Fallback" class="w-full h-auto rounded-lg shadow-lg">
        <p class="text-sm text-gray-500 mt-2">3D model tidak dapat dimuat</p>
    `;
    modelViewer.parentNode.appendChild(fallbackContainer);
}

// Intersection Observers Setup
function setupIntersectionObservers() {
    // Header Observer
    const header = document.querySelector('header');
    const headerObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                header.classList.toggle('is-scrolled', !entry.isIntersecting);
            });
        },
        { threshold: 0, rootMargin: '-100px 0px 0px 0px' }
    );

    const hero = document.querySelector('#hero');
    if (hero) headerObserver.observe(hero);

    // Feature Cards Observer
    const featureCards = document.querySelectorAll('.feature-card');
    const cardObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    cardObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.2 }
    );

    featureCards.forEach(card => cardObserver.observe(card));
}

// Statistics Animation
function initializeStats() {
    const animateValue = (element, start, end, duration) => {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentValue = Math.floor(progress * (end - start) + start);

            if (element.dataset.format === 'percentage') {
                element.textContent = currentValue.toFixed(1) + '%';
            } else {
                element.textContent = currentValue.toLocaleString();
            }

            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    };

    const statsObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const target = parseFloat(element.dataset.target);
                    animateValue(element, 0, target, 2000);
                    statsObserver.unobserve(element);
                }
            });
        },
        { threshold: 0.5 }
    );

    document.querySelectorAll('[data-counter]').forEach(stat => {
        statsObserver.observe(stat);
    });
}

// Lazy Loading Implementation
function initializeLazyLoading() {
    const imageObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                }
            });
        },
        {
            rootMargin: '50px 0px',
            threshold: 0.1
        }
    );

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Event Listeners Setup
function setupEventListeners() {
    // FAQ accordion control
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const answer = button.nextElementSibling;
            button.setAttribute('aria-expanded', answer.style.display === 'none');
        });
    });

    // Back to top button
    const backToTopButton = document.getElementById('backToTop');
    if (backToTopButton) {
        window.addEventListener('scroll', debounce(() => {
            backToTopButton.classList.toggle('show', window.pageYOffset > 400);
        }, 100));

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Performance monitoring for Largest Contentful Paint (LCP) and First Input Delay (FID)
const perfObserver = new PerformanceObserver((list) => {
    for (const entry of list.getEntries()) {
        if (entry.entryType === 'largest-contentful-paint') {
            console.log('LCP:', entry.startTime, entry);
        }
        if (entry.entryType === 'first-input') {
            console.log('FID:', entry.processingStart - entry.startTime);
        }
    }
});

perfObserver.observe({ entryTypes: ['largest-contentful-paint', 'first-input'] });

// Utility function for debouncing events
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

// Smooth Scroll Initialization
const scroll = new SmoothScroll('a[href*="#"]', {
    speed: 800,
    speedAsDuration: true,
    easing: 'easeInOutCubic',
    offset: 70,
    updateURL: false,
    popstate: true,
    emitEvents: true,
    before: function(anchor, toggle) {
        console.log('Starting scroll to:', anchor.id);
    },
    after: function(anchor, toggle) {
        console.log('Finished scrolling to:', anchor.id);
    }
});

// Error Handling for Global Events
window.addEventListener('error', function(e) {
    console.error('Global error:', e);
});

// Custom error handler for Alpine.js errors
Alpine.handleError = (err, component, expression) => {
    console.error(`Alpine Error: ${err.message}`);
};

// Export functions if needed elsewhere in the application
export {
    initializeModelViewer,
    setupIntersectionObservers,
    initializeStats,
    initializeLazyLoading
};

