# WordPress移行ガイド - JavaScript機能移行編

## 概要

現在のmain.jsの機能をWordPress環境に適応させ、動的コンテンツ（dancer-library）との連携を実装します。

## 現在のJavaScript機能

### STEPJAMreAppクラスの主要機能
1. **ナビゲーション機能**
   - オーバーレイメニューの開閉
   - ドロップダウンメニュー
   - ESCキーでの閉じる機能

2. **スクロール機能**
   - セクションへの自動スクロール
   - ヘッダーオフセット考慮（97.36px）

3. **Library Tab機能**
   - Tokyo/Osakaタブ切り替え
   - カード表示の制御
   - タイトル画像の切り替え

4. **レスポンシブ対応**
   - 768pxブレークポイント
   - デスクトップ/モバイル判定

## WordPress対応のJavaScript実装

### 1. 基本構造の調整

```javascript
class STEPJAMreApp {
    constructor() {
        this.isDesktop = window.innerWidth >= 768;
        this.wpData = window.stepjam_data || {};
        this.dancers = {
            tokyo: [],
            osaka: []
        };
        this.init();
    }

    init() {
        console.log(`🚀 STEPJAMre: ${this.isDesktop ? 'Desktop' : 'Mobile'} (${window.innerWidth}px)`);
        
        // WordPress環境の確認
        if (this.wpData.is_front_page) {
            this.initFrontPageFeatures();
        }
        
        this.bindEvents();
        this.initMainContent();
        
        // レスポンシブ対応
        window.addEventListener('resize', () => {
            const wasDesktop = this.isDesktop;
            this.isDesktop = window.innerWidth >= 768;
            
            if (wasDesktop !== this.isDesktop) {
                console.log(`📱 Viewport changed: ${this.isDesktop ? 'Desktop' : 'Mobile'}`);
                this.onViewportChange();
            }
        });
    }

    initFrontPageFeatures() {
        // フロントページ限定の機能初期化
        this.loadDancerData();
        this.bindLibraryTabEvents();
    }
}
```

### 2. WordPress Ajax連携

```javascript
class STEPJAMreApp {
    // ... 

    async loadDancerData() {
        try {
            // WordPress Ajax でdancer-library投稿を取得
            const response = await fetch(this.wpData.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_dancer_library',
                    nonce: this.wpData.nonce
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.dancers = data.data;
                this.renderDancerCards();
                console.log('📚 Dancer data loaded:', this.dancers);
            }
        } catch (error) {
            console.error('❌ Failed to load dancer data:', error);
            // フォールバック: 静的データまたは空の配列
            this.renderDancerCards();
        }
    }

    renderDancerCards() {
        // Tokyo Cards
        this.renderLocationCards('tokyo');
        // Osaka Cards  
        this.renderLocationCards('osaka');
    }

    renderLocationCards(location) {
        const container = document.querySelector(`.library-cards[data-tab="${location}"]`);
        if (!container || !this.dancers[location]) return;

        // 既存のカードをクリア（静的HTMLカードを除く）
        const dynamicCards = container.querySelectorAll('.dancer-card[data-dynamic="true"]');
        dynamicCards.forEach(card => card.remove());

        // 動的カードの生成
        this.dancers[location].forEach(dancer => {
            const cardHtml = this.createDancerCardHtml(dancer, location);
            container.insertAdjacentHTML('beforeend', cardHtml);
        });
    }

    createDancerCardHtml(dancer, location) {
        const bgColor = location === 'tokyo' ? 'bg-red-500' : 'bg-blue-700';
        
        return `
            <div class="library-card ${bgColor}" data-tab="${location}" data-dynamic="true">
                <img src="${dancer.image}" 
                     alt="${dancer.name}" 
                     class="w-full h-full object-cover"
                     loading="lazy">
                <div class="card-title">
                    <h3>${dancer.name}</h3>
                </div>
            </div>
        `;
    }
}
```

### 3. WordPress Ajax Handler（PHP側）

```php
// functions.phpまたは専用ファイルに追加

/**
 * Dancer Library Ajax Handler
 */
function stepjam_get_dancer_library() {
    // nonce検証
    if (!wp_verify_nonce($_POST['nonce'], 'stepjam_nonce')) {
        wp_die('Security check failed');
    }

    $dancers = array(
        'tokyo' => array(),
        'osaka' => array()
    );

    // Tokyo投稿の取得
    $tokyo_query = new WP_Query(array(
        'post_type' => 'dancer-library',
        'posts_per_page' => -1,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'dancer-location',
                'field' => 'slug',
                'terms' => 'tokyo'
            )
        )
    ));

    if ($tokyo_query->have_posts()) {
        while ($tokyo_query->have_posts()) {
            $tokyo_query->the_post();
            $dancer_image = get_field('dancer_image');
            $display_name = get_field('dancer_display_name');
            
            $dancers['tokyo'][] = array(
                'id' => get_the_ID(),
                'name' => $display_name ?: get_the_title(),
                'image' => $dancer_image ?: '',
                'url' => get_permalink()
            );
        }
    }

    // Osaka投稿の取得
    $osaka_query = new WP_Query(array(
        'post_type' => 'dancer-library',
        'posts_per_page' => -1,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'dancer-location',
                'field' => 'slug',
                'terms' => 'osaka'
            )
        )
    ));

    if ($osaka_query->have_posts()) {
        while ($osaka_query->have_posts()) {
            $osaka_query->the_post();
            $dancer_image = get_field('dancer_image');
            $display_name = get_field('dancer_display_name');
            
            $dancers['osaka'][] = array(
                'id' => get_the_ID(),
                'name' => $display_name ?: get_the_title(),
                'image' => $dancer_image ?: '',
                'url' => get_permalink()
            );
        }
    }

    wp_reset_postdata();

    wp_send_json_success($dancers);
}
add_action('wp_ajax_get_dancer_library', 'stepjam_get_dancer_library');
add_action('wp_ajax_nopriv_get_dancer_library', 'stepjam_get_dancer_library');
```

### 4. タブ切り替え機能の拡張

```javascript
class STEPJAMreApp {
    // ...

    switchLibraryTab(selectedTab) {
        // ボタン状態の更新
        const allTabButtons = document.querySelectorAll('.library-tab-btn[data-tab]');
        allTabButtons.forEach(button => {
            const tabName = button.getAttribute('data-tab');
            const isSelected = tabName === selectedTab;
            
            if (isSelected) {
                button.classList.remove('bg-transparent', 'border-2', 'border-blue-700', 'text-blue-700');
                button.classList.add('bg-blue-700', 'text-white');
                button.classList.add('active');
            } else {
                button.classList.remove('bg-blue-700', 'text-white', 'active');
                button.classList.add('bg-transparent', 'border-2', 'border-blue-700', 'text-blue-700');
            }
        });
        
        // カード表示の切り替え
        const allCards = document.querySelectorAll('.library-card[data-tab]');
        allCards.forEach(card => {
            const cardTab = card.getAttribute('data-tab');
            
            if (cardTab === selectedTab) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
        
        // タイトル画像の切り替え（WordPress版）
        this.updateLibraryTitleImage(selectedTab);
        
        console.log(`📚 Library tab switched to: ${selectedTab}`);
    }

    updateLibraryTitleImage(selectedTab) {
        const desktopTitleImg = document.getElementById('lib-list-title-desktop');
        const mobileTitleImg = document.getElementById('lib-list-title-mobile');
        
        // ACFフィールドから取得した画像、フォールバックは静的パス
        let imagePath;
        if (selectedTab === 'tokyo') {
            imagePath = this.wpData.lib_title_tokyo || 
                       `${this.wpData.theme_url}/assets/lib-list/lib-list-tokyo.png`;
        } else {
            imagePath = this.wpData.lib_title_osaka || 
                       `${this.wpData.theme_url}/assets/lib-list/lib-list-osaka.png`;
        }
        
        if (desktopTitleImg) {
            desktopTitleImg.src = imagePath;
            desktopTitleImg.alt = `${selectedTab.charAt(0).toUpperCase() + selectedTab.slice(1)} Library List Title`;
        }
        
        if (mobileTitleImg) {
            mobileTitleImg.src = imagePath;
            mobileTitleImg.alt = `${selectedTab.charAt(0).toUpperCase() + selectedTab.slice(1)} Library List Title Mobile`;
        }
    }
}
```

### 5. WordPressデータの受け渡し設定

```php
// inc/enqueue-scripts.phpに追加

function stepjam_enqueue_scripts() {
    // JavaScript読み込み
    wp_enqueue_script(
        'stepjam-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
    
    // ACFフィールドの値を取得
    $lib_title_tokyo = get_field('lib_title_tokyo');
    $lib_title_osaka = get_field('lib_title_osaka');
    
    // JavaScriptで使用するデータ
    wp_localize_script('stepjam-main', 'stepjam_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('stepjam_nonce'),
        'theme_url' => get_template_directory_uri(),
        'home_url' => home_url(),
        'is_front_page' => is_front_page(),
        'lib_title_tokyo' => $lib_title_tokyo,
        'lib_title_osaka' => $lib_title_osaka,
        'debug' => WP_DEBUG
    ));
}
```

## ナビゲーション機能の調整

### WordPress メニューとの連携

```javascript
class STEPJAMreApp {
    // ...

    bindScrollEvents() {
        // 静的メニューアイテム
        const menuItems = document.querySelectorAll('.nav-menu-item[data-scroll-target]');
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = item.getAttribute('data-scroll-target');
                this.scrollToSection(targetId);
            });
        });

        // 動的サブメニューアイテム（Library > Tokyo/Osaka）
        const submenuItems = document.querySelectorAll('.nav-submenu-item[data-scroll-target]');
        submenuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = item.getAttribute('data-scroll-target');
                const tabTarget = item.getAttribute('data-tab');
                
                // セクションにスクロール
                this.scrollToSection(targetId);
                
                // タブの切り替え
                if (tabTarget) {
                    setTimeout(() => {
                        this.switchLibraryTab(tabTarget);
                    }, 500); // スクロール完了後にタブ切り替え
                }
            });
        });

        // WordPressメニューリンクとの統合
        this.bindWordPressMenuEvents();
    }

    bindWordPressMenuEvents() {
        // WordPressで生成されたメニューのカスタムリンク処理
        const wpMenuLinks = document.querySelectorAll('a[href*="#"]');
        wpMenuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                const hashIndex = href.indexOf('#');
                
                if (hashIndex !== -1) {
                    e.preventDefault();
                    const targetId = href.substring(hashIndex + 1);
                    this.scrollToSection(targetId);
                }
            });
        });
    }
}
```

## エラーハンドリングとフォールバック

### 1. Ajax失敗時の処理

```javascript
class STEPJAMreApp {
    // ...

    async loadDancerData() {
        try {
            const response = await fetch(this.wpData.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_dancer_library',
                    nonce: this.wpData.nonce
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                this.dancers = data.data;
                this.renderDancerCards();
            } else {
                throw new Error(data.data || 'Unknown error');
            }
        } catch (error) {
            console.error('❌ Ajax request failed:', error);
            this.handleDancerDataFallback();
        }
    }

    handleDancerDataFallback() {
        // 静的HTMLカードが既に存在する場合はそれを使用
        const existingCards = document.querySelectorAll('.library-card:not([data-dynamic="true"])');
        
        if (existingCards.length > 0) {
            console.log('📄 Using existing static cards as fallback');
            return;
        }

        // フォールバック用の空の状態表示
        this.showEmptyState();
    }

    showEmptyState() {
        ['tokyo', 'osaka'].forEach(location => {
            const container = document.querySelector(`.library-cards[data-tab="${location}"]`);
            if (container) {
                container.innerHTML = `
                    <div class="empty-state">
                        <p class="text-figma-white text-center">
                            ${location.toUpperCase()} dancers will be loaded soon...
                        </p>
                    </div>
                `;
            }
        });
    }
}
```

### 2. レガシーブラウザ対応

```javascript
// Polyfillの追加（IE11対応が必要な場合）
if (!window.fetch) {
    // Fetch polyfill
    console.warn('Fetch API not supported, consider adding a polyfill');
}

// ES6機能のフォールバック
class STEPJAMreApp {
    constructor() {
        // Internet Explorer判定
        this.isIE = !!document.documentMode;
        
        if (this.isIE) {
            console.warn('Internet Explorer detected, some features may be limited');
        }
        
        // 初期化続行
        this.init();
    }
}
```

## デバッグとメンテナンス

### 1. デバッグ機能の追加

```javascript
class STEPJAMreApp {
    constructor() {
        this.debug = this.wpData.debug || false;
        // ...
    }

    log(message, data = null) {
        if (this.debug) {
            console.log(`[STEPJAM Debug] ${message}`, data);
        }
    }

    error(message, error = null) {
        console.error(`[STEPJAM Error] ${message}`, error);
    }
}
```

### 2. パフォーマンス監視

```javascript
class STEPJAMreApp {
    init() {
        const startTime = performance.now();
        
        // 初期化処理
        this.bindEvents();
        this.initMainContent();
        
        const endTime = performance.now();
        this.log(`Initialization completed in ${endTime - startTime}ms`);
    }

    async loadDancerData() {
        const startTime = performance.now();
        
        try {
            // Ajax処理
            const response = await fetch(/* ... */);
            // ...
            
            const endTime = performance.now();
            this.log(`Dancer data loaded in ${endTime - startTime}ms`);
        } catch (error) {
            // エラー処理
        }
    }
}
```

## 実装チェックリスト

### Phase 1: 基本機能移行
- [ ] STEPJAMreAppクラスの調整
- [ ] WordPress Ajax連携の実装
- [ ] wp_localize_scriptでのデータ受け渡し

### Phase 2: 動的機能実装
- [ ] dancer-library投稿のAjax取得
- [ ] 動的カード生成機能
- [ ] タブ切り替え機能の拡張

### Phase 3: エラーハンドリング
- [ ] Ajax失敗時のフォールバック
- [ ] 空の状態の表示
- [ ] レガシーブラウザ対応

### Phase 4: 最適化
- [ ] パフォーマンス監視
- [ ] デバッグ機能の実装
- [ ] キャッシュ機構の検討

### Phase 5: 動作確認
- [ ] 全ブラウザでの動作確認
- [ ] レスポンシブ動作の確認
- [ ] Ajax通信の確認
- [ ] エラー状況の確認