# WordPress移行ガイド - Custom Post Type設定編

## 概要

`dancer-library`カスタム投稿タイプと、Tokyo/Osaka分類用カスタムタクソノミーの設定を行います。

## 必要プラグイン

### Custom Post Type UI
- **ダウンロード先**: WordPress公式プラグインディレクトリ
- **バージョン**: 最新版
- **用途**: カスタム投稿タイプ・タクソノミーの管理画面作成

## Custom Post Type UI設定

### Step 1: カスタム投稿タイプ作成

#### 基本設定
- **投稿タイプ名**: `dancer-library`
- **複数形ラベル**: `Dancer Libraries`
- **単数形ラベル**: `Dancer Library`

#### 詳細設定

```
設定項目               値                      説明
─────────────────────────────────────────────────────
Public                 true                   公開設定
Publicly Queryable     true                   クエリ可能
Show UI                true                   管理UI表示
Show In Nav Menus      true                   ナビメニューに表示
Show In Rest           true                   REST API対応
Rest Base              dancer-library         REST APIベース
Has Archive            false                  アーカイブページなし
Exclude From Search    false                  検索対象
Capability Type        post                   権限タイプ
Hierarchical           false                  階層なし
Rewrite                true                   URL書き換え
Rewrite Slug           dancer-library         URLスラッグ
Rewrite With Front     false                  フロント付けない
Query Var              true                   クエリ変数使用
Query Var Slug         dancer-library         クエリ変数名
Menu Position          5                      メニュー位置
Show In Menu           true                   管理メニュー表示
```

#### サポート機能
- **Title** (タイトル): ✓
- **Editor** (エディタ): ✗ (ACFで管理するため)
- **Author** (作成者): ✗
- **Thumbnail** (アイキャッチ): ✓
- **Excerpt** (抜粋): ✗
- **Comments** (コメント): ✗
- **Revisions** (リビジョン): ✓

#### ラベル設定
```php
// 管理画面でのラベル設定
'labels' => array(
    'name' => 'Dancer Libraries',
    'singular_name' => 'Dancer Library',
    'add_new' => '新しいダンサーを追加',
    'add_new_item' => '新しいダンサーライブラリを追加',
    'edit_item' => 'ダンサーライブラリを編集',
    'new_item' => '新しいダンサーライブラリ',
    'view_item' => 'ダンサーライブラリを表示',
    'search_items' => 'ダンサーライブラリを検索',
    'not_found' => 'ダンサーライブラリが見つかりません',
    'not_found_in_trash' => 'ゴミ箱にダンサーライブラリはありません'
)
```

### Step 2: カスタムタクソノミー作成

#### 基本設定
- **タクソノミー名**: `dancer-location`
- **複数形ラベル**: `Locations`
- **単数形ラベル**: `Location`
- **対象投稿タイプ**: `dancer-library`

#### 詳細設定

```
設定項目               値                      説明
─────────────────────────────────────────────────────
Public                 true                   公開設定
Publicly Queryable     true                   クエリ可能
Hierarchical           true                   階層あり（カテゴリー形式）
Show UI                true                   管理UI表示
Show In Menu           true                   メニュー表示
Show In Nav Menus      true                   ナビメニューに表示
Show In Rest           true                   REST API対応
Show Tagcloud          false                  タグクラウド非表示
Show In Quick Edit     true                   クイック編集表示
Show Admin Column      true                   管理画面カラム表示
Rewrite                true                   URL書き換え
Rewrite Slug           location               URLスラッグ
Rewrite With Front     false                  フロント付けない
Rewrite Hierarchical   true                   階層URL
Query Var              true                   クエリ変数使用
Query Var Slug         location               クエリ変数名
```

#### ラベル設定
```php
'labels' => array(
    'name' => 'Locations',
    'singular_name' => 'Location',
    'search_items' => 'ロケーションを検索',
    'all_items' => 'すべてのロケーション',
    'edit_item' => 'ロケーションを編集',
    'update_item' => 'ロケーションを更新',
    'add_new_item' => '新しいロケーションを追加',
    'new_item_name' => '新しいロケーション名'
)
```

#### デフォルトタームの作成
タクソノミー作成後、以下のタームを手動で追加：

1. **Tokyo**
   - 名前: Tokyo
   - スラッグ: tokyo
   - 説明: 東京エリアのダンサー

2. **Osaka** 
   - 名前: Osaka
   - スラッグ: osaka
   - 説明: 大阪エリアのダンサー

## functions.phpでの設定（代替方法）

Custom Post Type UIを使わない場合の、functions.phpでの実装コード：

### inc/custom-post-types.php
```php
<?php
/**
 * カスタム投稿タイプ・タクソノミー登録
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

// dancer-libraryカスタム投稿タイプの登録
function stepjam_register_dancer_library_post_type() {
    $labels = array(
        'name' => 'Dancer Libraries',
        'singular_name' => 'Dancer Library',
        'add_new' => '新しいダンサーを追加',
        'add_new_item' => '新しいダンサーライブラリを追加',
        'edit_item' => 'ダンサーライブラリを編集',
        'new_item' => '新しいダンサーライブラリ',
        'view_item' => 'ダンサーライブラリを表示',
        'search_items' => 'ダンサーライブラリを検索',
        'not_found' => 'ダンサーライブラリが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にダンサーライブラリはありません'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'rest_base' => 'dancer-library',
        'query_var' => true,
        'rewrite' => array('slug' => 'dancer-library'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title', 'thumbnail', 'revisions'),
        'menu_icon' => 'dashicons-groups'
    );

    register_post_type('dancer-library', $args);
}
add_action('init', 'stepjam_register_dancer_library_post_type');

// dancer-locationタクソノミーの登録
function stepjam_register_dancer_location_taxonomy() {
    $labels = array(
        'name' => 'Locations',
        'singular_name' => 'Location',
        'search_items' => 'ロケーションを検索',
        'all_items' => 'すべてのロケーション',
        'edit_item' => 'ロケーションを編集',
        'update_item' => 'ロケーションを更新',
        'add_new_item' => '新しいロケーションを追加',
        'new_item_name' => '新しいロケーション名'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'location',
            'with_front' => false,
            'hierarchical' => true
        )
    );

    register_taxonomy('dancer-location', array('dancer-library'), $args);
}
add_action('init', 'stepjam_register_dancer_location_taxonomy');

// デフォルトタームの作成
function stepjam_create_default_dancer_locations() {
    // Tokyo タームの作成
    if (!term_exists('Tokyo', 'dancer-location')) {
        wp_insert_term(
            'Tokyo',
            'dancer-location',
            array(
                'slug' => 'tokyo',
                'description' => '東京エリアのダンサー'
            )
        );
    }

    // Osaka タームの作成
    if (!term_exists('Osaka', 'dancer-location')) {
        wp_insert_term(
            'Osaka',
            'dancer-location',
            array(
                'slug' => 'osaka',
                'description' => '大阪エリアのダンサー'
            )
        );
    }
}
add_action('init', 'stepjam_create_default_dancer_locations');
```

## 管理画面での操作手順

### 投稿の作成
1. **管理画面** → **Dancer Libraries** → **新規追加**
2. **タイトル**: ダンサー名を入力
3. **Location**: Tokyo または Osaka を選択
4. **アイキャッチ画像**: ダンサーの画像を設定
5. **ACFフィールド**: 必要な情報を入力
6. **公開**: 投稿を公開

### タクソノミーの管理
1. **管理画面** → **Dancer Libraries** → **Locations**
2. **新しいLocationを追加**: 必要に応じて新しいエリアを追加
3. **既存Locationの編集**: 説明やスラッグの変更

## WP_Queryでの取得例

### 全投稿取得（ランダム表示）
```php
$args = array(
    'post_type' => 'dancer-library',
    'posts_per_page' => -1,
    'orderby' => 'rand',
    'post_status' => 'publish'
);

$dancers = new WP_Query($args);
```

### Tokyo投稿のみ取得
```php
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
```

## 注意事項

### パーマリンク設定
- カスタム投稿タイプ・タクソノミー登録後、**設定** → **パーマリンク設定** → **変更を保存**を実行
- URL構造の反映に必要

### データベース更新
- 大量のdancer-library投稿（計60件程度）を一度に作成する場合は、CSVインポートプラグインの活用を検討

### パフォーマンス
- `posts_per_page => -1`を使用する際は、投稿数が増えた場合のパフォーマンス影響を考慮
- 必要に応じてキャッシュ機構を導入