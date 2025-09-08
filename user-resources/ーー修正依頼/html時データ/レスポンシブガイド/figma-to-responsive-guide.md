# 📱 Figma → レスポンシブ対応ガイドライン

> **STEPJAMプロジェクト実績ベース**  
> Figmaから取得された固定幅JSONスタイル情報をレスポンシブ対応に落とし込むための実践的ガイドライン

---

## 🏗️ **レイアウト構造設計**

### ✅ **CSS Grid ベース統一**

**原則**: Absolute Position → CSS Grid 構造に統一

```css
/* ✅ 推奨: CSS Grid */
.section-container {
    display: grid;
    grid-template-columns: 60% 30% 10%;  /* パーセンテージ指定 */
    grid-template-rows: 7fr 3fr;         /* 比率指定 */
    grid-template-areas:
        "area1 area2 area3"
        "area4 area2 area3";
}

/* ❌ 非推奨: Absolute Position */
.legacy-container {
    position: absolute;
    top: 19.1%;
    left: 0;
    width: 38.4%;
}
```

**適用事例**:
- WHSJセクション: `60% 30% 10%` + `7fr 3fr`
- Sponsorセクション: `1fr` + `62% 38%` → `45% 55%`

---

## 📐 **高さ・幅の使い分け基準**

### ✅ **基本原則: 高さ固定・幅レスポンシブ**

| 要素 | 高さ | 幅 | 実装方法 |
|------|------|-----|----------|
| **親コンテナ** | 固定（rem） | レスポンシブ（%） | `height: 67.5rem; width: 100%;` |
| **内包フレーム** | 固定（rem/％） | レスポンシブ（%） | `height: 100%; width: clamp(...);` |
| **ベクター・画像** | aspect-ratio | width基準 | `width: 60%; aspect-ratio: 564/255;` |
| **テキスト** | auto | clamp() | `width: clamp(...); height: auto;` |

### ✅ **高さ制約の柔軟対応（ユーザー指示時のみ）**

**原則**: 高さ固定を維持。ユーザーが明確に排除を指示した場合のみ柔軟対応を適用。

| 対応レベル | 適用条件 | 実装方法 | 注意事項 |
|-----------|----------|----------|----------|
| **固定維持** | デフォルト | `height: 67.5rem;` | 推奨・基本方針 |
| **最小保証** | ユーザー指示時 | `min-height: 67.5rem;` | 内容増加時の拡張許可 |
| **完全柔軟** | 明確な指示時 | `height: auto;` | レイアウト影響要確認 |

**ユーザー指示確認例**:
```markdown
🔍 高さ制約変更の確認:
「現在の固定高さ（67.5rem）を維持しますか？
 それとも内容に応じた柔軟な高さに変更しますか？」

✅ 固定維持 → height: 67.5rem; (推奨)
⚠️ 柔軟対応 → min-height: 67.5rem; (要影響確認)
```

### ✅ **px → rem 変換基準**

```css
/* 変換基準: 1rem = 16px */
1080px ÷ 16 = 67.5rem   /* セクション高さ */
666px ÷ 16 = 41.625rem  /* コンテンツ高さ */
414px ÷ 16 = 25.875rem  /* サブエリア高さ */
```

**変換例**:
```css
/* Figma: 1920px × 1080px セクション */
.section-container {
    width: 100%;           /* レスポンシブ */
    height: 67.5rem;       /* 固定（1080px ÷ 16） */
}

/* Figma: 1186px × 666px コンテンツ */
.content-area {
    width: 85%;            /* レスポンシブ（1186px ÷ 1920px ≈ 62% → 調整85%） */
    height: 41.625rem;     /* 固定（666px ÷ 16） */
}
```

---

## 📏 **幅指定ルール**

### ✅ **動的幅指定の優先順位**

| 優先度 | 手法 | 用途 | 実装例 |
|--------|------|------|--------|
| **1** | `clamp()` | 高精度レスポンシブ | `clamp(55%, calc(65% + 1vw), 85%)` |
| **2** | `%ベース` | グリッド・基本レイアウト | `w-[85%]`, `45% 55%` |
| **3** | `vwベース` | ビューポート連動 | `1vw`, `calc(65% + 1vw)` |
| **4** | `固定値` | 最小限の使用 | `height: 67.5rem` |

### ✅ **スライドコンテンツ幅設定**

```css
/* Desktop */
.desktop-slide { width: 85%; }

/* Mobile */  
.mobile-slide { width: 120%; }

/* 高精度調整 */
.content-image { width: clamp(55%, calc(65% + 1vw), 85%); }
```

**実績値**:
- Desktop スライド: `w-[85%]`
- Mobile スライド: `w-[120%]`
- コンテンツ画像: `w-[clamp(55%,calc(65% + 1vw),85%)]`

### ✅ **Figma固定幅 → レスポンシブ変換手順**

#### **Step 1: デバイス別基準での%計算**

```css
/* Desktop基準（1920px） */
Figma幅 ÷ 1920px × 100 = Desktop%
例: 738px ÷ 1920px × 100 = 38.4%

/* Mobile基準（768px） */
Figma幅 ÷ 768px × 100 = Mobile%  
例: 294px ÷ 768px × 100 = 38.3%
```

#### **Step 2: コンテンツ種別によるclamp()設定**

| コンテンツ種別 | min% | base% | max% | 実装例 |
|----------------|------|-------|------|--------|
| **メインコンテンツ** | 60% | 85% | 95% | `clamp(60%, 85%, 95%)` |
| **サブコンテンツ** | 30% | 45% | 60% | `clamp(30%, 45%, 60%)` |
| **アイコン・ロゴ** | 15% | 20% | 30% | `clamp(15%, 20%, 30%)` |
| **テキストエリア** | 40% | 55% | 75% | `clamp(40%, 55%, 75%)` |

#### **Step 3: 最小幅320px対応確認**

```css
/* 320px時の実際のサイズ確認 */
clamp(60%, 85%, 95%) at 320px
= 60% × 320px = 192px  /* 十分な表示サイズを確保 */

/* 見切れ防止の調整例 */
.critical-content {
    width: clamp(80%, 85%, 90%);  /* min値を上げて見切れ防止 */
    min-width: 200px;             /* 絶対最小サイズ保証 */
}
```

#### **Step 4: calc()による微調整**

```css
/* ビューポート幅に応じた微調整 */
.adaptive-content {
    width: clamp(55%, calc(65% + 1vw), 85%);
    /* 320px時: calc(65% + 3.2px) ≈ 65.1% */
    /* 1920px時: calc(65% + 19.2px) ≈ 66% */
}
```

---

## 📱 **グリッド比率の調整ルール**

### ✅ **ブレークポイント別比率設定**

#### **固定比率 vs 柔軟比率の使い分け**

| 比率タイプ | 適用条件 | 実装方法 | 用途 |
|-----------|----------|----------|------|
| **固定比率** | デザイン厳密制御時 | `grid-template-columns: 45% 55%` | 厳密な比率維持 |
| **柔軟比率** | 内容自動調整時 | `grid-template-columns: auto 1fr` | 内容に応じた調整 |
| **比例比率** | 要素間バランス重視 | `grid-template-columns: 2fr 3fr` | 相対的サイズ維持 |

#### **実装パターン**

```css
/* パターン1: 固定比率（デフォルト推奨） */
.content-container {
    grid-template-columns: 45% 55%;
}

/* パターン2: 柔軟比率（内容可変時） */
.flexible-container {
    grid-template-columns: auto 1fr;  /* 左：内容サイズ、右：残り領域 */
}

/* パターン3: 比例比率（バランス重視） */
.proportional-container {
    grid-template-columns: 2fr 3fr;   /* 2:3の比率維持 */
}

/* タブレット以上 */
@media (min-width: 768px) {
    .content-container {
        grid-template-columns: 45% 55% !important;
    }
}

/* スマホ（縦並び） */
@media (max-width: 767px) {
    .content-container {
        grid-template-columns: 1fr;
        grid-template-rows: auto auto;
    }
}
```

#### **選択指針**

```markdown
✅ 固定比率を選ぶ場合:
- デザイン通りの厳密な比率が必要
- 全体の高さが統一されている
- 内容がはみ出る可能性が低い

✅ 柔軟比率（auto 1fr）を選ぶ場合:
- 内容量が動的に変化する
- テキストや画像サイズが可変
- ユーザーが柔軟対応を指示
```

**調整実績**:
- `30% 70%` → `45% 55%` (より自然な比率)
- 768px未満: 縦並び配置

---

## 🖼️ **画像・動画リサイズルール**

### ✅ **アセット取得・保存ルール**

**ベクター・画像が配置されている場合の必須対応**:

```bash
# 1. Figma MCPでベクター・画像を検出した場合
# 2. 対象データと同じパスのassetsフォルダに保存
# 3. 対象エリア名でフォルダ作成（例：whsj, sponsor等）
# 4. 構築時にローカルアセットを使用

mkdir -p assets/whsj/          # エリア別フォルダ作成
figma-download vector.svg      # ベクター取得
figma-download image.png       # 画像取得
mv *.svg *.png assets/whsj/    # 指定フォルダに保存
```

**実装時の参照方法**:
```html
<!-- ✅ 推奨: ローカルアセット使用 -->
<img src="assets/whsj/sponsor-logo.svg" alt="スポンサーロゴ">
<img src="assets/sponsor/content-image.png" alt="コンテンツ画像">

<!-- ❌ 非推奨: 外部URL・不安定なリンク -->
<img src="https://figma.com/temp/..." alt="一時的リンク">
```

**フォルダ構成例**:
```
project/
├── assets/
│   ├── whsj/           # WHSJセクション用
│   │   ├── logo.svg
│   │   └── bg-image.png
│   ├── sponsor/        # Sponsorセクション用
│   │   ├── sponsor-logo.svg
│   │   └── content-img.jpg
│   └── common/         # 共通アセット
│       ├── icons/
│       └── backgrounds/
└── index.html
```

### ✅ **object-fit 適用基準**

| コンテンツタイプ | object-fit | 用途 |
|------------------|------------|------|
| **背景画像** | `object-cover` | 領域を完全に埋める |
| **コンテンツ画像** | `object-contain` | アスペクト比保持 |
| **アイコン・ロゴ** | `object-contain` | 完全表示優先 |

```css
/* 動画スライド */
.video-slide {
    width: 85%;
    height: 100%;
    object-fit: cover;
    border-radius: 51px;
}

/* コンテンツ画像 */
.content-image {
    width: clamp(55%, calc(65% + 1vw), 85%);
    height: clamp(40%, 46.7%, 55%);
    object-fit: contain;
}
```

### ✅ **ベクター・画像のaspect-ratio基準設計**

**基本原則**: width基準 + aspect-ratio で高さ自動調整

```css
/* Step 1: Figmaサイズからaspect-ratio計算 */
Figma: width: 564px, height: 255px
aspect-ratio: 564/255 = 2.212 (または 564/255 と記述)

/* Step 2: 親ボックスに対する相対width指定 */
.vector-image {
    width: 60%;                /* 親ボックスの60% */
    aspect-ratio: 564/255;     /* Figma比率維持 */
    height: auto;              /* 自動調整 */
}

/* Step 3: レスポンシブwidth調整 */
.responsive-vector {
    width: clamp(40%, 60%, 80%);  /* コンテンツ種別による調整 */
    aspect-ratio: 564/255;
    object-fit: contain;          /* 画像の場合 */
}
```

#### **コンテンツ種別別の実装パターン**

```css
/* ロゴ・アイコン（完全表示優先） */
.logo-element {
    width: clamp(15%, 20%, 30%);
    aspect-ratio: 564/255;
    object-fit: contain;
}

/* メイン画像（バランス重視） */
.main-image {
    width: clamp(60%, 85%, 95%);
    aspect-ratio: 1186/666;
    object-fit: cover;
}

/* SVGベクター（精密表示） */
.svg-vector {
    width: clamp(50%, 61.5%, 75%);
    aspect-ratio: 1180.38 / 199.66;
    max-width: 73.774rem;  /* 最大サイズ制限 */
}
```

#### **320px最小幅での検証例**

```css
/* 320px時のサイズ確認 */
.logo-element { width: clamp(15%, 20%, 30%); }
320px × 15% = 48px    /* 最小でも48px確保 */
320px × 20% = 64px    /* 基準サイズ */

/* aspect-ratio: 564/255 = 2.212 の場合 */
width: 64px → height: 64px ÷ 2.212 = 29px  /* 適切な表示サイズ */
```

---

## 🏷️ **data属性整理ルール**

### ✅ **保持・削除基準**

| 属性 | 判定 | 理由 |
|------|------|------|
| `data-acf` | ✅ **保持** | WordPress ACF連携に必要 |
| `data-node` | ❌ **削除** | Figma開発時のみ使用 |
| `data-constraints` | ❌ **削除** | Figmaレイアウト制約情報 |

```html
<!-- ✅ 整理後 -->
<div class="sponsor-content-left" data-acf="spon-cont-tl-desktop">
    <div class="content-image" data-acf="spon-cont-img-desktop">
        <img src="" alt="Sponsor Content">
    </div>
</div>

<!-- ❌ 整理前 -->
<div class="sponsor-content-left"
     data-node="156:727"
     data-constraints="vertical:TOP,horizontal:LEFT"
     data-acf="spon-cont-tl-desktop">
```

---

## 🔧 **ACF（Advanced Custom Fields）対応ルール**

### ✅ **共通事項：acfレイヤーの基本対応**

**WordPress実装に向けた必須確認事項**:

```markdown
対象Figmaデータ内の「acf」という名前がついたレイヤーについて：

✅ 基本対応手順：
1. acfレイヤーを特定・リストアップ
2. 各レイヤーのACFフィールドタイプをユーザーに確認
3. 確認内容を整理・記録
4. 後工程での変換作業に備える
```

**確認必須項目**:
- **ACFフィールドタイプ**: テキスト／画像／ボタン／リピーター／選択肢など
- **入力形式**: 単一行／複数行／リッチテキスト／URL／ファイルなど
- **必須／任意**: フィールドの入力必須性
- **デフォルト値**: 初期設定値の有無

```html
<!-- 実装例: ACF対応マークアップ -->
<div class="content-area" data-acf="main-content-text">
    <!-- ACFフィールドタイプ: テキストエリア（複数行） -->
    <!-- 必須: Yes, デフォルト値: なし -->
    <?php the_field('main_content_text'); ?>
</div>
```

### ✅ **ボタン関連：acf + tag or bt を含むレイヤー**

**対象レイヤーの特定**:
```bash
# 検索パターン例
- レイヤー名: "acf-button-tag"
- レイヤー名: "acf-cta-bt"
- レイヤー名: "acf-link-tag"
```

**必須確認項目**:

| 確認事項 | 質問内容 | 実装への影響 |
|----------|----------|--------------|
| **リンク先タイプ** | 外部URL／内部ページ／アンカーリンク | `target="_blank"` 設定 |
| **ボタンスタイル** | プライマリ／セカンダリ／テキストリンク | CSSクラス指定 |
| **動作・挙動** | ページ遷移／モーダル表示／スムーススクロール | JavaScript実装 |
| **トラッキング** | GA4イベント／コンバージョン測定 | データ属性追加 |

**実装テンプレート**:
```html
<!-- ボタンACF実装例 -->
<div class="button-container" data-acf="cta-button-primary">
    <a href="<?php the_field('button_url'); ?>" 
       class="btn btn-primary"
       <?php if(get_field('button_target')): ?>target="_blank"<?php endif; ?>
       data-ga-event="<?php the_field('button_tracking'); ?>">
        <?php the_field('button_text'); ?>
    </a>
</div>
```

**ユーザー確認テンプレート**:
```markdown
🔘 ボタンACFレイヤー「[レイヤー名]」について確認させてください：

1. リンク先タイプ: 外部URL / 内部ページ / アンカーリンク
2. ボタンデザイン: プライマリ / セカンダリ / テキストリンク
3. 挙動: 通常遷移 / 別タブ開く / スムーススクロール
4. トラッキング: GA4イベント名（ある場合）

ご回答いただいた内容を元に、適切なACFフィールド設定を行います。
```

### ✅ **投稿関連：acf + post or cust を含むレイヤー**

**対象レイヤーの特定**:
```bash
# 検索パターン例
- レイヤー名: "acf-post-list"
- レイヤー名: "acf-cust-content"
- レイヤー名: "acf-custom-post"
```

**必須確認項目**:

| 確認分類 | 詳細確認内容 | 実装影響 |
|----------|--------------|----------|
| **投稿タイプ** | 標準投稿／固定ページ／カスタム投稿タイプ | WP Query設定 |
| **表示件数** | 何件表示／ページング有無 | Loop処理 |
| **フィールド構造** | 表示項目（タイトル／日付／画像／抜粋など） | ACFフィールド設計 |
| **並び順** | 日付順／カスタム順／ランダム | order/orderby設定 |
| **繰り返し仕様** | 単発表示／リスト表示／グリッド表示 | Repeater Field使用 |

**実装テンプレート**:
```php
<!-- カスタム投稿ACF実装例 -->
<div class="custom-posts" data-acf="custom-post-list">
    <?php 
    $posts = get_field('custom_post_selection');
    if($posts): foreach($posts as $post): setup_postdata($post); ?>
        <article class="post-item">
            <h3><?php the_title(); ?></h3>
            <div class="post-meta"><?php the_time('Y.m.d'); ?></div>
            <div class="post-thumbnail"><?php the_post_thumbnail(); ?></div>
            <div class="post-excerpt"><?php the_excerpt(); ?></div>
        </article>
    <?php endforeach; wp_reset_postdata(); endif; ?>
</div>
```

**ユーザー確認テンプレート**:
```markdown
🧾 投稿関連ACFレイヤー「[レイヤー名]」について確認させてください：

1. 投稿タイプ: 標準投稿 / カスタム投稿タイプ（名称：）
2. 表示件数: ○件表示 / ページング（有無）
3. 表示項目: タイトル / 日付 / アイキャッチ / 抜粋 / その他
4. 並び順: 日付順（新しい順/古い順） / カスタム順 / その他
5. 繰り返し: 単発 / リスト / グリッド（○列）

ご回答に基づいて、適切なカスタム投稿タイプとACFフィールドを設計します。
```

### ✅ **ACF実装時の整理・タグ付けルール**

**メモ・タグ付け形式**:
```html
<!-- ACF情報をdata属性とコメントで整理 -->
<div class="content-block" 
     data-acf="section-title"
     data-acf-type="text"
     data-acf-required="true">
    <!-- ACF: テキストフィールド（単一行） / 必須: Yes / デフォルト: なし -->
    <!-- 確認日: 2025-08-17 / 確認者: [ユーザー名] -->
    <?php the_field('section_title'); ?>
</div>
```

**確認記録テンプレート**:
```markdown
## ACF確認記録 - [日付]

### レイヤー: [acf-xxx-xxx]
- **フィールドタイプ**: テキスト（単一行）
- **フィールド名**: section_title
- **必須/任意**: 必須
- **デフォルト値**: なし
- **追加設定**: 最大文字数50文字
- **確認者**: [ユーザー名]
- **確認日**: [日付]

### 実装メモ:
[ユーザーからの回答内容をそのまま記録]
```

---

## 🎠 **Swiper設定共通化ルール**

### ✅ **共通設定の抽出**

```javascript
// 共通設定オブジェクト
const commonSettings = {
    allowTouchMove: false,
    simulateTouch: false,
    slidesPerView: 'auto',
};

const mainSliderCommon = {
    ...commonSettings,
    rewind: true,
    speed: 1000,
    effect: 'slide',
    centeredSlides: true,
    initialSlide: 1,
};

// 個別設定（autoplay/loopは各自維持）
const mainSliderDesktop = new Swiper('.main-slider-desktop', {
    ...mainSliderCommon,
    loop: false,              // 個別維持
    autoplay: {               // 個別維持
        delay: 3000,
        disableOnInteraction: false,
    },
    spaceBetween: 20,
});
```

### ✅ **設定の個別化ルール**

| 設定項目 | 共通化 | 個別維持 |
|----------|--------|----------|
| `allowTouchMove` | ✅ 共通 | - |
| `slidesPerView` | ✅ 共通 | - |
| `speed` | ✅ 共通 | - |
| `autoplay` | - | ✅ 個別 |
| `loop` | - | ✅ 個別 |
| `spaceBetween` | - | ✅ 個別 |

---

## 📱 **メディアクエリ範囲設定**

### ✅ **統一ブレークポイント**

```css
/* 基本ブレークポイント: 768px */

/* デスクトップ・タブレット */
@media (min-width: 768px) {
    .responsive-grid {
        grid-template-columns: 45% 55%;
    }
}

/* スマートフォン */
@media (max-width: 767px) {
    .responsive-grid {
        grid-template-columns: 1fr;
        grid-template-rows: auto auto;
    }
}
```

**統一理由**:
- 768px: 一般的なタブレット幅
- 767px以下: スマートフォン対応
- **複数ブレークポイント削除**: 保守性向上

### ✅ **画面サイズ別調整**

| 画面サイズ | 設定 | 備考 |
|------------|------|------|
| **768px以上** | 横並び: `45% 55%` | タブレット・デスクトップ |
| **767px以下** | 縦並び: `1fr` | スマートフォン |

---

## 🔄 **スマホ縦並び切り替え基準**

### ✅ **縦並び適用ルール**

```css
@media (max-width: 767px) {
    /* グリッド → 縦並び */
    .sponsor-content-container {
        grid-template-columns: 1fr;
        grid-template-rows: auto auto;
    }
    
    /* 子要素のグリッド配置 */
    .sponsor-content-left {
        grid-column: 1;
        grid-row: 1;
    }
    
    .sponsor-logo-right {
        grid-column: 1;
        grid-row: 2;
    }
}
```

**適用条件**:
1. **767px以下**: 自動的に縦並び
2. **グリッド構造維持**: Flexboxに変更せず
3. **順序制御**: `grid-row`で表示順序指定

---

## 🎯 **フォント・テキストサイズ設定**

### ✅ **clamp()によるテキストサイズ調整**

```css
/* 基本テキスト */
.responsive-text {
    font-size: clamp(0.75rem, 1vw, 1rem);    /* min 12px, max 16px */
    line-height: 1.375;
    letter-spacing: 0.05em;
}

/* 大きなテキスト */
.large-responsive-text {
    font-size: clamp(0.75rem, 2vw, 1rem);    /* よりレスポンシブ */
}
```

**基準値**:
- **最小**: `0.75rem` (12px) - 読みやすさの下限
- **最大**: `1rem` (16px) - 標準サイズ
- **可変**: `1vw` または `2vw` - ビューポート連動

---

## 🔧 **コード品質・保守性チェック**

### ✅ **目的: 構築品質の維持・向上**

レスポンシブ対応時に以下の問題がないか必ずチェックし、コードの品質を維持してください。

#### **1. CSS競合・重複チェック項目**

| チェック対象 | 確認内容 | 対処方法 |
|--------------|----------|----------|
| **重複セレクタ** | 同一要素に複数の競合するスタイル | 統合・削除・優先度調整 |
| **!important乱用** | 不要な!important指定 | 詳細度の見直し・削除 |
| **メディアクエリ重複** | 同一ブレークポイントの重複定義 | 統一・集約 |
| **未使用プロパティ** | 効果のないCSS宣言 | 削除・修正 |

```css
/* ❌ 問題例: 競合・重複 */
.sponsor-content-container {
    grid-template-columns: 30% 70%;
}
.sponsor-content-container {
    grid-template-columns: 45% 55% !important;  /* 競合 */
}
@media (max-width: 1200px) {
    .sponsor-content-container {
        grid-template-columns: 38% 62% !important;  /* 重複ブレークポイント */
    }
}

/* ✅ 修正例: 統一・簡潔化 */
.sponsor-content-container {
    grid-template-columns: 45% 55%;  /* 基本設定 */
}
@media (min-width: 768px) {
    .sponsor-content-container {
        grid-template-columns: 45% 55%;  /* 単一ブレークポイント */
    }
}
```

#### **2. 残像コード・未使用スタイル検出**

| 検出対象 | 確認方法 | 対処基準 |
|----------|----------|----------|
| **旧デザインの残り** | コメント・命名規則で特定 | 削除（問題ない場合のみ） |
| **テスト用コード** | debug, test, temp等の命名 | 削除（問題ない場合のみ） |
| **未使用セレクタ** | HTML内での使用確認 | 削除（問題ない場合のみ） |
| **古いブレークポイント** | 現在の基準と異なる値 | 統一・削除 |

```css
/* ❌ 削除対象例 */
.old-sponsor-layout { /* 旧デザイン */
    position: absolute;
    top: 19.1%;
    width: 38.4%;
}

.debug-border { /* テスト用 */
    border: 2px solid red !important;
}

.temp-fix { /* 一時対応 */
    margin-left: -10px;
}

@media (max-width: 1400px) { /* 複雑化したブレークポイント */
    .sponsor-content-container {
        grid-template-columns: 32% 68% !important;
    }
}

/* ✅ 保持・整理後 */
.sponsor-content-container {
    grid-template-columns: 45% 55%;
}
@media (max-width: 767px) {
    .sponsor-content-container {
        grid-template-columns: 1fr;
    }
}
```

#### **3. 複雑化・保守性低下箇所の特定**

| 問題パターン | 判定基準 | 推奨対処 |
|--------------|----------|----------|
| **深いネスト** | 4階層以上のセレクタ | フラット化・クラス分離 |
| **過度な計算式** | calc()内の複雑な式 | 変数化・分離 |
| **巨大なメディアクエリ** | 10個以上のプロパティ | 分割・共通化 |
| **マジックナンバー** | 意味不明な数値 | コメント・変数化 |

```css
/* ❌ 複雑化例 */
.sponsor-section .content .left .image-container .responsive-image {
    width: calc(clamp(40%, calc(55% + 2vw - 10px), 75%) * 0.8 + 5px);
    height: calc((100vh - 67.5rem) / 3 + 15px);
    transform: translateX(calc(-50% + 12.34px)) scale(0.987);
}

/* ✅ 改善案（ユーザー承認後に実行） */
:root {
    --content-base-width: 55%;
    --content-adjust: 2vw;
    --content-offset: 5px;
}

.responsive-image {
    width: clamp(40%, var(--content-base-width), 75%);
    aspect-ratio: 738/255;
    transform: translateX(-50%);
}
```

### ✅ **対応ポリシー**

#### **削除の判定基準**

```markdown
✅ **削除OK**: 以下すべてに該当する場合
- [ ] HTMLで使用されていない
- [ ] 他のCSSから参照されていない  
- [ ] 削除してもレイアウトに影響しない
- [ ] 機能・動作に支障をきたさない

⚠️ **要承認**: 以下のいずれかに該当する場合
- [ ] 影響範囲が不明
- [ ] 複雑な依存関係がある
- [ ] JavaScript連携がある
- [ ] 将来の機能拡張で使用予定
```

#### **修正提案・承認フロー**

```markdown
1. **問題箇所の特定・分析**
   - 現在のコード構造を詳細調査
   - 問題点と影響範囲を明確化
   
2. **改善案の提示**
   - 具体的な修正後コードを提示
   - メリット・デメリットを説明
   - 影響範囲・テスト項目を明記
   
3. **ユーザー承認の取得**
   - 修正内容の詳細確認
   - 承認後に実行（承認なしでは実行しない）
   
4. **段階的実行・検証**
   - バックアップ作成
   - 段階的修正・動作確認
   - 問題発生時の即座回復
```

#### **チェック実行タイミング**

| タイミング | 実行内容 | 頻度 |
|------------|----------|------|
| **レスポンシブ対応開始前** | 既存コードの品質確認 | 必須 |
| **各セクション完了時** | 追加コードの品質確認 | 推奨 |
| **全体完了時** | 統合的な品質確認 | 必須 |
| **保守・更新時** | 継続的な品質維持 | 定期 |

---

## ⚠️ **注意事項・制約**

### ✅ **固定値使用の制限**

| 要素 | 固定値使用 | 代替手法 |
|------|------------|----------|
| **width** | ❌ 禁止 | `%`, `clamp()`, `vw` |
| **height** | ⚠️ 制限付き | `aspect-ratio`, `vh` |
| **position** | ⚠️ 制限付き | CSS Grid推奨 |
| **font-size** | ❌ 禁止 | `clamp()`, `rem` |

### ✅ **互換性確保**

```css
/* ブラウザサポート確認 */
@supports (aspect-ratio: 1/1) {
    .modern-aspect {
        aspect-ratio: 564/255;
    }
}

/* フォールバック */
@supports not (aspect-ratio: 1/1) {
    .legacy-aspect {
        padding-bottom: 45.21%; /* 255/564 * 100 */
    }
}
```

---

## 📱 **モバイル多列レイアウトの収納設計**

### ✅ **カード要素の最小幅設計基準**

| カード種別 | 基本min-width | 特例min-width | 適用条件 |
|-----------|---------------|---------------|----------|
| **一般カード** | 200px | - | 標準的な情報表示 |
| **アイコンカード** | 150px | - | 簡潔な情報表示 |
| **多列収納カード** | 200px | 69px | **4列以上のモバイル収納** |

### ✅ **多列収納の実装手順**

#### **Step 1: 収納可能性の計算**
```css
/* 計算例: 320px画面での4列収納 */
利用可能幅 = 画面幅 - パディング - gap合計
         = 320px - 10px - 24px = 286px
1カードあたり = 286px ÷ 4 = 71.5px
最小必要幅 = 69px（切り上げ）
```

#### **Step 2: ユーザー事前確認（必須）**
```markdown
⚠️ 多列収納実装前の必須確認:
- カード内容の可読性維持可能か？
- 極小サイズでのユーザビリティ問題は？
- デスクトップでの表示バランスは？
- 代替手段（2列・スクロール）は検討したか？
```

#### **Step 3: 段階的実装**
```css
/* 段階1: 基本設定（200px基準） */
.card-element {
    min-width: 200px;
    max-width: 300px;
    flex: 1 1 0;
}

/* 段階2: ユーザー承認後の特例設定（69px） */
.card-element-compact {
    min-width: 69px;            /* 特例：多列収納用 */
    max-width: 300px;           /* 大画面での上限維持 */
    flex: 1 1 0;
}

/* 段階3: モバイル左右余白調整 */
.container-mobile {
    padding: 0 5px;             /* 余白最小化 */
}
```

### ✅ **品質保証のチェックポイント**

```css
/* カード比率維持の確認 */
.card-element {
    aspect-ratio: 9/16;         /* 比率一定維持 */
}

/* 320px画面での実際表示確認 */
@media (max-width: 320px) {
    .debug-card {
        border: 1px solid red;  /* デバッグ用境界線 */
        min-height: 2em;        /* 最小高さ確保 */
    }
}
```

---

## 🎨 **エリア間余白の統一手法**

### ✅ **余白統一の設計原則**

```css
/* 原則: 各エリアに一律の上下余白を適用 */
.title-area,
.button-area,
.content-area {
    padding: 1rem 0;           /* 16px上下余白 */
}

/* レスポンシブ調整 */
@media (max-width: 767px) {
    .title-area,
    .button-area,
    .content-area {
        padding: 0.75rem 0;    /* モバイルで調整 */
    }
}
```

### ✅ **余白値の選定基準**

| 余白サイズ | 用途 | 実装値 | 適用例 |
|-----------|------|--------|--------|
| **極小** | 密度高い情報 | `0.5rem (8px)` | データテーブル行間 |
| **小** | 関連性高い要素 | `0.75rem (12px)` | モバイル縮小時 |
| **標準** | 一般的な区切り | `1rem (16px)` | **推奨値** |
| **大** | セクション間区切り | `2rem (32px)` | 大きな構造分離 |

### ✅ **配置調整テンプレート**

```css
/* エリア余白統一テンプレート */
.area-spacing {
    padding: 1rem 0;          /* 標準16px */
}

/* 配置調整 */
.left-align { justify-content: flex-start; }
.center-align { justify-content: center; }
.right-align { justify-content: flex-end; }
```

---

## 📋 **高さ制約問題解決テンプレート**

### ✅ **高さ柔軟化テンプレート**

```css
/* Before: 固定高さ（問題発生パターン） */
.section-container {
    height: 45.25rem;
    overflow: hidden;
}

/* After: 柔軟高さ（ユーザー指示時のみ） */
.section-container {
    min-height: 45.25rem;
    /* overflow: visible; 必要に応じて */
}

.grid-container {
    /* grid-template-rows: 31% 69%; */
    grid-template-rows: auto 1fr;
}
```

### ✅ **モバイル多列収納テンプレート**

```css
/* ユーザー承認後の特例実装 */
.mobile-card-compact {
    display: flex;
    flex-direction: column;
    height: 100%;
    flex: 1 1 0;
    max-width: 300px;         /* デスクトップ上限 */
    min-width: 69px;          /* モバイル下限 */
}

.mobile-container {
    padding: 0 5px;           /* 余白最小化 */
    gap: clamp(0.5rem, 1.3%, 1rem);
    flex-wrap: nowrap;
}
```

---

## 📋 **実装チェックリスト**

### ✅ **レスポンシブ対応完了基準**

#### **構造・レイアウト**
- [ ] CSS Grid構造に統一
- [ ] 768pxブレークポイント設定（単一ブレークポイント）
- [ ] スマホで縦並び表示確認（767px以下）

#### **サイズ指定**
- [ ] **高さ**: Figmaのpx値を1rem=16px基準でrem変換
- [ ] **幅**: 固定幅を動的幅(`%`, `clamp()`)に変換
- [ ] **画像・ベクター**: aspect-ratio + width基準で実装
- [ ] **テキスト**: clamp()でサイズ設定（最小0.75rem）

#### **レスポンシブ対応**
- [ ] デバイス別基準計算（Desktop: 1920px, Mobile: 768px）
- [ ] コンテンツ種別によるclamp()個別調整
- [ ] 320px最小幅での見切れ・破綻確認
- [ ] ブラウザ幅比例の拡大・縮小動作確認

#### **コード品質**
- [ ] data属性整理(ACFのみ保持、node/constraints削除)
- [ ] Swiper設定共通化（autoplay/loop個別維持）
- [ ] object-fit/aspect-ratio適用
- [ ] 各画面サイズでの表示確認

#### **品質・保守性チェック**
- [ ] **CSS競合・重複**：重複セレクタ・!important乱用・メディアクエリ重複の確認
- [ ] **残像コード検出**：旧デザイン・テスト用・未使用セレクタの削除確認
- [ ] **複雑化チェック**：深いネスト・過度な計算式・巨大メディアクエリの簡潔化
- [ ] **削除判定基準**：HTMLでの使用・CSS参照・レイアウト影響・機能影響の確認

### ✅ **品質確認項目**

#### **レイアウト確認**
1. **768px以上**: 横並びレイアウト
2. **767px以下**: 縦並びレイアウト  
3. **320px**: 最小幅での見切れなし確認

#### **サイズ動作確認**
4. **高さ**: 固定値維持（rem単位）
5. **幅**: ブラウザ幅に比例した拡大・縮小
6. **画像・動画**: aspect-ratio維持とobject-fit適用
7. **テキスト**: 最小12px保証、最大値制限

#### **レスポンシブ動作確認**
8. **320px ～ 768px**: スマホレスポンシブ
9. **768px ～ 1920px**: デスクトップレスポンシブ  
10. **1920px以上**: 最大幅制限動作
11. **アニメーション**: Swiper正常動作・設定共通化

#### **品質・保守性確認**
12. **CSS競合なし**: 重複セレクタ・!important削減・メディアクエリ統一
13. **残像コード除去**: 旧デザイン・テスト用・未使用コードの削除
14. **保守性向上**: 複雑化箇所の簡潔化・ネスト深度適正化
15. **承認フロー遵守**: 修正提案・ユーザー承認・段階的実行の実施

---

## 📚 **参考実装例**

### ✅ **完全なレスポンシブセクション例**

```html
<!-- Figma: 1920px × 1080px セクション -->
<section class="hidden tablet:block relative w-full bg-figma-black overflow-hidden"
         style="height: 67.5rem;" 
         data-acf="sponsor-section-desktop">
    <div class="sponsor-section-container">
        <!-- メインスライダー: Figma 1920px × 670px → height: 41.875rem -->
        <div class="sponsor-main-slider" 
             style="height: 41.875rem;" 
             data-acf="spon-sl-desktop">
            <div class="swiper main-slider-desktop w-full h-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide flex items-center justify-center">
                        <!-- スライド: Figma 1186px × 666px → width: clamp(60%, 85%, 95%) + aspect-ratio -->
                        <div class="rounded-[51px] bg-red-500"
                             style="width: clamp(60%, 85%, 95%); aspect-ratio: 1186/666;"
                             data-acf="spon-sl-01-desktop">
                            <video class="w-full h-full object-cover rounded-[51px]" 
                                   autoplay muted loop data-acf="acf-main-video-01">
                                <source src="" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- コンテンツエリア: Figma 1920px × 410px → height: 25.625rem -->
        <div class="sponsor-content-container" 
             style="height: 25.625rem;" 
             data-acf="spon-cont-desktop">
            <div class="sponsor-content-left" data-acf="spon-cont-tl-desktop">
                <!-- コンテンツ画像: Figma 738px × 255px → aspect-ratio基準 -->
                <div style="width: clamp(40%, 55%, 75%); aspect-ratio: 738/255;"
                     data-acf="spon-cont-img-desktop">
                    <img src="" alt="Sponsor Content" 
                         style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>
            <div class="sponsor-logo-right" data-acf="spon-sl-logo-desktop">
                <!-- ロゴボックス: 相対配置 + clamp()調整 -->
                <div style="position: absolute; 
                           top: clamp(15%, 19.1%, 25%); 
                           left: 0; 
                           width: 100%; 
                           height: clamp(55%, 61.7%, 70%); 
                           overflow: hidden;"
                     data-acf="spon-sl-logo-box-desktop">
                    <div class="swiper logo-slider-desktop w-full h-full">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <!-- ロゴ: Figma 564px × 255px → aspect-ratio維持 -->
                                <div style="width: clamp(15%, 20%, 30%); 
                                           aspect-ratio: 564/255; 
                                           background-color: cyan;"
                                     data-acf="acf-spon-sl-spon-01">
                                    <img src="" alt="Sponsor Logo" 
                                         style="width: 100%; height: 100%; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 320px最小幅対応確認例 -->
<style>
/* 320px時の動作確認 */
@media (max-width: 320px) {
    /* clamp(60%, 85%, 95%) → 60% × 320px = 192px */
    /* clamp(15%, 20%, 30%) → 15% × 320px = 48px */
    /* aspect-ratio: 564/255 → 48px ÷ 2.212 = 22px高さ */
    
    .debug-info::after {
        content: "320px: スライド192px, ロゴ48×22px 表示確認";
        position: fixed;
        top: 0;
        left: 0;
        background: red;
        color: white;
        padding: 5px;
        font-size: 12px;
        z-index: 9999;
    }
}
</style>
```

#### **CSS Grid + 高さ固定 + 幅レスポンシブ の完全実装**

```css
/* セクション全体: Figma基準でrem変換 */
.sponsor-section-container {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 62% 38%;  /* 670px:410px = 62%:38% */
    width: 100%;                  /* レスポンシブ */
    height: 67.5rem;              /* 固定（1080px ÷ 16） */
    position: relative;
}

/* メインスライダー */
.sponsor-main-slider {
    grid-column: 1;
    grid-row: 1;
    width: 100%;                  /* レスポンシブ */
    height: 100%;                 /* 親要素の100%（固定） */
}

/* コンテンツコンテナ */
.sponsor-content-container {
    grid-column: 1;
    grid-row: 2;
    display: grid;
    grid-template-columns: 45% 55%;  /* デバイス別調整 */
    width: 100%;                     /* レスポンシブ */
    height: 100%;                    /* 親要素の100%（固定） */
}

/* メディアクエリ: 768px基準の単一ブレークポイント */
@media (max-width: 767px) {
    .sponsor-content-container {
        grid-template-columns: 1fr;      /* 縦並び */
        grid-template-rows: auto auto;   /* 高さ自動調整 */
    }
}
```

---

**📌 作成日**: 2025年8月17日  
**📌 バージョン**: v2.2 - 高さ制約・Grid比率・多列レイアウト統合版  
**📌 対象プロジェクト**: STEPJAM  
**📌 実装ベース**: index-tailwind.html レスポンシブ対応実績 + figma-to-responsive-guide_2.md統合  
**📌 更新内容**: 
- 高さ固定ルール追加（px→rem変換基準）
- **✅ 高さ制約柔軟対応**: ユーザー指示時のみの例外処理追加
- **✅ Grid比率使い分け**: 固定比率・auto/1fr・比例比率の並列記載
- **✅ モバイル多列レイアウト**: 69px特例含む収納設計ガイド追加
- **✅ エリア間余白統一**: padding: 1rem 0 の統一手法追加
- **✅ 実装テンプレート集**: 高さ柔軟化・多列収納の実装例追加
- Figma→レスポンシブ変換手順詳細化
- aspect-ratio + width基準設計
- 320px最小幅対応基準
- コンテンツ種別別clamp()調整ガイド
- **🔧 コード品質・保守性チェック項目追加**
  - CSS競合・重複チェック項目
  - 残像コード・未使用スタイル検出
  - 複雑化・保守性低下箇所の特定
  - 削除判定基準・修正承認フロー
  - チェック実行タイミング・品質確認項目