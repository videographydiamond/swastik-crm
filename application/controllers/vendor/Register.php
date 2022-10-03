<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Register extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/user_model');
    }

    
    public function index()
    {
        
        $data = array();
        $this->global['pageTitle'] = 'Add New Registration : Ale-izba';
        $this->load->view('vendor/register');
        
    }



    // Insert Member *************************************************************
    public function insertnow()
    {
        
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('fname', 'First Name', 'required');
         $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
         $this->form_validation->set_rules('phone', 'Mobile Number', 'required|numeric|min_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {

            // check already exist
            $where = array();
            $where['email'] = $form_data['email'];
            $returnData = $this->user_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['email'].' already Exist.');
            }else{
                //pre($form_data);exit;
                $insertData['fname'] = $form_data['fname'];
                $insertData['lname'] = $form_data['lname'];
                $insertData['email'] = $form_data['email'];
                $insertData['phone'] = $form_data['phone'];
                $insertData['password'] = md5($form_data['password']);
                $insertData['status'] = "1";
                $insertData['type'] = "2";
                $insertData['dateat'] = date("Y-m-d H:i:s");

              
                 
    			$result = $this->user_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Registration successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Registration  failed');
                }
            }// check already    
            redirect('vendor/register');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->user_model->get_datatables();
		
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
            $row[] = $no;
            $row[] = '<img src ="'.base_url().'uploads/register/'.$currentObj->img.'" width="30" alt = "Ale-izba"/>';
            $row[] = $currentObj->name;
            $row[] = $currentObj->email;
            $row[] = $currentObj->mobile."/".$currentObj->phone;
            $row[] = $currentObj->address;
            $row[] = $dateAt;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/register/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->user_model->count_all(),
                        "recordsFiltered" => $this->user_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Status Change
 
    public function statusChange($id = NULL)
    {
        if($_POST['id'] == null)
        {
            redirect('vendor/register');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->user_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        if($id == null)
        {
            redirect('vendor/register');
        }

        $data['edit_data'] = $this->user_model->find($id);
        $this->global['pageTitle'] = 'Registration ';
        $this->vendorView("vendor/register/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $delId = $this->input->post('id');  
        
        $result = $this->user_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Registration*************************************************************
    public function update()
    {
		
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Registration','trim|required');
        
        
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
                $insertData['description'] = base64_encode($form_data['description']);
                $insertData['short_description'] = base64_encode($form_data['short_description']);
                $insertData['email'] = $form_data['email'];
                $insertData['mobile'] = $form_data['mobile'];
                $insertData['phone'] = $form_data['phone'];
                $insertData['fax_number'] = $form_data['fax_number'];
                $insertData['language'] = $form_data['language'];
                $insertData['tax_number'] = $form_data['tax_number'];
                $insertData['address'] = $form_data['address'];
                $insertData['service_area'] = $form_data['service_area'];
                $insertData['position'] = $form_data['position'];
                $insertData['specialties'] = $form_data['specialties'];
                $insertData['whatsapp_number'] = $form_data['whatsapp_number'];
                $insertData['company_name'] = $form_data['company_name'];

                $insertData['website_url'] = base64_encode($form_data['website_url']);
                $insertData['social_media'] = base64_encode(json_encode($form_data['social_media'], true));
                $insertData['visibility_hide_show'] = $form_data['visibility_hide_show'];
                $insertData['slug'] = $form_data['slug'];
                $insertData['status'] = $form_data['status'];
                $insertData['date_at'] = date("Y-m-d H:i:s");
            
			
			if(isset($_FILES['img']['name']) && $_FILES['img']['name'] != '') {

				$f_name         =$_FILES['img']['name'];
                $f_tmp          =$_FILES['img']['tmp_name'];
                $f_size         =$_FILES['img']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="uploads/register/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Flag Upload Failed .');
                }
                else
                {
					$file = "uploads/register/".$form_data['old_img'];
					if(file_exists ( $file))
					{
						unlink($file);
					}
					$insertData['img'] = $f_newfile;
                   
                }
             }
             //company Logo
             if(isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name'] != '') {

                $f_name         =$_FILES['company_logo']['name'];
                $f_tmp          =$_FILES['company_logo']['tmp_name'];
                $f_size         =$_FILES['company_logo']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="uploads/company/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Flag Upload Failed .');
                }
                else
                {
                    $file = "uploads/company/".$form_data['old_company_logo'];
                    if(file_exists ( $file))
                    {
                        unlink($file);
                    }
                    $insertData['company_logo'] = $f_newfile;
                   
                }
             }

            $result = $this->user_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Registration successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Registration Updation failed');
            }
            redirect('vendor/register/edit/'.$insertData['id']);
          }  
        
    }

    
    
    
}

?>