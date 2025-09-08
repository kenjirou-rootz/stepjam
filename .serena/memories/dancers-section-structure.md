# Dancers Section 構造とACF連携

## template-parts/dancers-section.php 構造分析

### ACF フィールド階層
```
nx_dancers_section_show (boolean) - セクション全体表示制御
├── nx_day1_show (boolean) - DAY1表示制御
├── nx_day2_show (boolean) - DAY2表示制御
├── nx_day1_sliders (リピーター) - DAY1スライダー群
│   ├── genre_name (text) - ジャンル名
│   └── dancer_slides (リピーター) - ダンサーカード群
│       ├── dancer_name (text) - ダンサー名
│       ├── dancer_bg_image (image) - 背景画像
│       └── dancer_link (url) - リンクURL
└── nx_day2_sliders (リピーター) - DAY2スライダー群
    ├── genre_name (text) - ジャンル名
    └── dancer_slides (リピーター) - ダンサーカード群
        ├── dancer_name (text) - ダンサー名
        ├── dancer_bg_image (image) - 背景画像
        └── dancer_link (url) - リンクURL
```

### 表示制御ロジック
```php
// 階層的表示判定
if (!$dancers_section_show) return; // セクション全体非表示
if (!$day1_show && !$day2_show) return; // 両方非表示

// レイアウトクラス動的生成
$layout_class = '';
if ($day1_show && $day2_show) $layout_class = 'dancers-section--both';
elseif ($day1_show && !$day2_show) $layout_class = 'dancers-section--day1-only';
elseif (!$day1_show && $day2_show) $layout_class = 'dancers-section--day2-only';
```

### HTML構造
```html
<section class="dancers-section {layout_class}">
  <div class="dancers-section__container">
    <!-- DAY1 -->
    <div class="dancers-section__day dancers-section__day--day1">
      <div class="dancers-section__title-container">
        <div class="dancers-section__title-vector">
          <img src="{day1-title.svg}" alt="DAY1">
        </div>
      </div>
      <div class="dancers-section__dancers-container">
        <!-- ジャンル別スライダー -->
        <div class="dancers-section__slider-container">
          <div class="dancers-section__genre-title">
            <h3>{genre_name}</h3>
          </div>
          <div class="dancers-section__swiper">
            <div class="swiper-wrapper">
              <!-- ダンサーカード -->
              <div class="swiper-slide">...</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- DAY2（同構造） -->
  </div>
</section>
```

## CSS設計：50vw仕様と固定サイズ実装

### レイアウト戦略
```css
/* 50vw仕様：画面を左右に分割 */
.dancers-section--both .dancers-section__day {
    width: 50vw;
    max-width: 50vw;
    flex: 0 0 50vw;
    overflow: hidden; /* はみ出し防止 */
}

/* 片方のみ表示時：全幅使用 */
.dancers-section--day1-only .dancers-section__day,
.dancers-section--day2-only .dancers-section__day {
    width: 100%;
    max-width: 100%;
    flex: 0 0 100%;
}
```

### Figma準拠：固定サイズスライド
```css
/* 全デバイス共通の固定サイズ */
.dancers-section__slide {
    width: 278px !important;
    height: 274.5px !important;
    flex: 0 0 278px;
    /* レスポンシブサイズ設定は削除済み */
}

/* 固定10pxギャップ */
.dancers-section__swiper-wrapper {
    gap: 10px; /* Figma通りの固定ギャップ */
}
```

### Container Query活用
```css
.dancers-section {
    container-type: inline-size;
}

@container (max-width: 767px) {
    .dancers-section__container {
        flex-direction: column; /* モバイル：縦積み */
    }
    
    .dancers-section__day {
        width: 100% !important; /* モバイル：全幅 */
    }
}
```

### デザインシステム統一
```css
/* カラーパレット */
.dancers-section__day--day1 { background-color: transparent; }
.dancers-section__day--day2 { background-color: #0000ff; }
.dancers-section__slide-bg { background-color: #ff0000; } /* フォールバック */

/* タイポグラフィ */
.dancers-section__genre-text {
    font-family: 'Noto Sans JP', sans-serif;
    font-weight: 900;
    font-size: clamp(1.25rem, 2.5vw, 1.25rem);
    color: #ffffff;
}
```

## JavaScript連携（Swiper統合）

### クラス構造
```
STEPJAMreApp (main.js)
└── Swiper制御
    ├── dancers-section__swiper (セレクタ)
    ├── swiper-wrapper (Swiper必須クラス)  
    └── swiper-slide (Swiper必須クラス)
```

### パフォーマンス最適化
- CLS対策：aspect-ratio設定
- アニメーション軽減：prefers-reduced-motion対応
- will-change: opacity（JavaScript制御用）

## 保守・拡張ポイント

### 新規ジャンル追加
1. WordPress管理画面でnx_day1_slidersまたはnx_day2_slidersに追加
2. genre_nameとdancer_slidesを設定
3. 自動的にSwiper制御対象となる

### レスポンシブ調整
- Container Queryベース制御のため、コンテナサイズに応じた調整が可能
- 50vw制約下でのタイトルサイズ調整は`max-width: calc(50vw - 4rem)`で制御

### アクセシビリティ配慮
- セマンティックHTML（section, h3使用）
- loading="lazy"による画像最適化  
- focus-visible対応
- aria-label設定済み