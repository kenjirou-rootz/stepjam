# 🚨 重要発見: NX TOKYO背景メディア問題の根本原因

## 発見された問題
コード分析により問題を特定しました：

**378行目のHTML出力**:
```html
<section class="nx-area1" data-bg-type="<?php echo esc_attr($display_type); ?>" <?php if ($display_type === 'image') echo 'style="' . esc_attr($bg_style) . '"'; ?>>
```

**問題の核心**:
- 背景画像は`style`属性でインライン指定される
- しかし`tokyo_vector_show`が`false`の時、CSSの`.nx-area1[data-bg-type="image"]`セレクタは正常
- **問題なし**: 背景メディア設定は理論的に動作するはず

## 想定される実際の原因
1. ACFフィールド値が正しく取得されていない
2. 画像URLが無効
3. CSSの優先順位問題
4. ベクター非表示時の視覚的問題（空白に見える）

## 検証が必要
Playwright MCPでの実際の表示確認が必須