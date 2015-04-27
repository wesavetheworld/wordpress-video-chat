=== Wordpress Video Chat ===

Contributors: ruddernation
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FFAC7FBEBH6JE
Tags: video chat, tinychat, chat, wordpress chat, buddypress chat, wordpress video chat, buddypress video chat
Requires at least: 3.6.0
Tested up to: 4.2
Stable tag: 1.3.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

TinyChat full screen video chat for WordPress and BuddyPress,
This also has YouTube/SoundCloud for all chatters and now has smileys enabled using my embed file,
This now requires users to be logged in to the wordpress site to chat (This was a requested update).


== Installation ==

This will automatically create the page and install the short code with link *domain name/chatroom*, If it does not then please read the rest below.

Simply use shortcode [tinychat_page] in a page, you may need to remove footer as some will show in front of the chat screen.
This also uses my modified Tinychat embed file, This get's updated externally so you'll never need to update it.
If you want to use Tinychats original then you'll have to change the embed file url to http://tinychat.com/embed/chat.js.
Some themes may have issues with keyboard shortcuts, Especially for those that use jetpack, You'll have to disable the admin navbar from your frontend by adding 
// Remove Admin Bar Front End
add_filter('show_admin_bar', '__return_false');
to your themes functions.php file.

== Screenshots ==

* TinyChat load screen, Users of TinyChat will notice the colour change.
* Once loaded you'll have to enter a name.
* This is showing the YouTube/Soundcloud buttons.
* Both show popups which you just enter what you'd like to search.
* This is how it displays with both YouTube and Soundcloud.
* Click this to maximize the video size, This also works when you're on camera.
* This is how it looks using the larger video's.

== Notes ==

This is full screen video chat that is used on TinyChat, This will use your domain name as the chatroom name,
This way it'll never conflict with other rooms on TinyChat,
If anyone else requires another feature or has an idea for me to implement, Then open a support ticket with the relevant information.

== Frequently Asked Questions ==

* Q. Can I use this if I'm not logged in?
* A. No!, I removed that feature due to a few requests, You can simply allow guest access by removing. * }
function wp_show_wordpress_chat() {
	$current_user = wp_get_current_user();
	if($current_user->ID == 0) {
		echo('<b>You are not logged in, please login before trying to chat!</b>' );
		return;
	} * on line 53

* Q. The chat is not loading for me.
* A. Check to see if you have the Adobe flash player installed (http://helpx.adobe.com/flash-player.html) and JavaScript enabled in your browser.

* Q. How do I add it to my blog/website?
* A. Just go to the backend and on appearance select menus, From there you can add your page, It'll be *chatroom* by default.

* Q. I'm having issues with my wordpress keyboard shortcuts affecting my chat, It's not allowing me to use certain letters.
* A. The fix for this is to disable the Admin navbar on your frontend only, to do this add * // Remove Admin Bar Front End
add_filter('show_admin_bar', '__return_false'); * to you funtions.php file in your themes folder.

== Changelog ==

= 1.0.1 =
* First live version.
* Updated it to auto create the page and insert the short code for you.

= 1.0.1 =
* Added random number to stop the use of same rooms on TinyChat.

= 1.0.2 =
* Update of the Div files to the original TinyChat ones.

= 1.0.3 =
* Update of core components.

= 1.0.4 =
* Removal of White space.

= 1.0.5 =
* Removed the random number from rooms, Now done it so it uses the domain name for room name, Also added my social links.
* Now updated to have the domain name as the room name, It'll remove whitespace and special characters.

= 1.0.6 =
* Update of core components.
* Removed some unnecessary code, it should also load quicker.

= 1.0.7 = 
* Renamed to wordpress-video-chat for easier seaching of the plugin.

= 1.0.8 = 
* Major update to the core as it was only loading on certain themes, 
Also there seemed to be a conflict with another plugin.
* Now works in 99% of all themes and on WordPress 4.0+

= 1.0.9 =
* Had to do a quick fix due to chat loading on all pages!

= 1.1.0 =
* Few updates to core.

= 1.1.3 =
* Added "account" so as all users can now PM each other.

= 1.1.6 =
* Now stopped guest access to rooms, Only logged in members may chat.

= 1.1.8 =
* I've had to update the core due to rocketplayer script being unable to work, SoI've disabled rocketscript if your sites use this by default.

= 1.2.9 =
* Fixed the account issue, It'll now get user ID (Number) so you can private message each other in chat.

= 1.3.2 =
* It will now grab the correct username, This will also display a profile in your name on TinyChat.

= 1.3.6 =
* When you now click the share button within chat it'll display your correct link, just copy it then paste on your social networks.

== Social Sites ==

* Website - https://www.ruddernation.com

* Room Spy - https://www.tinychat-spy.com

* Facebook - https://www.facebook.com/rndtc

* Twitter - https://twitter.com/R_N_Designs

* Github - https://github.com/ruddernation

* WordPress - https://profiles.wordpress.org/ruddernation

* Skype - ruddernation.designs
