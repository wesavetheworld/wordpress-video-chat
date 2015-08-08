<?php
/*
* Plugin Name: Wordpress Video Chat 
* Plugin URI: https://wordpress.org/plugins/wpbp-video-chat/
* Author: Ruddernation Designs
* Author URI: http://profiles.wordpress.org/ruddernation
* Description: TinyChat full screen video chat for WordPress/BuddyPress, This also has YouTube/SoundCloud for all chatters and now has smileys enabled using my embed file, Users have to be logged in to your site before they can chat using this.
* Requires at least: WordPress 4.0, BuddyPress 1.8.1
* Tested up to: WordPress 4.3, BuddyPress 2.3
* Version: 1.5.6
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Date: 08th August 2015
*/
define('COMPARE_VERSION', '1.5.5');
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
	$current_user = wp_get_current_user();
	if($current_user->ID == 0) {
		echo('<b>You are not logged in, please login/register before trying to chat!</b>' );
		return;
	}?>
	<style>#chat{position:fixed;left:0px;right:0px;bottom:0px;height:98%;width:100%;z-index:9999}</style>
<div id="chat">
<script data-cfasync="false" type=text/javascript>
var tinychat = {room: "<?php echo htmlspecialchars($_SERVER['SERVER_NAME'],ENT_QUOTES, 'UTF-8') ?>", <?php echo 'nick: "' . $current_user->display_name .'"';?>, <?php echo 'wmode:"transparent"'?>,<?php echo 'youtube:"all"'?>,urlsuper:"<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>"};
	</script><script data-cfasync="false" src="https://www.ruddernation.com/info/js/eslag.js"></script>
<div id="client"></div></div>
<strong>If Chat isn't loading then check for a shield in your URL bar, <br />
Click that and allow/load unsecured/unsafe scripts/content to run<br />
TinyChat do not currently encrypt all of their content.</strong>
	<?php
}
?>
