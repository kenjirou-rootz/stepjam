# Info & News アーカイブページ改修状況（2025.08.25）

## 🚨 重要：改修は未完了です

ユーザー様より「まだ正しくあたっていない」とのフィードバックを受けており、追加の改修が必要です。

## 📋 実施した改修内容

### 1. バックアップファイル
- `/assets/css/style_backup_20250825_133005.css`
- `/archive-info-news_backup_20250825_133042.php`

### 2. CSS改修（/assets/css/style.css）

#### ルート変数設定（行1720-1732）
```css
:root {
    --info-news-container-pad: clamp(24px, 4vw, 48px);
    --info-news-gap-x: clamp(24px, 3vw, 48px);
    --info-news-gap-y: clamp(32px, 4vw, 48px);
    --info-news-visual-height: clamp(200px, 22vh, 280px);
    --info-news-font: 'Noto Sans JP', sans-serif;
}
```

#### 12カラムグリッド実装（行1745-1766）
- 12カラムグリッドを実装
- 左カード：5カラム、中央余白：2カラム、右カード：5カラム
- コンテナクエリ使用：`@container info-news-archive (min-width: 768px)`

#### 画像エリア処理（行1785-1798）
- **問題点**: 100svw設定を除去し、`calc(100% + 40px)`に変更
- 左側に-20pxオフセットで中央配置

#### ピンクコンテンツエリア（行1801-1811）
- 背景色：#E066AA
- パディング：clamp(16px, 2vw, 24px)

## 🗃️ データ取得構造

### PHPテンプレート（archive-info-news.php）

#### 投稿データ取得
```php
$posts = get_posts(array(
    'post_type' => 'info-news',
    'posts_per_page' => 6,  // デスクトップ：6記事
    'post_status' => 'publish'
));
```

#### 各カードで取得するデータ

1. **ACFフィールド**
   - `info_news_visual_type`: 画像/動画の種別
   - `info_news_show_date`: 日付表示フラグ
   - `info_news_video_url`: 動画URL
   - `info_news_video_thumbnail`: 動画サムネイル
   - `info_news_image`: メイン画像

2. **タクソノミー情報**
   ```php
   $tags = get_the_terms(get_the_ID(), 'info-news-type');
   // info または news のslugを取得してタグ色を決定
   ```

3. **基本情報**
   - `the_title()`: 記事タイトル
   - `get_the_content()`: 本文（抜粋用）
   - `get_the_date('Y.m.d')`: 投稿日付
   - `the_permalink()`: 記事URL

## ❌ 未解決の問題点

1. **レイアウト崩れ**
   - ユーザー様より「正しくあたっていない」とのフィードバック
   - 参考画像通りの2×3グリッドが正しく表示されていない可能性

2. **画像のはみ出し処理**
   - 100svw除去後も適切な表示になっていない可能性
   - カード枠を「少し」超える程度の調整が必要

3. **コンテナクエリの動作**
   - @containerが期待通りに動作していない可能性
   - フォールバックとして@mediaクエリの検討が必要かも

## 📐 参考画像の要件

- **デスクトップ**: `/ユーザーarea/ーー修正依頼/newsinfo包括エリア/sj-info_newsinfo-all.png`
- **モバイル**: 左側に画像、右側にピンクのコンテンツエリア
- **重要**: 黄色エリアは固定高さ、画像は100svw中央配置（ただし現在の実装では問題あり）

## 🔧 次の改修者への推奨事項

1. **Playwrightで現状確認**
   - 実際の表示を確認し、参考画像との差異を特定
   - 特に2×3グリッドの配置を重点的に確認

2. **グリッド構造の見直し**
   - 現在の12カラムグリッドが正しく機能しているか検証
   - subgridの使用も検討

3. **画像はみ出し処理の再検討**
   - 参考画像の「黄色パス」の意図を正確に理解
   - overflow: clipの適用位置を再確認

4. **コンテナクエリのデバッグ**
   - ブラウザの開発者ツールでコンテナサイズを確認
   - 必要に応じて従来の@mediaクエリに切り替え

## 📝 ユーザー要望まとめ

1. 参考画像の完全再現
2. 12カラムグリッド + subgrid使用
3. コンテナクエリでのレスポンシブ対応
4. clampによる流体的なサイズ調整
5. INFO=赤、NEWS=青のタグ色分け
6. 実際の投稿日付を正しい位置に表示

引き継ぎ後は、まずPlaywrightで現状を確認し、参考画像との差異を明確にしてから改修を進めることを推奨します。