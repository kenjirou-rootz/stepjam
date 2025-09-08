# News & Info セクション完全実装ガイド

## 概要
STEPJAMテーマのフロントページに実装されたNews & Infoセクションの包括的な技術仕様書

## 基本構造

### カスタム投稿タイプ
- **投稿タイプ名**: `info-news`
- **表示名**: Info & News記事

### タクソノミー構造
- **タクソノミー名**: `info-news-type`
- **ターム1**: `info` (Info記事用)
- **ターム2**: `news` (News記事用)

## ACFフィールド構成

### 基本フィールド
1. **`info_news_visual_type`** (選択フィールド)
   - 値: `'video'` | その他
   - 用途: 記事の種類判定（動画 or 通常記事）

2. **`info_news_show_date`** (True/False)
   - デフォルト値なし
   - 用途: 日付表示制御
   - 実装: 空/null時は自動的にtrueで表示

### 画像関連フィールド
3. **`info_news_image`** (画像フィールド)
   - 用途: 通常記事のメイン画像
   - 配列形式: `['url' => string, 'alt' => string]`

4. **`info_news_video_thumbnail`** (画像フィールド)
   - 用途: 動画記事専用サムネイル
   - 配列形式: `['url' => string, 'alt' => string]`

## テンプレート実装

### ファイル構成
- **メインテンプレート**: `/template-parts/news-info-section.php`
- **インクルード元**: `/front-page.php`
```php
<?php get_template_part('template-parts/news-info-section'); ?>
```

### クエリロジック

#### Info記事取得
```php
$info_args = array(
    'post_type' => 'info-news',
    'posts_per_page' => 7,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'info-news-type',
            'field' => 'slug',
            'terms' => 'info',
        ),
    ),
);
$info_posts = get_posts($info_args);
```

#### News記事取得
```php
$news_args = array(
    'post_type' => 'info-news',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'info-news-type',
            'field' => 'slug',
            'terms' => 'news',
        ),
    ),
);
$news_posts = get_posts($news_args);
```

## 出力ロジック詳細

### レスポンシブ構造
- **デスクトップ版** (≥768px): `.news-info-desktop`
- **モバイル版** (≤767px): `.news-info-mobile`

### Info記事出力パターン
```php
<?php foreach ($info_posts as $post) : 
    setup_postdata($post);
    $show_date = get_field('info_news_show_date');
    // デフォルト日付表示ロジック
    if ($show_date === '' || $show_date === null) {
        $show_date = true;
    }
?>
<article class="info-item">
    <a href="<?php the_permalink(); ?>">
        <div class="info-content">
            <?php if ($show_date): ?>
                <time datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date('m'); ?><br><?php echo get_the_date('d'); ?>
                </time>
            <?php endif; ?>
            <h3><?php the_title(); ?></h3>
            <p><?php echo wp_trim_words(get_the_content(), 20, '...'); ?></p>
        </div>
    </a>
</article>
<?php endforeach; wp_reset_postdata(); ?>
```

### News記事出力パターン
```php
<?php foreach ($news_posts as $post) : 
    setup_postdata($post);
    $visual_type = get_field('info_news_visual_type');
    $show_date = get_field('info_news_show_date');
    // デフォルト日付表示ロジック
    if ($show_date === '' || $show_date === null) {
        $show_date = true;
    }
?>
<article class="news-item">
    <a href="<?php the_permalink(); ?>">
        <!-- ビジュアルエリア -->
        <div class="news-visual">
            <?php if ($visual_type === 'video'): 
                $video_thumbnail = get_field('info_news_video_thumbnail');
                if ($video_thumbnail): ?>
                    <img src="<?php echo esc_url($video_thumbnail['url']); ?>" 
                         alt="<?php echo esc_attr($video_thumbnail['alt'] ?: get_the_title()); ?>"
                         class="news-image">
                <?php endif;
            else: 
                $main_image = get_field('info_news_image');
                if ($main_image): ?>
                    <img src="<?php echo esc_url($main_image['url']); ?>" 
                         alt="<?php echo esc_attr($main_image['alt'] ?: get_the_title()); ?>"
                         class="news-image">
                <?php endif;
            endif; ?>
        </div>
        
        <!-- コンテンツエリア -->
        <div class="news-content">
            <?php if ($show_date): ?>
                <time datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date('m/d'); ?>
                </time>
            <?php endif; ?>
            <h3><?php the_title(); ?></h3>
            <p><?php echo wp_trim_words(get_the_content(), 40, '...'); ?></p>
        </div>
    </a>
</article>
<?php endforeach; wp_reset_postdata(); ?>
```

## 画像表示の分岐ロジック

### 動画記事の場合
1. `info_news_visual_type` === 'video'をチェック
2. `info_news_video_thumbnail`フィールドを取得
3. サムネイル画像が設定されていれば表示
4. 未設定の場合は画像なしで表示

### 通常記事の場合
1. `info_news_visual_type` !== 'video'の場合
2. `info_news_image`フィールドを取得
3. メイン画像が設定されていれば表示

## 日付表示ロジック

### 実装された安全な日付表示
```php
$show_date = get_field('info_news_show_date');
// デフォルトで日付を表示（フィールドが空の場合）
if ($show_date === '' || $show_date === null) {
    $show_date = true;
}
```

### Info記事の日付フォーマット
- デスクトップ・モバイル共通: `08\n23` (月と日を改行で分割)

### News記事の日付フォーマット
- デスクトップ・モバイル共通: `08/23` (月/日形式)

## CSS実装概要

### コンテナクエリ対応
- 768px閾値でデスクトップ・モバイル切り替え
- CSS Grid 12カラムレイアウト

### SVGタイトル
- Infoタイトル: `/assets/news-info/info-title.svg`
- Newsタイトル: `/assets/news-info/news-title.svg`
- デスクトップ: 50%幅、モバイル: 25%幅

## Read Moreリンク
両セクションに投稿タイプアーカイブへのリンクを設置:
```php
<a href="<?php echo esc_url(get_post_type_archive_link('info-news')); ?>">
    Read More <span class="arrow">›</span>
</a>
```

## 技術的な注意点

1. **投稿データリセット**: 各foreachループ後に`wp_reset_postdata()`を実行
2. **セキュリティ**: `esc_url()`, `esc_attr()`でサニタイズ
3. **アクセシビリティ**: `datetime`属性付きの`<time>`要素使用
4. **フォールバック**: 画像altが未設定時は記事タイトルを使用

## デバッグ・トラブルシューティング

### よくある問題
1. **日付が表示されない** → ACFフィールド`info_news_show_date`の設定確認
2. **画像が表示されない** → 該当ACF画像フィールドの設定確認
3. **記事が表示されない** → タクソノミータームの割り当て確認

### 確認手順
1. WordPress管理画面でカスタム投稿タイプ`info-news`の存在確認
2. タクソノミー`info-news-type`で`info`・`news`ターム確認
3. 各記事でACFフィールド設定確認