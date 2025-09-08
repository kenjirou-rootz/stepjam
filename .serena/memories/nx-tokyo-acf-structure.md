# NX Tokyo ACF構造とテンプレート連携

## single-nx-tokyo.php ACF フィールド構造

### 基本イベント情報
- `nx_event_title`: イベントタイトル（デフォルト：'STEPJAM TOKYO'）
- `nx_event_subtitle`: サブタイトル（デフォルト：'2025 SUMMER'）

### コンテンツブロック（リピーターフィールド）
- `nx_content_blocks`: メインコンテンツのリピーター
  - `block_title`: ブロックタイトル
  - `block_content`: ブロック本文（nl2br対応）

### ビジュアル制御
- `nx_tokyo_vector_show`: TOKYOベクター表示制御（boolean）

### リンク設定
- `nx_day1_link`: DAY1ボタンリンク
- `nx_day2_link`: DAY2ボタンリンク  
- `nx_ticket_link`: チケットボタンリンク

### 背景メディア設定
- `nx_background_image`: 背景画像
- `nx_background_video`: 背景動画
- `nx_background_priority`: 優先度（'image' or 'video'）

### 動的ボタン制御ロジック
```php
// DAY1/DAY2ボタンの表示制御
$has_day1 = !empty($day1_link);
$has_day2 = !empty($day2_link);
$has_ticket = !empty($ticket_link);

// CSS クラス動的生成
$day_buttons_class = $has_day1 && $has_day2 ? 'both-days' : 
                    ($has_day1 ? 'day1-only' : 'day2-only');
$footer_buttons_class = $has_ticket ? 'has-ticket' : 'no-ticket';
```

### 背景メディア表示判定
```php
// 優先度ベース表示制御
$display_type = 'default'; // 青背景(#0000FF)
if ($bg_priority === 'image') {
    if ($bg_image) $display_type = 'image';
    elseif ($bg_video) $display_type = 'video';
} else {
    if ($bg_video) $display_type = 'video';
    elseif ($bg_image) $display_type = 'image';
}
```

## レスポンシブ実装方針

### CSS設計
- CSS変数（カスタムプロパティ）活用
- Container Queryベースの制御
- clamp()関数での流体設計
- dvh対応（iOS Safari配慮）

### ブレイクポイント戦略
- 768px基準でのレイアウト変更
- モバイル（767px以下）：縦積みレイアウト
- デスクトップ（768px以上）：2カラムグリッド

### パフォーマンス配慮
- CLS対策：aspect-ratio設定
- 画像最適化：loading="lazy"
- アニメーション軽減：prefers-reduced-motion対応

## テンプレート階層での位置付け
```
nx-tokyo投稿タイプ
↓
single-nx-tokyo.php（メインテンプレート）
├── header.php
├── メインコンテンツエリア（ACFベース）
├── template-parts/dancers-section.php
└── footer.php
```