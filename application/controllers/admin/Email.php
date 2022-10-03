<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Email extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/email_model');
        $this->load->library('email_service');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'zenostrategics : Email';
        $this->loadViews("admin/email/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function compose()
    {
        $this->isLoggedIn();
        // get service list
        $where = array();
        $where['table'] = 'zs_services';
        $where['field'] = 'id,service_name';
        $where['service_status'] = '1';
        $data['service_list'] = $this->email_model->findDynamic($where);
       
        $this->global['pageTitle'] = 'zenostrategics : Compose New Email';
        $this->loadViews("admin/email/compose", $this->global, $data , NULL);
        
    } 

    // Insert Video *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('services','Select services','trim|required');
        $this->form_validation->set_rules('services_status','Select Services Status','trim|required');
        $this->form_validation->set_rules('subject','Subject','trim|required');
        $this->form_validation->set_rules('message','Message','trim|required');
                       
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
                $this->compose();
        }
        else
        {
            // Get services Clieng email ****************************
            // write find query for customer emails
            $customer_email = 'bk@delimp.com';
            
            //*******************************************************


            $insertData['email_to'] = $customer_email;
            $insertData['email_from'] = 'info@delimp.com';
            $insertData['email_subject'] = $form_data['subject'];
            $insertData['email_message'] = $form_data['message'];
            $insertData['email_at'] = date("Y-m-d H:i:s");
            $insertData['email_status'] = '0';
            
            // attachment Upload
            if(isset($_FILES['attachment_file']['name']) && $_FILES['attachment_file']['name'] != '') {

                $f_name         =$_FILES['attachment_file']['name'];
                $f_tmp          =$_FILES['attachment_file']['tmp_name'];
                $f_size         =$_FILES['attachment_file']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="uploads/mail_attachment/".$f_newfile;
               
                if(!move_uploaded_file($f_tmp,$store))
                {
                     $this->session->set_flashdata('error', 'attachment Updation Failed Try again');
                }
                else
                {
                   $insertData['email_attachment'] = $f_newfile;
                  
                }
             } 
            

            // Mail Function  Argument Data 
            $data = array();
            $data['detail'] = $insertData;
            $response = $this->email_service->email_send($data);
            if($response)
            {
                $insertData['email_status'] = '1';
            }
            $result = $this->email_model->save($insertData);
            if($result > 0 )
            {
                if($response)
                {
                    $this->session->set_flashdata('success', 'Successfully Email Sent.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Email Sending Failed.');
                }
            }
            else
            { 
                $this->session->set_flashdata('error', 'Email Sending Failed.');
            }
            redirect('admin/email/compose');
          }  
        
    }


    // email list
    public function ajax_list()
    {
        $list = $this->email_model->get_datatables();
        $data = array();
       
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {
            $temp_date = $currentObj->email_at;
            $email_at = date("m-d-Y", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->email_to;
            $row[] = $currentObj->email_subject;
            $row[] = $currentObj->email_message;
            $row[] = $email_at;
            $row[] = $currentObj->email_status==1?'Sent':'Failed';
            $row[] = '<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->email_model->count_all(),
                        "recordsFiltered" => $this->email_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Delet Eamail *****************************************************************
      function delete()
    {
        $this->isLoggedIn();
        $userId = $this->input->post('id');  
        $email = $this->email_model->find($userId);
        //Unlink File
       $old_file = "uploads/mail_attachment/".$email->email_attachment;
       if (file_exists($old_file)) {   
        unlink($old_file);                       
        }
       
        $result = $this->email_model->delete($userId);           
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }
    
    
}

?>