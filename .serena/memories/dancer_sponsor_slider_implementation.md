# 登録ダンサーテンプレート スポンサースライダー追加実装記録

## 実装日時
2025-09-02

## 実装内容
カスタム投稿タイプ「登録ダンサー」のテンプレートにスポンサースライダーを追加

## 対象ファイル
- **テンプレートファイル**: `single-toroku-dancer.php`
- **使用テンプレートパーツ**: `template-parts/sponsor-content.php`
- **参照元**: `front-page.php`の実装方式

## 実装詳細

### バックアップ先
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/dancer-sponsor-addition/
└── single-toroku-dancer_backup_[timestamp].php
```

### 追加コード (182行目後に挿入)
```php
<!-- Sponsor Section - Added for Dancer Detail Pages -->
<!-- Desktop Sponsor Section -->
<section class="hidden tablet:block relative w-full bg-black overflow-hidden">
    <div class="sponsor-section-container">
        <!-- Desktop Sponsor Container - Modularized -->
        <?php get_template_part('template-parts/sponsor-content', null, array(
            'device_type' => 'desktop',
            'slider_class' => 'logo-slider-desktop'
        )); ?>
    </div>
</section>

<!-- Mobile Sponsor Section -->
<section class="block tablet:hidden relative w-full bg-black overflow-hidden">
    <div class="sponsor-section-container">
        <!-- Mobile Sponsor Container - Modularized -->
        <?php get_template_part('template-parts/sponsor-content', null, array(
            'device_type' => 'mobile',
            'slider_class' => 'logo-slider-mobile'
        )); ?>
    </div>
</section>
```

### 挿入位置
- **before**: `<?php get_footer(); ?>`
- **after**: `<?php endwhile; ?>`
- **配置**: フッター直前の適切な位置

## 技術仕様

### パラメータ設定
- **デスクトップ**: `device_type => 'desktop'`, `slider_class => 'logo-slider-desktop'`
- **モバイル**: `device_type => 'mobile'`, `slider_class => 'logo-slider-mobile'`

### レスポンシブ対応
- **デスクトップ**: `hidden tablet:block` - タブレット以上で表示
- **モバイル**: `block tablet:hidden` - タブレット未満で表示

### データソース
- **ACFフィールド**: `sponsors_slides` (option)
- **画像**: `/assets/spon/spon-cont-img.png`
- **スライダー**: 3つのスポンサーロゴ (what it isnt)

## 動作確認結果

### デスクトップ表示 (1920px)
✅ スポンサーコンテンツ画像表示
✅ ロゴスライダー正常動作 (3スライド)
✅ 適切な位置 (footer直前)

### モバイル表示 (375px)  
✅ Mobile Sponsor Content画像表示
✅ モバイル用ロゴスライダー正常動作
✅ レスポンシブ切り替え正常

### 確認URL
- テストダンサーページ: `http://stepjam.local/toroku-dancer/テストダンサー/`

## front-page.phpとの一致確認

### 共通要素
✅ 同一の `template-parts/sponsor-content.php` を使用
✅ 同一のパラメータ構造
✅ 同一のレスポンシブクラス設定
✅ 同一のACFデータソース

### 実装方式の一致
✅ デスクトップ/モバイル分離
✅ モジュール化されたテンプレートパーツ使用
✅ 適切なセクション構造
✅ CSSクラス名の統一

## 保守ポイント
- スポンサーコンテンツの更新は`template-parts/sponsor-content.php`で管理
- ACFの`sponsors_slides`フィールドでロゴ管理
- レスポンシブ切り替えは768px (tablet)境界
- 全ダンサーページで統一されたスポンサー表示

## 今後の拡張
- 他のカスタム投稿タイプへの展開も同様の方式で可能
- スポンサーコンテンツのカスタマイズはテンプレートパーツで一元管理