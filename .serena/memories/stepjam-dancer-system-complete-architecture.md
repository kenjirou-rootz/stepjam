# STEPJAM プロジェクト ダンサーシステム 完全仕組み記録

**プロジェクト**: STEPJAM ローカル開発環境 (http://stepjam.local/)  
**テーマ**: stepjam-theme  
**調査日**: 2025年8月22日  
**調査方式**: Ultra Think (正確性重視・過去ログ参照なし)

## 1. システム全体概要

### プロジェクト構造
- WordPressカスタムテーマ: `/Users/hayashikenjirou/Local Sites/stepjam/app/public/wp-content/themes/stepjam-theme/`
- カスタム投稿タイプ: `toroku-dancer` (登録ダンサー)
- front-page.php → single-toroku-dancer.php の完全連携システム

### 核心的な連携構造
front-page.phpの lib-list-cards-area がダンサー一覧表示のエントリーポイントとして機能し、各ダンサーカードクリックで single-toroku-dancer.php の詳細ページに遷移する仕組み。

## 2. lib-list-cards-area 詳細仕組み

### 2.1 フロントエンド表示構造
**location**: front-page.php line 607-869 (Library List Section)

#### デスクトップ版
- **Container**: `.lib-list-cards-area` (line 655-737)
- **東京エリア**: `#tokyo-dancers` (line 661-696)
- **大阪エリア**: `#osaka-dancers` (line 699-734)

#### モバイル版
- **Container**: `.lib-list-cards-area-mobile` (line 787-869)
- **東京エリア**: `#tokyo-dancers-mobile` (line 793-828)
- **大阪エリア**: `#osaka-dancers-mobile` (line 831-869)

### 2.2 データ取得メカニズム
**Core Function**: `stepjam_get_dancers_with_acf()` (inc/acf-fields.php line 846-871)

#### 関数実装詳細
```php
function stepjam_get_dancers_with_acf($location = '', $count = -1) {
    $args = array(
        'post_type' => 'toroku-dancer',
        'posts_per_page' => $count,
        'orderby' => 'rand',                    // ★ランダム表示
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',       // ★アイキャッチ画像必須
                'compare' => 'EXISTS'
            )
        )
    );
    
    // エリア絞り込み (tokyo/osaka)
    if (!empty($location)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'toroku-dancer-location',
                'field' => 'slug',
                'terms' => $location
            )
        );
    }
    
    return new WP_Query($args);
}
```

### 2.3 ランダム表示の影響範囲
**ランダム処理**: `'orderby' => 'rand'` により以下4箇所全てでランダム表示

1. **デスクトップ東京**: `stepjam_get_dancers_with_acf('tokyo', 4)` (line 663)
2. **デスクトップ大阪**: `stepjam_get_dancers_with_acf('osaka', 4)` (line 701)
3. **モバイル東京**: `stepjam_get_dancers_with_acf('tokyo', 4)` (line 795)
4. **モバイル大阪**: `stepjam_get_dancers_with_acf('osaka', 4)` (line 833)

**表示件数**: 各エリア4件ずつ  
**条件**: 公開済み + アイキャッチ画像必須 + エリア別絞り込み

### 2.4 single-toroku-dancer.php への連携
**Link Generation**: 各カードで `get_permalink()` を使用
```php
$dancer_permalink = get_permalink();
<a href="<?php echo esc_url($dancer_permalink); ?>" class="lib-list-card">
```

**URL Pattern**: `/toroku-dancer/ダンサースラッグ/`
**実例確認済み**:
- テストダンサー → `/toroku-dancer/テストダンサー/`
- KENJIROU → `/toroku-dancer/test-dancer/`

## 3. single-toroku-dancer.php 詳細構造

### 3.1 テンプレート階層
- **ファイル**: `single-toroku-dancer.php`
- **適用対象**: カスタム投稿タイプ `toroku-dancer` の単一投稿表示
- **URL rewrite**: `'slug' => 'toroku-dancer'` (inc/custom-post-types.php line 41)

### 3.2 ACFデータ取得構造
**location**: single-toroku-dancer.php line 12-19
```php
$dancer_genre = get_field('dancer_genre') ?: 'HIP-HOP';
$dancer_profile_text = get_field('dancer_profile_text') ?: '';
$performance_video_1 = get_field('performance_video_1') ?: '';
$performance_video_2 = get_field('performance_video_2') ?: '';
$instagram_url = get_field('toroku_instagram_url') ?: '';
$twitter_url = get_field('toroku_twitter_url') ?: '';
$youtube_url = get_field('toroku_youtube_url') ?: '';
$tiktok_url = get_field('toroku_tiktok_url') ?: '';
```

### 3.3 レイアウト構造
#### デスクトップ版 (line 29-88)
- **左列**: サムネイル画像エリア (30%)
- **右列**: コンテンツエリア (70%)
  - ヘッダー (ダンサー名・ジャンル)
  - Performance セクション (YouTube動画2本)
  - Profile セクション (プロフィール文章・SNSアイコン)

#### モバイル版 (line 91-143)
- 縦積みレイアウト
- Performance: Swiper スライダー対応
- レスポンシブ対応 (`md:hidden`)

## 4. カスタム投稿タイプ・タクソノミー構造

### 4.1 toroku-dancer カスタム投稿タイプ
**定義場所**: inc/custom-post-types.php line 17-50

#### 設定詳細
```php
'post_type' => 'toroku-dancer'
'rewrite' => array('slug' => 'toroku-dancer')
'has_archive' => false
'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions')
'menu_icon' => 'dashicons-admin-users'
```

### 4.2 toroku-dancer-location タクソノミー
**定義場所**: inc/custom-post-types.php line 57-88

#### 設定詳細
```php
'taxonomy' => 'toroku-dancer-location'
'hierarchical' => true
'rewrite' => array('slug' => 'toroku-dancer-location')
```

#### デフォルトエリア (line 95-120)
- **Tokyo**: slug 'tokyo', description '東京エリアの登録ダンサー'
- **Osaka**: slug 'osaka', description '大阪エリアの登録ダンサー'

## 5. ACFフィールド構成詳細

### 5.1 フィールドグループ
**Group**: `group_toroku_dancer` (inc/acf-fields.php line 689-793)  
**適用先**: post_type = 'toroku-dancer'  
**位置**: 'acf_after_title'

### 5.2 フィールド詳細
#### 基本情報
- `dancer_genre`: ダンスジャンル (text, 必須, default: 'HIP-HOP')
- `dancer_profile_text`: プロフィール文章 (textarea, 必須, 8行)

#### Performance動画セクション
- `performance_video_1`: Performance動画1 (URL, YouTube)
- `performance_video_2`: Performance動画2 (URL, YouTube)

#### SNS・ソーシャルセクション
- `toroku_instagram_url`: Instagram URL
- `toroku_twitter_url`: Twitter URL  
- `toroku_youtube_url`: YouTube URL
- `toroku_tiktok_url`: TikTok URL

## 6. CSS実装詳細

### 6.1 デスクトップ版スタイル
**location**: assets/css/style.css line 344-398

#### .lib-list-cards-area
- `display: flex`
- `gap: clamp(1rem, 2.5%, 2rem)`
- `justify-content: center`

#### .lib-list-card
- `max-width: 280px`
- `aspect-ratio: 9/16` (縦長比率)
- `transition: transform 0.3s ease`
- ホバーエフェクト: `transform: translateY(-5px)`

### 6.2 モバイル版スタイル
**location**: assets/css/style.css line 436以降

#### .lib-list-cards-area-mobile
- Grid レイアウト
- `max-width: min(600px, 90%)`
- `margin: 0 auto`

### 6.3 single-toroku-dancer.php 専用スタイル
**location**: assets/css/style.css line 876以降
- `.toroku-dancer-detail` クラス
- デスクトップ・モバイル分離レイアウト

## 7. WordPress管理画面構成

### 7.1 メニュー構造確認済み
- **メインメニュー**: 「登録ダンサー」
- **サブメニュー**: 
  - 登録ダンサー一覧
  - 新しい登録ダンサーを追加
  - Toroku Dancer Locations (タクソノミー管理)

### 7.2 現在のデータ状況 (2025年8月22日調査時点)
- **公開済み**: 5件の登録ダンサー
- **エリア分布**: 全て東京エリア
- **ゴミ箱**: 1件

## 8. プロジェクト特有の重要ポイント

### 8.1 ランダム表示の影響
- ページリロード毎にダンサーの表示順序が変化
- 4件表示のため、登録ダンサーが4件超の場合は表示されないダンサーが存在

### 8.2 アイキャッチ画像必須設計
- `'_thumbnail_id' EXISTS` により画像なしダンサーは表示されない
- lib-list-cards-area での表示条件として機能

### 8.3 エリア別完全分離
- 東京・大阪でデータベースレベルから分離
- タクソノミーによる確実な絞り込み

### 8.4 レスポンシブ対応
- デスクトップ・モバイルで完全分離されたHTML構造
- Tailwind CSS + カスタムCSS併用

## 9. 次回確認時の重要確認項目

1. **データ取得**: `stepjam_get_dancers_with_acf()` の動作
2. **ランダム表示**: `'orderby' => 'rand'` の影響範囲
3. **連携確認**: front-page.php → single-toroku-dancer.php のリンク
4. **ACFフィールド**: `group_toroku_dancer` の全フィールド
5. **エリア分類**: tokyo/osaka タクソノミー動作

**注意**: このシステムはSTEPJAMプロジェクト専用の実装であり、他プロジェクトとは一切関連がありません。