<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Customer extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/customer_model');
        $this->load->model('admin/booking_model');
        $this->load->model('admin/farmers_model');
        $this->load->model('admin/city_model');
        $this->load->model('admin/state_model');
        $this->load->model('admin/district_model');
        $this->load->model('admin/call_type_model');
        $this->load->model('admin/call_direction_model');
        $this->load->model('admin/customer_call_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/admin_model');
        $this->load->model('admin/farmer_type_model');
        $this->load->model('admin/crop_model');

        $this->perPage =200; 


        
    }

    
    public function index()
    {
        /*$this->isLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Customer ';
        $this->loadViews("admin/customer/list", $this->global, $data , NULL);*/

        $this->addnew();
        
    }

    // Add New 

    public function addnew()
    {
    
            $this->isLoggedIn();


        $this->global['module_id']      = get_module_byurl('admin/customer/addnew');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }


            
            $data = array();

           
            
            
 

            $data['edit_data'] = array();
            $data['section'] = $this->input->get('section');
            $data['customer_call_dtl'] = array();

            $form_type  = $this->input->get('form_type');
            $conditions = array(); 
            $where_search = array();
            $current_date = ( @$this->input->get('last_follow_date'))?(@$this->input->get('last_follow_date')):date('Y-m-d');

         if($data['section']=='booking')
         {
            $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid   = $uid;
            } 

            $where_search   =  array();
            $conditions     =  array();
            $booking_type   = @$this->input->get('booking_type');

            if(!empty($booking_type))
            {
                $where_search['booking_type'] =  $booking_type;
            }
            

            $conditions['returnType']   = 'count';
            if(!empty($uid))
            {
                $conditions['uid']       = $uid;     
            } 

            $conditions['where']            = $where_search;  
             
            $totalRec = $this->booking_model->getRows($conditions);
            


             $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 4; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/customer/addnew/'; 
                $config['uri_segment'] = $uriSegment; 
                $config['total_rows']  = $totalRec; 
                $config['per_page']    = $this->perPage; 
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  justify-content-center mt-4" id="query-pagination">';
            $config['full_tag_close'] = '</ul> ';
             
            $config['first_link'] = 'First&nbsp;Page';
            $config['first_tag_open'] = '<li class="page-item">  ';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last&nbsp;Page';
            $config['last_tag_open'] ='<li class="page-item">  ';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="page-item"> ';
            $config['next_tag_close'] = ' </li>';
 
            $config['prev_link'] = 'Previous';
            $config['prev_tag_open'] = '<li class="page-item"> ';
            $config['prev_tag_close'] = '</li>';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link active">';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="page-item"> ';
            $config['num_tag_close'] = ' </li>';

                // Initialize pagination library 
                $this->pagination->initialize($config); 
                
              

                // Define offset 
                $page = $this->uri->segment($uriSegment); 
                $offset = (!$page)?0:$page; 

                if($offset != 0){
                    $offset = ($offset-1) * $this->perPage;
                }

                // Get records 
                $conditions = array( 
                'start' => $offset, 
                'where' => $where_search, 
                'limit' => $this->perPage 
                ); 
                 if(!empty($uid))
                    {
                        $conditions['uid']       = $uid;     
                    } 
                
                
                    
                $data['bookings'] = $this->booking_model->getRows($conditions); 

 
                


                $data['pagination_total_count'] =  $totalRec;


                $where_search = array();

           

         }else
         {
                if($form_type=='inquiry')
                {


             $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid   = $uid;
            } 



                $where_search =  array();
                $search_customer_id  = @$this->input->get('search_customer_id');
                $search_name         = @$this->input->get('search_name');
                $search_mobile       = @$this->input->get('search_mobile');
                $search_alt_mobile   = @$this->input->get('search_alt_mobile');
                $state2              = @$this->input->get('state2');
                $other_state2        = @$this->input->get('other_state2');
                $district2           = @$this->input->get('district2');
                $other_district2     = @$this->input->get('other_district2');
                $city2               = @$this->input->get('city2');
                $other_city2         = @$this->input->get('other_city2');
                $call_direction2     = @$this->input->get('call_direction2');
                $call_type2          = @$this->input->get('call_type2'); 
                $farmer_type2        = @$this->input->get('farmer_type2'); 
                $crop_id2            = @$this->input->get('crop_id2'); 
                $stat_type           = @$this->input->get('stat_type'); 
                $followup_type       = @$this->input->get('followup_type'); 
                $uid                 = @$this->input->get('uid'); 
                 
                if(!empty($search_customer_id))
                {
                    $where_search['farmer_id'] =  $search_customer_id;
                } 
                if(!empty($current_date))
                {
                    $where_search['current_date'] =  $current_date;
                }
                 if(!empty($stat_type))
                {
                    $where_search['stat_type'] =  $stat_type;
                }
                 if(!empty($search_name))
                {
                    $where_search['customer_title'] =  $search_name;
                } 
                
                if(!empty($search_mobile))
                {
                    $where_search['customer_mobile'] =  $search_mobile;
                }
                if(!empty($search_alt_mobile))
                {
                    $where_search['customer_alter_mobile'] =  $search_alt_mobile;
                }
                if(!empty($state2))
                {
                    $where_search['state'] =  $state2;
                }
                if(!empty($other_state2))
                {
                    $where_search['other_state'] =  $other_state2;
                }
                
                if(!empty($district2))
                {
                    $where_search['district'] =  $district2;
                }if(!empty($other_district2))
                {
                    $where_search['other_district'] =  $other_district2;
                }
                if(!empty($city2))
                {
                    $where_search['city'] =  $city2;
                } 
                if(!empty($other_city2))
                {
                    $where_search['other_city'] =  $other_city2;
                }
                if(!empty($call_direction2))
                {
                    $where_search['last_call_direction'] =  $call_direction2;
                } 
                if(!empty($call_type2))
                {
                    $where_search['last_call_type'] =  $call_type2;
                }
                if(!empty($farmer_type2))
                {
                    $where_search['farmer_type'] =  $farmer_type2;
                } 
                if(!empty($crop_id2))
                {
                    $where_search['crop_id'] =  $crop_id2;
                }

        } 


               

        $conditions['returnType']   = 'count';
        if(!empty($uid))
        {
            $conditions['uid']       = $uid;     
        } 

        $conditions['where']       = $where_search;  
        $conditions['form_type']    = $form_type;
        $conditions['followup_type'] = @$followup_type;



        $totalRec = $this->customer_model->getRows($conditions);
                    



 



            $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 4; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/customer/addnew/'; 
                $config['uri_segment'] = $uriSegment; 
                $config['total_rows']  = $totalRec; 
                $config['per_page']    = $this->perPage; 
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  justify-content-center mt-4" id="query-pagination">';
            $config['full_tag_close'] = '</ul> ';
             
            $config['first_link'] = '<<';
            $config['first_tag_open'] = '<li class="page-item">  ';
            $config['first_tag_close'] = '</li>';
            $config['num_links'] =7;
            $config['last_link'] = '>>';
            $config['last_tag_open'] ='<li class="page-item">  ';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = '>';
            $config['next_tag_open'] = '<li class="page-item"> ';
            $config['next_tag_close'] = ' </li>';
 
            $config['prev_link'] = '<';
            $config['prev_tag_open'] = '<li class="page-item"> ';
            $config['prev_tag_close'] = '</li>';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link active">';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="page-item"> ';
            $config['num_tag_close'] = ' </li>';

                // Initialize pagination library 
                $this->pagination->initialize($config); 
                
              

                // Define offset 
                $page = $this->uri->segment($uriSegment); 
                $offset = (!$page)?0:$page; 

                if($offset != 0){
                    $offset = ($offset-1) * $this->perPage;
                }

                // Get records 
                $conditions = array( 
                'start' => $offset, 
                'where' => $where_search, 
                'limit' => $this->perPage 
                ); 
                 if(!empty($uid))
                    {
                        $conditions['uid']       = $uid;     
                    } 
                
                $conditions['form_type'] = $form_type; 
                $conditions['followup_type'] = @$followup_type; 
                    
                $data['customers'] = $this->customer_model->getRows($conditions);
                $data['pagination_total_count'] =  $totalRec;

 

         }
          
        


         $form_type  = $this->input->get('form_type');
         if($form_type =='search')
         {
            $farmer_id    = $this->input->get('farmer_id');
            $mobile         = $this->input->get('mobile');

            

            if($farmer_id !=='' || $mobile !=='')
            {   
                $isserch = false;
                $where = array();
                $where['status'] = 1;
                if(!empty($farmer_id))
                {   
                    $isserch = true;

                     $where['id'] = $farmer_id;
                }

                if(!empty($mobile))
                {
                    $isserch = true;
                     $where['mobile'] = $mobile;
                }

                if($isserch)
                {

                    $farmers = $this->farmers_model->findDynamic($where);
                     
                    if(!empty($farmers))
                    {
                        $data['edit_data'] = $farmers[0];


                        $where = array();
                        $where['farmer_id'] =$data['edit_data']->id;
                        $where['orderby'] ='-id';
                        $where['limit'] ='1';
                        $customer= $this->customer_model->findDynamic($where);



                        if(!empty($customer))
                        {
                            $data['enquiry_id']  = $customer[0]->id;
                        }
                        $where = array();
                        $where['farmer_id'] = $data['edit_data']->id;
                        //$data['customer_call_dtl'] =$this->customer_call_detail($data['edit_data']->id);
                       // $data['customer_call_dtl'] = $this->customer_call_model->findDynamic($where);
                    }
                    


                     
                }



                
                 
                 
                
            }

         }
        
        $company_id = $this->session->userdata('company_id');

        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,customer_name,customer_title,sku_id';
        $data['all_customers'] = $this->customer_model->findDynamic($where);
        
        $where = array();
        $where['id !='] = '0';
        $where['company_id'] = $company_id;
        $where['field'] = 'id,name,title,status';
        $data['all_users'] = $this->admin_model->findDynamic($where);


        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['states'] = $this->state_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['districts'] = $this->district_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        $data['cities'] = $this->city_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['calltypes'] = $this->call_type_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['farmertypes'] = $this->farmer_type_model->findDynamic($where);

        $where = array(); 
        $where['status'] = '1'; 
        $crop_list = $this->crop_model->findDynamic($where);
        $data['crop_lists'] =  $crop_list;

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['calldirections'] = $this->call_direction_model->findDynamic($where);
        
       
            $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid   = $uid;
            }else
            {
                 $userid = $this->session->userdata('userId');
            }

           

            $data['count_call_summary'] = $this->customer_call_model->getCallsummary($data['calltypes'],$userid,'call_type',$current_date);
              
           
            $where = array();
            $where['last_follow_date'] =  $current_date  ;
            if($userid !=='all')
            {
                $where['assigned_to'] =  $userid;    
            }
            
            $where['farmer_id !='] =  '';
            $where['field'] = 'id';
            $total_calls  = $this->customer_model->findDynamic($where);; 
            $data['total_calls'] = count($total_calls);

            $where = array();
            $where['last_follow_date'] =  $current_date ;
            if($userid !=='all')
            {
                $where['assigned_to'] =  $userid;    
            }
            $where['farmer_id !='] =  '';
            $where['field'] = 'id';
            $where['groupby'] = 'farmer_id';
            $total_customer  = $this->customer_model->findDynamic($where);; 
            $data['total_customer'] = count($total_customer);

            /*fetch data of todays booked*/
            $where = array();
            $where['create_date'] =  $current_date;
            $where['field'] = 'id';
            $today_booking  = $this->booking_model->findDynamic($where);; 
            $data['today_booking'] = count($today_booking); 

            /*fetch data of within 7 days booked*/
            $where = array();
            $booded_start_date = date('Y-m-d',strtotime("-7 days"));
            $booded_end_date  = date('Y-m-d');
            $where['create_date >='] =  $booded_start_date;
            $where['create_date <='] =  $booded_end_date;
            $where['field'] = 'id';
            $where['company_id'] = $company_id;
            $week_booking  = $this->booking_model->findDynamic($where);; 
            $data['week_booking'] = count($week_booking);

            /*fetch data of this months of booking*/
             $where = array();
            $currentmonth = date("Y-m");

            $booded_start_date     = $currentmonth."-01";
            $booded_end_date       =$currentmonth."-31";

            $where['create_date >='] =  $booded_start_date;
            $where['create_date <='] =  $booded_end_date;
            $where['field'] = 'id';
            $where['company_id'] = $company_id;
            $this_month_booking  = $this->booking_model->findDynamic($where);; 
            $data['this_month_booking'] = count($this_month_booking);

 /*fetch data of previous months of booking*/
             $where         = array();
            $currentdate    = date("Y-m-d");

            $prevcurrentdate= date("Y-m", strtotime ( '-1 month' , strtotime ( $currentdate ) )) ;
            $booded_start_date     = $prevcurrentdate."-01";
            $end_date       = $prevcurrentdate."-31";

            $where['create_date >='] =  $booded_start_date;
            $where['create_date <='] =  $end_date;
            $where['field'] = 'id';
            $where['company_id'] = $company_id;
            $previous_month_booking  = $this->booking_model->findDynamic($where);; 
            $data['previous_month_booking'] = count($previous_month_booking);



            $data_param = array();
            $data_param['userid']       =  $userid;
            $data_param['stat_type']    = 'followup';
            $data_param['current_date']    = $current_date;
            $data_param['followup_type']= 'yesterday'; 
            $data_param['calltype']= $data['calltypes']; 
            $result =   $this->customer_call_model->callSummary($data_param);
            $follow_up_missed = count($result);
            $data['follow_up_missed'] = $follow_up_missed ; 
            $data['follow_up_missed_sub'] = $this->customer_call_model->getCallsummary($data['calltypes'],$userid,'followup',$current_date,'yesterday');
              
            $data_param = array();
            $data_param['userid']       =  $userid;
             $data_param['current_date']    = $current_date;
            $data_param['stat_type']    = 'followup';
            $data_param['followup_type']= 'today'; 
            $result =   $this->customer_call_model->callSummary($data_param);
            $follow_up_due_today = count($result);
              $data['follow_up_due_today'] = $follow_up_due_today ; 
              $data['follow_up_due_today_sub'] = $this->customer_call_model->getCallsummary($data['calltypes'],$userid,'followup',$current_date,'today');
             
            $data_param = array();
            $data_param['userid']       =  $userid;
             $data_param['current_date']    = $current_date;
            $data_param['stat_type']    = 'followup';
            $data_param['followup_type']= 'tomorrow'; 
            $result =   $this->customer_call_model->callSummary($data_param);
             

            $follow_up_due_tomorrow = count($result);
            $data['follow_up_due_tomorrow'] = $follow_up_due_tomorrow ;
            $data['follow_up_due_tomorrow_sub'] = $this->customer_call_model->getCallsummary($data['calltypes'],$userid,'followup',$current_date,'tomorrow'); 
            
            
          
            
        $this->global['pageTitle'] = 'Add New customer';
        $this->loadViews("admin/customer/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
         
         $this->global['module_id']      = get_module_byurl('admin/customer/addnew');
            $role_id                        = $this->session->userdata('role_id');
            $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
            if(@$action_requred->create !=='create')
            {
                $this->session->set_flashdata('error', 'Un-autherise Access');
                redirect(base_url());
            }


        $userid         = $this->session->userdata('userId');
        $company_id     = $this->session->userdata('company_id');
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('customer_name','customer_name','trim|required');
        $this->form_validation->set_rules('customer_mobile','customer_mobile','trim|required');
        /*$this->form_validation->set_rules('state','state','trim|required');
        $this->form_validation->set_rules('city','city','trim|required');*/

        
        $this->form_validation->set_rules('call_type','call_type','trim|required');
        $this->form_validation->set_rules('assign_to','assign_to','trim|required');
        $this->form_validation->set_rules('call_direction','call_direction','trim|required');
        $this->form_validation->set_rules('current_conversation','Current Conversation','trim|required');
        
        
        $form_data  = $this->input->post();

        
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {

            $redirect_url = $form_data['redirect_url'];

            if(isset($form_data['farmser_id2']) && $form_data['farmser_id2'] !=='')
            {
                    $farmer_id = $form_data['farmser_id2'];
                    $insertData = array();
                    $insertData['id']               = $farmer_id;
                    $insertData['name']             = $form_data['customer_name'];
                    $insertData['mobile']           = $form_data['customer_mobile'];
                    $insertData['alt_mobile']       = $form_data['customer_alter_mobile'];
                    $insertData['city_id']          = $form_data['city'];
                    $insertData['other_city']       = $form_data['other_city'];
                    $insertData['state_id']         = $form_data['state'];
                    $insertData['other_state']      = $form_data['other_state'];
                    $insertData['other_district']   = $form_data['other_district'];
                    $insertData['district_id']      = $form_data['district'];
                    $insertData['update_at']        = date("Y-m-d H:i:s");
                    $insertData['company_id']       = $company_id;
                    $insertData['update_by']        = $userid;
                    $insertData['farmer_type']      = $form_data['farmer_type'];
                    $insertData['crop_id']          = $form_data['crop_id'];

                    $result_added = $this->farmers_model->save($insertData);
                    //$farmer_id = $result_added;
            }else
            {
                $where = array();
                $where['mobile']= $form_data['customer_mobile'];
                $where['company_id']= $company_id;
                $exist_mobile    = $this->farmers_model->findDynamic($where);
                $insertData = array();

                if(empty($exist_mobile))
                {   
                        

                       
                }else
                {
                    
                    $farmer_id  =   $exist_mobile[0]->id;

                    /*$this->session->set_flashdata('error', 'Farmer Already Added');
                    $this->addnew();*/
                     $insertData['id']             = $farmer_id;
                }

                   
                    $insertData['name']             = $form_data['customer_name'];
                    $insertData['mobile']           = $form_data['customer_mobile'];
                    $insertData['alt_mobile']       = $form_data['customer_alter_mobile'];
                    $insertData['city_id']          = $form_data['city'];
                    $insertData['other_city']       = $form_data['other_city'];
                    $insertData['state_id']         = $form_data['state'];
                    $insertData['other_state']      = $form_data['other_state'];
                    $insertData['other_district']   = $form_data['other_district'];
                    $insertData['district_id']      = $form_data['district'];
                    $insertData['date_at']          = date("Y-m-d H:i:s");;
                    $insertData['status']           = 1;
                    $insertData['company_id']       = $company_id;
                    $insertData['created_by']       = $userid;
                    $insertData['farmer_type']      = $form_data['farmer_type'];
                    $insertData['crop_id']          = $form_data['crop_id'];
                    $result_added = $this->farmers_model->save($insertData);
                    
                    $farmer_id  = $result_added;


            }
            

            $insertData             =  array();
            $meassage = '';

            //fetch data from tables origin



            if(isset($form_data['farmser_id2']) && $form_data['farmser_id2'] !=='')
            {

                
                $where = array();
                $where['farmer_id']     = $form_data['farmser_id2'];
                $where['orderby']       = '-id';
                $exist_customer         = $this->customer_model->findDynamic($where);
                

                /*$insertData['id']        = $customer_id;
                $insertData['update_at'] = date("Y-m-d H:i:s");
                $insertData['update_by'] = $this->session->userdata('userId');

                $meassage ='Customer successfully Updated ';*/

                if(!empty($exist_customer))
                {
                     
                    $customer_id            = $exist_customer[0]->id;
                    $insertData['id']        = $customer_id;
                    $insertData['update_at'] = date("Y-m-d H:i:s");
                    $insertData['update_by'] = $this->session->userdata('userId');

                    $meassage ='Customer successfully Updated ';

                }else
                {
                     // create ad new inquiry  
                    $insertData['farmer_id']            = $farmer_id;
                    $insertData['status']               = '1';
                    $insertData['date_at']              = date("Y-m-d H:i:s");
                    $insertData['created_by']           = $this->session->userdata('userId');
                    $meassage = 'Customer successfully Added';
                }


            }else 
            {

                $where = array();
                $where['farmer_id']     = $farmer_id;
                $where['orderby']       = '-id';
                $exist_customer         = $this->customer_model->findDynamic($where);
                if(!empty($exist_customer))
                {
                    $customer_id            = $exist_customer[0]->id; 
                    $insertData['id']        = $customer_id;
                    $insertData['update_at'] = date("Y-m-d H:i:s");
                    $insertData['update_by'] = $this->session->userdata('userId');

                    $meassage ='Customer successfully Updated ';

                }else
                {
                     // create ad new inquiry  
                    $insertData['farmer_id']            = $farmer_id;
                    $insertData['status']               = '1';
                    $insertData['date_at']              = date("Y-m-d H:i:s");
                    $insertData['created_by']           = $this->session->userdata('userId');
                    $meassage = 'Customer successfully Added';
                }
            }

                $insertData['assigned_to']           = $form_data['assign_to'];
                $insertData['last_call_direction']   = $form_data['call_direction'];
                $insertData['last_call_type']        = $form_data['call_type'];
                $insertData['last_follow_date']      = date("Y-m-d H:i:s");
                $insertData['last_follower']         = $this->session->userdata('userId');
                $insertData['last_follow_call_type'] = $form_data['call_type'];
                $insertData['last_call_back_date']   = $form_data['call_back_date'];
                $insertData['current_conversation']  = $form_data['current_conversation'];
                $insertData['company_id']            = $company_id;
                $insertData['update_at']             = date("Y-m-d H:i:s");


                 $result = $this->customer_model->save($insertData);




                 if($result > 0)
                {

                    $insertData = array();
                    /**insert data for call recording**/
                    $insertData['customer']                 = $result;
                    $insertData['call_type']                = $form_data['call_type'];
                    $insertData['assign_to']                = ($form_data['assign_to']);
                    $insertData['user_id']                  = ($this->session->userdata('userId'));
                    $insertData['call_back_date']           = $form_data['call_back_date'];
                    $insertData['call_direction']           = $form_data['call_direction'];
                    $insertData['current_conversation']     = $form_data['current_conversation'];
                    $insertData['status']                   = '1';
                    $insertData['date_at']                  = date("Y-m-d H:i:s");
                    $insertData['company_id']       =   $company_id;


                    $result = $this->customer_call_model->save($insertData);
                    


                    
                    /**insert data for call recording**/





                    $this->session->set_flashdata('success', $meassage );
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Customer Addition failed');
                }

                redirect(base_url().'admin/customer/addnew');
             
          }  
        
    } 

    public function insert_call_now()
    {
        $this->isLoggedIn();
        
        
        
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('customer','customer_name','trim|required');
        $this->form_validation->set_rules('call_type','call_type','trim|required');
        $this->form_validation->set_rules('assign_to','assign_to','trim|required');
        $this->form_validation->set_rules('call_back_date','call_back_date','trim|required');
        $this->form_validation->set_rules('call_direction','call_direction','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
                
                //pre($form_data);exit;
                $insertData['customer']              = $form_data['customer'];
                $insertData['call_type']                = $form_data['call_type'];
                $insertData['assign_to']                = ($form_data['assign_to']);
                $insertData['user_id']                = ($form_data['assign_to']);
                $insertData['call_back_date']           = $form_data['call_back_date'];
                $insertData['call_direction']           = $form_data['call_direction'];
                $insertData['current_conversation']     = $form_data['current_conversation'];
                $insertData['status']                   = '1';
                $insertData['date_at']                  = date("Y-m-d H:i:s");

                 
                $result = $this->customer_call_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Call Detail successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Call Detail Addition failed');
                }
              
            redirect('admin/customer/addnew');
          }  
        
    }

    
    // Member list
    public function ajax_list()
    {
		$list = $this->customer_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn" name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
            $dateAt = date("d-m-Y H:ia", strtotime($temp_date));

            $no++;
            $row = array();
            $row[] = '<div class="btn-group">
                        <span class="badge bg-primary dropdown-toggle text-white dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                        Action<i class="mdi mdi-chevron-down"></i>
                        </span>
                        <div class="dropdown-menu" style="">
                        <a class="dropdown-item btn side_modal" data-userid="'.$currentObj->id.'"   >View</a>
                        <a class="dropdown-item text-danger deletebtn" href="#" data-userid="'.$currentObj->id.'">Delete</a>
                         
                        
                        </div>
                        </div>';

                                            /*<a  class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"  href="'.base_url().'admin/customer/edit/'.$currentObj->id.'" >
                                                                View Details
                                                            </a><a  class="btn btn-primary btn-sm btn-rounded waves-effect waves-light deletebtn  href="#" data-userid="'.$currentObj->id.'" >
                                                                Delete
                                                            </a>*/
            $row[] = $dateAt;
            
            $row[] = $currentObj->sku_id;
            $row[] = $currentObj->customer_title;
            $row[] = $currentObj->customer_mobile;
            $row[] = $currentObj->customer_alter_mobile;
            $row[] = $currentObj->state;
            $row[] = $currentObj->district;
            $row[] = $currentObj->city;
            $row[] = $currentObj->leatest_calltype;
            $row[] = $currentObj->leatest_calldir;
            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->customer_model->count_all(),
                        "recordsFiltered" => $this->customer_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Status Change
 
    public function statusChange($id = NULL)
    {
        $this->isLoggedIn();
        if($_POST['id'] == null)
        {
            redirect('admin/agency');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->customer_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();

        if($id == null)
        {
            redirect('admin/customer');
        }

        $data = array();
        
        $where = array();
        $where['status'] = '1'; 
        $where['id'] = $id; 
        $where['field'] = 'id,customer_name,customer_title,sku_id';
        $data['all_customers'] = $this->customer_model->findDynamic($where);
        
        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_users'] = $this->admin_model->findDynamic($where);


        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['states'] = $this->state_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        $data['cities'] = $this->city_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['calltypes'] = $this->call_type_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['calldirections'] = $this->call_direction_model->findDynamic($where);
        

        $data['edit_data'] = $this->customer_model->find($id);
        $this->global['pageTitle'] = 'Agency ';
        $this->loadViews("admin/customer/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->customer_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Agency*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        
       
        
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('customer_name','customer_name','trim|required');
        $this->form_validation->set_rules('customer_mobile','customer_mobile','trim|required');
        
        
         
        $this->form_validation->set_rules('assign_to','assign_to','trim|required');
        $this->form_validation->set_rules('call_back_date','call_back_date','trim|required');
        $this->form_validation->set_rules('call_direction','call_direction','trim|required');
        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($form_data['id']);
        }
        else
        {

                $insertData = array();
                $where = array();
                $where['customer_mobile'] = $form_data['customer_mobile'];

                $where['id!=']      = $form_data['id'];
 

                $exist_mobile    = $this->customer_model->findDynamic($where);
                if(empty($exist_mobile))
                {
                    //pre($form_data);exit;
                $insertData['id']                    = $form_data['id'];
                $insertData['customer_name']         = $form_data['customer_name'];
                $insertData['customer_title']        = ucfirst($form_data['customer_name']);
                $insertData['customer_mobile']       = $form_data['customer_mobile'];
                $insertData['customer_alter_mobile'] = $form_data['customer_alter_mobile'];
                $insertData['state']                 = $form_data['state'];
                $insertData['other_state']           = $form_data['other_state'];
                $insertData['district']              = $form_data['district'];
                $insertData['other_district']        = $form_data['other_district'];
                $insertData['city']                  = $form_data['city'];
                $insertData['other_city']            = $form_data['other_city'];
                $insertData['status']                = '1';
                $insertData['date_at']               = date("Y-m-d H:i:s");
                $insertData['created_by']            = $this->session->userdata('userId');
                $insertData['assigned_to']           = $form_data['assign_to'];
                $insertData['last_call_direction']   = $form_data['call_direction'];
                $insertData['last_call_type']        = $form_data['call_type'];
                $insertData['last_follow_date']      = date("Y-m-d H:i:s");
                $insertData['last_follower']         = $this->session->userdata('userId');
                $insertData['last_follow_call_type'] = $form_data['call_type'];
                $insertData['last_call_back_date']   = $form_data['call_back_date'];
                $insertData['current_conversation']  = $form_data['current_conversation'];
                $insertData['update_by']             = $this->session->userdata('userId');

               
                 
                $result = $this->customer_model->save($insertData);
                if($result > 0)
                {

                     $insertData = array();
                     $insertData['customer']                 = $result;
                    $insertData['call_type']                = $form_data['call_type'];
                    $insertData['assign_to']                = ($form_data['assign_to']);
                    $insertData['user_id']                  = $this->session->userdata('userId');
                    $insertData['call_back_date']           = $form_data['call_back_date'];
                    $insertData['call_direction']           = $form_data['call_direction'];
                    $insertData['current_conversation']     = $form_data['current_conversation'];
                    $insertData['status']                   = '1';
                    $insertData['date_at']                  = date("Y-m-d H:i:s");

              

                    $result = $this->customer_call_model->save($insertData); 
                    


                    
                    /**insert data for call recording**/





                    $this->session->set_flashdata('success', 'Customer successfully Updated');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Customer Updation  failed');
                }
                }else
                {
                         $this->session->set_flashdata('error', 'Customer With Mobile Already Added');
                }



               
              
            
          } 

          redirect(base_url().'admin/customer/edit/'.$form_data['id']); 
        
    }

    public function update_enquiry()
    {
        
        $this->isLoggedIn();
        
        
        
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('customer_name_update','Name','trim|required');
        $this->form_validation->set_rules('enquiry_id_update','ID','trim|required');
        $this->form_validation->set_rules('customer_mobile_update','MObile','trim|required');
        
        
         
         
        
        
        //form data 
        $form_data  = $this->input->post();
        

                $insertData = array();
                $insertData['id']                    = $form_data['farmser_id_update'];
                $insertData['name']                  = ucfirst($form_data['customer_name_update']);
                $insertData['alt_mobile']               = $form_data['customer_alter_mobile_update'];
                $insertData['state_id']                 = $form_data['state_update'];
                $insertData['other_state']           = $form_data['other_state_update'];
                $insertData['district_id']              = $form_data['district_update'];
                $insertData['other_district']        = $form_data['other_district_update'];
                $insertData['city_id']                  = $form_data['city_update'];
                $insertData['other_city']            = $form_data['other_city_update'];
                $insertData['update_at']             = date("Y-m-d H:i:s");
                $insertData['update_by']             = $this->session->userdata('userId');
                

               
                 
                $result = $this->farmers_model->save($insertData);

                $insertData = array();

                //pre($form_data);exit;
                $insertData['id']                    = $form_data['enquiry_id_update'];
                $insertData['customer_name']         = $form_data['customer_name_update'];
                $insertData['customer_title']        = ucfirst($form_data['customer_name_update']);
                $insertData['customer_mobile']       = $form_data['customer_mobile_update'];
                $insertData['customer_alter_mobile'] = $form_data['customer_alter_mobile_update'];
                $insertData['state']                 = $form_data['state_update'];
                $insertData['other_state']           = $form_data['other_state_update'];
                $insertData['district']              = $form_data['district_update'];
                $insertData['other_district']        = $form_data['other_district_update'];
                $insertData['city']                  = $form_data['city_update'];
                $insertData['other_city']            = $form_data['other_city_update'];
                $insertData['update_at']             = date("Y-m-d H:i:s");
                $insertData['update_by']             = $this->session->userdata('userId');
                $insertData['assigned_to']           = $form_data['assign_to_update'];
                $insertData['last_call_direction']   = $form_data['call_direction_update'];
                $insertData['last_call_type']        = $form_data['call_type_update'];
                $insertData['last_follow_date']      = date("Y-m-d H:i:s");
                $insertData['last_follower']         = $this->session->userdata('userId');
                $insertData['last_follow_call_type'] = $form_data['call_type_update'];
                $insertData['last_call_back_date']   = $form_data['call_back_date_update'];
                $insertData['current_conversation'] = $form_data['current_conversation_update'];

               
                 
                $result = $this->customer_model->save($insertData);

                if($result)
                {

                        $insertData = array();
                        $where = array();
                        $where['customer'] = $result;
                        $where['orderby'] = '-id';
                        $customer_call = $this->customer_call_model->findDynamic($where);
                        if(!empty( $customer_call))
                        {

                            $customer_call_id = $customer_call[0]->id;
                            $insertData = array();
                            /**insert data for call recording**/
                            $insertData['id']                       = $customer_call_id;
                            $insertData['customer']                 = $result;
                            $insertData['call_type']                = $form_data['call_type_update'];
                            $insertData['assign_to']                = ($form_data['assign_to_update']);
                            $insertData['user_id']                  = $this->session->userdata('userId');
                            $insertData['call_back_date']           = $form_data['call_back_date_update'];
                            $insertData['call_direction']           = $form_data['call_direction_update'];
                            $insertData['current_conversation']     = $form_data['current_conversation_update'];
                            $insertData['status']                   = '1';
                            $insertData['date_at']                  = date("Y-m-d H:i:s");


                            $result = $this->customer_call_model->save($insertData);       
                        }
                     
                }
                 $response_result = array(
                 
                'status'=>0,
                'message'=>''
                    );

                    if($result)
                    {
                        $response_result = array(
                            'status'=>1,
                            'message'=>'Update Changes Successfully !'
                        );
                    }else
                    {
                        $response_result = array(
                            'status'=>0,
                            'message'=>'Failed Update Changes!'
                        );
                    }

                    echo json_encode($response_result);
                    
         

         
    }

    public function customer_call_detail()
    {
         $result = array();
         $form_data  = $this->input->post('id');
         $id = $form_data;
        if(empty($id))
        {
            $result = array();
        }else
        {
            /*start data*/
            $this->db->select('cc.*,user.title as assigned,created.title as user_createdby, call.title as calltype, direction.title as calldirection');
            $this->db->from('z_customer_call as cc');
            $this->db->where('cc.customer', $id);
            $this->db->join('z_admin as user', 'user.id = cc.assign_to', 'left');
            $this->db->join('z_admin as created', 'created.id = cc.user_id', 'left');
            $this->db->join('z_call_type as call', 'call.id = cc.call_type', 'left');
            $this->db->join('z_call_direction as direction', 'direction.id = cc.call_direction', 'left');
            $this->db->order_by("cc.id", "desc");
            $query = $this->db->get(); 
            $result_array = $query->result_array();        
            if(!empty($result_array ))
            {
                foreach ($result_array  as $value) 
                {
                    $call_detail = array();
                    $call_detail['date_at'] = date('d F Y, h:i:s A',strtotime($value['date_at']));
                    $call_detail['call_back_date'] = (($value['call_back_date']=='0000-00-00' || $value['call_back_date'] == null)?'':date('d M Y',strtotime($value['call_back_date'])));
                    $call_detail['calltype'] =  $value['calltype'];
                    $call_detail['assigned'] =  $value['assigned'];
                    $call_detail['user_createdby'] =  $value['user_createdby'];
                    $call_detail['calldirection'] =  $value['calldirection'];
                    $call_detail['current_conversation'] =  $value['current_conversation'];
                    $result[] = $call_detail;
                }
                
             } 

        }
        $result = json_encode($result);
        echo  $result;
        


    }
    public function get_all_state()
    {
         $where = array();
        $where['status'] = '1';
        $where['country_id'] = 105;
        $where['orderby'] = 'name';
        
        $states = $this->state_model->findDynamic($where);
        $html_content = '';
        if(!empty($states))
        {
            foreach ($states as $state ) {
                $selected = '';
                 
                $html_content.= '<option value="'.$state->id .'" '.$selected.'>'.$state->name .'</option>';
            }    
        }
        echo $html_content;
    }
    public function get_all_district()
    {
         $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        
        $districts = $this->district_model->findDynamic($where);
        $html_content = '';
        if(!empty($districts))
        {
            foreach ($districts as $district ) {
                $selected = '';
                 
                $html_content.= '<option value="'.$district->id .'" '.$selected.'>'.$district->name .'</option>';
            }    
        }
        echo $html_content;
    } 
    public function get_all_city()
    {
         $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        
        $cities = $this->city_model->findDynamic($where);
        $html_content = '';
        if(!empty($cities))
        {
            foreach ($cities as $city ) {
                $selected = '';
                 
                $html_content.= '<option value="'.$city->id .'" '.$selected.'>'.$city->name .'</option>';
            }    
        }
        echo $html_content;
    }
    public function state_change($state_id='',$selectedDistrict='')
    {
          
        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        if(!empty($state_id))
        {
            $where['state_id'] = $state_id;
        }
        $districts = $this->district_model->findDynamic($where);
        $html_content = '<option value="">Choose District</option>';
        if(!empty($districts))
        {
            foreach ($districts as $district ) {
                $selected = '';
                if(isset($selectedDistrict) && $selectedDistrict ==$district->id)
                {
                    $selected = 'selected';
                }
                $html_content.= '<option value="'.$district->id .'" '.$selected.'>'.$district->name .'</option>';
            }    
        }
        echo $html_content;
        
    } 
    public function country_change($country_id='',$selectedState='')
    {
          
        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        if(!empty($country_id))
        {
            $where['country_id'] = $country_id;
        }
        $states = $this->state_model->findDynamic($where);
        $html_content = '<option value="">Choose State</option>';
        if(!empty($states))
        {
            foreach ($states as $state ) {
                $selected = '';
                if(isset($selectedState) && $selectedState ==$state->id)
                {
                    $selected = 'selected';
                }
                $html_content.= '<option value="'.$state->id .'" '.$selected.'>'.$state->name .'</option>';
            }    
        }
        echo $html_content;
        
    } 
    public function district_change($district_id='',$selected_city='')
    {
          
        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        if(!empty($district_id))
        {
             $where['district_id'] = $district_id;
        }
        $cities = $this->city_model->findDynamic($where);
        $html_content = '<option value="">Choose Tehsil</option>';
        if(!empty($cities))
        {
            foreach ($cities as $city ) {
                $selected = '';
                if(isset($selected_city) && $selected_city ==$city->id)
                {
                    $selected = 'selected';
                }
                $html_content.= '<option value="'.$city->id .'" '.$selected.'>'.$city->city .'</option>';
            }    
        }
        echo $html_content;
        
    }

    public function single($id='')
    {
        $this->isLoggedIn();
        $customer_id    = $this->input->get('customer_id');
        $mobile         = $this->input->get('mobile');

        $single_arr  = array();
        if(isset($customer_id) || isset($mobile))
        {
            $where = array();
            $where['status'] = '1'; 
            if($customer_id !=='')
            {
                $where['id'] = $customer_id; 
            }

            if($mobile !=='')
            {
                $where['customer_mobile'] = $mobile; 
            }

             $result = $this->customer_model->findDynamic($where);
             if(!empty( $result))
             {
              $single_arr= $result[0];  
             }
                      
        }else
        {
             $single_arr = $this->customer_model->find($id);
        }
        echo  json_encode($single_arr);
    }
    public function export()
    {

         $this->isLoggedIn();

            $call_type      = @$this->input->post('call_type'); 
            $assigned_to    = @$this->input->post('assigned_to'); 
            $from_date      = @$this->input->post('from_date'); 
            $to_date        = @$this->input->post('to_date');
            $where_search   = array(); 
            $conditions     = array(); 
            if(!empty($call_type))
            {
                $where_search['last_call_type'] =  $call_type;
            }
            if(!empty($from_date))
            {
                $where_search['exp_from_date']      =  $from_date;
            } 
            if(!empty($to_date))
            {
                $where_search['exp_to_date']        =  $to_date;
            } 
            if(!empty($assigned_to))
            {
                $where_search['assigned_to']        =  $assigned_to;
                  
            }

          /*  if(!empty($assigned_to))
            {
                $conditions['uid']           = $assigned_to; 
            }
 */
                 $conditions = array( 
                
                'where' => $where_search
                 
                ); 
 


            $resultfound = $this->customer_model->getRows($conditions);
            
            $content = "Call Date,Customer Id,Customer name,Mobile,District,State,Call Direction,Call Type,Followup date,Emp Name,Assigned to,Assigned by,Comment,Customer Reg Date,Call Count,Entry made by,Entry Date,Entry Update Date,Last Follower,Last Call Type \n";
             
            if(!empty($resultfound))
            {
                foreach ($resultfound as $key => $value) 
                {
                    $farmer_details = $this->farmers_model->find($value['farmer_id']);
                    $where = array();
                    $where['customer'] = $value['id'];
                    $where['field'] ='id';

                    $count_call  = $this->customer_call_model->findDynamic($where);
                    $count_call = count($count_call);

                       $current_conversation =trim($value['current_conversation']);
                    $current_conversation =str_replace("\n", " ", $current_conversation);
                    $current_conversation =str_replace("\r", " ", $current_conversation);

                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['date_at']))).",";
                    $content.= str_replace(",", " ", $value['farmer_id']).",";
                    $content.= str_replace(",", " ", $value['farmername']).",";
                    $content.= str_replace(",", " ", $value['farmermobile']).",";
                    $content.= str_replace(",", " ", $value['district']).",";
                    $content.= str_replace(",", " ", $value['state']).",";
                    $content.= str_replace(",", " ", $value['calldir']).",";
                    $content.= str_replace(",", " ", $value['calltype']).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['last_follow_date']))).",";
                    
                    $content.= str_replace(",", " ", $value['createdby']).",";
                    $content.= str_replace(",", " ", $value['assignedto']).",";
                    $content.= str_replace(",", " ", $value['createdby']).",";
                    $content.= str_replace(",", " ", $current_conversation).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime(@$farmer_details->date_at))).",";
                    $content.= str_replace(",", " ", $count_call).",";
                    $content.= str_replace(",", " ", $value['createdby']).",";
                    
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['date_at']))).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['update_at']))).",";
                    $content.= str_replace(",", " ", $value['lastfollower']).",";
                    $content.= str_replace(",", " ", $value['lastcalltype']).",";
 
                           $content.="\n";
                }
            }            
                    
        $filename = 'enquiry-export-'.date('d-m-Y-h-s').'.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        print_r($content);
        die; 
    }

    public function export_stat()
    {

            $this->isLoggedIn();

            $uid                = @$this->input->get('uid'); 
            $stat_type          = @$this->input->get('stat_type'); 
            $followup_type      = @$this->input->get('followup_type'); 

            $form_type  = $this->input->get('form_type');
            $conditions = array(); 
            $where_search = array();

        if($form_type=='inquiry')
        {
                $where_search =  array();
                $search_customer_id  = @$this->input->get('search_customer_id');
                $search_name         = @$this->input->get('search_name');
                $search_mobile       = @$this->input->get('search_mobile');
                $search_alt_mobile   = @$this->input->get('search_alt_mobile');
                $state2              = @$this->input->get('state2');
                $other_state2        = @$this->input->get('other_state2');
                $district2           = @$this->input->get('district2');
                $other_district2     = @$this->input->get('other_district2');
                $city2               = @$this->input->get('city2');
                $other_city2         = @$this->input->get('other_city2');
                $call_direction2     = @$this->input->get('call_direction2');
                $call_type2          = @$this->input->get('call_type2'); 
                $farmer_type2        = @$this->input->get('farmer_type2'); 
                $crop_id2            = @$this->input->get('crop_id2'); 
                $stat_type           = @$this->input->get('stat_type'); 
                $followup_type       = @$this->input->get('followup_type'); 
                if(!empty($search_customer_id))
                {
                    $where_search['farmer_id'] =  $search_customer_id;
                }
                 if(!empty($stat_type))
                {
                    $where_search['stat_type'] =  $stat_type;
                }
                 if(!empty($search_name))
                {
                    $where_search['customer_title'] =  $search_name;
                } 
                
                if(!empty($search_mobile))
                {
                    $where_search['customer_mobile'] =  $search_mobile;
                }
                if(!empty($search_alt_mobile))
                {
                    $where_search['customer_alter_mobile'] =  $search_alt_mobile;
                }
                if(!empty($state2))
                {
                    $where_search['state'] =  $state2;
                }
                if(!empty($other_state2))
                {
                    $where_search['other_state'] =  $other_state2;
                }
                
                if(!empty($district2))
                {
                    $where_search['district'] =  $district2;
                }if(!empty($other_district2))
                {
                    $where_search['other_district'] =  $other_district2;
                }
                if(!empty($city2))
                {
                    $where_search['city'] =  $city2;
                } 
                if(!empty($other_city2))
                {
                    $where_search['other_city'] =  $other_city2;
                }
                if(!empty($call_direction2))
                {
                    $where_search['last_call_direction'] =  $call_direction2;
                } 
                if(!empty($call_type2))
                {
                    $where_search['last_call_type'] =  $call_type2;
                }
                if(!empty($farmer_type2))
                {
                    $where_search['farmer_type'] =  $farmer_type2;
                }
                if(!empty($crop_id2))
                {
                    $where_search['crop_id'] =  $crop_id2;
                }

                if(!empty($uid))
            {
                $conditions['uid']           = $uid; 
            }

        }

             if(!empty($stat_type))
                {
                    $where_search['stat_type'] =  $stat_type;
                }

            
 
            if(!empty($followup_type))
            {
                $conditions['followup_type']           = $followup_type; 
            } 
            

            $conditions['where']       = $where_search;  
             
            
 

 


            $resultfound = $this->customer_model->getRows($conditions);

            $content = "Call Date,Customer Id,Customer name,Mobile,District,State,Farmer Type,Call Direction,Call Type,Followup date,Emp Name,Assigned to,Assigned by,Comment,Customer Reg Date,Call Count,Entry made by,Entry Date,Entry Update Date,Last Follower,Last Call Type \n";
             
            if(!empty($resultfound))
            {
                foreach ($resultfound as $key => $value) 
                {
                    $farmer_details = $this->farmers_model->find($value['farmer_id']);
                    $where = array();
                    $where['customer'] = $value['id'];
                    $where['field'] ='id';

                    $count_call  = $this->customer_call_model->findDynamic($where);
                    $count_call = count($count_call);

                       $current_conversation =trim($value['current_conversation']);
                    $current_conversation =str_replace("\n", " ", $current_conversation);
                    $current_conversation =str_replace("\r", " ", $current_conversation);

                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['date_at']))).",";
                    $content.= str_replace(",", " ", $value['farmer_id']).",";
                    $content.= str_replace(",", " ", $value['farmername']).",";
                    $content.= str_replace(",", " ", $value['farmermobile']).",";
                    $content.= str_replace(",", " ", $value['district']).",";
                    $content.= str_replace(",", " ", $value['state']).",";
                    $content.= str_replace(",", " ", $value['farmertype']).",";
                    $content.= str_replace(",", " ", $value['cropname']).",";
                    $content.= str_replace(",", " ", $value['calldir']).",";
                    $content.= str_replace(",", " ", $value['calltype']).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['last_call_back_date']))).",";
                    
                    $content.= str_replace(",", " ", $value['createdby']).",";
                    $content.= str_replace(",", " ", $value['assignedto']).",";
                    $content.= str_replace(",", " ", $value['createdby']).",";
                    $content.= str_replace(",", " ", $current_conversation).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime(@$farmer_details->date_at))).",";
                    $content.= str_replace(",", " ", $count_call).",";
                    $content.= str_replace(",", " ", $value['createdby']).",";
                    
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['date_at']))).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['update_at']))).",";
                    $content.= str_replace(",", " ", $value['lastfollower']).",";
                    $content.= str_replace(",", " ", $value['lastcalltype']).",";
 
                           $content.="\n";
                }
            }            
                    
        $filename = 'enquiry-export-'.date('d-m-Y-h-s').'.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        print_r($content);
        die; 
    }
    
}

?>