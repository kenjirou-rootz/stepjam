<?php
/**
 * 登録ダンサー詳細ページテンプレート（完全再構築版）
 * 
 * @package STEPJAM_Theme
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); 
    // ACFフィールド値取得
    $dancer_genre = get_field('dancer_genre') ?: 'HIP-HOP';
    $dancer_profile_text = get_field('dancer_profile_text') ?: '';
    $performance_video_1 = get_field('performance_video_1') ?: '';
    $performance_video_2 = get_field('performance_video_2') ?: '';
    $performance_fixed_image = get_field('performance_fixed_image') ?: '';
    $instagram_url = get_field('toroku_instagram_url') ?: '';
    $twitter_url = get_field('toroku_twitter_url') ?: '';
    $youtube_url = get_field('toroku_youtube_url') ?: '';
    $tiktok_url = get_field('toroku_tiktok_url') ?: '';
    
    // アイキャッチ画像取得
    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<!-- 登録ダンサー詳細ページ - デザイン画像準拠 -->
<div class="toroku-dancer-detail">
    
    <!-- デスクトップ版レイアウト -->
    <div class="desktop-layout hidden md:grid">
        
        <!-- 左列: サムネイル画像エリア (30%) -->
        <div class="thumbnail-area">
            <?php if ($featured_image) : ?>
                <div class="thumbnail-image" style="background-image: url('<?php echo esc_url($featured_image); ?>');"></div>
            <?php else : ?>
                <div class="thumbnail-placeholder"></div>
            <?php endif; ?>
        </div>
        
        <!-- 右列: コンテンツエリア (70%) -->
        <div class="content-area">
            
            <!-- ヘッダーエリア -->
            <div class="header-area">
                <h1 class="dancer-name"><?php echo esc_html(get_the_title()); ?></h1>
                <p class="dancer-genre"><?php echo esc_html($dancer_genre); ?></p>
            </div>
            
            <!-- Performance セクション -->
            <div class="performance-section">
                <h2 class="section-title">Performance</h2>
                <div class="performance-container">
                    <!-- 左側: 固定画像エリア -->
                    <div class="performance-fixed-image">
                        <?php if ($performance_fixed_image) : ?>
                            <img src="<?php echo esc_url($performance_fixed_image['url']); ?>" 
                                 alt="<?php echo esc_attr($performance_fixed_image['alt'] ?: get_the_title() . ' Performance'); ?>" 
                                 class="fixed-image">
                        <?php else : ?>
                            <div class="image-placeholder"></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- 右側: YouTubeスライダーエリア -->
                    <div class="youtube-slider-container">
                        <div class="youtube-slider" data-auto-slide="4000">
                            <?php if ($performance_video_1) : ?>
                                <div class="slide active" data-video="<?php echo esc_attr($performance_video_1); ?>">
                                    <?php echo stepjam_youtube_url_to_iframe($performance_video_1, '100%', '100%'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($performance_video_2) : ?>
                                <div class="slide <?php echo !$performance_video_1 ? 'active' : ''; ?>" data-video="<?php echo esc_attr($performance_video_2); ?>">
                                    <?php echo stepjam_youtube_url_to_iframe($performance_video_2, '100%', '100%'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!$performance_video_1 && !$performance_video_2) : ?>
                                <div class="slide active">
                                    <div class="video-placeholder"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile セクション -->
            <div class="profile-section">
                <h2 class="section-title">Profile</h2>
                <div class="profile-content">
                    <div class="profile-text">
                        <?php echo wp_kses_post($dancer_profile_text); ?>
                    </div>
                    <div class="sns-icons">
                        <?php if ($instagram_url) : ?>
                            <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" class="sns-icon">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/icon-ins.svg'); ?>" alt="Instagram">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- モバイル版レイアウト -->
    <div class="mobile-layout md:hidden">
        
        <!-- ヘッダーエリア -->
        <div class="mobile-header">
            <h1 class="dancer-name"><?php echo esc_html(get_the_title()); ?></h1>
            <p class="dancer-genre"><?php echo esc_html($dancer_genre); ?></p>
        </div>
        
        <!-- サムネイル画像エリア -->
        <div class="mobile-thumbnail">
            <?php if ($featured_image) : ?>
                <div class="thumbnail-image" style="background-image: url('<?php echo esc_url($featured_image); ?>');"></div>
            <?php else : ?>
                <div class="thumbnail-placeholder"></div>
            <?php endif; ?>
        </div>
        
        <!-- Performance セクション -->
        <div class="mobile-performance">
            <h2 class="section-title">Performance</h2>
            
            <!-- 固定画像エリア -->
            <div class="mobile-fixed-image">
                <?php if ($performance_fixed_image) : ?>
                    <img src="<?php echo esc_url($performance_fixed_image['url']); ?>" 
                         alt="<?php echo esc_attr($performance_fixed_image['alt'] ?: get_the_title() . ' Performance'); ?>" 
                         class="fixed-image">
                <?php else : ?>
                    <div class="image-placeholder"></div>
                <?php endif; ?>
            </div>
            
            <!-- YouTubeスライダーエリア -->
            <div class="mobile-youtube-slider">
                <div class="youtube-slider" data-auto-slide="4000">
                    <?php if ($performance_video_1) : ?>
                        <div class="slide active" data-video="<?php echo esc_attr($performance_video_1); ?>">
                            <?php echo stepjam_youtube_url_to_iframe($performance_video_1, '100%', '100%'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($performance_video_2) : ?>
                        <div class="slide <?php echo !$performance_video_1 ? 'active' : ''; ?>" data-video="<?php echo esc_attr($performance_video_2); ?>">
                            <?php echo stepjam_youtube_url_to_iframe($performance_video_2, '100%', '100%'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!$performance_video_1 && !$performance_video_2) : ?>
                        <div class="slide active">
                            <div class="video-placeholder"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Profile セクション -->
        <div class="mobile-profile">
            <h2 class="section-title">Profile</h2>
            <div class="profile-text">
                <?php echo wp_kses_post($dancer_profile_text); ?>
            </div>
            <div class="sns-icons">
                <?php if ($instagram_url) : ?>
                    <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" class="sns-icon">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/icon-ins.svg'); ?>" alt="Instagram">
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
    </div>

</div>

<?php endwhile; ?>

<!-- Single Dancer Sponsor Section - Independent Template -->
<!-- Desktop Sponsor Section -->
<section class="hidden tablet:block relative w-full bg-black overflow-hidden single-sponsor-section">
    <div class="sponsor-section-container single-sponsor-container">
        <!-- Single Dancer Desktop Sponsor Container - Independent Template -->
        <?php get_template_part('template-parts/sponsor-single-area', null, array(
            'device_type' => 'desktop',
            'slider_class' => 'single-logo-slider-desktop'
        )); ?>
    </div>
</section>

<!-- Mobile Sponsor Section -->
<section class="block tablet:hidden relative w-full bg-black overflow-hidden single-sponsor-section">
    <div class="sponsor-section-container single-sponsor-container">
        <!-- Single Dancer Mobile Sponsor Container - Independent Template -->
        <?php get_template_part('template-parts/sponsor-single-area', null, array(
            'device_type' => 'mobile',
            'slider_class' => 'single-logo-slider-mobile'
        )); ?>
    </div>
</section>

<?php get_footer(); ?>