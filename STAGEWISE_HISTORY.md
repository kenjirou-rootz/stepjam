# StageWise MCP 作業履歴管理

## 概要
このファイルはStageWise MCPシステムに関する作業履歴と現在の状況を記録します。

## 履歴

### 2025年9月7日 - StageWise MCP v2.0 完全削除
- **時刻**: 00:13:26
- **理由**: ユーザー要望により、次回インポート/インストール時の干渉・競合防止のため完全削除
- **バックアップ場所**: `/バックアップ/stagewise-complete-deletion-20250907_001326/`
- **削除内容**:
  - mcp-stagewise-server/ ディレクトリ
  - .mcp.json設定（StageWise関連部分）
  - mcp-stagewise-server-validation.js
  - 関連するnode_modules

### StageWise MCP v2.0の機能
StageWiseは以下の機能を提供していました：
- **ブラウザ拡張機能との連携**: Web要素を選択して改善要望を送信
- **WebSocket通信**: ポート8765でブラウザ拡張と通信
- **MCP統合**: Claude Codeと連携して要素改善を自動化
- **最小限の実装**: DOM要素5項目とユーザープロンプトのみ送信

## 現在の状況
- StageWise MCPは完全削除済み
- プロジェクトルートの空ファイル（stagewise.json、mcp-stagewise-server-validation.js）は削除残骸
- MCPファイルシステム設定は新規追加済み（2025年9月7日）

## 復元方法（必要時）
```bash
# 1. バックアップから復元
cp -r /Users/hayashikenjirou/Local Sites/stepjam/バックアップ/stagewise-complete-deletion-20250907_001326/mcp-stagewise-server/ /Users/hayashikenjirou/Local Sites/stepjam/

# 2. MCP設定を更新
# .mcp.jsonに以下を追加:
# "stagewise": {
#   "type": "stdio",
#   "command": "node",
#   "args": ["mcp-stagewise-server/dist/index.js"]
# }

# 3. 依存関係インストールとビルド
cd mcp-stagewise-server
npm install
npm run build

# 4. サーバー起動
npm start
```

## 今後の管理方針
1. StageWise再導入時は本ファイルに記録
2. バージョン更新時は履歴セクションに追記
3. 問題発生時は現在の状況セクションを更新
4. 定期的にバックアップを作成

## 関連ファイル
- `/バックアップ/stagewise-complete-deletion-20250907_001326/利用ガイド.md` - 使用方法
- `/バックアップ/stagewise-complete-deletion-20250907_001326/README.md` - 技術詳細
- `/バックアップ/stagewise-complete-deletion-20250907_001326/BACKUP_INFO.md` - バックアップ詳細