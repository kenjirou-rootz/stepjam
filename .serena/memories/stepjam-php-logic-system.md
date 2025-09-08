# STEPJAM PHP ロジックシステム詳細

## single-nx-tokyo.php メインロジック

### エリア設定管理システム
```php
// エリア設定配列 - 全エリアの統一管理
$area_configs = array(
    'none' => array(
        'vector' => '',                    // ベクター画像なし
        'class' => 'area-none',            // CSSクラス
        'color' => 'transparent'           // 背景色識別子
    ),
    'tokyo' => array(
        'vector' => get_template_directory_uri() . '/assets/images/nx-tokyo-vector.svg',
        'class' => 'area-tokyo',
        'color' => 'blue'
    ),
    'osaka' => array(
        'vector' => get_template_directory_uri() . '/assets/images/osaka/osaka.svg',
        'class' => 'area-osaka', 
        'color' => 'red'
    ),
    'tohoku' => array(
        'vector' => get_template_directory_uri() . '/assets/images/tohoku/tohoku.svg',
        'class' => 'area-tohoku',
        'color' => 'green'
    )
);

// 選択エリアの設定取得
$current_area = $area_configs[$area_selection];
$area_class = $current_area['class'];        // CSSクラス適用用
$area_vector_path = $current_area['vector']; // ベクター画像パス
```

### 背景メディア制御ロジック
```php
// 背景表示優先度制御
$bg_priority = get_field('nx_background_priority') ?: 'image';
$display_type = 'default'; // デフォルト: エリア別単色背景

if ($bg_priority === 'image') {
    // 画像優先
    if ($bg_image) {
        $display_type = 'image';
        $bg_style = 'background-image: url(' . esc_url($bg_image['url']) . ');';
    } elseif ($bg_video) {
        $display_type = 'video';
    }
} else {
    // 動画優先
    if ($bg_video) {
        $display_type = 'video';
    } elseif ($bg_image) {
        $display_type = 'image';
        $bg_style = 'background-image: url(' . esc_url($bg_image['url']) . ');';
    }
}
```

### ヘッダー表示制御
```php
// 「なし」選択時の条件分岐
<?php if ($area_selection && $area_selection !== 'none') : ?>
    <!-- ヘッダーエリア表示 -->
    <div class="nx-header <?php echo esc_attr($area_class); ?>">
        <div class="nx-logo">...</div>
        <div class="nx-area-visual">
            <img src="<?php echo esc_url($area_vector_path); ?>" ...>
        </div>
    </div>
<?php else : ?>
    <!-- スペーサー要素 (「なし」時) -->
    <div class="nx-header-spacer"></div>
<?php endif; ?>
```

### 動的ボタン制御システム
```php
// ボタン存在確認
$has_day1 = !empty($day1_link);
$has_day2 = !empty($day2_link);  
$has_ticket = !empty($ticket_link);
$has_any_button = $has_day1 || $has_day2 || $has_ticket;

// DAY1/DAY2ボタンレイアウト制御
$day_buttons_class = '';
if ($has_day1 && $has_day2) {
    $day_buttons_class = 'both-days';       // 2カラム
} elseif ($has_day1 && !$has_day2) {
    $day_buttons_class = 'day1-only';       // 1カラム (DAY1のみ)
} elseif (!$has_day1 && $has_day2) {
    $day_buttons_class = 'day2-only';       // 1カラム (DAY2のみ)
}

// フッターボタンエリアレイアウト制御
$footer_buttons_class = $has_ticket ? 'has-ticket' : 'no-ticket';

// TIME TABLE表示判定
$show_timetable = !empty($day1_link) || !empty($day2_link);
```

### コンテンツブロック出力
```php
<?php if ($content_blocks) : ?>
    <div class="nx-content-blocks" tabindex="0" aria-label="コンテンツエリア">
        <?php foreach ($content_blocks as $block) : ?>
            <article class="nx-content-block">
                <div class="nx-block-title">
                    <h3><?php echo esc_html($block['block_title']); ?></h3>
                </div>
                <div class="nx-block-content">
                    <p><?php echo nl2br(esc_html($block['block_content'])); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
```

## ACF統合パターン

### フィールド取得の標準形
```php
// デフォルト値付きフィールド取得
$event_title = get_field('nx_event_title') ?: 'STEPJAM TOKYO';
$area_selection = get_field('nx_area_selection') ?: 'none';
$content_blocks = get_field('nx_content_blocks');

// 画像フィールドの安全な取得
$bg_image = get_field('nx_background_image');
if ($bg_image) {
    $image_url = $bg_image['url'];
    $image_alt = $bg_image['alt'];
}
```

### リピーターフィールド処理
```php
// nx_content_blocks リピーターフィールド
if (have_rows('nx_content_blocks')) {
    while (have_rows('nx_content_blocks')) {
        the_row();
        $title = get_sub_field('block_title');
        $content = get_sub_field('block_content'); 
    }
}
```

## セキュリティ対策

### 出力エスケープ
```php
// HTML属性値
<?php echo esc_attr($area_class); ?>

// HTML内容
<?php echo esc_html($event_title); ?>

// URL
<?php echo esc_url($day1_link); ?>

// 改行保持HTML出力
<?php echo nl2br(esc_html($block['block_content'])); ?>
```