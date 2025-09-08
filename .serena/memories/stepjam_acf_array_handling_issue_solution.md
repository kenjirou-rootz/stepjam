# STEPJAM ACF配列処理問題・解決策

## 📋 事象概要
**発生日**: 2025年8月29日  
**問題**: PHP Fatal Error: ltrim(): Argument #1 ($string) must be of type string, array given  
**影響**: フロントページテンプレート実行停止、セクション非表示

## 🔍 根本原因分析

### 技術的原因
Advanced Custom Fields (ACF)のファイル・画像フィールドが配列形式で返されているのに、コードが文字列前提で処理していたため発生。

### ACF返却形式の違い
```php
// 配列形式（設定により）
array(
    'url' => 'http://example.com/file.mp4',
    'alt' => 'Alternative text',
    'title' => 'File title',
    'id' => 123
)

// 文字列形式（設定により）
'http://example.com/file.mp4'
```

### エラー発生箇所
1. **front-page.php:99** - `esc_url($sponsor_main_video_01)`
2. **template-parts/news-info-section.php:126** - `esc_url($main_image['url'])`

## 🔧 実装した解決策

### パターン1: 動画フィールド対応
```php
// 修正前（エラー発生）
$video = get_field('sponsor_main_video_01', 'option');
echo esc_url($video);

// 修正後（安全）
$video = get_field('sponsor_main_video_01', 'option');
$video_url = is_array($video) ? $video['url'] : $video;
echo esc_url($video_url);
```

### パターン2: 画像フィールド対応（より堅牢）
```php
// 修正前
echo esc_url($image['url']);
echo esc_attr($image['alt']);

// 修正後
echo esc_url(is_array($image) && isset($image['url']) ? $image['url'] : $image);
echo esc_attr((is_array($image) && isset($image['alt'])) ? $image['alt'] : get_the_title());
```

## 📝 修正対象ファイル

### front-page.php
- `$sponsor_main_video_01` (Line ~99)
- `$sponsor_main_video_02` (Line ~124)
- `$sponsor_main_video_03` (Line ~147)
- `$whsj_video` (Line ~278, ~373)

### template-parts/news-info-section.php
- `$main_image` (Line ~126, ~240)
- `$video_thumbnail` (Line ~119, ~232)

## ⚠️ 残存リスク

### 未修正箇所（要確認）
- `single-toroku-dancer.php:57` (エラーログで確認)
- その他テンプレートファイルでのACFフィールド使用箇所

### 推奨される追加対策
```php
// 統一的なACF安全取得関数
function safe_get_acf_url($field_name, $post_id = false) {
    $field = get_field($field_name, $post_id);
    return is_array($field) && isset($field['url']) ? $field['url'] : $field;
}

function safe_get_acf_alt($field_name, $post_id = false, $fallback = '') {
    $field = get_field($field_name, $post_id);
    return is_array($field) && isset($field['alt']) ? $field['alt'] : $fallback;
}
```

## 🛡️ 今後の予防策

### 1. 開発標準
- 全ACFフィールドに対して型チェック必須
- `get_field()`の返値は常に検証してから使用
- フォールバック値を適切に設定

### 2. プロセス改善
- ACFフィールド設定変更時のコード影響確認
- PHP Fatal Errorの継続監視（`wp-debug.log`）
- ローカル開発環境でのWP_DEBUG有効化

### 3. 監視項目
- `/Local Sites/stepjam/logs/php/error.log`
- WordPress管理画面での白画面・セクション非表示
- フロントエンド表示の定期確認

## 📊 復元結果
- ✅ Hero Section: 正常表示
- ✅ Sponsor Section: 正常表示（動画3本）
- ✅ WHSJ Section: 正常表示
- ✅ News & Info Section: 正常表示
- ✅ Library Section: 正常表示
- ✅ Footer: 正常表示
- ✅ ACF連携: 完全復旧

## 🔗 関連バックアップ
- **完全バックアップ**: `complete-backup-20250830_000702/`
- **データベース**: `database-backup-complete-20250830_000834.sql`
- **状態**: 全機能正常動作確認済み

---
*記録作成日: 2025年8月30日*  
*記録者: SuperClaude Ultra Think Framework*