<?php
/**
 * The template for displaying Author archive pages
 */
?>
<?php get_header(); ?>
    <section id="content" role="main">
        <div class="inner">
            <?php if ( have_posts() ) : ?>
                <?php /* Queue the first post, that way we know the author */ ?>
                <?php the_post(); ?>
                <header class="archive-header">
                    <h1 class="archive-title"><?php printf(__('All posts by %s', 'jgtstork'), '<strong>' . get_the_author() . '</strong>'); ?></h1> 
                </header><!-- .archive-header -->
                <?php /* Since we called the_post() above, we need to rewind the loop back to the beginning */ ?>
                <?php rewind_posts(); ?>
                <?php if ( get_the_author_meta( 'description' ) ) { ?>
                <div class="author-box">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), 120 ); ?>
                    <h3 class="author-title"><?php printf( __( 'About %s', 'jgtstork' ), get_the_author() ); ?></h3>
                    <p class="author-bio"><?php the_author_meta( 'description' ); ?></p>
                </div><!-- .author-box -->
                <?php } ?>
                <div class="page-content">
                    <ul class="posts-list">
                        <?php /* The loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'jgtstork' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>, <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date(); ?></time> <?php $categories_list = get_the_category_list( __( ', ', 'jgtstork' ) ); if ( $categories_list ) printf( __( 'in %s', 'jgtstork' ), $categories_list ); ?></li>
                        <?php endwhile; ?>
                    </ul>
                    <?php jgstork_loop_navigation(); ?>
                </div><!-- .page-content -->                
            <?php else: ?>
                <header class="page-header">
                    <h1 class="page-title"><?php _e( 'Nothing found', 'jgtstork' ); ?></h1>
                </header><!-- .page-header -->
                <div class="page-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested archive.', 'jgtstork' ); ?></p>
                </div><!-- .page-content -->
            <?php endif; ?>
        </div><!-- .inner -->
    </section><!-- #content -->
<?php get_footer(); ?>