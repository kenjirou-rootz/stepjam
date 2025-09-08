/**
 * FAQ Accordion Component - Independent JavaScript Module
 * 
 * Modern accordion implementation with smooth animations,
 * accessibility support, and complete separation from main.js
 * 
 * @package STEPJAM_Theme
 * @version 1.0.0
 */

// Namespace isolation to prevent conflicts with STEPJAMreApp
if (typeof window.STEPJAM === 'undefined') {
    window.STEPJAM = {};
}

/**
 * FAQ Accordion Class
 * Completely independent from STEPJAMreApp
 */
window.STEPJAM.FAQAccordion = class {
    constructor(containerSelector = '[data-faq="container"]') {
        this.containerSelector = containerSelector;
        this.container = null;
        this.items = [];
        this.activeItems = new Set();
        this.isInitialized = false;
        
        // Animation settings
        this.animationDuration = 400; // 0.4s to match CSS
        this.easingFunction = 'cubic-bezier(0.4, 0, 0.2, 1)';
        
        // Enhanced animation states
        this.animationStates = {
            COLLAPSED: 'collapsed',
            EXPANDING: 'expanding', 
            EXPANDED: 'expanded',
            COLLAPSING: 'collapsing'
        };
        
        // Keyboard navigation support
        this.keyboardEnabled = true;
        
        // Debug mode
        this.debug = false;
        
        this.init();
    }

    /**
     * Initialize the FAQ accordion
     */
    init() {
        try {
            this.container = document.querySelector(this.containerSelector);
            
            if (!this.container) {
                if (this.debug) {
                    console.warn('FAQ Accordion: Container not found with selector:', this.containerSelector);
                }
                return;
            }

            this.collectItems();
            this.bindEvents();
            this.setupAccessibility();
            this.initializeAnimations();
            this.isInitialized = true;
            
            if (this.debug) {
                console.log('FAQ Accordion: Initialized successfully with', this.items.length, 'items');
            }
            
        } catch (error) {
            console.error('FAQ Accordion: Initialization error:', error);
        }
    }

    /**
     * Collect all FAQ items
     */
    collectItems() {
        const itemElements = this.container.querySelectorAll('[data-faq="item"]');
        this.items = [];
        
        itemElements.forEach((element, index) => {
            const questionButton = element.querySelector('[data-faq="question"]');
            const answerContainer = element.querySelector('[data-faq="answer-container"]');
            const plusIcon = element.querySelector('.faq-icon-plus');
            const minusIcon = element.querySelector('.faq-icon-minus');
            
            if (questionButton && answerContainer) {
                const item = {
                    index,
                    id: element.dataset.faqId || `faq-${index}`,
                    element,
                    questionButton,
                    answerContainer,
                    plusIcon,
                    minusIcon,
                    isExpanded: false,
                    contentHeight: 0
                };
                
                this.items.push(item);
            }
        });
    }

    /**
     * Bind event listeners
     */
    bindEvents() {
        this.items.forEach(item => {
            // Click events with ripple effect
            item.questionButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.addRippleEffect(item.questionButton, e);
                this.toggleItem(item);
            });

            // Keyboard events (Enter and Space)
            if (this.keyboardEnabled) {
                item.questionButton.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.toggleItem(item);
                    }
                });
            }
        });

        // Handle window resize for height recalculation
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.recalculateHeights();
            }, 150);
        });
    }

    /**
     * Setup accessibility attributes and initial states
     */
    setupAccessibility() {
        this.items.forEach(item => {
            // Ensure proper ARIA attributes
            item.questionButton.setAttribute('aria-expanded', 'false');
            item.questionButton.setAttribute('role', 'button');
            item.questionButton.setAttribute('tabindex', '0');
            
            // Ensure answer container has proper attributes
            item.answerContainer.setAttribute('aria-hidden', 'true');
            item.answerContainer.setAttribute('role', 'region');
            
            // Add unique IDs if not present
            if (!item.answerContainer.id) {
                item.answerContainer.id = `faq-answer-${item.id}`;
            }
            
            if (!item.questionButton.getAttribute('aria-controls')) {
                item.questionButton.setAttribute('aria-controls', item.answerContainer.id);
            }
            
            // Initialize animation states for CSS integration
            item.element.setAttribute('data-expanded', 'false');
            this.setAnimationState(item, this.animationStates.COLLAPSED);
        });
    }

    /**
     * Initialize animation system and remove loading state
     */
    initializeAnimations() {
        // Remove loading state after short delay for staggered animations
        setTimeout(() => {
            if (this.container) {
                this.container.classList.remove('faq-loading');
            }
        }, 600); // Allow time for staggered entrance animations
    }

    /**
     * Add ripple effect to button
     * @param {Element} button - Button element
     * @param {Event} event - Click event
     */
    addRippleEffect(button, event) {
        // Add ripple class
        button.classList.add('ripple-active');
        
        // Remove ripple after animation
        setTimeout(() => {
            button.classList.remove('ripple-active');
        }, 400);
    }

    /**
     * Toggle FAQ item (expand/collapse)
     * @param {Object} item - FAQ item object
     */
    toggleItem(item) {
        if (item.isExpanded) {
            this.collapseItem(item);
        } else {
            this.expandItem(item);
        }
    }

    /**
     * Expand FAQ item
     * @param {Object} item - FAQ item object
     */
    expandItem(item) {
        if (item.isExpanded) return;

        // Set expanding state
        this.setAnimationState(item, this.animationStates.EXPANDING);

        // Calculate content height
        const content = item.answerContainer.querySelector('.faq-answer-content');
        if (content) {
            // Temporarily make visible to measure height
            const tempStyle = {
                visibility: item.answerContainer.style.visibility,
                height: item.answerContainer.style.height,
                opacity: item.answerContainer.style.opacity,
                position: item.answerContainer.style.position
            };
            
            item.answerContainer.style.visibility = 'hidden';
            item.answerContainer.style.height = 'auto';
            item.answerContainer.style.opacity = '1';
            item.answerContainer.style.position = 'absolute';
            
            item.contentHeight = content.scrollHeight;
            
            // Restore original styles
            Object.assign(item.answerContainer.style, tempStyle);
        }

        // Update state
        item.isExpanded = true;
        this.activeItems.add(item.id);

        // Update ARIA attributes
        item.questionButton.setAttribute('aria-expanded', 'true');
        item.answerContainer.setAttribute('aria-hidden', 'false');

        // Update data attributes for CSS animations
        item.element.setAttribute('data-expanded', 'true');

        // Animate expansion with enhanced timing
        this.animateExpansion(item);

        // Update icons
        this.updateIcons(item);

        if (this.debug) {
            console.log('FAQ Accordion: Expanded item', item.id);
        }
    }

    /**
     * Collapse FAQ item
     * @param {Object} item - FAQ item object
     */
    collapseItem(item) {
        if (!item.isExpanded) return;

        // Set collapsing state
        this.setAnimationState(item, this.animationStates.COLLAPSING);

        // Update state
        item.isExpanded = false;
        this.activeItems.delete(item.id);

        // Update ARIA attributes
        item.questionButton.setAttribute('aria-expanded', 'false');
        item.answerContainer.setAttribute('aria-hidden', 'true');

        // Update data attributes for CSS animations
        item.element.setAttribute('data-expanded', 'false');

        // Animate collapse with enhanced timing
        this.animateCollapse(item);

        // Update icons
        this.updateIcons(item);

        if (this.debug) {
            console.log('FAQ Accordion: Collapsed item', item.id);
        }
    }

    /**
     * Set animation state for enhanced CSS integration
     * @param {Object} item - FAQ item object
     * @param {string} state - Animation state
     */
    setAnimationState(item, state) {
        item.answerContainer.setAttribute('data-state', state);
    }

    /**
     * Animate item expansion with enhanced CSS integration
     * @param {Object} item - FAQ item object
     */
    animateExpansion(item) {
        const { answerContainer } = item;
        
        // Set initial state for smooth transition
        answerContainer.style.height = '0px';
        
        // Force reflow for smooth animation
        answerContainer.offsetHeight;
        
        // Set expanding state and trigger CSS animations
        this.setAnimationState(item, this.animationStates.EXPANDING);
        
        // Set target height for smooth transition
        answerContainer.style.height = `${item.contentHeight}px`;
        
        // Handle animation completion
        setTimeout(() => {
            if (item.isExpanded) {
                this.setAnimationState(item, this.animationStates.EXPANDED);
                answerContainer.style.height = 'auto';
            }
        }, this.animationDuration);
    }

    /**
     * Animate item collapse with enhanced CSS integration
     * @param {Object} item - FAQ item object
     */
    animateCollapse(item) {
        const { answerContainer } = item;
        
        // Set current height for smooth transition
        answerContainer.style.height = `${answerContainer.scrollHeight}px`;
        
        // Force reflow
        answerContainer.offsetHeight;
        
        // Set collapsing state and trigger CSS animations
        this.setAnimationState(item, this.animationStates.COLLAPSING);
        
        // Animate to collapsed state
        answerContainer.style.height = '0px';
        
        // Handle animation completion
        setTimeout(() => {
            if (!item.isExpanded) {
                this.setAnimationState(item, this.animationStates.COLLAPSED);
            }
        }, this.animationDuration);
    }

    /**
     * Update plus/minus icons
     * @param {Object} item - FAQ item object
     */
    updateIcons(item) {
        if (item.plusIcon && item.minusIcon) {
            if (item.isExpanded) {
                // Show minus, hide plus
                item.plusIcon.style.opacity = '0';
                item.plusIcon.style.transform = 'rotate(45deg)';
                item.minusIcon.style.opacity = '1';
                item.minusIcon.style.transform = 'rotate(0deg)';
            } else {
                // Show plus, hide minus
                item.plusIcon.style.opacity = '1';
                item.plusIcon.style.transform = 'rotate(0deg)';
                item.minusIcon.style.opacity = '0';
                item.minusIcon.style.transform = 'rotate(45deg)';
            }
        }
    }

    /**
     * Recalculate heights after window resize
     */
    recalculateHeights() {
        this.items.forEach(item => {
            if (item.isExpanded) {
                const content = item.answerContainer.querySelector('.faq-answer-content');
                if (content) {
                    item.contentHeight = content.scrollHeight;
                    item.answerContainer.style.height = `${item.contentHeight}px`;
                }
            }
        });
    }

    /**
     * Expand all items
     */
    expandAll() {
        this.items.forEach(item => {
            if (!item.isExpanded) {
                this.expandItem(item);
            }
        });
    }

    /**
     * Collapse all items
     */
    collapseAll() {
        this.items.forEach(item => {
            if (item.isExpanded) {
                this.collapseItem(item);
            }
        });
    }

    /**
     * Get item by ID
     * @param {string} id - FAQ item ID
     * @returns {Object|null} FAQ item object or null
     */
    getItem(id) {
        return this.items.find(item => item.id === id) || null;
    }

    /**
     * Get all expanded items
     * @returns {Array} Array of expanded FAQ items
     */
    getExpandedItems() {
        return this.items.filter(item => item.isExpanded);
    }

    /**
     * Enable debug mode
     */
    enableDebug() {
        this.debug = true;
        console.log('FAQ Accordion: Debug mode enabled');
    }

    /**
     * Disable debug mode
     */
    disableDebug() {
        this.debug = false;
    }

    /**
     * Destroy the accordion (cleanup)
     */
    destroy() {
        // Remove all event listeners
        this.items.forEach(item => {
            const newQuestionButton = item.questionButton.cloneNode(true);
            item.questionButton.parentNode.replaceChild(newQuestionButton, item.questionButton);
        });

        // Reset state
        this.items = [];
        this.activeItems.clear();
        this.isInitialized = false;

        if (this.debug) {
            console.log('FAQ Accordion: Destroyed');
        }
    }
};

/**
 * Auto-initialization when DOM is ready
 */
function initFAQAccordion() {
    // Check if we're on the FAQ page
    const faqContainer = document.querySelector('[data-faq="container"]');
    
    if (faqContainer && typeof window.STEPJAM.FAQAccordion === 'function') {
        // Initialize FAQ accordion
        window.STEPJAM.faqAccordionInstance = new window.STEPJAM.FAQAccordion();
        
        // Global access for debugging (development only)
        if (window.location.hostname === 'localhost' || window.location.hostname.includes('local')) {
            window.STEPJAM.faqAccordionInstance.enableDebug();
            console.log('FAQ Accordion: Development mode - debug enabled');
        }
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFAQAccordion);
} else {
    // DOM is already ready
    initFAQAccordion();
}

// Fallback initialization for various loading scenarios
window.addEventListener('load', () => {
    // Double-check initialization
    if (!window.STEPJAM.faqAccordionInstance) {
        initFAQAccordion();
    }
});