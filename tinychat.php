<?php
/*
* Plugin Name: Wordpress Video Chat - Only On GitHub!
* Plugin URI: https://github.com/Ruddernation-Designs/wordpress-video-chat/
* Author: Ruddernation Designs
* Author URI: https://github.com/Ruddernation-Designs/
* Description: TinyChat full screen video chat for WordPress/BuddyPress, This also has YouTube/SoundCloud for all chatters and now has smileys enabled using my embed file, Users have to be logged in to your site before they can chat using this.
* Requires at least: WordPress 4.0, BuddyPress 2.0
* Tested up to: WordPress 4.6, BuddyPress 2.6.2
* Version: 1.6.7
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Date: 17th October 2016
*/
define('COMPARE_VERSION', '1.6.6');
register_activation_hook(__FILE__, 'wordpress_chat_install');
function wordpress_chat_install() {
	global $wpdb, $wp_version;
	$post_date = date("Y-m-d H:i:s");
	$post_date_gmt = gmdate("Y-m-d H:i:s");
	$sql = "SELECT * FROM ".$wpdb->posts." WHERE post_content LIKE '%[tinychat_page]%' AND `post_type` NOT IN('revision') LIMIT 1";
	$page = $wpdb->get_row($sql, ARRAY_A);
	if($page == NULL) {
		$sql ="INSERT INTO ".$wpdb->posts."(

			post_author, post_date, post_date_gmt, post_content, post_content_filtered, post_title, post_excerpt,  post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_parent, menu_order, post_type)

			VALUES

			('1', '$post_date', '$post_date_gmt', '[tinychat_page]', '', 'chatroom', '', 'publish', 'closed', 'closed', '', 'chatroom', '', '', '$post_date', '$post_date_gmt', '0', '0', 'page')";

		$wpdb->query($sql);
		$post_id = $wpdb->insert_id;
		$wpdb->query("UPDATE $wpdb->posts SET guid = '" . get_permalink($post_id) . "' WHERE ID = '$post_id'");
	} else {
		$post_id = $page['ID'];
	}
	update_option('wordpress_chat_url', get_permalink($post_id));
}
add_filter('the_content', 'wp_show_wordpress_chat_page', 12);

function wp_show_wordpress_chat_page($content = '') {

	if(preg_match("/\[tinychat_page\]/",$content)) {

		wp_show_wordpress_chat();

		return "";
	}
	return $content;
	
	//This is used to disable to chat to guests.
}
function wp_show_wordpress_chat() {
	$prohash = hash('sha256',filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP'));
	$current_user = wp_get_current_user();
	if($current_user->ID == 0) {
		echo ('<strong>Please login/register before trying to use the chat room!</strong>' );
		return; 
} else {
		echo '<style>#chat{position:fixed;left:0px;right:0px;bottom:0px;height:98%;width:100%;z-index:9999}</style><div id="chat">
<script type="text/javascript">
var tinychat = ({
		room: "'.filter_input(INPUT_SERVER, 'SERVER_NAME').'", 
		prohash: "'.$prohash.'",
		nick: "'.$current_user->display_name.'",
		wmode:"transparent",
		chatSmileys:"true", 
		youtube:"all",
		urlsuper: "'.filter_input(INPUT_SERVER, 'HTTP_HOST'). filter_input(INPUT_SERVER, 'REQUEST_URI').'", 
		desktop:"true",
		langdefault:"en"});
		</script>
<script src="https://cdn.ruddernation.com/js/eslag.js"></script>
<div id="client"></div></div>';}}?>
