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

/**
 * テーマセットアップ
 */
function stepjam_theme_setup() {
    // タイトルタグサポート
    add_theme_support('title-tag');
    
    // アイキャッチ画像サポート
    add_theme_support('post-thumbnails');
    
    // HTML5サポート
    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // カスタムメニューサポート
    register_nav_menus(array(
        'primary' => 'メインメニュー',
        'footer' => 'フッターメニュー'
    ));
    
    // レスポンシブ埋め込みサポート
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'stepjam_theme_setup');

/**
 * 機能ファイルの読み込み
 */
$includes = array(
    '/inc/enqueue-scripts.php',      // CSS/JS読み込み
    '/inc/custom-post-types.php',    // カスタム投稿タイプ
    '/inc/acf-fields.php'           // ACFフィールド設定
);

foreach ($includes as $file) {
    if (file_exists(get_template_directory() . $file)) {
        require_once get_template_directory() . $file;
    }
}

/**
 * テーマカスタマイズ
 */
function stepjam_customize_register($wp_customize) {
    // 必要に応じてカスタマイザー設定を追加
    // 現在は基本構造のみ
}
add_action('customize_register', 'stepjam_customize_register');

/**
 * ウィジェットエリア登録
 */
function stepjam_widgets_init() {
    register_sidebar(array(
        'name'          => 'フッターウィジェット',
        'id'            => 'footer-widget',
        'description'   => 'フッター領域のウィジェット',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'stepjam_widgets_init');

/**
 * デバッグ用関数（開発時のみ）
 */
if (WP_DEBUG) {
    function stepjam_debug_log($message) {
        if (is_array($message) || is_object($message)) {
            error_log('[STEPJAM_DEBUG] ' . print_r($message, true));
        } else {
            error_log('[STEPJAM_DEBUG] ' . $message);
        }
    }
    
    // ACF オプションページ問題の調査デバッグ（一時的）
    add_action('wp_footer', function() {
        if (is_front_page()) {
            echo "<!-- ACF DEBUG START -->\n";
            echo "<!-- ACF functions exist: " . (function_exists('get_field') ? 'YES' : 'NO') . " -->\n";
            echo "<!-- ACF options exist: " . (function_exists('acf_add_options_page') ? 'YES' : 'NO') . " -->\n";
            
            // 実際のget_field結果をテスト
            $hero_logo_test = get_field('hero_logo');
            $sponsor_test = get_field('sponsor_main_video_01', 'option');
            
            echo "<!-- hero_logo result: " . ($hero_logo_test ? 'HAS_VALUE' : 'NULL') . " -->\n";
            echo "<!-- sponsor_video result: " . ($sponsor_test ? 'HAS_VALUE' : 'NULL') . " -->\n";
            
            // WordPressオプション直接確認
            $option_test = get_option('options_sponsor_main_video_01');
            echo "<!-- WordPress option direct: " . ($option_test ? 'HAS_VALUE' : 'NULL') . " -->\n";
            
            echo "<!-- ACF DEBUG END -->\n";
        }
    });
}

/**
 * Contact Form AJAX Handler
 */
function stepjam_handle_contact_form() {
    // Nonce verification
    if (!wp_verify_nonce($_POST['stepjam_contact_nonce'], 'stepjam_contact_form')) {
        wp_die('Security check failed');
    }
    
    // Sanitize and validate input
    $contact_name = sanitize_text_field($_POST['contact_name']);
    $contact_kana = sanitize_text_field($_POST['contact_kana']);
    $contact_email = sanitize_email($_POST['contact_email']);
    $contact_phone = sanitize_text_field($_POST['contact_phone']);
    $contact_message = sanitize_textarea_field($_POST['contact_message']);
    $contact_categories = isset($_POST['contact_category']) ? array_map('sanitize_text_field', $_POST['contact_category']) : array();
    
    // Validation
    $errors = array();
    
    if (empty($contact_name)) {
        $errors[] = '氏名・ご担当者は必須項目です。';
    }
    
    if (empty($contact_kana)) {
        $errors[] = 'フリガナは必須項目です。';
    }
    
    if (empty($contact_email) || !is_email($contact_email)) {
        $errors[] = '正しいメールアドレスを入力してください。';
    }
    
    if (empty($contact_phone)) {
        $errors[] = 'ご連絡先は必須項目です。';
    }
    
    if (empty($contact_categories)) {
        $errors[] = '概要から最低1つ選択してください。';
    }
    
    if (!empty($errors)) {
        wp_send_json_error(array('message' => implode('<br>', $errors)));
        return;
    }
    
    // Prepare email content
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    
    $subject = '[' . $site_name . '] お問い合わせフォームより';
    
    $message = "■ お問い合わせ内容\n";
    $message .= "────────────────────────\n\n";
    $message .= "氏名・ご担当者: " . $contact_name . "\n";
    $message .= "フリガナ: " . $contact_kana . "\n";
    $message .= "メールアドレス: " . $contact_email . "\n";
    $message .= "ご連絡先: " . $contact_phone . "\n";
    $message .= "概要: " . implode(', ', $contact_categories) . "\n";
    
    if (!empty($contact_message)) {
        $message .= "\nお問い合わせ内容:\n" . $contact_message . "\n";
    }
    
    $message .= "\n────────────────────────\n";
    $message .= "送信日時: " . current_time('Y年m月d日 H:i') . "\n";
    $message .= "送信者IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site_name . ' <' . $admin_email . '>',
        'Reply-To: ' . $contact_name . ' <' . $contact_email . '>'
    );
    
    // Send email
    $mail_sent = wp_mail($admin_email, $subject, $message, $headers);
    
    if ($mail_sent) {
        // Send auto-reply to user
        $user_subject = '[' . $site_name . '] お問い合わせありがとうございます';
        $user_message = $contact_name . " 様\n\n";
        $user_message .= "この度は、STEPJAMへお問い合わせいただき、ありがとうございます。\n";
        $user_message .= "お問い合わせ内容を確認次第、担当者よりご連絡させていただきます。\n\n";
        $user_message .= "今しばらくお待ちください。\n\n";
        $user_message .= "────────────────────────\n";
        $user_message .= "STEPJAM運営事務局\n";
        $user_message .= get_bloginfo('url') . "\n";
        
        $user_headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . $admin_email . '>'
        );
        
        wp_mail($contact_email, $user_subject, $user_message, $user_headers);
        
        wp_send_json_success(array('message' => 'お問い合わせありがとうございます。確認次第ご連絡いたします。'));
    } else {
        wp_send_json_error(array('message' => 'メールの送信に失敗しました。しばらくしてから再度お試しください。'));
    }
}

// Register AJAX actions
add_action('wp_ajax_stepjam_contact_form', 'stepjam_handle_contact_form');
add_action('wp_ajax_nopriv_stepjam_contact_form', 'stepjam_handle_contact_form');

/**
 * NEXT SJ ナビメニュー対象エリア排他制御
 */
function stepjam_nx_nav_menu_area_exclusive_control($post_id) {
    // ACF関数が利用可能かチェック
    if (!function_exists('get_field') || !function_exists('update_field')) {
        return;
    }
    
    // 投稿タイプがnx-tokyoでない場合は処理しない
    if (get_post_type($post_id) !== 'nx-tokyo') {
        return;
    }
    
    // 現在選択されたエリア取得
    $selected_area = get_field('nx_nav_menu_area', $post_id);
    
    // 'none'または空の場合は排他制御不要
    if (empty($selected_area) || $selected_area === 'none') {
        return;
    }
    
    // 同じエリアを選択している他の投稿を検索
    $conflicting_posts = get_posts(array(
        'post_type' => 'nx-tokyo',
        'posts_per_page' => -1,
        'post_status' => array('publish', 'draft', 'private'),
        'exclude' => array($post_id), // 現在の投稿は除外
        'meta_query' => array(
            array(
                'key' => 'nx_nav_menu_area',
                'value' => $selected_area,
                'compare' => '='
            )
        )
    ));
    
    // 競合する投稿がある場合、それらを'none'に変更
    if (!empty($conflicting_posts)) {
        $conflicted_titles = array();
        
        foreach ($conflicting_posts as $conflicting_post) {
            update_field('nx_nav_menu_area', 'none', $conflicting_post->ID);
            $conflicted_titles[] = $conflicting_post->post_title;
        }
        
        // 管理画面通知メッセージを設定
        $area_names = array(
            'tokyo' => 'TOKYO',
            'osaka' => 'OSAKA', 
            'tohoku' => 'TOHOKU'
        );
        
        $area_name = isset($area_names[$selected_area]) ? $area_names[$selected_area] : $selected_area;
        $message = sprintf(
            '以下の投稿の%s選択を解除し、この投稿を%sに設定しました: %s',
            $area_name,
            $area_name,
            implode(', ', $conflicted_titles)
        );
        
        // WordPress Options APIにメッセージを保存（次回管理画面表示時に表示）
        update_option('stepjam_nav_menu_message', $message, false);
    }
}
add_action('acf/save_post', 'stepjam_nx_nav_menu_area_exclusive_control', 20);

/**
 * NEXT SJ ナビメニュー対象エリア管理画面メッセージ表示
 */
function stepjam_nx_nav_menu_admin_notices() {
    $message = get_option('stepjam_nav_menu_message');
    
    if ($message) {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p>' . esc_html($message) . '</p>';
        echo '</div>';
        delete_option('stepjam_nav_menu_message');
    }
}
add_action('admin_notices', 'stepjam_nx_nav_menu_admin_notices');

/**
 * NEXT SJ ナビゲーション動的リンク生成
 */
function stepjam_get_next_nav_links() {
    $links = array(
        'tokyo' => array('url' => '#', 'available' => false, 'title' => ''),
        'osaka' => array('url' => '#', 'available' => false, 'title' => ''),
        'tohoku' => array('url' => '#', 'available' => false, 'title' => '')
    );
    
    if (!function_exists('get_posts') || !function_exists('get_field')) {
        return $links;
    }
    
    $areas = array('tokyo', 'osaka', 'tohoku');
    
    foreach ($areas as $area) {
        $posts = get_posts(array(
            'post_type' => 'nx-tokyo',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'nx_nav_menu_area',
                    'value' => $area,
                    'compare' => '='
                )
            )
        ));
        
        if (!empty($posts)) {
            $links[$area] = array(
                'url' => get_permalink($posts[0]->ID),
                'available' => true,
                'title' => $posts[0]->post_title
            );
        }
    }
    
    return $links;
}

/**
 * Enqueue contact form scripts
 */
function stepjam_contact_form_scripts() {
    if (is_page_template('contact.php')) {
        wp_localize_script('stepjam-main-js', 'stepjam_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('stepjam_contact_form')
        ));
    }
}
add_action('wp_enqueue_scripts', 'stepjam_contact_form_scripts');

/**
 * FAQ投稿のリダイレクト動線改善
 * 
 * 問題：FAQ編集後の遷移が単体投稿で確認しづらい
 * 解決：アーカイブページ(/faq/)への統一リダイレクト
 * 
 * 対象ボタン：
 * - プレビューボタン 
 * - 管理バー「FAQを表示」リンク
 */

// FAQプレビューリンクの変更
function stepjam_faq_preview_redirect($preview_link, $post) {
    // 投稿オブジェクトとタイプのチェック
    if (!$post || !isset($post->post_type) || $post->post_type !== 'faq') {
        return $preview_link;
    }
    
    // FAQアーカイブページへリダイレクト
    return home_url('/faq/');
}
add_filter('preview_post_link', 'stepjam_faq_preview_redirect', 10, 2);

// 管理バー「FAQを表示」リンクの変更
function stepjam_admin_bar_faq_link($wp_admin_bar) {
    global $post;
    
    // FAQ編集画面でのみ実行
    if (is_admin() && $post && isset($post->post_type) && $post->post_type === 'faq') {
        // 既存の「表示」リンクを削除
        $wp_admin_bar->remove_node('view');
        
        // FAQアーカイブページへのリンクを追加
        $wp_admin_bar->add_node(array(
            'id' => 'view-faq-archive',
            'title' => 'FAQを表示',
            'href' => home_url('/faq/'),
        ));
    }
}
add_action('admin_bar_menu', 'stepjam_admin_bar_faq_link', 81);

