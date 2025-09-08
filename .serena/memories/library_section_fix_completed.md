# ライブラリセクション修正完了記録

## 修正日時
2025-09-02

## 問題の詳細
ユーザーからライブラリセクションの以下の問題が報告された：

1. **視覚的変更**: ボタンがONでなくても50/50vwで東京・大阪のカードが両方表示されている
2. **動作問題**: ボタンによる切り替えが適切に機能していない
3. **レイアウト要件**: 
   - デスクトップ：1行4つのリスト、5つ目以降は折り返し
   - スマホ：1行2つのリスト、折り返し
4. **期待動作**: ボタン選択によるエリアタグフィルタリング表示、タイトル画像の切り替え

## 根本原因
main.jsの`switchLibraryTab`関数において、デスクトップモード（768px+）で以下の問題が発生：

```javascript
// 問題のあったコード（276-281行目）
if (isDesktopMode) {
    // Desktop (768px+): Show both areas side by side (day1/day2 horizontal layout)
    if (tokyoDancersDesktop) tokyoDancersDesktop.classList.remove('hidden');
    if (osakaDancersDesktop) osakaDancersDesktop.classList.remove('hidden');
}
```

選択されたタブに関係なく、常に両方のダンサーエリアが表示されていた。

## 実施した修正

### 1. バックアップ作成
```
/Users/hayashikenjirou/Local Sites/stepjam/バックアップ/library-section-fix/
├── front-page_backup_20250902_HHMMSS.php
└── main_backup_20250902_HHMMSS.js
```

### 2. main.js修正内容

#### タイトル表示ロジック修正（247-260行目）
```javascript
if (isDesktopMode) {
    // Desktop (768px+): Show selected title only
    if (selectedTab === 'tokyo') {
        // Show Tokyo title
        if (tokyoTitleDesktop) tokyoTitleDesktop.classList.remove('hidden');
        if (osakaTitleDesktop) osakaTitleDesktop.classList.add('hidden');
    } else {
        // Show Osaka title
        if (tokyoTitleDesktop) tokyoTitleDesktop.classList.add('hidden');
        if (osakaTitleDesktop) osakaTitleDesktop.classList.remove('hidden');
    }
}
```

#### ダンサー表示ロジック修正（283-296行目）
```javascript
if (isDesktopMode) {
    // Desktop (768px+): Show selected area only
    if (selectedTab === 'tokyo') {
        // Show Tokyo dancers
        if (tokyoDancersDesktop) tokyoDancersDesktop.classList.remove('hidden');
        if (osakaDancersDesktop) osakaDancersDesktop.classList.add('hidden');
    } else {
        // Show Osaka dancers
        if (tokyoDancersDesktop) tokyoDancersDesktop.classList.add('hidden');
        if (osakaDancersDesktop) osakaDancersDesktop.classList.remove('hidden');
    }
}
```

## 修正後の動作確認

### Playwrightテスト結果
1. **初期状態（TOKYOボタンアクティブ）**:
   - タイトル: "Tokyo Library"のみ表示
   - ダンサー: TOKYOエリア4名のみ表示

2. **OSAKAボタンクリック後**:
   - タイトル: "Osaka Library"のみ表示
   - ダンサー: OSAKAエリア1名のみ表示
   - TOKYOダンサーは完全に非表示

3. **TOKYOボタン復帰**:
   - 正常に元の状態に戻る

### レスポンシブ動作
- デスクトップ（1920px）: 正常動作
- モバイル（375px）: 正常動作、適切な2列レイアウト

## 技術的詳細

### 対象ファイル
- `/app/public/wp-content/themes/stepjam-theme/assets/js/main.js`

### 修正箇所
- 247-260行目: タイトル表示ロジック
- 283-296行目: ダンサー表示ロジック

### 関連する要素ID
- `lib-title-tokyo`, `lib-title-osaka` (デスクトップタイトル)
- `tokyo-dancers`, `osaka-dancers` (デスクトップダンサーエリア)
- `lib-title-tokyo-mobile`, `lib-title-osaka-mobile` (モバイルタイトル)  
- `tokyo-dancers-mobile`, `osaka-dancers-mobile` (モバイルダンサーエリア)

### データソース
- カスタム投稿タイプ: `toroku-dancer`
- タクソノミー: `toroku-dancer-location`
- 関数: `stepjam_get_dancers_with_acf($location, $count)`

## 解決された問題
✅ 50/50vw両方表示問題の解決
✅ 適切なエリアタグフィルタリング機能の復元
✅ タイトル画像の切り替え機能の実装
✅ ボタン切り替え動作の正常化
✅ レスポンシブ対応の確認

## 今後の保守ポイント
- デスクトップモードでの切り替えロジックは選択されたタブのみ表示
- モバイルモードは既存の実装が正しく動作
- `switchLibraryTab`関数の変更時は両モードでの動作確認必須