<?php
/**
 * FAQ アーカイブページテンプレート
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<!-- FAQ Archive - Modern Accordion Design -->
<main class="site-main relative w-full bg-black min-h-screen" data-acf="faq-main">
    
    <!-- FAQ Hero Section -->
    <section class="faq-hero-section relative w-full bg-black py-16 tablet:py-24">
        <div class="container mx-auto px-4 tablet:px-8 max-w-6xl">
            
            <!-- Page Title -->
            <div class="text-center mb-8 tablet:mb-12">
                <h1 class="text-4xl tablet:text-6xl font-black text-white mb-4" 
                    style="font-family: 'Noto Sans JP', sans-serif;">
                    FAQ
                </h1>
                <p class="text-lg tablet:text-xl text-white/80" 
                   style="font-family: 'Noto Sans JP', sans-serif;">
                    よくあるご質問
                </p>
            </div>
            
        </div>
    </section>

    <!-- FAQ Content Section -->
    <section class="faq-content-section relative w-full bg-black pb-16 tablet:pb-24">
        <div class="container mx-auto px-4 tablet:px-8 max-w-4xl">
            
            <?php 
            // FAQ投稿の取得（公開済み・表示順序でソート）
            $faq_query = new WP_Query(array(
                'post_type' => 'faq',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'faq_published',
                        'value' => 1,
                        'compare' => '='
                    )
                ),
                'meta_key' => 'faq_order',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            ));

            if ($faq_query->have_posts()) : ?>
                
                <!-- FAQ Accordion Container -->
                <div class="faq-accordion-container faq-container faq-loading" data-faq="container">
                    
                    <?php while ($faq_query->have_posts()) : $faq_query->the_post(); 
                        $faq_question = get_field('faq_question');
                        $faq_answer = get_field('faq_answer');
                        $faq_order = get_field('faq_order');
                        
                        if ($faq_question && $faq_answer) : ?>
                            
                            <!-- FAQ Item -->
                            <div class="faq-accordion-item mb-4 tablet:mb-6 border-b border-white/10" 
                                 data-faq="item" 
                                 data-faq-id="<?php echo esc_attr(get_the_ID()); ?>"
                                 data-expanded="false">
                                
                                <!-- FAQ Question (Button) -->
                                <button class="faq-question-button w-full text-left py-6 tablet:py-8 px-6 tablet:px-8 
                                              bg-transparent hover:bg-white/5 transition-colors duration-300 
                                              border-0 cursor-pointer focus:outline-none focus:bg-white/5"
                                        data-faq="question"
                                        aria-expanded="false"
                                        aria-controls="faq-answer-<?php echo esc_attr(get_the_ID()); ?>"
                                        role="button"
                                        tabindex="0">
                                    
                                    <div class="flex items-center justify-between">
                                        <!-- Question Text -->
                                        <div class="faq-question-text flex-1 pr-4">
                                            <h3 class="text-lg tablet:text-xl font-semibold text-white m-0 leading-relaxed"
                                                style="font-family: 'Noto Sans JP', sans-serif;">
                                                <?php echo wp_kses($faq_question, array('br' => array())); ?>
                                            </h3>
                                        </div>
                                        
                                        <!-- Toggle Icon -->
                                        <div class="faq-toggle-icon flex-shrink-0 w-6 h-6 tablet:w-8 tablet:h-8 
                                                   relative transition-transform duration-300 ease-out">
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <!-- Plus Icon -->
                                                <svg class="faq-icon-plus w-full h-full text-figma-cyan transition-opacity duration-300" 
                                                     fill="none" 
                                                     stroke="currentColor" 
                                                     viewBox="0 0 24 24" 
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" 
                                                          stroke-linejoin="round" 
                                                          stroke-width="2" 
                                                          d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                <!-- Minus Icon -->
                                                <svg class="faq-icon-minus w-full h-full text-figma-cyan transition-opacity duration-300 opacity-0" 
                                                     fill="none" 
                                                     stroke="currentColor" 
                                                     viewBox="0 0 24 24" 
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" 
                                                          stroke-linejoin="round" 
                                                          stroke-width="2" 
                                                          d="M20 12H4"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </button>

                                <!-- FAQ Answer (Collapsible Content) -->
                                <div class="faq-answer-container overflow-hidden transition-all duration-300 ease-out"
                                     data-faq="answer-container"
                                     data-state="collapsed"
                                     id="faq-answer-<?php echo esc_attr(get_the_ID()); ?>"
                                     aria-hidden="true">
                                    
                                    <div class="faq-answer-content px-6 tablet:px-8 pt-4 tablet:pt-6 pb-6 tablet:pb-8">
                                        <div class="faq-answer-text text-white/90 leading-relaxed"
                                             style="font-family: 'Noto Sans JP', sans-serif;">
                                            <?php 
                                            // WYSIWYG出力のサニタイゼーション
                                            $allowed_tags = array(
                                                'p' => array(),
                                                'br' => array(),
                                                'strong' => array(),
                                                'em' => array(),
                                                'u' => array(),
                                                'a' => array(
                                                    'href' => array(),
                                                    'title' => array(),
                                                    'target' => array(),
                                                    'rel' => array()
                                                ),
                                                'ul' => array(),
                                                'ol' => array(),
                                                'li' => array(),
                                                'h1' => array(),
                                                'h2' => array(),
                                                'h3' => array(),
                                                'h4' => array(),
                                                'h5' => array(),
                                                'h6' => array()
                                            );
                                            echo wp_kses($faq_answer, $allowed_tags);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endif; ?>
                    <?php endwhile; ?>
                    
                </div>
                
            <?php else : ?>
                
                <!-- Demo FAQs for Testing Animation Features -->
                <div class="faq-accordion-container faq-container faq-loading" data-faq="container">
                    
                    <!-- Demo FAQ Item 1 -->
                    <div class="faq-accordion-item mb-4 tablet:mb-6 border-b border-white/10" 
                         data-faq="item" 
                         data-faq-id="demo-1"
                         data-expanded="false">
                        
                        <!-- FAQ Question (Button) -->
                        <button class="faq-question-button w-full text-left py-6 tablet:py-8 px-6 tablet:px-8 
                                      bg-transparent hover:bg-white/5 transition-colors duration-300 
                                      border-0 cursor-pointer focus:outline-none focus:bg-white/5 group"
                                data-faq="question"
                                aria-expanded="false"
                                aria-controls="faq-answer-demo-1"
                                role="button"
                                tabindex="0"
                                type="button">
                            
                            <div class="flex items-start justify-between">
                                <!-- Question Text -->
                                <div class="faq-question-text flex-1 pr-4 tablet:pr-6">
                                    <h3 class="text-lg tablet:text-xl font-semibold text-white m-0 leading-relaxed
                                              group-hover:text-figma-cyan transition-colors duration-300"
                                        style="font-family: 'Noto Sans JP', sans-serif;">
                                        STEPJAMとは何ですか？
                                    </h3>
                                </div>
                                
                                <!-- Toggle Icon Container -->
                                <div class="faq-toggle-icon flex-shrink-0 w-6 h-6 tablet:w-8 tablet:h-8 
                                           relative transition-all duration-300 ease-out group-hover:scale-110">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <!-- Plus Icon (Default State) -->
                                        <svg class="faq-icon-plus w-full h-full text-figma-cyan transition-all duration-300 
                                                   transform rotate-0 opacity-100" 
                                             fill="none" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24" 
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" 
                                                  stroke-linejoin="round" 
                                                  stroke-width="2.5" 
                                                  d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <!-- Minus Icon (Expanded State) -->
                                        <svg class="faq-icon-minus w-full h-full text-figma-cyan transition-all duration-300 
                                                   transform rotate-45 opacity-0 absolute inset-0" 
                                             fill="none" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24" 
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" 
                                                  stroke-linejoin="round" 
                                                  stroke-width="2.5" 
                                                  d="M20 12H4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </button>

                        <!-- Answer Container (Collapsible) -->
                        <div class="faq-answer-container overflow-hidden transition-all duration-300 ease-out
                                   bg-transparent border-0"
                             data-faq="answer-container"
                             data-state="collapsed"
                             id="faq-answer-demo-1"
                             aria-hidden="true"
                             role="region"
                             aria-labelledby="faq-question-demo-1"
                             style="height: 0; opacity: 0; transform: translateY(-10px);">
                            
                            <div class="faq-answer-content px-6 tablet:px-8 pb-6 tablet:pb-8 pt-2">
                                <!-- Answer Content -->
                                <div class="faq-answer-text text-white/90 leading-relaxed text-base tablet:text-lg"
                                     style="font-family: 'Noto Sans JP', sans-serif;">
                                    <p>STEPJAMは、ダンサーとイベント参加者をつなぐダンスコンペティション・イベントプラットフォームです。東京と大阪で開催される様々なダンスバトルやショーケースイベントを通じて、ダンス文化の発展と交流を促進しています。</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demo FAQ Item 2 -->
                    <div class="faq-accordion-item mb-4 tablet:mb-6 border-b border-white/10" 
                         data-faq="item" 
                         data-faq-id="demo-2"
                         data-expanded="false">
                        
                        <button class="faq-question-button w-full text-left py-6 tablet:py-8 px-6 tablet:px-8 
                                      bg-transparent hover:bg-white/5 transition-colors duration-300 
                                      border-0 cursor-pointer focus:outline-none focus:bg-white/5 group"
                                data-faq="question"
                                aria-expanded="false"
                                aria-controls="faq-answer-demo-2"
                                role="button"
                                tabindex="0"
                                type="button">
                            
                            <div class="flex items-start justify-between">
                                <div class="faq-question-text flex-1 pr-4 tablet:pr-6">
                                    <h3 class="text-lg tablet:text-xl font-semibold text-white m-0 leading-relaxed
                                              group-hover:text-figma-cyan transition-colors duration-300"
                                        style="font-family: 'Noto Sans JP', sans-serif;">
                                        参加するにはどうすればいいですか？
                                    </h3>
                                </div>
                                
                                <div class="faq-toggle-icon flex-shrink-0 w-6 h-6 tablet:w-8 tablet:h-8 
                                           relative transition-all duration-300 ease-out group-hover:scale-110">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="faq-icon-plus w-full h-full text-figma-cyan transition-all duration-300 
                                                   transform rotate-0 opacity-100" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <svg class="faq-icon-minus w-full h-full text-figma-cyan transition-all duration-300 
                                                   transform rotate-45 opacity-0 absolute inset-0" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </button>

                        <div class="faq-answer-container overflow-hidden transition-all duration-300 ease-out"
                             data-faq="answer-container" data-state="collapsed" id="faq-answer-demo-2"
                             aria-hidden="true" role="region"
                             style="height: 0; opacity: 0; transform: translateY(-10px);">
                            <div class="faq-answer-content px-6 tablet:px-8 pb-6 tablet:pb-8 pt-2">
                                <div class="faq-answer-text text-white/90 leading-relaxed text-base tablet:text-lg"
                                     style="font-family: 'Noto Sans JP', sans-serif;">
                                    <p>イベント参加は公式サイトからのエントリーフォーム、または各イベントページからお申し込みいただけます。詳細な参加条件や応募方法については、各イベントの詳細ページをご確認ください。</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demo FAQ Item 3 -->
                    <div class="faq-accordion-item mb-4 tablet:mb-6 border-b border-white/10" 
                         data-faq="item" 
                         data-faq-id="demo-3"
                         data-expanded="false">
                        
                        <button class="faq-question-button w-full text-left py-6 tablet:py-8 px-6 tablet:px-8 
                                      bg-transparent hover:bg-white/5 transition-colors duration-300 
                                      border-0 cursor-pointer focus:outline-none focus:bg-white/5 group"
                                data-faq="question"
                                aria-expanded="false"
                                aria-controls="faq-answer-demo-3"
                                role="button"
                                tabindex="0"
                                type="button">
                            
                            <div class="flex items-start justify-between">
                                <div class="faq-question-text flex-1 pr-4 tablet:pr-6">
                                    <h3 class="text-lg tablet:text-xl font-semibold text-white m-0 leading-relaxed
                                              group-hover:text-figma-cyan transition-colors duration-300"
                                        style="font-family: 'Noto Sans JP', sans-serif;">
                                        開催地域と頻度はどのくらいですか？
                                    </h3>
                                </div>
                                
                                <div class="faq-toggle-icon flex-shrink-0 w-6 h-6 tablet:w-8 tablet:h-8 
                                           relative transition-all duration-300 ease-out group-hover:scale-110">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="faq-icon-plus w-full h-full text-figma-cyan transition-all duration-300 
                                                   transform rotate-0 opacity-100" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <svg class="faq-icon-minus w-full h-full text-figma-cyan transition-all duration-300 
                                                   transform rotate-45 opacity-0 absolute inset-0" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </button>

                        <div class="faq-answer-container overflow-hidden transition-all duration-300 ease-out"
                             data-faq="answer-container" data-state="collapsed" id="faq-answer-demo-3"
                             aria-hidden="true" role="region"
                             style="height: 0; opacity: 0; transform: translateY(-10px);">
                            <div class="faq-answer-content px-6 tablet:px-8 pb-6 tablet:pb-8 pt-2">
                                <div class="faq-answer-text text-white/90 leading-relaxed text-base tablet:text-lg"
                                     style="font-family: 'Noto Sans JP', sans-serif;">
                                    <p>現在、東京と大阪を中心に月1～2回のペースでイベントを開催しています。大型のコンペティションは年4回、小規模なワークショップやバトルは随時開催しております。最新のスケジュールは公式サイトでご確認いただけます。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Original No FAQs Message (Hidden with demo data) -->
                <div class="faq-empty-state text-center py-16 tablet:py-24" style="display: none;">
                    <div class="mb-8">
                        <div class="text-6xl tablet:text-8xl mb-4">❓</div>
                        <h2 class="text-2xl tablet:text-3xl font-semibold text-white mb-4"
                            style="font-family: 'Noto Sans JP', sans-serif;">
                            FAQが見つかりません
                        </h2>
                        <p class="text-lg text-white/80 max-w-md mx-auto"
                           style="font-family: 'Noto Sans JP', sans-serif;">
                            現在、公開されているよくあるご質問はありません。<br>
                            しばらくしてから再度ご確認ください。
                        </p>
                    </div>
                    
                    <!-- Back to Home Button -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" 
                       class="inline-block px-8 py-4 bg-figma-cyan text-black font-semibold 
                              rounded-none border-0 transition-all duration-300 hover:bg-figma-cyan/90
                              focus:outline-none focus:ring-2 focus:ring-figma-cyan focus:ring-offset-2 focus:ring-offset-black"
                       style="font-family: 'Noto Sans JP', sans-serif;">
                        ホームに戻る
                    </a>
                </div>
                
            <?php endif; 
            
            // クエリリセット
            wp_reset_postdata(); ?>
            
        </div>
    </section>

</main>

<!-- FAQ Accordion Styles - Preparation for Phase 4 -->
<style>
/* FAQ Basic Styles - Will be enhanced in Phase 4 */
.faq-item {
    background: transparent;
}

.faq-question-button:hover {
    background: rgba(255, 255, 255, 0.05);
}

.faq-question-button:focus {
    background: rgba(255, 255, 255, 0.05);
    outline: 2px solid #00F7FF;
    outline-offset: 2px;
}

.faq-toggle-icon {
    transform-origin: center;
}

.faq-answer-container {
    background: transparent;
}

.faq-answer-text a {
    color: #00F7FF;
    text-decoration: underline;
    transition: color 0.3s ease;
}

.faq-answer-text a:hover {
    color: rgba(0, 247, 255, 0.8);
}

.faq-answer-text ul,
.faq-answer-text ol {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.faq-answer-text li {
    margin-bottom: 0.5rem;
}

.faq-answer-text h1,
.faq-answer-text h2,
.faq-answer-text h3,
.faq-answer-text h4,
.faq-answer-text h5,
.faq-answer-text h6 {
    color: #00F7FF;
    font-weight: 600;
    margin-bottom: 0.75rem;
    margin-top: 1rem;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
    .faq-question-text h3 {
        font-size: 1rem;
        line-height: 1.6;
    }
    
    .faq-answer-text {
        font-size: 0.9rem;
        line-height: 1.7;
    }
}
</style>

<?php get_footer(); ?>