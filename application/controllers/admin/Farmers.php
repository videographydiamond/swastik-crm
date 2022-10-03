<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Farmers extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/farmers_model');
       $this->load->model('admin/lead_source_model');
       $this->load->model('admin/state_model');
       $this->load->model('admin/district_model');
       $this->load->model('admin/country_model');
       $this->load->model('admin/farmers_model');
       $this->load->model('admin/farmer_type_model');

       $this->perPage =100; 
 
    }
     

    
    public function index()
    {
        $this->isLoggedIn();


        $this->global['module_id']      = get_module_byurl('admin/farmers');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        $action_requred2                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(!empty($action_requred) || !empty($action_requred2))
        {
            
        }else
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $data = array();


        //pagomatopm start
            $where_search = array();

            $search_name            = @$this->input->get('name');
            $farmer_id              = @$this->input->get('farmer_id');
            $mobile                 = @$this->input->get('mobile');
            $father_name            = @$this->input->get('father_name');
            $whatsapp               = @$this->input->get('whatsapp');
            $alt_mobile             = @$this->input->get('alt_mobile');
            $farmer_type             = @$this->input->get('farmer_type');
            $is_premium             = @$this->input->get('is_premium');



                if(!empty($search_name))
                {
                    $where_search['name'] =  $search_name;
                }  
                if(strlen($is_premium)>0)
                {
                    $where_search['is_premium'] =  $is_premium;
                } 
                if(!empty($farmer_id))
                {
                    $where_search['id'] =  $farmer_id;
                } 
                if(!empty($mobile))
                {
                    $where_search['mobile'] =  $mobile;
                } 
                if(!empty($whatsapp))
                {
                    $where_search['whatsapp'] =  $whatsapp;
                }
                 if(!empty($alt_mobile))
                {
                    $where_search['alt_mobile'] =  $alt_mobile;
                }
                if(!empty($farmer_type))
                {
                    $where_search['farmer_type'] =  $farmer_type;
                } 


            $userid = $this->session->userdata('userId');
            $conditions['returnType']   = 'count'; 
            $conditions['userid']       = $userid; 
            $conditions['where']        = $where_search;
            $totalRec = $this->farmers_model->getRows($conditions);

            $this->load->library('pagination'); 

            $conditions = array();
            $uriSegment = 4; 

            $config['base_url']         = base_url().'admin/farmers/index/'; 
            $config['uri_segment']      = $uriSegment; 
            $config['total_rows']       = $totalRec; 
            $config['per_page']         = $this->perPage; 
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string']= TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  justify-content-center mt-4" id="query-pagination">';
            $config['full_tag_close'] = '</ul> ';
             
            $config['first_link'] = 'First&nbsp;Page';
            $config['first_tag_open'] = '<li class="page-item">  ';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last&nbsp;Page';
            $config['last_tag_open'] ='<li class="page-item">  ';
            $config['last_tag_close'] = '</li>';
            $config['num_links'] =10;
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
                'userid' => $userid, 
                'limit' => $this->perPage 
                ); 


                $where = array();
                $where['status']        = '1';
                $where['orderby']       = 'id';
                $data['farmertypes']    = $this->farmer_type_model->findDynamic($where);


                 $data['farmers'] = $this->farmers_model->getRows($conditions); 
                $data['pagination_total_count'] =  $totalRec;
               /* echo "<pre>";
                print_r($data['farmers']);die;
                echo "</pre>";*/


         //pagination end 
 
        
        $this->global['pageTitle'] = 'Farmers';
        $this->loadViews("admin/farmers/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();

        $this->global['module_id']      = get_module_byurl('admin/farmers');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->create !=='create')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $data = array();
            
            $where  = array();
            $where['status']        = '1';
            $where['country_id']    = 105;
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['states'] = $this->state_model->findDynamic($where); 
            
            $where = array();
            $where['status'] = '1';
            $where['orderby'] = 'id';
            $data['farmertypes'] = $this->farmer_type_model->findDynamic($where);

            $where  = array();
            $where['status']        = '1'; 
            $data['lead_sources'] = $this->lead_source_model->findDynamic($where); 


        
        
        $this->global['module_id']  = get_module_byurl('admin/farmers');
        $role_id                    = $this->session->userdata('role_id');
        $action_requred             = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred->create))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $this->global['pageTitle'] = 'Add New Farmer';
        $this->loadViews("admin/farmers/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		$userid = $this->session->userdata('userId');
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('mobile','Mobile','trim|required');
        $this->form_validation->set_rules('farmer_type','Farmer Type','trim|required');
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {


                 // check already exist
                $form_data['name'] = strtolower($form_data['name']);
                $form_data['name'] = ucwords($form_data['name']);
                $where = array();
                 
                $where['mobile']          =  $form_data['mobile'];
                
                $returnData = $this->farmers_model->findDynamic($where);
 
              if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['mobile'].' already Exist.');
            }else{

            $insertData['name']         = $form_data['name'];
            $insertData['mobile']       = $form_data['mobile'];
            $insertData['alt_mobile']   = $form_data['alt_mobile'];
            $insertData['whatsapp']     = $form_data['whatsapp'];
            $insertData['father_name']  = $form_data['father_name'];
            $insertData['source']       = $form_data['source'];
            $insertData['pincode']      = $form_data['pincode'];
            $insertData['city_id']      = $form_data['city'];
            $insertData['other_city']   = $form_data['other_city'];
            $insertData['state_id']    = $form_data['state'];
            $insertData['other_state'] = $form_data['other_state'];
            $insertData['other_district']= $form_data['other_district'];
            $insertData['district_id']  = $form_data['district'];
            $insertData['date_at']      = date("Y-m-d H:i:s");;
            $insertData['status']       = $form_data['status1'];
            $insertData['village']      = $form_data['village'];
            $insertData['address']      = $form_data['address'];
            $insertData['farmer_type']      = $form_data['farmer_type'];
             $insertData['is_premium']      = (isset($form_data['is_premium']) && $form_data['is_premium'] !=='')?$form_data['is_premium']:0;
             $insertData['created_by']      = $userid;
                 
    			$result = $this->farmers_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Farmer successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Farmer Addition failed');
                }
            }// check already    
            redirect(base_url().'admin/farmers');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
         

		$list = $this->farmers_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            // $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn" name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
            
            $no++;
            $temp_date = $currentObj->date_at;
            $dateAt = date("d M Y H:ia", strtotime($temp_date));

            $row = array();
            $row[] = $currentObj->id;
            $row[] = $currentObj->name;
            $row[] = $currentObj->mobile;
            $row[] = $currentObj->alt_mobile;
            $row[] = $currentObj->father_name;
            $row[] = $currentObj->whatsapp;
            $row[] = $currentObj->village;
            $row[] = $currentObj->address;
           $row[] = $currentObj->state;
           $row[] = $currentObj->district;
           $row[] = $currentObj->city;
           $row[] = $currentObj->pincode;
           $row[] = $currentObj->source;
           $row[] = $dateAt;
            $edit_btn = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/farmers/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;';
            $delete_btn =  '<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
 
            $row[] = $btn;
            $row[] = $edit_btn.$delete_btn;;
           /* $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/farmers/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';*/
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->farmers_model->count_all(),
                        "recordsFiltered" => $this->farmers_model->count_filtered(),
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
            redirect('admin/farmers');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->farmers_model->save($insertData);
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
        exit;
    } 
  // Status Change
 
    public function isPremium($id = NULL)
    {
        $this->isLoggedIn();
        if($_POST['id'] == null)
        {
            redirect('admin/farmers');
        }
        $insertData = array();

        $insertData['id'] = $_POST['id'];
        $insertData['is_premium'] = $_POST['is_premium'];
        $result = $this->farmers_model->save($insertData);
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();
        if($id == null)
        {
            redirect('admin/farmers');
        }


        $this->global['module_id']  = get_module_byurl('admin/farmers');
        $role_id                    = $this->session->userdata('role_id');
        $action_requred             = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred->edit))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }


        $data = array();
        $data['edit_data'] = $this->farmers_model->find($id);


         $where  = array();
            $where['status']        = '1';
            $where['country_id']    = 105;
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['states'] = $this->state_model->findDynamic($where); 
        


        $where = array();
            $where['status'] = '1';
            $where['orderby'] = 'id';
            $data['farmertypes'] = $this->farmer_type_model->findDynamic($where);


            
         $where  = array();
            $where['status']        = '1'; 
            $data['lead_sources'] = $this->lead_source_model->findDynamic($where); 

        
        $this->global['pageTitle'] = 'Edit Farmers';
        $this->loadViews("admin/farmers/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->farmers_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		 $this->isLoggedIn();
       
        $userid = $this->session->userdata('userId');
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('mobile','Mobile','trim|required');
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
             $insertData = array();

                 // check already exist
                $form_data['name'] = strtolower($form_data['name']);
                $form_data['name'] = ucwords($form_data['name']);
                $where = array();
                 
                $where['mobile']          =  $form_data['mobile'];
                $where['id !=']          =  $form_data['id'];
                
                $returnData = $this->farmers_model->findDynamic($where);
 
              if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['mobile'].' already Exist.');
               redirect(base_url().'admin/farmers/edit/'.$form_data['id']);
            }else{

            $insertData['id']         = $form_data['id'];
            $insertData['name']         = $form_data['name'];
            $insertData['mobile']       = $form_data['mobile'];
            $insertData['alt_mobile']   = $form_data['alt_mobile'];
            $insertData['whatsapp']     = $form_data['whatsapp'];
            $insertData['father_name']  = $form_data['father_name'];
            $insertData['source']       = $form_data['source'];
            $insertData['pincode']      = $form_data['pincode'];
            $insertData['city_id']      = $form_data['city'];
            $insertData['other_city']   = $form_data['other_city'];
            $insertData['state_id']    = $form_data['state'];
            $insertData['other_state'] = $form_data['other_state'];
            $insertData['other_district']= $form_data['other_district'];
            $insertData['district_id']  = $form_data['district'];
            $insertData['update_at']      = date("Y-m-d H:i:s");;
            $insertData['status']       = $form_data['status1'];
            $insertData['village']      = $form_data['village'];
            $insertData['address']      = $form_data['address'];
            $insertData['farmer_type']      = $form_data['farmer_type'];
            $insertData['is_premium']      = (isset($form_data['is_premium']) && $form_data['is_premium'] !=='')?$form_data['is_premium']:0;
             $insertData['update_by']      = $userid;

                 
                $result = $this->farmers_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Farmer successfully Updated');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Farmer  Updated failed');
                }
            }// check already    
            redirect(base_url().'admin/farmers');
          } 
        
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
                $where['mobile'] = $mobile; 
            }

             $result = $this->farmers_model->findDynamic($where);
             if(!empty( $result))
             {
              $single_arr= $result[0];  
             }
                      
        }else
        {
             $single_arr = $this->farmers_model->find($id);
        }
        echo  json_encode($single_arr);
    }
    
}

?>