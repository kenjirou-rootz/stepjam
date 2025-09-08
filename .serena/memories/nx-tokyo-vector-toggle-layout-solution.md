# NX TOKYO ベクタートグル問題の完全解決記録

## 問題概要
**症状**: Tokyo SVGベクタートグルをOFFにすると、背景画像・動画が表示されない
**根本原因**: CSS Grid構造の崩壊による視覚的問題

## 技術的原因分析

### Grid構造の問題
```css
.nx-area1 {
  display: grid;
  grid-template-rows: 1fr auto;  /* ヘッダー部分 1fr, フッター部分 auto */
}
```

### 問題の発生メカニズム
1. ベクター表示ON時: nx-header(1fr) + nx-footer(auto) = 正常表示
2. ベクター表示OFF時: 空白(1fr) + nx-footer(auto) = 背景メディア認識不可

### HTML構造の問題
**修正前**:
```php
<?php if ($tokyo_vector_show) : ?>
<div class="nx-header">...</div>
<?php endif; ?>
<!-- ベクター非表示時、1frエリアが完全に空になる -->
```

## 完全解決策

### HTML修正
```php
<?php if ($tokyo_vector_show) : ?>
<div class="nx-header">
  <div class="nx-logo">
    <img src="<?php echo esc_url($stepjam_logo_path); ?>" alt="STEPJAM">
  </div>
  <div class="nx-tokyo-visual">
    <img src="<?php echo esc_url($tokyo_vector_path); ?>" alt="TOKYO">
  </div>
</div>
<?php else : ?>
<div class="nx-header-spacer"></div>
<?php endif; ?>
```

### CSS追加
```css
/* ベクター非表示時のスペーサー */
.nx-header-spacer {
  background: transparent;
  display: flex;
  flex: 1;
  min-height: 0;
}
```

## 動作確認済み状況

### Playwright MCP検証結果
- **nxArea1BgType**: "image" ✅
- **nxArea1Style**: `background-image: url(plec-dancer.webp)` ✅
- **headerSpacerPresent**: true ✅
- **headerElementPresent**: false ✅ (ベクター非表示時)

### 期待される表示結果
- **ベクターON**: STEPJAMロゴ + TOKYO SVG + 背景メディア
- **ベクターOFF**: 透明スペーサー + 背景メディア表示

## 予防策・将来の開発注意点

### Grid Layout使用時の注意
1. **構造要素の条件分岐**: 必ず代替要素（スペーサー等）を配置
2. **1fr指定エリア**: 完全に空にしない、透明要素で構造維持
3. **背景メディア表示**: 親要素レベルで設定、子要素の有無に依存しない設計

### WordPressテンプレート設計原則
1. **ACF条件分岐**: 表示・非表示でレイアウト構造を崩さない
2. **CSS Grid/Flexbox**: 動的コンテンツに対応した堅牢な構造設計
3. **背景メディア**: 常に親要素で制御、子要素に依存しない

### 同様問題の特定方法
```javascript
// Playwright MCPでの診断コード
const diagnostics = {
  bgType: element.getAttribute('data-bg-type'),
  bgStyle: element.getAttribute('style'),
  computedBg: window.getComputedStyle(element).backgroundColor,
  hasStructure: !!element.querySelector('.nx-header, .nx-header-spacer')
};
```

## 技術仕様

### ファイル場所
- **対象ファイル**: `/app/public/wp-content/themes/stepjam-theme/single-nx-tokyo.php`
- **修正箇所**: 385-403行目 (HTML構造) + 94-99行目 (CSS)

### ACFフィールド連携
- **制御フィールド**: `nx_tokyo_vector_show` (boolean)
- **背景フィールド**: `nx_background_image`, `nx_background_video`, `nx_background_priority`
- **独立性**: ベクター表示と背景メディア表示は完全に独立

## 今後の類似問題対策

### 開発時チェックリスト
- [ ] CSS Grid使用時、全ての条件分岐でstructure要素確保
- [ ] 背景メディア設定は親要素レベルで制御
- [ ] ACF条件分岐でレイアウト崩れがないか確認
- [ ] Playwright MCPでの動作検証実施

### デバッグ手法
1. **Playwright検証**: data属性・style属性・computed style確認
2. **構造診断**: スペーサー要素の存在確認
3. **Grid診断**: template-rows設定と実際のDOM構造対比

この解決策により、同種の問題は完全に予防可能です。