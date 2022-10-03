<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Email_template extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/email_template_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'zenostrategics : Email Template';
        $this->loadViews("admin/email_template/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'zenostrategics : Add New Members';
        $this->loadViews("admin/email_template/addnew", $this->global, NULL , NULL);
        
    } 

    // Insert Video *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('subject','Subject','trim|required');
        $this->form_validation->set_rules('message','Message','trim');
        $this->form_validation->set_rules('hint','Hint','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
                $this->addnew();
        }
        else
        {
            $insertData['name'] = $form_data['name'];
            $insertData['subject'] = $form_data['subject'];
            $insertData['message'] = $form_data['message'];
            $insertData['hint'] = $form_data['hint'];
            $insertData['status'] = $form_data['status'];
            $result = $this->email_template_model->save($insertData);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Email Template successfully Added');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Email Template Addition failed');
            }
            redirect('admin/email_template/addnew');
          }  
        
    }


    // Videos list
    public function ajax_list()
    {
        $list = $this->email_template_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $currentObj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->name;
            $row[] = $currentObj->subject;
            $row[] = $currentObj->status==1?'Active':'InActive';
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/email_template/edit/'.$currentObj->id.'"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->email_template_model->count_all(),
                        "recordsFiltered" => $this->email_template_model->count_filtered(),
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
            redirect('admin/email_template');
        }
        
        $data['edit_data'] = $this->email_template_model->find($id);
        $this->global['pageTitle'] = 'zenostrategics : Edit Members';
        $this->loadViews("admin/email_template/edit", $this->global, $data , NULL);
        
        
    } 

    // Update Members *************************************************************
    public function update()
    {
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('subject','Subject','trim|required');
        $this->form_validation->set_rules('message','Message','trim');
        $this->form_validation->set_rules('hint','Hint','trim|required');
        
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
            $insertData['subject'] = $form_data['subject'];
            $insertData['message'] = $form_data['message'];
            $insertData['hint'] = $form_data['hint'];
            $insertData['status'] = $form_data['status'];

            $result = $this->email_template_model->save($insertData);

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Email Template successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Email Template Updation failed');
            }
            redirect('admin/email_template/edit/'.$insertData['id']);
          }  
        
    }

    // Delet Video *****************************************************************
      function delete()
    {
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        $result = $this->email_template_model->delete($delId);           
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }
    
    
}

?>