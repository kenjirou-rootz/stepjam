    <!-- Footer Section (Desktop: 156:671, Mobile: 158:97) -->
    <footer class="relative w-full bg-black" style="min-height: 8.208rem;" data-acf="footer-section">
        
        <!-- Desktop Layout (≥768px) -->
        <div class="hidden tablet:grid tablet:grid-cols-3 tablet:min-h-full tablet:items-center tablet:px-4">
            
            <!-- Left: Footer Logo Area (156:329) -->
            <div class="flex flex-col items-center justify-center gap-6 p-4" 
                 data-name="footer-logo">
                <!-- Logo SVG (156:710) -->
                <div class="relative" style="width: clamp(8%, 9%, 12%); min-width: 173.01px; height: 34.8px;" 
                     data-name="footer-logo-ve">
                    <?php 
                    $footer_logo_ve = stepjam_get_site_option('footer_logo_ve', get_template_directory_uri() . '/assets/footer/footer-logo.svg');
                    ?>
                    <img src="<?php echo esc_url($footer_logo_ve); ?>" 
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                         class="w-full h-full object-contain" />
                </div>
                <!-- Copyright Text (156:711) -->
                <div class="text-center text-white text-sm tracking-wider leading-normal" 
                     style="font-family: 'Noto Sans JP', sans-serif; font-weight: 100; letter-spacing: 0.7px;" 
                     data-name="footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(stepjam_get_site_option('company_name', 'STEPJAM')); ?>. All rights reserved.</p>
                </div>
            </div>
            
            <!-- Center: Footer Navigation (156:673) -->
            <div class="flex items-center justify-center p-4" 
                 data-name="footer-list">
                <div class="text-center text-white text-base tracking-wider" 
                     style="font-family: 'Noto Sans JP', sans-serif; font-weight: 100; letter-spacing: 0.8px;">
                    <p>
                        <a href="https://rootz-adl.com/company/" 
                           target="_blank"
                           class="hover:text-cyan-400 transition-colors cursor-pointer">
                            会社概要
                        </a>
                        <span class="mx-2">|</span>
                        <a href="<?php echo esc_url(stepjam_get_site_option('privacy_policy_url', '#')); ?>" 
                           target="_blank"
                           class="hover:text-cyan-400 transition-colors cursor-pointer">
                            個人情報の取り扱い
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Right: Footer Contact (156:675) -->
            <div class="flex items-center justify-center p-4 border border-white" 
                 data-name="footer-contact">
                <div class="relative w-full h-full">
                    <?php 
                    $footer_contact_image = stepjam_get_site_option('footer_contact_image', get_template_directory_uri() . '/assets/footer/footer-contact-image.png');
                    ?>
                    <img src="<?php echo esc_url($footer_contact_image); ?>" 
                         alt="Contact" 
                         class="w-full h-full object-cover" />
                </div>
            </div>
            
        </div>
        
        <!-- Mobile Layout (<768px) -->
        <div class="tablet:hidden grid grid-rows-[repeat(3,minmax(0px,1fr))] min-h-full w-full">
            
            <!-- Top: Footer Contact (158:103) - Grid Area 1 -->
            <div class="[grid-area:1/1] relative w-full" 
                 style="height: 131.333px;" 
                 data-name="footer-contact">
                <a href="/contact/" 
                   class="flex items-center justify-center border border-white w-full h-full block hover:bg-gray-800 hover:bg-opacity-20 transition-colors duration-200"
                   aria-label="コンタクトページへ移動">
                    <div class="relative overflow-hidden w-full h-full max-w-[527px] max-h-[238px] mx-auto">
                        <img src="<?php echo esc_url($footer_contact_image); ?>" 
                             alt="Contact" 
                             class="w-full h-full object-cover" />
                    </div>
                </a>
            </div>
            
            <!-- Middle: Footer Logo (158:98) - Grid Area 2 -->
            <div class="[grid-area:2/1] flex flex-col items-center justify-end gap-[25px] relative w-full" 
                 style="padding-left: clamp(1rem, 15vw, 219px); padding-right: clamp(1rem, 15vw, 219px);" 
                 data-name="footer-logo">
                <!-- Logo SVG (158:99) -->
                <div class="relative" style="width: 173.01px; height: 34.8px;" 
                     data-name="footer-logo-ve">
                    <img src="<?php echo esc_url($footer_logo_ve); ?>" 
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                         class="w-full h-full object-contain block max-w-none" />
                </div>
                <!-- Copyright Text (158:100) -->
                <div class="text-center text-white text-sm leading-normal w-full flex flex-col justify-center" 
                     style="font-family: 'Noto Sans JP:Thin', sans-serif; font-weight: 100; letter-spacing: 0.7px; font-size: 14px; height: 23px;" 
                     data-name="footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(stepjam_get_site_option('company_name', 'STEPJAM')); ?>. All rights reserved.</p>
                </div>
            </div>
            
            <!-- Bottom: Footer Navigation (158:101) - Grid Area 3 -->
            <div class="[grid-area:3/1] flex items-center justify-center relative w-full" 
                 data-name="footer-list">
                <div class="flex items-center justify-center"
                     style="padding-left: clamp(0.5rem, 3vw, 50px); padding-right: clamp(0.5rem, 3vw, 50px);">
                    <div class="text-center text-white text-base text-nowrap" 
                         style="font-family: 'Noto Sans JP:Thin', sans-serif; font-weight: 100; letter-spacing: 0.8px; font-size: 16px;">
                        <p class="block leading-normal whitespace-pre">会社概要| 個人情報の取り扱い</p>
                    </div>
                </div>
            </div>
            
        </div>
        
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>