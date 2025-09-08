# 本番サーバーGit設定手順

## 前提条件
- SSH接続設定済み
- GitHub リポジトリ作成済み
- デプロイキー生成済み

## 設定手順

### 1. サーバーにSSH接続
```bash
ssh stepjam-xserver
cd /home/kenjirou0402/rootzexport.info/public_html
```

### 2. 既存ファイルバックアップ
```bash
# 重要ファイルのバックアップ
cp wp-config.php wp-config.php.backup
cp .htaccess .htaccess.backup
```

### 3. Gitリポジトリ初期化
```bash
# 初期化
git init
git remote add origin git@github.com:kenjirou-rootz/stepjam.git

# .gitignore作成（本番用）
cat > .gitignore << 'EOF'
wp-config.php
.htaccess
wp-content/uploads/
wp-content/cache/
wp-content/backup*/
*.log
*.sql
EOF
```

### 4. デプロイキー設定
```bash
# SSHキー生成（サーバー上で）
ssh-keygen -t ed25519 -C "deploy@rootzexport.info" -f ~/.ssh/deploy_key

# 公開鍵表示（GitHubに登録）
cat ~/.ssh/deploy_key.pub
```

### 5. SSH設定
```bash
# SSH設定追加
cat >> ~/.ssh/config << 'EOF'
Host github.com
    HostName github.com
    User git
    IdentityFile ~/.ssh/deploy_key
    StrictHostKeyChecking no
EOF

# 権限設定
chmod 600 ~/.ssh/config
chmod 600 ~/.ssh/deploy_key
```

### 6. 初回プル
```bash
# リモートから取得（既存ファイルは上書きされない）
git fetch origin main
git checkout -b main origin/main

# コンフリクトがある場合は手動解決
git status
```

## トラブルシューティング

### 権限エラーの場合
```bash
# Git設定の所有者確認
ls -la .git/
# 必要に応じて権限修正
chmod -R 755 .git/
```

### プルで問題が発生した場合
```bash
# 強制的にリモートの状態に合わせる（注意！）
git fetch origin main
git reset --hard origin/main
```