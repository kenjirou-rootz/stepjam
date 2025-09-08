# FAQ関連 WordPress フック実装

## functions.php における FAQ カスタマイズ

### 実装場所
`/app/public/wp-content/themes/stepjam-theme/functions.php` (362-394行目)

### 1. プレビューリンクのカスタマイズ
```php
// FAQプレビューリンクの変更
function stepjam_faq_preview_redirect($preview_link, $post) {
    // 投稿オブジェクトとタイプのチェック
    if (!$post || !isset($post->post_type) || $post->post_type !== 'faq') {
        return $preview_link;
    }
    
    // FAQアーカイブページへリダイレクト
    return home_url('/faq/');
}
add_filter('preview_post_link', 'stepjam_faq_preview_redirect', 10, 2);
```

**用途**: FAQ編集画面の「変更をプレビュー」ボタンクリック時の遷移先変更

### 2. 管理バーリンクのカスタマイズ
```php
// 管理バー「FAQを表示」リンクの変更
function stepjam_admin_bar_faq_link($wp_admin_bar) {
    global $post;
    
    // FAQ編集画面でのみ実行
    if (is_admin() && $post && isset($post->post_type) && $post->post_type === 'faq') {
        // 既存の「表示」リンクを削除
        $wp_admin_bar->remove_node('view');
        
        // FAQアーカイブページへのリンクを追加
        $wp_admin_bar->add_node(array(
            'id' => 'view-faq-archive',
            'title' => 'FAQを表示',
            'href' => home_url('/faq/'),
        ));
    }
}
add_action('admin_bar_menu', 'stepjam_admin_bar_faq_link', 81);
```

**用途**: WordPress上部管理バーの表示リンクを単体ページからアーカイブへ変更

### 3. 削除済み機能（参考）
**更新ボタンリダイレクト**: `redirect_post_location` フィルター
- ユーザー指示により実装せず
- 更新後は通常通り単体投稿編集画面に留まる

## フック実行優先度
- `preview_post_link`: 優先度 10
- `admin_bar_menu`: 優先度 81（他のノード追加後に実行）

## 今後の拡張ポイント
1. FAQ検索機能の追加
2. カテゴリー分類の実装
3. よく見られているFAQの自動ソート
4. 関連FAQ表示機能