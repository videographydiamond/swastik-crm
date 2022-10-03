<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Plan extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/plan_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Ale-izba : Plans';
        $this->loadViews("admin/plan/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Ale-izba : Add New Plan';
        $this->loadViews("admin/plan/addnew", $this->global, NULL , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		 $form_data  = $this->input->post();
		 
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('price',' Price','trim|required');
        $this->form_validation->set_rules('service1','Service1','trim|required');
        $this->form_validation->set_rules('service2','Service2','trim');
        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
			$insertData['name'] = $form_data['name'];
            $insertData['price'] = $form_data['price'];
            $insertData['service1'] = $form_data['service1'];
            $insertData['service2'] = $form_data['service2'];
            $insertData['desc'] = $form_data['desc'];
            $insertData['date_at'] = date("Y-m-d H:i:s");
            $insertData['status'] =  '1';

            $result = $this->plan_model->save($insertData);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'New Plan successfully Added');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Plan Addition failed');
            }
            redirect('admin/plan/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
        $list = $this->plan_model->get_datatables();
		
       
        $data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $date_at = date("d-m-Y", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->name;
            $row[] = $currentObj->price;
            $row[] = $currentObj->service1;
            $row[] = $currentObj->service2;
            $row[] = $date_at;
            $row[] = $currentObj->status==1?'Active':'InActive';
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/plan/edit/'.$currentObj->id.'"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->plan_model->count_all(),
                        "recordsFiltered" => $this->plan_model->count_filtered(),
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
        $this->isLoggedIn();
        if($id == null)
        {
            redirect('admin/plan');
        }

        
        $data['edit_data'] = $this->plan_model->find($id);
        $this->global['pageTitle'] = 'Ale-izba : Edit Plan';
        $this->loadViews("admin/plan/edit", $this->global, $data , NULL);
        
        
    } 

    // Update Members *************************************************************
    public function update()
    {
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('price',' Price','trim|required');
        $this->form_validation->set_rules('service1','Service1','trim|required');
        $this->form_validation->set_rules('service2','Service2','trim');
		
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
                $this->edit($form_data['id']);
        }
        else
        {
            $insertData['id'] = $form_data['id'];
            $insertData['name'] = $form_data['name'];
            $insertData['price'] = $form_data['price'];
            $insertData['service1'] = $form_data['service1'];
            $insertData['service2'] = $form_data['service2'];
            $insertData['desc'] = $form_data['desc'];
            $insertData['date_at'] = date("Y-m-d H:i:s");
            $insertData['status'] =  $form_data['status'];

            $result = $this->plan_model->save($insertData);

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Plan successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Plan Updation failed');
            }
            redirect('admin/plan/edit/'.$insertData['id']);
          }  
        
    }

    // Delete Member *****************************************************************
      function delete()
    {
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        $result = $this->plan_model->delete($delId);           
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }
    
    
}

?>