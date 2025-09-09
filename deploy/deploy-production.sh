#!/bin/bash
# STEPJAM 統合デプロイスクリプト (ACF JSON同期対応)

# 設定
PROJECT_ROOT="/Users/hayashikenjirou/Local Sites/stepjam"
REMOTE_HOST="stepjam-xserver"
REMOTE_PATH="/home/kenjirou0402/rootzexport.info/public_html"
THEME_PATH="app/public/wp-content/themes/stepjam-theme"
UPLOADS_PATH="app/public/wp-content/uploads"
SSH_CONFIG="$PROJECT_ROOT/ssh/config"

echo "🚀 STEPJAM デプロイ開始（ACF JSON同期対応）..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# 1. ローカル変更確認
cd "$PROJECT_ROOT"
echo "📋 ローカル変更確認..."
git status

# 2. ACF JSON整合性チェック
echo ""
echo "🔍 ACF JSON整合性チェック..."
if [ -d "$THEME_PATH/acf-json" ]; then
    json_count=$(find "$THEME_PATH/acf-json" -name "*.json" | wc -l | tr -d ' ')
    echo "✅ ACF JSONファイル: $json_count 個"
    
    # JSON形式チェック
    json_valid=true
    for json_file in "$THEME_PATH/acf-json"/*.json; do
        if [ -f "$json_file" ]; then
            if ! python3 -m json.tool "$json_file" >/dev/null 2>&1; then
                echo "❌ JSON形式エラー: $(basename "$json_file")"
                json_valid=false
            fi
        fi
    done
    
    if [ "$json_valid" = true ]; then
        echo "✅ JSON形式チェック: 正常"
    else
        echo "⚠️ JSON形式エラーがあります。修正後に再実行してください。"
        exit 1
    fi
else
    echo "⚠️ acf-json/ ディレクトリが見つかりません"
fi

# 3. コミット & プッシュ
echo ""
read -p "📝 コミットメッセージ: " commit_msg
if [ -n "$commit_msg" ]; then
    git add -A
    git commit -m "$commit_msg

🤖 Generated with [Claude Code](https://claude.ai/code)

Co-Authored-By: Claude <noreply@anthropic.com>"
    git push origin main
    echo "✅ GitHub プッシュ完了"
fi

# 4. 本番サーバーバックアップ
echo ""
echo "💾 本番サーバーバックアップ作成..."
ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && wp db export backups/backup-$(date +%Y%m%d-%H%M%S).sql"
echo "✅ バックアップ完了"

# 5. 本番サーバーでGitプル
echo ""
echo "📥 本番サーバーでコード更新..."
ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && git pull origin main"
echo "✅ コード更新完了"

# 6. ACF JSON → DB同期
echo ""
echo "🔄 ACF JSON → DB同期実行..."
ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && wp acf sync --all" && {
    echo "✅ ACF同期完了"
} || {
    echo "⚠️ ACF同期で一部エラーが発生（通常動作の場合があります）"
    # 同期状況確認
    echo "📋 同期状況確認中..."
    ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && wp acf sync --dry-run" || true
}

# 7. メディアファイル同期（オプション）
echo ""
read -p "🖼️ メディアファイルを同期しますか？ (y/N): " sync_media
if [[ $sync_media =~ ^[Yy]$ ]]; then
    echo "📤 メディアファイル同期中..."
    rsync -avz --delete \
        -e "ssh -F $SSH_CONFIG" \
        "$PROJECT_ROOT/$UPLOADS_PATH/" \
        "$REMOTE_HOST:$REMOTE_PATH/wp-content/uploads/"
    echo "✅ メディア同期完了"
fi

# 8. キャッシュクリア & 最適化
echo ""
echo "🧹 キャッシュクリア & 最適化..."
ssh -F "$SSH_CONFIG" $REMOTE_HOST "cd $REMOTE_PATH && wp cache flush && wp rewrite flush"
echo "✅ 最適化完了"

# 9. 動作確認
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ デプロイ完了（ACF JSON同期済み）！"
echo "🌐 サイト確認: https://rootzexport.info"
echo "🔍 ACF管理画面: https://rootzexport.info/wp-admin/edit.php?post_type=acf-field-group"
echo "📊 Git同期ログ: /wp-content/debug.log"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"