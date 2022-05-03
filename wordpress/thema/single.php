<?php get_header(); ?>
<div class="contents">
    <?php get_sidebar(); ?>
    <div id="main" class="main">
        <?php query_posts( array('post_type' => 'cast'));?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <!-- ここからループ -->
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h1>
			<div class="post-meta">
				<span class="post-date"><?php echo get_the_date(); ?></span>
				<span class="category">Category - <?php the_category(', ') ?></span>
				<span class="comment-num"><?php comments_popup_link('Comment : 0', 'Comment : 1', 'Comments : %'); ?></span>
			</div>
            <?php the_content(); ?>
            <?php $args = array(
			'before' => '<div class="page-link">',
			'after' => '</div>',
			'link_before' => '<span>',
			'link_after' => '</span>',
			);
		wp_link_pages($args); ?>
			<div class="footer-post-meta">
			<?php the_tags('Tag : ',', '); ?>
			<?php if ( is_multi_author() ): ?> 
			<span class="post-author">作成者 : <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
			<?php endif; ?>
			</div>
        </div>
        <!-- ここまでループ -->
        <!-- post navigation -->
		<div class="navigation">
			<?php if( get_previous_post() ): ?>
				<div class="alignleft"><?php previous_post_link('%link', '&laquo; %title'); ?></div>
			<?php endif; if( get_next_post() ): ?>
				<div class="alignright"><?php next_post_link('%link', '%title &raquo;'); ?></div>
			<?php endif; ?>
		</div>
		<!-- /post navigation -->
						
		<?php comments_template(); // コメント欄の表示 ?>
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