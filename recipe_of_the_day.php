<?php
/*
Plugin Name: Recipe of the Day
Plugin URI: http://www.premiumresponsive.com/wordpress-plugins/
Description: Plugin "Recipe of the Day" displays categorized recipes on your blog. There are over 20,000 recipes in 40 categories. Recipes are saved on our database, so you don't need to have space for all that information. 
Version: 3.5
Author: A.Kilius
Author URI: http://www.premiumresponsive.com/wordpress-plugins/
*/

define(recipe_day_TITLE, 'Recipe of the Day');
define(recipe_day_URL_RSS_DEFAULT, 'http://www.findbestfood.net/category/ethnic/feed/');
define(recipe_day_MAX_SHOWN_ITEMS, 10);
      
function recipe_day_widget_Init()
{
  register_sidebar_widget(__('Recipe of the Day'), 'recipe_day_widget_ShowRss');
  register_widget_control(__('Recipe of the Day'), 'recipe_day_widget_Admin', 500, 250);
}
add_action("plugins_loaded", "recipe_day_widget_Init");

function recipe_day_menu() {
	add_menu_page('Recipe of the Day', 'Recipe of the Day', 8, __FILE__, 'recipe_day_options');
}
add_action('admin_menu', 'recipe_day_menu');		

function recipe_day_widget_ShowRss($args)
{
 $options = get_option('recipe_day_widget');
	if( $options == false ) {
		$options[ 'recipe_day_widget_url_title' ] = recipe_day_TITLE;
		$options[ 'recipe_day_widget_RSS_count_items' ] = recipe_day_MAX_SHOWN_ITEMS;
	}

 $feed = recipe_day_URL_RSS_DEFAULT; 
	$title = $options[ 'recipe_day_widget_url_title' ];
 $rss = fetch_feed( $feed );
		if ( !is_wp_error( $rss ) ) :
			$maxitems = $rss->get_item_quantity($options['recipe_day_widget_RSS_count_items'] );
			$items = $rss->get_items( 0, $maxitems );
				endif;
 $output .= ' <!-- WP plugin:  Recipe of the Day --> <ul>';	
	if($items) { 
 			foreach ( $items as $item ) :
				// Create post object                                                           
  $titlee = trim($item->get_title()); 
  $output .= '<li> <a href="';
 $output .=  $item->get_permalink();
  $output .= '"  title="'.$titlee.'" target="_blank">';
   $output .= $titlee.'</a> ';
	 $output .= '</li>'; 
   		endforeach;		
	}
			$output .= '</ul> ';	 			
	extract($args);	
  echo $before_widget;  
  echo $before_title . $title . $after_title;  
 echo $output;  
 echo $after_widget;      
 }

function recipe_day_widget_Admin()
{
	$options = $newoptions = get_option('recipe_day_widget');	
	//default settings                                                                     
	if( $options == false ) {
		$newoptions[ 'recipe_day_widget_url_title' ] = recipe_day_TITLE;
		$newoptions['recipe_day_widget_RSS_count_items'] = recipe_day_MAX_SHOWN_ITEMS;		
	}
	if ( $_POST["recipe_day_widget-submit"] ) {
		$newoptions['recipe_day_widget_url_title'] = strip_tags(stripslashes($_POST["recipe_day_widget_url_title"]));
		$newoptions['recipe_day_widget_RSS_count_items'] = strip_tags(stripslashes($_POST["recipe_day_widget_RSS_count_items"]));
	}	
		
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('recipe_day_widget', $options);		
	}
	$recipe_day_widget_url_title = wp_specialchars($options['recipe_day_widget_url_title']);
	$recipe_day_widget_RSS_count_items = $options['recipe_day_widget_RSS_count_items'];

	?> 
	<p><label for="recipe_day_widget_url_title"><?php _e('Title:'); ?> <input style="width: 350px;" id="recipe_day_widget_url_title" name="recipe_day_widget_url_title" type="text" value="<?php echo $recipe_day_widget_url_title; ?>" /></label></p> 
	<p><label for="recipe_day_widget_RSS_count_items"><?php _e('Count Items To Show:'); ?> <input  id="recipe_day_widget_RSS_count_items" name="recipe_day_widget_RSS_count_items" size="2" maxlength="2" type="text" value="<?php echo $recipe_day_widget_RSS_count_items?>" /></label></p>	
	<br clear='all'></p>
	<input type="hidden" id="recipe_day_widget-submit" name="recipe_day_widget-submit" value="1" />	
 	<?php
}

function recipe_day7_widget_Admin()
{
	$options = $newoptions = get_option('recipe_day_widget');	
                                                                
	if( $options == false ) {
		$newoptions[ 'recipe_day_widget_url_title' ] = recipe_day_TITLE;
		$newoptions['recipe_day_widget_RSS_count_items'] = recipe_day_MAX_SHOWN_ITEMS;		
	}
	 		}

add_filter("plugin_action_links", 'recipe_day_ActionLink', 10, 2);

function recipe_day_ActionLink( $links, $file ) {
	    static $this_plugin;		
		if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__); 
        if ( $file == $this_plugin ) {
			$settings_link = "<a href='".admin_url( "options-general.php?page=".$this_plugin )."'>". __('Settings') ."</a>";
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

function recipe_day_options() {	
	?>
	<div class="wrap">
		<h2>Recipe of the Day</h2>
<p>
<b>Plugin "Recipe of the Day" displays categorized recipes on your blog. There are over 20,000 recipes in 40 categories. Recipes are saved on our database, so you don't need to have space for all that information.</b> </p>
<p> <h3>Add the widget "Recipe of the Day"  to your sidebar from <a href="<? echo "./widgets.php";?>"> Appearance->Widgets</a>  and configure the widget options.</h3>
<h3>More <a href="http://www.premiumresponsive.com/wordpress-plugins/" target="_blank"> WordPress Plugins</a></h3></p>
</p>
 	</div>
	<?php
		}
?>