<?php

/*

Plugin Name: Ruddernation Designs

Plugin URI: http://www.musclesforkaleb.com/downloads

Description: Add tinychat to your WordPress/BuddyPress blog

Version: 1.0.1

Author: Ruddernation Designs

Author URI: https://www.ruddernation.com

*/



define('COMPARE_VERSION', '1.0.0');








register_activation_hook(__FILE__, 'tinychat_install');



function tinychat_install() {

	global $wpdb, $wp_version;

	//We add an page for displaying tinychat

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

	

	update_option('tinychat_chat_url', get_permalink($post_id));

}



add_filter('the_content', 'wp_show_tinychat_page', 12);

function wp_show_tinychat_page($content = '') {

	if(preg_match("/\[tinychat_page\]/",$content)) {

		wp_show_tinychat();

		return "";

	}

	

	return $content;

}



function wp_show_tinychat() {

	$current_user = wp_get_current_user();

	

	if(!get_option('tinychat_chat_enabled', 0)) {

		return;

	}

	

	if($current_user->ID == 0 && !get_option('tinychat_allow_guests', 0)) {

		_e("Your not logged in, please login before trying to chat", 'widget-tinychat' );

		return;

	}

	

	$room = 'chat';

	$parameters = array(

		'room' 		=> 'chat',

		'nick'		=> $current_user->ID != 0 ? urlencode(html_entity_decode($current_user->display_name)) : '',

		'join'		=> 'auto',

		'youtube'	=> 'all',

	);

	

	if(get_option('tinychat_restricted_broadcast') == '1') {

		$parameters['bcast'] = 'restrict';

	}



	if($current_user->ID != 0) {

		$roles = array_keys($current_user->{$current_user->cap_key});

		$role = array_pop($roles);

	}

	

	if($current_user->ID != 0 && in_array($role, explode(',', get_option('tinychat_mod_groups')))) {


	} else {


		$parameters['owner'] = 'none';

	}

	

	$parameters['room'] = $room;

	

	foreach ( $parameters as $k => $v ) {

		$parameterString .= "{$k}: '{$v}', ";

	}

	

	$parameters = substr( $parameterString, 0, -2 );

	$tinychat_display = true;
			$random = Rand (1,9999);

			//$name = apply_filters( 'bp_get_group_name', $bp->groups->current_group->name );
			$name = preg_replace('/\s+/','',$name);
			$name=htmlspecialchars($name);
			$name=strtolower($name);

	?>
	<style>
#chat{height:100%;width:100%;top:0; left:0; right:0; bottom:0; position:absolute;
}</style>
<div id="chat">
<script src="https://www.ruddernation.com/info/js/slag.js"></script>

	<script type='text/javascript'>
var embed;

embed = Ruddernation({room: "<?php echo $name.sprintf("%04s",$random)?>", langdefault: "en", desktop: "true", youtube: "all"});

	</script>

	<div id='ruddernation'></div></div>

	<?php

}

?>
