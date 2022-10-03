<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Salespipeline extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/agency_model');
       $this->load->model('admin/type_model');

    }

    
    public function index()
    {
        $this->isVendorLoggedIn();

        $data = array();

        //SalutaionList 
        $data['SalutaionList']      = $this->type_model->SalutaionList();
        
        //list assignto 
        $data['listAssignTo']  = $this->type_model->listAssignTo();
        //TypeList
        $data['TypeList']  = $this->type_model->getTypeList();
        //Type of contact
        $data['listTypeOfContact']  = $this->type_model->listTypeOfContact();

        //  listContactStatus
        $data['listContactStatus']  = $this->type_model->listContactStatus();

        //  listNationality
        $data['listNationality']  = $this->type_model->listContactStatus();

        //  listSecure
        $data['listSecure']  = $this->type_model->listSecure();

        //RoleList 
        $data['RoleList']  = $this->type_model->RoleList();

        $this->global['pageTitle'] = 'Salespipeline : Ale-izba';
        $this->vendorView("vendor/salespipeline/contact", $this->global, $data , NULL);
        
    }

    // lead management
    public function leadmanagement()
    {
        $this->isVendorLoggedIn();

        $data = array();

        //  listSecure
        $data['LeadPurposeList']  = $this->type_model->LeadPurposeList();

        $this->global['pageTitle'] = 'Salespipeline : Ale-izba';
        $this->vendorView("vendor/salespipeline/leadmanagement", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isVendorLoggedIn();
        $data = array();
        $this->global['pageTitle'] = 'Add New Agency : Ale-izba';
        $this->vendorView("vendor/salespipeline/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isVendorLoggedIn();
		
		
		
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

            // check already exist
            $where = array();
            $where['name'] = $form_data['name'];
            $returnData = $this->agency_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{
                //pre($form_data);exit;
                $insertData['name'] = $form_data['name'];
                $insertData['description'] = base64_encode($form_data['description']);
                $insertData['email'] = $form_data['email'];
                $insertData['mobile'] = $form_data['mobile'];
                $insertData['phone'] = $form_data['phone'];
                $insertData['fax_number'] = $form_data['fax_number'];
                $insertData['language'] = $form_data['language'];
                $insertData['tax_number'] = $form_data['tax_number'];
                $insertData['address'] = $form_data['address'];
                $insertData['license'] = $form_data['license'];
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
                    $store          ="uploads/salespipeline/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'thumb Upload Failed .');
                    }
                    else
                    {
                       $insertData['img'] = $f_newfile;
                       
                    }
                 }
                 
    			$result = $this->agency_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Salespipeline successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Salespipeline Addition failed');
                }
            }// check already    
            redirect('vendor/salespipeline/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->agency_model->get_datatables();
		
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
            $row[] = '<img src ="'.base_url().'uploads/salespipeline/'.$currentObj->img.'" width="30" alt = "Ale-izba"/>';
            $row[] = $currentObj->name;
            $row[] = $currentObj->email;
            $row[] = $currentObj->mobile."/".$currentObj->phone;
            $row[] = $currentObj->address;
            $row[] = $dateAt;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/salespipeline/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->agency_model->count_all(),
                        "recordsFiltered" => $this->agency_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Status Change
 
    public function statusChange($id = NULL)
    {
        $this->isVendorLoggedIn();
        if($_POST['id'] == null)
        {
            redirect('vendor/agency');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->agency_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isVendorLoggedIn();
        if($id == null)
        {
            redirect('vendor/agency');
        }

        $data['edit_data'] = $this->agency_model->find($id);
        $this->global['pageTitle'] = 'Salespipeline ';
        $this->vendorView("vendor/salespipeline/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->agency_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Agency*************************************************************
    public function update()
    {
		
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Salespipeline','trim|required');
        
        
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
            $insertData['email'] = $form_data['email'];
            $insertData['mobile'] = $form_data['mobile'];
            $insertData['phone'] = $form_data['phone'];
            $insertData['fax_number'] = $form_data['fax_number'];
            $insertData['language'] = $form_data['language'];
            $insertData['tax_number'] = $form_data['tax_number'];
            $insertData['address'] = $form_data['address'];
            $insertData['license'] = $form_data['license'];
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
                $store          ="uploads/salespipeline/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Flag Upload Failed .');
                }
                else
                {
					$file = "uploads/salespipeline/".$form_data['old_img'];
					if(file_exists ( $file))
					{
						unlink($file);
					}
					$insertData['img'] = $f_newfile;
                   
                }
             }

            $result = $this->agency_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Agency successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Salespipeline Updation failed');
            }
            redirect('vendor/salespipeline/edit/'.$insertData['id']);
          }  
        
    }

    // Insert Member *************************************************************
    public function insertcontact()
    {
        $this->isVendorLoggedIn();
        
        
        
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('FirstName','First Name','trim|required');
        $this->form_validation->set_rules('LastName','Last Name','trim|required');
        $this->form_validation->set_rules('Mobile','Mobile','required');
        $this->form_validation->set_rules('TypeOFContact','Type Of Contact','required');
        $this->form_validation->set_rules('ContactAssignTo','Assign To','required');
         
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {

             $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );

            
        }
        else
        {

            // check already exist
            $where = array();
            $where['FirstName'] = $form_data['FirstName'];
            $where['LastName'] = $form_data['LastName'];
            $returnData = $this->agency_model->findDynamic($where);
            if(!empty($returnData)){
                 $response = array(
                    'status' => 'error',
                    'message' => $form_data['FirstName'].''.$form_data['LastName'].' already Exist.';
                );
            }else{
                //pre($form_data);exit;
                $insertData['name'] = $form_data['name'];
                $insertData['description'] = base64_encode($form_data['description']);
                $insertData['email'] = $form_data['email'];
                $insertData['mobile'] = $form_data['mobile'];
                $insertData['phone'] = $form_data['phone'];
                $insertData['fax_number'] = $form_data['fax_number'];
                $insertData['language'] = $form_data['language'];
                $insertData['tax_number'] = $form_data['tax_number'];
                $insertData['address'] = $form_data['address'];
                $insertData['license'] = $form_data['license'];
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
                    $store          ="uploads/salespipeline/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'thumb Upload Failed .');
                    }
                    else
                    {
                       $insertData['img'] = $f_newfile;
                       
                    }
                 }
                 
                $result = $this->agency_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Salespipeline successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Salespipeline Addition failed');
                }
            }// check already    
            redirect('vendor/salespipeline/addnew');
          }  
        
    }
    
    
}

?>