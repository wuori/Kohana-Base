<?php defined('SYSPATH') OR die('No direct access allowed.');

class Blog_Controller extends Controller{

	public function __construct()
	{
		parent::__construct();
		$this->Blog_model = new Blog_Model;
		$this->page_post_limit = 6;
		$this->head_data = array(
			'<link rel="alternate" type="application/rss+xml" title="Only In Old Town Blog" href="http://www.onlyinoldtown.com/blog/feed" />'
		);
		//** Init Cache
		$this->cache = Cache::instance();
	}
	
	public function get_sidebar()
	{
		$sidebar = new View('blog/sidebar');
		
		//** Data
		
		# Blog Categories (cached)
		$categories = $this->cache->get('blog_cats');
		if (!$categories)
		{
			$categories = $this->Blog_model->get_categories();
		    $this->cache->set('blog_cats', $categories, false, 7200);
		}
		$sidebar->categories = $categories;
		
		# Blog Months (cached)
		$months = $this->cache->get('blog_months');
		if (!$months)
		{
			$months = $this->Blog_model->get_months();
		    $this->cache->set('blog_months', $months, false, 7200);
		}
		$sidebar->months = $months;
		
		# Flickr Sets (cached)
		$hp_photos = $this->cache->get('hp_photos');
		if (!$hp_photos || 1==1)
		{
			$flickr = new Flickr_Controller;
			$hp_photos = $flickr->get_latest_sets(3);
		    $this->cache->set('hp_photos', $hp_photos, false, 7200);
		}
		$sidebar->flickr_photos = $hp_photos;
		
		//** Render as data
		return $sidebar->render(FALSE);
	}
	
	public function index($page=1){
	
		//** Init Page
		$this->show_header('Blog',$this->head_data);
	
		//** Init View
		$view = new View('blog/blog');
		$view->sidebar = $this->get_sidebar();
		$view->sub_title = false;	
		$view->only_small_images = true;
		
		// Data
		$data['total_rows'] = $this->Blog_model->get_total();
		$view->pagination = new Pagination(array(
		    'base_url'    => 'blog/', // base_url will default to current uri
		    'uri_segment'    => 'page', // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $data['total_rows'], // use db count query here of course
		    'items_per_page' => $this->page_post_limit, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'new_digg' // pick one from: classic (default), digg, extended, punbb, or add your own!
		));
		
		$view->posts = $this->Blog_model->get_posts($this->page_post_limit,0);
		
		$view->render(TRUE);
		$this->show_footer();
		
	}
	
	public function feed(){
		
		$posts = $this->Blog_model->get_posts(30,0);
		$info = array(
			'title' => 'Only In Old Town Blog',
			'link' => 'http://www.onlyinoldtown.com/blog/feed',
			'description' => 'The latest news and happenings with Old Town Rock Hill.',
			'language' => 'en'
		);
		$items = array();
		foreach($posts as $row): 
			$post_link = url::base().'/blog/post/'.$row->post_ID.'/'.url::title($row->title);
			$image_src = Kohana::config('oot.content_path').'blog/'.'thumbs/'.$row->ID.'.jpg';
			$img = ($row->image=='1')  ? '<img src="'.$image_src.'" align="left" />' : '';
			$body = $img . $row->body;
			$items[] = array(
		    	'title' => $row->title,
		    	'link' =>  $post_link,
		    	'description' => $body,
		    	'author' => $row->author_name,
		    	'pubDate' => date(DATE_RFC822,strtotime($row->posted))
			);
		endforeach;
		header("Content-type: text/xml");
		exit(feed::create($info, $items));
	}
	
	public function page($page=1){

		//** Init Cache
		$this->cache = Cache::instance();
		$offset = ($page) ? $this->page_post_limit * $page-1 : 0;

		
		//** Init Page
		$this->show_header('Blog',$this->head_data);
	
		//** Init View
		$view = new View('blog/blog');
		$view->sidebar = $this->get_sidebar();
		$view->only_small_images = false;
		if($page!=1) $view->only_small_images = true;
	
		// Data
		$data['total_rows'] = $this->Blog_model->get_total();
		
		$view->pagination = new Pagination(array(
		    'base_url'    => 'blog/', // base_url will default to current uri
		    'uri_segment'    => 'page', // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $data['total_rows'], // use db count query here of course
		    'items_per_page' => 1, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'new_digg' // pick one from: classic (default), digg, extended, punbb, or add your own!
		));
		
		$view->posts = $this->Blog_model->get_posts($this->page_post_limit,$offset);
		$view->sub_title = false;
		
		$view->render(TRUE);
		$this->show_footer();
		
	}
	
	public function post($ID,$title){
			
		//** Init View
		$view = new View('blog/post');
		$view->sidebar = $this->get_sidebar();
		$view->only_small_images = false;
	
		//** Data
		$view->posts = $this->Blog_model->get_posts(1,0,array('tbox_blog.ID'),array($ID),true);
		$view->images = $this->Blog_model->get_post_images($ID);
		$view->sub_title = false;		
				
		//** Related Data
		$view->related_events = false;
		$view->related_locations = false;		
		
		# related events
		$events = $this->Blog_model->get_related_events($ID);
		if(count($events)){
			$related_events = new View('related/events');
			$related_events->events = $events;
			$view->related_events = $related_events->render(FALSE);
		}
		
		# related locations
		$locations = $this->Blog_model->get_related_locations($ID);
		if(count($locations)){
			$related_locations = new View('related/locations');
			$related_locations->locations = $locations;
			$view->related_locations = $related_locations->render(FALSE);
		}

		# Comment Form
		$comments = new View('modules/comments');
		$comments->comment_name =  'Comment';
		$comments->comment_item_id = $ID;
		$comments->comment_type = 'blog';
		$comments->comments = $this->Blog_model->get_comments(20,0,'tbox_blog_comments',$ID);
		$view->comments_section = $comments->render(FALSE);

		//** Init Page
		$this->show_header($view->posts[0]->title,$this->head_data);
		//** Show Page
		$view->render(TRUE);
		$this->show_footer();		

	}
	
	public function author($ID,$title,$p=false,$page=false)
	{
		//** Init Cache
		$this->cache = Cache::instance();
		$offset = ($page) ? $this->page_post_limit * $page-1 : 0;

		//** Init View
		$view = new View('blog/blog');
		$view->sidebar = $this->get_sidebar();
		$view->only_small_images = true;
	
		// Data
		$data['total_rows'] = $this->Blog_model->get_total(array('tbox_blog.contributor'),array($ID));
		
		$view->pagination = new Pagination(array(
		    'base_url'    => 'blog/author/'.$ID.'/'.$title.'/', // base_url will default to current uri
		    'uri_segment'    => 'page', // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $data['total_rows'], // use db count query here of course
		    'items_per_page' => $this->page_post_limit, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'new_digg' // pick one from: classic (default), digg, extended, punbb, or add your own!
		));
		
		$view->posts = $this->Blog_model->get_posts($this->page_post_limit,$offset,array('tbox_blog.contributor'),array($ID));
		$view->sub_title = 'Posts by ' . $view->posts[0]->author_name;
		
		//** Init Page
		$this->show_header($view->sub_title,$this->head_data);
		
		// Build Page
		$view->render(TRUE);
		$this->show_footer();
		
	}
	
	public function category($ID,$title='cat',$p=false,$page=false){

		//** Init Cache
		$this->cache = Cache::instance();
		$offset = ($page) ? $this->page_post_limit * $page-1 : 0;

		//** Init View
		$view = new View('blog/blog');
		$view->sidebar = $this->get_sidebar();
		$view->only_small_images = true;
	
		// Data
		$data['total_rows'] = $this->Blog_model->get_total(array('tbox_blog.category'),array($ID));
		
		$view->pagination = new Pagination(array(
		    'base_url'    => 'blog/category/'.$ID.'/'.$title.'/', // base_url will default to current uri
		    'uri_segment'    => 'page', // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $data['total_rows'], // use db count query here of course
		    'items_per_page' => $this->page_post_limit, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'new_digg' // pick one from: classic (default), digg, extended, punbb, or add your own!
		));
		
		$view->posts = $this->Blog_model->get_posts($this->page_post_limit,$offset,array('tbox_blog.category'),array($ID));
		$view->sub_title = $view->posts[0]->cat_name;
		
		//** Init Page
		$this->show_header($view->sub_title . ' Blog Posts',$this->head_data);
		
		// Build Page
		$view->render(TRUE);
		$this->show_footer();

	}
	
	public function archive($month=1,$year=2009,$p=false,$page=false){

		$quals = array("MONTH(tbox_blog.posted)","YEAR(tbox_blog.posted)");
		$vals = array($month,$year);
		
		//** Init Cache
		$this->cache = Cache::instance();
		$offset = ($page) ? $this->page_post_limit * $page-1 : 0;

		//** Init View
		$view = new View('blog/blog');
		$view->sidebar = $this->get_sidebar();
		$view->only_small_images = true;
	
		// Data
		$data['total_rows'] = $this->Blog_model->get_total($quals,$vals);
		
		$view->pagination = new Pagination(array(
		    'base_url'    => 'blog/archive/'.$month.'/'.$year.'/', // base_url will default to current uri
		    'uri_segment'    => 'page', // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $data['total_rows'], // use db count query here of course
		    'items_per_page' => $this->page_post_limit, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'new_digg' // pick one from: classic (default), digg, extended, punbb, or add your own!
		));
		
		$view->posts = $this->Blog_model->get_posts($this->page_post_limit,$offset,$quals,$vals);
		$view->sub_title = date('F',strtotime('01-'.$month.'-'.$year)).' '.$year;
		
		//** Init Page
		$this->show_header('Blog Posts for '.date('F',strtotime('01-'.$month.'-'.$year)).' '.$year,$this->head_data);
		
		// Build Page
		$view->render(TRUE);
		$this->show_footer();
		
	}
	
}


?>