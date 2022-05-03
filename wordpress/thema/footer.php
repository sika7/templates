<footer id="footer" class="footer">
    <?php wp_nav_menu( array('theme_location' => 'footer-navi','container' => div,));?>
    <small id="copyright"><a href="<?php echo esc_url( home_url()); ?>">&copy; copyright 2017 <?php bloginfo('name') ; ?></a></small>
</footer>
</div>
<!-- wrapper end -->
<?php wp_footer(); ?>
</body>
</html>