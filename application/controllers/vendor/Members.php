<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Members extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/members_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isVendorLoggedIn();
        $this->global['pageTitle'] = 'Ale-izba : Members';
        $this->vendorView("vendor/members/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isVendorLoggedIn();
        $this->global['pageTitle'] = 'Ale-izba : Add New Members';
        $this->vendorView("vendor/members/addnew", $this->global, NULL , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isVendorLoggedIn();
		 $form_data  = $this->input->post();
		 
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('admin_type','Admin Type','trim|required');
        $this->form_validation->set_rules('name',' Name','trim');
        $this->form_validation->set_rules('phone','Phone Number','trim');
        $this->form_validation->set_rules('email','Email Address','trim|required');
        $this->form_validation->set_rules('address','Address','trim');
        $this->form_validation->set_rules('password','Password','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
			// check already added or not 
			$where =  array();
			$where['email'] = $form_data['email'];
			$db_data = $this->members_model->findDynamic($where);
			if(count($db_data) > 0)
			{
				$this->session->set_flashdata('error', 'Email Id Alrady Registerd ..');
				redirect('vendor/members/addnew');
				exit;
			}
			
			
            $insertData['admin_type'] = $form_data['admin_type'];
            $insertData['name'] = $form_data['name'];
            $insertData['email'] = $form_data['email'];
            $insertData['phone'] = $form_data['phone'];
            $insertData['address'] = $form_data['address'];
            $insertData['password'] = $form_data['password'];
            $insertData['date_at'] = date("Y-m-d H:i:s");
            $insertData['status'] =  $form_data['status'];

            $result = $this->members_model->save($insertData);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'New Member successfully Added');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Member Addition failed');
            }
            redirect('vendor/members/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
        $list = $this->members_model->get_datatables();
       
        $data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $date_at = date("d-m-Y", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->admin_type==1?'Administator':'Sub Admin';
            $row[] = $currentObj->name;
            $row[] = $currentObj->email;
            $row[] = $currentObj->phone;
            $row[] = $date_at;
            $row[] = $currentObj->status==1?'Active':'InActive';
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/members/edit/'.$currentObj->id.'"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->members_model->count_all(),
                        "recordsFiltered" => $this->members_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Edit
    // Add New 
    public function edit($id = NULL)
    {
        
        //exit;
        $this->isVendorLoggedIn();
        if($id == null)
        {
            redirect('vendor/members');
        }

        
        $data['edit_data'] = $this->members_model->find($id);
        $this->global['pageTitle'] = 'Ale-izba : Edit Members';
        $this->vendorView("vendor/members/edit", $this->global, $data , NULL);
        
        
    } 

    // Update Members *************************************************************
    public function update()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('admin_type','Admin Type','trim|required');
        $this->form_validation->set_rules('name',' Name','trim');
        $this->form_validation->set_rules('phone','Phone Number','trim');
        $this->form_validation->set_rules('email','Email Address','trim|required');
        $this->form_validation->set_rules('address','Address','trim');
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('id','Id','trim|required');
		
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
                $this->edit($form_data['id']);
        }
        else
        {
            $insertData['id'] = $form_data['id'];
            $insertData['admin_type'] = $form_data['admin_type'];
            $insertData['name'] = $form_data['name'];
            $insertData['email'] = $form_data['email'];
            $insertData['phone'] = $form_data['phone'];
            $insertData['address'] = $form_data['address'];
            $insertData['password'] = $form_data['password'];
            $insertData['date_at'] = date("Y-m-d H:i:s");
            $insertData['status'] =  $form_data['status'];

            $result = $this->members_model->save($insertData);

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Members successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Members Updation failed');
            }
            redirect('vendor/members/edit/'.$insertData['id']);
          }  
        
    }

    // Delete Member *****************************************************************
      function delete()
    {
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
        $result = $this->members_model->delete($delId);           
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }
    
    
}

?>