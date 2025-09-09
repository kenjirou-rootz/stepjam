# STEPJAMリポジトリ監視・長期運用ガイド

## リポジトリ健全性メトリクス

### 容量制限（GitHub）
- **制限**: 2GB
- **推奨警告レベル**: 1.5GB (75%)
- **現在容量**: ~50MB (追跡ファイルのみ)

### セキュリティ監視

#### 禁止ファイルパターン
```bash
# セキュリティチェックコマンド
git ls-files | grep -E "(\.key|_rsa|_ed25519|\.pem|\.sql)$" && echo "⚠️ セキュリティリスク検出" || echo "✅ セキュリティチェック通過"
```

#### 容量監視コマンド
```bash
# 容量チェック（MB単位）
git ls-files | xargs -I {} du -k {} 2>/dev/null | awk '{sum+=$1} END {print "総容量: " sum/1024 "MB"}'
```

## 自動メンテナンススクリプト

### 月次チェック（推奨）
```bash
#!/bin/bash
# monthly-repo-check.sh

echo "=== STEPJAMリポジトリ健全性チェック ==="
cd "/Users/hayashikenjirou/Local Sites/stepjam"

# 1. 容量チェック
TOTAL_MB=$(git ls-files | xargs -I {} du -k {} 2>/dev/null | awk '{sum+=$1} END {print sum/1024}')
echo "追跡ファイル総容量: ${TOTAL_MB}MB"

if (( $(echo "$TOTAL_MB > 1500" | bc -l) )); then
    echo "⚠️ 警告: 容量が1.5GBを超過しています"
fi

# 2. セキュリティチェック
SECURITY_FILES=$(git ls-files | grep -E "(\.key|_rsa|_ed25519|\.pem|\.sql)$" | wc -l)
if [ $SECURITY_FILES -gt 0 ]; then
    echo "🚨 セキュリティリスク: 機密ファイルが追跡されています"
    git ls-files | grep -E "(\.key|_rsa|_ed25519|\.pem|\.sql)$"
else
    echo "✅ セキュリティチェック通過"
fi

# 3. 未追跡ファイル数
UNTRACKED=$(git status --porcelain | grep "^??" | wc -l)
echo "未追跡ファイル数: $UNTRACKED"

if [ $UNTRACKED -gt 20 ]; then
    echo "⚠️ 警告: 未追跡ファイルが多すぎます(.gitignore見直し推奨)"
fi

echo "=== チェック完了 ==="
```

## .gitignore保守ルール

### 追加時の確認事項
1. **WordPress本体除外**: 新しいWP更新ファイルの確認
2. **セキュリティ**: 機密情報の完全除外
3. **容量管理**: 大容量ファイル（>100MB）の自動除外
4. **開発効率**: 必要な設定ファイルの適切な追跡

### 定期レビュー項目
- [ ] WordPress本体の新しいディレクトリ/ファイル
- [ ] バックアップファイルの場所変更
- [ ] 新しい開発ツール出力ファイル
- [ ] セキュリティ要件の変更

## 緊急時対応

### セキュリティ侵害時
```bash
# 1. 即座にプライベートリポジトリに変更
# 2. 機密ファイルの完全削除
git filter-branch --force --index-filter 'git rm --cached --ignore-unmatch ssh/*' --prune-empty --tag-name-filter cat -- --all

# 3. 強制プッシュ（履歴削除）
git push origin --force --all
```

### 容量超過時
```bash
# 大容量ファイル特定
git ls-files | xargs -I {} du -k {} 2>/dev/null | sort -nr | head -20

# Git履歴からの削除（慎重に実行）
git filter-branch --force --index-filter 'git rm --cached --ignore-unmatch LARGE_FILE_PATH'
```

## 追跡ファイル分類

### 🟢 必須追跡（コア機能）
- `app/public/wp-content/themes/stepjam-theme/` - カスタムテーマ
- `deploy/` - デプロイスクリプト
- `docs/` - プロジェクトドキュメント

### 🟡 条件付き追跡（開発支援）
- `app/public/wp-content/themes/stepjam-theme/acf-json/` - ACFフィールド定義
- `.gitignore`, `CLAUDE.md` - プロジェクト設定

### 🔴 追跡禁止（セキュリティ・容量）
- `ssh/` - SSH鍵（全パターン）
- `*.sql` - データベースダンプ
- `backups/`, `バックアップ/` - バックアップファイル
- WordPress本体ファイル

## 長期運用ベストプラクティス

1. **月次健全性チェック**: 容量・セキュリティ・構造確認
2. **.gitignore定期見直し**: WordPress更新・新ツール対応
3. **セキュリティ監査**: 機密情報漏洩防止の徹底
4. **容量管理**: 2GB制限の遵守とアラート設定
5. **バックアップ戦略**: Gitとは独立したバックアップ体制

最終更新: 2025-09-09
責任者: Claude Code (Anthropic)