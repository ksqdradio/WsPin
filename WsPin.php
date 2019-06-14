<?php
/*
* Plugin Name: WsPin
* Description:  Call Spinitron API
* Author:      Keith Gudger
* Author URI:  http://www.github.com/kgudger
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*  */

defined( 'ABSPATH' ) or die( 'Ah ah ah, you didn\'t say the magic word' );

add_action('admin_menu', 'WsPin_setup_menu');
add_action( 'admin_init', 'register_WsPin_settings' );
 
function WsPin_setup_menu(){
        add_options_page( 'WsPin Setup Page', 'WsPin', 'manage_options', 'WsPin-plugin', 'WsPin_options_page' );
}

function register_WsPin_settings () { // register the API Key
	register_setting ('WsPinPlugin', 'WsPin_API_Key_settings');
	add_settings_section(
		'WsPin_Plugin_section',
		__( 'Spinitron API Key', 'wordpress'),
		'WsPin_section_callback',
		'WsPinPlugin'
	);
	add_settings_field(
		'WsPin_API_Key_field',
		__( 'Spinitron API Key Value', 'wordpress'),
		'WsPin_api_render',
		'WsPinPlugin',
		'WsPin_Plugin_section'
	);
}
 
function WsPin_api_render() {
	$options = get_option( 'WsPin_API_Key_settings' );
	?>
	<input type='text' name='WsPin_API_Key_settings[WsPin_API_Key_field]' value='<?php echo $options['WsPin_API_Key_field']; ?>'>
	<?php
}

function WsPin_section_callback () {
	echo __( 'Enter the Spinitron API Key here', 'wordpress');
}

/**
 * Display the options page and form
 */
function WsPin_options_page() {
	?>
	<form action='options.php' method='post'>
	<h2>WsPin Settings Admin Page</h2>
	<?php
	settings_fields( 'WsPinPlugin' );
	do_settings_sections( 'WsPinPlugin' );
	submit_button();
	?>
	</form>
	<h4>Usage</h4>
	<p>Insert the following shortcodes in pages where needed</p>
	<p><code>[wspin action="playing" count="5",show_id=""]</code><br>
	<span>count defaults to 5</span><br>
	<span>Lists the last (count) songs playing</span><br>
	<span>show_id defaults to blank, if used playlist is for that show.
	</span></p>
	<p><code>[wspin action="upnext" count="5"]</code><br>
	<span>count defaults to 5</span><br>
	<span>Lists the next (count) hours programs</span><br>
	<span>A negative number removes the current program from the list</span><br>
	<span>Use '0' (zero) for only one program</span></p>
	<p><code>[wspin action="showlist"]</code><br>
	<span>Lists all the scheduled programs</span><p>
	<p><code>[wspin action="refresh" count="5"]</code><br>
	<span>count defaults to 5</span><br>
	<span>Inserts JavaScript into page to refresh the play list every 15 seconds.</span><br>
	<span>count is how many songs to list</span></p>
	<p>Note: HTML responses are wrapped in a paragraph class styled
	in the theme appearance menu.  "spin_recent" and "spin_today"
	and "spin_list" are the associated classes.</p>
	<?php
}

add_shortcode('wspin', 'wspin_spinapi');
include_once('includes/recent.php');
include_once('includes/today.php');
include_once('includes/showlist.php');

/** Actual shortcode code
 *  @param $atts is an array of passed parameters, default null
 *  @param $content is any content in the shortcode
 *  @param $tag ??
 */
function wspin_spinapi($atts=[], $content=null,$tag='') {
// sets defaults for $atts parameters
$a = shortcode_atts( array(
	'action' => "",
	'count' => 5,
	'show_id' =>"",
), $atts );
$rstring = ""; // return string, required in WP
if ( strtolower($a['action']) == 'playing' ) { // playlist
	$rstring = recent(intval($a['count']),$a['show_id']) ; // count is how many songs
} else if ( strtolower($a['action']) == 'upnext' ) { // next prograrms
	$rstring = today(intval($a['count'])) ;  // count is hours into future
} else if ( strtolower($a['action']) == 'refresh' ) { // next prograrms
	$count = intval($a['count']) ;
	$rstring = <<<EOT
<script>
    (function () {
        setInterval(function () {
            var request = new XMLHttpRequest();
            request.onload = function () {
                document.querySelector('#spin-recent').innerHTML = request.responseText;
            };
            request.open('GET', 'https://' + window.location.hostname + "/recentt.php?count=$count", true);
            request.send();
        }, 15000);
    }());
</script>
EOT;
} else if ( strtolower($a['action']) == 'showlist' ) { // next prograrms
	$rstring = showlist() ;  // all shows
}
//$file = './rstring.txt';
//file_put_contents($file, $rstring);
return $rstring;
}
?>
