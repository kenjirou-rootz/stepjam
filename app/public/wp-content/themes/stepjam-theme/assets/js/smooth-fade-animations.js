/**
 * Smooth Fade Animations Library
 * 
 * 汎用的なフェードインアニメーション（ダウン→アップ）を提供
 * モノリシック統合を避け、他ページでも再利用可能な構成
 * 
 * @package STEPJAM_Theme
 * @version 1.0.0
 */

class SmoothFadeAnimations {
    constructor(options = {}) {
        this.options = {
            // デフォルト設定
            rootMargin: '0px 0px -100px 0px',
            threshold: 0.1,
            animationDuration: '0.8s',
            animationEasing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
            translateDistance: '30px',
            staggerDelay: 100, // ミリ秒
            ...options
        };
        
        this.observer = null;
        this.animatedElements = new Set();
        this.init();
    }
    
    /**
     * 初期化
     */
    init() {
        if (!window.IntersectionObserver) {
            // Intersection Observer未対応の場合はすべて表示
            this.showAllElements();
            return;
        }
        
        this.setupStyles();
        this.createObserver();
        this.observeElements();
        
        // 修正: 重複初期化防止のため条件分岐を削除
        // DOMContentLoaded時の自動初期化(241行目)で十分に対応可能
    }
    
    /**
     * CSSスタイルの設定
     */
    setupStyles() {
        const styleId = 'smooth-fade-animations-styles';
        
        // 既存のスタイルがある場合は削除
        const existingStyle = document.getElementById(styleId);
        if (existingStyle) {
            existingStyle.remove();
        }
        
        const style = document.createElement('style');
        style.id = styleId;
        style.textContent = `
            /* Smooth Fade Animation Styles */
            [data-fade-in]:not(.fade-in-animated) {
                opacity: 0;
                transform: translateY(${this.options.translateDistance});
                transition: all ${this.options.animationDuration} ${this.options.animationEasing};
            }
            
            [data-fade-in].fade-in-animated {
                opacity: 1;
                transform: translateY(0);
            }
            
            /* レスポンシブ対応 */
            @media (max-width: 768px) {
                [data-fade-in]:not(.fade-in-animated) {
                    transform: translateY(20px);
                }
            }
            
            /* アクセシビリティ: prefers-reduced-motionに対応 */
            @media (prefers-reduced-motion: reduce) {
                [data-fade-in] {
                    transition: opacity 0.3s ease !important;
                    transform: none !important;
                }
                
                [data-fade-in]:not(.fade-in-animated) {
                    opacity: 0;
                }
                
                [data-fade-in].fade-in-animated {
                    opacity: 1;
                }
            }
        `;
        
        document.head.appendChild(style);
    }
    
    /**
     * Intersection Observer の作成
     */
    createObserver() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.animatedElements.has(entry.target)) {
                    this.animateElement(entry.target);
                    this.animatedElements.add(entry.target);
                }
            });
        }, {
            root: null,
            rootMargin: this.options.rootMargin,
            threshold: this.options.threshold
        });
    }
    
    /**
     * 要素の監視を開始
     */
    observeElements() {
        const elements = document.querySelectorAll('[data-fade-in]');
        
        elements.forEach((element, index) => {
            // 重複観測の厳格防止：すでにアニメーション済みまたは観測中の要素はスキップ
            if (this.animatedElements.has(element) || element.hasAttribute('data-fade-observing')) {
                return;
            }
            
            // 観測中マークを追加（重複防止）
            element.setAttribute('data-fade-observing', 'true');
            
            // ステージ遅延の設定
            if (this.options.staggerDelay > 0) {
                element.style.setProperty(
                    '--fade-delay', 
                    `${index * this.options.staggerDelay}ms`
                );
            }
            
            this.observer.observe(element);
        });
    }
    
    /**
     * 要素のアニメーション実行
     */
    animateElement(element) {
        // 重複実行防止：既にアニメーション済みの場合はスキップ
        if (element.classList.contains('fade-in-animated')) {
            return;
        }
        
        // 遅延がある場合は適用
        const delay = element.style.getPropertyValue('--fade-delay');
        
        const animate = () => {
            element.classList.add('fade-in-animated');
            // 観測中マークを削除（アニメーション完了）
            element.removeAttribute('data-fade-observing');
            
            // アニメーション完了後のイベント発火
            element.addEventListener('transitionend', (e) => {
                if (e.target === element && e.propertyName === 'opacity') {
                    const event = new CustomEvent('fadeInComplete', {
                        detail: { element: element }
                    });
                    element.dispatchEvent(event);
                }
            }, { once: true });
        };
        
        if (delay) {
            setTimeout(animate, parseInt(delay));
        } else {
            animate();
        }
    }
    
    /**
     * すべての要素を即座に表示（フォールバック用）
     */
    showAllElements() {
        const elements = document.querySelectorAll('[data-fade-in]');
        elements.forEach(element => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        });
    }
    
    /**
     * 新しい要素を動的に追加
     */
    addElement(element) {
        if (!element || this.animatedElements.has(element)) {
            return;
        }
        
        this.observer.observe(element);
    }
    
    /**
     * 要素の監視を停止
     */
    removeElement(element) {
        if (!element) {
            return;
        }
        
        this.observer.unobserve(element);
        this.animatedElements.delete(element);
    }
    
    /**
     * アニメーションをリセット
     */
    resetElement(element) {
        if (!element) {
            return;
        }
        
        element.classList.remove('fade-in-animated');
        this.animatedElements.delete(element);
        this.observer.observe(element);
    }
    
    /**
     * クリーンアップ
     */
    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
        
        // スタイル要素の削除
        const style = document.getElementById('smooth-fade-animations-styles');
        if (style) {
            style.remove();
        }
        
        this.animatedElements.clear();
    }
}

// 自動初期化（データ属性での設定をサポート）
document.addEventListener('DOMContentLoaded', () => {
    // 二重初期化の厳格な防止
    if (window.smoothFadeAnimations && window.smoothFadeAnimations.observer) {
        console.warn('SmoothFadeAnimations: Already initialized, skipping duplicate initialization');
        return;
    }
    
    // カスタム設定を読み取り
    const configElement = document.querySelector('[data-fade-config]');
    let config = {};
    
    if (configElement) {
        try {
            config = JSON.parse(configElement.getAttribute('data-fade-config'));
        } catch (e) {
            console.warn('SmoothFadeAnimations: Invalid config JSON');
        }
    }
    
    // グローバルインスタンスの作成（強化版チェック）
    if (!window.smoothFadeAnimations) {
        window.smoothFadeAnimations = new SmoothFadeAnimations(config);
        // インスタンス作成確認ログ
        console.log('SmoothFadeAnimations: Initialized successfully');
    }
});

// モジュール対応
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SmoothFadeAnimations;
}