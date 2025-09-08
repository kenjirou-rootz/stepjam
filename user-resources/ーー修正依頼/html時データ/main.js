
class STEPJAMreApp {
    constructor() {
        this.isDesktop = window.innerWidth >= 768;
        this.init();
    }

    init() {
        console.log(`🚀 STEPJAMre: ${this.isDesktop ? 'Desktop' : 'Mobile'} (${window.innerWidth}px)`);
        
        this.bindEvents();
        this.initMainContent();
        
        // Responsive check on resize
        window.addEventListener('resize', () => {
            const wasDesktop = this.isDesktop;
            this.isDesktop = window.innerWidth >= 768;
            
            if (wasDesktop !== this.isDesktop) {
                console.log(`📱 Viewport changed: ${this.isDesktop ? 'Desktop' : 'Mobile'}`);
                this.onViewportChange();
            }
        });
    }

    bindEvents() {
        
        // Navigation Overlay Events
        this.bindNavigationEvents();
        
        // Main Content Section Click Events
        document.querySelectorAll('.section').forEach(section => {
            section.addEventListener('click', (e) => {
                this.handleSectionClick(e);
            });
        });
    }

    bindNavigationEvents() {
        // Nav Toggle Button (Header)
        const navToggle = document.getElementById('nav-toggle');
        const navOverlay = document.getElementById('nav-overlay');
        const navCloseBtn = document.getElementById('nav-close-btn');
        
        if (navToggle && navOverlay) {
            navToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleNavigation();
            });
        }
        
        if (navCloseBtn && navOverlay) {
            navCloseBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.closeNavigation();
            });
        }
        
        // Close nav when clicking overlay background
        if (navOverlay) {
            navOverlay.addEventListener('click', (e) => {
                if (e.target === navOverlay) {
                    this.closeNavigation();
                }
            });
        }
        
        // ESC key to close navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeNavigation();
            }
        });

        // Dropdown menu functionality
        this.bindDropdownEvents();
        
        // Scroll navigation functionality
        this.bindScrollEvents();
        
        // Library tab switching functionality
        this.bindLibraryTabEvents();
    }

    bindDropdownEvents() {
        const libraryToggle = document.getElementById('library-toggle');
        const librarySubmenu = document.getElementById('library-submenu');
        const libraryArrow = document.getElementById('library-arrow');
        
        if (libraryToggle && librarySubmenu && libraryArrow) {
            libraryToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const isOpen = !librarySubmenu.classList.contains('hidden');
                
                if (isOpen) {
                    librarySubmenu.classList.add('hidden');
                    libraryArrow.classList.remove('rotate-180');
                    console.log('📁 Library dropdown closed');
                } else {
                    librarySubmenu.classList.remove('hidden');
                    libraryArrow.classList.add('rotate-180');
                    console.log('📁 Library dropdown opened');
                }
            });
        }
    }

    bindScrollEvents() {
        // Main menu scroll events
        const menuItems = document.querySelectorAll('.nav-menu-item[data-scroll-target]');
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = item.getAttribute('data-scroll-target');
                this.scrollToSection(targetId);
            });
        });

        // Submenu scroll events
        const submenuItems = document.querySelectorAll('.nav-submenu-item[data-scroll-target]');
        submenuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = item.getAttribute('data-scroll-target');
                this.scrollToSection(targetId);
            });
        });
    }

    scrollToSection(targetId) {
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            // Close navigation first
            this.closeNavigation();
            
            // Scroll to target with header offset
            const headerHeight = 97.36; // Fixed header height
            const elementPosition = targetElement.offsetTop;
            const offsetPosition = elementPosition - headerHeight;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            console.log(`📍 Scrolled to section: ${targetId}`);
        } else {
            console.warn(`⚠️ Target element not found: ${targetId}`);
        }
    }

    bindLibraryTabEvents() {
        // Get all library tab buttons (both desktop and mobile)
        const tabButtons = document.querySelectorAll('.library-tab-btn[data-tab]');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const selectedTab = button.getAttribute('data-tab');
                this.switchLibraryTab(selectedTab);
            });
        });
        
        // Initialize with Tokyo tab selected
        this.switchLibraryTab('tokyo');
    }

    switchLibraryTab(selectedTab) {
        // Update button states
        const allTabButtons = document.querySelectorAll('.library-tab-btn[data-tab]');
        allTabButtons.forEach(button => {
            const tabName = button.getAttribute('data-tab');
            const isSelected = tabName === selectedTab;
            
            if (isSelected) {
                // Selected state: blue background, white text
                button.classList.remove('bg-transparent', 'border-2', 'border-blue-700', 'text-blue-700');
                button.classList.add('bg-blue-700', 'text-white');
                button.classList.add('active');
            } else {
                // Unselected state: transparent background, blue border and text
                button.classList.remove('bg-blue-700', 'text-white', 'active');
                button.classList.add('bg-transparent', 'border-2', 'border-blue-700', 'text-blue-700');
            }
        });
        
        // Update card visibility
        const allCards = document.querySelectorAll('.library-card[data-tab]');
        allCards.forEach(card => {
            const cardTab = card.getAttribute('data-tab');
            
            if (cardTab === selectedTab) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
        
        // Update title images (desktop and mobile)
        const desktopTitleImg = document.getElementById('lib-list-title-desktop');
        const mobileTitleImg = document.getElementById('lib-list-title-mobile');
        
        const imagePath = selectedTab === 'tokyo' 
            ? 'assets/lib-list/lib-list-tokyo.png' 
            : 'assets/lib-list/lib-list-osaka.png';
        
        if (desktopTitleImg) {
            desktopTitleImg.src = imagePath;
            desktopTitleImg.alt = `${selectedTab.charAt(0).toUpperCase() + selectedTab.slice(1)} Library List Title`;
        }
        
        if (mobileTitleImg) {
            mobileTitleImg.src = imagePath;
            mobileTitleImg.alt = `${selectedTab.charAt(0).toUpperCase() + selectedTab.slice(1)} Library List Title Mobile`;
        }
        
        console.log(`📚 Library tab switched to: ${selectedTab}`);
    }

    toggleNavigation() {
        const navOverlay = document.getElementById('nav-overlay');
        if (navOverlay) {
            const isVisible = !navOverlay.classList.contains('hidden');
            if (isVisible) {
                this.closeNavigation();
            } else {
                this.openNavigation();
            }
        }
    }

    openNavigation() {
        const navOverlay = document.getElementById('nav-overlay');
        if (navOverlay) {
            navOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent body scroll
            console.log('📱 Navigation opened');
        }
    }

    closeNavigation() {
        const navOverlay = document.getElementById('nav-overlay');
        if (navOverlay) {
            navOverlay.classList.add('hidden');
            document.body.style.overflow = ''; // Restore body scroll
            console.log('📱 Navigation closed');
        }
    }

    initMainContent() {
        console.log('📄 Main Content Initialization...');
        
        // Add smooth scroll behavior for sections
        const sections = document.querySelectorAll('.section');
        sections.forEach((section, index) => {
            // Add section navigation functionality if needed
            section.setAttribute('data-section-index', index);
        });
        
    }



    handleSectionClick(e) {
        const section = e.currentTarget;
        const nodeId = section.dataset.nodeId;
        const sectionName = section.classList.contains('spon-section') ? 'Sponsors' :
                           section.classList.contains('whsj-section') ? 'WHSJ' :
                           section.classList.contains('lib-top-section') ? 'Library Top' :
                           section.classList.contains('lib-list-section') ? 'Library List' : 'Unknown';
        
        console.log(`📄 Section clicked: ${sectionName} (Node ID: ${nodeId})`);
        
        // Future: Add section-specific interactions
    }



    onViewportChange() {
        // CSS handles all responsive behavior via media queries
        console.log(`🔄 Viewport: ${this.isDesktop ? 'Desktop' : 'Mobile'}`);
    }

}

// Initialize on DOM Content Loaded
document.addEventListener('DOMContentLoaded', () => {
    window.stepjamreApp = new STEPJAMreApp();
    
});

// Export for potential future module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = STEPJAMreApp;
}