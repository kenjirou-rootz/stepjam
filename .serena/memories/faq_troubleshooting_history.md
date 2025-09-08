# FAQ機能トラブルシューティング履歴

## 2025-09-03 修正履歴

### 問題1: FAQ投稿の公開ボタンが押せない
**原因**: ACFチェックボックスフィールドの型不一致
- ACF: 整数型（1/0）として保存
- WP_Query: 文字列 '1' で検索していた

**解決**: 
```php
// 修正前
'value' => '1',  // 文字列

// 修正後  
'value' => 1,    // 整数
```

### 問題2: FAQ展開時にテキストが見えない
**原因**: インラインスタイル opacity:0 がCSS優先度で勝っていた
- archive-faq.php にハードコードされた style属性
- CSSの data-state ルールが効かない

**解決**:
```php
// 修正前
style="height: 0; opacity: 0; transform: translateY(-10px);"

// 修正後
// スタイル属性を完全削除、CSSで制御
```

### 問題3: FAQ展開時に質問と回答が重なる
**原因**: 回答コンテナの padding-top 不足

**解決**:
```html
<!-- 修正前 -->
<div class="faq-answer-content px-6 tablet:px-8 pb-6 tablet:pb-8">

<!-- 修正後 -->
<div class="faq-answer-content px-6 tablet:px-8 pt-4 tablet:pt-6 pb-6 tablet:pb-8">
```

### 問題4: 管理画面から単体ページへ遷移して確認しづらい
**要望**: FAQ作成・編集後は `/faq/` アーカイブページで確認したい

**実装**:
1. プレビューボタン: `preview_post_link` フィルターでリダイレクト
2. 管理バー「FAQを表示」: `admin_bar_menu` アクションで置換
3. 更新ボタン: ユーザー指示により実装見送り

## 注意事項
- ACFフィールドの型に注意（特にチェックボックス）
- インラインスタイルは避け、CSSクラスで制御
- スペーシングは Tailwind ユーティリティクラスを活用