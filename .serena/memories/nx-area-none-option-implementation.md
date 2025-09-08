# NEXT SJエリア選択「なし」オプション実装完了

## 実装概要
NEXT SJ カスタム投稿タイプに「エリアベクターを非表示にする」ラジオボタン「なし」を追加

## 実装詳細

### 1. ACFフィールド修正 (inc/acf-fields.php)
```php
'choices' => array(
    'none' => 'なし',
    'tokyo' => 'TOKYO',
    'osaka' => 'OSAKA',
    'tohoku' => 'TOHOKU'
),
'default_value' => 'none',
```

### 2. PHP条件分岐修正 (single-nx-tokyo.php)
- area_configs配列に'none'設定追加
- ヘッダー表示条件: `<?php if ($area_selection && $area_selection !== 'none') : ?>`
- 非表示時はnx-header-spacer要素で代替

### 3. CSS追加
```css
.nx-area1.area-none {
  background-color: transparent;
}

.nx-tokyo-container.area-none .dancers-section__day--day2 {
  background-color: transparent !important;
}
```

### 4. JavaScript背景色制御
```javascript
if (container.classList.contains('area-none')) {
    bgColor = 'transparent'; // なし 透明
}
```

## 動作確認結果
✅ area-noneクラス設定正常
✅ ヘッダーエリア完全非表示
✅ 背景画像・動画表示継続  
✅ DAY2セクション透明背景
✅ すべての仕様要件満足

## バックアップ場所
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/nx-area-none-option/

## テスト実行済み
- 手動JavaScriptテスト: 100%成功
- area-noneクラス正常適用確認済み

## 実装日時
2025-09-02