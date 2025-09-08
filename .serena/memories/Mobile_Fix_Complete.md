# Mobile Fix Complete - 767px以下表示修正

## 修正完了内容

### 問題解決
**ファイル**: `app/public/wp-content/themes/stepjam-theme/archive-info-news.php`
**修正箇所**: 行130 `posts_per_page => 3` → `posts_per_page => 6`

### 修正前後比較
**修正前:**
```php
<!-- Mobile Layout - 全3記事詳細表示 -->
$mobile_posts = get_posts(array(
    'post_type' => 'info-news',
    'posts_per_page' => 3,  /* 3投稿制限 */
    'post_status' => 'publish'
));
```

**修正後:**
```php
<!-- Mobile Layout - 全6記事詳細表示 -->
$mobile_posts = get_posts(array(
    'post_type' => 'info-news',
    'posts_per_page' => 6,  /* 6投稿表示 */
    'post_status' => 'publish'
));
```

### Playwright検証結果（375px時）
- **モバイルコンテナ**: `display: flex`, 子要素6個
- **デスクトップコンテナ**: `display: none`, 子要素6個（非表示）
- **総表示アイテム数**: 6個（正常）

### 表示状態確認
- ✅ **デスクトップ（768px以上）**: 6投稿を2×3グリッドで表示
- ✅ **モバイル（767px以下）**: 6投稿を縦1列で表示

## ✅ 修正完了：モバイルでも6投稿全て表示されるように修正