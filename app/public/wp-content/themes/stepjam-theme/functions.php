<?php
/**
 * STEPJAM Theme Functions
 * 
 * @package STEPJAM_Theme
 * @version 1.0.0
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

// QA検証: 統合環境テスト実行 - 2025-09-08
define('STEPJAM_QA_TEST_TIMESTAMP', '2025-09-08-125900');

// 基本設定
require_once get_template_directory() . '/inc/enqueue-scripts.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * テーマサポート設定
 */
function stepjam_theme_setup() {
    // HTML5サポート
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // 投稿サムネイル有効化
    add_theme_support('post-thumbnails');
    
    // カスタムロゴサポート
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // メニューサポート
    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
    ));
    
    // タイトルタグサポート
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'stepjam_theme_setup');

/**
 * ウィジェット領域設定
 */
function stepjam_widgets_init() {
    register_sidebar(array(
        'name'          => 'Main Sidebar',
        'id'            => 'sidebar-1',
        'description'   => 'Main sidebar widget area',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'stepjam_widgets_init');

/**
 * 画像サイズ追加
 */
function stepjam_image_sizes() {
    add_image_size('dancer-thumb', 300, 300, true);
    add_image_size('sponsor-logo', 200, 100, true);
    add_image_size('news-thumb', 400, 250, true);
}
add_action('after_setup_theme', 'stepjam_image_sizes');

/**
 * WP管理バー非表示（フロントエンド）
 */
if (!is_admin()) {
    show_admin_bar(false);
}

/**
 * 開発用デバッグ情報
 * WP_DEBUG が true の時のみ動作
 */
function stepjam_debug_info() {
    if (defined('WP_DEBUG') && WP_DEBUG && is_front_page()) {
        echo "<!-- STEPJAM Debug Info -->\n";
        echo "<!-- ACF Pro Active: " . (function_exists('get_field') ? 'Yes' : 'No') . " -->\n";
        echo "<!-- Current Theme: " . wp_get_theme()->get('Name') . " -->\n";
        echo "<!-- WordPress Version: " . get_bloginfo('version') . " -->\n";
        echo "<!-- QA Test Timestamp: " . (defined('STEPJAM_QA_TEST_TIMESTAMP') ? STEPJAM_QA_TEST_TIMESTAMP : 'Not Set') . " -->\n";
        echo "<!-- End Debug Info -->\n";
    }
}
add_action('wp_head', 'stepjam_debug_info');

/**
 * セキュリティ強化
 */
// XMLRPCを無効化
add_filter('xmlrpc_enabled', '__return_false');

// WordPressバージョン非表示
remove_action('wp_head', 'wp_generator');

// WLWManifest非表示
remove_action('wp_head', 'wlwmanifest_link');

// RSD非表示
remove_action('wp_head', 'rsd_link');

/**
 * 管理画面カスタマイズ
 */
function stepjam_admin_styles() {
    echo '<style>
        .stepjam-admin-notice {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-left: 4px solid #28a745;
            padding: 12px;
            margin: 5px 0 15px;
        }
    </style>';
}
add_action('admin_head', 'stepjam_admin_styles');

/**
 * カスタムフィールド値のサニタイズ
 */
function stepjam_sanitize_acf_output($value) {
    if (is_string($value)) {
        return wp_kses_post($value);
    }
    return $value;
}

/**
 * パフォーマンス最適化
 * 不要なスクリプト・スタイル削除
 */
function stepjam_optimize_performance() {
    if (!is_admin()) {
        // 絵文字スクリプト削除
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        
        // oEmbed削除
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
    }
}
add_action('init', 'stepjam_optimize_performance');

/**
 * エラーログ設定（開発環境）
 */
if (defined('WP_DEBUG') && WP_DEBUG) {
    function stepjam_log($message) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}