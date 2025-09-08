<!DOCTYPE html>
<html <?php language_attributes(); ?> class="h-full">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO設定 -->
    <meta name="description" content="<?php echo get_bloginfo('description'); ?>">
    
    <!-- WordPress head処理 -->
    <?php wp_head(); ?>
</head>
<body <?php body_class('h-full bg-black text-white font-sans antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- Navigation Overlay -->
<?php get_template_part('template-parts/nav-overlay'); ?>

<!-- Header Section -->
<header class="fixed top-0 left-0 w-full bg-black" style="height: 97.36px; z-index: var(--z-fixed-header);" data-acf="header-section">
    <div class="w-full h-full relative">
        <!-- Navigation Area - 元HTML正確位置・サイズ準拠 -->
        <div style="position: absolute; 
                    left: 0; 
                    top: 0; 
                    width: 173.08px; 
                    height: 97.36px;">
            <button id="nav-toggle"
                    class="w-full h-full bg-transparent hover:bg-white hover:bg-opacity-10 transition-colors"
                    aria-label="メニュー開閉"
                    data-acf="nav-button">
                <?php 
                $nav_icon = stepjam_get_site_option('nav_icon', get_template_directory_uri() . '/assets/header/header-nav.svg');
                ?>
                <img src="<?php echo esc_url($nav_icon); ?>" 
                     alt="Navigation" 
                     class="w-full h-full object-contain" />
            </button>
        </div>
        
        <!-- Logo Area - 元HTML正確位置・サイズ準拠（217px） -->
        <div style="position: absolute; 
                    left: 217px; 
                    top: 50%; 
                    transform: translateY(-50%); 
                    width: 96.75px; 
                    height: 22.415px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" 
               class="block w-full h-full"
               data-acf="logo-link">
                <?php 
                $header_logo = stepjam_get_site_option('header_logo', get_template_directory_uri() . '/assets/header/header-logo.svg');
                ?>
                <img src="<?php echo esc_url($header_logo); ?>" 
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                     class="w-full h-full object-contain" />
            </a>
        </div>
        
    </div>
</header>

<!-- Main Content with Header Offset -->
<div class="w-full" style="margin-top: 97.36px;"></div>