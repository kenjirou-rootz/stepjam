# STEPJAM スタイリングシステム詳細

## CSS設計思想

### CSS変数 (カスタムプロパティ)
```css
:root {
  /* エリア別カラーパレット */
  --nx-red: #FF0000;      /* OSAKA */
  --nx-blue: #0000FF;     /* TOKYO */
  --nx-green: #00FF6A;    /* TOHOKU */
  --nx-black: #000000;    /* ベース */
  --nx-white: #FFFFFF;    /* テキスト */
  
  /* レスポンシブ設定 */
  --content-max-width: 1920px;
  --area1-max-width: 733px;
  --area2-padding: clamp(1.5rem, 4vw, 2.5rem);
  
  /* タイポグラフィ (clamp使用) */
  --title-size: clamp(2rem, 4vw + 1rem, 2.8125rem);
  --content-title-size: clamp(0.875rem, 1.5vw + 0.5rem, 1rem);
  --content-text-size: clamp(0.75rem, 1vw + 0.5rem, 0.875rem);
}
```

## コンテナクエリ実装

### メインコンテナ
```css
.nx-tokyo-container {
  container-type: inline-size;
  container-name: nx-container;
}

/* 768px以上でグリッドレイアウト */
@container nx-container (min-width: 768px) {
  .nx-tokyo-wrapper {
    grid-template-columns: minmax(300px, var(--area1-max-width)) 1fr;
  }
}
```

### エリア2スクロール制御
```css
@container nx-container (min-width: 750px) {
  .nx-area2 {
    height: 100vh;
    overflow: hidden;
  }
  .nx-content-blocks {
    overflow-y: auto;
    height: 100%;
  }
}
```

## エリア別動的スタイリング

### 背景色システム
```css
/* デフォルト (TOKYO) */
.nx-area1 { background-color: var(--nx-blue); }

/* エリア別上書き */
.nx-area1.area-none   { background-color: transparent; }
.nx-area1.area-tokyo  { background-color: var(--nx-blue); }
.nx-area1.area-osaka  { background-color: var(--nx-red); }
.nx-area1.area-tohoku { background-color: var(--nx-green); }
```

### DAY2セクション背景色制御
```css
/* CSS実装 */
.nx-tokyo-container.area-none .dancers-section__day--day2 {
  background-color: transparent !important;
}
.nx-tokyo-container.area-tokyo .dancers-section__day--day2 {
  background-color: #0000FF !important;
}
.nx-tokyo-container.area-osaka .dancers-section__day--day2 {
  background-color: #FF0000 !important;
}
.nx-tokyo-container.area-tohoku .dancers-section__day--day2 {
  background-color: #00FF6A !important;
}
```

## JavaScript制御システム

### DAY2背景色フォールバック
```javascript
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.nx-tokyo-container');
    const day2Section = document.querySelector('.dancers-section__day--day2');
    
    if (container && day2Section) {
        let bgColor = '#0000FF'; // デフォルト: TOKYO
        
        if (container.classList.contains('area-none')) {
            bgColor = 'transparent';
        } else if (container.classList.contains('area-osaka')) {
            bgColor = '#FF0000';
        } else if (container.classList.contains('area-tohoku')) {
            bgColor = '#00FF6A';
        }
        
        day2Section.style.setProperty('background-color', bgColor, 'important');
    }
});
```

## レスポンシブ戦略

### モバイルファースト設計
```css
/* ベース: モバイル (767px以下) */
.nx-tokyo-wrapper {
  grid-template-rows: auto 1fr;
}

/* デスクトップ拡張 (768px以上) */
@media (min-width: 768px) {
  .nx-tokyo-wrapper {
    grid-template-columns: minmax(300px, 733px) 1fr;
  }
}
```

### 動的ボタン制御
```css
/* DAY1/DAY2ボタン動的レイアウト */
.nx-day-buttons.day1-only,
.nx-day-buttons.day2-only {
  grid-template-columns: 1fr;
}
.nx-day-buttons.both-days {
  grid-template-columns: 1fr 1fr;
}

/* フッターボタンエリア */
.nx-footer-buttons.no-ticket {
  grid-template-columns: 1fr;
}
.nx-footer-buttons.has-ticket {
  grid-template-columns: 1fr 1fr;
}
```