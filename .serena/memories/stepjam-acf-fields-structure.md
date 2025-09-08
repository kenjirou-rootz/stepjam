# STEPJAM ACF フィールド構造詳細

## NX TOKYO カスタム投稿タイプ ACFフィールド

### 基本情報フィールド
```php
// イベントタイトル・サブタイトル
'nx_event_title'     // デフォルト: 'STEPJAM TOKYO'
'nx_event_subtitle'  // デフォルト: '2025 SUMMER'
```
**役割**: エリア2見出し部分に表示
**紐付け先**: `.nx-heading h1` 要素

### エリア選択フィールド
```php
'nx_area_selection' // ラジオボタン選択
// 選択肢:
// - 'none' => 'なし' (デフォルト)
// - 'tokyo' => 'TOKYO'
// - 'osaka' => 'OSAKA'  
// - 'tohoku' => 'TOHOKU'
```
**役割**: 
- ヘッダーエリア表示/非表示制御
- エリア別背景色設定
- ベクター画像パス決定
- DAY2セクション背景色制御

**紐付け先**:
- PHP: `$area_configs` 配列で設定管理
- CSS: `.area-{selection}` クラス適用
- HTML: `nx-tokyo-container` のクラス名

### 背景メディアフィールド
```php
'nx_background_image'    // 画像アップロード
'nx_background_video'    // 動画アップロード  
'nx_background_priority' // ラジオボタン: 'image' | 'video'
```
**役割**: エリア1背景メディア制御
**紐付け先**: 
- `nx-area1` 要素の `data-bg-type` 属性
- 画像: `background-image` CSS
- 動画: `<video class="nx-bg-video">` 要素

### ナビゲーションリンクフィールド
```php
'nx_day1_link'    // URL入力
'nx_day2_link'    // URL入力
'nx_ticket_link'  // URL入力
```
**役割**: フッターボタンエリアの表示制御
**紐付け先**: 
- DAY1/DAY2ボタン: `.nx-day-button` 要素
- チケットボタン: `.nx-ticket-button` 要素
- TIME TABLE表示判定: いずれかのDAYリンク存在時

### コンテンツブロックフィールド (リピーター)
```php
'nx_content_blocks' // リピーターフィールド
├── 'block_title'   // サブフィールド: テキスト
└── 'block_content' // サブフィールド: テキストエリア
```
**役割**: エリア2メインコンテンツ
**紐付け先**:
- `.nx-content-block` 要素 (動的生成)
- タイトル: `.nx-block-title h3`
- 内容: `.nx-block-content p`

## ACF フィールドグループ設定

### 表示ルール
```php
'location' => array(
    array(
        array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'nx-tokyo',
        ),
    ),
),
```

### 表示位置
- **Position**: 'normal' (メインコンテンツ下)
- **Style**: 'default'
- **Label Placement**: 'top'