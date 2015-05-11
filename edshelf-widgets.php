<?php
/*
Plugin Name: edshelf Widgets
Plugin URI: https://edshelf.com
Description: Adds a shortcode for embedding an edshelf widget on your site.
Version: 1.0
Author: edshelf
Author URI: https://edshelf.com
*/


/**
 * Constants
 */
define( 'EDSHELF_DEFAULT_SHELF_ID', 33080 );
define( 'EDSHELF_DEFAULT_SHELF_HEIGHT', 550 );
define( 'EDSHELF_DEFAULT_SHELF_FORMAT', 'grid' );


/**
 * Creates a submenu for this plugin
 */
add_action( 'admin_menu', 'edshelf_widgets_admin_menu' );
function edshelf_widgets_admin_menu() {
    add_submenu_page( 'tools.php', 'edshelf Widgets', 'edshelf Widgets', 'manage_options', 'edshelf-widgets', 'edshelf_widgets_admin_page' );
}


/**
 * Creates an options page for this plugin
 */
function edshelf_widgets_admin_page() {

    // Safety precaution
    if( !current_user_can('manage_options') )  {
        wp_die( __( 'Sorry, you do not have sufficient permissions to access this page.' ) );
    }

    // The UI
?>
<div id="edshelf-widgets-options-page" class="wrap">
<div id="icon-tools" class="icon32"></div>
<h2>Widgets from edshelf</h2>
<p>Instructions on how to add and configure an edshelf widget for your site.</p>
<hr size="1" style="border:0;border-top:1px solid #ccc;">
<h3>Shelf widget</h3>
<h4>Quick instructions</h4>
<p>The shelf widget shortcode: <code>[edshelf-shelf-widget id="NNNN" height="YYY" format="FFFF"]</code></p>
<p>The shelf widget template tag: <code>edshelf_shelf_widget( $id, $height, '$format' );</code></p>
<h4>Step-by-step instructions</h4>
<p>How to embed this widget:</p>
<ol>
    <li>Go to the shelf on edshelf that you want to embed. As an example, here is the <a href="https://edshelf.com/shelf/mikeleeorg-teacher-created-tools/" target="_new">Teacher-Created Tools Shelf</a>.</li>
    <li>Look for the Widget module at the bottom of the right column. In that module will be some code that looks like this:<br><code>&lt;div id="edshelf-widget-shelf-33080"&gt;&lt;/div&gt;&lt;script src="https://edshelf.com/widgets/shelf/?id=33080&height=550&format=grid&type=shelf"&gt;&lt;/script&gt;</code></li>
    <li>In that code, look for the ID number of the shelf. In our example, it is:<br><code>33080</code>.</li>
    <li>In your WordPress site, go to the blog post or page on which you want to embed this shelf widget. Type in the following WordPress shortcode in the text editor:<br><code>[edshelf-shelf-widget id="NNNN" height="YYY" format="FFFF"]</code></li>
    <li>NNNN represents a shelf's ID number, which you just found earlier. Substitute NNNN with the ID number of the shelf you want to embed.</li>
    <li>YYY represents the height of the widget in pixels. Substitute YYY with the height you would like to use. You can keep changing this number until you like the height of the widget. For our example, let's use<br><code>800</code>.</li>
    <li>FFFF represents the format of widget you would like to display. There are three formats: "grid", "list", and "compact". If you leave this out, the widget will automatically default to grid. The differences between each are:<ul>
        <li><strong>grid</strong> - The widget displays all the info that we display on edshelf.com. This is best used if the widget is embedded into a blog post or wide column.</li>
        <li><strong>list</strong> - The widget displays all of the notes written alongside a tool. This is best used in a blog post or wide column also.</li>
        <li><strong>compact</strong> - The widget displays only the icons in the shelf and hides the tool names and other related info, so it can squeeze into a sidebar or narrow column.</li>
    </ul></li>
    <li>In our example, the final shortcode is:<br><code>[edshelf-shelf-widget id="33080" height="800" format="grid"]</code></li>
    <li>Or, if you know PHP and want to use the template tag, it is:<br><code>edshelf_shelf_widget( 33080, 800, 'grid' );</code></li>
    <li>And you're done!</li>
</ol>
<?php
}


/**
 * Returns the Shelf widget itself
 */
function edshelf_shelf_widget_embed( $id = EDSHELF_DEFAULT_SHELF_ID, $height = EDSHELF_DEFAULT_SHELF_HEIGHT, $format = EDSHELF_DEFAULT_SHELF_FORMAT ) {
    $id     = esc_attr( $id );
    $height = esc_attr( $height );
    $format = esc_attr( $format );
    return "<div id='edshelf-widget-shelf-{$id}'></div><script src='https://edshelf.com/widgets/shelf/?id={$id}&height={$height}&format={$format}&type=shelf'></script>";
}


/**
 * Creates a template tag for the Shelf widget
 *
 * edshelf_shelf_widget( 33080, 550, 'grid' );
 */
function edshelf_shelf_widget( $id, $height, $format ) {
    echo edshelf_shelf_widget_embed( $id, $height, $format );
}


/**
 * Creates a shortcode for the Shelf widget
 *
 * [edshelf-shelf-widget id="33080" height="550" format="grid"]
 */
add_shortcode( 'edshelf-shelf-widget', 'edshelf_shelf_widget_function' );
function edshelf_shelf_widget_function( $atts ) {
    extract( shortcode_atts( array(
        'id'     => EDSHELF_DEFAULT_SHELF_ID,
        'height' => EDSHELF_DEFAULT_SHELF_HEIGHT,
        'format' => EDSHELF_DEFAULT_SHELF_FORMAT
    ), $atts ) );

    return edshelf_shelf_widget_embed( $id, $height, $format );
}


/**
 * Creates a WordPress widget for the Shelf widget
 */
function edshelf_shelf_widget_wpwidget( $args ) {
    extract( $args );

    $options = get_option( 'edshelf_shelf_widget' );
    if( !is_array( $options ) ) {
        $options = array(
            'id'     => EDSHELF_DEFAULT_SHELF_ID,
            'height' => EDSHELF_DEFAULT_SHELF_HEIGHT,
            'format' => EDSHELF_DEFAULT_SHELF_FORMAT
        );
    }     

    echo $before_widget;
    echo edshelf_shelf_widget_embed( $options['id'], $options['height'], $options['format'] );
    echo $after_widget;
}


/**
 * Creates the WordPress widget controls for the Shelf widget
 */
function edshelf_shelf_widget_control() {

    // Process the data from the controls
    $options = get_option( 'edshelf_shelf_widget' );
    if( !is_array( $options ) ) {
        $options = array(
            'id'     => EDSHELF_DEFAULT_SHELF_ID,
            'height' => EDSHELF_DEFAULT_SHELF_HEIGHT,
            'format' => EDSHELF_DEFAULT_SHELF_FORMAT
        );
    }     

    if( $_POST['edshelf_shelf_submit'] ) {
        $options['id']     = sanitize_text_field( $_POST['edshelf_shelf_id'] );
        $options['height'] = sanitize_text_field( $_POST['edshelf_shelf_height'] );
        $options['format'] = sanitize_text_field( $_POST['edshelf_shelf_format'] );
        update_option( 'edshelf_shelf_widget', $options );
    }

    // The UI
?>
<p>
    <label for="edshelf-shelf-id">Shelf ID</label>:
    <input type="text" id="edshelf-shelf-id" name="edshelf_shelf_id" size="5" maxlength="5" value="<?php echo $options['id'];?>"><br>
    <label for="edshelf-shelf-height">Widget height</label>:
    <input type="text" id="edshelf-shelf-height" name="edshelf_shelf_height" size="5" maxlength="6" value="<?php echo $options['height'];?>"><br>
    <label for="edshelf-shelf-height">Widget format</label>:
    <select id="edshelf-shelf-format" name="edshelf_shelf_format">
        <option value="grid"<?php    if ( $options['format'] == 'grid' )    { echo ' selected'; } ?>>Grid</option>
        <option value="list"<?php    if ( $options['format'] == 'list' )    { echo ' selected'; } ?>>List</option>
        <option value="compact"<?php if ( $options['format'] == 'compact' ) { echo ' selected'; } ?>>Compact</option>
    </select>
    <input type="hidden" name="edshelf_shelf_submit" value="1">
</p>
<p>The Shelf ID can be found on the page for the shelf on edshelf. Look for the code in the Widget module at the bottom of the right column. The ID will look like <code>id="33080"</code> in the code.</p>
<?php
}


/**
 * Initialize the WordPress widget for the Shelf widget
 */
add_action( 'plugins_loaded', 'edshelf_shelf_widget_init' ); 
function edshelf_shelf_widget_init() {
    register_sidebar_widget( 'edshelf Shelf Widget', 'edshelf_shelf_widget_wpwidget' );
    register_widget_control( 'edshelf Shelf Widget', 'edshelf_shelf_widget_control' );
}


?>