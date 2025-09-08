<?php
/**
 * ACFフィールド設定
 * 
 * @package STEPJAM_Theme
 */

// セキュリティ対策
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ACFオプションページの作成
 */
function stepjam_acf_add_options_page() {
    if (function_exists('acf_add_options_page')) {
        // Site Settings オプションページ
        acf_add_options_page(array(
            'page_title' => 'Site Settings',
            'menu_title' => 'サイト設定',
            'menu_slug' => 'site-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-admin-settings',
            'position' => 30
        ));
        
        // Sponsor Settings オプションページ
        acf_add_options_page(array(
            'page_title' => 'スポンサー設定',
            'menu_title' => 'スポンサー',
            'menu_slug' => 'sponsor-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-star-filled',
            'position' => 31
        ));

        // WHSJ Settings オプションページ
        acf_add_options_page(array(
            'page_title' => 'WHSJ設定',
            'menu_title' => 'WHSJ',
            'menu_slug' => 'whsj-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-video-alt3',
            'position' => 32
        ));
    }
}
add_action('acf/init', 'stepjam_acf_add_options_page');

function stepjam_register_acf_fields() {
    if(!function_exists('acf_add_local_field_group')) {
        return;
    }

    // ダンサー登録の設定フィールドグループ（最適化版）
    acf_add_local_field_group(array(
        'key' => 'group_toroku_dancer',
        'title' => 'ダンサー登録設定',
        'fields' => array(
            // 基本情報タブ
            array(
                'key' => 'field_basic_info_tab',
                'label' => '基本情報',
                'name' => 'basic_info_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'ページ表示用の基本情報'
            ),
            
            // 実際に使用される表示用フィールドのみ
            array(
                'key' => 'field_dancer_genre',
                'label' => 'ダンサージャンル',
                'name' => 'dancer_genre',
                'type' => 'text',
                'instructions' => 'ページに表示されるジャンル名（例：HIP-HOP）',
                'required' => 0,
                'default_value' => 'HIP-HOP',
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            array(
                'key' => 'field_dancer_profile_text',
                'label' => 'プロフィール文章',
                'name' => 'dancer_profile_text',
                'type' => 'textarea',
                'instructions' => 'ページに表示されるプロフィール文章',
                'required' => 0,
                'rows' => 4,
                'new_lines' => 'br',
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            
            // SNSタブ
            array(
                'key' => 'field_sns_tab',
                'label' => 'SNS',
                'name' => 'sns_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'SNSリンク設定'
            ),
            array(
                'key' => 'field_toroku_instagram_url',
                'label' => 'Instagram URL',
                'name' => 'toroku_instagram_url',
                'type' => 'url',
                'instructions' => 'ページに表示するInstagram URL',
                'required' => 0
            ),
            
            // パフォーマンスタブ
            array(
                'key' => 'field_performance_tab',
                'label' => 'パフォーマンス',
                'name' => 'performance_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'パフォーマンス動画と画像'
            ),
            array(
                'key' => 'field_performance_video_1',
                'label' => 'パフォーマンス動画1',
                'name' => 'performance_video_1',
                'type' => 'url',
                'instructions' => 'YouTube URLを入力（1つ目の動画）',
                'required' => 0,
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            array(
                'key' => 'field_performance_video_2',
                'label' => 'パフォーマンス動画2',
                'name' => 'performance_video_2',
                'type' => 'url',
                'instructions' => 'YouTube URLを入力（2つ目の動画）',
                'required' => 0,
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            array(
                'key' => 'field_performance_fixed_image',
                'label' => 'パフォーマンス固定画像',
                'name' => 'performance_fixed_image',
                'type' => 'image',
                'instructions' => 'パフォーマンス用の固定画像をアップロード',
                'required' => 0,
                'return_format' => 'array',
                'library' => 'all',
                'wrapper' => array(
                    'width' => '100'
                )
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'toroku-dancer'
                )
            )
        ),
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label'
    ));

    // スポンサー設定のフィールドグループ
    acf_add_local_field_group(array(
        'key' => 'group_sponsor',
        'title' => 'スポンサー設定',
        'fields' => array(
            // メイン動画タブ
            array(
                'key' => 'field_sponsor_main_videos_tab',
                'label' => 'メイン動画',
                'name' => 'sponsor_main_videos_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'スポンサーメイン動画（3つまで）'
            ),
            array(
                'key' => 'field_sponsor_main_video_01',
                'label' => 'メイン動画1',
                'name' => 'sponsor_main_video_01',
                'type' => 'file',
                'instructions' => 'スポンサーメイン動画1（MP4推奨、10MB以下）',
                'required' => 0,
                'return_format' => 'array',
                'mime_types' => 'mp4,mov,avi'
            ),
            array(
                'key' => 'field_sponsor_main_video_02',
                'label' => 'メイン動画2',
                'name' => 'sponsor_main_video_02',
                'type' => 'file',
                'instructions' => 'スポンサーメイン動画2（MP4推奨、10MB以下）',
                'required' => 0,
                'return_format' => 'array',
                'mime_types' => 'mp4,mov,avi'
            ),
            array(
                'key' => 'field_sponsor_main_video_03',
                'label' => 'メイン動画3',
                'name' => 'sponsor_main_video_03',
                'type' => 'file',
                'instructions' => 'スポンサーメイン動画3（MP4推奨、10MB以下）',
                'required' => 0,
                'return_format' => 'array',
                'mime_types' => 'mp4,mov,avi'
            ),
            
            // ロゴスライドタブ
            array(
                'key' => 'field_sponsor_logos_tab',
                'label' => 'ロゴスライド',
                'name' => 'sponsor_logos_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'スポンサーロゴスライド（無制限）'
            ),
            array(
                'key' => 'field_sponsors_slides',
                'label' => 'スポンサースライド',
                'name' => 'sponsors_slides',
                'type' => 'repeater',
                'instructions' => 'スポンサーのロゴ画像を追加（無制限）',
                'sub_fields' => array(
                    array(
                        'key' => 'field_sponsor_logo',
                        'label' => 'スポンサーロゴ',
                        'name' => 'sponsor_logo',
                        'type' => 'image',
                        'instructions' => 'スポンサーのロゴ画像（推奨サイズ：横300px以上）',
                        'required' => 1,
                        'return_format' => 'array',
                        'wrapper' => array(
                            'width' => '30'
                        )
                    ),
                    array(
                        'key' => 'field_sponsor_name',
                        'label' => 'スポンサー名',
                        'name' => 'sponsor_name',
                        'type' => 'text',
                        'instructions' => 'スポンサー企業・団体名',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '35'
                        )
                    ),
                    array(
                        'key' => 'field_sponsor_url',
                        'label' => 'リンクURL',
                        'name' => 'sponsor_url',
                        'type' => 'url',
                        'instructions' => 'スポンサーサイトへのリンクURL（任意）',
                        'required' => 0,
                        'wrapper' => array(
                            'width' => '35'
                        )
                    )
                ),
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'スポンサーを追加',
                'collapsed' => 'field_sponsor_name'
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'sponsor-settings'
                )
            )
        ),
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label'
    ));

    // サイト設定のフィールドグループ
    acf_add_local_field_group(array(
        'key' => 'group_site_options',
        'title' => 'サイト設定',
        'fields' => array(
            // 基本設定タブ
            array(
                'key' => 'field_site_basic_tab',
                'label' => '基本設定',
                'name' => 'site_basic_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'サイトの基本設定項目'
            ),
            array(
                'key' => 'field_site_title_jp',
                'label' => 'サイトタイトル（日本語）',
                'name' => 'site_title_jp',
                'type' => 'text',
                'instructions' => 'サイトのメインタイトル（日本語表記）',
                'default_value' => 'STEPJAM',
                'required' => 1
            ),
            array(
                'key' => 'field_site_title_en',
                'label' => 'サイトタイトル（英語）',
                'name' => 'site_title_en',
                'type' => 'text',
                'instructions' => 'サイトのメインタイトル（英語表記）',
                'default_value' => 'STEPJAM',
                'required' => 1
            ),
            array(
                'key' => 'field_site_description',
                'label' => 'サイト説明文',
                'name' => 'site_description',
                'type' => 'textarea',
                'instructions' => 'サイトの説明文（SEO用）',
                'required' => 1,
                'rows' => 3
            ),
            
            // ヘッダー設定タブ
            array(
                'key' => 'field_header_tab',
                'label' => 'ヘッダー設定',
                'name' => 'header_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'ヘッダーエリアの設定'
            ),
            array(
                'key' => 'field_header_logo',
                'label' => 'ヘッダーロゴ',
                'name' => 'header_logo',
                'type' => 'image',
                'instructions' => 'ヘッダーに表示するロゴ画像（SVG推奨）',
                'required' => 1,
                'return_format' => 'array'
            ),
            array(
                'key' => 'field_header_menu_items',
                'label' => 'ヘッダーメニュー',
                'name' => 'header_menu_items',
                'type' => 'repeater',
                'instructions' => 'ヘッダーのナビゲーションメニュー項目',
                'sub_fields' => array(
                    array(
                        'key' => 'field_menu_label',
                        'label' => 'メニューラベル',
                        'name' => 'menu_label',
                        'type' => 'text',
                        'instructions' => '表示されるメニュー名',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '40'
                        )
                    ),
                    array(
                        'key' => 'field_menu_url',
                        'label' => 'リンクURL',
                        'name' => 'menu_url',
                        'type' => 'url',
                        'instructions' => 'リンク先URL',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '40'
                        )
                    ),
                    array(
                        'key' => 'field_menu_target',
                        'label' => 'リンク動作',
                        'name' => 'menu_target',
                        'type' => 'select',
                        'instructions' => 'リンクをクリック時の動作',
                        'choices' => array(
                            '_self' => '同じウィンドウで開く',
                            '_blank' => '新しいウィンドウで開く'
                        ),
                        'default_value' => '_self',
                        'wrapper' => array(
                            'width' => '20'
                        )
                    )
                ),
                'min' => 1,
                'max' => 8,
                'layout' => 'block',
                'button_label' => 'メニューを追加',
                'collapsed' => 'field_menu_label'
            ),
            
            // フッター設定タブ
            array(
                'key' => 'field_footer_tab',
                'label' => 'フッター設定',
                'name' => 'footer_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'フッターエリアの設定'
            ),
            array(
                'key' => 'field_footer_copyright',
                'label' => 'コピーライト',
                'name' => 'footer_copyright',
                'type' => 'text',
                'instructions' => 'フッターに表示するコピーライト',
                'default_value' => '© 2025 STEPJAM. All rights reserved.',
                'required' => 1
            ),
            array(
                'key' => 'field_footer_social_links',
                'label' => 'SNSリンク',
                'name' => 'footer_social_links',
                'type' => 'group',
                'instructions' => 'フッターに表示するSNSリンク',
                'sub_fields' => array(
                    array(
                        'key' => 'field_instagram_url',
                        'label' => 'Instagram URL',
                        'name' => 'instagram_url',
                        'type' => 'url',
                        'wrapper' => array(
                            'width' => '50'
                        )
                    ),
                    array(
                        'key' => 'field_twitter_url',
                        'label' => 'Twitter/X URL',
                        'name' => 'twitter_url',
                        'type' => 'url',
                        'wrapper' => array(
                            'width' => '50'
                        )
                    ),
                    array(
                        'key' => 'field_youtube_url',
                        'label' => 'YouTube URL',
                        'name' => 'youtube_url',
                        'type' => 'url',
                        'wrapper' => array(
                            'width' => '50'
                        )
                    ),
                    array(
                        'key' => 'field_tiktok_url',
                        'label' => 'TikTok URL',
                        'name' => 'tiktok_url',
                        'type' => 'url',
                        'wrapper' => array(
                            'width' => '50'
                        )
                    )
                )
            ),
            
            // SEO設定タブ
            array(
                'key' => 'field_seo_tab',
                'label' => 'SEO設定',
                'name' => 'seo_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'SEO関連の設定'
            ),
            array(
                'key' => 'field_og_image',
                'label' => 'OGP画像',
                'name' => 'og_image',
                'type' => 'image',
                'instructions' => 'SNSでシェアされる際に表示される画像（1200x630px推奨）',
                'return_format' => 'array'
            ),
            array(
                'key' => 'field_google_analytics_id',
                'label' => 'Google Analytics ID',
                'name' => 'google_analytics_id',
                'type' => 'text',
                'instructions' => 'Google Analytics の測定ID（G-XXXXXXXXXX）'
            ),
            array(
                'key' => 'field_google_tag_manager_id',
                'label' => 'Google Tag Manager ID',
                'name' => 'google_tag_manager_id',
                'type' => 'text',
                'instructions' => 'Google Tag Manager の コンテナID（GTM-XXXXXXX）'
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'site-settings'
                )
            )
        ),
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label'
    ));

    // WHSJ設定のフィールドグループ
    acf_add_local_field_group(array(
        'key' => 'group_whsj',
        'title' => 'WHSJ設定',
        'fields' => array(
            array(
                'key' => 'field_whsj_video',
                'label' => 'WHSJ動画',
                'name' => 'whsj_video',
                'type' => 'file',
                'instructions' => 'WHSJ動画ファイル（MP4推奨、10MB以下）',
                'required' => 0,
                'return_format' => 'array',
                'mime_types' => 'mp4,mov,avi'
            ),
            array(
                'key' => 'field_whsj_text_content',
                'label' => 'WHSJテキスト内容',
                'name' => 'whsj_text_content',
                'type' => 'textarea',
                'instructions' => 'WHSJ説明テキスト',
                'required' => 0,
                'rows' => 5,
                'new_lines' => 'br'
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'whsj-settings'
                )
            )
        ),
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label'
    ));

    // INFO・NEWS記事設定のフィールドグループ（テンプレート対応版）
    acf_add_local_field_group(array(
            'key' => 'group_info_news',
            'title' => 'INFO・NEWS 記事設定',
            'fields' => array(
            // 表示設定タブ
            array(
                'key' => 'field_info_news_display_tab',
                'label' => '表示設定',
                'name' => 'info_news_display_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => '記事の表示オプション'
            ),
            array(
                'key' => 'field_info_news_show_date',
                'label' => '日付を表示',
                'name' => 'info_news_show_date',
                'type' => 'true_false',
                'instructions' => '記事に公開日を表示する',
                'default_value' => 1,
                'ui' => 1
            ),
            array(
                'key' => 'field_info_news_show_category',
                'label' => 'カテゴリを表示',
                'name' => 'info_news_show_category',
                'type' => 'true_false',
                'instructions' => '記事にカテゴリ情報を表示する',
                'default_value' => 1,
                'ui' => 1
            ),
            
            // メディア設定タブ
            array(
                'key' => 'field_info_news_media_tab',
                'label' => 'メディア設定',
                'name' => 'info_news_media_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => '画像・動画の設定'
            ),
            array(
                'key' => 'field_info_news_visual_type',
                'label' => '表示タイプ',
                'name' => 'info_news_visual_type',
                'type' => 'select',
                'instructions' => '記事に表示するメディアのタイプ',
                'choices' => array(
                    'image' => '画像',
                    'video' => '動画'
                ),
                'default_value' => 'image',
                'allow_null' => 0,
                'required' => 1
            ),
            array(
                'key' => 'field_info_news_image',
                'label' => 'メイン画像',
                'name' => 'info_news_image',
                'type' => 'image',
                'instructions' => '記事のメイン画像',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_info_news_visual_type',
                            'operator' => '==',
                            'value' => 'image'
                        )
                    )
                )
            ),
            array(
                'key' => 'field_info_news_video_url',
                'label' => '動画URL',
                'name' => 'info_news_video_url',
                'type' => 'url',
                'instructions' => 'YouTube等の動画URL',
                'placeholder' => 'https://www.youtube.com/watch?v=...',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_info_news_visual_type',
                            'operator' => '==',
                            'value' => 'video'
                        )
                    )
                )
            ),
            array(
                'key' => 'field_info_news_video_thumbnail',
                'label' => '動画サムネイル',
                'name' => 'info_news_video_thumbnail',
                'type' => 'image',
                'instructions' => '動画のサムネイル画像',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_info_news_visual_type',
                            'operator' => '==',
                            'value' => 'video'
                        )
                    )
                )
            ),
            
            // ボタン設定タブ
            array(
                'key' => 'field_info_news_button_tab',
                'label' => 'ボタン設定',
                'name' => 'info_news_button_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'リンクボタンの設定'
            ),
            array(
                'key' => 'field_info_news_show_button',
                'label' => 'ボタンを表示',
                'name' => 'info_news_show_button',
                'type' => 'true_false',
                'instructions' => 'リンクボタンを表示する',
                'default_value' => 0,
                'ui' => 1
            ),
            array(
                'key' => 'field_info_news_button_text',
                'label' => 'ボタンテキスト',
                'name' => 'info_news_button_text',
                'type' => 'text',
                'instructions' => 'ボタンに表示するテキスト',
                'default_value' => '詳細を見る',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_info_news_show_button',
                            'operator' => '==',
                            'value' => '1'
                        )
                    )
                )
            ),
            array(
                'key' => 'field_info_news_button_url',
                'label' => 'ボタンURL',
                'name' => 'info_news_button_url',
                'type' => 'url',
                'instructions' => 'ボタンのリンク先URL',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_info_news_show_button',
                            'operator' => '==',
                            'value' => '1'
                        )
                    )
                )
            ),
            array(
                'key' => 'field_info_news_button_target',
                'label' => 'ボタンのターゲット',
                'name' => 'info_news_button_target',
                'type' => 'select',
                'instructions' => 'リンクの開き方',
                'choices' => array(
                    '_self' => '同じウィンドウで開く',
                    '_blank' => '新しいウィンドウで開く'
                ),
                'default_value' => '_blank',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_info_news_show_button',
                            'operator' => '==',
                            'value' => '1'
                        )
                    )
                )
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'info-news'
                )
            )
        ),
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label'
    ));

    // NX TOKYO イベント設定のフィールドグループ
    acf_add_local_field_group(array(
        'key' => 'group_nx_tokyo',
        'title' => 'NEXT SJ イベント設定',
        'fields' => array(
            // ヘッダー設定タブ
            array(
                'key' => 'field_nx_header_tab',
                'label' => 'ヘッダー設定',
                'name' => 'nx_header_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'NX TOKYOページヘッダー情報'
            ),
            array(
                'key' => 'field_nx_event_title',
                'label' => 'イベントタイトル',
                'name' => 'nx_event_title',
                'type' => 'text',
                'instructions' => 'メインタイトル（例：STEPJAM TOKYO）',
                'default_value' => 'STEPJAM TOKYO',
                'required' => 1
            ),
            array(
                'key' => 'field_nx_event_subtitle',
                'label' => 'サブタイトル',
                'name' => 'nx_event_subtitle',
                'type' => 'text',
                'instructions' => 'サブタイトル（例：2025 SUMMER）',
                'default_value' => '2025 SUMMER',
                'required' => 1
            ),
            
            // コンテンツブロックタブ
            array(
                'key' => 'field_nx_content_tab',
                'label' => 'コンテンツブロック',
                'name' => 'nx_content_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'ACFリピート nx-content-areablockの設定'
            ),
            array(
                'key' => 'field_nx_content_blocks',
                'label' => 'コンテンツブロック',
                'name' => 'nx_content_blocks',
                'type' => 'repeater',
                'instructions' => 'コンテンツエリアのブロックを追加（タイトルと内容のセット）',
                'sub_fields' => array(
                    array(
                        'key' => 'field_nx_block_title',
                        'label' => 'タイトル',
                        'name' => 'block_title',
                        'type' => 'text',
                        'instructions' => 'ブロックのタイトル（acf-タイトル）',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '30'
                        )
                    ),
                    array(
                        'key' => 'field_nx_block_content',
                        'label' => '内容',
                        'name' => 'block_content',
                        'type' => 'textarea',
                        'instructions' => 'ブロックの内容（acf-内容）',
                        'required' => 1,
                        'rows' => 4,
                        'new_lines' => 'br',
                        'wrapper' => array(
                            'width' => '70'
                        )
                    )
                ),
                'min' => 1,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'コンテンツブロックを追加',
                'collapsed' => 'field_nx_block_title'
            ),
            
            // ビジュアル設定タブ
            array(
                'key' => 'field_nx_visual_tab',
                'label' => 'ビジュアル設定',
                'name' => 'nx_visual_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'ヘッダーエリアのビジュアル設定'
            ),
            array(
                'key' => 'field_nx_area_selection',
                'label' => 'エリア選択',
                'name' => 'nx_area_selection',
                'type' => 'radio',
                'instructions' => 'イベントエリアを選択してください（ベクター画像と背景色が変わります）',
                'choices' => array(
                    'none' => 'なし',
                    'tokyo' => 'TOKYO',
                    'osaka' => 'OSAKA',
                    'tohoku' => 'TOHOKU'
                ),
                'default_value' => 'none',
                'layout' => 'horizontal',
                'required' => 1
            ),
            array(
                'key' => 'field_nx_background_image',
                'label' => '背景画像',
                'name' => 'nx_background_image',
                'type' => 'image',
                'instructions' => 'nx-area1の背景画像（jpg, png, webp推奨）',
                'required' => 0,
                'return_format' => 'array',
                'mime_types' => 'jpg,jpeg,png,webp'
            ),
            array(
                'key' => 'field_nx_background_video',
                'label' => '背景動画',
                'name' => 'nx_background_video',
                'type' => 'file',
                'instructions' => 'nx-area1の背景動画（mp4推奨、10MB以下）',
                'required' => 0,
                'return_format' => 'array',
                'mime_types' => 'mp4'
            ),
            array(
                'key' => 'field_nx_background_priority',
                'label' => '背景表示優先度',
                'name' => 'nx_background_priority',
                'type' => 'radio',
                'instructions' => '画像と動画が両方設定されている場合の表示優先度',
                'choices' => array(
                    'image' => '画像優先',
                    'video' => '動画優先'
                ),
                'default_value' => 'image',
                'layout' => 'horizontal',
                'required' => 1
            ),
            
            // 出演ダンサー設定タブ
            array(
                'key' => 'field_nx_dancers_tab',
                'label' => '出演ダンサー設定',
                'name' => 'nx_dancers_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'DAY1/DAY2の出演ダンサーセクション設定'
            ),
            array(
                'key' => 'field_nx_dancers_section_show',
                'label' => '出演ダンサーセクションを表示',
                'name' => 'nx_dancers_section_show',
                'type' => 'true_false',
                'instructions' => '出演ダンサーセクション全体の表示・非表示',
                'default_value' => 1,
                'ui' => 1
            ),
            array(
                'key' => 'field_nx_day1_show',
                'label' => 'DAY1を表示',
                'name' => 'nx_day1_show',
                'type' => 'true_false',
                'instructions' => 'DAY1セクションの表示・非表示（非表示の場合、DAY2が100vw占有）',
                'default_value' => 1,
                'ui' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_nx_dancers_section_show',
                            'operator' => '==',
                            'value' => '1'
                        )
                    )
                )
            ),
            array(
                'key' => 'field_nx_day2_show',
                'label' => 'DAY2を表示',
                'name' => 'nx_day2_show',
                'type' => 'true_false',
                'instructions' => 'DAY2セクションの表示・非表示（非表示の場合、DAY1が100vw占有）',
                'default_value' => 1,
                'ui' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_nx_dancers_section_show',
                            'operator' => '==',
                            'value' => '1'
                        )
                    )
                )
            ),
            
            // DAY1スライダーコンテナ
            array(
                'key' => 'field_nx_day1_sliders',
                'label' => 'DAY1スライダーコンテナ',
                'name' => 'nx_day1_sliders',
                'type' => 'repeater',
                'instructions' => 'DAY1のジャンル別スライダーを追加（各ジャンルごとに1つのスライダー）',
                'sub_fields' => array(
                    array(
                        'key' => 'field_day1_genre_name',
                        'label' => 'ジャンル名',
                        'name' => 'genre_name',
                        'type' => 'text',
                        'instructions' => 'スライダーのジャンルタイトル（例：CHOREOGRAPHER）',
                        'required' => 1,
                        'default_value' => 'CHOREOGRAPHER',
                        'wrapper' => array('width' => '100')
                    ),
                    array(
                        'key' => 'field_day1_dancer_slides',
                        'label' => 'ダンサースライド',
                        'name' => 'dancer_slides',
                        'type' => 'repeater',
                        'instructions' => 'このジャンルのダンサースライドを追加',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_day1_dancer_bg_image',
                                'label' => '背景画像',
                                'name' => 'dancer_bg_image',
                                'type' => 'image',
                                'instructions' => 'ダンサーの背景画像（278x274.5px推奨）',
                                'required' => 0,
                                'return_format' => 'array',
                                'wrapper' => array('width' => '40')
                            ),
                            array(
                                'key' => 'field_day1_dancer_name',
                                'label' => 'ダンサー名',
                                'name' => 'dancer_name',
                                'type' => 'text',
                                'instructions' => '表示するダンサー名',
                                'required' => 1,
                                'wrapper' => array('width' => '30')
                            ),
                            array(
                                'key' => 'field_day1_dancer_link',
                                'label' => 'リンクURL',
                                'name' => 'dancer_link',
                                'type' => 'url',
                                'instructions' => 'クリック時のリンク先（任意）',
                                'required' => 0,
                                'wrapper' => array('width' => '30')
                            )
                        ),
                        'min' => 1,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => 'ダンサーを追加',
                        'collapsed' => 'field_day1_dancer_name'
                    )
                ),
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'ジャンルスライダーを追加',
                'collapsed' => 'field_day1_genre_name',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_nx_day1_show',
                            'operator' => '==',
                            'value' => '1'
                        )
                    )
                )
            ),
            
            // DAY2スライダーコンテナ
            array(
                'key' => 'field_nx_day2_sliders',
                'label' => 'DAY2スライダーコンテナ',
                'name' => 'nx_day2_sliders',
                'type' => 'repeater',
                'instructions' => 'DAY2のジャンル別スライダーを追加（各ジャンルごとに1つのスライダー）',
                'sub_fields' => array(
                    array(
                        'key' => 'field_day2_genre_name',
                        'label' => 'ジャンル名',
                        'name' => 'genre_name',
                        'type' => 'text',
                        'instructions' => 'スライダーのジャンルタイトル（例：CHOREOGRAPHER）',
                        'required' => 1,
                        'default_value' => 'CHOREOGRAPHER',
                        'wrapper' => array('width' => '100')
                    ),
                    array(
                        'key' => 'field_day2_dancer_slides',
                        'label' => 'ダンサースライド',
                        'name' => 'dancer_slides',
                        'type' => 'repeater',
                        'instructions' => 'このジャンルのダンサースライドを追加',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_day2_dancer_bg_image',
                                'label' => '背景画像',
                                'name' => 'dancer_bg_image',
                                'type' => 'image',
                                'instructions' => 'ダンサーの背景画像（278x274.5px推奨）',
                                'required' => 0,
                                'return_format' => 'array',
                                'wrapper' => array('width' => '40')
                            ),
                            array(
                                'key' => 'field_day2_dancer_name',
                                'label' => 'ダンサー名',
                                'name' => 'dancer_name',
                                'type' => 'text',
                                'instructions' => '表示するダンサー名',
                                'required' => 1,
                                'wrapper' => array('width' => '30')
                            ),
                            array(
                                'key' => 'field_day2_dancer_link',
                                'label' => 'リンクURL',
                                'name' => 'dancer_link',
                                'type' => 'url',
                                'instructions' => 'クリック時のリンク先（任意）',
                                'required' => 0,
                                'wrapper' => array('width' => '30')
                            )
                        ),
                        'min' => 1,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => 'ダンサーを追加',
                        'collapsed' => 'field_day2_dancer_name'
                    )
                ),
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'ジャンルスライダーを追加',
                'collapsed' => 'field_day2_genre_name',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_nx_day2_show',
                            'operator' => '==',
                            'value' => '1'
                        )
                    )
                )
            ),

            // ナビゲーション設定タブ
            array(
                'key' => 'field_nx_navigation_tab',
                'label' => 'ナビゲーション設定',
                'name' => 'nx_navigation_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'メインナビゲーションメニューとの連携設定'
            ),
            array(
                'key' => 'field_nx_nav_menu_area',
                'label' => 'ナビメニュー対象エリア',
                'name' => 'nx_nav_menu_area',
                'type' => 'radio',
                'instructions' => 'このページをメインナビゲーションの対象エリアに設定（1エリアにつき1ページのみ選択可能）',
                'choices' => array(
                    'none' => '非表示',
                    'tokyo' => 'TOKYO',
                    'osaka' => 'OSAKA',
                    'tohoku' => 'TOHOKU'
                ),
                'default_value' => 'none',
                'layout' => 'horizontal',
                'required' => 1,
                'wrapper' => array(
                    'width' => '100'
                )
            ),
            
            // ボタン設定タブ
            array(
                'key' => 'field_nx_buttons_tab',
                'label' => 'ボタン設定',
                'name' => 'nx_buttons_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => '各種ボタンの設定'
            ),
            array(
                'key' => 'field_nx_day1_button_link',
                'label' => 'DAY1リンク',
                'name' => 'nx_day1_link',
                'type' => 'url',
                'instructions' => 'DAY1ボタンのリンク先（空の場合はボタン非表示）',
                'required' => 0
            ),
            array(
                'key' => 'field_nx_day2_button_link',
                'label' => 'DAY2リンク',
                'name' => 'nx_day2_link',
                'type' => 'url',
                'instructions' => 'DAY2ボタンのリンク先（空の場合はボタン非表示）',
                'required' => 0
            ),
            array(
                'key' => 'field_nx_ticket_link',
                'label' => 'チケットリンク',
                'name' => 'nx_ticket_link',
                'type' => 'url',
                'instructions' => 'チケットボタンのリンク先（空の場合はボタン非表示）',
                'required' => 0
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'nx-tokyo'
                )
            )
        ),
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label'
    ));
}
add_action('acf/init', 'stepjam_register_acf_fields');

/**
 * ACFフィールド値取得のヘルパー関数
 */
function stepjam_get_site_option($field_name, $default = '') {
    if (function_exists('get_field')) {
        $value = get_field($field_name, 'option');
        return $value ?: $default;
    }
    return $default;
}

/**
 * YouTube URL をiframe埋め込みHTMLに変換
 */
function stepjam_youtube_url_to_iframe($url, $width = '100%', $height = '315') {
    if (empty($url)) {
        return '';
    }
    
    // YouTube URL パターン解析
    $patterns = array(
        '/youtube\.com\/watch\?v=([^&\n]+)/',
        '/youtube\.com\/embed\/([^&\n]+)/',
        '/youtu\.be\/([^&\n]+)/'
    );
    
    $video_id = '';
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            $video_id = $matches[1];
            break;
        }
    }
    
    if (empty($video_id)) {
        return '';
    }
    
    return sprintf(
        '<iframe width="%s" height="%s" src="https://www.youtube.com/embed/%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
        esc_attr($width),
        esc_attr($height),
        esc_attr($video_id)
    );
}

/**
 * toroku-dancer投稿の取得関数（アイキャッチ画像必須）
 */
function stepjam_get_dancers_with_acf($location = '', $count = -1) {
    $args = array(
        'post_type' => 'toroku-dancer',
        'posts_per_page' => $count,
        'orderby' => 'rand',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            )
        )
    );

    // ロケーション指定がある場合
    if (!empty($location)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'toroku-dancer-location',
                'field' => 'slug',
                'terms' => $location
            )
        );
    }

    return new WP_Query($args);
}

/**
 * FAQフィールドグループの登録
 */
function stepjam_register_faq_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_faq',
        'title' => 'FAQ Management',
        'fields' => array(
            // 質問タブ
            array(
                'key' => 'field_faq_question_tab',
                'label' => '質問',
                'name' => 'faq_question_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => 'よくある質問の内容'
            ),
            array(
                'key' => 'field_faq_question',
                'label' => '質問',
                'name' => 'faq_question',
                'type' => 'textarea',
                'instructions' => 'ユーザーからのよくある質問を入力してください',
                'required' => 1,
                'rows' => 3,
                'new_lines' => 'br',
                'placeholder' => '例：STEPJAMへの参加方法を教えてください',
                'wrapper' => array(
                    'width' => '100'
                )
            ),
            
            // 回答タブ  
            array(
                'key' => 'field_faq_answer_tab',
                'label' => '回答',
                'name' => 'faq_answer_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => '質問に対する回答'
            ),
            array(
                'key' => 'field_faq_answer',
                'label' => '回答',
                'name' => 'faq_answer',
                'type' => 'wysiwyg',
                'instructions' => '質問に対する詳細な回答を入力してください。HTMLタグも使用できます。',
                'required' => 1,
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 1,
                'wrapper' => array(
                    'width' => '100'
                )
            ),
            
            // 表示設定タブ
            array(
                'key' => 'field_faq_display_tab',
                'label' => '表示設定',
                'name' => 'faq_display_tab',
                'type' => 'tab',
                'placement' => 'top',
                'instructions' => '表示順序と公開状態の設定'
            ),
            array(
                'key' => 'field_faq_order',
                'label' => '表示順序',
                'name' => 'faq_order',
                'type' => 'number',
                'instructions' => '数値が小さいほど上位に表示されます（0が最上位）',
                'required' => 1,
                'default_value' => 0,
                'min' => 0,
                'max' => 9999,
                'step' => 1,
                'placeholder' => '0',
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            array(
                'key' => 'field_faq_published',
                'label' => '公開状態',
                'name' => 'faq_published',
                'type' => 'true_false',
                'instructions' => '公開するFAQの場合はONにしてください',
                'required' => 1,
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => '公開',
                'ui_off_text' => '非公開',
                'wrapper' => array(
                    'width' => '50'
                )
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'faq'
                )
            )
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array('the_content'),
        'active' => true,
        'description' => 'FAQページで使用する質問と回答、表示設定を管理します。'
    ));
}
add_action('acf/init', 'stepjam_register_faq_fields');