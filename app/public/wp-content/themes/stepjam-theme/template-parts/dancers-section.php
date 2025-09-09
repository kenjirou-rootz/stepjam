<?php
/**
 * 出演ダンサーセクション テンプレートパーツ
 * Figma「デスクトップ-出演ダンサー」デザイン対応
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

// ACFフィールド取得（エラーハンドリング付き）
$dancers_section_show = false;
$day1_show = false;
$day2_show = false;
$day1_sliders = array();
$day2_sliders = array();

if (function_exists('get_field')) {
    $dancers_section_show = get_field('nx_dancers_section_show') ?: false;
    $day1_show = get_field('nx_day1_show') ?: false;
    $day2_show = get_field('nx_day2_show') ?: false;
    $day1_sliders = get_field('nx_day1_sliders') ?: array();
    $day2_sliders = get_field('nx_day2_sliders') ?: array();
}

// セクション全体が非表示の場合は何も表示しない
if (!$dancers_section_show) {
    return;
}

// 両方非表示の場合も何も表示しない
if (!$day1_show && !$day2_show) {
    return;
}

// 表示状態に応じたレイアウトクラス決定
$layout_class = '';
if ($day1_show && $day2_show) {
    $layout_class = 'dancers-section--both';
} elseif ($day1_show && !$day2_show) {
    $layout_class = 'dancers-section--day1-only';
} elseif (!$day1_show && $day2_show) {
    $layout_class = 'dancers-section--day2-only';
}
?>

<section class="dancers-section <?php echo esc_attr($layout_class); ?>" data-section="dancers">
    <div class="dancers-section__container">
        
        <?php if ($day1_show && $day1_sliders): ?>
            <div class="dancers-section__day dancers-section__day--day1" data-day="1">
                <!-- DAY1タイトルコンテナ -->
                <div class="dancers-section__title-container">
                    <div class="dancers-section__title-vector" data-title="day1">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/day1-title.svg'); ?>" 
                             alt="DAY1" 
                             class="dancers-section__title-image"
                             loading="lazy">
                    </div>
                </div>
                
                <!-- DAY1出演ダンサーコンテナ -->
                <div class="dancers-section__dancers-container">
                    <?php foreach ($day1_sliders as $slider_index => $slider): 
                        $genre_name = isset($slider['genre_name']) ? $slider['genre_name'] : '未設定';
                        $dancer_slides = isset($slider['dancer_slides']) ? $slider['dancer_slides'] : array();
                    ?>
                        <div class="dancers-section__slider-container" data-slider="day1-<?php echo $slider_index; ?>">
                            <!-- ジャンルタイトル -->
                            <div class="dancers-section__genre-title">
                                <h3 class="dancers-section__genre-text"><?php echo esc_html($genre_name); ?></h3>
                            </div>
                            
                            <!-- Swiperスライダー -->
                            <div class="swiper dancers-section__swiper">
                                <div class="dancers-section__swiper-wrapper">
                                    <?php if (!empty($dancer_slides)): ?>
                                        <?php foreach ($dancer_slides as $slide_index => $slide): 
                                            $dancer_name = isset($slide['dancer_name']) ? $slide['dancer_name'] : '未設定';
                                            $dancer_bg_image = isset($slide['dancer_bg_image']) ? $slide['dancer_bg_image'] : null;
                                            $dancer_link = isset($slide['dancer_link']) ? $slide['dancer_link'] : '';
                                        ?>
                                            <div class="dancers-section__slide swiper-slide" 
                                                 data-slide="<?php echo $slider_index; ?>-<?php echo $slide_index; ?>">
                                                <?php 
                                                $slide_content = '<div class="dancers-section__slide-inner">';
                                                
                                                // 背景画像設定（エラーハンドリング付き）
                                                $bg_style = '';
                                                if ($dancer_bg_image && is_array($dancer_bg_image) && isset($dancer_bg_image['url'])) {
                                                    $bg_style = 'background-image: url(' . esc_url($dancer_bg_image['url']) . ');';
                                                }
                                                
                                                $slide_content .= '<div class="dancers-section__slide-bg" style="' . $bg_style . '">';
                                                $slide_content .= '<div class="dancers-section__slide-overlay">';
                                                $slide_content .= '<div class="dancers-section__slide-text">';
                                                $slide_content .= '<p class="dancers-section__dancer-name">' . esc_html($dancer_name) . '</p>';
                                                $slide_content .= '</div></div></div></div>';
                                                
                                                // リンク設定がある場合はaタグで囲む
                                                if (!empty($dancer_link)): ?>
                                                    <a href="<?php echo esc_url($dancer_link); ?>" 
                                                       class="dancers-section__slide-link" 
                                                       target="_blank" 
                                                       rel="noopener noreferrer">
                                                        <?php echo $slide_content; ?>
                                                    </a>
                                                <?php else: ?>
                                                    <?php echo $slide_content; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <!-- データが空の場合のメッセージ -->
                                        <div class="dancers-section__slide swiper-slide">
                                            <div class="dancers-section__slide-inner">
                                                <div class="dancers-section__slide-bg">
                                                    <div class="dancers-section__slide-overlay">
                                                        <div class="dancers-section__slide-text">
                                                            <p class="dancers-section__dancer-name">データがありません</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($day2_show && $day2_sliders): ?>
            <div class="dancers-section__day dancers-section__day--day2" data-day="2">
                <!-- DAY2タイトルコンテナ -->
                <div class="dancers-section__title-container">
                    <div class="dancers-section__title-vector" data-title="day2">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/day2-title.svg'); ?>" 
                             alt="DAY2" 
                             class="dancers-section__title-image"
                             loading="lazy">
                    </div>
                </div>
                
                <!-- DAY2出演ダンサーコンテナ -->
                <div class="dancers-section__dancers-container">
                    <?php foreach ($day2_sliders as $slider_index => $slider): 
                        $genre_name = isset($slider['genre_name']) ? $slider['genre_name'] : '未設定';
                        $dancer_slides = isset($slider['dancer_slides']) ? $slider['dancer_slides'] : array();
                    ?>
                        <div class="dancers-section__slider-container" data-slider="day2-<?php echo $slider_index; ?>">
                            <!-- ジャンルタイトル -->
                            <div class="dancers-section__genre-title">
                                <h3 class="dancers-section__genre-text"><?php echo esc_html($genre_name); ?></h3>
                            </div>
                            
                            <!-- Swiperスライダー -->
                            <div class="swiper dancers-section__swiper">
                                <div class="dancers-section__swiper-wrapper">
                                    <?php if (!empty($dancer_slides)): ?>
                                        <?php foreach ($dancer_slides as $slide_index => $slide): 
                                            $dancer_name = isset($slide['dancer_name']) ? $slide['dancer_name'] : '未設定';
                                            $dancer_bg_image = isset($slide['dancer_bg_image']) ? $slide['dancer_bg_image'] : null;
                                            $dancer_link = isset($slide['dancer_link']) ? $slide['dancer_link'] : '';
                                        ?>
                                            <div class="dancers-section__slide swiper-slide" 
                                                 data-slide="<?php echo $slider_index; ?>-<?php echo $slide_index; ?>">
                                                <?php 
                                                $slide_content = '<div class="dancers-section__slide-inner">';
                                                
                                                // 背景画像設定（エラーハンドリング付き）
                                                $bg_style = '';
                                                if ($dancer_bg_image && is_array($dancer_bg_image) && isset($dancer_bg_image['url'])) {
                                                    $bg_style = 'background-image: url(' . esc_url($dancer_bg_image['url']) . ');';
                                                }
                                                
                                                $slide_content .= '<div class="dancers-section__slide-bg" style="' . $bg_style . '">';
                                                $slide_content .= '<div class="dancers-section__slide-overlay">';
                                                $slide_content .= '<div class="dancers-section__slide-text">';
                                                $slide_content .= '<p class="dancers-section__dancer-name">' . esc_html($dancer_name) . '</p>';
                                                $slide_content .= '</div></div></div></div>';
                                                
                                                // リンク設定がある場合はaタグで囲む
                                                if (!empty($dancer_link)): ?>
                                                    <a href="<?php echo esc_url($dancer_link); ?>" 
                                                       class="dancers-section__slide-link" 
                                                       target="_blank" 
                                                       rel="noopener noreferrer">
                                                        <?php echo $slide_content; ?>
                                                    </a>
                                                <?php else: ?>
                                                    <?php echo $slide_content; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <!-- データが空の場合のメッセージ -->
                                        <div class="dancers-section__slide swiper-slide">
                                            <div class="dancers-section__slide-inner">
                                                <div class="dancers-section__slide-bg">
                                                    <div class="dancers-section__slide-overlay">
                                                        <div class="dancers-section__slide-text">
                                                            <p class="dancers-section__dancer-name">データがありません</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<style>
/* 出演ダンサーセクション CSS */
/* SuperClaude仕様: CSS Grid基盤、Container Query、流体設計、dvh対応 */

.dancers-section {
    /* 基本レイアウト */
    min-height: 100dvh;
    min-height: 100vh; /* フォールバック */
    background-color: #000000;
    container-type: inline-size;
    position: relative;
    isolation: isolate;
    /* 50vw仕様対応: 最大幅制限 + 中央寄せ */
    max-width: 1920px;
    margin: 0 auto;
    width: 100%;
}

.dancers-section__container {
    /* 50vw仕様対応: Grid → Flexbox変更 */
    display: flex;
    min-height: 100dvh;
    min-height: 100vh; /* フォールバック */
    width: 100%;
    gap: 1px;
}

/* 50vw仕様: レイアウトバリエーション */
.dancers-section--both .dancers-section__container {
    /* 両方表示時: flexboxで自動分散 */
    flex-direction: row;
}

.dancers-section--day1-only .dancers-section__container,
.dancers-section--day2-only .dancers-section__container {
    /* 片方のみ表示時: 単一カラム */
    flex-direction: row;
}

.dancers-section__day {
    /* 各Dayコンテナ */
    display: grid;
    grid-template-rows: auto 1fr;
    min-height: 100dvh;
    min-height: 100vh; /* フォールバック */
    position: relative;
    /* Figmaデザイン準拠: dayコンテナのオーバーフロー制御 */
    overflow: hidden; /* 50vw制約下でのはみ出し制御 */
}

.dancers-section__day--day1 {
    background-color: transparent;
}

.dancers-section__day--day2 {
    background-color: #0000ff; /* TOKYO デフォルト */
}

/* DAY2エリア別背景色 - 最高詳細度セレクター */
body .nx-tokyo-container.area-tokyo .dancers-section .dancers-section__day.dancers-section__day--day2 {
    background-color: #0000FF !important; /* TOKYO: 青 */
}

body .nx-tokyo-container.area-osaka .dancers-section .dancers-section__day.dancers-section__day--day2 {
    background-color: #FF0000 !important; /* OSAKA: 赤 */
}

body .nx-tokyo-container.area-tohoku .dancers-section .dancers-section__day.dancers-section__day--day2 {
    background-color: #00FF6A !important; /* TOHOKU: 緑 */
}

/* 50vw仕様: 各Dayの幅指定 */
.dancers-section--both .dancers-section__day {
    /* 両方表示時: 各50vw使用 */
    width: 50vw;
    max-width: 50vw;
    flex: 0 0 50vw; /* Flexbox確実性 */
    overflow: hidden; /* タイトルはみ出し防止 */
}

.dancers-section--day1-only .dancers-section__day,
.dancers-section--day2-only .dancers-section__day {
    /* 片方のみ表示時: 100%幅使用 */
    width: 100%;
    max-width: 100%;
    flex: 0 0 100%;
}

/* タイトルコンテナ */
.dancers-section__title-container {
    padding: clamp(1.25rem, 2.5vw, 1.25rem) clamp(1.25rem, 3.125vw, 3.125rem) clamp(6.25rem, 10vw, 6.25rem) clamp(2rem, 4vw, 2rem);
    max-height: clamp(22.8125rem, 30vw, 22.8125rem);
    max-width: 100%; /* DAYコンテナ制約準拠 */
    overflow: hidden; /* はみ出し制御 */
    display: flex;
    align-items: flex-start;
}

.dancers-section__title-vector {
    /* 決定的修正: 50vw制約下で確実収納 */
    width: 100%;
    max-width: calc(50vw - 3rem); /* 50vw - padding余白（左右余白確保）*/
    aspect-ratio: 863.5 / 265;
    object-fit: contain;
    height: auto;
}

.dancers-section__title-image {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: contain;
}

/* DAY2のタイトル画像アスペクト比調整 */
.dancers-section__day--day2 .dancers-section__title-vector {
    /* 決定的修正: DAY2も50vw制約準拠 */
    width: 100%;
    max-width: calc(50vw - 3rem); /* 50vw - padding余白（左右余白確保）*/
    aspect-ratio: 793.5 / 243.518;
    object-fit: contain;
    height: auto;
}

/* 出演ダンサーコンテナ */
.dancers-section__dancers-container {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    /* 上詰め配置：スライダーコンテナ数不一致時の適切な間隔設定 */
    gap: clamp(1.5rem, 3vw, 2.5rem);
}

/* スライダーコンテナ */
.dancers-section__slider-container {
    display: flex;
    flex-direction: column;
    /* 上詰め配置：等分割を無効化し自然な高さを使用 */
    flex: none;
    min-height: 0;
}

/* ジャンルタイトル */
.dancers-section__genre-title {
    padding: clamp(1.25rem, 2.5vw, 1.25rem) clamp(0.625rem, 1.25vw, 0.625rem);
    /* 左余白追加: ブラウザ端密着回避 */
    margin-left: clamp(1rem, 2vw, 1.5rem);
    min-height: clamp(3.9375rem, 6vw, 3.9375rem);
    display: flex;
    align-items: center;
}

.dancers-section__genre-text {
    font-family: 'Noto Sans JP', sans-serif;
    font-weight: 900;
    font-size: clamp(1.25rem, 2.5vw, 1.25rem);
    color: #ffffff;
    margin: 0;
    line-height: 1;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Swiperコンテナ */
.dancers-section__swiper {
    flex: 1;
    padding: clamp(0.625rem, 1.25vw, 0.625rem);
    /* 左余白追加: ブラウザ端密着回避 */
    margin-left: clamp(1rem, 2vw, 1.5rem);
    /* Figmaデザイン準拠: dayコンテナからはみ出すスライドを非表示 */
    overflow: hidden !important; /* はみ出したスライドを確実に非表示 */
    position: relative;
    width: 100%;
    max-width: 100%;
}

.dancers-section__swiper-wrapper {
    display: flex;
    align-items: flex-start;
    /* B案採用: height: 100% + min-height: 274.5px 組み合わせ */
    height: 100%;
    min-height: 274.5px;
    /* Swiper動作時はgapを無効化（spaceBetween使用） */
    gap: 10px; /* Figma通りの固定ギャップ - Swiper未適用時のみ有効 */
}

/* Swiper動作時の調整 */
.dancers-section__swiper.swiper {
    /* Swiperが初期化されている場合の調整 */
    overflow: hidden !important;
}

.dancers-section__swiper .swiper-wrapper {
    /* 独立Slider用スタイル調整 */
    display: flex;
    align-items: flex-start;
    height: 100%;
    min-height: 274.5px;
    /* 独立Slider用: CSS transformアニメーション対応 */
    transition: transform 1s ease-in-out;
    transform: translateX(0px);
}

/* Figmaデザイン準拠: 固定サイズスライド */
.dancers-section__slide {
    /* 278px × 274.5px 固定サイズ（全デバイス共通） */
    width: 278px !important;
    height: 274.5px !important;
    flex: 0 0 278px;
    max-width: none;
    min-width: 278px;
    border-radius: 0;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Figmaデザイン準拠: レスポンシブサイズ設定削除（固定サイズのみ使用） */

.dancers-section__slide:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.dancers-section__slide-link {
    display: block;
    width: 100%;
    height: 100%;
    text-decoration: none;
    color: inherit;
}

.dancers-section__slide-inner {
    width: 100%;
    height: 100%;
    position: relative;
}

.dancers-section__slide-bg {
    width: 100%;
    height: 100%;
    background-color: #ff0000; /* Figmaデザインのフォールバック色 */
    /* Figmaデザイン準拠: 画像伸縮・中央配置・オーバーフロー */
    background-size: cover; /* 画像を枠に合わせて伸縮 */
    background-position: center center; /* 中央配置を明確化 */
    background-repeat: no-repeat;
    overflow: hidden; /* はみ出し部分を切り取り */
    display: flex;
    align-items: flex-end;
    position: relative;
}

.dancers-section__slide-overlay {
    width: 100%;
    background: rgba(0, 0, 0, 0.4);
    padding: clamp(0.625rem, 1.25vw, 0.625rem);
    display: flex;
    align-items: flex-end;
}

.dancers-section__slide-text {
    flex: 1;
}

.dancers-section__dancer-name {
    font-family: 'Noto Sans JP', sans-serif;
    font-weight: 400;
    font-size: clamp(0.875rem, 1.5vw, 0.875rem);
    line-height: 1.35;
    color: #ffffff;
    margin: 0;
    word-break: break-word;
    overflow-wrap: anywhere;
}

/* 50vw仕様: Media Queryレスポンシブ（詳細度修正版） - 修正ポイント */
@media (max-width: 768px) {
    /* 詳細度向上: レイアウトクラス関係なく強制縦積み */
    .dancers-section--both .dancers-section__container,
    .dancers-section--day1-only .dancers-section__container,
    .dancers-section--day2-only .dancers-section__container,
    .dancers-section__container {
        /* モバイルでは常に縦積み */
        flex-direction: column !important;
        gap: 0;
    }
    
    /* 詳細度向上: レイアウトクラス関係なく強制100vw幅 */
    .dancers-section--both .dancers-section__day,
    .dancers-section--day1-only .dancers-section__day,
    .dancers-section--day2-only .dancers-section__day,
    .dancers-section__day {
        /* モバイルでは常に100vw幅で縦積み */
        width: 100vw !important;
        max-width: 100vw !important;
        flex: 0 0 auto !important;
    }
    
    .dancers-section__title-container {
        padding: clamp(1rem, 4vw, 1rem) clamp(1rem, 4vw, 1rem) clamp(4rem, 8vw, 4rem) clamp(1rem, 4vw, 1rem);
        max-height: none;
    }
    
    /* Figmaデザイン準拠: モバイルでも固定サイズ維持（レスポンシブサイズ削除） */
    
    /* Figmaデザイン準拠: モバイルでも固定ギャップ維持 */
    
    .dancers-section__genre-text {
        font-size: clamp(1rem, 4vw, 1rem);
    }
}

/* CLS対策 */
.dancers-section__title-image,
.dancers-section__slide-bg {
    aspect-ratio: inherit;
    min-height: 1px;
}

/* アクセシビリティ - アニメーション軽減設定対応 */
@media (prefers-reduced-motion: reduce) {
    .dancers-section__slide {
        transition: none;
    }
    
    .dancers-section__slide:hover {
        transform: none;
    }
    
    /* スライド遷移時の不透明度エフェクトも無効化 */
    .dancers-section__slide {
        opacity: 1 !important;
    }
}

/* 通常時：スライド遷移エフェクト用のベース設定 */
@media not (prefers-reduced-motion: reduce) {
    .dancers-section__slide {
        /* JavaScriptで動的に制御される不透明度変化の基盤 */
        will-change: opacity;
    }
}

/* ダークモード対応 */
@media (prefers-color-scheme: light) {
    .dancers-section {
        /* 必要に応じてライトモード用の調整 */
    }
}
</style>