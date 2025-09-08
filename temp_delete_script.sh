#!/bin/bash
# StageWise完全削除スクリプト
echo "=== StageWise空ファイル完全削除開始 ==="

# 削除対象ファイル
FILES=(
    "stagewise.json"
    "mcp-stagewise-server-validation.js"
    "send-test-data.js"
)

cd "/Users/hayashikenjirou/Local Sites/stepjam"

# 削除前確認
echo "削除前確認:"
for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "✓ $file - 存在 (削除対象)"
    else
        echo "✗ $file - 不存在"
    fi
done

echo ""
echo "=== ファイル削除実行 ==="

# 削除実行
for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        rm "$file"
        if [ ! -f "$file" ]; then
            echo "✅ $file - 削除完了"
        else
            echo "❌ $file - 削除失敗"
        fi
    else
        echo "⚠️  $file - 削除対象なし（既に不存在）"
    fi
done

echo ""
echo "=== 削除後確認 ==="
for file in "${FILES[@]}"; do
    if [ ! -f "$file" ]; then
        echo "✅ $file - 完全削除確認"
    else
        echo "❌ $file - まだ存在"
    fi
done

echo ""
echo "=== StageWise完全削除完了 ==="