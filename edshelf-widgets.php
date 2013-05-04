<?php
/*
Plugin Name: edshelf Widgets
Plugin URI: http://edshelf.com
Description: Adds a shortcode for embedding an edshelf widget on your site.
Version: 0.2.1
Author: edshelf
Author URI: http://edshelf.com
*/


/**
 * Constants
 */
define( 'EDSHELF_DEFAULT_COLLECTION_ID', 8786 );
define( 'EDSHELF_DEFAULT_COLLECTION_HEIGHT', 500 );
define( 'EDSHELF_DEFAULT_COLLECTION_ID', 'full' );


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
<h3>Collections widget</h3>
<h4>Quick instructions</h4>
<p>The collection widget shortcode: <code>[edshelf-collection-widget id="NNNN" height="YYY" type="TTTT"]</code></p>
<p>The collection widget template tag: <code>edshelf_collection_widget( $id, $height, '$type' );</code></p>
<h4>Step-by-step instructions</h4>
<p>How to embed this widget:</p>
<ol>
    <li>Go to the collection on edshelf that you want to embed. As an example, here is the <a href="http://edshelf.com/profile/mikeleeorg/teacher-created-tools" target="_new">Teacher-Created Tools Collection</a>.</li>
    <li>Look for the Widget module at the bottom of the right column. In that module will be some code that looks like this:<br><code>&lt;div id="edshelf-widget"&gt;&lt;/div&gt;&lt;script src="//edshelf.com/widgets/collection?id=8786&height=500&type=full"&gt;&lt;/script&gt;</code></li>
    <li>In that code, look for the ID number of the collection. In our example, it is:<br><code>8786</code>.</li>
    <li>In your WordPress site, go to the blog post or page on which you want to embed this collection widget. Type in the following WordPress shortcode in the text editor:<br><code>[edshelf-collection-widget id="NNNN" height="YYY" type="TTTT"]</code></li>
    <li>NNNN represents a collection's ID number, which you just found earlier. Substitute NNNN with the ID number of the collection you want to embed.</li>
    <li>YYY represents the height of the widget in pixels. Substitute YYY with the height you would like to use. You can keep changing this number until you like the height of the widget. For our example, let's use<br><code>800</code>.</li>
    <li>TTTT represents the type of widget you would like to display. There are three types: "full", "compact", and "list". If you leave this out, the widget will automatically default to full. The differences between each are:<ul>
        <li><strong>full</strong> - The widget displays all the info that we display on edshelf.com. This is best used if the widget is embedded into a blog post or wide column.</li>
        <li><strong>compact</strong> - The widget displays only the icons in the collection and hides the tool names and other related info, so it can squeeze into a sidebar or narrow column.</li>
        <li><strong>list</strong> - The widget displays all of the notes written alongside a tool. This is best used in a blog post or wide column also.</li>
    </ul></li>
    <li>In our example, the final shortcode is:<br><code>[edshelf-collection-widget id="8786" height="800" type="full"]</code></li>
    <li>Or, if you know PHP and want to use the template tag, it is:<br><code>edshelf_collection_widget( 8786, 800, 'full' );</code></li>
    <li>And you're done!</li>
</ol>
<?php
}


/**
 * Returns the Collection widget itself
 */
function edshelf_collection_widget_embed( $id = EDSHELF_DEFAULT_COLLECTION_ID, $height = EDSHELF_DEFAULT_COLLECTION_HEIGHT, $type = EDSHELF_DEFAULT_COLLECTION_TYPE ) {
    $id     = esc_attr( $id );
    $height = esc_attr( $height );
    $type   = esc_attr( $type );
    return "<div id='edshelf-widget'></div><script src='//edshelf.com/widgets/collection?id={$id}&height={$height}&type={$type}'></script>";
}


/**
 * Creates a template tag for the Collection widget
 *
 * edshelf_collection_widget( 8786, 500, 'full' );
 */
function edshelf_collection_widget( $id, $height, $type ) {
    echo edshelf_collection_widget_embed( $id, $height, $type );
}


/**
 * Creates a shortcode for the Collection widget
 *
 * [edshelf-collection-widget id="8786" height="500" type="full"]
 */
add_shortcode( 'edshelf-collection-widget', 'edshelf_collection_widget_function' );
function edshelf_collection_widget_function( $atts ) {
    extract( shortcode_atts( array(
        'id'     => EDSHELF_DEFAULT_COLLECTION_ID,
        'height' => EDSHELF_DEFAULT_COLLECTION_HEIGHT,
        'type'   => EDSHELF_DEFAULT_COLLECTION_TYPE
    ), $atts ) );

    return edshelf_collection_widget_embed( $id, $height, $type );
}


/**
 * Creates a WordPress widget for the Collection widget
 */
function edshelf_collection_widget_wpwidget( $args ) {
    extract( $args );

    $options = get_option( 'edshelf_collection_widget' );
    if( !is_array( $options ) ) {
        $options = array(
            'id'     => EDSHELF_DEFAULT_COLLECTION_ID,
            'height' => EDSHELF_DEFAULT_COLLECTION_HEIGHT,
            'type'   => EDSHELF_DEFAULT_COLLECTION_TYPE
        );
    }     

    echo $before_widget;
    echo edshelf_collection_widget_embed( $options['id'], $options['height'], $options['type'] );
    echo $after_widget;
}


/**
 * Creates the WordPress widget controls for the Collection widget
 */
function edshelf_collection_widget_control() {

    // Process the data from the controls
    $options = get_option( 'edshelf_collection_widget' );
    if( !is_array( $options ) ) {
        $options = array(
            'id'     => EDSHELF_DEFAULT_COLLECTION_ID,
            'height' => EDSHELF_DEFAULT_COLLECTION_HEIGHT,
            'type'   => EDSHELF_DEFAULT_COLLECTION_TYPE
        );
    }     

    if( $_POST['edshelf_collection_submit'] ) {
        $options['id']     = esc_attr( $_POST['edshelf_collection_id'] );
        $options['height'] = esc_attr( $_POST['edshelf_collection_height'] );
        $options['type']   = esc_attr( $_POST['edshelf_collection_type'] );
        update_option( 'edshelf_collection_widget', $options );
    }

    // The UI
?>
<p>
    <label for="edshelf-collection-id">Collection ID</label>:
    <input type="text" id="edshelf-collection-id" name="edshelf_collection_id" size="5" maxlength="5" value="<?php echo $options['id'];?>"><br>
    <label for="edshelf-collection-height">Widget height</label>:
    <input type="text" id="edshelf-collection-height" name="edshelf_collection_height" size="5" maxlength="6" value="<?php echo $options['height'];?>"><br>
    <label for="edshelf-collection-height">Widget type</label>:
    <input type="text" id="edshelf-collection-type" name="edshelf_collection_type" size="5" maxlength="10" value="<?php echo $options['type'];?>"><br>
    <input type="hidden" name="edshelf_collection_submit" value="1">
</p>
<p>The Collection ID can be found on the page for the collection on edshelf. Look for the code in the Widget module at the bottom of the right column. The ID will look like <code>id="8786"</code> in the code.</p>
<?php
}


/**
 * Initialize the WordPress widget for the Collections widget
 */
add_action( 'plugins_loaded', 'edshelf_collection_widget_init' ); 
function edshelf_collection_widget_init() {
    register_sidebar_widget( 'edshelf Collection Widget', 'edshelf_collection_widget_wpwidget' );
    register_widget_control( 'edshelf Collection Widget', 'edshelf_collection_widget_control' );
}


?>