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
 * 本番環境では関数自体が登録されない
 */
if (defined('WP_DEBUG') && WP_DEBUG) {
    function stepjam_debug_info() {
        if (is_front_page()) {
            echo "<!-- STEPJAM Debug Info -->\n";
            echo "<!-- ACF Pro Active: " . (function_exists('get_field') ? 'Yes' : 'No') . " -->\n";
            echo "<!-- Current Theme: " . wp_get_theme()->get('Name') . " -->\n";
            echo "<!-- WordPress Version: " . get_bloginfo('version') . " -->\n";
            echo "<!-- QA Test Timestamp: " . (defined('STEPJAM_QA_TEST_TIMESTAMP') ? STEPJAM_QA_TEST_TIMESTAMP : 'Not Set') . " -->\n";
            echo "<!-- End Debug Info -->\n";
        }
    }
    add_action('wp_head', 'stepjam_debug_info');
}

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
                    'key' => 'nx_area_selection', // 修正: ACFフィールド名に合わせる
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

/**
 * =============================================================================
 * ACF GIT同期システム - Phase 1 実装
 * Git制限対応: 6push/minute, 2GB制限, エラーハンドリング, バッチ処理
 * 実装日: 2025-09-08
 * =============================================================================
 */

/**
 * ACF JSON同期ディレクトリ設定
 * 開発環境でのフィールド編集 → JSON自動出力
 */
add_filter('acf/settings/save_json', 'stepjam_acf_json_save_point');
function stepjam_acf_json_save_point($path) {
    $json_dir = get_stylesheet_directory() . '/acf-json';
    
    // ディレクトリが存在しない場合は作成
    if (!file_exists($json_dir)) {
        wp_mkdir_p($json_dir);
        chmod($json_dir, 0755);
    }
    
    return $json_dir;
}

/**
 * ACF JSON読み込みディレクトリ設定
 * JSON → DB自動同期
 */
add_filter('acf/settings/load_json', 'stepjam_acf_json_load_point');
function stepjam_acf_json_load_point($paths) {
    $json_dir = get_stylesheet_directory() . '/acf-json';
    
    if (file_exists($json_dir)) {
        $paths[] = $json_dir;
    }
    
    return array_unique($paths);
}

/**
 * Git制限管理クラス
 * GitHub API制限対応: 6 push/minute, 2GB file size limit
 */
class StepjamGitLimitManager {
    private static $instance = null;
    private $rate_limit_key = 'stepjam_git_push_count';
    private $batch_queue_key = 'stepjam_acf_batch_queue';
    private $max_pushes_per_minute = 6;
    private $max_file_size_mb = 2048; // 2GB in MB
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Git Push レート制限チェック
     * @return bool true: 実行可能, false: 制限中
     */
    public function canPush() {
        $current_count = get_transient($this->rate_limit_key);
        
        if ($current_count === false) {
            // 初回または期限切れ
            set_transient($this->rate_limit_key, 1, 60); // 1分間
            return true;
        }
        
        if ($current_count >= $this->max_pushes_per_minute) {
            return false;
        }
        
        // カウント増加
        set_transient($this->rate_limit_key, $current_count + 1, 60);
        return true;
    }
    
    /**
     * ファイルサイズチェック
     * @param string $file_path
     * @return bool true: サイズOK, false: サイズ超過
     */
    public function checkFileSize($file_path) {
        if (!file_exists($file_path)) {
            return true;
        }
        
        $size_mb = filesize($file_path) / (1024 * 1024);
        return $size_mb <= $this->max_file_size_mb;
    }
    
    /**
     * バッチキューに追加
     * @param array $data
     */
    public function addToBatchQueue($data) {
        $queue = get_option($this->batch_queue_key, array());
        $queue[] = array_merge($data, ['timestamp' => time()]);
        update_option($this->batch_queue_key, $queue);
    }
    
    /**
     * バッチキュー処理
     */
    public function processBatchQueue() {
        $queue = get_option($this->batch_queue_key, array());
        
        if (empty($queue)) {
            return array('success' => true, 'message' => 'キューが空です');
        }
        
        $processed = 0;
        $errors = array();
        
        foreach ($queue as $index => $item) {
            if ($this->canPush()) {
                $result = $this->executeGitOperation($item);
                
                if ($result['success']) {
                    unset($queue[$index]);
                    $processed++;
                } else {
                    $errors[] = $result['error'];
                }
            } else {
                break; // レート制限到達
            }
        }
        
        // キュー更新
        update_option($this->batch_queue_key, array_values($queue));
        
        return array(
            'success' => true,
            'processed' => $processed,
            'remaining' => count($queue),
            'errors' => $errors
        );
    }
    
    /**
     * Git操作実行
     * @param array $operation
     * @return array
     */
    private function executeGitOperation($operation) {
        try {
            switch ($operation['type']) {
                case 'acf_json_sync':
                    return $this->syncACFJson($operation['field_group']);
                default:
                    return array('success' => false, 'error' => '不明な操作タイプ');
            }
        } catch (Exception $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }
    
    /**
     * ACF JSON Git同期実行
     * @param string $field_group
     * @return array
     */
    private function syncACFJson($field_group) {
        $json_dir = get_stylesheet_directory() . '/acf-json';
        $json_file = $json_dir . '/' . $field_group . '.json';
        
        if (!$this->checkFileSize($json_file)) {
            return array('success' => false, 'error' => 'ファイルサイズが2GB制限を超過');
        }
        
        // Git操作（実際の実装では外部スクリプト呼び出し）
        $git_result = $this->executeGitCommitPush($field_group);
        
        if ($git_result) {
            $this->logGitOperation('acf_json_sync', $field_group, 'success');
            return array('success' => true, 'message' => 'ACF JSON同期完了');
        } else {
            $this->logGitOperation('acf_json_sync', $field_group, 'error');
            return array('success' => false, 'error' => 'Git操作失敗');
        }
    }
    
    /**
     * Git Commit & Push実行
     * @param string $field_group
     * @return bool
     */
    private function executeGitCommitPush($field_group) {
        // セキュリティワークフロー実行
        $project_root = '/Users/hayashikenjirou/Local Sites/stepjam';
        $secure_script = $project_root . '/deploy/secure-git-workflow.sh';
        
        if (!file_exists($secure_script)) {
            return false;
        }
        
        $commit_message = "ACF: {$field_group} フィールドグループ自動同期\n\n🤖 Generated with [Claude Code](https://claude.ai/code)\n\nCo-Authored-By: Claude <noreply@anthropic.com>";
        
        // セキュアGit操作実行
        $command = sprintf(
            'cd "%s" && "%s" git commit "%s" 2>&1',
            $project_root,
            $secure_script,
            addslashes($commit_message)
        );
        
        $output = shell_exec($command);
        
        // Push実行
        if ($output && strpos($output, '✅ Commit 完了') !== false) {
            $push_command = sprintf(
                'cd "%s" && "%s" git push origin main 2>&1',
                $project_root,
                $secure_script
            );
            
            $push_output = shell_exec($push_command);
            return $push_output && strpos($push_output, '✅ Push 完了') !== false;
        }
        
        return false;
    }
    
    /**
     * Git操作ログ記録
     */
    private function logGitOperation($operation, $target, $status) {
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            $log_message = sprintf(
                '[STEPJAM ACF-GIT] %s: %s - %s at %s',
                strtoupper($operation),
                $target,
                strtoupper($status),
                date('Y-m-d H:i:s')
            );
            error_log($log_message);
        }
    }
}

/**
 * ACF フィールドグループ保存時の自動Git同期
 */
add_action('acf/save_post', 'stepjam_acf_auto_git_sync', 20);
function stepjam_acf_auto_git_sync($post_id) {
    // ACF フィールドグループ保存のみ対象
    if (get_post_type($post_id) !== 'acf-field-group') {
        return;
    }
    
    $field_group_key = get_post_field('post_name', $post_id);
    if (!$field_group_key) {
        return;
    }
    
    $git_manager = StepjamGitLimitManager::getInstance();
    
    // レート制限チェック
    if ($git_manager->canPush()) {
        // 即座にGit同期実行
        $result = $git_manager->executeGitOperation(array(
            'type' => 'acf_json_sync',
            'field_group' => $field_group_key
        ));
        
        if (!$result['success']) {
            // 失敗時はバッチキューに追加
            $git_manager->addToBatchQueue(array(
                'type' => 'acf_json_sync',
                'field_group' => $field_group_key
            ));
        }
    } else {
        // レート制限時はバッチキューに追加
        $git_manager->addToBatchQueue(array(
            'type' => 'acf_json_sync',
            'field_group' => $field_group_key
        ));
    }
}

/**
 * バッチキュー処理用WP-Cronスケジュール
 */
add_action('wp', 'stepjam_schedule_acf_batch_processing');
function stepjam_schedule_acf_batch_processing() {
    if (!wp_next_scheduled('stepjam_process_acf_batch_queue')) {
        wp_schedule_event(time(), 'every_minute', 'stepjam_process_acf_batch_queue');
    }
}

// カスタムcronスケジュール追加
add_filter('cron_schedules', 'stepjam_add_cron_interval');
function stepjam_add_cron_interval($schedules) {
    $schedules['every_minute'] = array(
        'interval' => 60,
        'display' => 'Every Minute'
    );
    return $schedules;
}

// バッチキュー処理実行
add_action('stepjam_process_acf_batch_queue', 'stepjam_execute_batch_processing');
function stepjam_execute_batch_processing() {
    $git_manager = StepjamGitLimitManager::getInstance();
    $git_manager->processBatchQueue();
}

/**
 * ACF JSON同期状況確認（管理画面・開発用）
 * 本番環境では関数自体が登録されない
 */
if (defined('WP_DEBUG') && WP_DEBUG) {
    function stepjam_acf_sync_debug() {
        if (current_user_can('manage_options')) {
        $json_dir = get_stylesheet_directory() . '/acf-json';
        
        if (file_exists($json_dir)) {
            $json_files = glob($json_dir . '/*.json');
            $file_count = count($json_files);
            
            echo "<!-- ACF-Git同期システム: JSON Files: {$file_count} files -->\n";
            
            // Git制限状況
            $git_manager = StepjamGitLimitManager::getInstance();
            $can_push = $git_manager->canPush() ? 'OK' : 'RATE_LIMITED';
            echo "<!-- ACF-Git同期システム: Push Status: {$can_push} -->\n";
            
            // バッチキュー状況
            $queue_count = count(get_option('stepjam_acf_batch_queue', array()));
            echo "<!-- ACF-Git同期システム: Batch Queue: {$queue_count} items -->\n";
        } else {
            echo "<!-- ACF-Git同期システム: acf-json directory not found -->\n";
        }
        }
    }
    add_action('wp_head', 'stepjam_acf_sync_debug');
}

/**
 * FAQカスタム投稿タイプのプレビューURL制御
 * 編集画面でのプレビューボタンリンク先を/faq/に設定
 */
add_filter('preview_post_link', 'stepjam_faq_preview_url_control', 10, 2);
function stepjam_faq_preview_url_control($preview_link, $post) {
    // FAQカスタム投稿タイプのみ対象
    if ($post->post_type === 'faq') {
        // FAQアーカイブページのURLを取得（/faq/）
        $faq_archive_url = get_post_type_archive_link('faq');
        
        if ($faq_archive_url) {
            return $faq_archive_url;
        }
    }
    
    // その他の投稿タイプは通常のプレビューリンクを返す
    return $preview_link;
}

/**
 * 管理画面: ACF Git同期状況表示
 */
add_action('admin_notices', 'stepjam_acf_git_sync_admin_notice');
function stepjam_acf_git_sync_admin_notice() {
    $screen = get_current_screen();
    
    // ACF管理画面でのみ表示
    if ($screen && $screen->post_type === 'acf-field-group') {
        $git_manager = StepjamGitLimitManager::getInstance();
        $queue_count = count(get_option('stepjam_acf_batch_queue', array()));
        
        if ($queue_count > 0) {
            echo '<div class="stepjam-admin-notice">';
            echo '<p><strong>ACF Git同期:</strong> バッチキューに' . $queue_count . '件の同期待ちがあります。</p>';
            echo '</div>';
        }
        
        // 緊急解決: Local Field Groups変換ボタン表示
        $local_groups = acf_get_local_field_groups();
        if (!empty($local_groups) && count($local_groups) > 1) { // テストグループ以外にLocal群が存在
            echo '<div class="notice notice-warning">';
            echo '<p><strong>🚨 ACF Local Field Groups 検出:</strong> ' . count($local_groups) . '個のLocal Field Groupsが管理画面で編集できません。</p>';
            $convert_url = add_query_arg(array(
                'stepjam_convert_local' => 1,
                '_wpnonce' => wp_create_nonce('stepjam_convert_local')
            ), $_SERVER['REQUEST_URI']);
            echo '<p><a href="' . esc_url($convert_url) . '" class="button button-primary">即座に管理画面対応に変換</a></p>';
            echo '</div>';
        }
    }
}

/**
 * =============================================================================
 * 緊急解決: ACF Local Field Groups → Admin Field Groups 即座変換
 * Phase 2 対応: 一発変換ボタンでLocal Groups を管理画面対応に変更
 * =============================================================================
 */

// 変換実行処理
add_action('admin_init', 'stepjam_handle_local_conversion');
function stepjam_handle_local_conversion() {
    if (!isset($_GET['stepjam_convert_local']) || !wp_verify_nonce($_GET['_wpnonce'], 'stepjam_convert_local')) {
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('権限がありません');
    }
    
    $result = stepjam_convert_local_to_admin();
    
    // 結果表示用のパラメータ設定
    $redirect_args = array(
        'post_type' => 'acf-field-group',
        'stepjam_conversion_result' => $result['success'] ? 'success' : 'error',
        'stepjam_converted_count' => $result['converted_count']
    );
    
    wp_redirect(add_query_arg($redirect_args, admin_url('edit.php')));
    exit;
}

/**
 * Local Field Groups → Admin変換メイン処理
 */
function stepjam_convert_local_to_admin() {
    $converted_count = 0;
    $local_groups = acf_get_local_field_groups();
    
    foreach ($local_groups as $group_key => $group_data) {
        // テストグループはスキップ
        if (strpos($group_key, '68bedfbe3d50c') !== false) {
            continue;
        }
        
        // 既存確認
        $existing = get_posts(array(
            'post_type' => 'acf-field-group',
            'name' => $group_key,
            'post_status' => 'any',
            'numberposts' => 1
        ));
        
        if (!empty($existing)) {
            continue; // 既存の場合はスキップ
        }
        
        // WordPress投稿として作成
        $post_data = array(
            'post_type' => 'acf-field-group',
            'post_status' => 'publish',
            'post_title' => $group_data['title'],
            'post_name' => $group_key,
            'post_excerpt' => isset($group_data['description']) ? $group_data['description'] : ''
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (!is_wp_error($post_id)) {
            // ACF メタデータ保存
            foreach ($group_data as $key => $value) {
                update_field($key, $value, $post_id);
            }
            
            $converted_count++;
        }
    }
    
    return array(
        'success' => true,
        'converted_count' => $converted_count
    );
}

// 変換結果通知
add_action('admin_notices', 'stepjam_conversion_result_notice');
function stepjam_conversion_result_notice() {
    if (!isset($_GET['stepjam_conversion_result'])) {
        return;
    }
    
    $result = $_GET['stepjam_conversion_result'];
    $count = isset($_GET['stepjam_converted_count']) ? intval($_GET['stepjam_converted_count']) : 0;
    
    if ($result === 'success') {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>✅ 変換完了!</strong> ' . $count . '個のLocal Field Groupsを管理画面対応に変換しました。</p>';
        echo '<p>各フィールドグループを編集・保存してJSONファイル生成を確認してください。</p>';
        echo '</div>';
    } else {
        echo '<div class="notice notice-error is-dismissible">';
        echo '<p><strong>❌ 変換エラー</strong> 変換処理でエラーが発生しました。</p>';
        echo '</div>';
    }
}