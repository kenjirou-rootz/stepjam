<?php
/**
 * Template for displaying NX TOKYO events
 *
 * @package STEPJAM
 */

get_header();
?>

<style>
/* CSS変数定義 */
:root {
  --nx-red: #FF0000;
  --nx-blue: #0000FF;
  --nx-green: #00FF6A;
  --nx-black: #000000;
  --nx-white: #FFFFFF;
  
  /* フォント設定 */
  --font-family: 'Noto Sans JP', sans-serif;
  
  /* レスポンシブ対応の基準値 */
  --content-max-width: 1920px;
  --area1-max-width: 733px;
  --area2-padding: clamp(1.5rem, 4vw, 2.5rem);
  
  /* タイポグラフィ（clamp使用） */
  --title-size: clamp(2rem, 4vw + 1rem, 2.8125rem); /* 32px → 45px */
  --title-spacing: clamp(0.08em, 0.1vw, 0.04em); /* 1.44px → 1.8px */
  --content-title-size: clamp(0.875rem, 1.5vw + 0.5rem, 1rem); /* 14px → 16px */
  --content-text-size: clamp(0.75rem, 1vw + 0.5rem, 0.875rem); /* 12px → 14px */
  --content-line-height: 1.857; /* 26px/14px */
}

/* コンテナクエリ設定 */
.nx-tokyo-container {
  container-type: inline-size;
  container-name: nx-container;
  width: 100%;
  min-height: 100vh;
  min-height: 100dvh;
  display: grid;
  grid-template-columns: 1fr;
  background-color: var(--nx-black);
  overflow: hidden;
}

/* メインレイアウト */
.nx-tokyo-wrapper {
  display: grid;
  grid-template-columns: 1fr;
  width: 100%;
  max-width: var(--content-max-width);
  margin: 0 auto;
  min-height: 100vh;
  min-height: 100dvh;
}

/* 768px以上でのグリッドレイアウト */
@container nx-container (min-width: 768px) {
  .nx-tokyo-wrapper {
    grid-template-columns: minmax(300px, var(--area1-max-width)) 1fr;
    gap: 1px;
  }
}

/* 768px以上でのnx-area2スクロール実装 */
@container nx-container (min-width: 750px) {
  .nx-area2 {
    height: 100vh; /* 固定領域内スクロール用の画面高さ固定 */
    height: 100dvh; /* iOS Safari対応 */
    overflow: hidden; /* 固定領域制御 */
  }
  
  .nx-content-blocks {
    overflow-y: auto; /* スクロールバー有効 */
    height: 100%; /* 親の残り領域を占有 */
    grid-auto-rows: auto; /* 内容に応じた自動高さを強制 */
  }
}

/* エリア1：ビジュアルエリア - デフォルト */
.nx-area1 {
  background-color: var(--nx-blue); /* TOKYO デフォルト */
  display: grid;
  grid-template-rows: 1fr auto;
  height: 100svh;
  height: 100dvh;
  height: 100vh;
  min-height: 100vh;
  position: relative;
}

/* エリア別背景色 */
.nx-area1.area-none {
  background-color: transparent;
}

.nx-area1.area-tokyo {
  background-color: var(--nx-blue);
}

.nx-area1.area-osaka {
  background-color: var(--nx-red);
}

.nx-area1.area-tohoku {
  background-color: var(--nx-green);
}

/* ヘッダーセクション - デフォルト */
.nx-header {
  background-color: var(--nx-blue); /* TOKYO デフォルト */
  display: flex;
  flex-direction: column;
  gap: clamp(2rem, 5vw, 3rem);
  padding: clamp(2rem, 5vw, 3rem) clamp(1.5rem, 4vw, 2.5rem);
  overflow: hidden;
  position: relative;
  min-height: 0;
  max-height: 400px;
}

/* ヘッダーエリア別背景色 */
.nx-header.area-none {
  background-color: transparent;
}

.nx-header.area-tokyo {
  background-color: var(--nx-blue);
}

.nx-header.area-osaka {
  background-color: var(--nx-red);
}

.nx-header.area-tohoku {
  background-color: var(--nx-green);
}

/* ベクター非表示時のスペーサー */
.nx-header-spacer {
  background: transparent;
  display: flex;
  flex: 1;
  min-height: 0;
}

.nx-logo {
  width: clamp(80px, 15vw, 126.91px);
  height: auto;
  aspect-ratio: 126.91 / 41.52;
  display: block;
}

.nx-tokyo-visual {
  display: grid;
  place-items: start center;
  flex: 1;
  padding: 0;
}

.nx-tokyo-visual img,
.nx-tokyo-visual svg {
  width: 100%;
  max-width: 753px;
  height: auto;
  aspect-ratio: 753 / 317;
  display: block;
}

/* フッターセクション */
.nx-footer {
  background-color: var(--nx-black);
  display: grid;
}

.nx-timetable {
  background-color: var(--nx-black);
  padding: 0.5rem 1rem;
  color: var(--nx-white);
  font-family: var(--font-family);
  font-size: 0.875rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.nx-footer-buttons {
  background-color: var(--nx-green);
  display: grid;
  grid-template-columns: 1fr 1fr;
  overflow: hidden;
  width: 100%;
}

.nx-day-buttons {
  background-color: var(--nx-white);
  display: grid;
  grid-template-columns: 1fr 1fr;
  height: clamp(60px, 10vw, 91px);
  overflow: hidden;
}

/* DAY2エリア別背景色 */
.nx-header.area-tokyo .nx-day-buttons {
  background-color: var(--nx-blue);
}

.nx-header.area-osaka .nx-day-buttons {
  background-color: var(--nx-red);
}

.nx-header.area-tohoku .nx-day-buttons {
  background-color: var(--nx-green);
}

.nx-day-button {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.625rem;
  cursor: pointer;
  transition: opacity 0.3s ease;
  min-width: 0;
  min-height: 0;
  overflow: hidden;
}

.nx-day-button:hover {
  opacity: 0.8;
}

.nx-day-button img {
  max-width: clamp(125px, 20.75vw, 189px);
  width: 100%;
  height: auto;
  max-height: 100%;
  object-fit: contain;
}

.nx-ticket-button {
  background-color: var(--nx-blue);
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: clamp(0.625rem, 1.5vw, 0.625rem);
  cursor: pointer;
}

.nx-ticket-button img {
  height: clamp(30px, 5vw, 41px);
  width: auto;
  aspect-ratio: 187.12 / 41;
  max-width: 100%;
}

/* 動的ボタン制御CSS */
.nx-day-buttons.day1-only,
.nx-day-buttons.day2-only {
  grid-template-columns: 1fr;
}

.nx-day-buttons.both-days {
  grid-template-columns: 1fr 1fr;
}

.nx-footer-buttons.no-ticket {
  grid-template-columns: 1fr;
}

.nx-footer-buttons.has-ticket {
  grid-template-columns: 1fr 1fr;
  background-color: transparent !important;
}

/* エリア2：コンテンツエリア */
.nx-area2 {
  background-color: var(--nx-black);
  padding: var(--area2-padding);
  display: grid;
  grid-template-rows: auto 1fr; /* 固定領域内スクロール: heading + 残り領域 */
  gap: 0;
  container-type: inline-size;
  container-name: nx-content;
}

/* 見出しセクション */
.nx-heading {
  padding: clamp(3rem, 8vw, 4.875rem) 0;
  max-height: 404px;
}

.nx-heading h1 {
  font-family: var(--font-family);
  font-weight: 900;
  font-size: var(--title-size);
  line-height: 1.2;
  color: var(--nx-white);
  letter-spacing: var(--title-spacing);
  margin: 0;
}

/* コンテンツブロック（最適化済み） */
.nx-content-blocks {
  display: grid;
  grid-template-columns: 1fr;
  grid-auto-rows: auto; /* 内容に応じた自動高さ */
  width: 100%;
  /* スクロールバー非表示設定（機能は維持） */
  scrollbar-width: none; /* Firefox用 */
  -ms-overflow-style: none; /* IE/Edge用 */
  outline: none;
}

/* Webkit系ブラウザ用スクロールバー非表示 */
.nx-content-blocks::-webkit-scrollbar {
  display: none;
  width: 0;
  height: 0;
}

.nx-content-blocks:focus-visible {
  outline: 2px solid var(--nx-green);
  outline-offset: -2px;
}

.nx-content-block {
  display: grid;
  grid-template-columns: 1fr;
  border-top: 1px solid var(--nx-white);
  /* 高さ制約を完全に除去 - 内容に完全適応 */
}

/* 768px以上：2カラムレイアウトのみ */
@container nx-content (min-width: 768px) {
  .nx-content-block {
    grid-template-columns: minmax(200px, 396px) 1fr;
  }
}

.nx-block-title,
.nx-block-content {
  padding: clamp(0.5rem, 2vw, 1rem); /* より柔軟なpadding：短いコンテンツでも適切な余白 */
  display: flex;
  align-items: flex-start;
}

.nx-block-title h3,
.nx-block-content p {
  font-family: var(--font-family);
  font-weight: 400;
  color: var(--nx-white);
  margin: 0;
  word-wrap: break-word;        /* 長い単語を強制改行 */
  overflow-wrap: break-word;    /* 現代的な折り返し制御 */
  word-break: break-word;       /* 日本語対応の改行制御 */
  hyphens: auto;               /* ハイフネーション有効 */
}

.nx-block-title h3 {
  font-size: var(--content-title-size);
  line-height: var(--content-line-height);
}

.nx-block-content p {
  font-size: var(--content-text-size);
  line-height: var(--content-line-height);
}

/* モバイルレイアウト（767px以下） */
@media (max-width: 767px) {
  .nx-tokyo-wrapper {
    grid-template-rows: auto 1fr;
  }
  
  .nx-area1 {
    height: 100svh;
    height: 100dvh;
    height: 100vh;
    min-height: 100vh;
  }
  
  .nx-header {
    max-height: 300px;
  }
  
  /* モバイルでは1カラム（デフォルトのまま） */
  
  .nx-block-title {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding-bottom: 2rem; /* タイトルとコンテンツ間の余白を拡張 */
  }
}

/* デスクトップレイアウト（768px以上） */
@media (min-width: 768px) {
  .nx-heading {
    padding-top: 0; /* デスクトップ幅で上部paddingを除去 */
  }
}

/* 背景メディア設定 */
.nx-area1[data-bg-type="image"] {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.nx-bg-video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -1;
}

.nx-area1[data-bg-type="default"] {
  background-color: var(--nx-red);
}

/* 重複したスクロールバー設定を削除 - 上記.nx-content-blocksブロックに統合済み */

/* アクセシビリティとCLS対策 */
img, svg {
  max-width: 100%;
  height: auto;
}

.nx-tokyo-container * {
  box-sizing: border-box;
}

/* フォント読み込み最適化 */
/* フォント読み込みはstyle.cssのGoogle Fonts CDNを使用 */

/* DAY2エリア別背景色 - MAIN CSS */
.nx-tokyo-container.area-none .dancers-section__day--day2 {
  background-color: transparent !important; /* なし: 透明 */
}

.nx-tokyo-container.area-tokyo .dancers-section__day--day2 {
  background-color: #0000FF !important; /* TOKYO: 青 */
}

.nx-tokyo-container.area-osaka .dancers-section__day--day2 {
  background-color: #FF0000 !important; /* OSAKA: 赤 */
}

.nx-tokyo-container.area-tohoku .dancers-section__day--day2 {
  background-color: #00FF6A !important; /* TOHOKU: 緑 */
}
</style>

<script>
// DAY2セクション背景色JavaScriptフォールバック
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.nx-tokyo-container');
    const day2Section = document.querySelector('.dancers-section__day--day2');
    
    if (container && day2Section) {
        let bgColor = '#0000FF'; // デフォルト: TOKYO 青
        
        if (container.classList.contains('area-none')) {
            bgColor = 'transparent'; // なし 透明
        } else if (container.classList.contains('area-osaka')) {
            bgColor = '#FF0000'; // OSAKA 赤
        } else if (container.classList.contains('area-tohoku')) {
            bgColor = '#00FF6A'; // TOHOKU 緑
        }
        
        day2Section.style.setProperty('background-color', bgColor, 'important');
        console.log('DAY2背景色をJavaScriptで設定:', bgColor);
    }
});
</script>

<?php 
// エリア選択の事前取得（コンテナクラス用）
$area_selection = get_field('nx_area_selection') ?: 'none';
$area_configs = array(
    'none' => 'area-none',
    'tokyo' => 'area-tokyo',
    'osaka' => 'area-osaka', 
    'tohoku' => 'area-tohoku'
);
$container_area_class = $area_configs[$area_selection];
?>

<div class="nx-tokyo-container <?php echo esc_attr($container_area_class); ?>">
  <?php while (have_posts()) : the_post(); ?>
    <?php
    // ACFフィールドの取得
    $event_title = get_field('nx_event_title') ?: 'STEPJAM TOKYO';
    $event_subtitle = get_field('nx_event_subtitle') ?: '2025 SUMMER';
    $content_blocks = get_field('nx_content_blocks');
    $area_selection = get_field('nx_area_selection') ?: 'none';
    $day1_link = get_field('nx_day1_link');
    $day2_link = get_field('nx_day2_link');
    $ticket_link = get_field('nx_ticket_link');
    
    // 表示制御フィールド
    $header_show = get_field('nx_header_show');
    // デフォルトはtrue（既存の投稿との互換性のため）
    if ($header_show === null) {
        $header_show = true;
    }
    
    // 背景メディア設定
    $bg_image = get_field('nx_background_image');
    $bg_video = get_field('nx_background_video');
    $bg_priority = get_field('nx_background_priority') ?: 'image';
    
    // エリア別設定配列
    $area_configs = array(
        'none' => array(
            'vector' => '',
            'class' => 'area-none',
            'color' => 'transparent'
        ),
        'tokyo' => array(
            'vector' => get_template_directory_uri() . '/assets/images/nx-tokyo-vector.svg',
            'class' => 'area-tokyo',
            'color' => 'blue'
        ),
        'osaka' => array(
            'vector' => get_template_directory_uri() . '/assets/images/osaka/osaka.svg',
            'class' => 'area-osaka',
            'color' => 'red'
        ),
        'tohoku' => array(
            'vector' => get_template_directory_uri() . '/assets/images/tohoku/tohoku.svg',
            'class' => 'area-tohoku',
            'color' => 'green'
        )
    );
    
    // 選択されたエリアの設定を取得
    $current_area = $area_configs[$area_selection];
    $area_vector_path = $current_area['vector'];
    $area_class = $current_area['class'];
    $area_color = $current_area['color'];
    
    // その他のパス設定
    $stepjam_logo_path = get_template_directory_uri() . '/assets/header/header-logo.svg';
    $d1_bt_path = get_template_directory_uri() . '/assets/images/nx-tokyo/d1-bt.svg';
    $d2_bt_path = get_template_directory_uri() . '/assets/images/nx-tokyo/d2-bt.svg';
    $ticket_bt_path = get_template_directory_uri() . '/assets/images/nx-tokyo/nxtokyo-ticket-bt.svg';
    
    // TIME TABLE表示判定（DAY1またはDAY2いずれか入力時のみ）
    $show_timetable = !empty($day1_link) || !empty($day2_link);
    
    // 動的ボタン制御ロジック
    $has_day1 = !empty($day1_link);
    $has_day2 = !empty($day2_link);
    $has_ticket = !empty($ticket_link);
    $has_any_button = $has_day1 || $has_day2 || $has_ticket;
    
    // DAY1/DAY2ボタンの動的クラス制御
    $day_buttons_class = '';
    if ($has_day1 && $has_day2) {
        $day_buttons_class = 'both-days';
    } elseif ($has_day1 && !$has_day2) {
        $day_buttons_class = 'day1-only';
    } elseif (!$has_day1 && $has_day2) {
        $day_buttons_class = 'day2-only';
    }
    
    // フッターボタンエリアの動的クラス制御
    $footer_buttons_class = '';
    if ($has_ticket) {
        $footer_buttons_class = 'has-ticket';
    } else {
        $footer_buttons_class = 'no-ticket';
    }
    
    // 背景メディア表示判定
    $display_type = 'default'; // 青背景(#0000FF)
    $bg_style = '';
    
    if ($bg_priority === 'image') {
        if ($bg_image) {
            $display_type = 'image';
            $bg_style = 'background-image: url(' . esc_url($bg_image['url']) . ');';
        } elseif ($bg_video) {
            $display_type = 'video';
        }
    } else { // video priority
        if ($bg_video) {
            $display_type = 'video';
        } elseif ($bg_image) {
            $display_type = 'image';
            $bg_style = 'background-image: url(' . esc_url($bg_image['url']) . ');';
        }
    }
    ?>
    
    <div class="nx-tokyo-wrapper">
      <!-- nx-area1: ビジュアルエリア -->
      <section class="nx-area1 <?php echo esc_attr($area_class); ?>" aria-label="ビジュアルエリア" data-bg-type="<?php echo esc_attr($display_type); ?>" <?php if ($display_type === 'image') echo 'style="' . esc_attr($bg_style) . '"'; ?>>
        <?php if ($display_type === 'video') : ?>
          <video class="nx-bg-video" autoplay muted loop playsinline aria-label="背景動画" role="img">
            <source src="<?php echo esc_url($bg_video['url']); ?>" type="video/mp4">
          </video>
        <?php endif; ?>
        
        <?php if ($header_show && $area_selection && $area_selection !== 'none') : ?>
        <div class="nx-header <?php echo esc_attr($area_class); ?>">
          <div class="nx-logo">
            <img src="<?php echo esc_url($stepjam_logo_path); ?>" 
                 alt="STEPJAM"
                 width="97"
                 height="22">
          </div>
          
          <div class="nx-area-visual">
            <img src="<?php echo esc_url($area_vector_path); ?>" 
                 alt="<?php echo esc_attr(strtoupper($area_selection)); ?>"
                 width="753"
                 height="317">
          </div>
        </div>
        <?php elseif (!$header_show || ($area_selection === 'none')) : ?>
        <div class="nx-header-spacer"></div>
        <?php endif; ?>
        
        <?php if ($has_any_button) : ?>
        <div class="nx-footer">
          <?php if ($show_timetable) : ?>
          <div class="nx-timetable">
            <span>TIME TABLE</span>
            <span>▼</span>
          </div>
          <?php endif; ?>
          
          <div class="nx-footer-buttons <?php echo esc_attr($footer_buttons_class); ?>">
            <?php if ($has_day1 || $has_day2) : ?>
            <div class="nx-day-buttons <?php echo esc_attr($day_buttons_class); ?>">
              <?php if ($has_day1) : ?>
              <a href="<?php echo esc_url($day1_link); ?>" class="nx-day-button" aria-label="DAY1">
                <img src="<?php echo esc_url($d1_bt_path); ?>" alt="DAY1" width="193" height="93">
              </a>
              <?php endif; ?>
              <?php if ($has_day2) : ?>
              <a href="<?php echo esc_url($day2_link); ?>" class="nx-day-button" aria-label="DAY2">
                <img src="<?php echo esc_url($d2_bt_path); ?>" alt="DAY2" width="193" height="93">
              </a>
              <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($has_ticket) : ?>
            <a href="<?php echo esc_url($ticket_link); ?>" class="nx-ticket-button" aria-label="チケット購入">
              <img src="<?php echo esc_url($ticket_bt_path); ?>" alt="ticket" width="187" height="41">
            </a>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
      </section>
      
      <!-- nx-area2: コンテンツエリア -->
      <section class="nx-area2" aria-label="コンテンツエリア">
        <div class="nx-heading">
          <h1>
            <?php echo esc_html($event_title); ?><br>
            <?php echo esc_html($event_subtitle); ?>
          </h1>
        </div>
        
        <?php if ($content_blocks) : ?>
          <div class="nx-content-blocks" tabindex="0" aria-label="コンテンツエリア">
            <?php foreach ($content_blocks as $block) : ?>
              <article class="nx-content-block">
                <div class="nx-block-title">
                  <h3><?php echo esc_html($block['block_type']); ?></h3>
                </div>
                <div class="nx-block-content">
                  <p><?php echo nl2br(esc_html($block['content'])); ?></p>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </section>
    </div>
    
  <?php endwhile; ?>
</div>

<!-- Dancers Section -->
<?php get_template_part('template-parts/dancers-section'); ?>

<?php
get_footer();
?>