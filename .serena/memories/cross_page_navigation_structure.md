# 他ページナビボタン検証: サイト構造調査結果

## 発見されたページテンプレート

**メインページ:**
- `front-page.php` - フロントページ（スクロール対象セクション存在）
- `page-contact.php` - CONTACTページ
- `page-about.php` - ABOUTページ

**カスタム投稿タイプページ:**
- `archive-info-news.php` - NEWSアーカイブページ
- `single-info-news.php` - 単一NEWSページ
- `single-toroku-dancer.php` - 登録ダンサー詳細ページ
- `single-nx-tokyo.php` - NX TOKYO詳細ページ

## 重要な発見

1. **全ページでget_header()使用**: すべてのページテンプレートで`get_header()`が呼ばれており、共通のナビメニューが表示される
2. **ナビメニューの統一性**: header.php + nav-overlay.phpが全ページで読み込まれる
3. **スクロール対象セクション**: hero-section, sponsor-section, whsj-section, lib-top-section はfront-page.phpにのみ存在

## 検証が必要な動作

**他ページからのスクロール系ナビ:**
- HOME → hero-section (フロントページ遷移が必要)
- SPONSORS → sponsor-section (フロントページ遷移が必要)
- ABOUT → whsj-section (フロントページ遷移が必要)
- LIBRARY → lib-top-section (フロントページ遷移が必要)

**ページ遷移系ナビ:**
- NEWS → /info-news/ (どのページからでも正常動作期待)
- CONTACT → /contact/ (どのページからでも正常動作期待)