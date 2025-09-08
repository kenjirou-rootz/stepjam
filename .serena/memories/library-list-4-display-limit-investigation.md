# フロントページライブラリリスト4件表示制限調査結果

**調査日**: 2025年8月22日  
**調査対象**: STEPJAMプロジェクト フロントページのライブラリリスト表示制限  
**結論**: 意図的な設計による4件制限

## 問題の特定結果

### 表示制限の実装箇所
1. **front-page.php 内での関数呼び出し**
   - line 663: `stepjam_get_dancers_with_acf('tokyo', 4)` (デスクトップ東京)
   - line 701: `stepjam_get_dancers_with_acf('osaka', 4)` (デスクトップ大阪)
   - line 795: `stepjam_get_dancers_with_acf('tokyo', 4)` (モバイル東京)
   - line 833: `stepjam_get_dancers_with_acf('osaka', 4)` (モバイル大阪)

2. **関数仕様** (inc/acf-fields.php:842-871)
   ```php
   function stepjam_get_dancers_with_acf($location = '', $count = -1) {
       $args = array(
           'post_type' => 'toroku-dancer',
           'posts_per_page' => $count,  // 第2引数で件数制限
           'orderby' => 'rand',         // ランダム表示
           // 条件：公開済み + アイキャッチ画像必須
       );
   }
   ```

## 制限の理由
- **デザイン上の配慮**: 各エリア4件ずつの表示でレイアウトを統一
- **パフォーマンス**: データ取得量を制限
- **ランダム表示**: `orderby => 'rand'` により毎回異なるダンサーを表示

## 解決方法
### より多くのダンサーを表示する場合
```php
// 6件表示の例
$tokyo_dancers = stepjam_get_dancers_with_acf('tokyo', 6);
$osaka_dancers = stepjam_get_dancers_with_acf('osaka', 6);
```

### 全件表示する場合
```php
// 制限なし（-1で全件取得）
$tokyo_dancers = stepjam_get_dancers_with_acf('tokyo', -1);
$osaka_dancers = stepjam_get_dancers_with_acf('osaka', -1);
```

## 注意事項
- ランダム表示のため、登録数が4件超の場合は表示されないダンサーが存在
- レスポンシブデザインへの影響を考慮した変更が必要
- 4箇所すべて（デスクトップ・モバイル × 東京・大阪）の変更が必要