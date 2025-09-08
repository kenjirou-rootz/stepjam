# SP-Custom-Info-News モバイルデザイン実装記録

## 実装日時
2025-08-23

## 実装概要
Info-newsカスタム投稿タイプの767px以下モバイルデザインを、指定された参考画像に基づいて完全に新しいデザインに変更しました。

## 参考デザイン
- パス: `/Users/hayashikenjirou/Local Sites/stepjam/ユーザーarea/ーー作成/カスタム記事/SP-custom-info-news/sp-custom-info-news.png`
- デザインの特徴:
  - 黒い背景
  - 上部に日付とタイトル（ヘッダーエリア）
  - 中央に青いビジュアルエリア（100svh高さ）
  - 下部にコンテンツとリンクボタン（コンテンツエリア）

## 実装内容

### 1. CSSファイルの修正 (`/assets/css/style.css`)
**開始行**: 1454行目付近の `/* モバイルレイアウト (767px以下) */` セクション

**主な変更**:
- 従来の縦並びレイアウトから、CSS Gridベースの3エリアレイアウトに変更
- 新しいgrid構造:
  ```css
  grid-template-areas: 
      "header-area"
      "visual-area" 
      "content-area";
  ```

**重要な実装詳細**:
- `min-height: 100svh` による全画面表示（フォールバック: 100vh）
- visual-areaに `100vh/100svh` の高さ設定
- `display: flex; align-items: center; justify-content: center` による中央軸揃え
- `font-family: 'Noto Sans JP', sans-serif` によるフォント統一
- `clamp()` 関数を使用した流動的レスポンシブタイポグラフィ

### 2. PHPテンプレートファイルの修正 (`/single-info-news.php`)
**変更箇所**: 111-182行目の `<!-- Mobile Layout -->` セクション

**構造変更**:
- 従来の5つの独立したセクション構成から、CSS Gridに対応した3エリア構造に変更:
  1. `info-news-mobile-header-area` (日付・タイトル)
  2. `info-news-mobile-visual-area` (画像・動画)
  3. `info-news-mobile-content-area` (コンテンツ・ボタン)

## 技術仕様
- **CSS Grid**: 3行1列のグリッドレイアウト
- **svh単位**: 新しいビューポート単位を使用（フォールバック付き）
- **Noto Sans JP**: Google Fontsを使用
- **clamp()関数**: 流動的タイポグラフィスケーリング
- **中央揃え**: Flexboxによる視覚コンテンツの中央配置

## テスト確認
- **URL**: http://stepjam.local/info-news/テスト記事：info-news-システム検証/
- **テストデバイス**: 375x667px（iPhone SE相当）
- **確認事項**: 
  - 全画面レイアウトの実現
  - グリッドエリアの正常な配置
  - レスポンシブ動作の確認

## ファイル変更履歴
1. `/assets/css/style.css` - モバイルスタイル完全置き換え
2. `/single-info-news.php` - モバイルHTML構造をGrid対応に変更

## 今後のメンテナンス注意点
- svh単位は比較的新しい仕様のため、古いブラウザ対応が必要な場合はvhフォールバックが重要
- Noto Sans JPフォントの読み込み確認
- 各グリッドエリアのコンテンツが適切に配置されているかの定期確認