<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

//require APPPATH . '/libraries/BaseController.php';


/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Welcome extends CI_Controller
{
    
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('admin/product_model');
        $this->load->library('base_library');
        // Cookie helper
        $this->load->helper('cookie');
     }



    /**
     * Index Page for this controller.
     */
    // Index =============================================================
    public function index()
    {
      // Onload Comon Page Data ============================= 
    	$data = array();
      



       // Define =========================== 
       $data["title"]="Welcome To Ale-izba";
       $data["file"]="front/welcome";
       $this->load->view('front/template',$data);
    } 

}

?>