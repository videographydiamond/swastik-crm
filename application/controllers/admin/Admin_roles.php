<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Admin_roles extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/admin_role_model');
       $this->load->model('admin/admin_model');
       $this->load->model('admin/role_model');

        $role = $this->session->userdata('role');
         
        if($role==1)
        {
             
        }else
        {
            $this->session->set_flashdata('error', 'Un-Authorized Page Access !');
             redirect(base_url().'admin', 'refresh');
        }
    }

    
    public function index()
    {
        $this->isLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Roles';

        $this->loadViews("admin/admin-roles/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();
        $data = array();
        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_users'] = $this->admin_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $data['all_roles'] = $this->role_model->findDynamic($where);
        $this->global['pageTitle'] = 'Add New Role';
        $this->loadViews("admin/admin-roles/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('user_id','User Name','trim|required');
        $this->form_validation->set_rules('role_id','Role name','trim|required');
         
         
        

        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
              
              $userid = $this->session->userdata('userId');
              $company_id = $this->session->userdata('company_id');
            // check already exist
            $form_data['name'] =  strtolower($form_data['name']);
            $form_data['slug'] =  clean_slug($form_data['name']);
            $form_data['title'] =  ucwords($form_data['name']);
            $where = array();
            $where['user_id']  = $form_data['user_id'];
            $where['role_id']  = $form_data['role_id'];
            $returnData     = $this->admin_role_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].'Added.');
            }else{

                $insertData = array();
                $insertData['user_id']         = $form_data['user_id'];
                $insertData['role_id']        = $form_data['role_id'];
                $insertData['status']       = $form_data['status1'];
                $insertData['company_id']       = $company_id;
                
                $insertData['created_at']      = date("Y-m-d H:i:s");
                $insertData['created_by']      = $userid ;
    			$result = $this->admin_role_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'User Role successfully Added');
                     redirect(base_url().'admin/admin_roles');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'User  Role Addition failed');
                     redirect(base_url().'admin/admin_roles/addnew');
                }
            }   
           redirect(base_url().'admin/admin_roles/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->admin_role_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

             $temp_date = $currentObj->created_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn form-control form-control-sm " name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
              $dateAt = date("d M Y H:ia", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->admin_name;
            $row[] = $currentObj->role_name;
            $row[] = $dateAt;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/admin_roles/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->admin_role_model->count_all(),
                        "recordsFiltered" => $this->admin_role_model->count_filtered(),
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
            redirect('admin/roles');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->admin_role_model->save($insertData);
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
            redirect('admin/admin_roles');
        }

          $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_users'] = $this->admin_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $data['all_roles'] = $this->role_model->findDynamic($where);

        $data['edit_data'] = $this->admin_role_model->find($id);
        $this->global['pageTitle'] = 'Role Edit ';
        $this->loadViews("admin/admin-roles//edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->admin_role_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Country*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('role_id','User Role','trim|required');
        $this->form_validation->set_rules('user_id','User Name','trim|required');
         
        
        $this->form_validation->set_rules('id','Id','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {
             $userid = $this->session->userdata('userId');
              $company_id = $this->session->userdata('company_id');

            

                $where = array();
                $where['user_id']         = $form_data['user_id'];
                $where['role_id']         = $form_data['role_id'];
                $where['id !=']         = $form_data['id'];
                $returnData             = $this->admin_role_model->findDynamic($where);


                 
            


            if(!empty($returnData)){
               $this->session->set_flashdata('error',  ' already Added.');
            }else{
                 $insertData = array();
                $insertData['id'] = $form_data['id'];
               
                 $insertData['user_id']         = $form_data['user_id'];
                $insertData['role_id']        = $form_data['role_id'];
                $insertData['status']       = $form_data['status1'];
                $insertData['company_id']       = $company_id;
                
                 $insertData['updated_by']      = $userid ;
                $insertData['updated_at']      = date("Y-m-d H:i:s");
                
                
             

                $result = $this->admin_role_model->save($insertData);
                

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'User Role successfully Updated');
                    redirect(base_url().'admin/roles');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Role Updation failed');
                    redirect(base_url().'admin/admin_roles/edit/'.$form_data['id']);
                }
            }
            
            redirect(base_url().'admin/admin_roles/edit/'.$form_data['id']);
          }  
        
    }


     
    

    
    
    
}

?>