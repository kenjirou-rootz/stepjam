#!/bin/bash
# GitHub SSH設定スクリプト

echo "🔑 GitHub SSH設定開始..."

# 1. SSH設定確認
if [ ! -f ~/.ssh/id_ed25519 ]; then
    echo "❌ SSHキーが見つかりません。"
    echo "以下のコマンドで生成してください："
    echo "ssh-keygen -t ed25519 -C \"k_hayashi@rootz-adl.com\""
    exit 1
fi

# 2. SSH設定追加
if ! grep -q "github.com" ~/.ssh/config; then
    echo "📝 GitHub SSH設定を追加..."
    cat >> ~/.ssh/config << 'EOF'

Host github.com
    HostName github.com
    User git
    IdentityFile ~/.ssh/id_ed25519
    StrictHostKeyChecking no
EOF
    echo "✅ SSH設定追加完了"
fi

# 3. 接続テスト
echo "🔍 GitHub接続テスト..."
ssh -T git@github.com

echo "✅ 設定完了！"