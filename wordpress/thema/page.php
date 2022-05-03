<?php
/*
Template Name: 固定ページの新規テンプレート
*/
?>
<?php get_header(); ?>
<div class="contents">
    <?php get_sidebar(); ?>
    <div id="main" class="main">
        <?php query_posts( array('post_type' => 'cast'));?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <!-- ここからループ -->
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h1>
            <?php the_content(); ?>
            <?php $args = array(
			'before' => '<div class="page-link">',
			'after' => '</div>',
			'link_before' => '<span>',
			'link_after' => '</span>',
			);
		wp_link_pages($args); ?>
        </div>
        <!-- ここまでループ -->
        <?php endwhile; else: _e('ごめんなさいコンテンツがありません'); endif; wp_reset_query(); ?>
        <!-- pager -->
        <?php if ( $wp_query -> max_num_pages > 1 ) : ?>
            <div class="navigation">
                <div class="alignleft"><?php next_posts_link('&laquo; PREV'); ?></div>
                <div class="alignright"><?php previous_posts_link('NEXT &raquo;'); ?></div>
            </div>
        <?php endif;　?>
        <!-- /pager  -->
    </div>
</div>
<?php get_footer(); ?>
