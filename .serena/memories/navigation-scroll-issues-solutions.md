# ナビゲーションスクロール問題の解決パターン

## 問題パターンと解決方法

### 1. ABOUT・LIBRARY スクロール問題 (2025-09-02)
**根本原因**: ナビゲーション閉じる処理とスクロール処理の競合
- `closeNavigation()` → `document.body.style.overflow = ''` 復元
- 同時実行の`window.scrollTo()`がoverflow復元前に実行され無効化

**解決方法**: setTimeout()による100ms遅延
```javascript
scrollToSection(targetId) {
    const targetElement = document.getElementById(targetId);
    if (targetElement) {
        this.closeNavigation();
        setTimeout(() => {
            // overflow復元完了後にスクロール実行
            window.scrollTo({top: offsetPosition, behavior: 'smooth'});
        }, 100);
    }
}
```

### 2. SPONSOR スクロール問題 (2025-09-02)
**根本原因**: ID参照不一致
- front-page.php: `id="sponsor-section"` (単数形)  
- nav-overlay.php: `data-scroll-target="sponsors-section"` (複数形)
- scrollToSection()がdocument.getElementById()で要素を発見できない

**解決方法**: ID参照の統一
```html
<!-- 修正前 -->
data-scroll-target="sponsors-section"

<!-- 修正後 -->
data-scroll-target="sponsor-section"
```

## 共通デバッグ手順

1. **動作確認**: ナビゲーション開 → ボタンクリック → 期待動作確認
2. **要素存在確認**: 対象セクションのIDが正しく設定されているか
3. **ID一致確認**: data-scroll-target と実際のID が一致しているか
4. **タイミング問題確認**: closeNavigation()とscrollTo()の競合がないか
5. **イベントリスナー確認**: bindScrollEvents()で正しく設定されているか

## 修正ファイルと影響範囲

**主要ファイル**:
- `/assets/js/main.js`: scrollToSection()メソッド (タイミング問題修正)
- `/template-parts/nav-overlay.php`: data-scroll-target属性 (ID参照修正)
- `/front-page.php`: セクションID定義 (参照先)

**影響範囲**: デスクトップ・モバイル両対応、全スクロール対象ボタンに適用

## 予防策

1. **命名規則統一**: 単数形・複数形の一貫した使用
2. **ID・参照の整合性確認**: 新規セクション追加時の必須チェック
3. **タイミング制御**: DOM操作とUI動作の適切な遅延設定
4. **包括テスト**: デスクトップ・モバイル両環境での動作確認

## 技術的学習ポイント

- **overflow制御の重要性**: ナビゲーション制御とスクロール処理の競合回避
- **ID参照の正確性**: data-attribute参照時の要素存在確認の重要性
- **Sequential MCP活用**: 構造化分析による根本原因特定の有効性
- **Playwright MCP活用**: UI動作の確実な検証とデバッグ効率化