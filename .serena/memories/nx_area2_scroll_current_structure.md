# nx-area2 現在の構造分析結果

## DOM階層構造
```
.nx-tokyo-container (container-type: inline-size)
└── .nx-tokyo-wrapper (グリッドコンテナ)
    ├── .nx-area1 (左側エリア)
    └── .nx-area2 (右側コンテンツエリア)
        ├── .nx-heading (見出しセクション)
        │   └── h1 (イベントタイトル)
        └── .nx-content-blocks (コンテンツコンテナ)
            └── .nx-content-block × n個
```

## 現在のCSS設定

### nx-area2
```css
.nx-area2 {
  background-color: var(--nx-black);
  padding: var(--area2-padding); /* clamp(1.5rem, 4vw, 2.5rem) */
  display: grid;
  grid-template-rows: auto 1fr;
  gap: 0;
  container-type: inline-size;
  container-name: nx-content;
}
```

### nx-heading
```css
.nx-heading {
  padding: clamp(3rem, 8vw, 4.875rem) 0;
  max-height: 404px;
}
```

### nx-content-blocks
```css
.nx-content-blocks {
  display: grid;
  grid-template-columns: 1fr;
  width: 100%;
}
```

## レスポンシブ設定

### 768px以上
```css
@container nx-container (min-width: 768px) {
  .nx-tokyo-wrapper {
    grid-template-columns: minmax(300px, var(--area1-max-width)) 1fr;
    gap: 1px;
  }
}
```

### 767px以下
```css
@media (max-width: 767px) {
  .nx-tokyo-wrapper {
    grid-template-rows: auto 1fr;
  }
  .nx-area1 {
    height: 100vh;
  }
}
```

## 重要な発見事項

1. **nx-area2は既にグリッドレイアウト**
   - `grid-template-rows: auto 1fr`により、.nx-headingが自動高さ、.nx-content-blocksが残り全て

2. **コンテナクエリ対応**
   - nx-contentという名前でコンテナクエリ設定済み

3. **高さ制御なし**
   - 現在nx-area2には明示的な高さ設定がない
   - 768px以上でもビューポート高さ制限なし

4. **モバイル対応**
   - 767px以下では縦並びレイアウト
   - nx-area1が100vh固定高さ