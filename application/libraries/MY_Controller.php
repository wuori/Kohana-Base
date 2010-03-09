<?php defined('SYSPATH') OR die('No direct access allowed.');

 class Controller extends Controller_Core
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function show_header($title='',$meta=false,$section=false)
	{
		//** Load Doc Head
		$header = new View('page/header');
		$header->meta = $meta;
		$header->page_title = $title;
		$header->section = $section;
		$header->Render(true);
	}
			
	public function show_footer()
	{
		//** Load Doc Footer
		$header = new View('page/footer');
		$header->Render(true);
	}
			
}