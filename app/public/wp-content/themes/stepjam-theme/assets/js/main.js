class STEPJAMreApp {
    constructor() {
        this.isDesktop = window.innerWidth >= 768;
        this.init();
    }

    init() {
        
        this.bindEvents();
        this.initMainContent();
        this.initYouTubeSliders();
        
        // Responsive check on resize
        window.addEventListener('resize', () => {
            const wasDesktop = this.isDesktop;
            this.isDesktop = window.innerWidth >= 768;
            
            if (wasDesktop !== this.isDesktop) {
                this.onViewportChange();
            }
        });
    }

    bindEvents() {
        
        // Navigation Overlay Events
        this.bindNavigationEvents();
        
        // Main Content Section Click Events - Future implementation
        // document.querySelectorAll('.section').forEach(section => {
        //     section.addEventListener('click', (e) => {
        //         this.handleSectionClick(e);
        //     });
        // });
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
        // Library dropdown (for future use)
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
                } else {
                    librarySubmenu.classList.remove('hidden');
                    libraryArrow.classList.add('rotate-180');
                }
            });
        }
        
        // NEXT dropdown in navigation
        const nextToggle = document.getElementById('next-toggle');
        const nextSubmenu = document.getElementById('next-submenu');
        const nextArrow = document.getElementById('next-arrow');
        
        if (nextToggle && nextSubmenu && nextArrow) {
            nextToggle.addEventListener('click', (e) => {
                e.preventDefault();
                
                if (nextSubmenu.classList.contains('hidden')) {
                    nextSubmenu.classList.remove('hidden');
                    nextArrow.style.transform = 'rotate(180deg)';
                } else {
                    nextSubmenu.classList.add('hidden');
                    nextArrow.style.transform = 'rotate(0deg)';
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
            // Same page navigation - target element exists on current page
            this.closeNavigation();
            
            // Wait for navigation close to complete, then scroll
            // This prevents overflow conflict between closeNavigation() and scrollTo()
            setTimeout(() => {
                const headerHeight = 97.36; // Fixed header height
                const elementPosition = targetElement.offsetTop;
                const offsetPosition = elementPosition - headerHeight;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }, 100); // 100ms delay for navigation close completion
        } else {
            // Cross-page navigation - target element doesn't exist on current page
            // Navigate to front-page.php with hash anchor
            this.closeNavigation();
            
            // Check if we're already on the home page (front-page.php)
            const currentPath = window.location.pathname;
            const isHomePage = currentPath === '/' || currentPath === '/index.php' || currentPath === '';
            
            if (!isHomePage) {
                // Navigate to home page with hash anchor
                const homeUrl = window.location.origin + '/#' + targetId;
                window.location.href = homeUrl;
            }
            // If already on home page but element not found, do nothing (element may not exist)
        }
    }

    bindLibraryTabEvents() {
        // Get all library tab buttons (both desktop and mobile) - HTML基準構造対応
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
        
        // Bind resize event to handle responsive behavior
        window.addEventListener('resize', () => {
            // Re-apply current tab state on resize to handle desktop/mobile transitions
            const currentActiveTab = this.getCurrentActiveTab();
            if (currentActiveTab) {
                this.switchLibraryTab(currentActiveTab);
            }
        });
    }

    getCurrentActiveTab() {
        const activeButton = document.querySelector('.library-tab-btn.tokyo-active[data-tab]');
        return activeButton ? activeButton.getAttribute('data-tab') : 'tokyo';
    }

    switchLibraryTab(selectedTab) {
        // Check if we're in desktop mode (768px+)
        const isDesktopMode = window.innerWidth >= 768;
        
        // Update button states - 参考デザイン準拠CSS適用
        const allTabButtons = document.querySelectorAll('.library-tab-btn[data-tab]');
        allTabButtons.forEach(button => {
            const tabName = button.getAttribute('data-tab');
            
            // Remove all state classes
            button.classList.remove('tokyo-active', 'osaka-inactive');
            
            // Apply appropriate classes based on selection
            if (selectedTab === 'tokyo') {
                if (tabName === 'tokyo') {
                    button.classList.add('tokyo-active');
                } else {
                    button.classList.add('osaka-inactive');
                }
            } else {
                if (tabName === 'osaka') {
                    button.classList.add('tokyo-active'); // Osaka gets active blue fill when selected
                } else {
                    button.classList.add('osaka-inactive'); // Tokyo gets inactive blue outline when not selected
                }
            }
        });
        
        // Update title images visibility - HTML基準ID対応
        const tokyoTitleDesktop = document.getElementById('lib-title-tokyo');
        const osakaTitleDesktop = document.getElementById('lib-title-osaka');
        const tokyoTitleMobile = document.getElementById('lib-title-tokyo-mobile');
        const osakaTitleMobile = document.getElementById('lib-title-osaka-mobile');
        
        if (isDesktopMode) {
            // Desktop (768px+): Show selected title only
            if (selectedTab === 'tokyo') {
                // Show Tokyo title
                if (tokyoTitleDesktop) tokyoTitleDesktop.classList.remove('hidden');
                if (osakaTitleDesktop) osakaTitleDesktop.classList.add('hidden');
            } else {
                // Show Osaka title
                if (tokyoTitleDesktop) tokyoTitleDesktop.classList.add('hidden');
                if (osakaTitleDesktop) osakaTitleDesktop.classList.remove('hidden');
            }
            if (tokyoTitleMobile) tokyoTitleMobile.classList.add('hidden');
            if (osakaTitleMobile) osakaTitleMobile.classList.add('hidden');
        } else {
            // Mobile (767px-): Show selected title only
            if (selectedTab === 'tokyo') {
                // Show Tokyo titles
                if (tokyoTitleDesktop) tokyoTitleDesktop.classList.add('hidden');
                if (osakaTitleDesktop) osakaTitleDesktop.classList.add('hidden');
                if (tokyoTitleMobile) tokyoTitleMobile.classList.remove('hidden');
                if (osakaTitleMobile) osakaTitleMobile.classList.add('hidden');
            } else {
                // Show Osaka titles
                if (tokyoTitleDesktop) tokyoTitleDesktop.classList.add('hidden');
                if (osakaTitleDesktop) osakaTitleDesktop.classList.add('hidden');
                if (tokyoTitleMobile) tokyoTitleMobile.classList.add('hidden');
                if (osakaTitleMobile) osakaTitleMobile.classList.remove('hidden');
            }
        }
        
        // Update dancers visibility - レスポンシブ対応改修
        const tokyoDancersDesktop = document.getElementById('tokyo-dancers');
        const osakaDancersDesktop = document.getElementById('osaka-dancers');
        const tokyoDancersMobile = document.getElementById('tokyo-dancers-mobile');
        const osakaDancersMobile = document.getElementById('osaka-dancers-mobile');
        
        if (isDesktopMode) {
            // Desktop (768px+): Show selected area only
            if (selectedTab === 'tokyo') {
                // Show Tokyo dancers
                if (tokyoDancersDesktop) tokyoDancersDesktop.classList.remove('hidden');
                if (osakaDancersDesktop) osakaDancersDesktop.classList.add('hidden');
            } else {
                // Show Osaka dancers
                if (tokyoDancersDesktop) tokyoDancersDesktop.classList.add('hidden');
                if (osakaDancersDesktop) osakaDancersDesktop.classList.remove('hidden');
            }
            if (tokyoDancersMobile) tokyoDancersMobile.classList.add('hidden');
            if (osakaDancersMobile) osakaDancersMobile.classList.add('hidden');
        } else {
            // Mobile (767px-): Show selected area only (day1 or day2 vertical stacking)
            if (selectedTab === 'tokyo') {
                // Show Tokyo dancers
                if (tokyoDancersDesktop) tokyoDancersDesktop.classList.add('hidden');
                if (osakaDancersDesktop) osakaDancersDesktop.classList.add('hidden');
                if (tokyoDancersMobile) tokyoDancersMobile.classList.remove('hidden');
                if (osakaDancersMobile) osakaDancersMobile.classList.add('hidden');
            } else {
                // Show Osaka dancers
                if (tokyoDancersDesktop) tokyoDancersDesktop.classList.add('hidden');
                if (osakaDancersDesktop) osakaDancersDesktop.classList.add('hidden');
                if (tokyoDancersMobile) tokyoDancersMobile.classList.add('hidden');
                if (osakaDancersMobile) osakaDancersMobile.classList.remove('hidden');
            }
        }
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
        }
    }

    closeNavigation() {
        const navOverlay = document.getElementById('nav-overlay');
        if (navOverlay) {
            navOverlay.classList.add('hidden');
            document.body.style.overflow = ''; // Restore body scroll
        }
        
        // Reset dropdown state when closing navigation
        const nextSubmenu = document.getElementById('next-submenu');
        const nextArrow = document.getElementById('next-arrow');
        if (nextSubmenu && nextArrow) {
            nextSubmenu.classList.add('hidden');
            nextArrow.style.transform = 'rotate(0deg)';
        }
    }

    initMainContent() {
        
        // Add smooth scroll behavior for sections
        const sections = document.querySelectorAll('.section');
        sections.forEach((section, index) => {
            // Add section navigation functionality if needed
            section.setAttribute('data-section-index', index);
        });
        
        // Initialize Swiper sliders
        this.initSwiper();
    }

    initSwiper() {
        // Wait for Swiper to be available
        const waitForSwiper = () => {
            if (typeof Swiper !== 'undefined') {
                this.setupSwiperSliders();
            } else {
                setTimeout(waitForSwiper, 100);
            }
        };
        waitForSwiper();
    }

    setupSwiperSliders() {
        
        // Common Swiper Settings - HTML基準設定
        const commonSettings = {
            allowTouchMove: false,
            simulateTouch: false,
            slidesPerView: 'auto',
        };
        
        const mainSliderCommon = {
            ...commonSettings,
            rewind: true,
            speed: 1000,
            effect: 'slide',
            centeredSlides: true,
            initialSlide: 1,
            grabCursor: false,
            watchOverflow: false,
        };
        
        const logoSliderCommon = {
            ...commonSettings,
            speed: 15000,
            freeMode: {
                enabled: true,
                momentum: false,
            },
        };

        // Sponsor Section Swiper Initialization
        this.initSponsorSwipers(mainSliderCommon, logoSliderCommon);
        
        // Dancer Performance Video Slider Initialization
        this.initDancerPerformanceSlider();
    }

    initSponsorSwipers(mainSliderCommon, logoSliderCommon) {
        // Desktop Main Slider
        const mainSliderDesktopEl = document.querySelector('.main-slider-desktop');
        if (mainSliderDesktopEl) {
            this.mainSliderDesktop = new Swiper('.main-slider-desktop', {
                ...mainSliderCommon,
                loop: false,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                spaceBetween: 20,
            });
        }

        // Mobile Main Slider
        const mainSliderMobileEl = document.querySelector('.main-slider-mobile');
        if (mainSliderMobileEl) {
            this.mainSliderMobile = new Swiper('.main-slider-mobile', {
                ...mainSliderCommon,
                loop: false,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                spaceBetween: '4.17%',
            });
        }

        // Desktop Logo Slider
        const logoSliderDesktopEl = document.querySelector('.logo-slider-desktop');
        if (logoSliderDesktopEl) {
            // Check number of slides for loop mode compatibility
            const slideCount = logoSliderDesktopEl.querySelectorAll('.swiper-slide').length;
            
            this.logoSliderDesktop = new Swiper('.logo-slider-desktop', {
                ...logoSliderCommon,
                loop: slideCount >= 3, // Only enable loop if 3 or more slides
                autoplay: {
                    delay: 2000, // 2秒間隔の自動再生
                    disableOnInteraction: false
                },
                spaceBetween: '1.41%',
            });
        }

        // Mobile Logo Slider
        const logoSliderMobileEl = document.querySelector('.logo-slider-mobile');
        if (logoSliderMobileEl) {
            // Check number of slides for loop mode compatibility
            const slideCount = logoSliderMobileEl.querySelectorAll('.swiper-slide').length;
            
            this.logoSliderMobile = new Swiper('.logo-slider-mobile', {
                ...logoSliderCommon,
                loop: slideCount >= 3, // Only enable loop if 3 or more slides
                autoplay: {
                    delay: 2000, // 2秒間隔の自動再生
                    disableOnInteraction: false
                },
                spaceBetween: '3.52%',
            });
        }

        // Single Dancer Desktop Logo Slider
        const singleLogoSliderDesktopEl = document.querySelector('.single-logo-slider-desktop');
        if (singleLogoSliderDesktopEl) {
            // Check number of slides for loop mode compatibility
            const slideCount = singleLogoSliderDesktopEl.querySelectorAll('.swiper-slide').length;
            
            this.singleLogoSliderDesktop = new Swiper('.single-logo-slider-desktop', {
                ...logoSliderCommon,
                loop: slideCount >= 3, // Only enable loop if 3 or more slides
                autoplay: {
                    delay: 2000, // 2秒間隔の自動再生
                    disableOnInteraction: false
                },
                spaceBetween: '1.41%',
            });
        }

        // Single Dancer Mobile Logo Slider
        const singleLogoSliderMobileEl = document.querySelector('.single-logo-slider-mobile');
        if (singleLogoSliderMobileEl) {
            // Check number of slides for loop mode compatibility
            const slideCount = singleLogoSliderMobileEl.querySelectorAll('.swiper-slide').length;
            
            this.singleLogoSliderMobile = new Swiper('.single-logo-slider-mobile', {
                ...logoSliderCommon,
                loop: slideCount >= 3, // Only enable loop if 3 or more slides
                autoplay: {
                    delay: 2000, // 2秒間隔の自動再生
                    disableOnInteraction: false
                },
                spaceBetween: '3.52%',
            });
        }
    }

    initDancerPerformanceSlider() {
        // Mobile Dancer Performance Video Slider
        const performanceSliderEl = document.querySelector('.performance-slider');
        if (performanceSliderEl) {
            this.performanceSlider = new Swiper('.performance-slider', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: false,
                grabCursor: true,
                allowTouchMove: true,
                simulateTouch: true,
                watchOverflow: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    bulletClass: 'swiper-pagination-bullet',
                    bulletActiveClass: 'swiper-pagination-bullet-active',
                },
                // Breakpoints
                breakpoints: {
                    768: {
                        // Disable on desktop as it uses grid layout
                        enabled: false,
                    }
                }
            });
        }
    }


    // Future implementation: Section click handling
    // handleSectionClick(e) {
    //     const section = e.currentTarget;
    //     const nodeId = section.dataset.nodeId;
    //     const sectionName = section.classList.contains('whsj-section') ? 'WHSJ' :
    //                        section.classList.contains('lib-top-section') ? 'Library Top' :
    //                        section.classList.contains('lib-list-section') ? 'Library List' : 'Unknown';
    //     
    //     // Placeholder for future section-specific interactions
    // }

    onViewportChange() {
        // CSS handles all responsive behavior via media queries
        
        // Destroy existing swipers
        this.destroySwipers();
        
        // Re-initialize swipers for new viewport
        setTimeout(() => {
            this.initSwiper();
        }, 300);
        
        // Re-apply tab state for responsive transitions
        const currentActiveTab = this.getCurrentActiveTab();
        if (currentActiveTab) {
            this.switchLibraryTab(currentActiveTab);
        }
    }

    initYouTubeSliders() {
        // Initialize YouTube auto-sliders for toroku-dancer pages
        const youtubeSliders = document.querySelectorAll('.youtube-slider[data-auto-slide]');
        
        youtubeSliders.forEach(slider => {
            const slides = slider.querySelectorAll('.slide');
            
            if (slides.length <= 1) return; // No need to slide if only one slide
            
            const interval = parseInt(slider.getAttribute('data-auto-slide')) || 1000;
            let currentSlide = 0;
            let sliderInterval;
            
            // Function to show specific slide
            const showSlide = (index) => {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
            };
            
            // Function to go to next slide
            const nextSlide = () => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            };
            
            // Start auto-sliding
            const startSlider = () => {
                sliderInterval = setInterval(nextSlide, interval);
            };
            
            // Stop auto-sliding
            const stopSlider = () => {
                if (sliderInterval) {
                    clearInterval(sliderInterval);
                    sliderInterval = null;
                }
            };
            
            // Initialize first active slide
            let initialActiveFound = false;
            slides.forEach((slide, index) => {
                if (slide.classList.contains('active') && !initialActiveFound) {
                    currentSlide = index;
                    initialActiveFound = true;
                } else if (!initialActiveFound && index === 0) {
                    currentSlide = 0;
                    slide.classList.add('active');
                    initialActiveFound = true;
                } else {
                    slide.classList.remove('active');
                }
            });
            
            // Start the slider
            startSlider();
            
            // Pause on hover (optional)
            slider.addEventListener('mouseenter', stopSlider);
            slider.addEventListener('mouseleave', startSlider);
            
            // Store reference for cleanup
            slider._sliderInterval = sliderInterval;
        });
    }

    destroySwipers() {
        // Destroy YouTube sliders
        const youtubeSliders = document.querySelectorAll('.youtube-slider[data-auto-slide]');
        youtubeSliders.forEach(slider => {
            if (slider._sliderInterval) {
                clearInterval(slider._sliderInterval);
                slider._sliderInterval = null;
            }
        });
        
        // Destroy Sponsor Section Swipers
        if (this.mainSliderDesktop) {
            this.mainSliderDesktop.destroy(true, true);
            this.mainSliderDesktop = null;
        }
        
        if (this.mainSliderMobile) {
            this.mainSliderMobile.destroy(true, true);
            this.mainSliderMobile = null;
        }
        
        if (this.logoSliderDesktop) {
            this.logoSliderDesktop.destroy(true, true);
            this.logoSliderDesktop = null;
        }
        
        if (this.logoSliderMobile) {
            this.logoSliderMobile.destroy(true, true);
            this.logoSliderMobile = null;
        }
        
        // Destroy Dancer Performance Slider
        if (this.performanceSlider) {
            this.performanceSlider.destroy(true, true);
            this.performanceSlider = null;
        }
        
        // Destroy Dancers Section Swipers with resize handlers cleanup
        if (this.dancerSwipers && this.dancerSwipers.length > 0) {
            this.dancerSwipers.forEach(swiperObj => {
                // 新しい構造対応: オブジェクトまたは直接Swiperインスタンス
                if (swiperObj && typeof swiperObj === 'object') {
                    if (swiperObj.swiper && typeof swiperObj.swiper.destroy === 'function') {
                        // 新構造: {swiper: Swiper, resizeHandler: function}
                        swiperObj.swiper.destroy(true, true);
                        if (swiperObj.resizeHandler) {
                            window.removeEventListener('resize', swiperObj.resizeHandler);
                        }
                    } else if (typeof swiperObj.destroy === 'function') {
                        // 旧構造: 直接Swiperインスタンス
                        swiperObj.destroy(true, true);
                    }
                }
            });
            this.dancerSwipers = [];
        }
    }

}

// Initialize on DOM Content Loaded with fallback support
document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.stepjamreApp === 'undefined') {
        window.stepjamreApp = new STEPJAMreApp();
    }
});

// Fallback 1: Window load event (if DOMContentLoaded fails)
window.addEventListener('load', () => {
    if (typeof window.stepjamreApp === 'undefined') {
        window.stepjamreApp = new STEPJAMreApp();
    }
});

// Fallback 2: Immediate initialization if DOM already ready
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    if (typeof window.stepjamreApp === 'undefined') {
        window.stepjamreApp = new STEPJAMreApp();
    }
}

// Export for potential future module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = STEPJAMreApp;
}