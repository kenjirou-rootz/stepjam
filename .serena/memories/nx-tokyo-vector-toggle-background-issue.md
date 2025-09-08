# NX TOKYO ベクタートグル問題分析

## 問題状況
ユーザー報告：Tokyo SVGベクタートグルをOFFにすると、背景画像・動画も見えなくなる

## 現在の実装状況
- nx-header全体を`<?php if ($tokyo_vector_show) : ?>`で条件分岐
- 背景メディアはnx-area1レベルで`data-bg-type`と`style`属性で設定
- 背景画像：CSS `background-image`
- 背景動画：`<video class="nx-bg-video">`タグ（z-index: -1）

## 技術的分析
理論的には背景メディアは表示されるはず：
- 背景設定はnx-area1レベル（親要素）
- nx-header非表示でも背景には影響しないはず

## 確認が必要な点
1. 実際の表示状況
2. ユーザーの期待する完成状態
3. レイアウト構造の問題の有無

## 次のアクション
ユーザーに詳細確認後、適切な解決策を実装