<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Salespipeline extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/agency_model');
       $this->load->model('admin/type_model');
       $this->load->model('admin/salespipeline_contact_model');
       $this->load->model('admin/contact_note_model');
       $this->load->model('admin/contact_task_model');

       

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
        $data['listNationality']  = $this->type_model->listNationality();

        //  listSecure
        $data['listSecure']  = $this->type_model->listSecure();

        //RoleList 
        $data['RoleList']  = $this->type_model->RoleList();

        
        //get total list of contact 
        $data['get_contact_lists']  = $this->salespipeline_contact_model->get_contact_list();


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
		$list = $this->salespipeline_contact_model->get_datatables();
		
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
            $row[] = "<span class='table-row contact_profile' data-profile_id='".$currentObj->id."' > ".$currentObj->FirstName."</span>";
            $row[] = $currentObj->LastName;
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

    // Insert contact table
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
            $returnData = $this->salespipeline_contact_model->findDynamic($where);
            if(!empty($returnData)){
                 $response = array(
                    'status' => 'error',
                    'message' => "<h3>".$form_data['FirstName']." already Exist.</h3>"
                );
               
            }else{
               
                $insertData = array();

                $insertData['Salutation']   = $form_data['Salutation'];
                $insertData['FirstName']    = $form_data['FirstName'];;
                $insertData['LastName']     = $form_data['LastName'];;
                $insertData['Email']        = $form_data['Email']; 
                $insertData['Mobile']       = $form_data['Mobile'];
                $insertData['AlternateMobile']=$form_data['AlternateMobile'];
                $insertData['TypeOFContact']= (isset($form_data['TypeOFContact'])) ? $form_data['TypeOFContact'] : "0";
                $insertData['Role']         =  $form_data['Role'];
                $insertData['Nationality']  = $form_data['Nationality'];
                $insertData['ContactSource']= $form_data['ContactSource'];
                $insertData['ContactAssignTo']=$form_data['ContactAssignTo'];
                $insertData['status']       = '1';
                $insertData['date_at']      = date("Y-m-d H:i:s");


                $result = $this->salespipeline_contact_model->save($insertData);
                 
                
                if($result > 0)
                {
                     $response = array(
                        'status' => 'success',
                        'message' => "<h3 >Contact Details Added successfully.</h3>"
                    );
                }
                else
                { 
                    $response = array(
                        'status' => 'error',
                        'message' => "<h3>Contact Details Addition failed.</h3>"
                    );
                }
            }// check already    
            
          }  
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        
    }


    //to get and edit instant contact details 
    public function get_contact_profile($id)
    {
         $this->isVendorLoggedIn();
        
        $result = $this->salespipeline_contact_model->get_contact_list();
        
        if(!empty($result))
        {



            $response = array(
                        'status' => 'success',
                        'message' =>  $result
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
    //to get and edit instant contact details 
    public function get_contact_detail($id)
    {
         $this->isVendorLoggedIn();
        
        $resultobj = $this->salespipeline_contact_model->get_contact_detail($id);
        $result = $resultobj[0];
          
        if(!empty($result))
        {


            $RoleList = $this->type_model->RoleList();
            $listAssignTo = $this->type_model->listAssignTo();
            $listSecure = $this->type_model->listSecure();

            
            $Role = $result->Role;
            $ContactSource = $result->ContactSource;
            $ContactAssignTo = $result->ContactAssignTo;
            $SalutationId = $result->Salutation;
            $NationalityId = $result->Nationality;
            $TypeOFContactId = $result->TypeOFContact;

            $RoleName = $RoleList[$Role];
            $SourceName = $listSecure[$ContactSource];
            $AssignToName = $listAssignTo[$ContactAssignTo];
 
           
            

            $row = [];
            $row['FirstName'] =$result->FirstName;
            $row['LastName'] =$result->LastName;
            $row['Email'] = $result->Email;
            $row['Mobile'] = $result->Mobile;
            $row['AlternateMobile'] = $result->AlternateMobile;

            $row['RoleName'] = $RoleName;
            $row['ContactSource'] = $SourceName;
            $row['ContactAssignTo'] = $AssignToName;
            
            $row['ContactSourceId'] = $ContactSource;
            $row['RoleNameId']      = $RoleName;
            $row['ContactAssignToId'] = $ContactAssignTo;
            $row['ContactSourceId'] = $ContactSource;
            $row['SalutationId'] = $SalutationId;
            $row['NationalityId'] = $NationalityId;
            $row['TypeOFContactId'] = $TypeOFContactId;



            
             
            


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

    public function update_contact_detail()
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

                $insertData = array();
                if(isset($form_data['ContactID']) && $form_data['ContactID'] !=='')
                {
                    $insertData['id']   = $form_data['ContactID'];
                }
                
                $insertData['Salutation']   = $form_data['Salutation'];
                $insertData['FirstName']    = $form_data['FirstName'];;
                $insertData['LastName']     = $form_data['LastName'];;
                $insertData['Email']        = $form_data['Email']; 
                $insertData['Mobile']       = $form_data['Mobile'];
                $insertData['AlternateMobile']=$form_data['AlternateMobile'];
                $insertData['TypeOFContact']= (isset($form_data['TypeOFContact'])) ? $form_data['TypeOFContact'] : "0";
                $insertData['Role']         =  $form_data['Role'];
                $insertData['Nationality']  = $form_data['Nationality'];
                $insertData['ContactSource']= $form_data['ContactSource'];
                $insertData['ContactAssignTo']=$form_data['ContactAssignTo'];
                $insertData['update_at']      = date("Y-m-d H:i:s");

                $result = $this->salespipeline_contact_model->save($insertData);
                 
                
                if($result > 0)
                {
                     $response = array(
                        'status' => 'success',
                        'message' => "<h3 >Contact Details Updated successfully.</h3>"
                    );
                }
                else
                { 
                    $response = array(
                        'status' => 'error',
                        'message' => "<h3>Contact Details Updation failed.</h3>"
                    );
                }
              
            
          }  
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // Insert contact note
    public function insert_contact_note()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('contact_note','Note','trim|required');
         
         
        
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

                $insertData['contact_note']   = $form_data['contact_note'];
                $insertData['contact_id']=$form_data['hiddenNoteContactId'] ;               
                $insertData['status']       = '1';
                $insertData['date_at']      = date("Y-m-d H:i:s");

                $result = $this->contact_note_model->save($insertData);
                 
                
                if($result > 0)
                {
                     $response = array(
                        'status' => 'success',
                        'message' => "<h3 >Contact Note Added successfully.</h3>"
                    );
                }
                else
                { 
                    $response = array(
                        'status' => 'error',
                        'message' => "<h3>Contact Note Addition failed.</h3>"
                    );
                }
              
            
          }  
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        
    }
    // Insert contact note
    public function insert_contact_task()
    {
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('task_type','Type','required');
        $this->form_validation->set_rules('due_date','Due Date','trim|required');
        $this->form_validation->set_rules('due_time','Time','required');
        $this->form_validation->set_rules('staff_id','Staff','required');
        $this->form_validation->set_rules('task_status','Status','required');
        $this->form_validation->set_rules('task_status','hiddenTaskContactId','required');
         
         
        
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

                $insertData['type']         = $form_data['task_type'];
                $insertData['due_date']     = $form_data['due_date'];
                $insertData['due_time']     = $form_data['due_time'];
                $insertData['staff_id']     = $form_data['staff_id'];
                $insertData['contact_note'] = $form_data['contact_task_note'];
                $insertData['contact_id'] = $form_data['hiddenTaskContactId'];
                $insertData['status']       = $form_data['task_status'];
                $insertData['date_at']      = date("Y-m-d H:i:s");

                $result = $this->contact_task_model->save($insertData);
                 
                
                if($result > 0)
                {
                     $response = array(
                        'status' => 'success',
                        'message' => "<h3 >Contact Note Added successfully.</h3>"
                    );
                }
                else
                { 
                    $response = array(
                        'status' => 'error',
                        'message' => "<h3>Contact Note Addition failed.</h3>"
                    );
                }
              
            
          }  
          $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        
    }

     
     public function get_task_contact($id)
    {
         $this->isVendorLoggedIn();
        
        $result = $this->contact_task_model->get_task_contact($id);
        
        //print_r($result);
        if(!empty($result))
        {
                $response = array(
                        'status' => 'success',
                        'message' =>  $result
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

    public function get_note_contact($id)
    {
         $this->isVendorLoggedIn();
        
        $result = $this->contact_note_model->get_note_contact($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

}

?>