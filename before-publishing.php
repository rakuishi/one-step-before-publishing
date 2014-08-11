<?php
/*
Plugin Name: One Step Before Publishing
Plugin URI: http://rakuishi.com/wordpress-plugins/
Description: One Step Before Publishing is a WordPress plugin that display comfirmation dialog before publishing.
Version: 1.0.0
Author: rakuishi
Author URI: http://rakuishi.com/
License: GPL2
Text Domain: before-publishing
Domain Path: /languages

Copyright 2014 rakuishi

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

load_plugin_textdomain('before-publishing', false, dirname(plugin_basename(__FILE__)) . '/languages');

add_action('admin_print_scripts', 'before_publishing_admin_print_scripts');

function before_publishing_admin_print_scripts() {
	$message = __('Are you SURE you want to publish this post?', 'before-publishing');
	echo <<< EOF
<script type="text/javascript">
<!--
window.onload = function() {
	var publish = document.getElementById('publish');
	var hidden_post_status = document.getElementById('hidden_post_status');
	if (publish !== null && hidden_post_status !== null && hidden_post_status.value === 'draft') {
		publish.onclick = confirm_publishing;
	}
}
function confirm_publishing() {
	if (window.confirm('{$message}')) {
		return true;
	} else {
		/*
		 * Remove loading animation class
		 */
		var elements = document.getElementsByTagName('span');
		for (var i = 0; i < elements.length; i++) {
			var element = elements[i];
			if (element.className.indexOf("spinner", 0) != -1) {
				element.classList.remove('spinner');
			}
		}
		document.getElementById('publish').classList.remove('button-primary-disabled');
		document.getElementById('save-post').classList.remove('button-disabled');

		return false;
	}
}
// -->
</script>
EOF;
}
