# クロスページナビゲーション問題分析

## 問題概要
- front-page.php以外のページ（archive-info-news.php等）から、ナビゲーションメニューの「SPONSORS」「ABOUT」「LIBRARY」ボタンをクリックしても動作しない
- 現在のscrollToSection()はdocument.getElementById()を使用するため、現在のページにない要素は検出できない

## 現在の実装（main.js:146-166行目）
```javascript
scrollToSection(targetId) {
    const targetElement = document.getElementById(targetId);
    
    if (targetElement) {
        // 要素が見つかった場合のみ動作
        this.closeNavigation();
        setTimeout(() => {
            // スクロール処理
        }, 100);
    }
    // 要素が見つからない場合は何も起こらない
}
```

## 解決策
クロスページナビゲーション機能の追加：
1. 現在のページがfront-page.phpかチェック
2. 違う場合は`window.location.href`でfront-page.phpに遷移+アンカー
3. front-page.phpの場合は既存のスクロール処理

## 技術実装案
- WordPress: `window.location.pathname`でページ判定
- URL遷移: `home_url('/#section-id')`形式
- front-page.php側でアンカー処理追加