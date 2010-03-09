<?php defined('SYSPATH') OR die('No direct access allowed.');

class Contact_Controller extends Controller {

	public function __construct()
	{
		parent::__construct();
	}	
	
	public function index($errors=false,$form_data=false)
	{
		//** Init Cache
		$this->cache = Cache::instance();
		
		//** Init Page
		$this->show_header('Contact Us');
		
		//** Init View
		$view = new View('contact/contact');
		
		//** Init Form
		if(!$form_data) $form_data = array(
			"name" => '',
			"email" => '',
			"message" => ''
		);
		$view->form_data = $form_data;
		$view->errors = $errors;

		//** Get Data		
		# Flickr Sets (cached)
		$hp_photos = $this->cache->get('hp_photos');
		if (!$hp_photos || 1==1)
		{
			$flickr = new Flickr_Controller;
			$hp_photos = $flickr->get_latest_sets(3);
		    $this->cache->set('hp_photos', $hp_photos, false, 3600);
		}
		$view->flickr_photos = $hp_photos;

		//** Output
	  	$view->render(true);
		$this->show_footer();
	}
	
	public function success()
	{
		//** Init Cache
		$this->cache = Cache::instance();
		
		//** Init Page
		$this->show_header('Contact Us');
		
		//** Init View
		$view = new View('contact/contact_success');
		
		//** Get Data		
		# Flickr Sets (cached)
		$hp_photos = $this->cache->get('hp_photos');
		if (!$hp_photos || 1==1)
		{
			$flickr = new Flickr_Controller;
			$hp_photos = $flickr->get_latest_sets(3);
		    $this->cache->set('hp_photos', $hp_photos, false, 3600);
		}
		$view->flickr_photos = $hp_photos;

		//** Output
	  	$view->render(true);
		$this->show_footer();
	}
	
	public function submit()
	{
		//** Validate POST
    	$post = new Validation($_POST);
		$post->pre_filter('trim',TRUE);
		$post->add_rules('name','required');
		$post->add_rules('email','required','email');
		$post->add_rules('message','required');
		if($post->validate())
		{
			//** Form has validated. Send Email and present success page
			$form_data = $post->as_array();
			$this->send_email('contact',$form_data);
			url::redirect('/contact/success');
		}
		else
		{
			//** Form did not validate. Build errors and return field values.
			$errors = $post->errors();
			$form_data = $post->as_array();
			$this->index($errors,$form_data);
		}
	}
	
	public function send_email($type=false,$data=false)
	{
		//** Init
		switch($type){
		
			case 'contact':
			default:
				$data['to_address'] = Kohana::config('oot.contact_email');
				$view = 'contact/email';
				$subject = 'Message from RockHillUSA.com Contact Page';		
		}
		
		$view = new View($view);
		
		# Data array sent to view for parsing
		$view->data = $data;
		
		//** Use Swift package to send html email

		# Use connect() method to load Swiftmailer and connect using the parameters set in the email config file
		$swift = email::connect();

		# From, subject and HTML message
		$from = 'messages@rockhillusa.com';
		$message = $view->render(false);

		# Build recipient lists
		$recipients = new Swift_RecipientList;
		$recipients->addTo($data['to_address']);

		# Build the HTML message
		$message = new Swift_Message($subject, $message, "text/html");

		if ($swift->send($message, $recipients, $from))
		{
		  // Success
		}
		else
		{
		  // Failure
		}

		// Disconnect
		$swift->disconnect();

	}

} // End Controller
