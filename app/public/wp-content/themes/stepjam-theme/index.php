<?php
/**
 * The main template file
 * 
 * @package STEPJAM_Theme
 */

get_header(); ?>

<main class="site-main relative w-full bg-black" data-acf="main-content">
    <div class="container mx-auto px-4 py-8">
        
        <?php if (have_posts()) : ?>
            
            <!-- Page Header -->
            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header mb-8">
                    <h1 class="page-title text-4xl text-white font-bold mb-4">
                        <?php single_post_title(); ?>
                    </h1>
                </header>
            <?php endif; ?>

            <?php if (is_archive()) : ?>
                <header class="page-header mb-8">
                    <h1 class="page-title text-4xl text-white font-bold mb-4">
                        <?php the_archive_title(); ?>
                    </h1>
                    <?php if (get_the_archive_description()) : ?>
                        <div class="archive-description text-white/80 text-lg">
                            <?php the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                </header>
            <?php endif; ?>

            <!-- Posts Loop -->
            <div class="posts-container space-y-8">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item bg-black border border-white/20 rounded-lg p-6'); ?>>
                        
                        <!-- Post Header -->
                        <header class="entry-header mb-4">
                            <?php if (is_singular()) : ?>
                                <h1 class="entry-title text-3xl text-white font-bold">
                                    <?php the_title(); ?>
                                </h1>
                            <?php else : ?>
                                <h2 class="entry-title text-2xl text-white font-bold mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-cyan-400 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                            <?php endif; ?>

                            <?php if ('post' === get_post_type()) : ?>
                                <div class="entry-meta text-white/60 text-sm">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                    <?php if (get_the_category()) : ?>
                                        <span class="mx-2">|</span>
                                        <?php the_category(', '); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Post Thumbnail -->
                        <?php if (has_post_thumbnail() && !is_singular()) : ?>
                            <div class="entry-thumbnail mb-4">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded')); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Post Content -->
                        <div class="entry-content text-white prose prose-invert max-w-none">
                            <?php if (is_singular()) : ?>
                                <?php the_content(); ?>
                            <?php else : ?>
                                <?php the_excerpt(); ?>
                                <div class="read-more mt-4">
                                    <a href="<?php the_permalink(); ?>" 
                                       class="inline-block bg-cyan-400 text-black px-4 py-2 rounded hover:bg-opacity-80 transition-colors">
                                        続きを読む
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Post Footer -->
                        <?php if (is_singular() && ('post' === get_post_type())) : ?>
                            <footer class="entry-footer mt-6 pt-4 border-t border-white/20">
                                <?php if (get_the_tags()) : ?>
                                    <div class="post-tags">
                                        <span class="text-white/60">Tags: </span>
                                        <?php the_tags('', ', ', ''); ?>
                                    </div>
                                <?php endif; ?>
                            </footer>
                        <?php endif; ?>

                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if (!is_singular()) : ?>
                <nav class="pagination-nav mt-12" aria-label="Posts navigation">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '&laquo; 前へ',
                        'next_text' => '次へ &raquo;',
                        'class' => 'pagination flex justify-center space-x-2',
                    ));
                    ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>

            <!-- No Posts Found -->
            <section class="no-results text-center py-16">
                <header class="page-header mb-8">
                    <h1 class="page-title text-4xl text-white font-bold mb-4">
                        <?php _e('Nothing found', 'stepjam-theme'); ?>
                    </h1>
                </header>

                <div class="page-content text-white/80 text-lg">
                    <?php if (is_search()) : ?>
                        <p class="mb-4">
                            <?php printf(__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'stepjam-theme')); ?>
                        </p>
                        <?php get_search_form(); ?>
                    <?php else : ?>
                        <p class="mb-4">
                            <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'stepjam-theme'); ?>
                        </p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </section>

        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>