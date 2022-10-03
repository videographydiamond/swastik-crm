<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

//require APPPATH . '/libraries/BaseController.php';


/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class PropertyList extends CI_Controller
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
        $this->load->model('propertyList_model');
        $this->load->helper('cookie');
        $this->load->library("pagination");

        
    }
        // Pagination Start

        // public function dataPage($dArr)
        // {

        //     $page= $this->input->get('page');
        //     $dArr['perPage']=1;
        //     $dArr['totalCount']=$this->propertyList_model->get_count();
        //     $dArr['page']= !empty($page)?1:$page;

        //     $data = array();
        //     $totalPage = $dArr['totalCount']/$dArr['perPage'];

        //     $this->pagination->initialize($dArr);
        //     $data['property']= $this->propertyList_model->get_property($dArr['perPage'], $page);
        //     $data['page_list']=$data;
        //     $this->load->view('pagination', $data);
        // }
        
        // Pagination End


        // Pagination Start

        public function dataPage() 
    {
        $pagination = array();
        $pagination["total_rows"] = $this->propertyList_model->get_count();
        $pagination["per_page"] = 4;
        $pagination["uri_segment"] = 1;

        $this->pagination->initialize($pagination);

        
        $page = ($this->uri->segment(1))? $this->uri->segment(1) : 0;
        
        $data["links"] = $this->pagination->create_links();

        $data['property'] = $this->propertyList_model->get_property($pagination["per_page"], $page);

        $this->load->view('pagination', $data);
    }

        
        //Pagination Start
        


        //Pagination End
        
     

    /**
     * Index Page for this controller.
     */
    // Index =============================================================
    // Sorting Code with Search Also
    public function index()
    {
    // Onload Comon Page Data ============================= 
        $data = array();
        $form_data  = $this->input->get();
        $search=null;
        $price=null;
        $city=null;
        $minPrice=null;
        $maxPrice=null;
        $bed=null;
        $bath=null;

        $rowperpage = 4;
        $rowno = 0;

        if(isset($form_data['per_page']) && $form_data['per_page']!= 0){
            $rowno = ($form_data['per_page']-1) * $rowperpage;
        }

        // Pagination Start
        //print_r($form_data);
        $page = $this->input->get('page');
        
     


        //Pagination End



    if(isset($form_data['PropertySortBy']) and $form_data['PropertySortBy'] !=='')
    {
        $price=  $form_data['PropertySortBy'];
 
    }

    if(isset($form_data['search']) and $form_data['search'] !=='')
    {
        $city=  $form_data ['search'];
             
    } 

    if(isset($form_data['minPrice']) and $form_data['minPrice'] !=='')
    {
        $minPrice=  $form_data['minPrice'];
    } 

    if(isset($form_data['maxPrice']) and $form_data['maxPrice'] !=='')
    {
        $maxPrice=  $form_data['maxPrice'];
    } 

    if(isset($form_data['bed']) and $form_data['bed'] !=='')
    {
        $bed=  $form_data['bed'];
    }

    if(isset($form_data['bath']) and $form_data['bath'] !=='')
    {
        $bath=  $form_data['bath'];
    }




      // Page

                $propertyListData= array();
                $propertyListData['price']=$price;
                $propertyListData['city']=$city;
                $propertyListData['minPrice']=$minPrice;
                $propertyListData['maxPrice']=$maxPrice;
                $propertyListData['bed']=$bed;
                $propertyListData['bath']=$bath;


                $pagination = array();
                $pagination["base_url"] = base_url() . "propertylist/index";
                $allcount = $this->propertyList_model->get_count($propertyListData);
                $pagination["per_page"] = $rowperpage ;
                $pagination["uri_segment"] = 3;

                $pagination['use_page_numbers'] = TRUE;
                $pagination['total_rows'] = $allcount;
                 


                $pagination['use_page_numbers'] = TRUE;
                $pagination['page_query_string'] = TRUE;

                
                // $pagination['full_tag_open'] = '<ul class="pagination" style="padding-left:50px;">';
                // $pagination['full_tag_close'] = '</ul>';
                // $pagination['first_link'] = '';
                // $pagination['last_link'] = '';
                // $pagination['first_tag_open'] = '<li class="page-item">';
                // $pagination['first_tag_close'] = '</li>';
                // $pagination['prev_link'] = 'Prev';
                // $pagination['prev_tag_open'] = '<li class="page-item ">';
                // $pagination['prev_tag_close'] = '</li>';
                // $pagination['next_link'] = 'Next';
                // $pagination['next_tag_open'] = '';
                // $pagination['next_tag_close'] = '';
                // $pagination['last_tag_open'] = '<li class="page-item ">';
                // $pagination['last_tag_close'] = '</li>';
                // $pagination['cur_tag_open'] = '<li class="page-item">';
                // $pagination['cur_tag_close'] = '</a></li>';
                // $pagination['num_tag_open'] = '<li class="page-item ">';
                // $pagination['num_tag_close'] = '</li>';


                $this->pagination->initialize($pagination);
                $data["links"] = $this->pagination->create_links();








    
    //echo " $rowno,$rowperpage ";
    $property_list= $this->propertyList_model->getPropertyList($propertyListData,$rowno,$rowperpage);
    //$property_list= $this->propertyList_model->getPropertyList($propertyListData, $pagination["per_page"], $page);
    $data['property_list']=$property_list;

    // Define =========================== 
    $data["title"]="Al-eizba";
    $data["file"]="front/property_list";
    $this->load->view('front/header/template',$data);

    }

    // public function loadAll(){

    //     dataPage();
    //     index();

    // }


  }
?>