<?php
/**
 * The main template file
 *
 * @package DevLite
 * @version 1.0
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="content-area">
            <?php if (have_posts()) : ?>
                
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                        <header class="post-header">
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="post-meta">
                                <span class="post-date">
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date()); ?>
                                    </time>
                                </span>
                                <span class="post-author">
                                    <?php esc_html_e('by', 'devlite'); ?> 
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php the_author(); ?>
                                    </a>
                                </span>
                                <span class="reading-time">
                                    <?php echo esc_html(devlite_reading_time()); ?>
                                </span>
                                <?php if (has_category()) : ?>
                                    <span class="post-categories">
                                        <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                    <?php 
                                    the_post_thumbnail('large', array(
                                        'alt' => the_title_attribute(array('echo' => false)),
                                    )); 
                                    ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <?php
                            if (has_excerpt()) {
                                the_excerpt();
                            } else {
                                the_content();
                            }
                            ?>
                            
                            <?php if (has_excerpt() || strpos(get_the_content(), '<!--more-->') !== false) : ?>
                                <p>
                                    <a href="<?php the_permalink(); ?>" class="read-more">
                                        <?php esc_html_e('Continue reading', 'devlite'); ?> &rarr;
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>

                        <?php if (has_tag()) : ?>
                            <footer class="post-footer">
                                <div class="post-tags">
                                    <?php the_tags('<span class="tags-label">' . esc_html__('Tags:', 'devlite') . '</span> ', ', '); ?>
                                </div>
                            </footer>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>

                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('&larr; Previous', 'devlite'),
                    'next_text' => __('Next &rarr;', 'devlite'),
                    'class'     => 'pagination',
                ));
                ?>

            <?php else : ?>
                
                <div class="no-posts">
                    <h2><?php esc_html_e('No posts found', 'devlite'); ?></h2>
                    <p><?php esc_html_e('Sorry, no posts were found. Try searching for something else.', 'devlite'); ?></p>
                    
                    <?php get_search_form(); ?>
                </div>
                
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>