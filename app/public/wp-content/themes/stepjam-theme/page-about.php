<?php
/**
 * About Page Template (page-about.php)
 * Automatically applies to pages with 'about' slug
 * 
 * @package STEPJAM_Theme
 */

get_header(); ?>

<!-- About Page - STEPJAM -->
<div class="site-responsive-wrapper">

    <main class="site-main relative w-full bg-black min-h-screen">
        
        <!-- About Hero Section -->
        <section id="about-hero" class="relative w-full bg-black overflow-hidden pt-20 pb-16">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 font-[Noto_Sans_JP]">
                        ABOUT
                    </h1>
                    <p class="text-white/60 text-lg mb-2 font-[Noto_Sans_JP]">
                        STEPJAMについて
                    </p>
                    <div class="w-20 h-1 bg-white/20 mx-auto"></div>
                </div>
            </div>
        </section>
        
        <!-- WHSJ Section Reference -->
        <section id="whsj-content" class="relative w-full bg-black py-16">
            <div class="container mx-auto px-4 max-w-6xl">
                
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 font-[Noto_Sans_JP]">
                        WHAT IS STEPJAM
                    </h2>
                    <p class="text-white/70 text-lg font-[Noto_Sans_JP] max-w-3xl mx-auto">
                        STEPJAMは、ダンス文化の発展と次世代のダンサー育成を目的とした<br>
                        革新的なダンスイベントプラットフォームです
                    </p>
                </div>
                
                <!-- Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Text Content -->
                    <div class="space-y-6">
                        <div class="prose prose-invert max-w-none">
                            <h3 class="text-xl font-bold text-white mb-4 font-[Noto_Sans_JP]">
                                私たちのミッション
                            </h3>
                            <p class="text-white/80 leading-relaxed font-[Noto_Sans_JP]">
                                STEPJAMは、東京・大阪・東北を拠点に、多様なダンスジャンルとアーティストが交流し、
                                新しい表現を生み出す場を提供しています。経験豊富なダンサーから新進気鋭のアーティストまで、
                                すべての人がダンスの魅力を最大限に発揮できる環境を創造します。
                            </p>
                        </div>
                        
                        <div class="prose prose-invert max-w-none">
                            <h3 class="text-xl font-bold text-white mb-4 font-[Noto_Sans_JP]">
                                イベントの特徴
                            </h3>
                            <ul class="text-white/80 space-y-2 font-[Noto_Sans_JP]">
                                <li>✓ 多地域連携によるダイナミックなイベント展開</li>
                                <li>✓ ジャンルを超えたコラボレーションの促進</li>
                                <li>✓ プロフェッショナルな制作・配信環境</li>
                                <li>✓ 次世代ダンサーの発掘と育成支援</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Visual Content Placeholder -->
                    <div class="relative">
                        <div class="aspect-video bg-gradient-to-br from-cyan-900/20 to-purple-900/20 rounded-lg border border-white/10 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 opacity-30">
                                    <svg fill="currentColor" viewBox="0 0 24 24" class="w-full h-full text-white">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                                    </svg>
                                </div>
                                <p class="text-white/50 font-[Noto_Sans_JP]">
                                    WHSJ動画コンテンツ<br>
                                    <small class="text-xs">(ACF設定から動画を設定可能)</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </section>
        
        <!-- Company Information Section -->
        <section id="company-info" class="relative w-full bg-black py-16 border-t border-white/10">
            <div class="container mx-auto px-4 max-w-4xl">
                
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 font-[Noto_Sans_JP]">
                        COMPANY
                    </h2>
                    <p class="text-white/60 font-[Noto_Sans_JP]">
                        運営会社情報
                    </p>
                </div>
                
                <!-- Company Details -->
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-8 border border-white/10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2 font-[Noto_Sans_JP]">
                                    会社名
                                </h3>
                                <p class="text-white/80 font-[Noto_Sans_JP]">
                                    株式会社Rootz
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2 font-[Noto_Sans_JP]">
                                    事業内容
                                </h3>
                                <p class="text-white/80 font-[Noto_Sans_JP]">
                                    エンターテインメント事業<br>
                                    イベント企画・制作・運営<br>
                                    アーティスト育成・マネジメント
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2 font-[Noto_Sans_JP]">
                                    設立
                                </h3>
                                <p class="text-white/80 font-[Noto_Sans_JP]">
                                    2020年
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2 font-[Noto_Sans_JP]">
                                    拠点
                                </h3>
                                <p class="text-white/80 font-[Noto_Sans_JP]">
                                    東京本社<br>
                                    大阪支社<br>
                                    東北事業所
                                </p>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- External Link -->
                    <div class="mt-8 pt-6 border-t border-white/10 text-center">
                        <a href="https://rootz-adl.com/company/" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center px-6 py-3 bg-white/10 text-white font-bold rounded-lg hover:bg-white/20 transition-colors font-[Noto_Sans_JP]">
                            詳細な会社情報を見る
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                    
                </div>
                
            </div>
        </section>
        
        <!-- Call to Action Section -->
        <section id="about-cta" class="relative w-full bg-black py-16">
            <div class="container mx-auto px-4 text-center">
                
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-6 font-[Noto_Sans_JP]">
                    STEPJAMで新しいダンスの可能性を
                </h2>
                
                <p class="text-white/70 text-lg mb-8 max-w-2xl mx-auto font-[Noto_Sans_JP]">
                    イベント参加、スポンサーシップ、その他のお問い合わせは<br>
                    お気軽にご連絡ください
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" 
                       class="inline-flex items-center px-8 py-4 bg-cyan-600 text-white font-bold rounded-lg hover:bg-cyan-700 transition-colors font-[Noto_Sans_JP]">
                        お問い合わせ
                    </a>
                    
                    <button class="inline-flex items-center px-8 py-4 bg-white/10 text-white font-bold rounded-lg hover:bg-white/20 transition-colors font-[Noto_Sans_JP]"
                            data-scroll-target="lib-top-section"
                            onclick="scrollToLibrary()">
                        出演ダンサーを見る
                    </button>
                </div>
                
            </div>
        </section>
        
    </main>
    
</div> <!-- /.site-responsive-wrapper -->

<script>
// Scroll to Library section on front page
function scrollToLibrary() {
    window.location.href = '<?php echo esc_url(home_url('/')); ?>#lib-top-section';
}

// Smooth scroll for internal page anchors
document.addEventListener('DOMContentLoaded', function() {
    const scrollButtons = document.querySelectorAll('[data-scroll-target]');
    
    scrollButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const targetId = this.getAttribute('data-scroll-target');
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<?php get_footer(); ?>