<?php
/**
 * Sponsor Logo Slider Template Part
 * 
 * Reusable module for sponsor logo slider display
 * 
 * @package STEPJAM_Theme
 * 
 * Parameters (via $args):
 * @param string $slider_class   CSS class for logo slider (logo-slider-desktop/mobile)
 * @param array  $sponsor_logos  Array of sponsor logo data (ACF format)
 * @param string $device_type    'desktop' or 'mobile' - For alt text differentiation
 */

// Extract parameters with defaults and error handling
$slider_class = $args['slider_class'] ?? 'logo-slider-desktop';
$sponsor_logos = null;
$device_type = $args['device_type'] ?? 'desktop';

// Safe ACF field retrieval
if (isset($args['sponsor_logos'])) {
    $sponsor_logos = $args['sponsor_logos'];
} elseif (function_exists('get_field')) {
    $sponsor_logos = get_field('sponsors_slides', 'option');
}

// Ensure sponsor_logos is an array
$sponsor_logos = is_array($sponsor_logos) ? $sponsor_logos : array();

// Alt text prefix for mobile differentiation
$alt_prefix = ($device_type === 'mobile') ? 'Mobile Sponsor ' : 'Sponsor ';
?>

<!-- Logo Slider Right (Priority 2) -->
<div class="sponsor-logo-right">
    
    <!-- Sponsor Logo Box -->
    <div class="absolute top-[clamp(15%,19.1%,25%)] left-0 w-full h-[clamp(55%,61.7%,70%)] overflow-hidden">
        
        <!-- Logo Swiper Container -->
        <div class="swiper <?php echo esc_attr($slider_class); ?> w-full h-full">
            <div class="swiper-wrapper">
                
                <?php 
                if (!empty($sponsor_logos)) :
                    foreach ($sponsor_logos as $index => $logo_item) : 
                        // Safe field access with defaults
                        $logo_image = isset($logo_item['sponsor_logo']) ? $logo_item['sponsor_logo'] : null;
                        $logo_alt = isset($logo_item['sponsor_name']) ? $logo_item['sponsor_name'] : '';
                        $logo_url = isset($logo_item['sponsor_url']) ? $logo_item['sponsor_url'] : '';
                        $logo_target = '_blank'; // デフォルト値として設定
                        
                        if ($logo_image && is_array($logo_image) && isset($logo_image['url'])) : ?>
                            <div class="swiper-slide">
                                <div class="w-full h-full min-w-0">
                                    <?php if ($logo_url) : ?>
                                        <a href="<?php echo esc_url($logo_url); ?>" 
                                           target="<?php echo esc_attr($logo_target); ?>"
                                           rel="<?php echo ($logo_target === '_blank') ? 'noopener noreferrer' : ''; ?>"
                                           class="block w-full h-full">
                                    <?php endif; ?>
                                    <img src="<?php echo esc_url($logo_image['url']); ?>" 
                                         alt="<?php echo esc_attr($logo_alt ?: $logo_image['alt'] ?: $alt_prefix . ($index + 1)); ?>" 
                                         class="w-full h-full object-contain">
                                    <?php if ($logo_url) : ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif;
                    endforeach;
                else: ?>
                    <!-- スポンサーデータが空の場合のデフォルトスライド -->
                    <div class="swiper-slide">
                        <div class="w-full h-full min-w-0 flex items-center justify-center">
                            <div class="text-white text-sm opacity-50">
                                スポンサー情報を設定してください
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>