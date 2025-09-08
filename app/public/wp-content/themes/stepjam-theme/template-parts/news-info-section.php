<?php
/**
 * News & Info セクション
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

// Info記事を取得（infoタグ付き）
$info_args = array(
    'post_type' => 'info-news',
    'posts_per_page' => 7,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'info-news-type',
            'field' => 'slug',
            'terms' => 'info',
        ),
    ),
);
$info_posts = get_posts($info_args);

// News記事を取得（newsタグ付き）
$news_args = array(
    'post_type' => 'info-news',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'info-news-type',
            'field' => 'slug',
            'terms' => 'news',
        ),
    ),
);
$news_posts = get_posts($news_args);
?>

<!-- News & Info Section -->
<section class="news-info-section">
    
    <!-- Desktop Layout (≥768px) -->
    <div class="news-info-desktop">
        
        <!-- Info Column -->
        <div class="info-column">
            <div class="info-heading">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/news-info/info-title.svg'); ?>" 
                     alt="Info" 
                     class="info-heading-svg" />
            </div>
            
            <?php if ($info_posts) : ?>
                <div class="info-list">
                    <?php foreach ($info_posts as $post) : 
                        setup_postdata($post);
                        $show_date = get_field('info_news_show_date');
                        ?>
                        <article class="info-item">
                            <a href="<?php the_permalink(); ?>" class="info-link">
                                <div class="info-content">
                                    <?php if ($show_date): ?>
                                        <time class="info-date" datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date('m'); ?><br><?php echo get_the_date('d'); ?>
                                        </time>
                                    <?php else: ?>
                                        <div class="info-date">
                                            info
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="info-title"><?php the_title(); ?></h3>
                                    <p class="info-excerpt">
                                        <?php echo wp_trim_words(get_the_content(), 30, '...'); ?>
                                    </p>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; 
                    wp_reset_postdata(); ?>
                </div>
                
                <a href="<?php echo esc_url(get_post_type_archive_link('info-news')); ?>" class="read-more-link">
                    Read More <span class="arrow">›</span>
                </a>
            <?php else : ?>
                <p class="no-posts">現在、Info記事はありません。</p>
            <?php endif; ?>
        </div>
        
        <!-- News Column -->
        <div class="news-column">
            <div class="news-heading">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/news-info/news-title.svg'); ?>" 
                     alt="News" 
                     class="news-heading-svg" />
            </div>
            
            <?php if ($news_posts) : ?>
                <div class="news-grid">
                    <?php foreach ($news_posts as $post) : 
                        setup_postdata($post);
                        $visual_type = get_field('info_news_visual_type');
                        $show_date = get_field('info_news_show_date');
                        // デフォルトで日付を表示（フィールドが空の場合）
                        if ($show_date === '' || $show_date === null) {
                            $show_date = true;
                        }
                        
                        ?>
                        <article class="news-item">
                            <a href="<?php the_permalink(); ?>" class="news-link">
                                
                                <!-- Visual Area -->
                                <div class="news-visual">
                                    <?php if ($visual_type === 'video'): 
                                        $video_thumbnail = get_field('info_news_video_thumbnail');
                                        if ($video_thumbnail): ?>
                                            <img src="<?php echo esc_url(is_array($video_thumbnail) && isset($video_thumbnail['url']) ? $video_thumbnail['url'] : $video_thumbnail); ?>" 
                                                 alt="<?php echo esc_attr((is_array($video_thumbnail) && isset($video_thumbnail['alt'])) ? $video_thumbnail['alt'] : get_the_title()); ?>"
                                                 class="news-image">
                                        <?php endif;
                                    else: 
                                        $main_image = get_field('info_news_image');
                                        if ($main_image): ?>
                                            <img src="<?php echo esc_url(is_array($main_image) && isset($main_image['url']) ? $main_image['url'] : $main_image); ?>" 
                                                 alt="<?php echo esc_attr((is_array($main_image) && isset($main_image['alt'])) ? $main_image['alt'] : get_the_title()); ?>"
                                                 class="news-image">
                                        <?php endif;
                                    endif; ?>
                                </div>
                                
                                <!-- Content Area -->
                                <div class="news-content">
                                    <?php if ($show_date): ?>
                                        <time class="news-date" datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date('m/d'); ?>
                                        </time>
                                    <?php endif; ?>
                                    
                                    <h3 class="news-title"><?php the_title(); ?></h3>
                                    
                                    <p class="news-excerpt">
                                        <?php echo wp_trim_words(get_the_content(), 40, '...'); ?>
                                    </p>
                                </div>
                                
                            </a>
                        </article>
                    <?php endforeach; 
                    wp_reset_postdata(); ?>
                </div>
                
                <a href="<?php echo esc_url(get_post_type_archive_link('info-news')); ?>" class="read-more-link">
                    Read More <span class="arrow">›</span>
                </a>
            <?php else : ?>
                <p class="no-posts">現在、News記事はありません。</p>
            <?php endif; ?>
        </div>
        
    </div>
    
    <!-- Mobile Layout (≤767px) -->
    <div class="news-info-mobile">
        
        <!-- Mobile Info Section -->
        <div class="mobile-info-section">
            <div class="mobile-info-heading">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/news-info/info-title.svg'); ?>" 
                     alt="Info" 
                     class="mobile-info-heading-svg" />
            </div>
            
            <?php if ($info_posts) : ?>
                <div class="mobile-info-list">
                    <?php foreach ($info_posts as $post) : 
                        setup_postdata($post);
                        $show_date = get_field('info_news_show_date');
                        ?>
                        <article class="mobile-info-item">
                            <a href="<?php the_permalink(); ?>" class="mobile-info-link">
                                <?php if ($show_date): ?>
                                    <time class="mobile-info-date" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date('m'); ?><br><?php echo get_the_date('d'); ?>
                                    </time>
                                <?php else: ?>
                                    <div class="mobile-info-date">
                                        info
                                    </div>
                                <?php endif; ?>
                                <div class="mobile-info-content">
                                    <h3 class="mobile-info-title"><?php the_title(); ?></h3>
                                    <p class="mobile-info-excerpt">
                                        <?php echo wp_trim_words(get_the_content(), 25, '...'); ?>
                                    </p>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; 
                    wp_reset_postdata(); ?>
                </div>
                
                <a href="<?php echo esc_url(get_post_type_archive_link('info-news')); ?>" class="mobile-read-more">
                    Read More <span class="arrow">›</span>
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Mobile News Section -->
        <div class="mobile-news-section">
            <div class="mobile-news-heading">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/news-info/news-title.svg'); ?>" 
                     alt="News" 
                     class="mobile-news-heading-svg" />
            </div>
            
            <?php if ($news_posts) : ?>
                <div class="mobile-news-list">
                    <?php foreach ($news_posts as $post) : 
                        setup_postdata($post);
                        $visual_type = get_field('info_news_visual_type');
                        $show_date = get_field('info_news_show_date');
                        // デフォルトで日付を表示（フィールドが空の場合）
                        if ($show_date === '' || $show_date === null) {
                            $show_date = true;
                        }
                        ?>
                        <article class="mobile-news-item">
                            <a href="<?php the_permalink(); ?>" class="mobile-news-link">
                                
                                <!-- Visual Area -->
                                <div class="mobile-news-visual">
                                    <?php if ($visual_type === 'video'): 
                                        $video_thumbnail = get_field('info_news_video_thumbnail');
                                        if ($video_thumbnail): ?>
                                            <img src="<?php echo esc_url(is_array($video_thumbnail) && isset($video_thumbnail['url']) ? $video_thumbnail['url'] : $video_thumbnail); ?>" 
                                                 alt="<?php echo esc_attr((is_array($video_thumbnail) && isset($video_thumbnail['alt'])) ? $video_thumbnail['alt'] : get_the_title()); ?>"
                                                 class="mobile-news-image">
                                        <?php endif;
                                    else: 
                                        $main_image = get_field('info_news_image');
                                        if ($main_image): ?>
                                            <img src="<?php echo esc_url(is_array($main_image) && isset($main_image['url']) ? $main_image['url'] : $main_image); ?>" 
                                                 alt="<?php echo esc_attr((is_array($main_image) && isset($main_image['alt'])) ? $main_image['alt'] : get_the_title()); ?>"
                                                 class="mobile-news-image">
                                        <?php endif;
                                    endif; ?>
                                </div>
                                
                                <!-- Content Area -->
                                <div class="mobile-news-content">
                                    <?php if ($show_date): ?>
                                        <time class="mobile-news-date" datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date('m/d'); ?>
                                        </time>
                                    <?php endif; ?>
                                    
                                    <h3 class="mobile-news-title"><?php the_title(); ?></h3>
                                    
                                    <p class="mobile-news-excerpt">
                                        <?php echo wp_trim_words(get_the_content(), 30, '...'); ?>
                                    </p>
                                </div>
                                
                            </a>
                        </article>
                    <?php endforeach; 
                    wp_reset_postdata(); ?>
                </div>
                
                <a href="<?php echo esc_url(get_post_type_archive_link('info-news')); ?>" class="mobile-read-more">
                    Read More <span class="arrow">›</span>
                </a>
            <?php endif; ?>
        </div>
        
    </div>
    
</section>