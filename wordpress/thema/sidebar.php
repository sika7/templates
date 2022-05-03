<!-- sidebar -->
<aside id="sidebar">
    <?php if ( is_active_sidebar( 'sidebar_1' ) ) : dynamic_sidebar( 'sidebar_1' ); else: ?>
    <div class="widget">
        <h2>No Widget</h2>
        <p>ウィジットは設定されていません。</p>
    </div>
    <?php endif;?>
</aside>
<!-- /sidebar -->