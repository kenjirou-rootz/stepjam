# STEPJAM開発ベストプラクティス

## 🏗️ ACF（Advanced Custom Fields）安全な実装パターン

### 基本原則
1. **防御的プログラミング**: ACFフィールドの返値は必ず型チェック
2. **フォールバック**: 値が存在しない場合の代替処理
3. **一貫性**: 統一された取得・表示パターンの使用

### 推奨コードパターン

#### ファイル・画像フィールド（URL取得）
```php
// 安全なURL取得パターン
$field = get_field('field_name', 'option');
$url = '';
if ($field) {
    $url = is_array($field) ? ($field['url'] ?? '') : $field;
}

// 使用例
if ($url) {
    echo '<img src="' . esc_url($url) . '" alt="...">';
}
```

#### 画像フィールド（URL + ALT取得）
```php
// 完全な画像処理パターン
$image = get_field('image_field');
if ($image) {
    $image_url = is_array($image) ? ($image['url'] ?? '') : $image;
    $image_alt = is_array($image) ? ($image['alt'] ?? '') : '';
    
    if ($image_url) {
        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
    }
}
```

#### テキストフィールド
```php
// テキストフィールドの安全な取得
$text = get_field('text_field', 'option');
if ($text) {
    echo '<p>' . nl2br(esc_html($text)) . '</p>';
}
```

### ユーティリティ関数

#### functions.phpに追加推奨
```php
/**
 * ACFファイルフィールドからURLを安全に取得
 */
function stepjam_get_acf_url($field_name, $post_id = false) {
    $field = get_field($field_name, $post_id);
    if (!$field) return '';
    
    return is_array($field) ? ($field['url'] ?? '') : $field;
}

/**
 * ACF画像フィールドからALTテキストを安全に取得
 */
function stepjam_get_acf_alt($field_name, $post_id = false, $fallback = '') {
    $field = get_field($field_name, $post_id);
    if (!$field || !is_array($field)) return $fallback;
    
    return $field['alt'] ?? $fallback;
}

/**
 * ACFテキストフィールドを安全に取得・表示
 */
function stepjam_get_acf_text($field_name, $post_id = false, $nl2br = true) {
    $text = get_field($field_name, $post_id);
    if (!$text) return '';
    
    $escaped = esc_html($text);
    return $nl2br ? nl2br($escaped) : $escaped;
}
```

## 🔍 デバッグ・エラー監視

### WordPress Debug設定
```php
// wp-config.php に追加
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### PHPエラーログ監視
```bash
# Local by Flywheel環境
tail -f "/Users/hayashikenjirou/Local Sites/stepjam/logs/php/error.log"
```

### 開発時チェックリスト
- [ ] ACFフィールド使用箇所で型チェック実装済み
- [ ] フォールバック処理を適切に設定
- [ ] esc_url(), esc_attr(), esc_html() でサニタイズ
- [ ] PHPエラーログでFatal Error確認
- [ ] ブラウザでフロントエンド表示確認

## 🚨 エラー対応フロー

### 1. 症状確認
- フロントエンド白画面・セクション非表示
- WordPress管理画面アクセス不可
- 特定ページのみ表示問題

### 2. エラーログ確認
```bash
cd "/Users/hayashikenjirou/Local Sites/stepjam"
tail -20 "logs/php/error.log"
```

### 3. 問題特定
- Fatal Error行番号からファイル・コード特定
- ACFフィールドの返値形式確認
- 管理画面でのフィールド設定確認

### 4. 修正実装
- 型チェック・フォールバック追加
- 同様パターンの一括修正
- テスト確認・エラーログ再確認

## 📦 バックアップ戦略

### 定期バックアップ
- **テーマファイル**: 重要変更前に必ずバックアップ
- **データベース**: Local SQL fileの定期コピー
- **完全バックアップ**: 機能追加・大規模変更前

### バックアップ命名規則
```
テーマ: complete-backup-YYYYMMDD_HHMMSS/
データベース: database-backup-complete-YYYYMMDD_HHMMSS.sql
個別ファイル: filename_backup_YYYYMMDD_HHMMSS.php
```

## 🔧 開発環境設定

### 推奨拡張・ツール
- PHP Error Logs 監視
- WordPress Debug Bar (開発環境)
- ACF Field Type確認用プラグイン

### コード品質
- WordPress Coding Standards準拠
- セキュリティベストプラクティス遵守
- パフォーマンス最適化（画像・スクリプト）

---
*更新日: 2025年8月30日*  
*対象環境: Local by Flywheel + WordPress 6.8 + ACF Pro*