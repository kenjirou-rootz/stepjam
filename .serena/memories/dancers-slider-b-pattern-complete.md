# DancersSlider B案実装パターン（完全独立型）

## 実装概要
既存STEPJAMreAppとの完全分離を実現した独立型Slider実装。getComputedStyleエラー問題を回避し、ユーザー要求仕様を100%達成。

## 技術仕様

### ユーザー要求達成状況
✅ **Q1-1**: 左方向自動スクロール - translateX()によるCSS Transform実装  
✅ **Q1-2**: 3秒間隔自動再生 - setInterval(3000ms)による制御  
✅ **Q1-3**: 無限ループ機能 - 最初のスライド複製による無限スクロール実現  
✅ **Q2-1**: 全デバイス対応 - モバイル(375px)・デスクトップ(1920px)検証済み  
✅ **Q2-2**: 手動操作時一時停止 - mouseenter/mouseleave + touchstart/touchend対応  
✅ **Q3-1**: 固定サイズ維持 - 278px × 274.5px + 左余白clamp()  
✅ **Q3-2**: 50vw制約準拠 - Figmaデザイン要件完全対応  
✅ **Q4-1**: 動的ACF対応 - リピーターフィールド構造完全サポート  
✅ **Q4-2**: 少数スライド対応 - 1スライド以下時は自動無効化  

### アーキテクチャ
```javascript
class DancersSlider {
    // 完全独立型設計
    constructor(container) {
        // 1スライド以下の場合は初期化スキップ
        if (this.slideCount <= 1) return;
    }
    
    // CSS Transform基盤のスライド制御
    moveToSlide(index) {
        const translateX = -index * (278 + 10); // 278px + 10px gap
        this.wrapper.style.transform = `translateX(${translateX}px)`;
    }
    
    // 3秒間隔自動再生
    startAutoplay() {
        this.autoplayInterval = setInterval(() => {
            if (!this.isPaused) this.nextSlide();
        }, 3000);
    }
}
```

### ファイル構成
1. **dancers-slider.js** - 完全独立型Slider実装（209行）
2. **dancers-section.php** - CSS Transform対応修正（361-363行）  
3. **enqueue-scripts.php** - 独立スクリプト読み込み（60-67行）

### 実装結果検証（Playwright）
- **初期化成功**: 2つのコンテナで正常動作確認
- **3秒自動スクロール**: translateX値変化を確認済み
- **ホバー一時停止**: isPaused = true動作確認
- **モバイル対応**: 375px環境での動作検証済み
- **エラー回避**: getComputedStyleエラー完全解決

## 保守性・拡張性

### 独立性保証
- STEPJAMreAppクラスとの依存関係完全排除
- Swiperライブラリ依存なし（Pure JavaScript）
- エラー発生時の他システムへの影響遮断

### 設定カスタマイズ
```javascript
// 簡単な設定変更
const slideWidth = 278;      // スライド幅調整
const slideGap = 10;         // ギャップ調整  
const autoplayDelay = 3000;  // 間隔調整
```

### 学習ポイント
1. **完全独立設計** - 既存システムとの分離でエラー回避
2. **段階的無効化** - 1スライド以下時の適切な処理
3. **CSS Transform制御** - SwiperJSより軽量で確実
4. **イベント多重対応** - デスクトップ・モバイル両対応

## 今後の運用指針
- dancers-slider.js単体での保守・更新可能
- 新規Sliderコンテナ自動検出・初期化対応済み
- デバッグ用window.dancerSliders配列でグローバルアクセス可能
- 設定変更時はdancers-slider.js内定数のみ修正