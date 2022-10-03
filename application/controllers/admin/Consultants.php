<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Consultants extends BaseController
{


   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/consultant_model');
        $this->load->model('admin/company_model');
        
        $this->load->model('admin/agent_model');
        $this->load->model('admin/customer_model');
        $this->load->model('admin/farmers_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/admin_model');
        $this->load->model('admin/consultant_ticket_status_model');
        $this->load->model('admin/consultant_call_type_model');
        $this->load->model('admin/document_category_model');
        $this->load->model('admin/document_model');
        $this->load->model('admin/crop_model');

        $this->perPage =200; 



    }

    


    public function index()
    {


        $this->isLoggedIn();
         $this->global['module_id']      = get_module_byurl('admin/consultants');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

          $data = array();

            $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid   = $uid;
            }else
            {
                $userid = $this->session->userdata('userId');
            }

            
            
 
            $conditions = array(); 
            $where_search = array();

            $data['edit_data'] = array();
            $data['customer_call_dtl'] = array();

            $form_type  = $this->input->get('form_type');
            
                
        

                $where_search           =  array();
                $search_farmer_id       = @$this->input->get('farmer_id');
                $farmer_name            = @$this->input->get('farmer_name');
                $farmer_mobile          = @$this->input->get('farmer_mobile');
                $ticket_id              = @$this->input->get('ticket_id');
                $assigned_to            = @$this->input->get('assigned_to'); 
                $call_type              = @$this->input->get('call_type'); 
                $document_category_id   = @$this->input->get('document_category_id');
                $tickets_status         = @$this->input->get('tickets_status');
                $ticket_status2         = @$this->input->get('ticket_status2');
                $follow_up_date         = @$this->input->get('follow_up_date');

 
                if(!empty($search_farmer_id))
                {
                    $where_search['farmer_id'] =  $search_farmer_id;
                } 
                if(!empty($farmer_name))
                {
                    $where_search['farmer_name'] =  $farmer_name;
                } 
                if(!empty($farmer_mobile))
                {
                    $where_search['farmer_mobile'] =  $farmer_mobile;
                } 
                if(!empty($ticket_id))
                {
                    $where_search['id'] =  $ticket_id;
                }
                if(!empty($assigned_to))
                {
                    $where_search['assigned_to'] =  $assigned_to;
                } 
                if(!empty($call_type))
                {
                    $where_search['call_type'] =  $call_type;
                } 
                if(!empty($document_category_id))
                {
                    $where_search['document_category_id'] =  $document_category_id;
                } 
                if(!empty($tickets_status))
                {
                    $where_search['ticket_status'] =  $tickets_status;
                }
                if(!empty($tickets_status))
                {
                    $where_search['ticket_status'] =  $tickets_status;
                } 
                if(!empty($ticket_status2))
                {
                    $where_search['ticket_status'] =  $ticket_status2;
                } 
                if(!empty($follow_up_date))
                {
                    $where_search['follow_up_date'] =  $follow_up_date;


                } 

                
                 
                    

            $conditions['returnType'] = 'count'; 
            $conditions['userid'] = $userid; 
            $conditions['form_type'] = $form_type; 
            $conditions['where'] = $where_search; 
            $totalRec = $this->consultant_model->getRows($conditions);


            $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 4; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/consultants/index'; 
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
                'userid' =>  $userid, 
                'form_type' => $form_type, 
                'limit' => $this->perPage 
                ); 
                
                $data['consultants']   = $this->consultant_model->getRows($conditions); 
                $data['pagination'] = $this->pagination->create_links(); 
                $data['pagination_total_count'] =  $totalRec;
                
                $form_type  = $this->input->get('form_type');
         if($form_type =='search')
         {
            $customer_id    = $this->input->get('customer_id');
            $mobile         = $this->input->get('mobile');

            

            if($customer_id !=='' || $mobile !=='')
            {   
                $isserch = false;
                $where = array();
                if(!empty($customer_id))
                {   
                    $isserch = true;

                     $where['sku_id'] = $customer_id;
                }

                if(!empty($mobile))
                {
                    $isserch = true;
                     $where['customer_mobile'] = $mobile;
                }

                if($isserch)
                {

                    $customer = $this->customer_model->findDynamic($where);
                    if(!empty($customer))
                    {
                        $data['edit_data'] = $customer[0];


                        $where = array();
                        $where['customer'] = $data['edit_data']->id;
                         
                    }
                    


                     
                }



                
                 
                 
                
            }

         }
         


 
        
        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_users'] = $this->admin_model->findDynamic($where);

       
 

        

        $where = array();
        $where['status']        = '1';
        $where['orderby']       = 'id';
        $data['calltypes']      = $this->consultant_call_type_model->findDynamic($where);

        $where = array();
        $where['status']        = '1';
        $where['orderby']       = 'id';
        $data['documents_category']      = $this->document_category_model->findDynamic($where);
        
        $where = array();
        $where['status'] = '1';
        $where['admin_type'] = '2';
        $where['orderby'] = 'title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);
       
         $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['tickets_status'] = $this->consultant_ticket_status_model->findDynamic($where);

         
 


        $filter_bookings_status =  array();
        $result_bookings_status =  array();
        if(!empty($data['bookings_status']))
        {
            $bookingwhere  = array();
            $bookingwhere['title']  = 'all';

            $count_booking =  $this->consultant_model->get_booking_data($bookingwhere,$userid); 
            $filter_bookings_status = array();
            $filter_bookings_status['title'] = 'All' ;
            $filter_bookings_status['slug'] = 'all';
            $filter_bookings_status['count_booking'] = count($count_booking) ;
            $result_bookings_status[] = $filter_bookings_status;


            foreach ($data['bookings_status'] as $bookingstatus)
            {
                $bookingwhere  = array(); 
                $bookingwhere['title']  = $bookingstatus->slug;
                $count_booking =  $this->consultant_model->get_booking_data($bookingwhere,$userid); 

                $filter_bookings_status = array();
                $filter_bookings_status['title'] = $bookingstatus->title ;
                $filter_bookings_status['slug'] = $bookingstatus->slug ;
                $filter_bookings_status['count_booking'] = count($count_booking) ;
                $result_bookings_status[] = $filter_bookings_status;
            }
        }

        $data['filter_bookings_status'] = $result_bookings_status;

 

        

          
        

        
        $this->global['pageTitle'] = 'Consultants';
        $this->loadViews("admin/consultants/list", $this->global, $data , NULL);
        
    }

    // Add New 

    public function create()
    {
    
            $this->isLoggedIn();

              $this->global['module_id']      = get_module_byurl('admin/consultants');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->create !=='create')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

            $data = array();
            $userid = $this->session->userdata('userId');
            $company_id = $this->session->userdata('company_id');

            $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,customer_name,customer_title,sku_id';
        $data['all_customers'] = $this->customer_model->findDynamic($where);
        
        
          $where = array(); 
        $where['status'] = '1'; 
        $crop_list = $this->crop_model->findDynamic($where);
        $data['crop_lists'] =  $crop_list;


        $where = array();
        $where['status']        = '1';
        $where['orderby']       = 'id';
        $data['calltypes']      = $this->consultant_call_type_model->findDynamic($where);
        
        $where = array();
        $where['status'] = '1';
        $where['admin_type'] = '2';
        $where['orderby'] = 'title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);
       
         $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['tickets_status'] = $this->consultant_ticket_status_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['documents_category'] = $this->document_category_model->findDynamic($where);

 

       /* $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['all_agents'] = $this->admin_model->findDynamic($where); */



          
         
        $data['company_data'] = $this->company_model->find($company_id);
        
        $this->global['pageTitle'] = 'Add New Consultation';
        $this->loadViews("admin/consultants/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('farmer_id','Farmer Id','trim|required');
        $this->form_validation->set_rules('farmer_name','Farmer name','trim|required');
        /*$this->form_validation->set_rules('address','Address','trim|required');*/
        $this->form_validation->set_rules('document_category_id','Problem','trim|required');
        $this->form_validation->set_rules('document_id','Sub Problem','trim|required');
        $this->form_validation->set_rules('root_cause','Root Cause','trim');
        $this->form_validation->set_rules('recommendation','Recommendation','trim');
        
         $company_id = $this->session->userdata('company_id');
        
        //form data 
        
        if($this->form_validation->run() == FALSE)
        {
            $this->create();
        }
        else
        {
            $form_data  = $this->input->post();


             $get_farmerid = $form_data['farmer_id'];
                





                //$get_customerid

                            $insertData = array();
                            $all_images  = array();
 
                            if(!empty($_FILES['upload_files']))
                            {
                                 

                                  $total_images = count($_FILES['upload_files']);
                                for ($i=0; $i < $total_images; $i++) {

                                   if(isset($_FILES['upload_files']['name'][$i]) && $_FILES['upload_files']['error'][$i] ==0)
                                  {
                                         $f_name         =$_FILES['upload_files']['name'][$i];
                                        $f_tmp          =$_FILES['upload_files']['tmp_name'][$i];
                                        $f_size         =$_FILES['upload_files']['size'][$i];
                                        $f_extension    =explode('.',$f_name);
                                        $f_extension    =strtolower(end($f_extension));
                                        $f_newfile      =uniqid().'.'.$f_extension;
                                        $store          ="uploads/admin/document/images/".$f_newfile;
                                         
                                        if(!move_uploaded_file($f_tmp,$store))
                                        {
                                            $this->session->set_flashdata('error', 'Images Upload Failed .');
                                        }
                                        else
                                        {
                                           $all_images[] = $f_newfile;
                                           
                                        }
                                     }
                                }

                                 
                                    
                            }
                            $insertData['images'] = json_encode($all_images);

                             if(isset($_FILES['screenshot']['name']) && $_FILES['screenshot']['size'] !=='')
                            {
                                 
                                 

                                   if(isset($_FILES['screenshot']['name']) && $_FILES['screenshot']['name'] != '')
                                  {

                                        $f_name         =$_FILES['screenshot']['name'];
                                        $f_tmp          =$_FILES['screenshot']['tmp_name'];
                                        $f_size         =$_FILES['screenshot']['size'];
                                        $f_extension    =explode('.',$f_name);
                                        $f_extension    =strtolower(end($f_extension));
                                        $f_newfile      =uniqid().'.'.$f_extension;
                                        $store          ="uploads/admin/document/screenshot/".$f_newfile;
                                    
                                        if(!move_uploaded_file($f_tmp,$store))
                                        {
                                            $this->session->set_flashdata('error', 'Screenshot Upload Failed .');
                                        }
                                        else
                                        {
                                           $insertData['screenshot'] = $f_newfile ;
                                           
                                        }
                                     }
                                
                                    
                            }
                            


                            

                        $form_data['ticket_title']  = strtolower($form_data['ticket_title']);
                        $form_data['ticket_title']  = ucwords($form_data['ticket_title']);

                        $form_data['farmer_name']  = strtolower($form_data['farmer_name']);
                        $form_data['farmer_name']  = ucwords($form_data['farmer_name']);
                             
                           

                            $insertData['farmer_id']                    = $get_farmerid;
                            $insertData['farmer_name']                  = $form_data['farmer_name'];
                            $insertData['farmer_mobile']                = $form_data['farmer_mobile'];
                            $insertData['address']                      = $form_data['address'];
                            $insertData['crop_id']                      = $form_data['crop_id'];
                            $insertData['crop_status']                  = 1;
                            $insertData['crop_area']                    = $form_data['crop_area'];
                            $insertData['ticket_title']                 = $form_data['ticket_title'];
                            $insertData['ticket_status']                = $form_data['ticket_status'];
                            $insertData['call_type']                    = $form_data['call_type'];
                            $insertData['follow_up_date']               = $form_data['follow_up_date'];
                            $insertData['document_category_id']        = $form_data['document_category_id'];
                            $insertData['document_id']                 = $form_data['document_id'];
                            $insertData['root_cause']                   =  ($form_data['root_cause']);
                            $insertData['recommendation']               =  ($form_data['recommendation']);
                            $insertData['company_id']                   = $company_id;
                            $insertData['created_by']                   = $this->session->userdata('userId');
                            $insertData['assigned_to']                  = $this->session->userdata('userId');;
                            $insertData['date_at']                      = date("Y-m-d H:i:s");

                            $result_insert  = $this->consultant_model->save($insertData);
                                



                         

 
                if(!empty($result_insert))
                {
                 $this->session->set_flashdata('success', 'Consultant successfully Added');

                    
                }else
                {
                     $this->session->set_flashdata('error', 'Consultant  Addition failed!');
                }

                    redirect(base_url().'admin/consultants');
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
         $this->global['module_id']      = get_module_byurl('admin/consultants');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->edit !=='edit')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $data = array();
        $userid = $this->session->userdata('userId');
        $company_id = $this->session->userdata('company_id');





        $data['edit_data'] = array();

        

         $where = array(); 
        $where['status'] = '1'; 
        $crop_list = $this->crop_model->findDynamic($where);
        $data['crop_lists'] =  $crop_list;

        

        $where = array();
        $where['status']        = '1';
        $where['orderby']       = 'id';
        $data['calltypes']      = $this->consultant_call_type_model->findDynamic($where);

         $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['tickets_status'] = $this->consultant_ticket_status_model->findDynamic($where);

        $where = array();
        $where['status']        = '1';
        $where['orderby']       = 'id';
        $data['documents_category']      = $this->document_category_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['admin_type'] = '2';
        $where['orderby'] = 'title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);


         $data['edit_data'] = $this->consultant_model->find($id);
         if(empty($data['edit_data']))
         {
            redirect(base_url()."admin/consultants");
            $this->session->set_flashdata('error', 'Record not found !');

         }

            $where = array();
            $where['status']            = '1';
            $where['orderby']           = 'id';
            $where['document_cat_id']   = $data['edit_data']->document_category_id;
            $data['documents']          = $this->document_model->findDynamic($where);
             



                 $data['company_data'] = $this->company_model->find($company_id);
 
          
          


        $this->global['pageTitle'] = 'Edit Consultant';
         
        $this->loadViews("admin/consultants/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->consultant_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Agency*************************************************************
    public function update()
    {
		

         $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('farmer_id','Farmer Id','trim|required');
        $this->form_validation->set_rules('farmer_name','Farmer name','trim|required');
        /*$this->form_validation->set_rules('address','Address','trim|required');*/
        $this->form_validation->set_rules('document_category_id','Problem','trim|required');
        $this->form_validation->set_rules('document_id','Sub Problem','trim|required');
        $this->form_validation->set_rules('root_cause','Root Cause','trim');
        $this->form_validation->set_rules('recommendation','Recommendation','trim');


         $form_data  = $this->input->post();
        
        
        //form data 
        
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($form_data['id']);
        }
        else
        {

             $company_id = $this->session->userdata('company_id');
            $form_data  = $this->input->post();

                
            $get_farmerid = $form_data['farmer_id'];
                 
            

                            $insertData = array();
                            $all_images =  array();

                            if(!empty($form_data['exist_file']))
                            {
                                $exist_image_file =  $form_data['exist_file'] ;
                                $exist_images = count($exist_image_file);
                                for ($jj=0; $jj < $exist_images; $jj++) { 
                                   $all_images[] = $exist_image_file[$jj];
                                }
                            }
                             
                             if(!empty($_FILES['upload_files']))
                            {
                                 

                                  $total_images = count($_FILES['upload_files']);
                                for ($i=0; $i < $total_images; $i++) {

                                   if(isset($_FILES['upload_files']['name'][$i]) && $_FILES['upload_files']['error'][$i] ==0)
                                  {
                                     
                                        $f_name         =$_FILES['upload_files']['name'][$i];
                                        $f_tmp          =$_FILES['upload_files']['tmp_name'][$i];
                                        $f_size         =$_FILES['upload_files']['size'][$i];
                                        $f_extension    =explode('.',$f_name);
                                        $f_extension    =strtolower(end($f_extension));
                                        $f_newfile      =uniqid().'.'.$f_extension;
                                        $store          ="uploads/admin/document/images/".$f_newfile;
                                   
                                        if(!move_uploaded_file($f_tmp,$store))
                                        {
                                            $this->session->set_flashdata('error', 'Images Upload Failed .');
                                        }
                                        else
                                        {
                                           $all_images[] = $f_newfile;
                                           
                                        }
                                     }
                                }

                                 
                                 
                                    
                            }

                            $insertData['images'] = json_encode($all_images);
                               if(isset($_FILES['screenshot']['name']) && $_FILES['screenshot']['error'] ==0)
                            {
                                 
                                  
                                        $f_name         =$_FILES['screenshot']['name'];
                                        $f_tmp          =$_FILES['screenshot']['tmp_name'];
                                        $f_size         =$_FILES['screenshot']['size'];
                                        $f_extension    =explode('.',$f_name);
                                        $f_extension    =strtolower(end($f_extension));
                                        $f_newfile      =uniqid().'.'.$f_extension;
                                        $store          ="uploads/admin/document/screenshot/".$f_newfile;
                                    
                                        if(!move_uploaded_file($f_tmp,$store))
                                        {
                                            $this->session->set_flashdata('error', 'Screenshot Upload Failed .');
                                        }
                                        else
                                        {
                                           $insertData['screenshot'] = $f_newfile ;
                                           
                                        }
                                      
                                
                                    
                            }else
                            {
                                 $insertData['screenshot'] = $form_data['screenshot_exist_file'];
                            }

 
                            $form_data['ticket_title']  = strtolower($form_data['ticket_title']);
                            $form_data['ticket_title']  = ucwords($form_data['ticket_title']);

                            $form_data['farmer_name']  = strtolower($form_data['farmer_name']);
                            $form_data['farmer_name']  = ucwords($form_data['farmer_name']);
                             
                           

                            $insertData['farmer_id']                    = $get_farmerid;
                            $insertData['id']                  = $form_data['id'];
                            $insertData['farmer_name']                  = $form_data['farmer_name'];
                            $insertData['farmer_mobile']                = $form_data['farmer_mobile'];
                            $insertData['address']                      = $form_data['address'];
                            $insertData['crop_id']                      = $form_data['crop_id'];
                            $insertData['crop_status']                  = 1;
                            $insertData['crop_area']                    = $form_data['crop_area'];
                            $insertData['ticket_title']                 = $form_data['ticket_title'];
                            $insertData['ticket_status']                = $form_data['ticket_status'];
                            $insertData['call_type']                    = $form_data['call_type'];
                            $insertData['follow_up_date']               = $form_data['follow_up_date'];
                            $insertData['document_category_id']        = $form_data['document_category_id'];
                            $insertData['document_id']                 = $form_data['document_id'];
                            $insertData['root_cause']                   = ($form_data['root_cause']);
                            $insertData['recommendation']               = ($form_data['recommendation']);
                            $insertData['company_id']                   = $company_id;
                            $insertData['updated_by']                   = $this->session->userdata('userId');
                            $insertData['update_at']                      = date("Y-m-d H:i:s");

                            $result_insert  = $this->consultant_model->save($insertData);



  
 
                if(!empty($result_insert))
                {
                     $this->session->set_flashdata('success', 'Consultants successfully Update');

                    
                }else
                {
                     $this->session->set_flashdata('error', 'You Have No Make Any Changes!');
                }

                    
          }  

          redirect(base_url().'admin/consultants');
      }

    public function customer_call_detail()
    {
         $form_data  = $this->input->post('id');
         $id = $form_data;
        if(empty($id))
        {
            $result = array();
        }else
        {
            /*start data*/
            $this->db->select('cc.*,user.title as username, call.title as calltype, direction.title as calldirection');
            $this->db->from('z_customer_call as cc');
            $this->db->where('cc.customer', $id);
            $this->db->join('z_admin as user', 'user.id = cc.assign_to', 'left');
            $this->db->join('z_call_type as call', 'call.id = cc.call_type', 'left');
            $this->db->join('z_call_direction as direction', 'direction.id = cc.call_direction', 'left');
            $this->db->order_by("cc.id", "desc");
            $query = $this->db->get(); 
            $result = $query->result_array();        

        /*end  data*/

        }
        $result = json_encode($result);
        echo  $result;
        


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

    public function change_booking_status($id)
    {

        
        $this->isLoggedIn();
        $update_booking_status  = $this->input->post('update_booking_status');
        $insertData                 = array();
        $insertData['id']           = $id;
        $insertData['booking_status']= $update_booking_status;
        $result = $this->consultant_model->save($insertData);

        $single_arr     = $this->consultant_model->find($id);
        $logged         = $this->booking_log_model->booking_log($single_arr);

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

    public function delete_payment($id)
    {

        
        $this->isLoggedIn();
        $update_booking_status  = $this->input->post('update_booking_status');
        $insertData                     = array();
        $insertData['id']               = $id;
        $insertData['status']           = 0;
        $result                 = $this->booking_payments_model->save($insertData);
  
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Deleted Payment Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed Deleted Payment !'
            );
        }

        echo json_encode($response_result);


         
    }

    public function add_payment($id)
    {

        
        $this->isLoggedIn();
         $form_data  = $this->input->post();

        $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['booking_id']       = $id;
        $insertData['payment_type']     = 'payment';
        $insertData['payment_mode']     = $form_data['payment_mode'];
        $insertData['bank_transaction_id']= $form_data['payment_bank_transaction_id'];
        $insertData['amount']           = $form_data['payment_amount'];
        $insertData['status']           = 1;
        $insertData['date_at']          = date("Y-m-d H:i:s");
        $insertData['created_by']       = $this->session->userdata('userId');
        $insertData['customer_id']      = $form_data['custID'];
        $insertData['cheque_no']        = $form_data['cheque_no'];
        $insertData['bank_name']        = $form_data['bank_name'];
        $insertData['bank_branch']      = $form_data['bank_branch'];


        //booking data fetch
        $single_arr         = $this->consultant_model->find($id);
        $balance            =  $single_arr->total;
        $total_paid_amount  = $single_arr->total_paid_amount + $form_data['payment_amount'];
        $outstanding_amount = ($balance-$total_paid_amount);

         
        $result = $this->booking_payments_model->save($insertData);

        $insertData                         = array();
        $insertData['total_paid_amount']    = $total_paid_amount;
        $insertData['outstanding_amount']   = $outstanding_amount;
        $insertData['id']                   = $id;  
        $price_updated                      = $this->consultant_model->save($insertData);

        //get and update to log
        $single_arr     = $this->consultant_model->find($id);
        $logged         = $this->booking_log_model->booking_log($single_arr);
        //get and update to log end
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Add Payment Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed Add Payment!'
            );
        }

        echo json_encode($response_result);


         
    }

    public function cancel_status($id)
    {

        
        $this->isLoggedIn();
         $form_data  = $this->input->post();

        $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['booking_id']       = $id;
        $insertData['payment_type']     = $form_data['payment_type'];
         
         
        $insertData['amount']           = $form_data['cancel_charges'];
        $insertData['status']           = 1;
        $insertData['date_at']          = date("Y-m-d H:i:s");
        $insertData['created_by']       = $this->session->userdata('userId');
        $insertData['customer_id']      = $form_data['custID'];
        $insertData['farmer_id']        = $form_data['farmer_id'];
        
        //booking data fetch
        $single_arr     = $this->consultant_model->find($id);
        
         
        $result = $this->booking_payments_model->save($insertData);

        $insertData  = array();
        $insertData['cancellation_charge']      = $form_data['cancel_charges'];
        $insertData['cancellation_reason']        = $form_data['cancel_reason'];
        $insertData['cancellation_date']        =  $form_data['payment_create_date'];
        $insertData['booking_status']        =  $form_data['booking_status'];
        $insertData['cancel_by']        = $this->session->userdata('userId');;
         
        $insertData['id']  = $id;  
        $price_updated    = $this->consultant_model->save($insertData);

        //get and update to log
        $single_arr     = $this->consultant_model->find($id);
        $logged         = $this->booking_log_model->booking_log($single_arr);
        //get and update to log end
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Cancellation Saved Successfully Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed To Add Cancellation!'
            );
        }

        echo json_encode($response_result);


         
    }

    public function edit_payment($id)
    {
         
        
        $this->isLoggedIn();
         $form_data  = $this->input->post();

         if($form_data['payment_amount'] ==$form_data['x_payment_amount'])
         {
            $response_result = array(
                'status'=>0,
                'message'=>'Update Some Amount !'
            );

         }else
         {
                $booking_id  = $form_data['booking_id'];
                $where = array();
                $where['status'] = '1';
                $where['booking_id'] = $booking_id;
                $where['id !='] = $id;

                $fetch_all_payment = $this->booking_payments_model->findDynamic($where);
                $total_paid_amount = 0;
                $total_refund_amount = 0;
                if(!empty($fetch_all_payment))
                {
                    foreach ($fetch_all_payment as $key => $value)
                    {
                         if($value->payment_type =='payment')
                         {
                            $total_paid_amount = $total_paid_amount + $value->amount;
                          }else if($value->payment_type =='refund')
                         { 
                            $total_refund_amount = $total_refund_amount + $value->amount;
                         } 
                    }
                }


                $single_arr         = $this->consultant_model->find($booking_id);
               

                if($form_data['payment_type']=='payment')
                {

                    $total_paid_amount = $total_paid_amount + $form_data['payment_amount'];
                    $balance            =  $single_arr->total;
                    $outstanding_amount = ($balance-$total_paid_amount);
                }
                if($form_data['payment_type']=='refund')
                {
                   $total_refund_amount = $total_refund_amount + $form_data['payment_amount'];

                   $outstanding_amount = ($single_arr->total_paid_amount-$total_refund_amount);
                }








           

         $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['id']               = $id;
        $insertData['payment_type']     = $form_data['payment_type'];
        $insertData['payment_mode']     = $form_data['payment_mode'];
        $insertData['bank_transaction_id']= $form_data['payment_bank_transaction_id'];
        $insertData['amount']           = $form_data['payment_amount'];
        $insertData['status']           = 1;
        $insertData['update_at']        = date("Y-m-d H:i:s");
        $insertData['update_by']        = $this->session->userdata('userId');
        $insertData['cheque_no']        = $form_data['cheque_no'];
        $insertData['bank_name']        = $form_data['bank_name'];
        $insertData['bank_branch']      = $form_data['bank_branch'];


        
         
       
        /*$total_paid_amount  = $single_arr->total + $form_data['payment_amount'];
        $outstanding_amount = ($balance-$total_paid_amount);*/
 
         
        $result = $this->booking_payments_model->save($insertData);

        $insertData                         = array();
        $insertData['total_paid_amount']    = $total_paid_amount;
        $insertData['refunded_amount']      = $total_refund_amount;
        $insertData['outstanding_amount']   = $outstanding_amount;
        $insertData['id']                   = $booking_id;  
        $price_updated                      = $this->consultant_model->save($insertData);

        //get and update to log
        $single_arr     = $this->consultant_model->find($booking_id);
        $logged         = $this->booking_log_model->booking_log($single_arr);
        //get and update to log end
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Add Payment Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed Add Payment!'
            );
        }
         }

        

        echo json_encode($response_result);


         
    }

    public function add_refund($id)
    {

        
        $this->isLoggedIn();
         $form_data  = $this->input->post();

        $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['booking_id']       = $id;
        $insertData['payment_type']     = 'refund';
        $insertData['payment_mode']     = $form_data['payment_mode'];
        $insertData['bank_transaction_id']= $form_data['payment_bank_transaction_id'];
        $insertData['amount']           = $form_data['payment_amount'];
        $insertData['date_at']          = date("Y-m-d H:i:s");
        $insertData['status']           = 1;
        $insertData['created_by']       = $this->session->userdata('userId');
        $insertData['customer_id']      = $form_data['custID'];
        $insertData['cheque_no']        = $form_data['cheque_no'];
        $insertData['bank_name']        = $form_data['bank_name'];
        $insertData['bank_branch']      = $form_data['bank_branch'];

         
     $response_result = array(
                    'status'=>0,
                    'message'=>''
            );

            $where = array();
                $where['status'] = '1';
                $where['booking_id'] = $id; 

                $fetch_all_payment = $this->booking_payments_model->findDynamic($where);
                 $total_refund_amount = 0;
                if(!empty($fetch_all_payment))
                {
                    foreach ($fetch_all_payment as $key => $value)
                    {
                         if($value->payment_type =='refund')
                         { 
                            $total_refund_amount = $total_refund_amount + $value->amount;
                         } 
                    }
                }


                $single_arr         = $this->consultant_model->find($id);
               

               
                 
                   $total_refund_amount = $total_refund_amount + $form_data['payment_amount'];

                   $outstanding_amount = ($single_arr->total_paid_amount-$total_refund_amount);
                




   /*      //booking data fetch outstanding_amount
        $single_arr     = $this->consultant_model->find($id);
        $total_paid = $single_arr->total_paid_amount;
        $refund = $form_data['payment_amount'];
        /*if($total_paid >= $refund)
        {
            $balance =  $single_arr->total;
             
            $refunded_amount        =  $single_arr->refunded_amount;
            $total_paid_amount      = ($single_arr->total_paid_amount-$form_data['payment_amount']);
            $outstanding_amount     = ($balance+0) - ($total_paid_amount+0);
            $outstanding_amount     = ($outstanding_amount) - ($form_data['payment_amount']);
            $refunded_amount        = $refunded_amount + $form_data['payment_amount'];
            $total_paid_amount      = $single_arr->total_paid_amount - $form_data['payment_amount'];

*/
             
            $result = $this->booking_payments_model->save($insertData);

            $insertData  = array();
             
           /* $insertData['total_paid_amount']  = $total_paid_amount;*/
            $insertData['outstanding_amount']  = $outstanding_amount;
            $insertData['refunded_amount']  = $total_refund_amount;
            $insertData['id']  = $id;  
            $price_updated    = $this->consultant_model->save($insertData);

            //get and update to log
            $single_arr     = $this->consultant_model->find($id);
            $logged         = $this->booking_log_model->booking_log($single_arr);
            //get and update to log end
            
           

            if($result)
            {
                $response_result = array(
                    'status'=>1,
                    'message'=>'Add Refund Successfully !'
                );
            }else
            {
                $response_result = array(
                    'status'=>0,
                    'message'=>'Failed Add Refund!'
                );
            }

        /*}else
        {
             $response_result = array(
                    'status'=>0,
                    'message'=>"Your Refund Amount shout not Greater than Total Paid Amount"
            );
        }
       */
        echo json_encode($response_result);


         
    }


    public function single($id='')
    {
         $this->isLoggedIn();
        $single_arr = $this->consultant_model->find($id);
         
        echo  json_encode($single_arr);
    }
    public function booking_logs($id='')
    {
         $this->isLoggedIn();
         $userid = $this->session->userdata('userId');
         $where_search['booking_id'] = $id;
         $conditions = array( 
                    'where' => $where_search, 
                    'userid' =>  $userid, 
                 ); 
        $booking_logs = $this->booking_log_model->getRows($conditions);
         
        if(!empty($booking_logs))
        {
            $arra_empt = [];
            foreach ($booking_logs as $bookin_log)
            {
                 

                   $arra_empt2=[];
                    $arra_empt2['id']                    =$bookin_log['id'];
                    $arra_empt2['booking_id']            =$bookin_log['booking_id'];
                    $arra_empt2['stage']                 =$bookin_log['stage'];
                    $arra_empt2['farmer_id']           =$bookin_log['farmer_id'];
                    $arra_empt2['customer_name']         =$bookin_log['customer_name'];
                    $arra_empt2['customer_mobile']       =$bookin_log['customer_mobile'];
                    $arra_empt2['customer_alter_mobile'] =$bookin_log['customer_alter_mobile'];
                    $arra_empt2['father_name']           =$bookin_log['father_name'];
                    $arra_empt2['state']                 =$bookin_log['state'];
                    $arra_empt2['other_state']           =$bookin_log['other_state'];
                    $arra_empt2['district']              =$bookin_log['district'];
                    $arra_empt2['other_district']        =$bookin_log['other_district'];
                    $arra_empt2['city']                  =$bookin_log['city'];
                    $arra_empt2['other_city']            =$bookin_log['other_city'];
                    $arra_empt2['village']               =$bookin_log['village'];
                    $arra_empt2['pincode']               =$bookin_log['pincode'];
                    $arra_empt2['booking_date']          =date('d M Y',strtotime($bookin_log['booking_date']));
                    $arra_empt2['req_delivery_date']     =$bookin_log['req_delivery_date'];
                    $arra_empt2['delivery_date']         =($bookin_log['delivery_date']=='0000-00-00' || $bookin_log['delivery_date']==null)?'':date('d M Y',strtotime($bookin_log['delivery_date']));
                    $arra_empt2['supply_address']        =$bookin_log['supply_address'];
                    $arra_empt2['vehicle_no']            =$bookin_log['vehicle_no'];
                    $arra_empt2['agent_id']              =$bookin_log['agent_id'];
                    $arra_empt2['crates']                =$bookin_log['crates'];
                    $arra_empt2['bank_trans_id']         =$bookin_log['bank_trans_id'];
                    $arra_empt2['contract']              =$bookin_log['contract'];
                    $arra_empt2['productive_plants']     =$bookin_log['productive_plants'];
                    $arra_empt2['driver_name']           =$bookin_log['driver_name'];
                    $arra_empt2['booking_status']        =$bookin_log['booking_status'];
                    $arra_empt2['crop_status']           =$bookin_log['crop_status'];
                    $arra_empt2['billing_address']       =$bookin_log['billing_address'];
                    $arra_empt2['same_billing']          =$bookin_log['same_billing'];
                    $arra_empt2['delivery_address']      =$bookin_log['delivery_address'];
                    $arra_empt2['advance']               =number_format($bookin_log['advance'],2);
                    $arra_empt2['create_date']           =date('d M Y',strtotime($bookin_log['create_date']));
                    $arra_empt2['balance']               =$bookin_log['balance'];
                    $arra_empt2['payment_mode']          =$bookin_log['payment_mode'];
                    $arra_empt2['cheque_no']             =$bookin_log['cheque_no'];
                    $arra_empt2['bank_name']             =$bookin_log['bank_name'];
                    $arra_empt2['bank_branch']           =$bookin_log['bank_branch'];
                    $arra_empt2['product_id']            =$bookin_log['product_id'];
                    $arra_empt2['uom']                   =$bookin_log['uom'];
                    $arra_empt2['price']                 =number_format($bookin_log['price'],2);
                    $arra_empt2['quantity']              =$bookin_log['quantity'];
                    $arra_empt2['cgst_rate']             =$bookin_log['cgst_rate'];
                    $arra_empt2['sgst_rate']             =$bookin_log['sgst_rate'];
                    $arra_empt2['igst_rate']             =$bookin_log['igst_rate'];
                    $arra_empt2['cgst_amount']           =$bookin_log['cgst_amount'];
                    $arra_empt2['sgst_amount']           =$bookin_log['sgst_amount'];
                    $arra_empt2['igst_amount']           =$bookin_log['igst_amount'];
                    $arra_empt2['total_paid_amount']     =$bookin_log['total_paid_amount'];
                    $arra_empt2['outstanding_amount']    =$bookin_log['outstanding_amount'];
                    $arra_empt2['cancellation_reason']    =$bookin_log['cancellation_reason'];
                    $arra_empt2['discount']              =number_format($bookin_log['discount'],2);
                    $arra_empt2['total']                 =number_format($bookin_log['total'],2);
                    $arra_empt2['pending_bill']          =$bookin_log['pending_bill'];
                    $arra_empt2['status']                =$bookin_log['status'];
                    $arra_empt2['created_by']            =$bookin_log['created_by'];
                    $arra_empt2['date_at']               =date('d M Y',strtotime($bookin_log['date_at']));
                    $arra_empt2['document']              =(isset($bookin_log['document'])?"<a href='".base_url()."uploads/admin/document/".$bookin_log['document']."'>":"");
                    $arra_empt2['assigned_to']           =$bookin_log['assigned_to'];
                    $arra_empt2['delivery_expect_start_date']=($bookin_log['delivery_expect_start_date']=='0000-00-00' || $bookin_log['delivery_expect_start_date']==null)?'':date('d M Y',strtotime($bookin_log['delivery_expect_start_date']));
                    $arra_empt2['delivery_expect_end_date']=($bookin_log['delivery_expect_end_date']=='0000-00-00' || $bookin_log['delivery_expect_end_date']==null)?'':date('d M Y',strtotime($bookin_log['delivery_expect_end_date']));
                    $arra_empt2['update_at']             =date('d M Y',strtotime($bookin_log['update_at']));
                    $arra_empt2['company_id']            =$bookin_log['company_id'];
                    $arra_empt2['createdby']             =$bookin_log['createdby'];
                    $arra_empt2['booked_status']         =$bookin_log['booked_status'];
                    $arra_empt2['booked_badges']         =$bookin_log['booked_badges'];
                    $arra_empt2['executive']             =$bookin_log['executive'];
                    $arra_empt2['productname']           =$bookin_log['productname'];
                    $arra_empt2['paymentmodename']       =$bookin_log['paymentmodename'];
                    $arra_empt2['contractstatusname']    =$bookin_log['contractstatusname'];
                    $arra_empt2['assignedto']            =$bookin_log['assignedto'];
                    $arra_empt2['cropstatusname']        =$bookin_log['cropstatusname'];

                    $arra_empt[]= $arra_empt2;
            }
        }
        echo  json_encode($arra_empt);
    }

    public function receipt($id)
    {

        $this->isLoggedIn();

        $data = array();
         $userid = $this->session->userdata('userId');
         $where_search['id'] = $id;
         $conditions = array( 
                    'where' => $where_search 
                 ); 
        $booked = $this->consultant_model->getRows($conditions);
         $data['company_details'] = '';
         $data['receipt_dtl'] = '';
        if(!empty($booked))
        {
            $receipt_dtl = $booked[0];

            $where_search =  array();
            $where_search['id'] = $receipt_dtl['company_id'];
            $conditions = array( 
                'where' => $where_search 
            ); 

             $data['receipt_dtl'] = $receipt_dtl;
             $company_details = $this->company_model->findCompanyDetail($conditions);

            if(!empty($company_details))
            {
                $data['company_details'] =   $company_details[0];   
            }

            $where = array();
            $where['status'] = '1';
            $where['orderby'] = 'title';
            $data['payments_mode'] = $this->payment_mode_model->findDynamic($where);
           

            
        }
        
 
        $this->global['pageTitle'] = 'Booking Receipt';
        $this->loadViews("admin/booking/booking-reciept", $this->global, $data , NULL);

    }
    public function agreement($id)
    {

        $this->isLoggedIn();

        $data = array();
         $userid = $this->session->userdata('userId');
         $where_search['id'] = $id;
         $conditions = array( 
                    'where' => $where_search 
                 ); 
        $booked = $this->consultant_model->getRows($conditions);
         $data['company_details'] = '';
         $data['receipt_dtl'] = '';
        if(!empty($booked))
        {
            $receipt_dtl = $booked[0];

            $where_search =  array();
            $where_search['id'] = $receipt_dtl['company_id'];
            $conditions = array( 
                'where' => $where_search 
            ); 

             $data['receipt_dtl'] = $receipt_dtl;
             $company_details = $this->company_model->findCompanyDetail($conditions);

            if(!empty($company_details))
            {
                $data['company_details'] =   $company_details[0];   
            }
           

            
        }
        
 
        $this->global['pageTitle'] = 'Booking Agreement';
        $this->loadViews("admin/booking/booking-agreement", $this->global, $data , NULL);

    }
    public function view($id)
    {

        $this->isLoggedIn();

        $data = array();
         $userid = $this->session->userdata('userId');
         $where_search['id'] = $id;
         $conditions = array( 
                    'where' => $where_search 
                 ); 
        $booked = $this->consultant_model->getRows($conditions);
         $data['company_details'] = '';
         $data['receipt_dtl'] = '';
        if(!empty($booked))
        {
            $receipt_dtl = $booked[0];

            $where_search =  array();
            $where_search['id'] = $receipt_dtl['company_id'];
            $conditions = array( 
                'where' => $where_search 
            ); 

             $data['receipt_dtl'] = $receipt_dtl;
             $data['payment_details']    = $this->booking_payments_model->getPaymentDetail($id); 
             $company_details = $this->company_model->findCompanyDetail($conditions);

            if(!empty($company_details))
            {
                $data['company_details'] =   $company_details[0];   
            }
           

            
        }
        
 
        $this->global['pageTitle'] = 'Booking View';
        $this->loadViews("admin/booking/booking-view", $this->global, $data , NULL);

    }

    public function export()
    {

         $this->isLoggedIn();



                $userid = $this->session->userdata('userId');
                $where_search   = array(); 
                $conditions     = array();

                $search_farmer_id  = @$this->input->get('farmer_id');
                $search_name         = @$this->input->get('customer_name');
                $search_mobile       = @$this->input->get('customer_mobile');
                $search_alt_mobile   = @$this->input->get('customer_alter_mobile');
                $state2              = @$this->input->get('state2');
                $other_state         = @$this->input->get('other_state');
                $district2           = @$this->input->get('district2');
                $other_district      = @$this->input->get('other_district');
                $city2               = @$this->input->get('city2');
                $other_city          = @$this->input->get('other_city');
                $call_direction2     = @$this->input->get('call_direction2');
                $call_type2          = @$this->input->get('call_type2'); 
                $booking_no          = @$this->input->get('booking_no'); 
                $booking_date        = @$this->input->get('booking_date'); 
                $booking_status      = @$this->input->get('booking_status'); 
                $crop_status         = @$this->input->get('crop_status'); 
                $agent_id            = @$this->input->get('agent_id'); 
                $product_id          = @$this->input->get('product_id'); 
                $address             = @$this->input->get('address'); 
                $pincode             = @$this->input->get('pincode'); 
                $quantity            = @$this->input->get('quantity'); 
                $unit_price          = @$this->input->get('unit_price'); 
                $discount            = @$this->input->get('discount'); 
                $outstanding_amount  = @$this->input->get('outstanding_amount'); 
                $req_delivery_date   = @$this->input->get('req_delivery_date'); 
                $delivery_date       = @$this->input->get('delivery_date'); 
                $vehicle_no          = @$this->input->get('vehicle_no'); 
                $contract            = @$this->input->get('contract'); 
                $start_date          = @$this->input->get('start_date'); 
                $end_date            = @$this->input->get('end_date'); 
                $search_type            = @$this->input->get('search_type'); 
                $advance_booking_status_value            = @$this->input->get('advance_booking_status_value'); 
                if(!empty($start_date))
                {
                     $where_search['start_date'] =  $start_date;
                 }
                 if(!empty($end_date))
                {
                     $where_search['end_date'] =  $end_date;
                 } 
                 if(!empty($contract))
                {
                     $where_search['contract'] =  $contract;
                 }
                 if(!empty($vehicle_no))
                {
                     $where_search['vehicle_no'] =  $vehicle_no;
                 }
                 if(!empty($delivery_date))
                {
                     $where_search['delivery_date'] =  $delivery_date;
                 }
                 if(!empty($quantity))
                {
                     $where_search['quantity'] =  $quantity;
                 }
                 if(!empty($discount))
                {
                     $where_search['discount'] =  $discount;
                 }if(strlen($outstanding_amount) >0)
                {
                     $where_search['outstanding_amount'] =  $outstanding_amount;
                 }if(strlen($unit_price) >0)
                {
                     $where_search['price'] =  $unit_price;
                 }
                 if(!empty($pincode))
                {
                     $where_search['pincode'] =  $pincode;
                 }
                 if(!empty($other_state))
                {
                     $where_search['other_state'] =  $other_state;
                 }
                 if(!empty($other_district))
                {
                     $where_search['other_district'] =  $other_district;
                 }
                   if(!empty($other_city))
                {
                     $where_search['other_city'] =  $other_city;
                 }

                 if(!empty($address))
                {
                     $where_search['billing_address'] =  $address;
                 }
                 if(!empty($product_id))
                {
                     $where_search['product_id'] =  $product_id;
                 }
                
                if(!empty($agent_id))
                {
                     $where_search['agent_id'] =  $agent_id;
                      
                }
                if(!empty($crop_status))
                {
                      $where_search['crop_status'] =  $crop_status;
                }
                if(!empty($booking_status) && $booking_status !=='all')
                {
                     $where_search['booking_status'] =  $booking_status;
                }
                if(!empty($booking_date))
                {
                     $where_search['booking_date'] =  $booking_date;
                }
                if(!empty($booking_no))
                {
                    $where_search['id'] =  $booking_no;
                }
                if(!empty($search_farmer_id))
                {
                    $where_search['farmer_id'] =  $search_farmer_id;
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
                
                if(!empty($district2))
                {
                    $where_search['district'] =  $district2;
                }
                if(!empty($city2))
                {
                    $where_search['city'] =  $city2;
                }
                if(!empty($search_type))
                {
                    $where_search['search_type'] =  $search_type;
                } 
                 if(!empty($advance_booking_status_value))
                {
                    $where_search['advance_booking_status_value'] =  $advance_booking_status_value;
                }  
                
                
            

             $conditions = array( 
                 
                'where' => $where_search, 
                'userid' =>  $userid
                 
                
                ); 




           
            
             $resultfound = $this->consultant_model->getRows($conditions);

            $content = "Booking No,Booking Date ,Order Status,Crop Status,Customer Id,Customer Name,Executive,Product,Primary number,Number,Address,Tehsil,Pincode,District,State,Payment Mode,Bank Trxn Id,Crates,Plants Booked,Plant Rate,Total Billed Amount,Discount Amount,Received Amount,Outstanding Amount,Requested Delivery Date,Actual Delivery Date ,Vehicle No.,Delivery Status,Contract Status,Productive Plants, Billing Address, Delivery Address\n";
                
               /* echo "<pre>";
                print_r($resultfound );
                echo "</pre>";*/
            if(!empty($resultfound))
            {
                foreach ($resultfound as $key => $value) 
                {
                    
                    $billing_address =trim($value['billing_address']);
                    $billing_address =str_replace("\n", " ", $billing_address);
                    $billing_address =str_replace("\r", " ", $billing_address);
                     
                    $delivery_address =trim( $value['delivery_address']);
                    $delivery_address =str_replace("\n", " ", $delivery_address);
                    $delivery_address =str_replace("\r", " ", $delivery_address);
                     
                    $customer_alter_mobile =str_replace(",", " ", $value['customer_alter_mobile']);
                     

                    $content.= str_replace(",", " ", $value['id']).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['booking_date']))).",";
                    $content.= str_replace(",", " ", $value['booked_status']).",";
                    $content.= str_replace(",", " ", $value['cropstatusname']).",";
                    $content.= str_replace(",", " ", $value['farmer_id']).",";
                    $content.= str_replace(",", " ", $value['customer_name']).",";
                    $content.= str_replace(",", " ", $value['executive']).",";
                    $content.= str_replace(",", " ", $value['productname']).",";
                    $content.= str_replace(",", " ", $value['customer_mobile']).",";
                    $content.= str_replace(",", " ", $customer_alter_mobile).",";
                    $content.= str_replace(",", " ", $billing_address).",";
                    $content.= str_replace(",", " ", ($value['city']=='Other')?$value['other_city']:$value['city']).",";
                    $content.= str_replace(",", " ", ($value['pincode'])).",";
                    $content.= str_replace(",", " ", ($value['district']=='Other')?$value['other_district']:$value['district']).",";
                    $content.= str_replace(",", " ", ($value['state']=='Other')?$value['other_state']:$value['state']).",";
                     
                    $content.= str_replace(",", " ", $value['paymentmodename']).",";
                    $content.= str_replace(",", " ", $value['bank_trans_id']).",";
                    $content.= str_replace(",", " ", $value['crates']).",";
                    $content.= str_replace(",", " ", $value['quantity']).",";
                    $content.= str_replace(",", " ", $value['price']).",";
                    $content.= str_replace(",", " ", $value['total']).",";
                    $content.= str_replace(",", " ", $value['discount']).",";
                    $content.= str_replace(",", " ", $value['total_paid_amount']).",";
                    $content.= str_replace(",", " ", $value['outstanding_amount']).",";
                    $content.= str_replace(",", " ", (($value['delivery_expect_start_date'] !=='0000-00-00')?date('d M Y',strtotime($value['delivery_expect_start_date'])):'')).",";
                    $content.= str_replace(",", " ", (($value['delivery_date'] !=='0000-00-00')?date('d M Y',strtotime($value['delivery_date'])):'')).",";
                     $content.= str_replace(",", " ", $value['vehicle_no']).",";
                     $content.= str_replace(",", " ", $value['booked_status']).",";
                     $content.= str_replace(",", " ", $value['contractstatusname']).",";
                     $content.= str_replace(",", " ", $value['productive_plants']).",";
                     $content.= str_replace(",", " ", $billing_address).",";
                     $content.= str_replace(",", " ", $delivery_address).",";
 
                           $content.="\n";
                }
            }        

 
                    
        $filename = 'bookiong-export-'.date('d-m-Y-h-s').'.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        print_r($content);
        die; 
    }

    public function get_all_state()
    {

            
            $where = array();
            $where['country_id'] = '105';
            $where['status'] = 1;
            $where['field'] = 'id,name';
             

            $returnData = $this->state_model->findDynamic($where);

          $response_result = array(
                'status'=>0,
                'data'=>'',
                'message'=>'Not data found !'
        );

        if($returnData)
        {
            $response_result = array(
                'status'=>1,
                'data'=>$returnData,
                'message'=>'Data Found .'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'data'=>'Failed Fetch Data!',
                'message'=>'Empty Data Found .'
            );
        }

        echo json_encode($response_result);
          
    }  
    public function get_all_district()
    {

            
            $where = array();
            $where['status'] = 1;
            $where['field'] = 'id,name';
             

            $returnData = $this->district_model->findDynamic($where);

          $response_result = array(
                'status'=>0,
                'data'=>'',
                'message'=>'Not data found !'
        );

        if($returnData)
        {
            $response_result = array(
                'status'=>1,
                'data'=>$returnData,
                'message'=>'Data Found .'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'data'=>'Failed Fetch Data!',
                'message'=>'Empty Data Found .'
            );
        }

        echo json_encode($response_result);
          
    }  
    public function get_all_city()
    {

            
            $where = array();
            $where['status'] = 1;
            $where['field'] = 'id,city';
             

            $returnData = $this->city_model->findDynamic($where);

          $response_result = array(
                'status'=>0,
                'data'=>'',
                'message'=>'Not data found !'
        );

        if($returnData)
        {
            $response_result = array(
                'status'=>1,
                'data'=>$returnData,
                'message'=>'Data Found .'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'data'=>'Failed Fetch Data!',
                'message'=>'Empty Data Found .'
            );
        }

        echo json_encode($response_result);
          
    }  


    public function documentCategoryChange($id='',$selected_id='')
    {
          
          $form_data    = $this->input->post();
          $id           = $form_data['id'];
          $selected_id     = $form_data['selected'];
        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        if(!empty($id))
        {
            $where['document_cat_id'] = $id;
        }
        $documents = $this->document_model->findDynamic($where);
        $html_content = '<option value="">Choose</option>';
        if(!empty($documents))
        {
            foreach ($documents as $documents ) {
                $selected = '';
                if(isset($selected_id) && $selected_id ==$documents->id)
                {
                    $selected = 'selected';
                }
                $html_content.= '<option value="'.$documents->id .'" '.$selected.'>'.$documents->title .'</option>';
            }    
        }
        echo $html_content;
        
    }
    
    
    
    
}

?>