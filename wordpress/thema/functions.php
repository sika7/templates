<?php

if ( ! isset( $content_width ) ) $content_width = 900;


/****************************************

          不要な機能の削除

*****************************************/

/*WordPressのバージョンを消す　*/
remove_action('wp_head','wp_generator');

/*EditURLを削除*/
remove_action('wp_head','rsd_link');

/*wlwmanifestを削除*/
remove_action('wp_head','wlwmanifest_link');

/*wp-jconを削除*/
remove_action('wp_head','rest_output_link_wp_head');

/*コメントのフィードなどを消す　*/
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

/*コメント欄を表示しない　XSS対策　*/
add_filter( 'comments_open', '__return_false');

/*コメントフォームでのオートリンク機能を無効化*/
remove_filter('comment_text', 'make_clickable', 9);

/*コメントフォームで使用できるタグを無効化*/
add_filter('comments_open', 'custom_comment_tags');
add_filter('pre_comment_approved', 'custom_comment_tags');
function custom_comment_tags($data) {
    global $allowedtags;
    unset($allowedtags['a']);
    unset($allowedtags['abbr']);
    unset($allowedtags['acronym']);
    unset($allowedtags['b']);
    unset($allowedtags['div']);
    unset($allowedtags['cite']);
    unset($allowedtags['code']);
    unset($allowedtags['del']);
    unset($allowedtags['em']);
    unset($allowedtags['i']);
    unset($allowedtags['q']);
    unset($allowedtags['strike']);
    unset($allowedtags['strong']);
    return $data;
}
/* 絵文字の削除 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/* more-linkのハッシュ消し */
function remove_more_jump_link($link) {
  $offset = strpos($link, '#more-');
  if ($offset) {
    $end = strpos($link, '"',$offset);
  }
  if ($end) {
    $link = substr_replace($link, '', $offset, $end-$offset);
  }
  return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');

/*管理バーから不要なメニューを削除*/
function my_remove_bar_menus($wp_admin_bar) {
    // $wp_admin_bar->remove_menu('wp-logo');      // ワードプレスロゴ
    // $wp_admin_bar->remove_menu('site-name');    // サイトタイトル
    // $wp_admin_bar->remove_menu('view-site');    // サイトタイトル > サイトを表示
    $wp_admin_bar->remove_menu('comments');     // コメント
    // $wp_admin_bar->remove_menu('new-content');  // 新規
    // $wp_admin_bar->remove_menu('new-post');     // 新規 > 投稿
    // $wp_admin_bar->remove_menu('new-media');    // 新規 > メディア
    // $wp_admin_bar->remove_menu('new-link');     // 新規 > リンク
    // $wp_admin_bar->remove_menu('new-page');     // 新規 > 固定ページ
    // $wp_admin_bar->remove_menu('new-user');     // 新規 > ユーザー
    // $wp_admin_bar->remove_menu('updates');      // 更新
    // $wp_admin_bar->remove_menu('my-account');   // マイアカウント
    // $wp_admin_bar->remove_menu('user-info');    // マイアカウント > プロフィール
    // $wp_admin_bar->remove_menu('edit-profile'); // マイアカウント > プロフィール編集
    // $wp_admin_bar->remove_menu('logout');       // マイアカウント > ログアウト
}
add_action('admin_bar_menu', 'my_remove_bar_menus', 201);

/*管理メニューから不要なメニューを削除*/
function remove_menus () {
    global $menu;
    // unset($menu[2]);  // ダッシュボード
    // unset($menu[5]);  // 投稿
    // unset($menu[10]); // メディア
    // unset($menu[15]); // リンク
    // unset($menu[20]); // ページ
    unset($menu[25]); // コメント
    // unset($menu[60]); // テーマ
    // unset($menu[65]); // プラグイン
    // unset($menu[70]); // プロフィール
    // unset($menu[75]); // ツール
    // unset($menu[80]); // 設定
}
add_action('admin_menu', 'remove_menus');

//フロント表示時アドミンバーを消す
function disable_admin_bar(){
    return false;
}
add_filter( 'show_admin_bar' , 'disable_admin_bar');


/****************************************

          必要な機能の追加

*****************************************/

// タイトルタグをサポート
add_theme_support( 'title-tag' );


// stylesheetを入れる jsを入れる
function add_files() {
    wp_deregister_script('jquery');
    wp_enqueue_style( 'style', get_template_directory_uri() . '/asset/style.css');
    wp_enqueue_script( 'js', get_template_directory_uri() . '/asset/common.js');
}

add_action( 'wp_enqueue_scripts', 'add_files' );

/*ファビコンを追加*/
function my_favicon(){
  echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_template_directory_uri().'/images/favicon.ico"/>';
}
add_action('wp_head','my_favicon');

// ログイン画面のカスタマイズ
function my_login_style() {
 wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/css/login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_style' );


// ロゴのリンク先を指定
function my_login_logo_url() {
 return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
// ロゴのtitleテキストを指定
function my_login_logo_tit() {
 return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'my_login_logo_tit' );


// カスタム投稿タイプの追加
add_action( 'init', 'create_post_type' );
function create_post_type() {
//カスタム投稿タイプ1（ここから）
    register_post_type(
    'flyer',
    array(
    'label' => 'チラシ', //表示名
    'public' => true, //公開状態
    'show_ui' => true, //管理画面に表示するか
    'show_in_menu' => true, //管理画面のメニューに表示するか
    'menu_position' => 5, //管理メニューの表示位置を指定
    'hierarchical' => false, //階層構造を持たせるか
    'has_archive'   => true, //この投稿タイプのアーカイブを作成するか
    'supports' => array(
        'title',
        'editor',
        // 'comments',
        'excerpt',
        'thumbnail',
        // 'custom-fields',
        // 'post-formats',
        // 'page-attributes',
        // 'trackbacks',
        'revisions',
        // 'author'
    ), //編集画面で使用するフィールド
    )
    );
//カスタム投稿タイプ1（ここまで）
// カスタムタクソノミーを作成(カテゴリー)
register_taxonomy('work_cat', 'flyer',
array(
  'label'                 => '実績の分類', // ラベルを指定。個別に指定したい場合は'labels'を使う
  'public'                => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
  'show_in_quick_edit'    => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
  'show_admin_column'     => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
  'description'           => '実績の分類で分けられるようにします。', // タクソノミーの簡潔な説明
  'hierarchical'          => true, // trueの場合はカテゴリーのような階層あり（子を持つ）タクソノミー、falseの場合はタグのような階層化しないタクソノミーになる
  'rewrite'               => array( // タクソノミーのパーマリンクのリライト方法を変更
    'slug' => 'type', // パーマリンク構造のスラッグを変更
    'with_front' => false, // パーマリンクの前にfrontベースを入れるかどうか
    'hierarchical' => true, // 階層化したURLを使用可能にするかどうか
  ),
)
);
}

 /*アイキャッチ*/
add_theme_support('post-thumbnails');
add_image_size( 'news-thumbnails', 350, 250, true );
add_image_size( 'interview-thumbnails', 300, 200, true );
add_image_size( 'gallery-thumbnails', 300, 300, true );
add_image_size( 'square-thumbnails', 400, 400, true );

/*ビジュアルリッチエディター*/
function ilc_mce_buttons($buttons){
  array_push($buttons, "backcolor", "fontsizeselect", "fontselect", "cleanup","code","styleselect");
  return $buttons;
}
add_filter("mce_buttons", "ilc_mce_buttons");

// jQueryの読み込み


// フッター
function remove_footer_admin () {
    echo 'お問い合わせは<a href="mailto:info@timeair.jp">Time & Air Partners </a>まで';
}
add_filter('admin_footer_text', 'remove_footer_admin');

//管理画面の投稿メニュー名を変更
/*function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'クロスレビュー';
    $submenu['edit.php'][5][0] = 'クロスレビュー一覧';
    $submenu['edit.php'][10][0] = '新規レビューを追加';
}
add_action( 'admin_menu', 'change_post_menu_label' );*/


/*カスタムメニュー*/
// register_nav_menus( array(
//     'header-navi' => 'ヘッダー用',
//     'footer-navi' => 'フッター用',
// ) );



//投稿記事一覧にアイキャッチ画像を表示
function customize_admin_manage_posts_columns($columns) {
    $columns['thumbnail'] = __('Thumbnail');
    return $columns;
}
function customize_admin_add_column($column_name, $post_id) {
    if ( 'thumbnail' == $column_name) {
        //テーマで設定されているサムネイルを利用する場合
        $thum = get_the_post_thumbnail($post_id, 'thumb100', array( 'style'=>'width:75px;height:auto;' ));
        //Wordpressで設定されているサムネイル（小）を利用する場合
        //$thum = get_the_post_thumbnail($post_id, 'small', array( 'style'=>'width:75px;height:auto;' ));
    }
    if ( isset($thum) && $thum ) {
        echo $thum;
    }
}
//アイキャッチ画像の列の幅をCSSで調整
function customize_admin_css_list() {
    echo '<style TYPE="text/css">.column-thumbnail{width:80px;}</style>';
}
//カラムの挿入
add_filter( 'manage_posts_columns', 'customize_admin_manage_posts_columns' );
//サムネイルの挿入
add_action( 'manage_posts_custom_column', 'customize_admin_add_column', 10, 2 );
//投稿一覧のカラムの幅のスタイル調整
add_action('admin_print_styles', 'customize_admin_css_list', 21);



/*ウィジェット*/
if ( !function_exists( 'bj_register_sidebars' ) ) {
    function bj_register_sidebars() {
        register_sidebar( array(
            'id'            => 'sidebar_1', //ウィジェットのID
            'name'          => 'サイドバートップ用', //ウィジェットの名前
            'description'   => 'ウィジェットをドラッグして編集してください。', //ウィジェットの説明文
            'before_widget' => '<div id="%1$s" class="widget_box %2$s">', //ウィジェットを囲う開始タグ
            'after_widget'  => '</div>', //ウィジェットを囲う終了タグ
            'before_title'  => '<h3 class="side_index_no_m">', //タイトルを囲う開始タグ
            'after_title'   => '</h4>', //タイトルを囲う終了タグ
        ) );
        register_sidebar( array(
            'id'            => 'sidebar_2', //ウィジェットのID
            'name'          => 'サイドバーボトム用', //ウィジェットの名前
            'description'   => 'ウィジェットをドラッグして編集してください。', //ウィジェットの説明文
            'before_widget' => '<div id="%1$s" class="widget_box %2$s">', //ウィジェットを囲う開始タグ
            'after_widget'  => '</div>', //ウィジェットを囲う終了タグ
            'before_title'  => '<h3 class="side_index_no_m">', //タイトルを囲う開始タグ
            'after_title'   => '</h4>', //タイトルを囲う終了タグ
        ) );
    }
    add_action( 'widgets_init', 'bj_register_sidebars' );
}

// メインクエリ変更
function twpp_change_sort_order( $query ) {
  if ( is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( $query->is_home() ) {
    $query->set( 'order', 'ASC' );
  }
}
add_action( 'pre_get_posts', 'twpp_change_sort_order' );
