<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Profile extends BaseController
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
       $this->perPage =100; 
    }

    
    public function index()
    {
        $this->isLoggedIn();
        $userid = $this->session->userdata('userId');
         $this->edit($userid );
        
    }

    

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();
        
        $userid = $this->session->userdata('userId');
        if($id == null)
        {
            $id = $this->session->userdata('userId');
            
        }else if($userid !=='')
        {
            
            $id = $this->session->userdata('userId');
        }else
        {
            redirect(base_url().'admin');
        }

        $data = array();
        $data['edit_data'] = $this->admin_model->find($id);


            

             $where  = array();
            $where['status']        = '1';
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['states'] = $this->state_model->findDynamic($where); 

            $this->global['pageTitle'] = 'Edit Profile';
            $this->loadViews("admin/profile/edit", $this->global, $data , NULL);
        
    }
    public function change_passowrd()
    {
        $this->isLoggedIn();
        $id = $this->session->userdata('userId');
        $data = array();
        $data['edit_data'] = $this->admin_model->find($id);
        $this->global['pageTitle'] = 'Change Password';
        $this->loadViews("admin/profile/change-passowrd", $this->global, $data , NULL);
        
    } 
   
    // Update category*************************************************************
    public function update_change_passowrd()
    {
		$this->isLoggedIn();
        $userid = $this->session->userdata('userId');
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('new_password','New Password','trim|required|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','trim|required');
         
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->change_passowrd();
        }
        else
        {

                $insertData = array();
                 
                $where = array();
                 
                $where['password']      =  $form_data['password'];
                $where['id =']          =  $form_data['id'];
                
                $returnData = $this->admin_model->findDynamic($where);
 
              if(empty($returnData)){
               $this->session->set_flashdata('error', $form_data['password'].' Password Not corrct');
               
                 $this->change_passowrd();
            }else{

            $insertData['id']               = $form_data['id'];
            $insertData['update_at']        = date("Y-m-d H:i:s");
            $insertData['password']         = $form_data['new_password'];
            $insertData['update_by']        = $userid;

                 
                $result = $this->admin_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Password successfully Update. Your need to Relogin');
                    redirect(base_url().'admin/login/logout');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Password Update failed');
                }
            }// check already    
            redirect(base_url().'admin/profile/change_passowrd');
          }  
        
        
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
         
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($form_data['id']);
        }
        else
        {

                $insertData = array();
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
                //redirect(base_url().'admin/profile/edit/'.$form_data['id']);
                 $this->edit($form_data['id']);
            }else{

            $insertData['id']         = $form_data['id'];
            $insertData['name']         = $form_data['name'];
            $insertData['title']         = $form_data['title'];
            $insertData['email']         = $form_data['email'];
            $insertData['phone']       = $form_data['mobile'];
            $insertData['pincode']      = $form_data['pincode'];
            $insertData['city_id']      = $form_data['city'];
            $insertData['state_id']    = $form_data['state'];
            $insertData['district_id']  = $form_data['district'];
            $insertData['update_at']      = date("Y-m-d H:i:s");
            $insertData['address']      = $form_data['address'];
            $insertData['update_by']      = $userid;

                 
                $result = $this->admin_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Profile successfully Update');
                    

                }
                else
                { 
                    $this->session->set_flashdata('error', 'Profile Update failed');
                }
            }// check already    
            redirect(base_url().'admin/profile');
          }  
        
        
    }

    
    
    
}

?>