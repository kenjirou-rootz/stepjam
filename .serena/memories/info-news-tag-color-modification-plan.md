# Info & News タグ色修正計画

## 問題特定
現在のアーカイブページ（http://stepjam.local/info-news/）では：
- INFOとNEWSタグが同じクラス `.info-news-archive-tag` を使用
- 両方とも同じ色（半透明の白背景、白文字）で表示
- デスクトップとモバイルで異なるスタイル設定

## ユーザー要望
- INFOタグ: 赤色
- NEWSタグ: 青色
- 12カラムレイアウトを維持

## 修正方針
1. **テンプレートファイル修正** (`archive-info-news.php`)
   - `.info-news-archive-tag` クラスに加えて、タクソノミーベースの個別クラスを追加
   - INFO: `info-news-archive-tag-info`
   - NEWS: `info-news-archive-tag-news`

2. **CSSファイル修正** (`assets/css/style.css`)
   - INFO用スタイル: 赤背景色
   - NEWS用スタイル: 青背景色
   - デスクトップとモバイル両方に対応

## 修正箇所
- `archive-info-news.php`: 82行目、179行目（デスクトップ・モバイル版）
- `assets/css/style.css`: `.info-news-archive-tag` 関連スタイルに追加

## グローバル指針への準拠
- 12カラムグリッド維持
- コンテナクエリ対応維持
- clamp()による可変対応維持