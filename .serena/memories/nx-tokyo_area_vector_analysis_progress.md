# NEXT SJ ACF エリアベクター対応 - 分析進捗

## 要件概要
TOKYOベクター単体表示を3エリア選択(TOKYO・OSAKA・TOHOKU)に変更

## 各エリア仕様
- TOKYO: 現在の青色、現在のtokyoベクター継続
- OSAKA: 赤色、/assets/images/osaka/osaka.svg
- TOHOKU: 緑色、/assets/images/tohoku/tohoku.svg

## 現在の実装状況
### ACF構造 (inc/acf-fields.php)
```php
// Line 847-854: 現在の単一トグル
array(
    'key' => 'field_nx_tokyo_vector_show',
    'label' => 'TOKYOベクター表示',
    'name' => 'nx_tokyo_vector_show',
    'type' => 'true_false'
)
```

### テンプレート実装 (single-nx-tokyo.php)
```php
// Line 416: 現在の取得処理
$tokyo_vector_show = get_field('nx_tokyo_vector_show');

// Line 428: 現在のベクターパス
$tokyo_vector_path = get_template_directory_uri() . '/assets/images/nx-tokyo-vector.svg';
```

## ファイル存在確認
✅ `/assets/images/osaka/osaka.svg` - 確認済み
✅ `/assets/images/tohoku/tohoku.svg` - 確認済み
✅ 現在のTOKYOベクター継続使用可能

## 次回実装タスク
1. ACFフィールド3エリア選択設計
2. テンプレート条件分岐実装
3. CSS背景色定義(赤・緑)
4. DAY2背景色連動実装
5. バックアップ＋Playwright検証

## 設計方針
- マイクロコンポーネント設計基準
- 既存ACF・スタイル影響最小化
- CLAUDE.mdバックアップ準拠
- 全デバイス対応