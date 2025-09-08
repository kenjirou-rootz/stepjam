<?php
/**
 * ACF Dancers Section Debug Script
 * URL: http://stepjam.local/acf-debug-dancers.php
 */

// WordPress環境の読み込み
require_once(__DIR__ . '/wp-load.php');

// セキュリティ：管理者のみ
if (!current_user_can('manage_options')) {
    die('Access denied. Admin privileges required.');
}

// デバッグ出力用CSS
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ACF Dancers Section Debug</title>
    <style>
        body { font-family: 'Courier New', monospace; margin: 20px; background: #1e1e1e; color: #d4d4d4; }
        .debug-section { margin-bottom: 30px; padding: 20px; background: #2d2d30; border-radius: 5px; }
        .debug-title { color: #4FC3F7; font-size: 18px; font-weight: bold; margin-bottom: 15px; }
        .field-name { color: #C3E88D; font-weight: bold; }
        .field-value { color: #FFCB6B; margin-left: 20px; }
        .array-container { border-left: 3px solid #82B1FF; padding-left: 15px; margin-left: 10px; }
        .boolean-true { color: #C3E88D; }
        .boolean-false { color: #F07178; }
        pre { background: #1e1e1e; padding: 15px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🎭 ACF Dancers Section Data Debug</h1>
    <p><strong>Generated:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>

<?php

// nx-tokyoカスタム投稿を検索
$nx_tokyo_posts = get_posts([
    'post_type' => 'nx-tokyo',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);

if (empty($nx_tokyo_posts)) {
    echo '<div class="debug-section">';
    echo '<div class="debug-title">❌ No nx-tokyo posts found</div>';
    echo '<p>No published nx-tokyo posts exist in the database.</p>';
    echo '</div>';
} else {
    foreach ($nx_tokyo_posts as $post) {
        setup_postdata($post);
        
        echo '<div class="debug-section">';
        echo '<div class="debug-title">📄 Post: ' . esc_html($post->post_title) . ' (ID: ' . $post->ID . ')</div>';
        
        // ACF フィールドデータ取得
        $dancers_section_show = get_field('nx_dancers_section_show', $post->ID);
        $day1_show = get_field('nx_day1_show', $post->ID);
        $day2_show = get_field('nx_day2_show', $post->ID);
        $day1_sliders = get_field('nx_day1_sliders', $post->ID);
        $day2_sliders = get_field('nx_day2_sliders', $post->ID);
        
        // 基本制御フィールド
        echo '<div class="field-name">nx_dancers_section_show:</div>';
        echo '<div class="field-value ' . ($dancers_section_show ? 'boolean-true' : 'boolean-false') . '">' . 
             ($dancers_section_show ? 'TRUE (表示)' : 'FALSE (非表示)') . '</div><br>';
        
        echo '<div class="field-name">nx_day1_show:</div>';
        echo '<div class="field-value ' . ($day1_show ? 'boolean-true' : 'boolean-false') . '">' . 
             ($day1_show ? 'TRUE (表示)' : 'FALSE (非表示)') . '</div><br>';
        
        echo '<div class="field-name">nx_day2_show:</div>';
        echo '<div class="field-value ' . ($day2_show ? 'boolean-true' : 'boolean-false') . '">' . 
             ($day2_show ? 'TRUE (表示)' : 'FALSE (非表示)') . '</div><br>';
        
        // DAY1 スライダーデータ
        echo '<div class="field-name">nx_day1_sliders:</div>';
        if (!empty($day1_sliders)) {
            echo '<div class="array-container">';
            echo '<div class="field-value">📊 スライダー数: ' . count($day1_sliders) . '</div>';
            foreach ($day1_sliders as $slider_index => $slider) {
                echo '<div class="field-value">🎯 [' . $slider_index . '] ジャンル: ' . esc_html($slider['genre_name']) . '</div>';
                if (!empty($slider['dancer_slides'])) {
                    echo '<div class="array-container">';
                    echo '<div class="field-value">👥 ダンサー数: ' . count($slider['dancer_slides']) . '</div>';
                    foreach ($slider['dancer_slides'] as $dancer_index => $dancer) {
                        echo '<div class="field-value">🕺 [' . $dancer_index . '] ' . esc_html($dancer['dancer_name']);
                        if (!empty($dancer['dancer_bg_image'])) {
                            echo ' | 🖼️ 画像: ' . basename($dancer['dancer_bg_image']['url']);
                        }
                        if (!empty($dancer['dancer_link'])) {
                            echo ' | 🔗 Link: ' . esc_html($dancer['dancer_link']);
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            echo '</div>';
        } else {
            echo '<div class="field-value">❌ No DAY1 slider data</div>';
        }
        
        // DAY2 スライダーデータ
        echo '<br><div class="field-name">nx_day2_sliders:</div>';
        if (!empty($day2_sliders)) {
            echo '<div class="array-container">';
            echo '<div class="field-value">📊 スライダー数: ' . count($day2_sliders) . '</div>';
            foreach ($day2_sliders as $slider_index => $slider) {
                echo '<div class="field-value">🎯 [' . $slider_index . '] ジャンル: ' . esc_html($slider['genre_name']) . '</div>';
                if (!empty($slider['dancer_slides'])) {
                    echo '<div class="array-container">';
                    echo '<div class="field-value">👥 ダンサー数: ' . count($slider['dancer_slides']) . '</div>';
                    foreach ($slider['dancer_slides'] as $dancer_index => $dancer) {
                        echo '<div class="field-value">🕺 [' . $dancer_index . '] ' . esc_html($dancer['dancer_name']);
                        if (!empty($dancer['dancer_bg_image'])) {
                            echo ' | 🖼️ 画像: ' . basename($dancer['dancer_bg_image']['url']);
                        }
                        if (!empty($dancer['dancer_link'])) {
                            echo ' | 🔗 Link: ' . esc_html($dancer['dancer_link']);
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            echo '</div>';
        } else {
            echo '<div class="field-value">❌ No DAY2 slider data</div>';
        }
        
        // Raw Data Dump (for detailed inspection)
        echo '<br><div class="debug-title">🔍 Raw Data Structures</div>';
        
        if (!empty($day1_sliders)) {
            echo '<div class="field-name">DAY1 Raw Data:</div>';
            echo '<pre>' . esc_html(print_r($day1_sliders, true)) . '</pre>';
        }
        
        if (!empty($day2_sliders)) {
            echo '<div class="field-name">DAY2 Raw Data:</div>';
            echo '<pre>' . esc_html(print_r($day2_sliders, true)) . '</pre>';
        }
        
        echo '</div>';
    }
    
    wp_reset_postdata();
}

?>

    <div class="debug-section">
        <div class="debug-title">📝 How to Access This Data</div>
        <p>In <code>dancers-section.php</code>, these fields are accessed using:</p>
        <pre>$dancers_section_show = get_field('nx_dancers_section_show');
$day1_show = get_field('nx_day1_show');  
$day2_show = get_field('nx_day2_show');
$day1_sliders = get_field('nx_day1_sliders');
$day2_sliders = get_field('nx_day2_sliders');</pre>
        
        <p><strong>⚠️ セキュリティ注意:</strong> このファイルは管理者専用です。確認後は削除してください。</p>
    </div>

</body>
</html>