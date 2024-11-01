<?php
/*
	Plugin Name: WP-UDIF-Entrecard
	Plugin URI: https://wiki.geekyhabitat.com/tiki-index.php?page=WP-UDIF-Entrecard
	Version: v0.13
	Author: Stuart Ryan
	Author URI: http://www.secludedhabitat.com/
	Description: A plugin that displays an Entrecard Widget with a selectable U Drop I Follow image below it. Any issues with this plugin should be reported on <a href="http://bugzilla.geekyhabitat.com/">GeekyHabitat BugZilla</a>
*/

/*  Copyright 2008  Stuart Ryan  (email : bugmin@geekyhabitat.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



function widget_wpudifentrecardPlugin_init() {
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ){
		return;
	}

	function widget_wpudifentrecard($args) {
		extract($args);
		$options = get_option('widget_wpudifentrecard');
		$title = empty($options['title']) ? 'Entrecard' : $options['title'];
		$generated_code = $options['generated_code'];
						
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $generated_code;
		echo $after_widget;
	}
			
			

	function widget_wpudifentrecard_control() {
		$options = $newoptions = get_option('widget_wpudifentrecard');
		if ($_POST['wp-udif-entrecard-submit']) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['wpudifentrecard-title']));
			$newoptions['dashboard_user_id'] = strip_tags(stripslashes($_POST['wpudifentrecard-dashboard_user_id']));
			$newoptions['entrecard_widget_size'] = strip_tags(stripslashes($_POST['wpudifentrecard-entrecard_widget_size']));
			$imageno = strip_tags(stripslashes($_POST['wpudifentrecard-ufollow_image_no']));
			$newoptions['ufollow_image_no'] = (empty($imageno) ? 's1.jpg' : $imageno);
			$newoptions['generated_code'] = '<center><script src="http://entrecard.s3.amazonaws.com/widget.js?user_id=' . $newoptions['dashboard_user_id'] . '&amp;type=standard_' . $newoptions['entrecard_widget_size'] . '" type="text/javascript" id="ecard_widget"></script><br /><a href="http://leedoyle.com/u-drop-i-follow"><img src="http://leedoyle.com/udrop/images/' . $newoptions['ufollow_image_no'] . '" style="border: 0;" alt="U Drop I Follow" /></a></center>';
		}
		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_wpudifentrecard', $options);
		}
		
		$dashboard_user_id = $options['dashboard_user_id'];
		$entrecard_widget_size = $options['entrecard_widget_size'];
		$ufollow_image_no = $options['ufollow_image_no'];
		$title = $options['title'];
		
		echo '<div>';
		echo '<label for="wpudifentrecard-title" style="line-height:35px;display:block;">Title: <input type="text" id="wpudifentrecard-title" name="wpudifentrecard-title" value="' . $title . '" /></label>';
		echo '<label for="wpudifentrecard-dashboard_user_id" style="line-height:35px;display:block;">Entrecard Dashboard User ID: <input type="text" id="wpudifentrecard-dashboard_user_id" name="wpudifentrecard-dashboard_user_id" value="' . $dashboard_user_id . '" /></label>';
		echo '<label for="wpudif-entrecard_widget_size">Entrecard Widget Size: </label><select id="wpudifentrecard-entrecard_widget_size" name="wpudifentrecard-entrecard_widget_size" size="1"><option value="127" ';
		selected('127', $entrecard_widget_size);
		echo '>Small</option><option value="200" ';
		selected('200', $entrecard_widget_size);
		echo '>Medium</option><option value="250" ';
		selected('250', $entrecard_widget_size);
		echo '>Large</option></select>';
		echo '<label for="wpudifentrecard-ufollow_image_no" style="line-height:35px;display:block;">Image Filename: <input type="text" id="wpudifentrecard-ufollow_image_no" name="wpudifentrecard-ufollow_image_no" value="' . $ufollow_image_no . '" /></label>';
		echo '<a href="http://leedoyle.com/u-drop-i-follow/u-drop-i-follow-badges" target="_blank">See all available images and filenames here</a>';
		echo '<input type="hidden" name="wp-udif-entrecard-submit" id="wp-udif-entrecard-submit" value="1" />';
		echo '</div>';
	}
	
	register_sidebar_widget('WP UDIF Entrecard', 'widget_wpudifentrecard');
	register_widget_control('WP UDIF Entrecard', 'widget_wpudifentrecard_control', 400, 300);
} 
add_action('widgets_init', 'widget_wpudifentrecardPlugin_init');
?>
