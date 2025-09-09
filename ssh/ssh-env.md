# STEPJAM SSH環境設定情報
**最終更新**: 2025年9月8日  
**統合ワークフロー**: セキュリティ保持型Git運用システム

## 🖥️ サーバー情報
| 項目 | 設定値 |
|------|--------|
| **サーバーID** | kenjirou0402 |
| **サーバー番号** | sv3020 |
| **ホスト名** | sv3020.xserver.jp |
| **IPアドレス** | 202.254.234.21 |
| **SSHポート** | 10022 |

## 🔐 SSH認証設定

### **現在使用中のSSHキー**
- **秘密鍵**: `ssh/kenjirou0402.key` (RSA, パスフレーズ保護)
- **公開鍵**: Xserver側登録済み (`sj-git-go`)
- **パスフレーズ**: `rootz6002` (合言葉)

### **SSH Agent設定**
```bash
# SSH Agent起動
eval "$(ssh-agent -s)"

# パスフレーズでキー登録
echo "rootz6002" | ssh-add ssh/kenjirou0402.key

# 登録確認
ssh-add -l
```

### **接続テスト**
```bash
# 直接接続
ssh -F ssh/config stepjam-xserver "whoami"

# 統合ワークフロー経由
./stepjam-git test
```

## 🐙 GitHub統合設定

### **GitHub認証**
| 項目 | 設定値 |
|------|--------|
| **アカウント** | kenjirou-rootz (k_hayashi@rootz-adl.com) |
| **リポジトリ** | https://github.com/kenjirou-rootz/stepjam.git |
| **SSH接続** | git@github.com:kenjirou-rootz/stepjam.git |
| **SSHキー** | `ssh/stepjam_github_ed25519` (パスフレーズなし) |

### **GitHub公開鍵** (登録済み)
```
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAICzKj1pESLMEH3LYo0fdxcyomgcd7lXPPHDaSCCh2Mj1 k_hayashi@rootz-adl.com
```
**タイトル**: `STEPJAM-Development-MacBook-2025`

## 🚀 統合運用ワークフロー

### **セキュリティ保持型Git運用**
```bash
# 基本Git操作
./stepjam-git git commit "Update theme features"
./stepjam-git git push origin main
./stepjam-git git pull origin main

# デプロイ操作
./stepjam-git deploy production
./stepjam-git deploy rollback
./stepjam-git deploy sync-media

# 接続テスト
./stepjam-git test
```

### **認証フロー**
1. **GitHub**: ED25519キー（パスフレーズなし）→ 高速認証
2. **Xserver**: RSAキー（パスフレーズ保護）→ セキュア認証
3. **SSH Agent**: セッション管理で一度認証すれば持続

## ⚡ WP-CLI設定
| 項目 | 設定値 |
|------|--------|
| **バージョン** | WP-CLI 2.8.1 |
| **インストール状態** | ✅インストール済み |
| **リモート操作** | SSH経由でWP-CLI実行可能 |

### **WP-CLIコマンド例**
```bash
# リモートでキャッシュクリア
ssh stepjam-xserver "cd /home/kenjirou0402/rootzexport.info/public_html && wp cache flush"

# プラグイン一覧
ssh stepjam-xserver "cd /home/kenjirou0402/rootzexport.info/public_html && wp plugin list"
```

## 📊 GitHub制限事項
- **Push頻度**: 毎分6回まで
- **Push容量**: 2GBを超える場合は分割実行
- **Large File**: 50MB超過ファイルはGit LFS推奨

## 🛡️ セキュリティベストプラクティス

### **パスフレーズ管理**
- ✅ Xserver SSH: `rootz6002`（合言葉として厳格管理）
- ✅ GitHub SSH: パスフレーズなし（高速Git操作）
- ✅ SSH Agent: セッション終了時に自動クリア

### **キーローテーション**
- **推奨頻度**: 3ヶ月毎
- **緊急時**: 即座にキー再生成・交換
- **監査**: 定期的な接続ログ確認

## 🔧 トラブルシューティング

### **SSH接続失敗時**
```bash
# SSH Agent確認
ssh-add -l

# SSH Agent再起動
eval "$(ssh-agent -s)"
echo "rootz6002" | ssh-add ssh/kenjirou0402.key

# 接続確認
ssh -F ssh/config stepjam-xserver "echo 'Connection OK'"
```

### **Git操作失敗時**
```bash
# GitHub接続確認
ssh -F ssh/config -T git@github.com

# Git設定確認
git config --list | grep ssh
```

## 🏗️ 環境URL
| 環境 | URL | 用途 |
|------|-----|------|
| **ローカル開発** | http://localhost:10004 | テーマ開発・テスト |
| **本番サイト** | https://rootzexport.info | 実運用サイト |
| **GitHub** | https://github.com/kenjirou-rootz/stepjam | バージョン管理 |

## 📞 緊急対応

### **アクセス拒否時**
1. SSH Agentリセット: `ssh-add -D`
2. キー再登録: `echo "rootz6002" | ssh-add ssh/kenjirou0402.key`
3. 接続テスト: `./stepjam-git test`

### **デプロイ失敗時**
1. 手動SSH接続確認
2. WP-CLIアクセス確認  
3. 必要に応じてロールバック: `./stepjam-git deploy rollback`

---

## 📋 設定ファイル構成
```
stepjam/
├── ssh/
│   ├── config                    # SSH接続設定
│   ├── kenjirou0402.key         # Xserver秘密鍵（パスフレーズ保護）
│   ├── stepjam_github_ed25519   # GitHub秘密鍵（パスフレーズなし）
│   └── ssh-env.md               # この設定情報ファイル
├── deploy/
│   ├── secure-git-workflow.sh   # 統合ワークフロー
│   ├── deploy-production.sh     # 本番デプロイ
│   └── rollback.sh              # 緊急ロールバック
└── stepjam-git                  # クイックアクセスラッパー
```

**🔐 合言葉**: `rootz6002`  
**🎯 統合システム**: セキュリティ保持型Git運用ワークフロー完全稼働中