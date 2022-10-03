<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Customer_call extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('user/customer_call_model');
       $this->load->model('admin/city_model');
       $this->load->model('admin/state_model');
       $this->load->model('admin/call_type_model');
       $this->load->model('admin/call_direction_model');
       $this->load->model('admin/customer_model');
       $this->load->model('admin/user_model');
    }

    
    public function index()
    {
        $this->isUserLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Customer ';
        $this->userView("user/customer/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isUserLoggedIn();
        $data = array();
        
        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,customer_name,customer_title,sku_id';
        $data['all_customers'] = $this->customer_model->findDynamic($where);
        
        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title,sku_id';
        $data['all_users'] = $this->user_model->findDynamic($where);


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
        $where['orderby'] = 'title';
        $data['calltypes'] = $this->call_type_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['calldirections'] = $this->call_direction_model->findDynamic($where);

        $this->global['pageTitle'] = 'Add New customer';
        $this->userView("user/customer/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isUserLoggedIn();
        
        
        
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('customer','customer','trim|required');
        $this->form_validation->set_rules('call_type','call_type','trim|required');
        $this->form_validation->set_rules('assign_to','assign_to','trim|required');
        $this->form_validation->set_rules('call_back_date','call_back_date','trim|required');
        $this->form_validation->set_rules('call_direction','call_direction','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            if(isset($form_data['id']) && $form_data['id'] !==''){
                $this->edit($form_data['id']);
            }else
            {
                $this->addnew();
            }
            
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
              
               
                 if(isset($form_data['id']) && $form_data['id'] !==''){
                    redirect('user/customer/edit/'.$form_data['id']);
                         
                    }else
                    {
                         redirect('user/customer/addnew');
                    }
                    
          }  
        
    } 

     

    
    // Member list
    public function ajax_list()
    {
        $assign_to = $_POST['assign_to'];
		$list = $this->customer_call_model->get_datatables($assign_to);
		  print_r($this->db->last_query());  
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
                        <button class="btn btn-info dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action1<i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" style="">
                        <a class="dropdown-item" hidden   href="'.base_url().'user/customer/edit/'.$currentObj->id.'" >View</a>
                        <a class="dropdown-item text-danger deletebtn" href="#" data-userid="'.$currentObj->id.'">Delete</a>
                         
                        
                        </div>
                        </div>
                    
                                            ' ;

                                            /*<a  class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"  href="'.base_url().'user/customer/edit/'.$currentObj->id.'" >
                                                                View Details
                                                            </a><a  class="btn btn-primary btn-sm btn-rounded waves-effect waves-light deletebtn  href="#" data-userid="'.$currentObj->id.'" >
                                                                Delete
                                                            </a>*/
            $row[] = $dateAt;
            
            $row[] = $currentObj->customer_title;
            $row[] = $currentObj->call_type_title;
            $row[] =  date("d-m-Y H:ia", strtotime($currentObj->call_back_date)); 
            $row[] = $currentObj->call_direction_title;
            $row[] = $currentObj->current_conversation;
            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->customer_call_model->count_all($assign_to),
                        "recordsFiltered" => $this->customer_call_model->count_filtered($assign_to),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Status Change
 
    public function statusChange($id = NULL)
    {
        $this->isUserLoggedIn();
        if($_POST['id'] == null)
        {
            redirect('user/agency');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->customer_call_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isUserLoggedIn();

        if($id == null)
        {
            redirect('user/customer');
        }

        $data = array();
        
        $where = array();
        $where['status'] = '1'; 
        $where['id'] = $id; 
        $where['field'] = 'id,customer_name,customer_title,sku_id';
        $data['all_customers'] = $this->customer_model->findDynamic($where);
        
        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title,sku_id';
        $data['all_users'] = $this->user_model->findDynamic($where);


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
        $where['orderby'] = 'title';
        $data['calltypes'] = $this->call_type_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['calldirections'] = $this->call_direction_model->findDynamic($where);
        

        $data['edit_data'] = $this->customer_model->find($id);
        $this->global['pageTitle'] = 'Agency ';
        $this->userView("user/customer/edit", $this->global, $data , NULL);
        
    }  

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isUserLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->customer_call_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Agency*************************************************************
    public function update()
    {
		
        $this->isUserLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('customer_name','customer_name','trim|required');
        $this->form_validation->set_rules('customer_mobile','customer_mobile','trim|required');
        $this->form_validation->set_rules('state','state','trim|required');
        $this->form_validation->set_rules('city','city','trim|required');
        
        //form data 
        $form_data  = $this->input->post();

        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {
            $insertData['id'] = $form_data['id'];
            $insertData['customer_name']         = $form_data['customer_name'];
                $insertData['customer_title']        = ucfirst($form_data['customer_name']);
                $insertData['customer_mobile']       = $form_data['customer_mobile'];
                $insertData['customer_alter_mobile'] = $form_data['customer_alter_mobile'];
                $insertData['state']                 = $form_data['state'];
                $insertData['city']                  = $form_data['city'];
                $insertData['update_at']               = date("Y-m-d H:i:s");

             
			
			 

            $result = $this->customer_call_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Customer Update successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Customer Updation failed');
            }
            redirect('user/customer/edit/'.$insertData['id']);
          }  
        
    }

    
    
    
}

?>