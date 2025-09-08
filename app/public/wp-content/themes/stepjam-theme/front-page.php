<?php
/**
 * The front page template file
 * 
 * @package STEPJAM_Theme
 */

get_header(); ?>

<!-- Responsive Scale Wrapper - Ultra Think Implementation -->
<div class="site-responsive-wrapper">

    <main class="site-main relative w-full bg-black">
        
        <!-- Hero Section (Node: 113:6263) - レスポンシブガイド準拠 -->
        <section id="hero-section" class="relative w-full bg-black overflow-hidden" 
                 style="height: 67.5rem;" 
                >
            
            <!-- Desktop Hero Frame: 1920px × 1080px -->
            <div class="hidden tablet:block relative w-full h-hero-full">
                <!-- Hero FV Section (Node: 155:314) - 中央配置・ボーダー付き -->
                <div class="absolute inset-x-0 top-[208px] w-full h-hero-fv border border-white">
                    <!-- Make The Moment Logo (Node: 114:7293) - レスポンシブガイド準拠 -->
                    <div class="relative h-full flex items-center justify-center">
                        <div class="relative" 
                             style="width: clamp(55%, 61.5%, 70%); min-width: 300px; aspect-ratio: 1180.38/199.66;">
                            <?php 
                            $hero_logo = get_field('hero_logo');
                            $hero_logo_alt = get_field('hero_logo_alt');
                            if ($hero_logo) : ?>
                                <img src="<?php echo esc_url($hero_logo); ?>" 
                                     alt="<?php echo esc_attr($hero_logo_alt ?: 'make the moment'); ?>" 
                                     class="w-full h-full object-contain" />
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/hero/make-the-moment.svg'); ?>" 
                                     alt="make the moment" 
                                     class="w-full h-full object-contain" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
                
            <!-- Mobile Hero Frame: 768px × 1080px -->
            <div class="block tablet:hidden relative w-full h-hero-full">
                <!-- SP Hero Box (Node: 158:95) - y軸中央配置・ボーダー付きエリア -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 border border-white" 
                     style="width: clamp(90%, 95%, 100%); height: clamp(400px, 665.86px, 70vh);"
                    >
                    
                    <!-- Make The Moment Logo Mobile (Node: 158:96) - レスポンシブガイド準拠 -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" 
                         style="width: clamp(60%, 70%, 85%); min-width: 250px; aspect-ratio: 1180.38/199.66;"
                        >
                        <?php if ($hero_logo) : ?>
                            <img src="<?php echo esc_url($hero_logo); ?>" 
                                 alt="<?php echo esc_attr($hero_logo_alt ?: 'make the moment'); ?>" 
                                 class="w-full h-full object-contain" />
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/hero/make-the-moment.svg'); ?>" 
                                 alt="make the moment" 
                                 class="w-full h-full object-contain" />
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </section>
        
        <!-- Sponsor Section - MCP Verified Implementation -->
        <!-- Desktop Sponsor Section (Node: 156:330) - Responsive Grid Layout -->
        <section id="sponsor-section" class="hidden tablet:block relative w-full bg-black overflow-hidden"
                 style="height: 67.5rem;"
                >
            <div class="sponsor-section-container">
                
                <!-- Desktop Main Slider (Node: 156:712) - Priority 1 -->
                <div class="sponsor-main-slider"
                    >
                    
                    <!-- Swiper Container -->
                    <div class="swiper main-slider-desktop w-full h-full">
                        <div class="swiper-wrapper">
                            
                            <!-- Slide 01 (Node: 156:713) -->
                            <div class="swiper-slide flex items-center justify-center">
                                <div class="bg-red-500 rounded-[51px] w-full h-full"
                                    >
                                    <?php 
                                    $sponsor_main_video_01 = get_field('sponsor_main_video_01', 'option');
                                    if ($sponsor_main_video_01) : 
                                        $video_url = is_array($sponsor_main_video_01) ? $sponsor_main_video_01['url'] : $sponsor_main_video_01;
                                    ?>
                                        <video 
                                            class="w-full h-full object-cover rounded-[51px]" 
                                            autoplay 
                                            muted 
                                            loop
                                           >
                                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                                        </video>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-black/20 flex items-center justify-center rounded-[51px]">
                                            <span class="text-white/60 text-lg">Main Video 1</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Slide 02 (Node: 156:714) -->
                            <div class="swiper-slide flex items-center justify-center">
                                <div class="bg-red-500 rounded-[51px] w-full h-full"
                                    >
                                    <?php 
                                    $sponsor_main_video_02 = get_field('sponsor_main_video_02', 'option');
                                    if ($sponsor_main_video_02) : ?>
                                        <video 
                                            class="w-full h-full object-cover rounded-[51px]" 
                                            autoplay 
                                            muted 
                                            loop
                                           >
                                            <source src="<?php echo esc_url(is_array($sponsor_main_video_02) ? $sponsor_main_video_02['url'] : $sponsor_main_video_02); ?>" type="video/mp4">
                                        </video>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-black/20 flex items-center justify-center rounded-[51px]">
                                            <span class="text-white/60 text-lg">Main Video 2</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Slide 03 (Node: 156:715) -->
                            <div class="swiper-slide flex items-center justify-center">
                                <div class="bg-red-500 rounded-[51px] w-full h-full"
                                    >
                                    <?php 
                                    $sponsor_main_video_03 = get_field('sponsor_main_video_03', 'option');
                                    if ($sponsor_main_video_03) : ?>
                                        <video 
                                            class="w-full h-full object-cover rounded-[51px]" 
                                            autoplay 
                                            muted 
                                            loop
                                           >
                                            <source src="<?php echo esc_url(is_array($sponsor_main_video_03) ? $sponsor_main_video_03['url'] : $sponsor_main_video_03); ?>" type="video/mp4">
                                        </video>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-black/20 flex items-center justify-center rounded-[51px]">
                                            <span class="text-white/60 text-lg">Main Video 3</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sponsor Content Container - Modularized -->
                <?php get_template_part('template-parts/sponsor-logoslide-area', null, array(
                    'device_type' => 'desktop',
                    'slider_class' => 'logo-slider-desktop'
                )); ?>
            </div>
        </section>
        
        <!-- Mobile Sponsor Section (Node: 158:81) - Responsive Mobile Layout -->
        <section class="block tablet:hidden relative w-full bg-black overflow-hidden"
                 style="height: 67.5rem;"
                >
            <div class="sponsor-section-container">
                
                <!-- Mobile Main Slider (Node: 158:90) -->
                <div class="sponsor-main-slider"
                    >
                    
                    <!-- Mobile Swiper Container -->
                    <div class="swiper main-slider-mobile w-full h-full">
                        <div class="swiper-wrapper">
                            
                            <!-- Mobile Slide 01 (Node: 158:93) -->
                            <div class="swiper-slide flex items-center justify-center">
                                <div class="bg-red-500 rounded-[51px] w-full h-full"
                                    >
                                    <?php 
                                    $sponsor_main_video_01 = get_field('sponsor_main_video_01', 'option');
                                    if ($sponsor_main_video_01) : ?>
                                        <video 
                                            class="w-full h-full object-cover rounded-[51px]" 
                                            autoplay 
                                            muted 
                                            loop
                                           >
                                            <source src="<?php echo esc_url(is_array($sponsor_main_video_01) ? $sponsor_main_video_01['url'] : $sponsor_main_video_01); ?>" type="video/mp4">
                                        </video>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-black/20 flex items-center justify-center rounded-[51px]">
                                            <span class="text-white/60 text-sm">Mobile Video 1</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Mobile Slide 02 (Node: 158:92) -->
                            <div class="swiper-slide flex items-center justify-center">
                                <div class="bg-red-500 rounded-[51px] w-full h-full"
                                    >
                                    <?php 
                                    $sponsor_main_video_02 = get_field('sponsor_main_video_02', 'option');
                                    if ($sponsor_main_video_02) : ?>
                                        <video 
                                            class="w-full h-full object-cover rounded-[51px]" 
                                            autoplay 
                                            muted 
                                            loop
                                           >
                                            <source src="<?php echo esc_url(is_array($sponsor_main_video_02) ? $sponsor_main_video_02['url'] : $sponsor_main_video_02); ?>" type="video/mp4">
                                        </video>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-black/20 flex items-center justify-center rounded-[51px]">
                                            <span class="text-white/60 text-sm">Mobile Video 2</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Mobile Slide 03 (Node: 158:91) -->
                            <div class="swiper-slide flex items-center justify-center">
                                <div class="bg-red-500 rounded-[51px] w-full h-full"
                                    >
                                    <?php 
                                    $sponsor_main_video_03 = get_field('sponsor_main_video_03', 'option');
                                    if ($sponsor_main_video_03) : ?>
                                        <video 
                                            class="w-full h-full object-cover rounded-[51px]" 
                                            autoplay 
                                            muted 
                                            loop
                                           >
                                            <source src="<?php echo esc_url(is_array($sponsor_main_video_03) ? $sponsor_main_video_03['url'] : $sponsor_main_video_03); ?>" type="video/mp4">
                                        </video>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-black/20 flex items-center justify-center rounded-[51px]">
                                            <span class="text-white/60 text-sm">Mobile Video 3</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Sponsor Container - Modularized -->
                <?php get_template_part('template-parts/sponsor-logoslide-area', null, array(
                    'device_type' => 'mobile',
                    'slider_class' => 'logo-slider-mobile'
                )); ?>
            </div>
        </section>
        
        <!-- WHSJ Section (Node: 156:480 Desktop / 158:68 Mobile) -->
        <!-- Desktop WHSJ Section (Node: 156:480) - Responsive Grid Layout -->
        <section id="whsj-section" class="hidden tablet:block relative w-full bg-black min-h-screen"
                >
            <div class="whsj-section-container">
                
                <!-- Video Area (Left Top) -->
                <div class="whsj-video-area">
                    <?php 
                    $whsj_video = get_field('whsj_video', 'option');
                    if ($whsj_video) : ?>
                        <video 
                            class="w-full h-full object-cover" 
                            autoplay 
                            muted 
                            loop>
                            <source src="<?php echo esc_url(is_array($whsj_video) ? $whsj_video['url'] : $whsj_video); ?>" type="video/mp4">
                        </video>
                    <?php else : ?>
                        <div class="w-full h-full bg-black/20 flex items-center justify-center">
                            <span class="text-white/60 text-lg">Desktop Video</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Vector Area (Left Bottom) -->
                <div class="whsj-vector-area">
                    <div class="scale-y-[-100%] w-full h-full">
                        <div class="bg-transparent relative w-full h-full"
                            >
                            <!-- WHSJ Image 01 (Node: 156:483) -->
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="scale-y-[-100%] w-full h-full">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/whsj/whsj-img01.png'); ?>" 
                                         alt="WHSJ Content Image" 
                                         class="block w-full h-full object-contain">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Content Area (Center) -->
                <div class="whsj-content-area"
                    >
                    
                    <!-- WHSJ TX Box 01 (Node: 156:490) -->
                    <div class="flex justify-center w-full"
                        >
                        <div class="scale-y-[-100%] w-full max-w-sm">
                            <div class="bg-transparent overflow-hidden relative aspect-[327/252]">
                                <!-- WHSJ TX Box 01 A (Node: 156:491) -->
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-[30%]">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/whsj/whsj-tx-box-01-a.svg'); ?>" 
                                         alt="Promotion Title" 
                                         class="block w-full h-full object-contain">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- WHSJ Text Content (Node: 156:489) -->
                    <div class="w-full"
                        >
                        <div class="font-['Noto_Sans_JP'] font-extralight text-white text-justify leading-snug tracking-wider"
                             style="font-size: clamp(0.875rem, 1.2vw, 1.125rem); line-height: 1.375; letter-spacing: 0.05em;">
                            <?php 
                            $whsj_text_content = get_field('whsj_text_content', 'option');
                            if ($whsj_text_content) : ?>
                                <p class="block leading-snug">
                                    <?php echo nl2br(esc_html($whsj_text_content)); ?>
                                </p>
                            <?php else : ?>
                                <p class="block leading-snug">
                                    ここにテキストがはいります。ここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいります
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Sono Area (Right) -->
                <div class="whsj-sono-area">
                    <div class="rotate-180 scale-y-[-100%] w-full h-full flex items-center justify-center">
                        <div class="relative w-full h-full">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/whsj/whsj-sono-box.svg'); ?>" 
                                 alt="WHSJ Sono Box" 
                                 class="block w-full h-full object-contain object-center">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Mobile WHSJ Section (Node: 158:68) - 768px × 1080px -->
        <section class="block tablet:hidden relative w-full bg-black overflow-hidden h-hero-full"
                >
            <div class="w-full relative h-full">
                
                <!-- WHSJ Video Box Mobile (Node: 158:71) -->
                <div class="absolute left-1/2 translate-x-[-50%] w-full h-hero-fv top-0"
                    >
                    <div class="w-full h-full flex items-center justify-center">
                        <?php 
                        $whsj_video = get_field('whsj_video', 'option');
                        if ($whsj_video) : ?>
                            <video 
                                class="w-full h-full object-cover" 
                                autoplay 
                                muted 
                                loop>
                                <source src="<?php echo esc_url(is_array($whsj_video) ? $whsj_video['url'] : $whsj_video); ?>" type="video/mp4">
                            </video>
                        <?php else : ?>
                            <div class="w-full h-full bg-black/20 flex items-center justify-center">
                                <span class="text-white/60 text-sm">Mobile Video</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- WHSJ Content 01 Mobile (Node: 158:72) - 768px × 1081px -->
                <div class="absolute bg-transparent overflow-hidden w-full h-full"
                    >
                    
                    <!-- WHSJ Sono Box Mobile (Node: 158:73) - Responsive -->
                    <div class="absolute flex items-center justify-center right-0 top-0 w-2/5 h-full hidden">
                        <div class="flex-none rotate-180 scale-y-[-100%]">
                            <div class="bg-transparent w-full h-full">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/whsj/whsj-sono-box.svg'); ?>" 
                                     alt="WHSJ Sono Box Mobile" 
                                     class="block w-full h-full object-cover object-center">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ve Sono Mobile (Node: 158:74) - Fixed aspect ratio and responsive -->
                    <div class="absolute right-0 top-0 z-10"
                         style="width: clamp(120px, 20vw, 200px); height: 100%; aspect-ratio: 156.17/1181.45;">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/whsj/ve-sono.svg'); ?>" 
                             alt="Ve Sono Mobile" 
                             class="w-full h-full object-contain">
                    </div>
                    
                    <!-- WHSJ Text Box Mobile (Node: 158:75) - Responsive width -->
                    <div class="absolute bg-black bg-opacity-60 overflow-hidden shadow-md"
                         style="left: 0; top: 0; width: clamp(300px, 56.5%, 500px); height: 100%;"
                        >
                        
                        <!-- WHSJ Text Content Mobile (Node: 158:76) - Responsive sizing -->
                        <div class="absolute bg-transparent overflow-hidden translate-x-[-50%]"
                             style="left: 50%; top: clamp(200px, 40%, 0px); width: clamp(250px, 75%, 350px); min-height: clamp(200px, 25%, 250px); padding-bottom: clamp(30px, 5%, 50px);"
                            >
                            <div class="absolute font-['Noto_Sans_JP'] font-extralight text-white text-justify leading-snug tracking-wider whsj-text-responsive"
                                 style="left: 0; top: 0; width: 100%; height: 100%; line-height: 1.375; letter-spacing: 0.05em;">
                                <?php 
                                $whsj_text_content = get_field('whsj_text_content', 'option');
                                if ($whsj_text_content) : ?>
                                    <p class="block leading-snug">
                                        <?php echo nl2br(esc_html($whsj_text_content)); ?>
                                    </p>
                                <?php else : ?>
                                    <p class="block leading-snug">
                                        ここにテキストがはいります。ここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいりますここにテキストがはいります
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- WHSJ TX Box 01 Mobile (Node: 158:78) - Responsive sizing -->
                        <div class="absolute flex items-center justify-center translate-x-[-50%]"
                             style="left: 50%; top: clamp(20px, 3%, 40px); width: clamp(250px, 42.5%, 400px); aspect-ratio: 327/252;">
                            <div class="flex-none scale-y-[-100%] w-full h-full">
                                <div class="bg-transparent overflow-hidden relative w-full h-full"
                                    >
                                    
                                    <!-- WHSJ TX Box 01 A Mobile (Node: 158:79) - Centered -->
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-[30%]">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/whsj/whsj-tx-box-01-a.svg'); ?>" 
                                             alt="Promotion Title Mobile" 
                                             class="block w-full h-full object-contain">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- WHSJ Vector Area Mobile (Node: 156:483) - Added for mobile display -->
                    <div class="whsj-vector-area">
                        <div class="scale-y-[-100%] w-full h-full">
                            <div class="bg-transparent relative w-full h-full">
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="scale-y-[-100%] w-full h-full">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/whsj/whsj-img01.png'); ?>" 
                                             alt="WHSJ Content Image Mobile" 
                                             class="block w-full h-full object-contain">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News & Info Section -->
        <?php get_template_part('template-parts/news-info-section'); ?>
        
        <!-- Lib-Top Section (Node: 156:507 Desktop / 158:60 Mobile) -->
        <!-- Desktop Lib-Top Section (Node: 156:507) - CSS Grid Layout -->
        <section id="lib-top-section" class="hidden tablet:block relative w-full bg-black overflow-hidden"
                 style="height: auto; padding: 100px 0;"
                >
            <div class="lib-top-container">
                
                <!-- Tokyo Area (Left) -->
                <div class="lib-tokyo-area"
                    >
                    <!-- Tokyo Image Container -->
                    <div class="w-full h-full flex items-center justify-center"
                        >
                        <div style="width: clamp(60%, 79%, 85%); aspect-ratio: 660/606;">
                            <?php 
                            $lib_top_tokyo_image = get_field('lib_top_tokyo_image');
                            if ($lib_top_tokyo_image) : ?>
                                <img src="<?php echo esc_url($lib_top_tokyo_image); ?>" 
                                     alt="Tokyo Library Image" 
                                     class="w-full h-full object-cover">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/lib-top/lib-tokyo.svg'); ?>" 
                                     alt="Tokyo Library Image" 
                                     class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Central Divider -->
                <div class="lib-center-divider"
                    >
                    <div class="w-full h-full flex items-center justify-center">
                        <div style="width: 100%; aspect-ratio: 128/1077;">
                            <?php 
                            $lib_center_divider = get_field('lib_center_divider');
                            if ($lib_center_divider) : ?>
                                <img src="<?php echo esc_url($lib_center_divider); ?>" 
                                     alt="Library Central Divider" 
                                     class="w-full h-full object-contain">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/lib-top/lib-center-divider.svg'); ?>" 
                                     alt="Library Central Divider" 
                                     class="w-full h-full object-contain">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Osaka Area (Right) -->
                <div class="lib-osaka-area"
                    >
                    <div class="w-full h-full flex items-center justify-center">
                        <div style="width: clamp(60%, 79%, 85%); aspect-ratio: 660/606;">
                            <?php 
                            $lib_top_osaka_svg = get_field('lib_top_osaka_svg');
                            if ($lib_top_osaka_svg) : ?>
                                <img src="<?php echo esc_url($lib_top_osaka_svg); ?>" 
                                     alt="Osaka Library Content" 
                                     class="w-full h-full object-cover">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/lib-top/lib-osaka.svg'); ?>" 
                                     alt="Osaka Library Content" 
                                     class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Mobile Lib-Top Section (Node: 158:60) - CSS Grid Layout -->
        <section class="block tablet:hidden relative w-full bg-black overflow-hidden"
                 style="height: 29.6875rem;"
                >
            <div class="lib-top-container-mobile">
                
                <!-- Tokyo Area Mobile (Left) -->
                <div class="lib-tokyo-area-mobile"
                    >
                    <!-- Tokyo Image Container Mobile -->
                    <div class="w-full h-full flex items-center justify-center"
                        >
                        <div style="width: clamp(70%, 83.2%, 90%); aspect-ratio: 312/286;">
                            <?php 
                            $lib_top_tokyo_image = get_field('lib_top_tokyo_image');
                            if ($lib_top_tokyo_image) : ?>
                                <img src="<?php echo esc_url($lib_top_tokyo_image); ?>" 
                                     alt="Tokyo Library Image Mobile" 
                                     class="w-full h-full object-cover">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/lib-top/lib-tokyo.svg'); ?>" 
                                     alt="Tokyo Library Image Mobile" 
                                     class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Central Divider Mobile -->
                <div class="lib-center-divider-mobile"
                    >
                    <div class="w-full h-full flex items-center justify-center">
                        <div style="width: 100%; aspect-ratio: 76/475;">
                            <?php 
                            $lib_center_divider = get_field('lib_center_divider');
                            if ($lib_center_divider) : ?>
                                <img src="<?php echo esc_url($lib_center_divider); ?>" 
                                     alt="Library Central Divider Mobile" 
                                     class="w-full h-full object-contain">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/lib-top/lib-center-divider.svg'); ?>" 
                                     alt="Library Central Divider Mobile" 
                                     class="w-full h-full object-contain">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Osaka Area Mobile (Right) -->
                <div class="lib-osaka-area-mobile"
                    >
                    <div class="w-full h-full flex items-center justify-center">
                        <div style="width: clamp(60%, 79%, 85%); aspect-ratio: 660/606;">
                            <?php 
                            $lib_top_osaka_svg = get_field('lib_top_osaka_svg');
                            if ($lib_top_osaka_svg) : ?>
                                <img src="<?php echo esc_url($lib_top_osaka_svg); ?>" 
                                     alt="Osaka Library Content Mobile" 
                                     class="w-full h-full object-cover">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/lib-top/lib-osaka.svg'); ?>" 
                                     alt="Osaka Library Content Mobile" 
                                     class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Library List Section -->
        <section id="lib-list-section" class="relative w-full bg-black overflow-hidden py-16" 
                >
            
            <!-- Desktop Lib-List Section (HTML基準構造) -->
            <div class="hidden tablet:block lib-list-container"
                >
                
                <!-- Header Area - HTML基準2段階構造 -->
                <div class="lib-list-header-area"
                    >
                    
                    <!-- Title Area - HTML基準 -->
                    <div class="lib-list-title-area"
                        >
                        <div id="lib-title-tokyo" class="lib-title-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/lib-list/lib-list-tokyo.png" 
                                 alt="Tokyo Library" 
                                 class="mx-auto h-auto max-w-full" />
                        </div>
                        <div id="lib-title-osaka" class="lib-title-image hidden">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/lib-list/lib-list-osaka.png" 
                                 alt="Osaka Library" 
                                 class="mx-auto h-auto max-w-full" />
                        </div>
                    </div>
                    
                    <!-- Button Area - HTML基準 -->
                    <div class="lib-list-button-area"
                        >
                        <div class="flex justify-center">
                            <div class="flex space-x-4">
                                <button id="tag-bt-tokyo" 
                                        class="library-tab-btn tokyo-active"
                                        data-tab="tokyo">
                                    TOKYO
                                </button>
                                <button id="tag-bt-osaka" 
                                        class="library-tab-btn osaka-inactive"
                                        data-tab="osaka">
                                    OSAKA
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Cards Area - HTML基準 -->
                <div class="lib-list-cards-area"
                    >
                    
                    <div class="lib-list-cards-grid">
                        
                        <!-- Tokyo Dancers -->
                        <div id="tokyo-dancers" class="dancers-grid">
                            <?php
                            $tokyo_dancers = stepjam_get_dancers_with_acf('tokyo', 4);
                            if ($tokyo_dancers->have_posts()) :
                                while ($tokyo_dancers->have_posts()) : $tokyo_dancers->the_post();
                                    $dancer_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $dancer_name = get_field('dancer_name') ?: get_the_title();
                                    $dancer_permalink = get_permalink();
                                    ?>
                                    <a href="<?php echo esc_url($dancer_permalink); ?>" class="lib-list-card">
                                        <div class="card-image">
                                            <?php if ($dancer_thumbnail) : ?>
                                                <img src="<?php echo esc_url($dancer_thumbnail); ?>" 
                                                     alt="<?php echo esc_attr($dancer_name); ?>"
                                                     class="w-full h-full object-cover" />
                                            <?php else : ?>
                                                <div class="w-full h-full bg-red-500 flex items-center justify-center">
                                                    <span class="text-white/60 text-sm">No Image</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-text">
                                            <span class="dancer-name">
                                                <?php echo esc_html($dancer_name); ?>
                                            </span>
                                        </div>
                                    </a>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else : ?>
                                <div class="w-full text-center text-white/60">
                                    <p>東京エリアのダンサーがまだ登録されていません。</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Osaka Dancers -->
                        <div id="osaka-dancers" class="dancers-grid hidden">
                            <?php
                            $osaka_dancers = stepjam_get_dancers_with_acf('osaka', 4);
                            if ($osaka_dancers->have_posts()) :
                                while ($osaka_dancers->have_posts()) : $osaka_dancers->the_post();
                                    $dancer_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $dancer_name = get_field('dancer_name') ?: get_the_title();
                                    $dancer_permalink = get_permalink();
                                    ?>
                                    <a href="<?php echo esc_url($dancer_permalink); ?>" class="lib-list-card">
                                        <div class="card-image">
                                            <?php if ($dancer_thumbnail) : ?>
                                                <img src="<?php echo esc_url($dancer_thumbnail); ?>" 
                                                     alt="<?php echo esc_attr($dancer_name); ?>"
                                                     class="w-full h-full object-cover" />
                                            <?php else : ?>
                                                <div class="w-full h-full bg-red-500 flex items-center justify-center">
                                                    <span class="text-white/60 text-sm">No Image</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-text">
                                            <span class="dancer-name">
                                                <?php echo esc_html($dancer_name); ?>
                                            </span>
                                        </div>
                                    </a>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else : ?>
                                <div class="w-full text-center text-white/60">
                                    <p>大阪エリアのダンサーがまだ登録されていません。</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
            <!-- Mobile Lib-List Section (HTML基準構造) -->
            <div class="block tablet:hidden lib-list-container-mobile"
                >
                
                <!-- Mobile Header Area - HTML基準 -->
                <div class="lib-list-header-area-mobile"
                    >
                    
                    <!-- Mobile Title Area - HTML基準 -->
                    <div class="lib-list-title-area-mobile"
                        >
                        <div id="lib-title-tokyo-mobile" class="lib-title-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/lib-list/lib-list-tokyo.png" 
                                 alt="Tokyo Library Mobile" 
                                 class="mx-auto h-auto max-w-full" />
                        </div>
                        <div id="lib-title-osaka-mobile" class="lib-title-image hidden">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/lib-list/lib-list-osaka.png" 
                                 alt="Osaka Library Mobile" 
                                 class="mx-auto h-auto max-w-full" />
                        </div>
                    </div>
                    
                    <!-- Mobile Button Area - HTML基準 -->
                    <div class="lib-list-button-area-mobile"
                        >
                        <div class="flex justify-center">
                            <div class="flex space-x-2">
                                <button id="tag-bt-tokyo-mobile" 
                                        class="library-tab-btn tokyo-active"
                                        data-tab="tokyo">
                                    TOKYO
                                </button>
                                <button id="tag-bt-osaka-mobile" 
                                        class="library-tab-btn osaka-inactive"
                                        data-tab="osaka">
                                    OSAKA
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Mobile Cards Area - HTML基準 -->
                <div class="lib-list-cards-area-mobile"
                    >
                    
                    <div class="lib-list-cards-grid-mobile">
                        
                        <!-- Tokyo Dancers Mobile -->
                        <div id="tokyo-dancers-mobile" class="dancers-grid">
                            <?php
                            $tokyo_dancers = stepjam_get_dancers_with_acf('tokyo', 4);
                            if ($tokyo_dancers->have_posts()) :
                                while ($tokyo_dancers->have_posts()) : $tokyo_dancers->the_post();
                                    $dancer_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $dancer_name = get_field('dancer_name') ?: get_the_title();
                                    $dancer_permalink = get_permalink();
                                    ?>
                                    <a href="<?php echo esc_url($dancer_permalink); ?>" class="lib-list-card">
                                        <div class="card-image">
                                            <?php if ($dancer_thumbnail) : ?>
                                                <img src="<?php echo esc_url($dancer_thumbnail); ?>" 
                                                     alt="<?php echo esc_attr($dancer_name); ?>"
                                                     class="w-full h-full object-cover" />
                                            <?php else : ?>
                                                <div class="w-full h-full bg-red-500 flex items-center justify-center">
                                                    <span class="text-white/60 text-sm">No Image</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-text">
                                            <span class="dancer-name">
                                                <?php echo esc_html($dancer_name); ?>
                                            </span>
                                        </div>
                                    </a>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else : ?>
                                <div class="w-full text-center text-white/60">
                                    <p>東京エリアのダンサーがまだ登録されていません。</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Osaka Dancers Mobile -->
                        <div id="osaka-dancers-mobile" class="dancers-grid hidden">
                            <?php
                            $osaka_dancers = stepjam_get_dancers_with_acf('osaka', 4);
                            if ($osaka_dancers->have_posts()) :
                                while ($osaka_dancers->have_posts()) : $osaka_dancers->the_post();
                                    $dancer_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $dancer_name = get_field('dancer_name') ?: get_the_title();
                                    $dancer_permalink = get_permalink();
                                    ?>
                                    <a href="<?php echo esc_url($dancer_permalink); ?>" class="lib-list-card">
                                        <div class="card-image">
                                            <?php if ($dancer_thumbnail) : ?>
                                                <img src="<?php echo esc_url($dancer_thumbnail); ?>" 
                                                     alt="<?php echo esc_attr($dancer_name); ?>"
                                                     class="w-full h-full object-cover" />
                                            <?php else : ?>
                                                <div class="w-full h-full bg-red-500 flex items-center justify-center">
                                                    <span class="text-white/60 text-sm">No Image</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-text">
                                            <span class="dancer-name">
                                                <?php echo esc_html($dancer_name); ?>
                                            </span>
                                        </div>
                                    </a>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else : ?>
                                <div class="w-full text-center text-white/60">
                                    <p>大阪エリアのダンサーがまだ登録されていません。</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </section>
        
    </main>
    
</div> <!-- /.site-responsive-wrapper -->

<!-- Cross-page navigation: Handle URL hash anchors for section scrolling -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a hash in the URL and scroll to that section
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1); // Remove the # symbol
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            // Wait for page content to fully load
            setTimeout(() => {
                const headerHeight = 97.36; // Fixed header height
                const elementPosition = targetElement.offsetTop;
                const offsetPosition = elementPosition - headerHeight;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Remove hash from URL to clean up the address bar
                if (history.replaceState) {
                    history.replaceState(null, null, window.location.pathname);
                }
            }, 500); // 500ms delay to ensure all content is rendered
        }
    }
});
</script>

<?php get_footer(); ?>