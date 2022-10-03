<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Root extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/root_model');
       $this->load->model('admin/root_dtl_model');

         $this->global['module_id']      = get_module_byurl('admin/root');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if( empty($action_requred) )
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }
    }

    
    public function index()
    {
        $this->isLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Roots';
        $this->loadViews("admin/root/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();
        $data = array();
        $this->global['pageTitle'] = 'Add New Root';
        $this->loadViews("admin/root/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
         
         
        

        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
             $company_id = $this->session->userdata('company_id');

            // check already exist
            $form_data['name'] =  strtolower($form_data['name']);
            $form_data['slug'] =  clean_slug($form_data['name']);
            $form_data['title'] =  ucwords($form_data['name']);
            $where = array();
            $where['title']  = $form_data['title'];
            $returnData     = $this->root_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{

                $insertData = array();
                $insertData['name']         = $form_data['name'];
                $insertData['title']        = $form_data['title'];
                $insertData['slug_url']         = $form_data['slug'];
                $insertData['status']       = $form_data['status1'];
                $insertData['company_id']        = $company_id;
                $insertData['date_at']      = date("Y-m-d H:i:s");
    			$result = $this->root_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Role successfully Added');
                     redirect(base_url().'admin/roles');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Role Addition failed');
                     redirect(base_url().'admin/root/addnew');
                }
            }   
            redirect('admin/root/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->root_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

             $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn form-control form-control-sm " name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
              $dateAt = date("d M Y H:ia", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->name;
            $row[] = $dateAt;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/root/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->root_model->count_all(),
                        "recordsFiltered" => $this->root_model->count_filtered(),
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
        $result = $this->root_model->save($insertData);
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
            redirect('admin/roles');
        }

        $data['edit_data'] = $this->root_model->find($id);
        $this->global['pageTitle'] = 'Role Edit ';
        $this->loadViews("admin/root/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->root_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Country*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Role','trim|required');
         
        
        $this->form_validation->set_rules('id','Id','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {


             // check already exist
                $form_data['name'] =  strtolower($form_data['name']);
                $form_data['slug'] =  clean_slug($form_data['name']);
                $form_data['title'] =  ucwords($form_data['name']);


                $where = array();
                $where['title']         = $form_data['title'];
                $where['id !=']         = $form_data['id'];
                $returnData             = $this->root_model->findDynamic($where);


                 
            


            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{
                 $insertData = array();
                $insertData['id'] = $form_data['id'];
               
                $insertData['name']         = $form_data['name'];
                $insertData['title']        = $form_data['title'];
                $insertData['slug_url']         = $form_data['slug'];
                $insertData['status']           = $form_data['status1'];
                $insertData['update_at']      = date("Y-m-d H:i:s");
                
                
             

                $result = $this->root_model->save($insertData);
                

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Role successfully Updated');
                    redirect(base_url().'admin/roles');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Role Updation failed');
                    redirect(base_url().'admin/root/edit/'.$form_data['id']);
                }
            }
            
            redirect(base_url().'admin/root/edit/'.$form_data['id']);
          }  
        
    }


    public function update_role_module()
    {
        $this->isLoggedIn();
        
         
         


        $module_checked =   $this->input->post('module_checked');
        $option_data =   $this->input->post('option_data');
        $role_id =   $this->input->post('role_id');
        $userid = $this->session->userdata('userId');
        $company_id = $this->session->userdata('company_id');




            $where = array();
            $where['role_id']       = $role_id ;
            $where['field']         = 'id';
            $update_status             = $this->module_root_model->findDynamic($where);

            if(!empty($update_status))
            {
                foreach ($update_status as $key => $value)
                {
                     $insertData = array();
                     $insertData['id'] = $value->id;
                     $insertData['status'] = 0;
                    
                    $this->module_root_model->save($insertData);
                }
            }


        
 
         foreach ($module_checked  as $key => $value) {
                 $insertData = array();
                $module_id = $key;
                $where = array();
                $where['module_id']         = $module_id;
                $where['role_id']       = $role_id ;
                $returnData             = $this->module_root_model->findDynamic($where);

                if(!empty($returnData))
                {
                    $insertData['id']   =  $returnData[0]->id;
                    $insertData['updated_by']   =  $userid;
                    $insertData['updated_at']      = date("Y-m-d H:i:s");
                }else
                {
                    $insertData['created_by']   =  $userid;
                    $insertData['company_id']   =  $company_id;
                    $insertData['date_at']      = date("Y-m-d H:i:s");
                }
                $insertData['action_required']         = json_encode(array());
                if(!empty($option_data))
                {
                    if(isset($option_data[$module_id]['inlineRadioOptions']) && !empty($option_data[$module_id]['inlineRadioOptions']))
                    {
                        $action_required = json_encode($option_data[$module_id]['inlineRadioOptions']);
                        $insertData['action_required']         = $action_required;
                    }
                }

                $insertData['module_id']         = $module_id;
                $insertData['role_id']        = $role_id;
                 
                $insertData['status']       = 1;
                 
                $result = $this->module_root_model->save($insertData);
         }
             $this->session->set_flashdata('success', 'Role Module successfully Updated');
            redirect(base_url().'admin/root/edit/'.$role_id);
         
    }
    

    
    
    
}

?>