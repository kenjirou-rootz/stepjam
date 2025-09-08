<?php
/**
 * Info & News アーカイブページテンプレート - 新デザイン対応
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="info-news-archive-container">
    
    <?php if (have_posts()) : ?>
    
        <!-- Desktop Layout - 全6記事詳細表示 -->
        <div class="info-news-archive-desktop">
            <?php 
            $posts = get_posts(array(
                'post_type' => 'info-news',
                'posts_per_page' => -1,
                'post_status' => 'publish'
            ));
            
            foreach ($posts as $post) : 
                setup_postdata($post);
                
                $visual_type = get_field('info_news_visual_type');
                $show_date = get_field('info_news_show_date');
                ?>
                
                <article class="info-news-archive-item">
                    <a href="<?php the_permalink(); ?>" class="info-news-archive-link">
                        
                        <!-- Visual Content -->
                        <div class="info-news-archive-visual">
                            <?php if ($visual_type === 'video'): 
                                $video_url = get_field('info_news_video_url');
                                $video_thumbnail = get_field('info_news_video_thumbnail');
                                ?>
                                <div class="info-news-archive-video-container">
                                    <?php if ($video_thumbnail): ?>
                                        <img src="<?php echo esc_url($video_thumbnail['url']); ?>" 
                                             alt="<?php echo esc_attr($video_thumbnail['alt'] ?: get_the_title()); ?>">
                                    <?php elseif ($video_url): ?>
                                        <div class="info-news-archive-video-embed">
                                            <?php echo wp_oembed_get($video_url); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: 
                                $main_image = get_field('info_news_image');
                                if ($main_image): ?>
                                    <div class="info-news-archive-image-container">
                                        <img src="<?php echo esc_url($main_image['url']); ?>" 
                                             alt="<?php echo esc_attr($main_image['alt'] ?: get_the_title()); ?>">
                                    </div>
                                <?php endif;
                            endif; ?>
                        </div>
                        
                        <!-- Content Area -->
                        <div class="info-news-archive-content">
                            
                            <!-- TAG Label - info/news条件分岐表示 -->
                            <?php 
                            $tags = get_the_terms(get_the_ID(), 'info-news-type');
                            $tag_display = 'TAG'; // デフォルト
                            
                            if ($tags && !is_wp_error($tags) && count($tags) > 0) {
                                $tag_slug = $tags[0]->slug;
                                if ($tag_slug === 'info') {
                                    $tag_display = 'INFO';
                                } elseif ($tag_slug === 'news') {
                                    $tag_display = 'NEWS';
                                }
                            }
                            
                            $tag_class = 'info-news-archive-tag';
                            if (isset($tag_slug)) {
                                if ($tag_slug === 'info') {
                                    $tag_class .= ' info-news-archive-tag-info';
                                } elseif ($tag_slug === 'news') {
                                    $tag_class .= ' info-news-archive-tag-news';
                                }
                            }
                            ?>
                            <div class="<?php echo esc_attr($tag_class); ?>">
                                <?php echo esc_html($tag_display); ?>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="info-news-archive-title">
                                <?php the_title(); ?>
                            </h2>
                            
                            <!-- Excerpt -->
                            <div class="info-news-archive-excerpt">
                                <?php
                                $content = get_the_content();
                                $excerpt = wp_trim_words($content, 45, '...'); /* 4行表示に対応するため文字数増加 */
                                echo wp_kses_post($excerpt);
                                ?>
                            </div>
                            
                            <!-- Date -->
                            <?php if ($show_date): ?>
                                <div class="info-news-archive-date">
                                    <?php echo get_the_date('Y.m.d'); ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        
                    </a>
                </article>
                
            <?php endforeach;
            wp_reset_postdata(); ?>
        </div>
        
        <!-- Mobile Layout - 全6記事詳細表示 -->
        <div class="info-news-archive-mobile">
            <?php 
            $mobile_posts = get_posts(array(
                'post_type' => 'info-news',
                'posts_per_page' => -1,
                'post_status' => 'publish'
            ));
            
            foreach ($mobile_posts as $post) : 
                setup_postdata($post);
                
                $visual_type = get_field('info_news_visual_type');
                $show_date = get_field('info_news_show_date');
                ?>
                
                <article class="info-news-archive-item">
                    <a href="<?php the_permalink(); ?>" class="info-news-archive-link">
                        
                        <!-- Visual Content -->
                        <div class="info-news-archive-visual">
                            <?php if ($visual_type === 'video'): 
                                $video_url = get_field('info_news_video_url');
                                $video_thumbnail = get_field('info_news_video_thumbnail');
                                ?>
                                <div class="info-news-archive-video-container">
                                    <?php if ($video_thumbnail): ?>
                                        <img src="<?php echo esc_url($video_thumbnail['url']); ?>" 
                                             alt="<?php echo esc_attr($video_thumbnail['alt'] ?: get_the_title()); ?>">
                                    <?php elseif ($video_url): ?>
                                        <div class="info-news-archive-video-embed">
                                            <?php echo wp_oembed_get($video_url); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: 
                                $main_image = get_field('info_news_image');
                                if ($main_image): ?>
                                    <div class="info-news-archive-image-container">
                                        <img src="<?php echo esc_url($main_image['url']); ?>" 
                                             alt="<?php echo esc_attr($main_image['alt'] ?: get_the_title()); ?>">
                                    </div>
                                <?php endif;
                            endif; ?>
                        </div>
                        
                        <!-- Content Area -->
                        <div class="info-news-archive-content">
                            
                            <!-- TAG Label - info/news条件分岐表示 -->
                            <?php 
                            $tags = get_the_terms(get_the_ID(), 'info-news-type');
                            $tag_display = 'TAG'; // デフォルト
                            
                            if ($tags && !is_wp_error($tags) && count($tags) > 0) {
                                $tag_slug = $tags[0]->slug;
                                if ($tag_slug === 'info') {
                                    $tag_display = 'INFO';
                                } elseif ($tag_slug === 'news') {
                                    $tag_display = 'NEWS';
                                }
                            }
                            
                            $tag_class = 'info-news-archive-tag';
                            if (isset($tag_slug)) {
                                if ($tag_slug === 'info') {
                                    $tag_class .= ' info-news-archive-tag-info';
                                } elseif ($tag_slug === 'news') {
                                    $tag_class .= ' info-news-archive-tag-news';
                                }
                            }
                            ?>
                            <div class="<?php echo esc_attr($tag_class); ?>">
                                <?php echo esc_html($tag_display); ?>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="info-news-archive-title">
                                <?php the_title(); ?>
                            </h2>
                            
                            <!-- Excerpt -->
                            <div class="info-news-archive-excerpt">
                                <?php
                                $content = get_the_content();
                                $excerpt = wp_trim_words($content, 40, '...'); /* 4行表示に対応するため文字数増加 */
                                echo wp_kses_post($excerpt);
                                ?>
                            </div>
                            
                            <!-- Date -->
                            <?php if ($show_date): ?>
                                <div class="info-news-archive-date">
                                    <?php echo get_the_date('Y.m.d'); ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        
                    </a>
                </article>
                
            <?php endforeach;
            wp_reset_postdata(); ?>
        </div>
        
    <?php else : ?>
        <div class="info-news-archive-no-posts">
            <p>記事が見つかりません。</p>
        </div>
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>