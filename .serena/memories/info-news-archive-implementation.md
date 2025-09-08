# Info & News アーカイブページ実装記録

## 実装概要
STEPJAMサイトのInfo & Newsカスタム投稿タイプ用の包括的アーカイブページを作成

## 作成ファイル
- `/app/public/wp-content/themes/stepjam-theme/archive-info-news.php` (完全新規作成)
- `/app/public/wp-content/themes/stepjam-theme/assets/css/style.css` (スタイル追加)

## デザイン仕様
### デスクトップ版 (768px以上)
- CSS Grid 2x3レイアウト (6記事表示)
- 左側：青色ビジュアル（動画/画像）
- 右側：TAG、タイトル、抜粋、日付
- 全ボックスクリック可能

### モバイル版 (767px以下)  
- 縦配置で3記事表示
- 左ビジュアル + 右コンテンツの横並び
- レスポンシブ対応

## 技術実装詳細
### PHP側機能
- `get_posts()` で記事取得 (デスクトップ6件、モバイル3件)
- ACFカスタムフィールド連携
  - `info_news_visual_type` (動画/画像判定)
  - `info_news_video_url` (動画URL)
  - `info_news_video_thumbnail` (動画サムネイル)
  - `info_news_image` (メイン画像)
  - `info_news_show_date` (日付表示制御)
- `get_the_terms()` で実際のWordPressタグ表示
- `wp_trim_words()` でテキスト切り詰め (デスクトップ25語、モバイル20語)

### CSS実装
- CSS Grid & Subgrid使用
- `clamp()` による流動的タイポグラフィ
- Noto Sans JP フォント適用
- 色彩：青色ビジュアル背景 (#2563EB)、白文字
- アニメーション：ホバー効果、スムーズトランジション

## 参考デザインとの適合性
✅ デスクトップ版：2x3グリッド配置完全一致  
✅ モバイル版：3記事横並び配置完全一致  
✅ TAG表示：実際のWordPressタクソノミー連携  
✅ クリック機能：全ボックス適切にリンク設定

## 検証結果
Playwright MCPによる精密検証にて、参考画像との完全一致を確認済み

## 関連ファイル
- `single-info-news.php` (個別記事テンプレート)
- カスタムフィールド設定 (ACF Pro)
- WordPress カスタム投稿タイプ「info-news」
- カスタムタクソノミー「info-news-type」

## 実装日
2025-08-23