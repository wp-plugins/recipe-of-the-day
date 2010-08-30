<?php
/*
Plugin Name: Recipe of the Day
Plugin URI: http://www.onlinerel.com/wordpress-plugins/
Description: Plugin "Recipe of the Day" displays categorized recipes on your blog. There are over 20,000 recipes in 40 categories. Recipes are saved on our database, so you don't need to have space for all that information. 
Version: 1.3
Author: A.Kilius
Author URI: http://www.onlinerel.com/wordpress-plugins/
License: GPL2
*/

define(recipe_day_READER_URL_RSS_DEFAULT, 'http://www.findbestfood.net/feed');
define(recipe_day_READER_TITLE, 'Recipe of the Day');
define(recipe_day_MAX_SHOWN_ITEMS, 10);
define(recipe_day_DESCRIPTION_COUNT_CHARS, 500);


function recipe_day_widget_ShowRss($args)
{
	//@ini_set('allow_url_fopen', 1);	
	if( file_exists( ABSPATH . WPINC . '/rss.php') ) {
		require_once(ABSPATH . WPINC . '/rss.php');		
	} else {
		require_once(ABSPATH . WPINC . '/rss-functions.php');
	}
	
	$options = get_option('recipe_day_widget');

	if( $options == false ) {
		$options[ 'recipe_day_widget_url_title' ] = recipe_day_READER_TITLE;
		$options[ 'recipe_day_widget_RSS_url' ] = recipe_day_READER_URL_RSS_DEFAULT;
		$options[ 'recipe_day_widget_RSS_count_items' ] = recipe_day_MAX_SHOWN_ITEMS;
	}

 $RSSurl = recipe_day_READER_URL_RSS_DEFAULT;
	$messages = fetch_rss($RSSurl);
	$title = $options[ 'recipe_day_widget_url_title' ];
	
	$messages_count = count($messages->items);
	if($messages_count != 0){
		$output = '<ul>';		
		for($i=0; $i<$options['recipe_day_widget_RSS_count_items'] && $i<$messages_count; $i++)
		{			
			$output .= '<li>';
			$output .= '<a href="'.$messages->items[$i]['link'].'?ad=1">'.$messages->items[$i]['title'].'</a></span>';						
				$output .= '</li>';
		}
		$output .= '</ul>';
	}
	
	extract($args);	
	?>
	<?php echo $before_widget; ?>
	<?php echo $before_title . $title . $after_title; ?>	
	<?php echo $output; ?>
	<?php echo $after_widget; ?>
	<?php	
}


function recipe_day_widget_Admin()
{
	$options = $newoptions = get_option('recipe_day_widget');	
	//default settings
	if( $options == false ) {
		$newoptions[ 'recipe_day_widget_url_title' ] = recipe_day_READER_TITLE;
		$newoptions[ 'recipe_day_widget_RSS_url' ] = recipe_day_READER_URL_RSS_DEFAULT;
		$newoptions['recipe_day_widget_RSS_count_items'] = recipe_day_MAX_SHOWN_ITEMS;		
	}
	if ( $_POST["recipe_day_widget-submit"] ) {
		$newoptions['recipe_day_widget_url_title'] = strip_tags(stripslashes($_POST["recipe_day_widget_url_title"]));
		$newoptions['recipe_day_widget_RSS_url'] = recipe_day_READER_URL_RSS_DEFAULT;
		$newoptions['recipe_day_widget_RSS_count_items'] = strip_tags(stripslashes($_POST["recipe_day_widget_RSS_count_items"]));
	}	
		
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('recipe_day_widget', $options);		
	}
	$recipe_day_widget_url_title = wp_specialchars($options['recipe_day_widget_url_title']);
	$recipe_day_widget_RSS_url = recipe_day_READER_URL_RSS_DEFAULT;	
	$recipe_day_widget_RSS_count_items = $options['recipe_day_widget_RSS_count_items'];
	
	?><form method="post" action="">	

	<p><label for="recipe_day_widget_url_title"><?php _e('Title:'); ?> <input style="width: 350px;" id="recipe_day_widget_url_title" name="recipe_day_widget_url_title" type="text" value="<?php echo $recipe_day_widget_url_title; ?>" /></label></p>
 
	<p><label for="recipe_day_widget_RSS_count_items"><?php _e('Count Items To Show:'); ?> <input  id="recipe_day_widget_RSS_count_items" name="recipe_day_widget_RSS_count_items" size="2" maxlength="2" type="text" value="<?php echo $recipe_day_widget_RSS_count_items?>" /></label></p>
	
	<br clear='all'></p>
	<input type="hidden" id="recipe_day_widget-submit" name="recipe_day_widget-submit" value="1" />	
	</form>
	<?php
}

add_action('admin_menu', 'recipe_day_menu');

function recipe_day_menu() {
	add_options_page('Recipe of the Day', 'Recipe of the Day', 8, __FILE__, 'recipe_day_options');
}

function recipe_day_options() {	
	?>
	<div class="wrap">
		<h2>Recipe of the Day</h2>
<p><b>Plugin "Recipe of the Day" displays categorized recipes on your blog. There are over 20,000 recipes in 40 categories. Recipes are saved on our database, so you don't need to have space for all that information.</b> </p>
<p> <h3>Add the widget "Recipe of the Day"  to your sidebar from Appearance->Widgets and configure the widget options.</h3></p>
 <hr /> <hr />
 
  		<h2>Joke of the Day</h2>
<p><b>Plugin "Joke of the Day" displays categorized jokes on your blog. There are over 40,000 jokes in 40 categories. Jokes are saved on our database, so you don't need to have space for all that information. </b> </p>
 <h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/joke-of-the-day/">Joke of the Day</h3></a>
   <hr /> <hr />
 
 <h2>WP Social Bookmarking</h2>
<p><b>WP-Social-Bookmarking plugin will add a image below your posts, allowing your visitors to share your posts with their friends, on FaceBook, Twitter, Myspace, Friendfeed, Technorati, del.icio.us, Digg, Google, Yahoo Buzz, StumbleUpon.</b></p>
<p><b>Plugin suport sharing your posts feed on <a href="http://www.onlinerel.com/">OnlineRel</a>. This helps to promote your blog and get more traffic.</b></p>

<p>Advertise your real estate, cars, items... Buy, Sell, Rent. Free promote your site:
<ul>
	<li><a target="_blank" href="http://www.onlinerel.com/">OnlineRel</a></li>
	<li><a target="_blank" href="http://www.easyfreeads.com/">Easy Free Ads</a></li>
	<li><a target="_blank" href="http://www.worldestatesite.com/">World Estate Site</a></li>
	<li><a target="_blank" href="http://www.facebook.com/pages/EasyFreeAds/106166672771355">Promote site on Facebook</a></li>	
</ul>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/wp-social-bookmarking/">WP Social Bookmarking</h3></a>
</p>
	</div>
	<?php
}

function recipe_day_widget_Init()
{
  register_sidebar_widget(__('Recipe of the Day'), 'recipe_day_widget_ShowRss');
  register_widget_control(__('Recipe of the Day'), 'recipe_day_widget_Admin', 500, 250);
}
add_action("plugins_loaded", "recipe_day_widget_Init");


?>