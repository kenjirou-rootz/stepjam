# STEPJAM 開発ワークフローガイド

## 開発環境構成

### Local by Flywheel環境
```
プロジェクトルート: /Users/hayashikenjirou/Local Sites/stepjam/
├── app/public/                     # WordPress本体
│   ├── wp-content/themes/stepjam-theme/  # カスタムテーマ
│   └── wp-content/uploads/         # メディアファイル
├── バックアップ/                   # CLAUDE.md準拠バックアップ
├── ユーザーarea/                   # ドキュメント・ログ
└── playwright-check/               # テスト環境
```

### アクセスURL
- **フロントエンド**: http://stepjam.local/
- **管理画面**: http://stepjam.local/wp-admin/
- **NX投稿一覧**: http://stepjam.local/nx-tokyo/

## CLAUDE.mdバックアップルール

### 必須バックアップ要件
すべてのWordPress編集前に必ずバックアップ実行:

```bash
# 単一ファイル編集時
mkdir -p "/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/{カテゴリ}/"
cp {元ファイル} "/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/{カテゴリ}/{ファイル名}_backup_{YYYYMMDD}_{HHMMSS}.{拡張子}"

# 複数ファイル・大規模改修時
mkdir -p "/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/complete-backup-{YYYYMMDD}_{HHMMSS}/"
cp -r . "/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/complete-backup/complete-backup-{YYYYMMDD}_{HHMMSS}/"
```

### バックアップカテゴリ
- **front-page/**: フロントページ関連
- **function/**: functions.php関連  
- **info-news/**: INFO・NEWS関連
- **登録ダンサー-single/**: ダンサー関連
- **nx-area-none-option/**: エリア「なし」オプション関連
- **complete-backup/**: 大規模改修時の完全バックアップ

## ファイル構造と役割

### コアテーマファイル
```
stepjam-theme/
├── functions.php              # テーマ機能設定
├── header.php / footer.php    # 共通ヘッダー・フッター
├── front-page.php            # ホームページテンプレート
├── single-nx-tokyo.php       # NX TOKYO投稿個別テンプレート
├── archive-nx-tokyo.php      # NX TOKYO投稿一覧テンプレート
└── template-parts/           # 部分テンプレート
    ├── dancers-section.php   # ダンサーセクション
    ├── sponsor-content.php   # スポンサーコンテンツ
    └── sponsor-logo-slider.php # スポンサーロゴスライダー
```

### 設定・管理ファイル
```
inc/
├── acf-fields.php           # ACFフィールド定義
├── custom-post-types.php   # カスタム投稿タイプ定義
└── enqueue-scripts.php     # スクリプト・スタイル読み込み
```

### アセットファイル
```
assets/
├── js/
│   └── main.js             # メインJavaScript (STEPJAMreApp)
├── css/                    # コンパイル済みCSS (将来用)
├── images/                 # 画像アセット
│   ├── nx-tokyo-vector.svg
│   ├── osaka/osaka.svg
│   └── tohoku/tohoku.svg
└── header/
    └── header-logo.svg     # ヘッダーロゴ
```

## 開発フロー

### 1. 新機能開発の標準プロセス
```
1. 要件確認 → 2. バックアップ作成 → 3. 実装 → 4. テスト → 5. 記録保存
```

### 2. ACFフィールド追加時
```
1. inc/acf-fields.php 編集
2. 対応テンプレートファイル修正  
3. CSS/JavaScript必要に応じて追加
4. Playwright テスト実行
5. WordPress管理画面で動作確認
```

### 3. テンプレート修正時
```
1. 対象PHPファイルバックアップ
2. HTML構造・PHP条件分岐修正
3. CSS スタイル調整
4. レスポンシブ確認 (375px, 768px, 1920px)
5. ブラウザ横断テスト
```

## テスト環境

### Playwright自動テスト
```bash
cd "/Users/hayashikenjirou/Local Sites/stepjam/playwright-check/dancers-section-fix-verification/"

# DAY2背景色テスト
node test-day2-background-colors.js

# エリア「なし」オプションテスト  
node test-area-none-option.js

# 手動検証テスト
node test-manual-none-verification.js
```

### ブラウザテスト環境
- **Chrome**: メインブラウザ
- **Firefox**: 互換性確認
- **Safari**: iOS/macOS対応確認
- **モバイル**: デバイスエミュレーション

### レスポンシブテスト
- **375px**: iPhone SE
- **768px**: タブレット境界
- **1920px**: デスクトップ

## トラブルシューティング

### よくある問題
1. **ACFフィールドが表示されない**
   - ACF Pro有効化確認
   - フィールドグループの投稿タイプ割り当て確認

2. **CSS適用されない**
   - セレクタの詳細度確認
   - `!important` の使用検討
   - JavaScript フォールバック実装

3. **レスポンシブレイアウト崩れ**
   - ブレークポイント確認 (768px)
   - コンテナクエリ対応確認

### デバッグ手法
```php
// PHP デバッグ
if (WP_DEBUG) {
    error_log('Debug: ' . print_r($variable, true));
}

// JavaScript デバッグ  
console.log('状態確認:', {
    container: container.className,
    day2Section: day2Section
});
```

## 記録・ドキュメント管理

### Serena MCP記録
- **アーキテクチャ**: stepjam-nx-tokyo-architecture-overview
- **ACFフィールド**: stepjam-acf-fields-structure  
- **スタイリング**: stepjam-styling-system
- **PHPロジック**: stepjam-php-logic-system
- **ダンサー統合**: stepjam-dancers-section-integration

### 技術問題解決記録
**CLAUDE.md内** `## Technical Issue Resolution History` セクションに追記:
- 問題概要・根本原因
- 修正内容詳細  
- バックアップ先
- 今後の保守ガイドライン