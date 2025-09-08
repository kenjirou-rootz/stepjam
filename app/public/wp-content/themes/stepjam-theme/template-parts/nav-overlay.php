<?php
/**
 * Template part for displaying navigation overlay
 * 
 * @package STEPJAM_Theme
 */
?>

<!-- Navigation Overlay - Modern 8-Item Structure -->
<nav id="nav-overlay" 
     class="fixed top-0 left-0 bg-black bg-opacity-50 hidden" 
     style="height: 100vh; width: 100%; max-width: 1200px; overflow: hidden; z-index: var(--z-navigation-overlay);"
     data-acf="nav-overlay">
    
    <!-- Nav Content Container -->
    <div class="flex flex-col justify-between items-start p-0 h-full w-full" 
         data-name="nav-open">
        
        <!-- Nav Header Area (Preserved Original) -->
        <div class="flex flex-row gap-11 items-center justify-start w-full p-0" 
             style="height: 96.12px;" 
             data-name="nav-header">
            
            <!-- Close Button -->
            <button id="nav-close-btn" 
                    class="block cursor-pointer relative shrink-0" 
                    style="width: 173.08px; height: 96.12px;" 
                    data-name="nav-bt_close"
                    aria-label="Close Navigation">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/nav/nav-bt-close.svg'); ?>" 
                     alt="Close Navigation" 
                     class="block max-w-none w-full h-full" />
            </button>
            
            <!-- STEPJAM Logo -->
            <div class="relative shrink-0" 
                 style="width: clamp(80px, 106.67px, 150px); height: clamp(16px, 21.47px, 30px);" 
                 data-name="nav-sjlogo">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/nav/nav-sjlogo.svg'); ?>" 
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo" 
                     class="block max-w-none w-full h-full" />
            </div>
            
        </div>
        
        <!-- Main Menu Area - Modern 8-Item Structure -->
        <div class="flex flex-col gap-12 items-start justify-start w-full overflow-hidden pl-10 pr-0 py-0" 
             data-name="main-menu-area">
            
            <!-- Primary Navigation Menu -->
            <div class="flex flex-col justify-start items-start w-full min-w-80 px-px py-0 space-y-5" 
                 data-name="primary-nav-menu">
                
                <!-- HOME -->
                <div class="nav-menu-item-container w-full">
                    <button class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full" 
                            style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                            data-scroll-target="hero-section"
                            data-nav-type="scroll">
                        HOME
                    </button>
                </div>
                
                <!-- NEXT with Dropdown -->
                <?php $next_links = stepjam_get_next_nav_links(); ?>
                <div class="nav-menu-item-container w-full">
                    <div class="next-dropdown relative">
                        <button class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer flex items-center w-full" 
                                style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                                id="next-toggle"
                                data-nav-type="dropdown">
                            NEXT
                            <span class="ml-3 transform transition-transform duration-200 text-xl" id="next-arrow">▼</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="next-submenu ml-6 mt-3 space-y-3 hidden" id="next-submenu">
                            <?php foreach ($next_links as $area => $link_data): ?>
                                <div class="nav-submenu-item-container">
                                    <?php if ($link_data['available']): ?>
                                        <a href="<?php echo esc_url($link_data['url']); ?>" 
                                           class="nav-submenu-item text-left text-white font-sans text-lg hover:text-cyan-400 transition-colors cursor-pointer block"
                                           data-nav-type="page"
                                           title="<?php echo esc_attr($link_data['title']); ?>">
                                            <?php echo esc_html(strtoupper($area)); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="nav-submenu-item text-left text-white font-sans text-lg cursor-not-allowed block opacity-50" 
                                              style="pointer-events: none;"
                                              title="該当ページが設定されていません"
                                              data-nav-type="unavailable">
                                            <?php echo esc_html(strtoupper($area)); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- SPONSORS -->
                <div class="nav-menu-item-container w-full">
                    <button class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full" 
                            style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                            data-scroll-target="sponsor-section"
                            data-nav-type="scroll">
                        SPONSORS
                    </button>
                </div>
                
                <!-- ABOUT -->
                <div class="nav-menu-item-container w-full">
                    <button class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full" 
                            style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                            data-scroll-target="whsj-section"
                            data-nav-type="scroll">
                        ABOUT
                    </button>
                </div>
                
                <!-- NEWS -->
                <div class="nav-menu-item-container w-full">
                    <a href="<?php echo esc_url(get_post_type_archive_link('info-news')); ?>" 
                       class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full block"
                       style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                       data-nav-type="page">
                        NEWS
                    </a>
                </div>
                
                <!-- LIBRARY -->
                <div class="nav-menu-item-container w-full">
                    <button class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full" 
                            style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                            data-scroll-target="lib-top-section"
                            data-nav-type="scroll">
                        LIBRARY
                    </button>
                </div>
                
                <!-- FAQ -->
                <div class="nav-menu-item-container w-full">
                    <a href="<?php echo esc_url(home_url('/faq/')); ?>" 
                       class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full block"
                       style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                       data-nav-type="page">
                        FAQ
                    </a>
                </div>
                
                <!-- CONTACT -->
                <div class="nav-menu-item-container w-full">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" 
                       class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full block"
                       style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
                       data-nav-type="page">
                        CONTACT
                    </a>
                </div>
                
            </div>
            
            <!-- Footer Navigation Menu -->
            <div class="flex flex-row gap-8 items-start justify-start w-full min-w-80 p-0" 
                 style="height: 60px;" 
                 data-name="footer-nav-menu">
                
                <a href="https://rootz-adl.com/company/" 
                   target="_blank"
                   class="text-left text-white font-sans text-lg hover:text-cyan-400 transition-colors cursor-pointer"
                   rel="noopener noreferrer"
                   data-nav-type="external">
                    会社概要
                </a>
                
                <a href="<?php echo esc_url(stepjam_get_site_option('privacy_policy_url', 'https://rootz-adl.com/privacy-policy-2/')); ?>" 
                   target="_blank"
                   class="text-left text-white font-sans text-lg hover:text-cyan-400 transition-colors cursor-pointer"
                   rel="noopener noreferrer"
                   data-nav-type="external">
                    個人情報保護に関して
                </a>
                
                <a href="<?php echo esc_url(home_url('/cancellation-policy/')); ?>" 
                   class="text-left text-white font-sans text-lg hover:text-cyan-400 transition-colors cursor-pointer"
                   data-nav-type="page">
                    キャンセルポリシー
                </a>
                
            </div>
            
        </div>
        
        <!-- Nav Bottom Decoration (Preserved Original) -->
        <div class="flex flex-row gap-2.5 items-end justify-start w-full p-0 opacity-20" 
             data-name="nav-item_obi">
            
            <div class="relative shrink-0" 
                 style="width: clamp(800px, 1215.55px, 100%); height: clamp(30px, 37.03px, 45px);" 
                 data-name="open-obi">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/nav/open-obi.svg'); ?>" 
                     alt="Navigation Decoration" 
                     class="block max-w-none w-full h-full" />
            </div>
            
        </div>
        
    </div>
    
</nav>

<!-- JavaScript functionality delegated to main.js STEPJAMreApp class -->

<!-- Tooltip styles for unavailable menu items -->
<style>
.nav-submenu-item[data-nav-type="unavailable"]:hover::after {
    content: attr(title);
    position: absolute;
    bottom: -30px;
    left: 0;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
    font-weight: normal;
}

.nav-submenu-item[data-nav-type="unavailable"] {
    position: relative;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .nav-menu-item {
        font-size: 2rem !important;
    }
    
    .nav-submenu-item {
        font-size: 1rem !important;
    }
    
    .next-submenu {
        margin-left: 1rem !important;
    }
}

@media (max-width: 480px) {
    .nav-menu-item {
        font-size: 1.75rem !important;
    }
    
    .nav-submenu-item {
        font-size: 0.9rem !important;
    }
}
</style>