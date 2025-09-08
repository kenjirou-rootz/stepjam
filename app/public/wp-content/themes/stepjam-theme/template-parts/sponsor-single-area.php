<?php
/**
 * Single Toroku Dancer Sponsor Area Template Part
 * 
 * Complete independent template for single-toroku-dancer.php only
 * Same structure as sponsor-logoslide-area.php but entirely separate codebase
 * Designed for full-height display (100% zone usage)
 * 
 * @package STEPJAM_Theme
 * 
 * Parameters (via $args):
 * @param string $device_type        'desktop' or 'mobile' - Controls display order
 * @param string $content_image_path Image path for sponsor content
 * @param string $content_image_alt  Alt text for content image
 * @param string $slider_class       CSS class for single logo slider
 * @param array  $sponsor_logos      Array of sponsor logo data (ACF format)
 */

// Extract parameters with defaults - Independent implementation
$device_type = $args['device_type'] ?? 'desktop';
$content_image_path = $args['content_image_path'] ?? get_template_directory_uri() . '/assets/spon/spon-cont-img.png';
$content_image_alt = $args['content_image_alt'] ?? 'Single Dancer Sponsor Content';
$slider_class = $args['slider_class'] ?? ('single-logo-slider-' . $device_type);
$sponsor_logos = $args['sponsor_logos'] ?? get_field('sponsors_slides', 'option');

// Mobile alt text adjustment - Independent implementation
if ($device_type === 'mobile' && $content_image_alt === 'Single Dancer Sponsor Content') {
    $content_image_alt = 'Single Dancer Mobile Sponsor Content';
}
?>

<!-- Single Dancer Sponsor Area (Full Zone) - <?php echo ucfirst($device_type); ?> -->
<div class="sponsor-content-container single-dancer-sponsor">
    
    <?php if ($device_type === 'desktop') : ?>
        <!-- Desktop Order: Content Left → Logo Right -->
        
        <!-- Single Dancer Sponsor Content Left -->
        <div class="sponsor-content-left single-content-left">
            
            <!-- Single Dancer Sponsor Content Image -->
            <div class="w-[clamp(55%,calc(65% + 1vw),85%)] h-[clamp(40%,46.7%,55%)] flex items-center justify-center">
                <img src="<?php echo esc_url($content_image_path); ?>" 
                     alt="<?php echo esc_attr($content_image_alt); ?>" 
                     class="w-full h-full object-contain single-sponsor-image">
            </div>
        </div>
        
        <!-- Single Dancer Logo Slider Right -->
        <?php get_template_part('template-parts/sponsor-logo-slider', null, array(
            'slider_class' => $slider_class,
            'sponsor_logos' => $sponsor_logos,
            'device_type' => $device_type
        )); ?>
        
    <?php else : ?>
        <!-- Mobile Order: Logo Right → Content Left -->
        
        <!-- Single Dancer Mobile Sponsor Logo Slider -->
        <?php get_template_part('template-parts/sponsor-logo-slider', null, array(
            'slider_class' => $slider_class,
            'sponsor_logos' => $sponsor_logos,
            'device_type' => $device_type
        )); ?>
        
        <!-- Single Dancer Mobile Sponsor Content Title/Image -->
        <div class="sponsor-content-left single-content-left">
            
            <!-- Single Dancer Mobile Sponsor Content Image -->
            <div class="w-[clamp(55%,calc(65% + 1vw),85%)] h-[clamp(40%,46.7%,55%)] flex items-center justify-center">
                <img src="<?php echo esc_url($content_image_path); ?>" 
                     alt="<?php echo esc_attr($content_image_alt); ?>" 
                     class="w-full h-full object-contain single-sponsor-image">
            </div>
        </div>
        
    <?php endif; ?>
    
</div>