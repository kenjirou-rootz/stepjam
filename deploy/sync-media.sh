#!/bin/bash
# メディアファイル同期専用スクリプト

# 設定
LOCAL_UPLOADS="/Users/hayashikenjirou/Local Sites/stepjam/app/public/wp-content/uploads"
REMOTE_HOST="stepjam-xserver"
REMOTE_UPLOADS="/home/kenjirou0402/rootzexport.info/public_html/wp-content/uploads"
EXCLUDE_FILE="$(dirname "$0")/rsync-exclude.txt"
SSH_CONFIG="/Users/hayashikenjirou/Local Sites/stepjam/ssh/config"

echo "🖼️ メディアファイル同期"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# 同期方向選択
echo "同期方向を選択してください："
echo "1) ローカル → 本番（アップロード）"
echo "2) 本番 → ローカル（ダウンロード）"
echo "3) 双方向同期（最新ファイル優先）"
read -p "選択 (1-3): " direction

case $direction in
    1)
        echo "📤 ローカル → 本番 同期開始..."
        rsync -avz --progress \
            --exclude-from="$EXCLUDE_FILE" \
            -e "ssh -F $SSH_CONFIG" \
            "$LOCAL_UPLOADS/" \
            "$REMOTE_HOST:$REMOTE_UPLOADS/"
        ;;
    2)
        echo "📥 本番 → ローカル 同期開始..."
        rsync -avz --progress \
            --exclude-from="$EXCLUDE_FILE" \
            -e "ssh -F $SSH_CONFIG" \
            "$REMOTE_HOST:$REMOTE_UPLOADS/" \
            "$LOCAL_UPLOADS/"
        ;;
    3)
        echo "🔄 双方向同期開始..."
        # 新しいファイルを双方向で同期
        rsync -avzu --progress \
            --exclude-from="$EXCLUDE_FILE" \
            -e "ssh -F $SSH_CONFIG" \
            "$LOCAL_UPLOADS/" \
            "$REMOTE_HOST:$REMOTE_UPLOADS/"
        
        rsync -avzu --progress \
            --exclude-from="$EXCLUDE_FILE" \
            -e "ssh -F $SSH_CONFIG" \
            "$REMOTE_HOST:$REMOTE_UPLOADS/" \
            "$LOCAL_UPLOADS/"
        ;;
    *)
        echo "❌ 無効な選択"
        exit 1
        ;;
esac

echo "✅ 同期完了！"