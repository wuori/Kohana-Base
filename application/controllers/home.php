<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Default Kohana controller. This controller should NOT be used in production.
 * It is for demonstration purposes only!
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Home_Controller extends Controller {

	public function __construct()
	{
		parent::__construct();
		//** Init Cache
		$this->cache = Cache::instance();
	}	
	
	public function index()
	{
		
		//** Init Page
		$this->show_header('A Business Guide to Rock Hill, SC');
		
		//** Init View
		$view = new View('home');

		//** Get Data
		
		# Page Features (cached 15 minutes)
		$page_features = $this->cache->get('hp_page_features');
		if (!$page_features)
		{
			$this->Features_model = new Features_Model;
			$page_features = $this->Features_model->get_page_features(false,2);
		    $this->cache->set('hp_page_features', $page_features, false, 600);
		}
		$view->page_features = $page_features;
		
		# Blog (cached)
		$blog_posts = $this->cache->get('hp_blog');
		if (!$blog_posts)
		{
			$this->Blog_model = new Blog_Model;
			$blog_posts = $this->Blog_model->get_posts(3,0);
		    $this->cache->set('hp_blog', $blog_posts, false, 3600);
		}
		$view->posts = $blog_posts;
		
		# Upcoming Events (cached)
		$events = $this->cache->get('hp_events');
		if (!$events)
		{
			$this->Events_model = new Events_Model;
			$events = $this->Events_model->get_events(false,false,false,false,false,2,true);
		    $this->cache->set('hp_events', $events, false, 9600);
		}
		$view->events = $events;

		//** Output
	  	$view->render(true);
		$this->show_footer();
	}
	
	public function features_xml($limit=5)
	{
		# Main Features (cached)
		$hp_features = $this->cache->get('hp_features');
		if (!$hp_features)
		{
			$this->Features_model = new Features_Model;
			$hp_features = $this->Features_model->get_homepage_features($limit);
		    $this->cache->set('hp_features', $hp_features, false, 3700);
		}
		if(!$hp_features) exit;

		$xml='
			<?xml version="1.0" encoding="ISO-8859-1"?>
			<content>';
		
		foreach($hp_features as $feature){
			#$image_url = 'http://www.onlyinoldtown.com/content/homepage_features/'.$feature['ID'].'.jpg';
			$image_url = '/content/homepage_features/'.$feature['ID'].'.jpg';
			$xml.='	
				<feature color="'.$feature['color'].'" url="'.$feature['url'].'">
					<image>'.$image_url.'</image>
					<title><![CDATA['.$feature['title'].']]></title>
					<subtitle><![CDATA['.$feature['sub_title'].']]></subtitle>
				</feature>';
		}
		
		$xml.='			
			</content>
		';
		
		exit($xml);
	}

	public function newsletter()
	{
		//** Init View
		$view = new View('page/newsletter_signup');
		//** Output
	  	$view->render(true);
	}
	
	public function newsletter_signup()
	{
		if(!$_POST['name'] || !$_POST['email'] || !$_POST['lists']) exit(0);
		
		//init
		$m = new CampaignMonitorBase(Kohana::config('oot.campaign_monitor_master_api'));
		
		//subscribe
		$lists = explode(',',$_POST['lists']);
		foreach($lists as $list){
			$m->subscriberAdd($_POST['email'],  $_POST['name'], $list, true);
		}
		
		exit(1);
	}

} // End Controller
