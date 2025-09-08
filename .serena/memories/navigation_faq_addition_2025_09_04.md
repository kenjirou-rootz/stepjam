# ナビゲーションFAQ追加記録

## 実施日
2025-09-04

## 要望
「/faq/をナビメニューに追加してください。CONTACT の上でお願いします。」

## 実装内容
**ファイル**: `/template-parts/nav-overlay.php`
**追加位置**: LIBRARYとCONTACTの間（141-149行目）

### 追加コード
```php
<!-- FAQ -->
<div class="nav-menu-item-container w-full">
    <a href="<?php echo esc_url(home_url('/faq/')); ?>" 
       class="nav-menu-item text-left text-white hover:text-cyan-400 transition-colors cursor-pointer w-full block"
       style="font-family: 'Noto Sans JP', sans-serif; font-weight: 800; font-size: 2.625rem;"
       data-nav-type="page">
        FAQ
    </a>
</div>
```

## ナビゲーション最終構成（9項目）
1. HOME - data-nav-type="scroll" (hero-section)
2. NEXT - data-nav-type="dropdown" (ドロップダウン)
3. SPONSORS - data-nav-type="scroll" (sponsor-section)
4. ABOUT - data-nav-type="scroll" (whsj-section)
5. NEWS - data-nav-type="page" (/info-news/)
6. LIBRARY - data-nav-type="scroll" (lib-top-section)
7. FAQ - data-nav-type="page" (/faq/) **新規追加**
8. CONTACT - data-nav-type="page" (/contact/)
9. フッターメニュー（会社概要、個人情報保護）

## レスポンシブ対応
- デスクトップ: font-size: 2.625rem
- タブレット(768px): font-size: 2rem
- モバイル(480px): font-size: 1.75rem

## 動作確認結果
- デスクトップ・モバイル両方で正常動作
- /faq/ ページへの遷移確認済み
- FAQアコーディオン機能も正常動作