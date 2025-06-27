<?php
/**
 * The template for displaying all pages
 *
 * @package DevLite
 * @version 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                    
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="entry-featured-image">
                                <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
                            </div>
                        <?php endif; ?>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'devlite'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div><!-- .entry-content -->

                    <?php if (get_edit_post_link()) : ?>
                        <footer class="entry-footer">
                            <div class="entry-meta">
                                <?php
                                edit_post_link(
                                    sprintf(
                                        wp_kses(
                                            __('Edit <span class="screen-reader-text">%s</span>', 'devlite'),
                                            array(
                                                'span' => array(
                                                    'class' => array(),
                                                ),
                                            )
                                        ),
                                        get_the_title()
                                    ),
                                    '<span class="edit-link">',
                                    '</span>'
                                );
                                ?>
                            </div>
                        </footer><!-- .entry-footer -->
                    <?php endif; ?>

                </article><!-- #post-<?php the_ID(); ?> -->

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; // End of the loop. ?>
        </div><!-- .container -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>