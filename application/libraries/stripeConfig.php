<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../assets/stripe-php-6.4.1/init.php';


class StripeConfig extends CI_Controller {
	public $stripe;
	function __construct() 
	{
        parent::__construct();
        

        $this->stripe = array(
          "secret_key"      => "sk_test_StW2yApk8i7uAQxzHCiwgt01",
          "publishable_key" => "pk_test_2yNHtbH7jydHUw0kByHsisAG"
        );
 	}
}
