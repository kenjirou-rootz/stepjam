<?php
/**
 * ACFフィールド設定
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ACFオプションページの作成
 */
function stepjam_acf_add_options_page() {
    if (function_exists('acf_add_options_page')) {
        // Site Settings オプションページ
        acf_add_options_page(array(
            'page_title' => 'Site Settings',
            'menu_title' => 'サイト設定',
            'menu_slug' => 'site-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-admin-settings',
            'position' => 30
        ));
        
        // Sponsor Settings オプションページ
        acf_add_options_page(array(
            'page_title' => 'スポンサー設定',
            'menu_title' => 'スポンサー',
            'menu_slug' => 'sponsor-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-star-filled',
            'position' => 31
        ));

        // WHSJ Settings オプションページ
        acf_add_options_page(array(
            'page_title' => 'WHSJ設定',
            'menu_title' => 'WHSJ',
            'menu_slug' => 'whsj-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-video-alt3',
            'position' => 32
        ));
    }
}
add_action('acf/init', 'stepjam_acf_add_options_page');

function stepjam_register_acf_fields() {
    if(!function_exists('acf_add_local_field_group')) {
        return;
    }

    // ダンサー登録設定 Group - Removed 2025-09-09: Converted to Admin Field Group (group_toroku_dancer)
    // Now managed through WordPress Admin interface with JSON sync enabled

    // スポンサー設定 Group - Removed 2025-09-09: Converted to Admin Field Group (group_sponsor)
    // Now managed through WordPress Admin interface with JSON sync enabled

    // サイト設定 Group - Removed 2025-09-09: Converted to Admin Field Group (group_site_options)
    // Now managed through WordPress Admin interface with JSON sync enabled

    // WHSJ設定 Group - Removed 2025-09-09: Converted to Admin Field Group (group_whsj)
    // Now managed through WordPress Admin interface with JSON sync enabled

    // INFO・NEWS記事設定 Group - Removed 2025-09-09: Converted to Admin Field Group (group_info_news)
    // Now managed through WordPress Admin interface with JSON sync enabled

    // NX TOKYO イベント設定 Group - Removed 2025-09-09: Converted to Admin Field Group (group_nx_tokyo)
    // Now managed through WordPress Admin interface with JSON sync enabled
}
add_action('acf/init', 'stepjam_register_acf_fields');

/**
 * ACFフィールド値取得のヘルパー関数
 */
function stepjam_get_site_option($field_name, $default = '') {
    if (function_exists('get_field')) {
        $value = get_field($field_name, 'option');
        return $value ?: $default;
    }
    return $default;
}

/**
 * YouTube URL をiframe埋め込みHTMLに変換
 */
function stepjam_youtube_url_to_iframe($url, $width = '100%', $height = '315') {
    if (empty($url)) {
        return '';
    }
    
    // YouTube URL パターン解析
    $patterns = array(
        '/youtube\.com\/watch\?v=([^&\n]+)/',
        '/youtube\.com\/embed\/([^&\n]+)/',
        '/youtu\.be\/([^&\n]+)/'
    );
    
    $video_id = '';
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            $video_id = $matches[1];
            break;
        }
    }
    
    if (empty($video_id)) {
        return '';
    }
    
    return sprintf(
        '<iframe width="%s" height="%s" src="https://www.youtube.com/embed/%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
        esc_attr($width),
        esc_attr($height),
        esc_attr($video_id)
    );
}

/**
 * toroku-dancer投稿の取得関数（アイキャッチ画像必須）
 */
function stepjam_get_dancers_with_acf($location = '', $count = -1) {
    $args = array(
        'post_type' => 'toroku-dancer',
        'posts_per_page' => $count,
        'orderby' => 'rand',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            )
        )
    );

    // ロケーション指定がある場合
    if (!empty($location)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'toroku-dancer-location',
                'field' => 'slug',
                'terms' => $location
            )
        );
    }

    return new WP_Query($args);
}

/**
 * FAQフィールドグループの登録
 */
// FAQ Management Group - Removed 2025-09-09: Converted to Admin Field Group (group_faq)
// Now managed through WordPress Admin interface with JSON sync enabled