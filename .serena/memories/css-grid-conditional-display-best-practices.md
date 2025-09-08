# CSS Grid + 条件分岐表示のベストプラクティス

## 一般的な問題パターン
WordPressテンプレートでCSS Gridを使用し、ACFフィールドによる条件分岐表示を行う際の構造崩壊問題

## 危険なパターン例
```php
<!-- ❌ 悪い例: 構造要素が完全に消失する -->
.parent-grid {
  display: grid;
  grid-template-rows: 1fr auto;
}

<?php if ($show_header) : ?>
<div class="header-area">...</div>
<?php endif; ?>
<div class="footer-area">...</div>
```

**問題**: `$show_header`がfalseの時、`1fr`エリアが空になりレイアウト崩壊

## 推奨解決パターン

### パターン1: スペーサー要素配置
```php
<!-- ✅ 良い例: 常に構造要素を保持 -->
<?php if ($show_header) : ?>
<div class="header-area">...</div>
<?php else : ?>
<div class="header-spacer"></div>
<?php endif; ?>
<div class="footer-area">...</div>
```

```css
.header-spacer {
  background: transparent;
  display: flex;
  flex: 1;
  min-height: 0;
}
```

### パターン2: CSS Grid動的切り替え
```php
<div class="parent-grid <?php echo $show_header ? 'has-header' : 'no-header'; ?>">
  <?php if ($show_header) : ?>
  <div class="header-area">...</div>
  <?php endif; ?>
  <div class="footer-area">...</div>
</div>
```

```css
.parent-grid.has-header {
  grid-template-rows: 1fr auto;
}
.parent-grid.no-header {
  grid-template-rows: auto;
}
```

### パターン3: CSS内条件分岐
```css
.header-area {
  display: flex; /* デフォルト表示 */
}
.header-area.hidden {
  display: none;
  /* しかしgrid構造は維持される */
}
.header-area.transparent {
  background: transparent;
  /* 視覚的には非表示だが構造は維持 */
}
```

## 背景メディア設計の鉄則

### 親要素での制御
```css
/* ✅ 正しい: 親要素で背景制御 */
.media-container[data-bg-type="image"] {
  background-size: cover;
  background-position: center;
}
.media-container[data-bg-type="video"] .bg-video {
  position: absolute;
  z-index: -1;
}
```

### 子要素に依存しない設計
```php
<!-- ✅ 背景設定は親レベル -->
<section class="media-container" data-bg-type="<?php echo $bg_type; ?>" style="<?php echo $bg_style; ?>">
  <!-- 子要素の有無に関わらず背景は表示される -->
  <?php if ($show_content) : ?>
  <div class="content">...</div>
  <?php endif; ?>
</section>
```

## WordPressテンプレート開発ガイドライン

### ACF条件分岐での注意点
1. **構造維持**: レイアウト要素は必ず代替要素で補完
2. **親要素制御**: 背景・レイアウトは親要素レベルで管理
3. **独立性保持**: 機能Aと機能Bは相互に影響しない設計

### デバッグ手法
```javascript
// 開発者コンソールでの確認コード
const checkGridStructure = (selector) => {
  const element = document.querySelector(selector);
  return {
    gridRows: window.getComputedStyle(element).gridTemplateRows,
    childCount: element.children.length,
    hasBackground: element.style.backgroundImage || element.dataset.bgType,
    computedBg: window.getComputedStyle(element).backgroundColor
  };
};
```

### テスト項目
- [ ] 全ACF条件の組み合わせでレイアウト確認
- [ ] CSS Grid構造が全パターンで維持されるか
- [ ] 背景メディアが条件に関係なく表示されるか
- [ ] モバイル・デスクトップ両方で問題ないか

## 類似問題の予防チェックリスト

### 開発時
- [ ] CSS Grid使用時は全条件分岐パターンを検証
- [ ] 構造要素の条件分岐には必ず代替要素を用意
- [ ] 背景・メディア要素は親要素レベルで制御
- [ ] ACFフィールドの依存関係を最小限に設計

### レビュー時
- [ ] `grid-template-rows/columns`と実際のDOM構造が一致
- [ ] 条件分岐で要素が完全消失するパターンがないか
- [ ] 背景設定が子要素の表示に依存していないか

この記録により、同種の問題を事前に防止できます。