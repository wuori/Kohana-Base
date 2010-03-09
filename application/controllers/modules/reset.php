<?php defined('SYSPATH') OR die('No direct access allowed.');

class Reset_Controller extends Controller {

	public function __construct()
	{
		parent::__construct();
	}	
	
	public function index()
	{
		// Clear all cache files
		$this->cache = Cache::instance();
		$this->cache->delete_all();
	}
	
}