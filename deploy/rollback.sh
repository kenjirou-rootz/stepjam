#!/bin/bash
# 緊急ロールバックスクリプト

echo "🚨 緊急ロールバック開始..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# 設定
REMOTE_HOST="stepjam-xserver"
REMOTE_PATH="/home/kenjirou0402/rootzexport.info/public_html"
SSH_CONFIG="/Users/hayashikenjirou/Local Sites/stepjam/ssh/config"

# ロールバック方法選択
echo "ロールバック方法を選択："
echo "1) 直前のコミットに戻す（Git）"
echo "2) バックアップから復元（データベース）"
echo "3) 完全復元（Git + データベース）"
read -p "選択 (1-3): " method

case $method in
    1)
        echo "📥 Gitロールバック実行..."
        ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && git reset --hard HEAD~1"
        echo "✅ コードロールバック完了"
        ;;
    2)
        echo "💾 最新バックアップ確認..."
        latest_backup=$(ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && ls -t backups/*.sql | head -1")
        echo "復元するバックアップ: $latest_backup"
        read -p "このバックアップを復元しますか？ (y/N): " confirm
        if [[ $confirm =~ ^[Yy]$ ]]; then
            ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && wp db import $latest_backup"
            echo "✅ データベース復元完了"
        fi
        ;;
    3)
        echo "🔄 完全復元実行..."
        # Gitロールバック
        ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && git reset --hard HEAD~1"
        
        # DB復元
        latest_backup=$(ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && ls -t backups/*.sql | head -1")
        ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && wp db import $latest_backup"
        
        echo "✅ 完全復元完了"
        ;;
    *)
        echo "❌ 無効な選択"
        exit 1
        ;;
esac

# キャッシュクリア
echo "🧹 キャッシュクリア..."
ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && wp cache flush"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ ロールバック完了！"
echo "🌐 サイト確認: https://rootzexport.info"