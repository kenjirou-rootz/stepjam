#!/bin/bash
# STEPJAM 統合デプロイスクリプト

# 設定
PROJECT_ROOT="/Users/hayashikenjirou/Local Sites/stepjam"
REMOTE_HOST="stepjam-xserver"
REMOTE_PATH="/home/kenjirou0402/rootzexport.info/public_html"
THEME_PATH="app/public/wp-content/themes/stepjam-theme"
UPLOADS_PATH="app/public/wp-content/uploads"

echo "🚀 STEPJAM デプロイ開始..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# 1. ローカル変更確認
cd "$PROJECT_ROOT"
echo "📋 ローカル変更確認..."
git status

# 2. コミット & プッシュ
echo ""
read -p "📝 コミットメッセージ: " commit_msg
if [ -n "$commit_msg" ]; then
    git add -A
    git commit -m "$commit_msg"
    git push origin main
    echo "✅ GitHub プッシュ完了"
fi

# 3. 本番サーバーバックアップ
echo ""
echo "💾 本番サーバーバックアップ作成..."
ssh $REMOTE_HOST "cd $REMOTE_PATH && wp db export backups/backup-$(date +%Y%m%d-%H%M%S).sql"
echo "✅ バックアップ完了"

# 4. 本番サーバーでGitプル
echo ""
echo "📥 本番サーバーでコード更新..."
ssh $REMOTE_HOST "cd $REMOTE_PATH && git pull origin main"
echo "✅ コード更新完了"

# 5. メディアファイル同期（オプション）
echo ""
read -p "🖼️ メディアファイルを同期しますか？ (y/N): " sync_media
if [[ $sync_media =~ ^[Yy]$ ]]; then
    echo "📤 メディアファイル同期中..."
    rsync -avz --delete \
        -e "ssh -p 10022 -i ~/.ssh/xserver_stepjam.key" \
        "$PROJECT_ROOT/$UPLOADS_PATH/" \
        "kenjirou0402@sv3020.xserver.jp:$REMOTE_PATH/wp-content/uploads/"
    echo "✅ メディア同期完了"
fi

# 6. キャッシュクリア & 最適化
echo ""
echo "🧹 キャッシュクリア & 最適化..."
ssh $REMOTE_HOST "cd $REMOTE_PATH && wp cache flush && wp rewrite flush"
echo "✅ 最適化完了"

# 7. 動作確認
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ デプロイ完了！"
echo "🌐 サイト確認: https://rootzexport.info"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"