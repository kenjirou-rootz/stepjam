# Info & News 日付トグル「info」テキスト表示実装

## 実装日
2025-08-31

## 実装内容
Info & Newsセクションで、日付表示をOFFにした際に「info」というテキストを表示する機能を実装

## 実装ファイル
- `/template-parts/news-info-section.php`

## 実装詳細

### デスクトップ版（64-76行目付近）
```php
<?php if ($show_date): ?>
    <time class="info-date" datetime="<?php echo get_the_date('c'); ?>">
        <?php echo get_the_date('m'); ?><br><?php echo get_the_date('d'); ?>
    </time>
<?php else: ?>
    <div class="info-date">
        info
    </div>
<?php endif; ?>
```

### モバイル版（183-194行目付近）
```php
<?php if ($show_date): ?>
    <time class="mobile-info-date" datetime="<?php echo get_the_date('c'); ?>">
        <?php echo get_the_date('m'); ?><br><?php echo get_the_date('d'); ?>
    </time>
<?php else: ?>
    <div class="mobile-info-date">
        info
    </div>
<?php endif; ?>
```

## スタイル
既存の`.info-date`および`.mobile-info-date`クラスのスタイルをそのまま活用：
- 白背景（#fff）
- 黒文字（#000）
- 太字（font-weight: 700）
- 中央揃え（text-align: center）
- パディングとフォントサイズはレスポンシブ対応（clamp関数使用）

## 動作仕様
1. **日付表示ON時**: ACFフィールド`info_news_show_date`がtrueの場合、日付を表示
2. **日付表示OFF時**: ACFフィールド`info_news_show_date`がfalseの場合、「info」テキストを表示
3. **レイアウト保持**: どちらの場合も同じクラスを使用するため、CSS Gridレイアウトが崩れない

## 検証結果
Playwright MCPでの検証により、デスクトップ・モバイル両方で正常に動作することを確認済み