<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Content extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/content_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isVendorLoggedIn();
        $this->global['pageTitle'] = 'Ale-izba : Page Content';
        $this->vendorView("vendor/content/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isVendorLoggedIn();
        $this->global['pageTitle'] = 'Ale-izba : Add New Page Content';
        $this->vendorView("vendor/content/addnew", $this->global, NULL , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isVendorLoggedIn();
		 $form_data  = $this->input->post();
		 
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('page_url','page_url','trim|required');
        $this->form_validation->set_rules('meta_title',' meta_title','required');
        $this->form_validation->set_rules('meta_keyword','meta_keyword','required');
        $this->form_validation->set_rules('meta_description','meta_description','required');
        $this->form_validation->set_rules('content','content','required');
        
        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
			$insertData['page_url'] = $form_data['page_url'];
            $insertData['meta_title'] = $form_data['meta_title'];
            $insertData['meta_keyword'] = $form_data['meta_keyword'];
            $insertData['meta_description'] = $form_data['meta_description'];
            $insertData['content'] = $form_data['content'];
            $insertData['date_at'] = date("Y-m-d H:i:s");
            $insertData['status'] =  '1';

            $result = $this->content_model->save($insertData);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Page Content successfully Added');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Page Content Addition failed');
            }
            redirect('vendor/content/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
        $list = $this->content_model->get_datatables();
		
       
        $data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $date_at = date("d-m-Y", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->page_url;
            $row[] = $currentObj->meta_title;
            $row[] = $date_at;
            $row[] = $currentObj->status==1?'Active':'InActive';
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/content/edit/'.$currentObj->id.'"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->content_model->count_all(),
                        "recordsFiltered" => $this->content_model->count_filtered(),
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
            redirect('vendor/content');
        }

        
        $data['edit_data'] = $this->content_model->find($id);
        $this->global['pageTitle'] = 'Ale-izba : Edit Page Content';
        $this->vendorView("vendor/content/edit", $this->global, $data , NULL);
        
        
    } 

    // Update Members *************************************************************
    public function update()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('page_url','page_url','trim|required');
        $this->form_validation->set_rules('meta_title',' meta_title','required');
        $this->form_validation->set_rules('meta_keyword','meta_keyword','required');
        $this->form_validation->set_rules('meta_description','meta_description','required');
        $this->form_validation->set_rules('content','content','required');
		
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
                $this->edit($form_data['id']);
        }
        else
        {
            $insertData['id'] = $form_data['id'];
            $insertData['page_url'] = $form_data['page_url'];
            $insertData['meta_title'] = $form_data['meta_title'];
            $insertData['meta_keyword'] = $form_data['meta_keyword'];
            $insertData['meta_description'] = $form_data['meta_description'];
            $insertData['content'] = $form_data['content'];
            $insertData['update_at'] = date("Y-m-d H:i:s");
            $insertData['status'] =  '1';
            $insertData['status'] =  $form_data['status'];

            $result = $this->content_model->save($insertData);

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Page Content successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Page content Updation failed');
            }
            redirect('vendor/content/edit/'.$insertData['id']);
          }  
        
    }

    // Delete Member *****************************************************************
      function delete()
    {
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
        $result = $this->content_model->delete($delId);           
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }
    
    
}

?>