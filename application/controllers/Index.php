<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

//require APPPATH . '/libraries/BaseController.php';


/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Index extends CI_Controller
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
    
            header("location:".base_url().'admin');
            // Onload Comon Page Data ============================= 
            $data = array();
            // Define =========================== 
            $data["title"]="Customer Support";
            $data["file"]="front/index";
            $this->load->view('front/header/template',$data);
    }  

    public function cookieupdate()
    {
        $cookiesave = array(
         'name'   => 'Ale-izbaCookie',
         'value'  => '1',
         'expire' =>  time()+86400);

        set_cookie($cookiesave);
        exit;
    } 

}

?>