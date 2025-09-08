# News & Info Section 相違点詳細分析

## 検証完了項目

### 参考画像確認:
- **デスクトップ版**: 左Info / 右News の2カラムレイアウト
- **モバイル版**: 縦並び（Info上 / News下）

### 現在の実装確認 (Playwright):
- **デスクトップスクリーンショット**: `/Users/hayashikenjirou/Local Sites/stepjam/.playwright-mcp/current-news-info-desktop.png`
- **モバイルスクリーンショット**: `/Users/hayashikenjirou/Local Sites/stepjam/.playwright-mcp/current-news-info-section.png`

## 発見した重要な相違点

### ❌ 1. 固定テキストの問題
**テンプレートファイル**: `/template-parts/news-info-section.php`

**Desktop News セクション (Line 136):**
```php
<h3 class="news-title">NEWS 記事タイトルが入る</h3>
```
✅ **修正必要**: `<?php the_title(); ?>` に変更

**Mobile Info セクション (Line 184):**
```php  
<h3 class="mobile-info-title">info 記事タイトル</h3>
```
✅ **修正必要**: `<?php the_title(); ?>` に変更

**Mobile Info 説明文 (Line 186):**
```php
1行で冒頭の内容だけが入り overflow で...
```
✅ **修正必要**: `<?php echo wp_trim_words(get_the_content(), 20, '...'); ?>` に変更

**Mobile News セクション (Line 246):**
```php
<h3 class="mobile-news-title">NEWS 記事タイトルが入る</h3>
```
✅ **修正必要**: `<?php the_title(); ?>` に変更

### ✅ 2. 正常に動作している要素
- SVGタイトル (Info/News) の表示
- 日付表示の動作
- Read Moreリンクの実装
- デスクトップ版Infoセクションのタイトル表示
- レスポンシブレイアウトの基本構造
- 記事画像の表示

## 参考画像との視覚的比較

### デスクトップ版:
- **レイアウト構造**: ✅ 左右2カラムは正しく実装
- **Info記事表示**: ✅ 実際のタイトルが表示されている  
- **News記事表示**: ❌ 固定テキストのまま

### モバイル版:
- **レイアウト構造**: ✅ 縦並びは正しく実装
- **Info記事表示**: ❌ 固定テキストのまま
- **News記事表示**: ❌ 固定テキストのまま

## 緊急修正項目
1. 固定テキストを実際の投稿データに置換（4箇所）
2. 動作確認とテスト