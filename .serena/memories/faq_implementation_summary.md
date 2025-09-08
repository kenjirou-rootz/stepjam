# FAQ機能実装サマリー

## 実装概要
WordPressカスタム投稿タイプ「FAQ」の完全な実装と管理画面UX改善。

## 主要コンポーネント

### フロントエンド
- **URL**: `/faq/`
- **テンプレート**: `archive-faq.php`
- **表示形式**: アコーディオン型（質問クリックで回答展開）
- **スタイル**: Tailwind CSS + カスタムアニメーション
- **レスポンシブ**: モバイル/タブレット/デスクトップ対応

### バックエンド
- **カスタム投稿タイプ**: `faq`
- **ACFフィールドグループ**: FAQ専用フィールド
  - faq_published（公開状態）
  - faq_question（質問文）
  - faq_answer（回答文）
  - faq_order（表示順）
- **管理画面カスタマイズ**: リダイレクト動線改善

### JavaScript機能
- アコーディオン開閉アニメーション
- aria属性による アクセシビリティ対応
- data-state による状態管理
- スムーズなheight/opacity遷移

## ファイル構成
```
stepjam-theme/
├── archive-faq.php          # FAQアーカイブテンプレート
├── functions.php            # フック実装（362-394行）
├── inc/
│   ├── custom-post-types.php # FAQ投稿タイプ定義
│   └── acf-fields.php       # ACFフィールド設定
├── assets/
│   ├── css/
│   │   └── faq-animations.css # アニメーション定義
│   └── js/
│       ├── main.js           # メインJS（FAQ制御含む）
│       └── faq-accordion.js  # FAQ専用スクリプト
```

## 改修時の注意点
1. ACFフィールドの型（特にチェックボックス = integer）
2. WP_Query のmeta_query条件
3. インラインスタイルよりCSSクラス優先
4. Tailwind ユーティリティの活用
5. WordPress標準フックの理解

## 動作確認項目
- FAQ新規作成・編集・公開
- アコーディオン展開・折りたたみ
- プレビュー機能
- 管理バーリンク
- レスポンシブ表示