<?php
/**
 * Sponsor Logo Slide Area Template Part (38% Zone Only)
 * 
 * Modular component for sponsor content display with logo slider
 * Designed for 38% lower area of sponsor-section-container
 * 
 * @package STEPJAM_Theme
 * 
 * Parameters (via $args):
 * @param string $device_type        'desktop' or 'mobile' - Controls display order
 * @param string $content_image_path Image path for sponsor content
 * @param string $content_image_alt  Alt text for content image
 * @param string $slider_class       CSS class for logo slider (logo-slider-desktop/mobile)
 * @param array  $sponsor_logos      Array of sponsor logo data (ACF format)
 */

// Extract parameters with defaults
$device_type = $args['device_type'] ?? 'desktop';
$content_image_path = $args['content_image_path'] ?? get_template_directory_uri() . '/assets/spon/spon-cont-img.png';
$content_image_alt = $args['content_image_alt'] ?? 'Sponsor Content';
$slider_class = $args['slider_class'] ?? ('logo-slider-' . $device_type);
$sponsor_logos = $args['sponsor_logos'] ?? get_field('sponsors_slides', 'option');

// Mobile alt text adjustment
if ($device_type === 'mobile' && $content_image_alt === 'Sponsor Content') {
    $content_image_alt = 'Mobile Sponsor Content';
}
?>

<!-- Sponsor Logo Slide Area (38% Zone) - <?php echo ucfirst($device_type); ?> -->
<div class="sponsor-content-container">
    
    <?php if ($device_type === 'desktop') : ?>
        <!-- Desktop Order: Content Left → Logo Right -->
        
        <!-- Sponsor Content Left (Priority 3) -->
        <div class="sponsor-content-left">
            
            <!-- Sponsor Content Image -->
            <div class="w-[clamp(55%,calc(65% + 1vw),85%)] h-[clamp(40%,46.7%,55%)] flex items-center justify-center">
                <img src="<?php echo esc_url($content_image_path); ?>" 
                     alt="<?php echo esc_attr($content_image_alt); ?>" 
                     class="w-full h-full object-contain">
            </div>
        </div>
        
        <!-- Logo Slider Right (Priority 2) -->
        <?php get_template_part('template-parts/sponsor-logo-slider', null, array(
            'slider_class' => $slider_class,
            'sponsor_logos' => $sponsor_logos,
            'device_type' => $device_type
        )); ?>
        
    <?php else : ?>
        <!-- Mobile Order: Logo Right → Content Left -->
        
        <!-- Mobile Sponsor Logo Slider -->
        <?php get_template_part('template-parts/sponsor-logo-slider', null, array(
            'slider_class' => $slider_class,
            'sponsor_logos' => $sponsor_logos,
            'device_type' => $device_type
        )); ?>
        
        <!-- Mobile Sponsor Content Title/Image -->
        <div class="sponsor-content-left">
            
            <!-- Mobile Sponsor Content Image -->
            <div class="w-[clamp(55%,calc(65% + 1vw),85%)] h-[clamp(40%,46.7%,55%)] flex items-center justify-center">
                <img src="<?php echo esc_url($content_image_path); ?>" 
                     alt="<?php echo esc_attr($content_image_alt); ?>" 
                     class="w-full h-full object-contain">
            </div>
        </div>
        
    <?php endif; ?>
    
</div>