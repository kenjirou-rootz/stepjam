<?php
/**
 * CSS/JavaScript読み込み設定
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

/**
 * フロントエンド用スクリプト・スタイル読み込み
 */
function stepjam_enqueue_scripts() {
    // 現在のTailwind CSS CDNを一時的に使用（後でビルド版に変更予定）
    wp_enqueue_script(
        'tailwind-cdn',
        'https://cdn.tailwindcss.com',
        array(),
        null,
        false
    );
    
    // Swiper CSS (必要に応じて)
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );
    
    // メインCSS（キャッシュバスト版 - Phase3強制適用）
    wp_enqueue_style(
        'stepjam-main-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        '1.0.0-phase3-' . time()
    );
    
    // Swiper JS を先に読み込み（main.jsより前に）
    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );
    
    // メインJavaScript（Swiper.jsに依存）
    wp_enqueue_script(
        'stepjam-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('swiper-js'), // Swiper.jsへの依存を明示
        '1.0.0',
        true
    );
    
    // 独立ダンサーSlider JavaScript（既存システムと完全独立）
    wp_enqueue_script(
        'stepjam-dancers-slider',
        get_template_directory_uri() . '/assets/js/dancers-slider.js',
        array(), // 既存システムに依存しない独立動作
        '1.0.0',
        true
    );
    
    // FAQ Accordion CSS（モダンアニメーション）
    wp_enqueue_style(
        'stepjam-faq-animations',
        get_template_directory_uri() . '/assets/css/faq-animations.css',
        array(),
        '1.0.0'
    );
    
    // FAQ Accordion JavaScript（完全分離コンポーネント）
    wp_enqueue_script(
        'stepjam-faq-accordion',
        get_template_directory_uri() . '/assets/js/faq-accordion.js',
        array(), // 既存main.jsとの完全独立
        '1.0.0',
        true
    );
    
    // Smooth Fade Animations JavaScript（汎用フェードインアニメーション）
    wp_enqueue_script(
        'stepjam-smooth-fade-animations',
        get_template_directory_uri() . '/assets/js/smooth-fade-animations.js',
        array(), // 完全独立動作
        '1.0.0',
        true
    );
    
    // WordPress用データの受け渡し（Ajax用）
    wp_localize_script('stepjam-main', 'stepjam_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('stepjam_nonce'),
        'home_url' => home_url('/'),
        'theme_url' => get_template_directory_uri()
    ));
}
add_action('wp_enqueue_scripts', 'stepjam_enqueue_scripts');

/**
 * 管理画面用スクリプト・スタイル読み込み
 */
function stepjam_admin_enqueue_scripts($hook) {
    // 必要に応じて管理画面用のスクリプトを追加
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_script(
            'stepjam-admin',
            get_template_directory_uri() . '/assets/js/admin.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action('admin_enqueue_scripts', 'stepjam_admin_enqueue_scripts');

/**
 * Tailwind Config（インライン）
 * 現在のHTMLの設定を維持
 */
function stepjam_tailwind_config() {
    ?>
    <script>
        if (typeof tailwind !== 'undefined') {
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'figma-black': '#000000',
                            'figma-white': '#FFFFFF',
                            'figma-cyan': '#00F7FF'
                        },
                        spacing: {
                            'hero-full': '67.5rem',
                            'hero-fv': '41.625rem',
                            'make-logo-w': '73.774rem',
                            'make-logo-h': '12.479rem',
                            'make-mobile-w': '36.5rem',
                            'make-mobile-h': '6.125rem',
                            'sp-hero-box-w': '48.009rem',
                            'sp-hero-box-h': '41.616rem',
                            'sp-make-logo-w': '29.509rem',
                            'sp-make-logo-h': '4.991rem'
                        },
                        fontSize: {
                            'xs': ['0.75rem', { lineHeight: '1rem' }],
                            'sm': ['0.875rem', { lineHeight: '1.25rem' }],
                            'base': ['1rem', { lineHeight: '1.5rem' }],
                            'lg': ['1.125rem', { lineHeight: '1.75rem' }],
                            'xl': ['1.25rem', { lineHeight: '1.75rem' }],
                            '2xl': ['1.5rem', { lineHeight: '2rem' }],
                            '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
                            '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
                            '5xl': ['3rem', { lineHeight: '1' }]
                        },
                        screens: {
                            'mobile': {'max': '767px'},
                            'tablet': '768px'
                        }
                    }
                }
            };
        }
    </script>
    <?php
}
add_action('wp_head', 'stepjam_tailwind_config');

/**
 * 不要なWordPressデフォルトスタイル・スクリプトの削除
 */
function stepjam_dequeue_unnecessary_scripts() {
    // クラシックテーマブロックエディタCSS削除
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    
    // WordPress絵文字スクリプト削除
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('wp_enqueue_scripts', 'stepjam_dequeue_unnecessary_scripts', 100);