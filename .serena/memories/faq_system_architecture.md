# WordPress FAQ システムアーキテクチャ

## 概要
STEPJAM テーマにおける FAQ（よくある質問）機能の実装詳細と改修履歴。

## システム構成

### 1. カスタム投稿タイプ
- **投稿タイプ名**: `faq`
- **定義場所**: `/inc/custom-post-types.php`
- **アーカイブURL**: `/faq/`

### 2. ACFフィールド構成
- **faq_published**: チェックボックス (integer 1/0) - 公開状態管理
- **faq_question**: テキストフィールド - 質問文
- **faq_answer**: WYSIWYGエディタ - 回答内容
- **faq_order**: 数値フィールド - 表示順序

### 3. テンプレートファイル
- **archive-faq.php**: FAQアーカイブページ（アコーディオン表示）
  - WP_Query使用で公開済みFAQを取得
  - meta_query で faq_published = 1 を条件指定
  - Tailwind CSS + カスタムCSSでスタイリング

### 4. JavaScript動作
- **assets/js/main.js**: FAQアコーディオン制御
- **assets/js/faq-accordion.js**: 専用アニメーション処理
- クリックで質問展開・折りたたみ動作

### 5. CSS/アニメーション
- **assets/css/faq-animations.css**: 展開アニメーション定義
- data-state属性でexpanded/collapsed状態管理
- opacity, height, transform によるスムーズな遷移

## 技術的詳細

### WP_Query実装
```php
$faq_query = new WP_Query(array(
    'post_type' => 'faq',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => 'faq_published',
            'value' => 1,  // 整数型で指定（ACFチェックボックス）
            'compare' => '='
        )
    ),
    'meta_key' => 'faq_order',
    'orderby' => 'meta_value_num',
    'order' => 'ASC'
));
```

## 管理画面カスタマイズ
- FAQ編集画面からのリダイレクト動線を改善
- プレビューボタン、管理バー表示リンクを `/faq/` へ統一