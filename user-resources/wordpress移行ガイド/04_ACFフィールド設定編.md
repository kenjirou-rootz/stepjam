# WordPress移行ガイド - ACFフィールド設定編

## 概要

現在のHTMLで使用されている143個のdata-acf属性を基に、セクション単位でACFフィールドグループを作成します。

## 必要プラグイン

### Advanced Custom Fields Pro
- **ライセンス**: 開発者ライセンス必要
- **バージョン**: 最新版（6.x推奨）
- **機能**: リピーターフィールド、柔軟コンテンツ、フィールドグループ

## フィールドグループ設計

### 1. Hero Section フィールドグループ

#### 基本設定
- **タイトル**: Hero Section
- **表示場所**: フロントページ（front-page.php）
- **位置**: 高（上部表示）

#### フィールド構成
```
フィールドラベル        フィールド名              タイプ        返り値
──────────────────────────────────────────────────────────────
Hero Logo             hero_logo               Image         URL
Hero Logo Alt Text    hero_logo_alt          Text          -
表示設定              hero_display_settings  True/False    -
```

#### フィールド詳細設定
**Hero Logo (hero_logo)**
- 返り値の形式: URL
- プレビューサイズ: Medium
- ライブラリ: すべて
- 最小サイズ: 300×50px

### 2. Sponsor Section フィールドグループ

#### 基本設定
- **タイトル**: Sponsor Section
- **表示場所**: フロントページ
- **位置**: 高

#### フィールド構成（リピーターフィールド使用）
```
フィールドラベル        フィールド名              タイプ        返り値
──────────────────────────────────────────────────────────────
Sponsor Content      sponsor_content         Repeater      -
├─ Video Type        video_type              Select        -
├─ Video File        video_file              File          URL
├─ YouTube URL       youtube_url             URL           -
├─ Video Poster      video_poster            Image         URL
└─ Display Order     display_order           Number        -

Sponsor Text Image   sponsor_text_image      Image         URL
Sponsor Bottom Text  sponsor_bottom_text     Text          -
```

#### サブフィールド詳細
**Video Type (video_type)**
- 選択肢: 
  - file: アップロードファイル
  - youtube: YouTube埋め込み
  - placeholder: プレースホルダー

**リピーター設定**
- 最小行数: 1
- 最大行数: 5
- レイアウト: テーブル

### 3. WHSJ Section フィールドグループ

#### 基本設定
- **タイトル**: WHSJ Section
- **表示場所**: フロントページ
- **位置**: 高

#### フィールド構成
```
フィールドラベル        フィールド名              タイプ        返り値
──────────────────────────────────────────────────────────────
Desktop構成
WHSJ Video (Desktop)  whsj_video_desktop      File/URL      URL
WHSJ Content Image    whsj_content_image      Image         URL
WHSJ Text Content     whsj_text_content       Textarea      -
WHSJ Promotion Title  whsj_promo_title       Image         URL
WHSJ Sono Box         whsj_sono_box          Image         URL

Mobile構成
WHSJ Video (Mobile)   whsj_video_mobile      File/URL      URL
Ve Sono Mobile        ve_sono_mobile         Image         URL
WHSJ Text (Mobile)    whsj_text_mobile       Textarea      -
WHSJ Promo (Mobile)   whsj_promo_mobile      Image         URL
```

### 4. Library Section フィールドグループ

#### 基本設定
- **タイトル**: Library Section
- **表示場所**: フロントページ
- **位置**: 高

#### フィールド構成
```
フィールドラベル        フィールド名              タイプ        返り値
──────────────────────────────────────────────────────────────
Library Title Tokyo  lib_title_tokyo         Image         URL
Library Title Osaka  lib_title_osaka         Image         URL
Display Settings     lib_display_settings    Group         -
├─ Cards Per Row     cards_per_row          Number        -
└─ Show Count        show_count             True/False    -
```

### 5. Dancer Library フィールドグループ

#### 基本設定
- **タイトル**: Dancer Profile
- **表示場所**: 投稿タイプ = dancer-library
- **位置**: 高

#### フィールド構成
```
フィールドラベル        フィールド名              タイプ        返り値
──────────────────────────────────────────────────────────────
Profile Image        dancer_image            Image         URL
Display Name         dancer_display_name     Text          -
Profile Text         dancer_profile          Textarea      -
Social Links         social_links            Repeater      -
├─ Platform          social_platform         Select        -
├─ URL               social_url              URL           -
└─ Icon              social_icon             Image         URL
```

#### サブフィールド詳細
**Social Platform (social_platform)**
- 選択肢:
  - instagram: Instagram
  - twitter: Twitter
  - youtube: YouTube
  - tiktok: TikTok

### 6. Site Options フィールドグループ

#### 基本設定
- **タイトル**: Site Options
- **表示場所**: オプションページ
- **位置**: 高

#### フィールド構成
```
フィールドラベル        フィールド名              タイプ        返り値
──────────────────────────────────────────────────────────────
Header
Header Logo          header_logo             Image         URL
Navigation Icon      nav_icon                Image         URL

Footer
Footer Logo VE       footer_logo_ve          Image         URL
Footer Logo Main     footer_logo_main        Image         URL
Footer Contact Image footer_contact_image    Image         URL
Footer Background    footer_bg_image         Image         URL

Contact Information
Company Name         company_name            Text          -
Company Address      company_address         Textarea      -
Contact Email        contact_email           Email         -
Privacy Policy URL   privacy_policy_url      URL           -
```

## ACF設定の実装手順

### Step 1: オプションページの作成
```php
// functions.phpに追加
if(function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Site Settings',
        'menu_title' => 'サイト設定',
        'menu_slug' => 'site-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-settings',
        'position' => 30
    ));
}
```

### Step 2: フィールドグループの作成

#### 管理画面での操作
1. **管理画面** → **カスタムフィールド** → **フィールドグループ**
2. **新規追加**で各フィールドグループを作成
3. 上記の設計に従ってフィールドを追加
4. 表示条件を設定

#### JSONでのインポート/エクスポート
```php
// inc/acf-fields.phpでのフィールド登録例
function stepjam_register_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        // Hero Sectionフィールドグループ
        acf_add_local_field_group(array(
            'key' => 'group_hero_section',
            'title' => 'Hero Section',
            'fields' => array(
                array(
                    'key' => 'field_hero_logo',
                    'label' => 'Hero Logo',
                    'name' => 'hero_logo',
                    'type' => 'image',
                    'return_format' => 'url',
                    'preview_size' => 'medium'
                )
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'front-page.php'
                    )
                )
            )
        ));
    }
}
add_action('acf/init', 'stepjam_register_acf_fields');
```

### Step 3: テンプレートでの値取得

#### front-page.phpでの使用例
```php
<?php
// Hero Section
$hero_logo = get_field('hero_logo');
if ($hero_logo): ?>
    <img src="<?php echo esc_url($hero_logo); ?>" 
         alt="<?php echo get_field('hero_logo_alt') ?: 'STEPJAM'; ?>" 
         class="w-full h-full object-contain" />
<?php endif; ?>

// Sponsor Section（リピーターフィールド）
<?php if (have_rows('sponsor_content')): ?>
    <div class="swiper-wrapper">
        <?php while (have_rows('sponsor_content')): the_row(); 
            $video_type = get_sub_field('video_type');
            $video_file = get_sub_field('video_file');
            $youtube_url = get_sub_field('youtube_url');
        ?>
            <div class="swiper-slide">
                <?php if ($video_type === 'file' && $video_file): ?>
                    <video autoplay muted loop>
                        <source src="<?php echo esc_url($video_file); ?>" type="video/mp4">
                    </video>
                <?php elseif ($video_type === 'youtube' && $youtube_url): ?>
                    <!-- YouTube埋め込み処理 -->
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
```

#### dancer-libraryテンプレートでの使用例
```php
<?php
// Dancer Library投稿での画像取得
$args = array(
    'post_type' => 'dancer-library',
    'posts_per_page' => -1,
    'orderby' => 'rand',
    'tax_query' => array(
        array(
            'taxonomy' => 'dancer-location',
            'field' => 'slug',
            'terms' => 'tokyo'
        )
    )
);

$tokyo_dancers = new WP_Query($args);

if ($tokyo_dancers->have_posts()): 
    while ($tokyo_dancers->have_posts()): $tokyo_dancers->the_post();
        $dancer_image = get_field('dancer_image');
        $display_name = get_field('dancer_display_name');
?>
        <div class="dancer-card">
            <?php if ($dancer_image): ?>
                <img src="<?php echo esc_url($dancer_image); ?>" 
                     alt="<?php echo esc_attr($display_name ?: get_the_title()); ?>">
            <?php endif; ?>
            <h3><?php echo $display_name ?: get_the_title(); ?></h3>
        </div>
<?php 
    endwhile;
    wp_reset_postdata();
endif; 
?>
```

## 注意事項

### パフォーマンス最適化
- **get_field()の適切な使用**: ループ内での過度な使用を避ける
- **キャッシュ活用**: 重いクエリは適切にキャッシュ
- **画像最適化**: ACFで設定した画像は適切なサイズで表示

### セキュリティ
- **出力のエスケープ**: `esc_url()`, `esc_attr()`, `esc_html()`を使用
- **入力値検証**: カスタムバリデーション関数の実装

### 保守性
- **フィールド名の統一**: data-acf属性との対応を明確化
- **ドキュメント化**: 各フィールドの用途を明記
- **バックアップ**: フィールド設定のJSONエクスポート