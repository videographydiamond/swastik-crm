<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Attendance_history extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/attendance_history_model');
       $this->load->model('admin/attendance_history_model');
       $this->load->model('admin/admin_model');
       $this->load->model('admin/role_model');

        
        
    }

    
    public function index()
    {
        $this->isLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Attendance';

        $this->loadViews("admin/attendance/list", $this->global, $data , NULL);
        
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
        $this->loadViews("admin/attendance/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('puch_time','Punch Time','trim|required');
          
         
        

        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
            $userid = $this->session->userdata('userId');
 
            if(strtotime($form_data['puch_time']) <  strtotime($form_data['today_time']))
            {
                    $this->session->set_flashdata('error', 'Puch time Previous not allow');
                     redirect(base_url().'admin/attendance');
            }


            $where = array();
            $where['user_id']  = $userid;
            $where['att_date']  =  date("Y-m-d");
            $returnData     = $this->attendance_history_model->findDynamic($where);
            $insertData = array();
            if(!empty($returnData))
            {
                $insertData['id'] = $returnData[0]->id;
                $insertData['update_at']   = date("Y-m-d H:i:s");
                $insertData['updated_by']   = $userid ;
            }else
            {
                $insertData['checkin']      = date("Y-m-d H:i:s");
                $insertData['company_id']   = $company_id;
                $insertData['created_at']   = date("Y-m-d H:i:s");
                $insertData['created_by']   = $userid ;
                $insertData['user_id']     = $userid;

            }
            if($form_data['state']==1)
            {
                $insertData['last_checkin'] = date("Y-m-d H:i:s");
            }
            if($form_data['state']==2)
            {
                $insertData['last_checkout'] = date("Y-m-d H:i:s");
            }

                
               
    			$result = $this->attendance_history_model->save($insertData);
                if($result > 0)
                {

                    $dtl_data = array();
                    $dtl_data['att_id'] =$result;
                    $dtl_data['state'] =$form_data['state'];
                    $dtl_data['time'] =$form_data['puch_time'];
                    $dtl_data['company_id']   = $company_id;
                    $dtl_data['created_at']   = date("Y-m-d H:i:s");
                    $dtl_data['created_by']   = $userid ;
                    $dtl_data['user_id']     = $userid;
                    $result = $this->attendance_history_model->save($dtl_data);

                    $this->session->set_flashdata('success', 'Puch successfully Added');
                     redirect(base_url().'admin/attendance');
                }
                else
                { 
                    $this->session->set_flashdata('error', ' Puch  Addition failed');
                     redirect(base_url().'admin/attendance/addnew');
                }
              
           redirect(base_url().'admin/attendance/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->attendance_history_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {
 

             $punch_time = $currentObj->time;
             $punch_time = date("h:i:s A", strtotime($punch_time));
             $statuss  =($currentObj->state ==1)?'IN':'OUT';


 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $punch_time; 
            $row[] = $statuss; 
             
            $row[] = '';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->attendance_history_model->count_all(),
                        "recordsFiltered" => $this->attendance_history_model->count_filtered(),
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
        $result = $this->attendance_history_model->save($insertData);
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
            redirect('admin/attendance');
        }

          $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_users'] = $this->admin_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $data['all_roles'] = $this->role_model->findDynamic($where);

        $data['edit_data'] = $this->attendance_history_model->find($id);
        $this->global['pageTitle'] = 'Role Edit ';
        $this->loadViews("admin/admin-roles//edit", $this->global, $data , NULL);
        
    }   
   

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->attendance_history_model->delete($delId); 
            
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
                $returnData             = $this->attendance_history_model->findDynamic($where);


                 
            


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
                
                
             

                $result = $this->attendance_history_model->save($insertData);
                

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