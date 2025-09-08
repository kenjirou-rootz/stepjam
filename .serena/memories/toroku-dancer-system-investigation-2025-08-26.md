# toroku-dancer システム調査結果

## 調査概要
**日時**: 2025年8月26日  
**対象URL**: http://stepjam.local/toroku-dancer/  
**SuperClaude Framework**: `--ultrathink --serena --play --c7`

## 1. システム構造確認

### 1.1 URL構造と動作確認
- **アーカイブページ**: http://stepjam.local/toroku-dancer/ → 404エラー（設計通り）
- **個別ページ**: http://stepjam.local/toroku-dancer/[スラッグ]/ → 正常動作
- **実例**: http://stepjam.local/toroku-dancer/テストダンサー/ → 正常表示

### 1.2 記事出力の仕組み
- **表示場所**: front-page.php の lib-list-cards-area セクション
- **データ取得関数**: `stepjam_get_dancers_with_acf($location, $count)`
- **表示方式**: ランダム表示 (`orderby => 'rand'`)
- **表示条件**: 
  - 公開済み (`post_status => 'publish'`)
  - アイキャッチ画像必須 (`'_thumbnail_id' EXISTS`)
  - エリア別絞り込み (tokyo/osaka タクソノミー)

### 1.3 現在登録されているダンサー（確認済み）
1. テストダンサー (URL: /toroku-dancer/テストダンサー/)
2. ；k；jpj (URL: /toroku-dancer/；k；jpj/)
3. 佐伯たくや (URL: /toroku-dancer/佐伯たくや/)
4. lkjlふいg (URL: /toroku-dancer/lkjlふいg/)
5. KENJIROU (URL: /toroku-dancer/test-dancer/)

## 2. テンプレート構造分析

### 2.1 single-toroku-dancer.php の構造
- **メインコンテナ**: `.toroku-dancer-detail`
- **レイアウト分離**: デスクトップ (`.desktop-layout`) とモバイル (`.mobile-layout`) 完全分離
- **セクション構成**:
  - ヘッダー: ダンサー名 (h1) + ジャンル (p)
  - Performance セクション (h2)
  - Profile セクション (h2)

### 2.2 ACFフィールド取得
**確認済みフィールド**:
```php
$dancer_genre = get_field('dancer_genre') ?: 'HIP-HOP';
$dancer_profile_text = get_field('dancer_profile_text') ?: '';
$performance_video_1 = get_field('performance_video_1') ?: '';
$performance_video_2 = get_field('performance_video_2') ?: '';
$instagram_url = get_field('toroku_instagram_url') ?: '';
$twitter_url = get_field('toroku_twitter_url') ?: '';
$youtube_url = get_field('toroku_youtube_url') ?: '';
$tiktok_url = get_field('toroku_tiktok_url') ?: '';
```

## 3. CSS スタイル詳細分析

### 3.1 メインコンテナ
```css
.toroku-dancer-detail {
    background-color: var(--dancer-bg-black);
    min-height: 100vh;
    width: 100%;
    overflow: hidden;
}
```

### 3.2 デスクトップレイアウト
```css
.desktop-layout {
    display: grid;
    grid-template-columns: var(--dancer-desktop-left) var(--dancer-desktop-right);
    height: 100vh;
    width: 100%;
}
```

#### 主要スタイル:
- **ダンサー名**: `font-size: clamp(48px, 5vw, 80px); font-weight: 900;`
- **ジャンル**: `font-size: clamp(20px, 2vw, 32px); font-weight: 400;`
- **セクションタイトル**: `font-size: clamp(24px, 2.5vw, 36px);`
- **サムネイルエリア**: `background-color: #3a44ff;`
- **動画コンテナ**: `grid-template-columns: 1fr 1fr; gap: var(--dancer-gap);`

### 3.3 モバイルレイアウト
```css
.mobile-layout {
    background-color: var(--dancer-bg-black);
    min-height: 100vh;
    padding-bottom: 60px;
}
```

#### モバイル専用スタイル:
- **ダンサー名**: `font-size: clamp(64px, 16vw, 120px);`
- **サムネイル**: `height: 70vh;`
- **Swiper対応**: `.performance-slider`

### 3.4 重要なCSSクラス一覧
**特定済みクラス**:
- `.toroku-dancer-detail` - メインコンテナ
- `.dancer-name` - ダンサー名
- `.dancer-genre` - ジャンル表示
- `.performance-section` - Performance セクション
- `.profile-section` - Profile セクション
- `.desktop-layout` / `.mobile-layout` - レイアウト分岐
- `.thumbnail-area` - サムネイル領域
- `.videos-container` - 動画コンテナ
- `.profile-content` - プロフィールコンテンツ
- `.sns-icons` - SNSアイコン群

## 4. 実際の表示確認結果

### 4.1 Playwright検証結果
**テストダンサーページ**: http://stepjam.local/toroku-dancer/テストダンサー/

#### 表示内容:
- **ダンサー名**: テストダンサー
- **ジャンル**: BREAKIN
- **Performance セクション**: 表示済み（動画なし）
- **Profile セクション**: 表示済み
- **プロフィール文**: "ブレイクダンス歴10年。バトルやコンテストで数多くの受賞歴があります。初心者からプロまでレッスンを行っています。"

#### レイアウト確認:
- デスクトップ・モバイル両レイアウトが存在
- レスポンシブ対応正常
- セクション構造が設計通り動作

## 5. 改修サポート準備状況

### 5.1 システム理解度
✅ **完了項目**:
- URL構造と動作仕様の把握
- テンプレートファイル構造の分析
- CSS スタイル詳細の特定
- ACF フィールド構成の確認
- 実際の表示動作の検証

### 5.2 改修対応可能領域
**対応可能な修正項目**:
1. **CSS スタイル調整**: フォントサイズ、色、レイアウト変更
2. **レスポンシブ対応**: デスクトップ・モバイル個別調整
3. **セクション構造変更**: Performance/Profile セクションの調整
4. **ACF フィールド追加・修正**: 新規フィールド追加や既存修正
5. **テンプレート機能拡張**: 新機能追加や表示ロジック変更

## 6. 重要な設計思想

### 6.1 完全分離設計
- デスクトップ・モバイルHTML完全分離
- 各レイアウト専用CSS設計
- レスポンシブ切り替えはCSS display制御

### 6.2 パフォーマンス配慮
- アイキャッチ画像必須制約
- ランダム表示による負荷分散
- vh/vw単位による viewport対応

## 結論
**改修サポート準備完了**: toroku-dancer システムの構造、スタイル、データフローを完全に把握し、あらゆる改修要求に対応可能な状態です。

**SuperClaude Framework活用**: 
- Sequential thinking による構造分析
- Playwright による実機確認
- Serena による記録管理
- Context7 によるWordPress知識活用

**次回対応**: 具体的な改修要求に応じて即座に対応可能です。