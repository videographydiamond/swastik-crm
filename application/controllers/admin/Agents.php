<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Agents extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/admin_model');
       $this->load->model('admin/lead_source_model');
       $this->load->model('admin/state_model');
       $this->load->model('admin/district_model');
       $this->load->model('admin/country_model');
       $this->load->model('admin/city_model');
       $this->load->model('admin/company_model');
       $role = $this->session->userdata('role');
       if($role==1)
        {
             
        }else
        {
            $this->session->set_flashdata('error', 'Un-Authorized Page Access !');
             redirect(base_url().'admin', 'refresh');
        }
        
       $this->perPage =100; 
    }

    
    public function index()
    {
        $this->isLoggedIn();

        $data = array();

        

        //pagomatopm start
            $where_search = array();

            $userid = $this->session->userdata('userId');
            $conditions['returnType']   = 'count'; 
            $conditions['userid']       = $userid; 
            $conditions['where']        = $where_search;
            $totalRec = $this->admin_model->getRows($conditions);

            $this->load->library('pagination'); 

            $conditions = array();
            $uriSegment = 4; 

            $config['base_url']    = base_url().'admin/agents/index/'; 
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
                'userid' => $userid, 
                'limit' => $this->perPage 
                ); 

                 $data['farmers'] = $this->admin_model->getRows($conditions); 
                $data['pagination_total_count'] =  $totalRec;
               /* echo "<pre>";
                print_r($data['farmers']);die;
                echo "</pre>";*/


         //pagination end 

        $this->global['pageTitle'] = 'Farmers';
        $this->loadViews("admin/agents/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
        

    
        $this->isLoggedIn();
        $data = array();
            
            $where  = array();
            $where['status']        = '1';
            $where['country_id']    = 105;
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['states'] = $this->state_model->findDynamic($where); 


            $where  = array();
            $where['status']        = '1';
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['companies'] = $this->company_model->findDynamic($where); 
            
            $where  = array();
            $where['status']        = '1'; 
            $data['lead_sources'] = $this->lead_source_model->findDynamic($where); 


        
        

        $this->global['pageTitle'] = 'Add New Farmer';
        $this->loadViews("admin/agents/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		 $userid = $this->session->userdata('userId');
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('mobile','Mobile','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
         
         
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
                $form_data['title'] = ucwords($form_data['name']);
                $where = array();
                 
                $where['email']          =  $form_data['email'];
                
                $returnData = $this->admin_model->findDynamic($where);
 
              if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['email'].' already Exist.');
            }else{

            $insertData['name']         = $form_data['name'];
            $insertData['title']         = $form_data['title'];
            $insertData['admin_type']         = 2;
            $insertData['email']         = $form_data['email'];
            $insertData['password']         = $form_data['password'];
            $insertData['phone']       = $form_data['mobile'];
            $insertData['pincode']      = $form_data['pincode'];
            $insertData['city_id']      = $form_data['city'];
            $insertData['other_city']   = $form_data['other_city'];
            $insertData['state_id']    = $form_data['state'];
            $insertData['other_state'] = $form_data['other_state'];
            $insertData['other_district']= $form_data['other_district'];
            $insertData['district_id']  = $form_data['district'];
            $insertData['date_at']      = date("Y-m-d H:i:s");;
            $insertData['date_join']      = (isset($form_data['date_join'])?($form_data['date_join']):date("Y-m-d"));
            $insertData['status']       = $form_data['status1'];
            $insertData['address']      = $form_data['address'];
            $insertData['company_id']      = $form_data['company_id'];
            $insertData['created_by']      = $userid;

                 
    			$result = $this->admin_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Agent successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Agent Addition failed');
                }
            }// check already    
            redirect(base_url().'admin/agents');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
         

		$list = $this->admin_model->get_datatables();
		
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
            $temp_date = $currentObj->date_join;
            $dateAt = date("d-m-Y H:ia", strtotime($temp_date));

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
            $edit_btn = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/agents/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;';
            $delete_btn =  '<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
 
            $row[] = $btn;
            $row[] = $edit_btn.$delete_btn;;
           /* $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/agents/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';*/
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->admin_model->count_all(),
                        "recordsFiltered" => $this->admin_model->count_filtered(),
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
            redirect('admin/city');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->admin_model->save($insertData);
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
            redirect('admin/agents');
        }

        $data = array();
        $data['edit_data'] = $this->admin_model->find($id);


            

             $where  = array();
            $where['status']        = '1';
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['states'] = $this->state_model->findDynamic($where); 

            
             $where  = array();
            $where['status']        = '1';
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['companies'] = $this->company_model->findDynamic($where); 
        

        
        $this->global['pageTitle'] = 'Edit Agents';
        $this->loadViews("admin/agents/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->admin_model->delete($delId); 
            
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
        $this->form_validation->set_rules('email','Email','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($form_data['id']);
        }
        else
        {


                 // check already exist
                $form_data['name'] = strtolower($form_data['name']);
                $form_data['title'] = ucwords($form_data['name']);
                $where = array();
                 
                $where['email']          =  $form_data['email'];
                $where['id !=']          =  $form_data['id'];
                
                $returnData = $this->admin_model->findDynamic($where);
 
              if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['email'].' already Exist.');
               //$this->edit($form_data['id']);
                redirect(base_url().'admin/agents/edit/'.$form_data['id']);
            }else{

            $insertData['id']         = $form_data['id'];
            $insertData['name']         = $form_data['name'];
            $insertData['title']         = $form_data['title'];
            $insertData['email']         = $form_data['email'];
            $insertData['password']         = $form_data['password'];
            $insertData['phone']       = $form_data['mobile'];
            $insertData['pincode']      = $form_data['pincode'];
            $insertData['city_id']      = $form_data['city'];
            $insertData['other_city']   = $form_data['other_city'];
            $insertData['state_id']    = $form_data['state'];
            $insertData['other_state'] = $form_data['other_state'];
            $insertData['other_district']= $form_data['other_district'];
            $insertData['district_id']  = $form_data['district'];
            $insertData['update_at']      = date("Y-m-d H:i:s");
             $insertData['date_join']      = (isset($form_data['date_join'])?($form_data['date_join']):date("Y-m-d"));
            $insertData['status']       = $form_data['status1'];
            $insertData['address']      = $form_data['address'];
            $insertData['company_id']      = $form_data['company_id'];
            $insertData['update_by']      = $userid;

                 
                $result = $this->admin_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Agent successfully Update');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Agent Update failed');
                }
            }// check already    
            redirect(base_url().'admin/agents');
          }  
        
        
    }

    
    
    
}

?>