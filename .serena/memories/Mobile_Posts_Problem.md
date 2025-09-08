# Mobile Posts Problem Analysis

## 問題特定
**ファイル**: `app/public/wp-content/themes/stepjam-theme/archive-info-news.php`
**行125-132**: モバイル用投稿取得で`posts_per_page => 3`に制限

## 現在の問題コード
```php
<!-- Mobile Layout - 全3記事詳細表示 -->
<div class="info-news-archive-mobile">
    <?php 
    $mobile_posts = get_posts(array(
        'post_type' => 'info-news',
        'posts_per_page' => 3,  /* 3投稿制限 */
        'post_status' => 'publish'
    ));
```

## 要求仕様との相違
- **デスクトップ**: 6投稿表示（正常）
- **モバイル**: 3投稿制限（問題）
- **要求**: 投稿数に応じた表示が必要

## 修正方針
`posts_per_page => 6`に変更し、デスクトップと同じ投稿数を表示