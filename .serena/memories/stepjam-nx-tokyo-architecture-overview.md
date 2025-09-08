# STEPJAM NX TOKYO アーキテクチャ概要

## プロジェクト全体構造

### WordPress環境
- **CMS**: WordPress 6.8
- **テーマ**: stepjam-theme (カスタムテーマ)
- **開発環境**: Local by Flywheel
- **ローカルURL**: http://stepjam.local/

### カスタム投稿タイプ
- `nx-tokyo` - NX TOKYO イベント投稿
- `toroku-dancer` - 登録ダンサー
- `info-news` - インフォメーション・ニュース

### 主要プラグイン
- Advanced Custom Fields Pro (ACF) - カスタムフィールド管理
- Custom Post Type UI - カスタム投稿タイプ作成
- WPForms - お問い合わせフォーム

## NX TOKYO投稿システム詳細

### URL構造
```
/nx-tokyo/                    # 一覧ページ
/nx-tokyo/{投稿スラッグ}/     # 個別投稿ページ
```

### テンプレートファイル
- **単体表示**: `single-nx-tokyo.php`
- **一覧表示**: `archive-nx-tokyo.php`
- **ダンサーセクション**: `template-parts/dancers-section.php`

### レスポンシブブレークポイント
- **モバイル**: ~767px
- **デスクトップ**: 768px~
- **コンテナクエリ**: 750px, 768px使い分け

## NX TOKYO投稿の画面構成

### レイアウト構造
```
nx-tokyo-container
├── nx-tokyo-wrapper (グリッドレイアウト)
    ├── nx-area1 (ビジュアルエリア)
    │   ├── nx-header (エリア選択時表示)
    │   ├── nx-header-spacer (なし選択時表示)
    │   └── nx-footer (ボタンエリア)
    └── nx-area2 (コンテンツエリア)
        ├── nx-heading
        └── nx-content-blocks
```

### エリア1: ビジュアルエリア
- **目的**: エリア別ビジュアル表示、ナビゲーションボタン
- **背景**: エリア別色分け（TOKYO=青、OSAKA=赤、TOHOKU=緑、なし=透明）
- **要素**: ロゴ、エリアベクター、DAY1/DAY2ボタン、チケットボタン

### エリア2: コンテンツエリア
- **目的**: イベント詳細情報表示
- **スクロール**: 768px以上で固定高さスクロール実装
- **要素**: イベントタイトル、コンテンツブロック（タイトル・内容ペア）