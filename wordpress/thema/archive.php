<?php get_header(); ?>
<div class="page-content">
	<h2 class="headline5"><span class="headline5-inner"><?php single_cat_title(); ?><?php post_type_archive_title(); ?></span></h2>
	<div class="renovation">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<!-- ここからループ -->
		<div id="post-<?php the_ID(); ?>" class="renovation-item renovation-card">
		<?php if(has_post_thumbnail()): the_post_thumbnail('construction-thumbnails-big'); else: ?>
                <img src="<?php bloginfo('template_url'); ?>/images/common/nowprinting-construction-big.jpg" width="540" height="340" alt="準備中です。">
                <?php endif; ?>
			<div class="title">
				<?php echo get_the_title(); ?>
			</div>
			<div class="kategorie">
				<?php echo get_the_date(); ?>
			</div>
			
			<div class="more-box"><a href="<?php echo the_permalink(); ?>" class="more">詳しく見る</a></div>
		</div>
		<!-- ここまでループ -->
		<?php endwhile; else: _e('ごめんなさいコンテンツがありません'); endif;?>
	</div>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }?>
</div>
<?php get_footer(); ?>
