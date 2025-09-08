<?php
/**
 * Contact Page Template (page-contact.php)
 * Automatically applies to pages with 'contact' slug
 * 
 * @package STEPJAM_Theme
 */

get_header(); ?>

<!-- Contact Page - Ultra Think Implementation -->
<div class="site-responsive-wrapper">

    <main class="site-main relative w-full bg-black min-h-screen">
        
        <!-- Contact Hero Section -->
        <section id="contact-hero" class="relative w-full bg-black overflow-hidden pt-20 pb-16">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 font-[Noto_Sans_JP]">
                        CONTACT
                    </h1>
                    <p class="text-white/60 text-lg mb-2 font-[Noto_Sans_JP]">
                        お問い合わせ
                    </p>
                    <div class="w-20 h-1 bg-white/20 mx-auto"></div>
                </div>
            </div>
        </section>
        
        <!-- Contact Form Section -->
        <section id="contact-form" class="relative w-full bg-black py-16">
            <div class="container mx-auto px-4 max-w-4xl">
                
                <!-- Form Header -->
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-4 font-[Noto_Sans_JP]">
                        イベントに関するお問い合わせ
                    </h2>
                    <p class="text-white/60 font-[Noto_Sans_JP]">
                        下記フォームよりお気軽にお問い合わせください
                    </p>
                </div>
                
                <!-- Contact Form -->
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-8 md:p-12 border border-white/10">
                    
                    <!-- Success Message (Hidden by default) -->
                    <div id="contact-success" class="hidden bg-green-500/20 border border-green-500/30 text-green-300 p-4 rounded-lg mb-8">
                        <p class="font-[Noto_Sans_JP]">✓ お問い合わせありがとうございます。確認次第ご連絡いたします。</p>
                    </div>
                    
                    <!-- Error Message (Hidden by default) -->
                    <div id="contact-error" class="hidden bg-red-500/20 border border-red-500/30 text-red-300 p-4 rounded-lg mb-8">
                        <p class="font-[Noto_Sans_JP]">✗ 送信に失敗しました。必須項目を確認してください。</p>
                    </div>
                    
                    <form id="stepjam-contact-form" method="POST" action="" class="space-y-8">
                        <?php wp_nonce_field('stepjam_contact_form', 'stepjam_contact_nonce'); ?>
                        
                        <!-- 氏名・ご担当者 -->
                        <div class="form-group">
                            <label for="contact_name" class="block text-white font-medium mb-3 font-[Noto_Sans_JP]">
                                氏名・ご担当者 <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="contact_name" 
                                name="contact_name" 
                                required
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:border-white/60 focus:ring-2 focus:ring-white/10 transition-colors font-[Noto_Sans_JP]"
                                placeholder="お名前またはご担当者名を入力してください"
                            >
                        </div>
                        
                        <!-- フリガナ -->
                        <div class="form-group">
                            <label for="contact_kana" class="block text-white font-medium mb-3 font-[Noto_Sans_JP]">
                                フリガナ <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="contact_kana" 
                                name="contact_kana" 
                                required
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:border-white/60 focus:ring-2 focus:ring-white/10 transition-colors font-[Noto_Sans_JP]"
                                placeholder="フリガナを入力してください"
                            >
                        </div>
                        
                        <!-- 概要（エレガントピルトグル） -->
                        <div class="form-group">
                            <label class="block text-white font-medium mb-4 font-[Noto_Sans_JP]">
                                概要 <span class="text-red-400">*</span>
                            </label>
                            
                            <!-- モダンピルトグルUI -->
                            <div class="pill-toggle-container">
                                <style>
                                    .pill-toggle-container {
                                        display: flex;
                                        flex-wrap: wrap;
                                        gap: 12px;
                                        margin-bottom: 0;
                                    }
                                    
                                    .pill-toggle-item {
                                        position: relative;
                                        display: inline-block;
                                    }
                                    
                                    .pill-toggle-input {
                                        position: absolute;
                                        opacity: 0;
                                        pointer-events: none;
                                    }
                                    
                                    .pill-toggle-label {
                                        display: inline-block;
                                        padding: 12px 20px;
                                        border: 1px solid rgba(255, 255, 255, 0.3);
                                        border-radius: 8px;
                                        background: transparent;
                                        color: rgba(255, 255, 255, 0.9);
                                        font-family: 'Noto Sans JP', sans-serif;
                                        font-size: 14px;
                                        font-weight: 400;
                                        cursor: pointer;
                                        transition: all 0.2s ease;
                                        user-select: none;
                                        white-space: nowrap;
                                    }
                                    
                                    .pill-toggle-label:hover {
                                        border-color: rgba(255, 255, 255, 0.6);
                                        background: rgba(255, 255, 255, 0.05);
                                    }
                                    
                                    .pill-toggle-input:checked + .pill-toggle-label {
                                        background: rgba(255, 255, 255, 0.95);
                                        color: #000;
                                        border-color: rgba(255, 255, 255, 0.95);
                                        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.1);
                                    }
                                    
                                    .pill-toggle-input:focus + .pill-toggle-label {
                                        outline: 2px solid rgba(255, 255, 255, 0.4);
                                        outline-offset: 2px;
                                    }
                                    
                                    /* レスポンシブ調整 */
                                    @media (max-width: 768px) {
                                        .pill-toggle-container {
                                            gap: 8px;
                                        }
                                        
                                        .pill-toggle-label {
                                            padding: 10px 16px;
                                            font-size: 13px;
                                            border-radius: 6px;
                                        }
                                    }
                                    
                                    @media (max-width: 480px) {
                                        .pill-toggle-container {
                                            gap: 6px;
                                        }
                                        
                                        .pill-toggle-label {
                                            padding: 8px 12px;
                                            font-size: 12px;
                                        }
                                    }
                                </style>
                                
                                <div class="pill-toggle-item">
                                    <input 
                                        type="checkbox" 
                                        id="inquiry_general" 
                                        name="contact_category[]" 
                                        value="お問い合わせ要項"
                                        class="pill-toggle-input"
                                    >
                                    <label for="inquiry_general" class="pill-toggle-label">
                                        お問い合わせ要項
                                    </label>
                                </div>
                                
                                <div class="pill-toggle-item">
                                    <input 
                                        type="checkbox" 
                                        id="next_stepjam" 
                                        name="contact_category[]" 
                                        value="次回STEPJAMに関して"
                                        class="pill-toggle-input"
                                    >
                                    <label for="next_stepjam" class="pill-toggle-label">
                                        次回STEPJAMに関して
                                    </label>
                                </div>
                                
                                <div class="pill-toggle-item">
                                    <input 
                                        type="checkbox" 
                                        id="participation" 
                                        name="contact_category[]" 
                                        value="参加に関して"
                                        class="pill-toggle-input"
                                    >
                                    <label for="participation" class="pill-toggle-label">
                                        参加に関して
                                    </label>
                                </div>
                                
                                <div class="pill-toggle-item">
                                    <input 
                                        type="checkbox" 
                                        id="sponsorship" 
                                        name="contact_category[]" 
                                        value="協賛に関して"
                                        class="pill-toggle-input"
                                    >
                                    <label for="sponsorship" class="pill-toggle-label">
                                        協賛に関して
                                    </label>
                                </div>
                                
                                <div class="pill-toggle-item">
                                    <input 
                                        type="checkbox" 
                                        id="tickets" 
                                        name="contact_category[]" 
                                        value="チケットに関して"
                                        class="pill-toggle-input"
                                    >
                                    <label for="tickets" class="pill-toggle-label">
                                        チケットに関して
                                    </label>
                                </div>
                                
                                <div class="pill-toggle-item">
                                    <input 
                                        type="checkbox" 
                                        id="other" 
                                        name="contact_category[]" 
                                        value="その他"
                                        class="pill-toggle-input"
                                    >
                                    <label for="other" class="pill-toggle-label">
                                        その他
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- メールアドレス -->
                        <div class="form-group">
                            <label for="contact_email" class="block text-white font-medium mb-3 font-[Noto_Sans_JP]">
                                メールアドレス <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="contact_email" 
                                name="contact_email" 
                                required
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:border-white/60 focus:ring-2 focus:ring-white/10 transition-colors font-[Noto_Sans_JP]"
                                placeholder="example@email.com"
                            >
                        </div>
                        
                        <!-- ご連絡先 -->
                        <div class="form-group">
                            <label for="contact_phone" class="block text-white font-medium mb-3 font-[Noto_Sans_JP]">
                                ご連絡先 <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="contact_phone" 
                                name="contact_phone" 
                                required
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:border-white/60 focus:ring-2 focus:ring-white/10 transition-colors font-[Noto_Sans_JP]"
                                placeholder="電話番号を入力してください"
                            >
                        </div>
                        
                        <!-- お問い合わせ内容 -->
                        <div class="form-group">
                            <label for="contact_message" class="block text-white font-medium mb-3 font-[Noto_Sans_JP]">
                                お問い合わせ内容
                            </label>
                            <textarea 
                                id="contact_message" 
                                name="contact_message" 
                                rows="6"
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:border-white/60 focus:ring-2 focus:ring-white/10 transition-colors font-[Noto_Sans_JP] resize-none"
                                placeholder="お問い合わせ内容を詳しく入力してください"
                            ></textarea>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button 
                                type="submit" 
                                id="contact-submit"
                                class="inline-flex items-center px-8 py-4 bg-white text-black font-bold rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white/20 transition-colors font-[Noto_Sans_JP] min-w-[200px] justify-center"
                            >
                                <span id="submit-text">送信</span>
                                <span id="submit-loading" class="hidden">送信中...</span>
                            </button>
                        </div>
                        
                    </form>
                    
                </div>
                
            </div>
        </section>
        
    </main>
    
</div> <!-- /.site-responsive-wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('stepjam-contact-form');
    const submitBtn = document.getElementById('contact-submit');
    const submitText = document.getElementById('submit-text');
    const submitLoading = document.getElementById('submit-loading');
    const successMsg = document.getElementById('contact-success');
    const errorMsg = document.getElementById('contact-error');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // 最低1つのチェックボックス選択を確認
            const categories = document.querySelectorAll('input[name="contact_category[]"]:checked');
            if (categories.length === 0) {
                errorMsg.querySelector('p').textContent = '概要から最低1つ選択してください。';
                errorMsg.classList.remove('hidden');
                successMsg.classList.add('hidden');
                return;
            }
            
            // Loading状態
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
            
            // フォームデータを収集
            const formData = new FormData(form);
            
            // WordPress AJAX送信
            formData.append('action', 'stepjam_contact_form');
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successMsg.classList.remove('hidden');
                    errorMsg.classList.add('hidden');
                    form.reset();
                } else {
                    errorMsg.querySelector('p').textContent = data.data.message || '送信に失敗しました。';
                    errorMsg.classList.remove('hidden');
                    successMsg.classList.add('hidden');
                }
            })
            .catch(error => {
                errorMsg.querySelector('p').textContent = '送信に失敗しました。しばらくしてから再度お試しください。';
                errorMsg.classList.remove('hidden');
                successMsg.classList.add('hidden');
            })
            .finally(() => {
                // Loading状態を解除
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                submitLoading.classList.add('hidden');
            });
        });
    }
});
</script>

<?php get_footer(); ?>