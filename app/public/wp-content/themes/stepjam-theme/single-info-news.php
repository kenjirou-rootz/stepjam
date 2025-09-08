<?php
/**
 * Info & News 単体記事テンプレート
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<div class="info-news-single-container">
    <!-- Desktop Layout -->
    <div class="info-news-desktop-layout hidden md:grid">
        <!-- Left Column: Visual Content -->
        <div class="info-news-visual-column">
            <?php
            $visual_type = get_field('info_news_visual_type');
            $show_date = get_field('info_news_show_date');
            $show_category = get_field('info_news_show_category');
            
            if ($visual_type === 'video'): 
                $video_url = get_field('info_news_video_url');
                $video_thumbnail = get_field('info_news_video_thumbnail');
                ?>
                <div class="info-news-video-container">
                    <?php if ($video_url): ?>
                        <div class="info-news-video-embed">
                            <?php echo wp_oembed_get($video_url); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($video_thumbnail && !$video_url): ?>
                        <div class="info-news-video-thumbnail">
                            <img src="<?php echo esc_url($video_thumbnail['url']); ?>" 
                                 alt="<?php echo esc_attr($video_thumbnail['alt'] ?: get_the_title()); ?>"
                                 width="<?php echo esc_attr($video_thumbnail['width']); ?>"
                                 height="<?php echo esc_attr($video_thumbnail['height']); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: 
                $main_image = get_field('info_news_image');
                if ($main_image): ?>
                    <div class="info-news-image-container">
                        <img src="<?php echo esc_url($main_image['url']); ?>" 
                             alt="<?php echo esc_attr($main_image['alt'] ?: get_the_title()); ?>"
                             width="<?php echo esc_attr($main_image['width']); ?>"
                             height="<?php echo esc_attr($main_image['height']); ?>">
                    </div>
                <?php endif;
            endif; ?>
        </div>

        <!-- Right Column: Content -->
        <div class="info-news-content-column">
            <div class="info-news-content-inner">
                <!-- Meta Information -->
                <div class="info-news-meta">
                    <?php if ($show_date): ?>
                        <div class="info-news-date">
                            <?php echo get_the_date('Y.m.d'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($show_category): 
                        $categories = get_the_terms(get_the_ID(), 'info-news-type');
                        if ($categories && !is_wp_error($categories)): ?>
                            <div class="info-news-categories">
                                <?php foreach ($categories as $category): ?>
                                    <span class="info-news-category-tag"><?php echo esc_html($category->name); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif;
                    endif; ?>
                </div>

                <!-- Title -->
                <h1 class="info-news-title"><?php the_title(); ?></h1>

                <!-- Content -->
                <div class="info-news-content">
                    <?php the_content(); ?>
                </div>

                <!-- Link Button -->
                <?php 
                $show_button = get_field('info_news_show_button');
                if ($show_button):
                    $button_text = get_field('info_news_button_text');
                    $button_url = get_field('info_news_button_url');
                    $button_target = get_field('info_news_button_target');
                    ?>
                    <div class="info-news-button-container">
                        <a href="<?php echo esc_url($button_url); ?>" 
                           target="<?php echo esc_attr($button_target ?: '_blank'); ?>"
                           class="info-news-link-button">
                            <?php echo esc_html($button_text ?: '詳細を見る'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mobile Layout -->
    <div class="info-news-mobile-layout block md:hidden">
        <!-- Header Area -->
        <div class="info-news-mobile-header-area">
            <!-- Meta Information -->
            <?php if ($show_date): ?>
                <div class="info-news-mobile-date">
                    <?php echo get_the_date('Y.m.d'); ?>
                </div>
            <?php endif; ?>
            
            <!-- Title -->
            <h1 class="info-news-mobile-title"><?php the_title(); ?></h1>
        </div>

        <!-- Visual Area -->
        <div class="info-news-mobile-visual-area">
            <?php if ($visual_type === 'video'): 
                $video_url = get_field('info_news_video_url');
                $video_thumbnail = get_field('info_news_video_thumbnail');
                ?>
                <div class="info-news-mobile-video-container">
                    <?php if ($video_url): ?>
                        <div class="info-news-mobile-video-embed">
                            <?php echo wp_oembed_get($video_url); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($video_thumbnail && !$video_url): ?>
                        <div class="info-news-mobile-video-thumbnail">
                            <img src="<?php echo esc_url($video_thumbnail['url']); ?>" 
                                 alt="<?php echo esc_attr($video_thumbnail['alt'] ?: get_the_title()); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: 
                $main_image = get_field('info_news_image');
                if ($main_image): ?>
                    <div class="info-news-mobile-image-container">
                        <img src="<?php echo esc_url($main_image['url']); ?>" 
                             alt="<?php echo esc_attr($main_image['alt'] ?: get_the_title()); ?>">
                    </div>
                <?php endif;
            endif; ?>
        </div>

        <!-- Content Area -->
        <div class="info-news-mobile-content-area">
            <!-- Content -->
            <div class="info-news-mobile-content">
                <?php the_content(); ?>
            </div>

            <!-- Link Button -->
            <?php if ($show_button): ?>
                <div class="info-news-mobile-button-container">
                    <a href="<?php echo esc_url($button_url); ?>" 
                       target="<?php echo esc_attr($button_target ?: '_blank'); ?>"
                       class="info-news-mobile-link-button">
                        <?php echo esc_html($button_text ?: '詳細を見る'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>