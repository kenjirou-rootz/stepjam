# WordPressプロジェクト分析結果 - 2025-08-28

## プロジェクト構造
- **プロジェクト**: STEPJAM
- **WordPress**: 6.8
- **テーマ**: stepjam-theme（カスタムテーマ）
- **環境**: Local by Flywheel

## 利用プラグイン
1. **Advanced Custom Fields Pro** - カスタムフィールド管理
2. **Custom Post Type UI** - カスタム投稿タイプ管理  
3. **WPForms Lite & Pro** - フォーム機能

## カスタム投稿タイプ
1. **toroku-dancer**（登録ダンサー）
   - スラッグ: toroku-dancer
   - アーカイブ: false
   - サポート: title, editor, thumbnail, excerpt, revisions
   - メニューアイコン: dashicons-admin-users

2. **info-news**（Info & NEWS）
   - スラッグ: info-news  
   - アーカイブ: true
   - サポート: title, editor, thumbnail, excerpt, revisions
   - メニューアイコン: dashicons-megaphone

## タクソノミー
- **toroku-dancer-location**: ダンサー用地域分類
- **info-news-type**: Info&News用タイプ分類

## テーマ構造
```
stepjam-theme/
├── functions.php - メイン設定
├── front-page.php - フロントページ
├── header.php / footer.php - 共通パーツ
├── style.css - メインスタイル
├── single-toroku-dancer.php - ダンサー詳細
├── single-info-news.php - Info&News詳細  
├── archive-info-news.php - Info&Newsアーカイブ
├── inc/
│   ├── custom-post-types.php - CPT定義
│   ├── acf-fields.php - ACF設定
│   └── enqueue-scripts.php - スクリプト読み込み
├── template-parts/ - パーツファイル
└── assets/ - アセット（CSS/JS/画像）
```

## ACF設定
- オプションページ設定
- カスタムフィールド登録
- YouTube URL変換機能
- ダンサーデータ取得機能

## 新テンプレート作成の準備状況
✅ **準備完了** - 全ての必要情報を収集し、テンプレート作成が可能な状態