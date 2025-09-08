# Navigation JavaScript Architecture

## STEPJAMプロジェクト ナビゲーション実装指針

### アーキテクチャ原則
- **単一責任原則**: JavaScriptはmain.js STEPJAMreAppクラスに一本化
- **責務分離**: HTML/CSS（nav-overlay.php）vs JavaScript機能（main.js）の明確分離
- **マイクロコンポーネント設計**: 機能ごとの適切なモジュール分割

### ファイル構造・責務
```
template-parts/nav-overlay.php
├── HTML構造（ナビゲーションDOM）
├── CSS（スタイル・レスポンシブ対応）
└── JavaScript: 禁止（main.jsに委譲）

assets/js/main.js
├── STEPJAMreAppクラス
├── bindNavigationEvents(): 全ナビゲーションイベント管理
├── toggleNavigation(): オーバーレイ表示切り替え
├── bindDropdownEvents(): NEXTドロップダウン制御
└── closeNavigation(): 状態リセット含む非表示処理
```

### 重要な実装ポイント

#### 1. イベントリスナー管理
```javascript
bindNavigationEvents() {
    // nav-toggle (header button)
    const navToggle = document.getElementById('nav-toggle');
    if (navToggle && navOverlay) {
        navToggle.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggleNavigation();
        });
    }
    
    // nav-close-btn (overlay close button)
    // overlay background click
    // ESC key support
}
```

#### 2. ドロップダウン制御
```javascript
bindDropdownEvents() {
    // NEXT dropdown in navigation
    const nextToggle = document.getElementById('next-toggle');
    const nextSubmenu = document.getElementById('next-submenu');
    const nextArrow = document.getElementById('next-arrow');
    
    // Toggle logic with arrow rotation
    // Transform: rotate(180deg) for open state
}
```

#### 3. 状態管理・リセット
```javascript
closeNavigation() {
    // Hide overlay
    navOverlay.classList.add('hidden');
    document.body.style.overflow = '';
    
    // Reset dropdown state (重要!)
    if (nextSubmenu && nextArrow) {
        nextSubmenu.classList.add('hidden');
        nextArrow.style.transform = 'rotate(0deg)';
    }
}
```

### トラブルシューティング履歴

#### 問題: ナビゲーションオーバーレイ非表示
- **原因**: JavaScript重複イベントリスナー競合
- **症状**: nav-toggleクリックでもオーバーレイが表示されない
- **解決**: nav-overlay.php内JavaScript完全削除、main.js一本化

#### 対策
1. template-parts内でのJavaScript実装禁止
2. main.js STEPJAMreAppクラス内での一元管理
3. Playwright MCPによる自動UI検証

### 今後の機能拡張指針
1. **新しいナビゲーション機能**: bindNavigationEvents()内に追加
2. **ドロップダウン追加**: bindDropdownEvents()パターンに従う
3. **状態管理**: closeNavigation()でのリセット処理追加必須
4. **レスポンシブ対応**: CSS media queriesで制御、JavaScript最小限

### 検証・テスト方法
```javascript
// Playwright MCP検証項目
1. デスクトップ (1920px): nav-toggle → overlay表示
2. モバイル (375px): nav-toggle → overlay表示  
3. NEXTドロップダウン: クリック → サブメニュー表示
4. nav-close-btn: クリック → overlay非表示
5. レスポンシブ切り替え: 768px境界での動作確認
```