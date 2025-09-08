/**
 * STEPJAM Dancers Section Auto-Slider
 * 独立したSlider実装 - 既存システムと競合しない完全独立型
 * 
 * ユーザー要求仕様実装:
 * Q1-1: 左方向自動スクロール
 * Q1-2: 3秒間隔
 * Q1-3: 無限ループ（最初に戻る）
 * Q2-1: 全デバイス対応
 * Q2-2: 手動操作時一時停止
 * Q3-1: 278px × 274.5px + 左余白維持
 * Q3-2: 50vw制約維持
 * Q4-1: 動的ACFデータ対応
 * Q4-2: 1人以下は固定表示
 */

class DancersSlider {
    constructor(container) {
        this.container = container;
        this.wrapper = container.querySelector('.dancers-section__swiper-wrapper');
        this.slides = container.querySelectorAll('.dancers-section__slide');
        this.slideCount = this.slides.length;
        this.currentIndex = 0;
        this.autoplayInterval = null;
        this.isPaused = false;
        this.isUserInteracting = false;
        
        // Q4-2: 1人以下の場合はSlider機能無効（固定表示）
        if (this.slideCount <= 1) {
            console.info('DancersSlider: Skipped (less than 2 slides)');
            return;
        }
        
        // 必要な要素が存在する場合のみ初期化
        if (this.wrapper && this.slides.length > 0) {
            this.init();
        }
    }
    
    init() {
        this.setupCSS();
        this.bindEvents();
        this.startAutoplay();
        console.info(`DancersSlider initialized: ${this.slideCount} slides`);
    }
    
    setupCSS() {
        // Wrapperにtransition設定追加（既存スタイル維持）
        this.wrapper.style.transition = 'transform 1s ease-in-out';
        this.wrapper.style.transform = 'translateX(0px)';
        
        // 無限ループのための追加スライド作成
        this.createInfiniteLoop();
    }
    
    createInfiniteLoop() {
        // Q1-3: 無限ループ実装のため、最初のスライドを最後に複製
        const firstSlide = this.slides[0].cloneNode(true);
        firstSlide.setAttribute('data-cloned', 'true');
        this.wrapper.appendChild(firstSlide);
        
        // 複製後のスライド数更新
        this.allSlides = this.wrapper.querySelectorAll('.dancers-section__slide');
    }
    
    bindEvents() {
        // Q2-2: マウスホバー時の一時停止
        this.container.addEventListener('mouseenter', () => {
            this.pauseAutoplay();
        });
        
        this.container.addEventListener('mouseleave', () => {
            if (!this.isUserInteracting) {
                this.resumeAutoplay();
            }
        });
        
        // タッチ操作対応（モバイル）
        this.container.addEventListener('touchstart', () => {
            this.isUserInteracting = true;
            this.pauseAutoplay();
        });
        
        this.container.addEventListener('touchend', () => {
            this.isUserInteracting = false;
            // Q2-2: 操作後自動再生継続
            setTimeout(() => {
                if (!this.isPaused) {
                    this.resumeAutoplay();
                }
            }, 1000); // 1秒後に再開
        });
        
        // ページ非表示時の停止（パフォーマンス最適化）
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseAutoplay();
            } else if (!this.isPaused && !this.isUserInteracting) {
                this.resumeAutoplay();
            }
        });
    }
    
    moveToSlide(index, instant = false) {
        // Q1-1: 左方向スクロール実装
        // スライド幅(278px) + ギャップ(10px) = 288px移動
        const slideWidth = 278;
        const slideGap = 10;
        const moveDistance = slideWidth + slideGap;
        const translateX = -index * moveDistance;
        
        if (instant) {
            this.wrapper.style.transition = 'none';
        } else {
            this.wrapper.style.transition = 'transform 1s ease-in-out';
        }
        
        this.wrapper.style.transform = `translateX(${translateX}px)`;
        
        // 無限ループ処理
        if (index >= this.slideCount) {
            setTimeout(() => {
                this.currentIndex = 0;
                this.moveToSlide(0, true);
            }, 1000); // transition完了後
        }
    }
    
    nextSlide() {
        this.currentIndex++;
        this.moveToSlide(this.currentIndex);
        
        // 無限ループのリセット
        if (this.currentIndex >= this.slideCount) {
            setTimeout(() => {
                this.currentIndex = 0;
            }, 1000);
        }
    }
    
    startAutoplay() {
        // Q1-2: 3秒間隔の自動再生
        if (!this.autoplayInterval) {
            this.autoplayInterval = setInterval(() => {
                if (!this.isPaused && !this.isUserInteracting) {
                    this.nextSlide();
                }
            }, 3000);
        }
    }
    
    pauseAutoplay() {
        this.isPaused = true;
    }
    
    resumeAutoplay() {
        this.isPaused = false;
        if (!this.autoplayInterval) {
            this.startAutoplay();
        }
    }
    
    destroy() {
        // クリーンアップ
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
        
        // 複製したスライドを削除
        const clonedSlide = this.wrapper.querySelector('[data-cloned="true"]');
        if (clonedSlide) {
            clonedSlide.remove();
        }
        
        // CSS初期化
        this.wrapper.style.transition = '';
        this.wrapper.style.transform = '';
    }
}

// 安全な初期化 - DOMContentLoaded後に実行
document.addEventListener('DOMContentLoaded', function() {
    // 既存のSTEPJAMreAppと完全独立して動作
    const dancerContainers = document.querySelectorAll('.dancers-section__swiper');
    const dancerSliders = [];
    
    if (dancerContainers.length > 0) {
        console.info(`Found ${dancerContainers.length} dancer slider containers`);
        
        dancerContainers.forEach((container, index) => {
            try {
                const slider = new DancersSlider(container);
                if (slider.slideCount > 1) {
                    dancerSliders.push(slider);
                }
            } catch (error) {
                console.warn(`DancersSlider[${index}] initialization failed:`, error);
                // エラーが発生してもページ全体に影響しない
            }
        });
        
        console.info(`Successfully initialized ${dancerSliders.length} dancer sliders`);
    }
    
    // グローバルにアクセス可能（デバッグ用）
    window.dancerSliders = dancerSliders;
});

// モジュール化対応
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DancersSlider;
}