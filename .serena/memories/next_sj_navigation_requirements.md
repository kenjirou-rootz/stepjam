# NEXT SJ ナビゲーション機能要件

## ユーザー要望
- NEXTメニューにTOKYO/OSAKA/TOHOKUサブメニュー追加
- NEXT SJ投稿編集画面で「ナビメニュー対象エリア」選択機能
- 排他制御: 1エリアにつき1投稿のみ選択可能
- 選択された投稿がナビゲーションリンク先となる

## 新ナビゲーション構成
HOME / NEXT(ドロップダウン) / SPONSORS / ABOUT / NEWS / LIBRARY / CONTACT

## 技術仕様
### 新ACFフィールド
- フィールド名: nx_nav_menu_area
- タイプ: ラジオボタン
- 選択肢: none/tokyo/osaka/tohoku
- 排他制御: 自動切替方式（既存選択を自動解除）

### 実装順序
1. ACFフィールド追加
2. 排他制御ロジック実装
3. ナビゲーション改修
4. 動的リンク生成
5. ABOUTページ作成
6. 検証・テスト

## 既存機能との関係
- nx_area_selection: ページ表示用（維持）
- nx_nav_menu_area: ナビゲーション用（新規）
- 2つのフィールドは独立動作