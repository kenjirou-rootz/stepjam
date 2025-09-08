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

// Extract parameters with defaults
$slider_class = $args['slider_class'] ?? 'logo-slider-desktop';
$sponsor_logos = $args['sponsor_logos'] ?? get_field('sponsors_slides', 'option');
$device_type = $args['device_type'] ?? 'desktop';

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
                if ($sponsor_logos && is_array($sponsor_logos)) :
                    foreach ($sponsor_logos as $index => $logo_item) : 
                        $logo_image = $logo_item['sponsor_logo'];
                        $logo_alt = $logo_item['sponsor_name'];
                        $logo_url = $logo_item['sponsor_url'];
                        $logo_target = '_blank'; // デフォルト値として設定
                        
                        if ($logo_image) : ?>
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
                endif; ?>
            </div>
        </div>
    </div>
</div>