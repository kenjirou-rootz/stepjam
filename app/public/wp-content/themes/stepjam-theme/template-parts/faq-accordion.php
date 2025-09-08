<?php
/**
 * Template part for displaying FAQ accordion item
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

// 必要なデータの確認
$faq_question = get_field('faq_question');
$faq_answer = get_field('faq_answer');
$faq_order = get_field('faq_order');
$faq_published = get_field('faq_published');

// 公開状態チェック
if (!$faq_published || empty($faq_question) || empty($faq_answer)) {
    return;
}
?>

<!-- Single FAQ Accordion Item -->
<div class="faq-accordion-item mb-4 tablet:mb-6 border-b border-white/10" 
     data-faq="item" 
     data-faq-id="<?php echo esc_attr(get_the_ID()); ?>"
     data-faq-order="<?php echo esc_attr($faq_order ?: 0); ?>">
    
    <!-- Question Button -->
    <button class="faq-question-button w-full text-left py-6 tablet:py-8 px-6 tablet:px-8 
                  bg-transparent hover:bg-white/5 transition-colors duration-300 
                  border-0 cursor-pointer focus:outline-none focus:bg-white/5 group"
            data-faq="question"
            aria-expanded="false"
            aria-controls="faq-answer-<?php echo esc_attr(get_the_ID()); ?>"
            role="button"
            tabindex="0"
            type="button">
        
        <div class="flex items-start justify-between">
            <!-- Question Text -->
            <div class="faq-question-text flex-1 pr-4 tablet:pr-6">
                <h3 class="text-lg tablet:text-xl font-semibold text-white m-0 leading-relaxed
                          group-hover:text-figma-cyan transition-colors duration-300"
                    style="font-family: 'Noto Sans JP', sans-serif;">
                    <?php echo wp_kses($faq_question, array('br' => array())); ?>
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
         id="faq-answer-<?php echo esc_attr(get_the_ID()); ?>"
         aria-hidden="true"
         role="region"
         aria-labelledby="faq-question-<?php echo esc_attr(get_the_ID()); ?>"
         style="height: 0; opacity: 0; transform: translateY(-10px);">
        
        <div class="faq-answer-content px-6 tablet:px-8 pb-6 tablet:pb-8 pt-2">
            <!-- Answer Content -->
            <div class="faq-answer-text text-white/90 leading-relaxed text-base tablet:text-lg"
                 style="font-family: 'Noto Sans JP', sans-serif;">
                <?php 
                // WYSIWYG出力の安全な表示
                $allowed_tags = array(
                    'p' => array('class' => array(), 'style' => array()),
                    'br' => array(),
                    'strong' => array('class' => array()),
                    'b' => array('class' => array()),
                    'em' => array('class' => array()),
                    'i' => array('class' => array()),
                    'u' => array('class' => array()),
                    'span' => array('class' => array(), 'style' => array()),
                    'a' => array(
                        'href' => array(),
                        'title' => array(),
                        'target' => array(),
                        'rel' => array(),
                        'class' => array()
                    ),
                    'ul' => array('class' => array()),
                    'ol' => array('class' => array()),
                    'li' => array('class' => array()),
                    'h1' => array('class' => array()),
                    'h2' => array('class' => array()),
                    'h3' => array('class' => array()),
                    'h4' => array('class' => array()),
                    'h5' => array('class' => array()),
                    'h6' => array('class' => array()),
                    'blockquote' => array('class' => array()),
                    'div' => array('class' => array(), 'style' => array())
                );
                echo wp_kses($faq_answer, $allowed_tags);
                ?>
            </div>
        </div>
    </div>
</div>