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
        $this->load->model('admin/type_model');
        $this->load->helper('cookie');
        $this->load->library("pagination");


        
    }
   
    // Index =============================================================
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

        //Residential Modal Starts

        $searchResFilter=null;
        $cityResFilter=null;
        $propertyResFilter=null;
        $transactionResFilter=null;
        $minPriceResFilter=null;
        $maxPriceResFilter=null;
        $bedsResFilter=null;
        $bathsResFilter=null;
        $landResFilter=null;
        $keywordsResFilter=null;
        $yearBuiltResFilter=null;

        //Residential Modal Ends

        //Commercial Modal Starts

        $searchComFilter=null;
        $cityComFilter=null;
        $propertyComFilter=null;
        $transactionComFilter=null;
        $minPriceComFilter=null;
        $maxPriceComFilter=null;
        $landSizeComFilter=null;
        $yearBuiltComFilter=null;
        $keywordsComFilter=null;

        //Commercial Modal Ends

        $rowperpage = 4;
        $rowno = 0;

        if(isset($form_data['per_page']) && $form_data['per_page']!= 0){
            $rowno = ($form_data['per_page']-1) * $rowperpage;
        }

        // Pagination Start
        //print_r($form_data);
        $page = $this->input->get('page');
        //Pagination End
        // filter start 
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
        //End filter start


        //Residential Filter Modal Start

        if(isset($form_data['searchResFilter']) and $form_data['searchResFilter'] !=='')
        {
            $cityResFilter=  $form_data ['searchResFilter'];         
        }

        if (isset($form_data['propertyResFilter']) and $form_data['propertyResFilter'] !=='') {
            $propertyResFilter= $form_data['propertyResFilter'];
        }

        if (isset($form_data['transactionResFilter']) and $form_data['transactionResFilter'] !=='') {
            $transactionResFilter= $form_data['transactionResFilter'];
        }

        if (isset($form_data['minPriceResFilter']) and $form_data['minPriceResFilter'] !=='') {
            $minPriceResFilter= $form_data['minPriceResFilter'];
        }

        if (isset($form_data['maxPriceResFilter']) and $form_data['maxPriceResFilter'] !=='') {
            $maxPriceResFilter= $form_data['maxPriceResFilter'];
        }

        if (isset($form_data['bedsResFilter']) and $form_data['bedsResFilter'] !=='') {
            $bedsResFilter= $form_data['bedsResFilter'];
        }

        if (isset($form_data['bathsResFilter']) and $form_data['bathsResFilter'] !=='') {
            $bathsResFilter= $form_data['bathsResFilter'];
        }

        if (isset($form_data['landResFilter']) and $form_data['landResFilter'] !=='') {
            $landResFilter= $form_data['landResFilter'];
        }

        if (isset($form_data['keywordsResFilter']) and $form_data['keywordsResFilter'] !=='') {
            $keywordsResFilter= $form_data['keywordsResFilter'];
        }

        if (isset($form_data['yearBuiltResFilter']) and $form_data['yearBuiltResFilter'] !=='') {
            $yearBuiltResFilter= $form_data['yearBuiltResFilter'];
        }

        //Residential Filter Modal End

        //Commercial Filter Modal Start

        if (isset($form_data['searchComFilter']) and $form_data['searchComFilter'] !=='') {
            $cityComFilter= $form_data['searchComFilter'];
        }

        if (isset($form_data['propertyComFilter']) and $form_data['propertyComFilter'] !=='') {
            $propertyComFilter= $form_data['propertyComFilter'];
        }

        if (isset($form_data['transactionComFilter']) and $form_data['transactionComFilter'] !=='') {
            $transactionComFilter= $form_data['transactionComFilter'];
        }

        if (isset($form_data['minPriceComFilter']) and $form_data['minPriceComFilter'] !=='') {
            $minPriceComFilter= $form_data['minPriceComFilter'];
        }

        if (isset($form_data['maxPriceComFilter']) and $form_data['maxPriceComFilter'] !=='') {
            $maxPriceComFilter= $form_data['maxPriceComFilter'];
        }

        if (isset($form_data['landSizeComFilter']) and $form_data['landSizeComFilter'] !=='') {
            $landSizeComFilter= $form_data['landSizeComFilter'];
        }

        if (isset($form_data['yearBuiltComFilter']) and $form_data['yearBuiltComFilter'] !=='') {
            $yearBuiltComFilter= $form_data['yearBuiltComFilter'];
        }

        if (isset($form_data['keywordsComFilter']) and $form_data['keywordsComFilter'] !=='') {
            $keywordsComFilter= $form_data['keywordsComFilter'];
        }

        //Commercial Filter Modal Start

      // Page

        $propertyListData= array();
        $propertyListData['price']=$price;
        $propertyListData['city']=$city;
        $propertyListData['minPrice']=$minPrice;
        $propertyListData['maxPrice']=$maxPrice;
        $propertyListData['bed']=$bed;
        $propertyListData['bath']=$bath;

        //Residential Filter Modal Start

        $propertyListData['cityResFilter']=$cityResFilter;
        $propertyListData['propertyResFilter']=$propertyResFilter;
        $propertyListData['transactionResFilter']=$transactionResFilter;
        $propertyListData['minPriceResFilter']=$minPriceResFilter;
        $propertyListData['maxPriceResFilter']=$maxPriceResFilter;
        $propertyListData['bedsResFilter']=$bedsResFilter;
        $propertyListData['bathsResFilter']=$bathsResFilter;
        $propertyListData['landResFilter']=$landResFilter;
        $propertyListData['keywordsResFilter']=$keywordsResFilter;
        $propertyListData['yearBuiltResFilter']=$yearBuiltResFilter;

        //Residential Filter Modal End

        //Commercial Filter Modal Start

        $propertyListData['cityComFilter']=$cityComFilter;
        $propertyListData['propertyComFilter']=$propertyComFilter;
        $propertyListData['transactionComFilter']=$transactionComFilter;
        $propertyListData['minPriceComFilter']=$minPriceComFilter;
        $propertyListData['maxPriceComFilter']=$maxPriceComFilter;
        $propertyListData['landSizeComFilter']=$landSizeComFilter;
        $propertyListData['yearBuiltComFilter']=$yearBuiltComFilter;
        $propertyListData['keywordsComFilter']=$keywordsComFilter;

        //Commercial Filter Modal End

        // pagination arguments
        $propertyListData['perPage']='4';
        $propertyListData['currentPageNo']= (isset($_GET['page']) && $_GET['page'] !='' )?$_GET['page']:'0';
    
        //echo " $rowno,$rowperpage ";
        $property_list= $this->propertyList_model->getPropertyList($propertyListData);
        //$property_list= $this->propertyList_model->getPropertyList($propertyListData, $pagination["per_page"], $page);
        $data['property_list']=$property_list;
        $data['pagination']= isset($property_list['pagination'])?$property_list['pagination']:'';
        

        // Define =========================== 
        $data["title"]="Al-eizba";

        $data['getTypeList']  = $this->type_model->getTypeList();
        $data['getResidentialList']  = $this->type_model->getResidentialList();
        $data['getCommercialList']  = $this->type_model->getCommercialList();
        $data['PurposeList']  = $this->type_model->PurposeList();
        $data["file"]="front/property_list";
        $this->load->view('front/header/template',$data);

    }

            // Filter Page Start

            public function filterList() 
            {

                $data["title"]="Al-eizba";
                $data["file"]="front/property_listFilter";
                $this->load->view('front/header/template',$data);
            }

            // Filter Page End

    // get page data function
    // =============================================     
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


  }
?>