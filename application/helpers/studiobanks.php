<?php 
/*
* Studiobanks Help
* @author Michael Wuori
*
*/

class studiobanks_Core{

	// Current Menu Item
	// Returns class for current menu item
	public static function is_current($item='',$against = '',$class='current')
	{		
		return ($item==$against) ? ' class="current"' : false;
	}

	// ago()
	// Displays verbal time since a php date
	public static function ago($timestamp)
	{
		$difference = time() - $timestamp;
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");
		for($j = 0; $difference >= $lengths[$j]; $j++)
		$difference /= $lengths[$j];
		$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
		$text = ($j>0) ? "$difference $periods[$j] ago" : 'just now';
		return $text;
	  }	

	// Get subdomain from url
	public static function get_subdomain()
	{
		// Initialize Host
		$hosts = explode(".", $_SERVER['HTTP_HOST']);
		// If subdomain = 'www' or no subdomain
		if(count($hosts)<3){
			return false;
		}else{
			return strtolower($hosts['0']);
		}				
	}

}


/* End of file studiobanks.php */
/* Location: ./system/helpers/studiobanks.php */