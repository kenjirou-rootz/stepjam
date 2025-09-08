<?php
/**
 * カスタム投稿タイプ・タクソノミー登録
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}


/**
 * toroku-dancerカスタム投稿タイプの登録
 */
function stepjam_register_toroku_dancer_post_type() {
    $labels = array(
        'name' => '登録ダンサー',
        'singular_name' => '登録ダンサー',
        'add_new' => '新規登録ダンサーを追加',
        'add_new_item' => '新しい登録ダンサーを追加',
        'edit_item' => '登録ダンサーを編集',
        'new_item' => '新しい登録ダンサー',
        'view_item' => '登録ダンサーを表示',
        'search_items' => '登録ダンサーを検索',
        'not_found' => '登録ダンサーが見つかりません',
        'not_found_in_trash' => 'ゴミ箱に登録ダンサーはありません'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'rest_base' => 'toroku-dancer',
        'query_var' => true,
        'rewrite' => array('slug' => 'toroku-dancer'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 6,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'menu_icon' => 'dashicons-admin-users'
    );

    register_post_type('toroku-dancer', $args);
}
add_action('init', 'stepjam_register_toroku_dancer_post_type');

/**
 * toroku-dancer-locationタクソノミーの登録
 */
function stepjam_register_toroku_dancer_location_taxonomy() {
    $labels = array(
        'name' => 'Toroku Dancer Locations',
        'singular_name' => 'Toroku Dancer Location',
        'search_items' => 'エリアを検索',
        'all_items' => 'すべてのエリア',
        'edit_item' => 'エリアを編集',
        'update_item' => 'エリアを更新',
        'add_new_item' => '新しいエリアを追加',
        'new_item_name' => '新しいエリア名'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'toroku-dancer-location',
            'with_front' => false,
            'hierarchical' => true
        )
    );

    register_taxonomy('toroku-dancer-location', array('toroku-dancer'), $args);
}
add_action('init', 'stepjam_register_toroku_dancer_location_taxonomy');

/**
 * toroku-dancer用デフォルトタームの作成
 */
function stepjam_create_default_toroku_dancer_locations() {
    // Tokyo タームの作成
    if (!term_exists('Tokyo', 'toroku-dancer-location')) {
        wp_insert_term(
            'Tokyo',
            'toroku-dancer-location',
            array(
                'slug' => 'tokyo',
                'description' => '東京エリアの登録ダンサー'
            )
        );
    }

    // Osaka タームの作成
    if (!term_exists('Osaka', 'toroku-dancer-location')) {
        wp_insert_term(
            'Osaka',
            'toroku-dancer-location',
            array(
                'slug' => 'osaka',
                'description' => '大阪エリアの登録ダンサー'
            )
        );
    }
}

/**
 * Info & NEWSカスタム投稿タイプの登録
 */
function stepjam_register_info_news_post_type() {
    $labels = array(
        'name' => 'Info & NEWS',
        'singular_name' => 'Info & NEWS',
        'menu_name' => 'Info & NEWS',
        'add_new' => '新規追加',
        'add_new_item' => '新しいInfo & NEWSを追加',
        'edit_item' => 'Info & NEWSを編集',
        'new_item' => '新しいInfo & NEWS',
        'view_item' => 'Info & NEWSを表示',
        'search_items' => 'Info & NEWSを検索',
        'not_found' => 'Info & NEWSが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にInfo & NEWSが見つかりません',
        'all_items' => 'すべてのInfo & NEWS',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'info-news'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'show_in_rest' => true,
    );

    register_post_type('info-news', $args);
}
add_action('init', 'stepjam_register_info_news_post_type');

/**
 * Info & NEWS用のタクソノミー（info/newsタグ）の登録
 */
function stepjam_register_info_news_type_taxonomy() {
    $labels = array(
        'name' => 'Info/Newsタイプ',
        'singular_name' => 'Info/Newsタイプ',
        'search_items' => 'タイプを検索',
        'all_items' => 'すべてのタイプ',
        'edit_item' => 'タイプを編集',
        'update_item' => 'タイプを更新',
        'add_new_item' => '新しいタイプを追加',
        'new_item_name' => '新しいタイプ名',
        'menu_name' => 'Info/Newsタイプ',
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => false,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'info-news-type'),
    );

    register_taxonomy('info-news-type', array('info-news'), $args);
}
add_action('init', 'stepjam_register_info_news_type_taxonomy');

/**
 * デフォルトのInfo/Newsタイプタームを作成
 */
function stepjam_create_default_info_news_types() {
    // Info タームの作成
    if (!term_exists('info', 'info-news-type')) {
        wp_insert_term(
            'Info',
            'info-news-type',
            array(
                'slug' => 'info',
                'description' => 'お知らせ・情報'
            )
        );
    }

    // News タームの作成
    if (!term_exists('news', 'info-news-type')) {
        wp_insert_term(
            'News',
            'info-news-type',
            array(
                'slug' => 'news',
                'description' => 'ニュース・新着情報'
            )
        );
    }
}
add_action('init', 'stepjam_create_default_info_news_types', 11);
add_action('init', 'stepjam_create_default_toroku_dancer_locations');

/**
 * nx-tokyoカスタム投稿タイプの登録
 */
function stepjam_register_nx_tokyo_post_type() {
    $labels = array(
        'name' => 'NEXT SJ',
        'singular_name' => 'NEXT SJ',
        'menu_name' => 'NEXT SJ',
        'add_new' => '新規追加',
        'add_new_item' => '新しいNEXT SJイベントを追加',
        'edit_item' => 'NEXT SJイベントを編集',
        'new_item' => '新しいNEXT SJイベント',
        'view_item' => 'NEXT SJイベントを表示',
        'search_items' => 'NEXT SJイベントを検索',
        'not_found' => 'NEXT SJイベントが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にNEXT SJイベントが見つかりません',
        'all_items' => 'すべてのNEXT SJイベント',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'nx-tokyo'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
        'show_in_rest' => true,
    );

    register_post_type('nx-tokyo', $args);
}
add_action('init', 'stepjam_register_nx_tokyo_post_type');

/**
 * FAQカスタム投稿タイプの登録
 */
function stepjam_register_faq_post_type() {
    $labels = array(
        'name' => 'FAQ',
        'singular_name' => 'FAQ',
        'menu_name' => 'FAQ',
        'add_new' => '新規追加',
        'add_new_item' => '新しいFAQを追加',
        'edit_item' => 'FAQを編集',
        'new_item' => '新しいFAQ',
        'view_item' => 'FAQを表示',
        'view_items' => 'FAQを表示',
        'search_items' => 'FAQを検索',
        'not_found' => 'FAQが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にFAQが見つかりません',
        'all_items' => 'すべてのFAQ',
        'archives' => 'FAQ一覧',
        'attributes' => 'FAQ属性',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'faq'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => array('title', 'revisions', 'page-attributes'),
        'show_in_rest' => true,
        'rest_base' => 'faq',
        'description' => 'よくある質問と回答を管理するためのカスタム投稿タイプです。',
    );

    register_post_type('faq', $args);
}
add_action('init', 'stepjam_register_faq_post_type');

