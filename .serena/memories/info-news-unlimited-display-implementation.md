# Info & News ページ無制限表示実装

## 実装概要
http://stepjam.local/info-news/ の記事表示を6記事制限から無制限表示に変更。

## 実装内容

### 変更ファイル
`/Users/hayashikenjirou/Local Sites/stepjam/app/public/wp-content/themes/stepjam-theme/archive-info-news.php`

### 変更箇所
1. **デスクトップレイアウト** (24行目):
   - 変更前: `'posts_per_page' => 6,`
   - 変更後: `'posts_per_page' => -1,`

2. **モバイルレイアウト** (130行目):
   - 変更前: `'posts_per_page' => 6,`
   - 変更後: `'posts_per_page' => -1,`

### バックアップ
- ファイル名: `archive-info-news_backup_20250826_173234_unlimited.php`
- 場所: テーマディレクトリ内

## 実装結果

### 現在の状況
- 変更は正常に適用済み
- 現在表示されている記事: 6記事（システム内の全記事）
- **WordPress内に6記事しか存在しないため、表示数に変化なし**

### 動作確認
- Playwright MCPで検証済み
- 無制限表示設定が正常に機能する状態
- 新しい記事が追加された際に自動的に全て表示される

### 技術詳細
- `posts_per_page => -1` はWordPressの標準的な「制限なし」設定
- 両レイアウト（デスクトップ・モバイル）で同様の設定を適用
- パフォーマンス影響は現在のところ軽微（6記事のため）

## 将来への配慮
- 記事数が大幅に増加した場合のパフォーマンス監視が必要
- 必要に応じてページング機能の実装を検討

## SuperClaude Framework
**Command**: `--ultrathink --serena --play --c7`
**Date**: 2025年8月26日
**Status**: 実装完了・正常動作確認済み