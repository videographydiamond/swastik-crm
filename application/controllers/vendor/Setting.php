<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Setting extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
          $this->load->model('admin/type_model');
          $this->load->model('admin/settingprofile_model');
          $this->load->model('admin/managetemplate_model');
          $this->load->model('admin/mailinglist_model');
          $this->load->model('admin/password_model');
        

     }

    
    public function index()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $this->global['pageTitle']  = 'Profile Settings : Al-eizba';


        $this->vendorView("vendor/setting/profile", $this->global, $data , NULL);
        
    }

      public function profile()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $this->global['pageTitle']  = 'Profile Settings : Al-eizba';


        $this->vendorView("vendor/setting/profile", $this->global, $data , NULL);
        
    }

    public function manage_template()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $data['listEmailTempType']    = $this->type_model->listEmailTempType();
        $this->global['pageTitle']  = 'Manage Templates : Al-eizba';


        $this->vendorView("vendor/setting/manage_templates", $this->global, $data , NULL);
        
    }


    public function mailing_lists()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $this->global['pageTitle']  = 'Mailing Lists : Al-eizba';


        $this->vendorView("vendor/setting/mailing_lists", $this->global, $data , NULL);
        
    }

    public function image_bank()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listAssignTo']    = $this->type_model->listAssignTo();
        $this->global['pageTitle']  = 'Image Bank : Al-eizba';


        $this->vendorView("vendor/setting/image_bank", $this->global, $data , NULL);
        
    }

    public function floor_plan_bank()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $this->global['pageTitle']  = 'Floor Plan Bank : Al-eizba';


        $this->vendorView("vendor/setting/floor_plan_bank", $this->global, $data , NULL);
        
    }

    public function email_notification()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $data['listNationality']    = $this->type_model->listNationality();
        $data['reminderEmail']    = $this->type_model->reminderEmail();
        $data['instantEmail']    = $this->type_model->instantEmail();
        $this->global['pageTitle']  = 'Email Notification : Al-eizba';


        $this->vendorView("vendor/setting/email_notification", $this->global, $data , NULL);
        
    }

    public function password()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle']  = 'Password : Al-eizba';
 
         $data['user_data']= $this->password_model->find($_SESSION['userId']);


        $this->vendorView("vendor/setting/password", $this->global, $data , NULL);
        
    }




    // Add Setting Profile
    public function add_setting_profile()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('ProfileEmail','Profile Email','required');
        $this->form_validation->set_rules('ProfileName','Profile Name','required');
        $this->form_validation->set_rules('ProfilePrimaryNoFirst','Profile Primary No First','required');
        $this->form_validation->set_rules('ProfilePrimaryNoSecond','Profile Primary No Second','required');
        $this->form_validation->set_rules('ProfilePrimaryNoThird','Profile Primary No Third','required');
        $this->form_validation->set_rules('ProfileCountry','Profile Country','required');



        //Form data 
        $form_data  = $this->input->post(); 
        if($this->form_validation->run() == FALSE)
        {

            $this->profile();

            // Ajax Code Not Working
            //$response = array(
                //'status' => 'error',
                //'message' => validation_errors()
            //);
        }
        else
        {
            $insertData = array();
                if(isset($form_data['settingProfileID']) && $form_data['settingProfileID'] !=='')
                {
                    $insertData['id']   = $form_data['settingProfileID'];
                }

                // Fields Details



                $insertData['ProfileEmail']        = $form_data['ProfileEmail'];
                $insertData['ProfileBRN']     = $form_data['ProfileBRN'];
                $insertData['ProfileName']       = $form_data['ProfileName'];
                $insertData['ProfileNameAr']       = $form_data['ProfileNameAr'];
                $insertData['ProfileAboutMeEn']         = $form_data['ProfileAboutMeEn'];
                $insertData['ProfileAboutMeAr']         = $form_data['ProfileAboutMeAr'];
                

                $insertData['ProfilePrimaryNoFirst'] = $form_data['ProfilePrimaryNoFirst'];
                $insertData['ProfilePrimaryNoSecond']= $form_data['ProfilePrimaryNoSecond'];
                $insertData['ProfilePrimaryNoThird']= $form_data['ProfilePrimaryNoThird'];
                
                $insertData['ProfileSecondaryNoFirst'] = $form_data['ProfileSecondaryNoFirst'];
                $insertData['ProfileSecondaryNoSecond'] = $form_data['ProfileSecondaryNoSecond'];

                 
                $insertData['ProfileFaxFirst']    = $form_data['ProfileFaxFirst'];
                $insertData['ProfileFaxSecond']   = $form_data['ProfileFaxSecond'];
                $insertData['ProfileFaxThird']    = $form_data['ProfileFaxThird'];

                $insertData['ProfileZipCode']    = $form_data['ProfileZipCode'];
                $insertData['ProfileAddress']    = $form_data['ProfileAddress'];
                $insertData['ProfileCountry']    = $form_data['ProfileCountry'];
                $insertData['ProfileNotify'] = (isset($form_data['ProfileNotify']) && $form_data['ProfileNotify'] !=='')? $form_data['ProfileNotify']:'';
                
                $insertData['date_at']          = date("Y-m-d H:i:s");
 


 
                $result = $this->settingprofile_model->save($insertData);
                 
                
                if($result > 0)
                {

                     $this->session->set_flashdata('success', 'New profile added successfully');

                     // Ajax Code Not Working
                     //$response = array(
                        //'status' => 'success',
                        //'message' => "<h3 >Profile Added successfully.</h3>"
                    //);
                }
                else
                { 

                    $this->session->set_flashdata('error', 'Profile Addition failed');

                    // Ajax Code Not Working
                    //$response = array(
                        //'status' => 'error',
                        //'message' => "<h3>Profile Addition failed.</h3>"
                    //);
                }

                redirect('vendor/setting/profile');

                 } 

                 // Ajax Code Not Working 
                //$this->output
                    //->set_content_type('application/json')
                    //->set_output(json_encode($response));
        }


    // Setting Profile Details End


        // Add Manage Template
        public function add_setting_template()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('ProfileTitle','Profile Title','required');
        $this->form_validation->set_rules('ProfileTemplateType','Profile Template Type','required');
        
        $this->form_validation->set_rules('ProfileContentEn','Content English','required');
        $this->form_validation->set_rules('ProfileContentAr','Content Arabic','required');

         //Form data 
        $form_data  = $this->input->post(); 
        if($this->form_validation->run() == FALSE)
        {

            $this->manage_template();

        }
        else
        {
            $insertData = array();
                if(isset($form_data['settingTempID']) && $form_data['settingTempID'] !=='')
                {
                    $insertData['id']   = $form_data['settingTempID'];
                }
            }

        // Fields Details

                $insertData['ProfileTitle']        = $form_data['ProfileTitle'];
                $insertData['ProfileTemplateType']        = $form_data['ProfileTemplateType'];
                $insertData['ProfileContentEn']       = $form_data['ProfileContentEn'];
                $insertData['ProfileContentAr']         = $form_data['ProfileContentAr'];

                $insertData['date_at']          = date("Y-m-d H:i:s");

                $result = $this->managetemplate_model->save($insertData);

                if($result > 0)
                {

                     $this->session->set_flashdata('success', 'New template added successfully');

                }

                redirect('vendor/setting/manage_template');

                }
        // End Manage Template

        // Add Mailing List
                public function add_setting_mailingList()
            {
                $this->isVendorLoggedIn();
                $this->load->library('form_validation');            
                $this->form_validation->set_rules('MailingListName','Mailing List Name','required');
                $this->form_validation->set_rules('MailingContacts','Mailing Contacts','required');

                //Form data 
                $form_data  = $this->input->post(); 
                if($this->form_validation->run() == FALSE)
                {

                    $this->mailing_lists();

                }
                else
                {
                    $insertData = array();
                        if(isset($form_data['settingMailID']) && $form_data['settingMailID'] !=='')
                        {
                            $insertData['id']   = $form_data['settingMailID'];
                        }
                    }

                // Fields Details
                $insertData['MailingListName']        = $form_data['MailingListName'];
                $insertData['MailingContacts']        = $form_data['MailingContacts'];

                $insertData['date_at']          = date("Y-m-d H:i:s");

                $result = $this->mailinglist_model->save($insertData);

                if($result > 0)
                {

                     $this->session->set_flashdata('success', 'New mailing list added successfully');

                }

                redirect('vendor/setting/mailing_lists');

                }

        // End Mailing List



                // Password Confirm Field End


                public function setting_updatePassword()
                {
                    $this->isVendorLoggedIn();
                    $this->load->library('form_validation');            
                    $this->form_validation->set_rules('SettingPassword','Current Password','required');

                    $this->form_validation->set_rules('SettingNewPassword', 'New-Password', 'required');
                    $this->form_validation->set_rules('SettingConfirmPassword','Confirm-Password','required|matches[SettingNewPassword]');
                    
                    
                    //Form data 
                    $form_data  = $this->input->post();
                    if($this->form_validation->run() == FALSE)
                    {
                            
                          $this->password();
                             
                        
                    }
                    else
                    {

                            $pre_existPass = $form_data['hiddenPassword'];
                            $check_Pass = md5($form_data['SettingPassword']);
                             if ($pre_existPass== $check_Pass) 
                             {
                              

                                    $user_id = $_SESSION['userId'];

                                    
                                    //Field Details
                                    $insertData = array();
                                    $insertData['id']       = $user_id;
                                    $insertData['password']   =  md5($form_data['SettingConfirmPassword']);

                                    $insertData['updateat']          = date("Y-m-d H:i:s");

                                    $result = $this->password_model->save($insertData);
                            }
                            
                    }   

                            if($result > 0)
                            {

                                $this->session->set_flashdata('success', 'Password updated successfully');

                            }


                            redirect('vendor/setting/password');
                       
                }


                // Password Confirm Field End



        // Member Setting Template List


     public function ajax_mailingTemp_list()
    {
        $list = $this->managetemplate_model->get_datatables();
        $listEmailTempType = $this->type_model->listEmailTempType();
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
            $row[] = '<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">';
            $row[]= $currentObj->id;
            $row[] = $currentObj->ProfileTitle;
            $row[] = (isset($listEmailTempType[$currentObj->ProfileTemplateType]))? $listEmailTempType[$currentObj->ProfileTemplateType]:"";
            

            $row[] = '<span class="action_link"   onclick="editStaff('.$currentObj->id.')" ><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i><i class="fa fa-trash fa-2x" aria-hidden="true"></i></span>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->managetemplate_model->count_all(),
                        "recordsFiltered" => $this->managetemplate_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

            //End Member List

    
 

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


}




?>