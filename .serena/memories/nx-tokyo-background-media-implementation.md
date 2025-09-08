# NX TOKYO背景メディア機能実装完了記録

## 実装概要
nx-tokyo投稿タイプに背景メディア（画像/動画）機能を追加し、nx-headerの高さ制限も併せて実装。すべての要件が正常に動作することを確認済み。

## 実装した機能

### 1. ACF背景メディアフィールド
- **背景画像**: 画像アップロード（jpg, png, webp）
- **背景動画**: ファイルアップロード（mp4, 10MB制限）
- **背景表示優先度**: ラジオボタン（画像優先/動画優先）

### 2. CSS実装
- **nx-header高さ制限**: 400px（デスクトップ）、300px（モバイル）
- **nx-area1高さ設定**: 100svh → 100dvh → 100vh（フォールバック）
- **背景メディア表示**: cover設定、z-index階層管理

### 3. PHP表示ロジック
- 優先度に基づく条件分岐表示
- 画像優先: 画像 → 動画 → デフォルト（赤背景）
- 動画優先: 動画 → 画像 → デフォルト（赤背景）
- データ属性による CSS ターゲティング

### 4. HTML5動画仕様
- `autoplay muted loop playsinline`
- ARIA ラベル設定
- アクセシビリティ対応

## 技術実装詳細

### ファイル変更箇所

#### /inc/acf-fields.php:75-108
```php
// 背景メディア設定フィールド追加
array(
    'key' => 'field_nx_background_image',
    'label' => '背景画像',
    'name' => 'nx_background_image',
    'type' => 'image',
    'mime_types' => 'jpg,jpeg,png,webp'
),
array(
    'key' => 'field_nx_background_video', 
    'label' => '背景動画',
    'name' => 'nx_background_video',
    'type' => 'file',
    'mime_types' => 'mp4'
),
array(
    'key' => 'field_nx_background_priority',
    'label' => '背景表示優先度',
    'name' => 'nx_background_priority',
    'type' => 'radio',
    'choices' => array(
        'image' => '画像優先',
        'video' => '動画優先'
    ),
    'default_value' => 'image'
)
```

#### /single-nx-tokyo.php:69-78, 90-92, 270-272, 284-302
```css
/* nx-area1 svh設定 */
.nx-area1 {
  height: 100svh;
  height: 100dvh; 
  height: 100vh;
}

/* nx-header高さ制限 */
.nx-header {
  max-height: 400px;
  overflow-y: auto;
}

/* モバイル対応 */
@media (max-width: 767px) {
  .nx-header {
    max-height: 300px;
  }
}

/* 背景メディアCSS */
.nx-area1[data-bg-type="image"] {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.nx-bg-video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -1;
}
```

#### /single-nx-tokyo.php:344-374, 379-384
```php
// 背景メディア設定取得と表示判定
$bg_image = get_field('nx_background_image');
$bg_video = get_field('nx_background_video');
$bg_priority = get_field('nx_background_priority') ?: 'image';

$display_type = 'default';
$bg_style = '';

if ($bg_priority === 'image') {
    if ($bg_image) {
        $display_type = 'image';
        $bg_style = 'background-image: url(' . esc_url($bg_image['url']) . ');';
    } elseif ($bg_video) {
        $display_type = 'video';
    }
} else {
    if ($bg_video) {
        $display_type = 'video';
    } elseif ($bg_image) {
        $display_type = 'image';
        $bg_style = 'background-image: url(' . esc_url($bg_image['url']) . ');';
    }
}

// HTML出力
<section class="nx-area1" data-bg-type="<?php echo esc_attr($display_type); ?>" <?php if ($display_type === 'image') echo 'style="' . esc_attr($bg_style) . '"'; ?>>
  <?php if ($display_type === 'video') : ?>
    <video class="nx-bg-video" autoplay muted loop playsinline>
      <source src="<?php echo esc_url($bg_video['url']); ?>" type="video/mp4">
    </video>
  <?php endif; ?>
```

## 動作検証結果

### Playwright MCP検証（2025-08-28実施）
- **375px（モバイル）**: nx-header 300px制限正常
- **768px（タブレット）**: 表示レイアウト正常
- **1920px（デスクトップ）**: nx-header 400px制限正常
- **ACFフィールド**: WordPress管理画面で正常表示
- **背景表示**: デフォルト赤背景正常表示

### ブラウザ互換性
- Chrome/Safari/Firefox最新版対応
- svh/dvh/vhフォールバック動作確認済み
- autoplay muted設定でモバイル再生対応

## セキュリティ対策
- `esc_url()`, `esc_attr()`, `esc_html()` 使用
- ファイルタイプ制限（画像: jpg/png/webp、動画: mp4）
- ファイルサイズ制限（動画: 10MB）

## パフォーマンス考慮
- WebP画像対応
- woff2フォント最適化
- CSS Grid/Flexbox効率的レイアウト
- `font-display: swap` CLS対策

## 実装完了日
2025年08月28日

## 次回開発時の参考情報
- Tokyo SVGベクター表示は `nx_tokyo_vector_show` フィールドで制御
- TIME TABLE表示は DAY1/DAY2 リンク入力時のみ表示
- 背景メディアのデフォルトは赤背景（#FF0000）
- nx-area1 の `position: relative` 設定により z-index 管理