# SuperClaudeグローバル化実装完了 - 2025-01-24

## 実装内容
SuperClaudeフレームワークの自己完結型テンプレートをSTEPJAMプロジェクトに実装

## ファイル配置
- **場所**: /Users/hayashikenjirou/Local Sites/stepjam/CLAUDE.md
- **バージョン**: 4.0.8
- **タイプ**: self-contained universal template

## カスタマイズ内容

### プロジェクト概要
- プロジェクト名: STEPJAM
- 技術スタック: WordPress 6.8 + カスタムテーマ開発
- 開発環境: Local by Flywheel（macOS）
- チーム構成: 個人開発 + デザイン連携

### 技術固有設定
- CMS: WordPress 6.8
- テーマ: stepjam-theme（カスタムテーマ）
- PHP: 8.0+
- JavaScript: Vanilla JS + jQuery
- カスタム投稿タイプ: info-news, member他
- プラグイン: Advanced Custom Fields (ACF)

### プロジェクト固有制約
- デザイン準拠: 参考画像に忠実な実装必須
- レスポンシブ: モバイルファースト設計
- ブラウザサポート: モダンブラウザ対応
- アクセシビリティ: WCAG 2.1 AA準拠目標

### 開発ルール
- バックアップ: _backup_YYYYMMDD_HHMMSS形式
- コーディング規約: WordPress Coding Standards準拠
- CSS命名規則: BEM + WordPress標準クラス
- テスト: Playwright MCPでフロントエンド動作確認
- メモリ記録: Serena MCPで作業内容を必ず記録

## 機能確認
- SuperClaudeコマンド利用可能
- MCP Server機能アクセス可能
- 外部依存なしで動作
- 他PC環境でのポータビリティ確保

## 参照元
/Users/hayashikenjirou/Local Sites/stepjam/ユーザーarea/superclaude-グロバル化/CLAUDE_他デバok.md