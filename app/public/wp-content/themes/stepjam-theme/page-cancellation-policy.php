<?php
/**
 * Template Name: キャンセルポリシー
 * 
 * @package STEPJAM_Theme
 */

get_header(); ?>

<!-- アニメーション速度カスタマイズ設定 -->
<script data-fade-config='{
    "animationDuration": "1.2s",
    "staggerDelay": 250,
    "translateDistance": "40px",
    "animationEasing": "cubic-bezier(0.25, 0.46, 0.45, 0.94)"
}'></script>

<!-- Cancellation Policy Page - Content Structure with Fade Animation -->
<main class="site-main bg-black min-h-screen" data-acf="cancellation-policy-main">
    
    <!-- Hero Section -->
    <section class="policy-hero-section relative w-full bg-black py-16 tablet:py-24">
        <div class="container mx-auto px-4 tablet:px-8 max-w-4xl">
            
            <!-- Page Title -->
            <div class="text-center mb-8 tablet:mb-12">
                <h1 class="text-2xl tablet:text-4xl font-bold text-white mb-4" 
                    style="font-family: 'Noto Sans JP', sans-serif;">
                    キャンセルポリシー
                </h1>
                <p class="text-lg tablet:text-xl text-white/80" 
                   style="font-family: 'Noto Sans JP', sans-serif;">
                    イベント規約・方針について
                </p>
            </div>
            
        </div>
    </section>

    <!-- Content Section -->
    <section class="policy-content-section relative w-full bg-black pb-16 tablet:pb-24">
        <div class="container mx-auto px-4 tablet:px-8 max-w-4xl">
            
            <!-- Introduction -->
            <div class="mb-12">
                <p class="text-white leading-relaxed text-base tablet:text-lg mb-6" 
                   style="font-family: 'Noto Sans JP', sans-serif;">
                    当イベント（STEPJAM）は東京都及び各開催地の条例で定める公衆衛生上必要な基準を満たす形で開催を予定しており、
                    出演者及び参加者とイベント主催者が協力して対策に取り組む必要がございます。<br>
                    当イベントを開催・参加する上で下記方針と規約をご確認くださいませ。<br>
                    ※なお、下記内容は社会情勢を踏まえて適宜改訂を行います。予めご了承くださいませ。
                </p>
                
                <div class="space-y-4">
                    <p class="text-white font-semibold" style="font-family: 'Noto Sans JP', sans-serif;">
                        ①出演者及び、ご来場いただくお客様に関しましては、下記規約に同意した上で参加しているものとみなします。
                    </p>
                    <p class="text-white font-semibold" style="font-family: 'Noto Sans JP', sans-serif;">
                        ②当イベントの運営上やむを得ない場合には、参加者に事前の通知なく、当イベントの運営を中止・中断および変更できるものとします。
                    </p>
                    <p class="text-white font-semibold" style="font-family: 'Noto Sans JP', sans-serif;">
                        ③エントリーをキャンセルする際は必ず主催者にご連絡願います。
                    </p>
                </div>
            </div>
            
            <!-- Participation Conditions -->
            <div class="mb-12">
                <h2 class="text-2xl tablet:text-3xl font-bold text-figma-cyan mb-6" 
                    style="font-family: 'Noto Sans JP', sans-serif;">
                    イベントの開催・参加条件に関しまして
                </h2>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-3" style="font-family: 'Noto Sans JP', sans-serif;">
                            ①参加要件に関しまして
                        </h3>
                        <p class="text-white/90 leading-relaxed" style="font-family: 'Noto Sans JP', sans-serif;">
                            キャンセルポリシーに関するイベント規約・方針について同意したうえでご参加いただきます。
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-3" style="font-family: 'Noto Sans JP', sans-serif;">
                            ②出演エントリーキャンセルに関しまして
                        </h3>
                        <p class="text-white/90 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            各イベント開催日のキャンセル規定期日までにキャンセルを申し出の参加者には、エントリー費用全額を返金させていただきます。<br>
                            ※開催イベントによって期日異なるので各期日は別途詳細にてお送りいたします。
                        </p>
                        
                        <!-- Cancellation Fees -->
                        <div class="bg-gray-900 border border-figma-cyan/30 rounded p-6 mb-4">
                            <h4 class="text-figma-cyan font-semibold mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                                ■ キャンセル費用について
                            </h4>
                            <div class="space-y-2 text-white/90" style="font-family: 'Noto Sans JP', sans-serif;">
                                <p>募集締切日：<span class="text-figma-cyan font-semibold">30%</span></p>
                                <p>2週間前〜：<span class="text-figma-cyan font-semibold">50%</span></p>
                                <p>前日〜：<span class="text-figma-cyan font-semibold">100%</span></p>
                            </div>
                        </div>
                        
                        <div class="text-white/90 leading-relaxed space-y-2" style="font-family: 'Noto Sans JP', sans-serif;">
                            <p>キャンセル期日以降のキャンセルは承れませんので、ご理解のほどお願い申し上げます。</p>
                            <p class="text-sm">※キャンセルの場合はエントリー時にお振込いただいた金額(ギャランティ分を差し引いた残金)をご返金させていただきます。</p>
                            <p class="text-sm">※返金の際は、ご入金をいただいた振付師及び代表者の口座宛てに直接、返金させていただきますので、別途主催者に振り込み先口座情報をご連絡ください。</p>
                            <p class="text-sm">※出演者個人への返金対応は出来かねます。予めご容赦ください。</p>
                            <p class="text-sm">※返金完了までは、最大約２ヶ月の期間を要する場合がございます。予めご了承ください。</p>
                            <p class="text-sm">※ナンバーの練習やイベント参加に要した諸経費（衣装代や交通費などのエントリー費用以外の経費）に関しての負担は一切できかねますので、何卒ご容赦ください。</p>
                            <p class="text-sm">※キャンセル期日以降、エントリー費・チケットの返金・交換はできかねますので、ご容赦ください。</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Guidelines -->
            <div class="mb-12">
                <h2 class="text-2xl tablet:text-3xl font-bold text-figma-cyan mb-6" 
                    style="font-family: 'Noto Sans JP', sans-serif;">
                    イベント開催時の基本的なガイドライン・予防対策
                </h2>
                
                <div class="space-y-4 text-white/90 leading-relaxed" style="font-family: 'Noto Sans JP', sans-serif;">
                    <p>・全てのイベント関係者・来場者は、入館時にアルコール消毒のご協力をお願いいたします。また、37.5度以上の発熱がある場合、来場を取りやめ自宅待機として下さい。<br>※会場により検温が必要な場合がございます。<br>※新型コロナウイルス感染症陽性とされた方、濃厚接触と判断された方はご来場をお控えください。</p>
                    <p>・公演時、出演者のステージ上でのマスク着用は任意としますが、会場側の規定によりマスク着用必須とさせて頂く場合がございます。</p>
                    <p>・来場者の再入場に関しましては、基本不可となります。ただし運営の兼ね合いで変更が出る場合はその限りではございません。<br>※変更になる場合は別途SNSなどで適宜広報致します。</p>
                    <p>・会場入口（会場内の各フロア含む）を出入りなされる方には、会場側の規定により、出演者及び来場者全ての方に手指アルコール消毒のご協力をお願いする場合がございます。<br>※エントランス付近に手指用アルコール消毒液を設置いたします。</p>
                    <p>・会場内での飲食・喫煙は全面禁止とさせて頂きます。<br>※会場によっては飲食・喫煙可能となりますので、随時アナウンスさせていただきます。</p>
                </div>
                
                <div class="bg-red-900/20 border border-red-500/30 rounded p-6 mt-6">
                    <h4 class="text-red-400 font-semibold mb-3" style="font-family: 'Noto Sans JP', sans-serif;">
                        ■ 感染者および感染の疑いが発生した場合の対応について
                    </h4>
                    <p class="text-white/90" style="font-family: 'Noto Sans JP', sans-serif;">
                        すべての公演関係者と観客において、感染者およびその疑いのある人（発熱および疑わしい症状を有する人）が発生した場合、主催者に即時情報共有してください。所管保健所に対応の指示を仰ぎます。
                    </p>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="mt-16 pt-8 border-t border-white/20">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-figma-cyan mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                        主催
                    </h3>
                    <div class="text-white/90" style="font-family: 'Noto Sans JP', sans-serif;">
                        <p class="font-semibold mb-2">Rootz株式会社</p>
                        <p class="text-sm">〒169-0075</p>
                        <p class="text-sm mb-2">東京都新宿区高田馬場3-23-3 ORビル 1F</p>
                        <p class="text-sm">03-6447-0801</p>
                        <a href="http://www.rootz-adl.com/" target="_blank" rel="noopener" 
                           class="text-figma-cyan hover:text-figma-cyan/80 transition-colors">
                            http://www.rootz-adl.com/
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

</main>

<?php get_footer(); ?>