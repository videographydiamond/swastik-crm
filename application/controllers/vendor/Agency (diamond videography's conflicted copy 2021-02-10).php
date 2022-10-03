<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Agency extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/agency_model');
       $this->load->model('admin/staff_model');
        $this->load->model('admin/type_model');
     }

    
    public function index()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $data['listAssignTo']       = $this->type_model->listAssignTo();
        $data['ActiveInactiveList']       = $this->type_model->ActiveInactiveList();
        $this->global['pageTitle']  = 'Manage Staff : Ale-izbac';


        $this->vendorView("vendor/agency/manage-staff", $this->global, $data , NULL);
        
    }
    public function managestaff()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $data['listAssignTo']       = $this->type_model->listAssignTo();
        $data['ActiveInactiveList']       = $this->type_model->ActiveInactiveList();

        $this->global['pageTitle'] = 'Manage Staff : Ale-izba';
        $this->vendorView("vendor/agency/manage-staff", $this->global, $data , NULL);
        
    }
    // manageteam
    public function manageteam()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Manage-team : Ale-izba';
        $this->vendorView("vendor/agency/manageteam", $this->global, $data , NULL);
        
    }
    // MarkettingPortal
    public function markettingportal()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Markettingportal : Ale-izba';
        $this->vendorView("vendor/agency/markettingportal", $this->global, $data , NULL);
        
    }
    // Wataermark setting
    public function wataermarksetting()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Wataermark Setting : Ale-izba';
        $this->vendorView("vendor/agency/watermark", $this->global, $data , NULL);
        
    }
    // Company profile
    public function companyprofile()
    {


        $this->isVendorLoggedIn();

        $data = array();

        //listCountry
        
        $data['listNationality']    = $this->type_model->listNationality();
        $this->global['pageTitle'] = 'Company profile : Ale-izba';
        $this->vendorView("vendor/agency/companyprofile", $this->global, $data , NULL);
        
    }
    // Agency Setting
    public function acencysetting()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Agency Setting : Ale-izba';
        $this->vendorView("vendor/agency/acencysetting", $this->global, $data , NULL);
        
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
            $row[] = '<img src ="'.base_url().'uploads/agency/'.$currentObj->img.'" width="30" alt = "Ale-izba"/>';
            $row[] = $currentObj->name;
            $row[] = $currentObj->email;
            $row[] = $currentObj->mobile."/".$currentObj->phone;
            $row[] = $currentObj->address;
            $row[] = $dateAt;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/agency/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
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
        $this->vendorView("vendor/agency/edit", $this->global, $data , NULL);
        
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
                $store          ="uploads/agency/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Flag Upload Failed .');
                }
                else
                {
					$file = "uploads/agency/".$form_data['old_img'];
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
            redirect('vendor/agency/edit/'.$insertData['id']);
          }  
        
    }

// Member list
    public function ajax_Staff_list()
    {
        $list = $this->staff_model->get_datatables();
        $listAssignTo = $this->type_model->listAssignTo();
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
            
            $row[] = $currentObj->StaffName;
            $row[] = '-';
            $row[] = $currentObj->StaffEmail;
            $row[] = $currentObj->StaffPrimaryTextFirst;
            $row[] = $currentObj->StaffSecondaryTextFirst;
            $row[] = (isset($listAssignTo[$currentObj->StaffTeam]))? $listAssignTo[$currentObj->StaffTeam]:"";
            $row[] = "0";
            $row[] = "0";
             
            
            // $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/agency/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $row[] = '<span class="action_link"   onclick="editStaff('.$currentObj->id.')" ><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></span> <span class="action_link" ><i class="fa fa-money fa-2x" ></i></span><span class="action_link" ><i class="fa fa-lock fa-2x" ></i></span><span class="action_link" ><i class="fa fa-trash fa-2x" aria-hidden="true"></i></span>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->staff_model->count_all(),
                        "recordsFiltered" => $this->staff_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    //add new staff member
     public function add_new_staff()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('StaffName','Name','required');
        $this->form_validation->set_rules('StaffEmail','Email','required');
        $this->form_validation->set_rules('StaffPassword','Password','required');

        $this->form_validation->set_rules('StaffRePassword', 'Re-Type', 'required|matches[StaffPassword]');
        $this->form_validation->set_rules('StaffRePassword','Re-Password','required');
        $this->form_validation->set_rules('StaffPrimaryTextFirst','Primary','required');
        
         
         
         
        
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

                $insertData = array();
                if(isset($form_data['StaffID']) && $form_data['StaffID'] !=='')
                {
                    $insertData['id']   = $form_data['StaffID'];
                }


                 
                $insertData['title']            = $form_data['StaffName'];
                $insertData['StaffName']        = $form_data['StaffName'];
                $insertData['NameInArabic']     = $form_data['NameInArabic'];
                $insertData['StaffEmail']       = $form_data['StaffEmail'];
                $insertData['StaffBRN']         = $form_data['StaffBRN'];
                $insertData['StaffTeam']        = $form_data['StaffTeam'];
                $insertData['StaffAboutYou']    = $form_data['StaffAboutYou'];
                $insertData['StaffTumbnail']   = (isset($form_data['StaffuploadImageName'])) ?  $form_data['StaffuploadImageName']: "";
                $insertData['StaffPrimaryTextFirst'] = $form_data['StaffPrimaryTextFirst'];
                $insertData['StaffPrimaryTextSecond']= $form_data['StaffPrimaryTextSecond'];
                $insertData['StaffPrimaryTextThird']= $form_data['StaffPrimaryTextThird'];
                
                $insertData['StaffSecondaryTextFirst'] = $form_data['StaffSecondaryTextFirst'];
                $insertData['StaffSecondaryTextSecond'] = $form_data['StaffSecondaryTextSecond'];
                 
                $insertData['StaffFaxFirst']    = $form_data['StaffFaxFirst'];
                $insertData['StaffFaxSecond']   = $form_data['StaffFaxSecond'];
                $insertData['StaffFaxThird']    = $form_data['StaffFaxThird'];

                $insertData['StaffAddress']     = $form_data['StaffAddress'];
                $insertData['StaffZip']         = $form_data['StaffZip'];
                $insertData['StaffNationality'] = $form_data['StaffNationality'];
                $insertData['status']           = $form_data['StaffIsActive'];
                $insertData['StaffSkype']       = $form_data['StaffSkype'];
                $insertData['StaffWhatsApp']    = $form_data['StaffWhatsApp'];
                $insertData['StaffPassport']    = $form_data['StaffPassport'];
                
                $insertData['date_at']          = date("Y-m-d H:i:s");

                $result = $this->staff_model->save($insertData);
                 
                
                if($result > 0)
                {
                     $response = array(
                        'status' => 'success',
                        'message' => "<h3>Staff Member Added Successfully.</h3>"
                    );
                }
                else
                { 
                    $response = array(
                        'status' => 'error',
                        'message' => "<h3>Staff Member Addition Failed.</h3>"
                    );
                }
             
            
               
               
              
            
          }  
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        
    }
    //to get and edit instant contact details 
    public function get_staff_detail($id)
    {
         $this->isVendorLoggedIn();
        
        $result = $this->staff_model->find($id);
        
        //print_r($result);
        if(!empty($result))
        {


            $RoleList = $this->type_model->RoleList();
            $listAssignTo = $this->type_model->listAssignTo();
            $listSecure = $this->type_model->listSecure();

             
            

            $row = [];
            $row['StaffName'] =$result->StaffName;
            $row['NameInArabic'] =$result->NameInArabic;
            $row['StaffEmail'] = $result->StaffEmail;
            $row['StaffBRN'] = $result->StaffBRN;
            $row['StaffPassword'] = $result->StaffPassword;
            $row['StaffAboutYou'] =  $result->StaffAboutYou;
            $row['StaffTumbnail'] = $result->StaffTumbnail;
            $row['StaffPrimaryTextFirst'] = $result->StaffPrimaryTextFirst;
            $row['StaffPrimaryTextSecond'] = $result->StaffPrimaryTextSecond;
            $row['StaffPrimaryTextThird'] = $result->StaffPrimaryTextThird;
            $row['StaffSecondaryTextFirst'] = $result->StaffSecondaryTextFirst;
            $row['StaffSecondaryTextSecond'] = $result->StaffSecondaryTextSecond;
            $row['StaffFaxFirst'] = $result->StaffFaxFirst;
            $row['StaffFaxSecond'] = $result->StaffFaxSecond;
            $row['StaffFaxThird'] = $result->StaffFaxThird;
            $row['StaffAddress'] = $result->StaffAddress;
            $row['StaffZip'] = $result->StaffZip;
            $row['StaffNationality'] = $result->StaffNationality;
            $row['StaffIsActive'] = $result->status;
            $row['StaffSkype'] = $result->StaffSkype;
            $row['StaffWhatsApp'] = $result->StaffWhatsApp;
            $row['StaffPassport'] = $result->StaffPassport;
            
            $response = array(
                        'status' => 'success',
                        'message' =>  $row
                    );
        }else
        {
             $response = array(
                        'status' => 'error',
                        'message' => "RECORD Not Found."
                    );
        }



        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



     //Add Company Profile Details
    public function add_company_profile()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('CompanyTitle','CompanyTitle','required');
        $this->form_validation->set_rules('CompanyEmail','Email','required');
        $this->form_validation->set_rules('CompanyCountry','Country','required');



        //Form data 
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
            $insertData = array();
                if(isset($form_data['compProfileID']) && $form_data['compProfileID'] !=='')
                {
                    $insertData['id']   = $form_data['compProfileID'];
                }

                // Fields Details

                $insertData['title']            = $form_data['CompanyTitle'];
                $insertData['CompanyTitle']        = $form_data['CompanyTitle'];
                $insertData['CompanyTitleInArabic']     = $form_data['CompanyTitleInArabic'];
                $insertData['CompanyEmail']       = $form_data['CompanyEmail'];
                $insertData['CompanyDescription']         = $form_data['CompanyDescription'];
                $insertData['CompanyLogo']   = (isset($form_data['CompanyPuploadImageName'])) ?  $form_data['CompanyPuploadImageName']: "";

                $insertData['CompanyPrimaryNoFirst'] = $form_data['CompanyPrimaryNoFirst'];
                $insertData['CompanyPrimaryNoSecond']= $form_data['CompanyPrimaryNoSecond'];
                $insertData['CompanyPrimaryNoThird']= $form_data['CompanyPrimaryNoThird'];
                
                $insertData['CompanySecondaryNoFirst'] = $form_data['CompanySecondaryNoFirst'];
                $insertData['CompanySecondaryNoSecond'] = $form_data['CompanySecondaryNoSecond'];

                $insertData['CompanyWebsite']  = $form_data['CompanyWebsite'];
                 
                $insertData['CompanyFaxFirst']    = $form_data['CompanyFaxFirst'];
                $insertData['CompanyFaxSecond']   = $form_data['CompanyFaxSecond'];
                $insertData['CompanyFaxThird']    = $form_data['CompanyFaxThird'];

                $insertData['CompanyAddress']    = $form_data['CompanyAddress'];
                $insertData['CompanyCountry']    = $form_data['CompanyCountry'];
                $insertData['CompanyState'] = $form_data['CompanyState'];
                $insertData['CompanyTradeLicense']   = $form_data['CompanyTradeLicense'];
                $insertData['CompanyORN']       = $form_data['CompanyORN'];
                
                $insertData['date_at']          = date("Y-m-d H:i:s");


                $result = $this->staff_model->save($insertData);
                 
                
                if($result > 0)
                {
                     $response = array(
                        'status' => 'success',
                        'message' => "<h3 >Company Profile Added successfully.</h3>"
                    );
                }
                else
                { 
                    $response = array(
                        'status' => 'error',
                        'message' => "<h3>Company Profile Addition failed.</h3>"
                    );
                }

                 }  
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
        }
    }


    // End Company Profile Details
    




?>