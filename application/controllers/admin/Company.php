<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Company extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/admin_model');
       $this->load->model('admin/company_model');
       $this->load->model('admin/state_model');
       $this->load->model('admin/district_model');
       $this->load->model('admin/country_model');
       $this->load->model('admin/city_model');
       $role = $this->session->userdata('role');
       if($role==1)
        {
             
        }else
        {
            $this->session->set_flashdata('error', 'Un-Authorized Page Access !');
             redirect(base_url().'admin', 'refresh');
        }
       $this->perPage =100; 
    }

    
    public function index()
    {
        $this->isLoggedIn();
        $this->global['module_id']      = get_module_byurl('admin/company');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $data = array();
        $this->global['pageTitle'] = 'Company';
        $this->loadViews("admin/company/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
        $role = $this->session->userdata('role');
        $this->isLoggedIn();

        $this->global['module_id']      = get_module_byurl('admin/company');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->create !=='create')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $data = array();
            
            $where  = array();
            $where['status']        = '1';
            $where['country_id']    = 105;
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['states'] = $this->state_model->findDynamic($where); 

 

        $this->global['pageTitle'] = 'Add New Comapny';
        $this->loadViews("admin/company/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		$role = $this->session->userdata('role');
         
        
		 $userid = $this->session->userdata('userId');
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('phone','phone','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required');
        $this->form_validation->set_rules('state','State','trim|required');
         
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {


                 // check already exist
                $form_data['name'] = strtolower($form_data['name']);
                $form_data['title'] = ucwords($form_data['name']);
                $where = array();
                 
                $where['email']          =  $form_data['email'];
                
                $returnData = $this->company_model->findDynamic($where);
 
              if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['email'].' already Exist.');
            }else{

                
            $insertData['name']         = $form_data['name'];
            $insertData['title']         = $form_data['title'];
            $insertData['email']         = $form_data['email'];
            $insertData['phone']       = $form_data['phone'];
            $insertData['city']      = $form_data['city'];
            $insertData['other_city']   = $form_data['other_city'];
            $insertData['state']    = $form_data['state'];
            $insertData['other_state'] = $form_data['other_state'];
            $insertData['other_district']= $form_data['other_district'];
            $insertData['district']  = $form_data['district'];
            $insertData['date_at']      = date("Y-m-d H:i:s");;
            $insertData['status']       = $form_data['status1'];
            $insertData['website']       = $form_data['website'];
            $insertData['gst_no']       = $form_data['gst_no'];
            $insertData['pan_no']       = $form_data['pan_no'];
            $insertData['nursury_address']      = $form_data['nursury_address'];
            $insertData['office_address']      = $form_data['office_address'];
            $insertData['bank_name']      = $form_data['bank_name'];
            $insertData['bank_branch_address']      = $form_data['bank_branch_address'];
            $insertData['bank_account_number']      = $form_data['bank_account_number'];
            $insertData['bank_holder_name']      = $form_data['bank_holder_name'];
            $insertData['bank_ifsc_code']      = $form_data['bank_ifsc_code'];
            $insertData['created_by']      = $userid;
            $social_url = array();
             
            if(isset($form_data['link_socials_value']) && !empty($form_data['link_socials_value']))
            {
                 for ($i=0; $i < count($form_data['link_socials_value']); $i++){ 
                     if(strlen($form_data['link_socials_value'][$i]) >0 && strlen($form_data['socials_keys'][$i])> 0){
                        $singledata = array();
                        $singledata['title'] = ucwords(strtolower($form_data['socials_keys'][$i]));
                        $singledata['url'] = (($form_data['link_socials_value'][$i]));
                        $social_url[] = $singledata;
                     }
                 }
            }
             $insertData['social_url']      =  json_encode($social_url);
              
            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != '') {

                $f_name         =$_FILES['logo']['name'];
                $f_tmp          =$_FILES['logo']['tmp_name'];
                $f_size         =$_FILES['logo']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="assets/admin/images/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Logo Upload Failed .');
                     $insertData['logo'] = 'logo.png';
                }
                else
                {
                   $insertData['logo'] = $f_newfile;
                   
                }
             }
                 if(isset($_FILES['seal_logo']['name']) && $_FILES['seal_logo']['name'] != '') {

                $f_name         =$_FILES['seal_logo']['name'];
                $f_tmp          =$_FILES['seal_logo']['tmp_name'];
                $f_size         =$_FILES['seal_logo']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="assets/admin/images/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Seal Logo Upload Failed .');
                     $insertData['seal_logo'] = 'seal-logo.png';
                }
                else
                {
                   $insertData['seal_logo'] = $f_newfile;
                   
                }
             }
                 
    			$result = $this->company_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Company successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Company Addition failed');
                }
            }// check already    
            redirect(base_url().'admin/company');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
         

		$list = $this->company_model->get_datatables();
		$this->global['module_id']      = get_module_byurl('admin/company');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
         

		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        $role = $this->session->userdata('role');
        $img_path = base_url()."assets/admin/images/";
        foreach ($list as $currentObj) {

            // $temp_date = $currentObj->date_at;
            $active = ($currentObj->status == 1)?" selected ":"";
            $inactive = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn" name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1" '.$active.'>Active</option>';
            $btn .= '<option value="0" '.$inactive.' >Inactive</option>';
            $btn .= '</select>';
            
            $no++;
            $temp_date = $currentObj->date_at;
            $dateAt = date("d-m-Y H:ia", strtotime($temp_date));

            $edit_btn =(@$action_requred->edit=='edit')?'<a class="btn btn-sm btn-info" href="'.base_url().'admin/company/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;':'';
            $delete_btn =(@$action_requred->delete=='delete')?'<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>':'';
            

            $social_urls = '';
            $social_url = json_decode($currentObj->social_url);
            if(!empty($social_url)) 
            {
                foreach ($social_url as  $value) {
                    
                    $social_urls.="<a href='".$value->url."'>".$value->title."</a>,";
                }
                
            }
            $seal_logo = '';
            if(isset($currentObj->seal_logo))
            {
                $seal_logo = "<a href='".$img_path.$currentObj->seal_logo."' download='seal-logo.png'><img class='img-thumbnail' src='".$img_path.$currentObj->seal_logo."'   ></a>";
            } 

            $logo = '';
            if(isset($currentObj->logo))
            {
                $logo = "<a href='".$img_path.$currentObj->logo."' download='seal-logo.png'><img class='img-thumbnail' src='".$img_path.$currentObj->logo."'   ></a>";
            }


                $row = array();
                
                 $row[] = $edit_btn.$delete_btn;
                $row[] = $currentObj->id;
                $row[] = $currentObj->title;
                $row[] = $logo;
                $row[] = $seal_logo;
                
                $row[] = $currentObj->phone;
                $row[] = $currentObj->email;
                $row[] = $currentObj->website;
                $row[] = $currentObj->gst_no;
                $row[] = $currentObj->pan_no;
                $row[] = $currentObj->nursury_address;
                $row[] = $currentObj->office_address;
                $row[] = $currentObj->state_name;
                $row[] = $currentObj->district_name;
                $row[] = $currentObj->city_name;
                $row[] = $currentObj->bank_name;
                $row[] = $currentObj->bank_account_number;
                $row[] = $currentObj->bank_holder_name;
                $row[] = $currentObj->bank_ifsc_code;
                $row[] = $currentObj->bank_branch_address;
                $row[] = $social_urls;
                $row[] = $dateAt;

           
 
            $row[] = $btn;
           
           /* $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/company/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';*/
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->company_model->count_all(),
                        "recordsFiltered" => $this->company_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Status Change
 
    public function statusChange($id = NULL)
    {
        $this->isLoggedIn();
        if($_POST['id'] == null)
        {
            redirect('admin/city');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->company_model->save($insertData);
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();
        $role = $this->session->userdata('role');
         
        $this->global['module_id']      = get_module_byurl('admin/company');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->edit !=='edit')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }


        

        if($id == null)
        {
            redirect('admin/agents');
        }

        $data = array();
        $data['edit_data'] = $this->company_model->find($id);


            

             $where  = array();
            $where['status']        = '1';
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['states'] = $this->state_model->findDynamic($where); 

            
             $where  = array();
            $where['status']        = '1';
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['companies'] = $this->company_model->findDynamic($where); 
        

        
        $this->global['pageTitle'] = 'Edit Agents';
        $this->loadViews("admin/company/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->company_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		 $this->isLoggedIn();
        
       $role = $this->session->userdata('role');
         
        
         $userid = $this->session->userdata('userId');
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('phone','phone','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required');
        $this->form_validation->set_rules('state','State','trim|required');
         
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($form_data['id']);
        }
        else
        {


                 // check already exist
                $form_data['name'] = strtolower($form_data['name']);
                $form_data['title'] = ucwords($form_data['name']);
                $where = array();
                 
                $where['email']          =  $form_data['email'];
                $where['id !=']          =  $form_data['id'];
                
                $returnData = $this->company_model->findDynamic($where);
 
              if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['email'].' already Exist.');
            }else{

            $insertData['id']               = $form_data['id'];
            $insertData['name']             = $form_data['name'];
            $insertData['title']            = $form_data['title'];
            $insertData['email']            = $form_data['email'];
            $insertData['phone']            = $form_data['phone'];
            $insertData['city']             = $form_data['city'];
            $insertData['other_city']       = $form_data['other_city'];
            $insertData['state']            = $form_data['state'];
            $insertData['other_state']      = $form_data['other_state'];
            $insertData['other_district']   = $form_data['other_district'];
            $insertData['district']         = $form_data['district'];
            $insertData['update_at']        = date("Y-m-d H:i:s");;
            $insertData['status']           = $form_data['status1'];
            $insertData['website']          = $form_data['website'];
            $insertData['gst_no']           = $form_data['gst_no'];
            $insertData['pan_no']           = $form_data['pan_no'];
            $insertData['nursury_address']  = $form_data['nursury_address'];
            $insertData['office_address']   = $form_data['office_address'];
            $insertData['bank_name']        = $form_data['bank_name'];
            $insertData['bank_branch_address']= $form_data['bank_branch_address'];
            $insertData['bank_account_number']= $form_data['bank_account_number'];
            $insertData['bank_holder_name'] = $form_data['bank_holder_name'];
            $insertData['bank_ifsc_code']   = $form_data['bank_ifsc_code'];
            $insertData['updated_by']       = $userid;

             $social_url = array();
             
            if(isset($form_data['link_socials_value']) && !empty($form_data['link_socials_value']))
            {
                 for ($i=0; $i < count($form_data['link_socials_value']); $i++){ 
                     if(strlen($form_data['link_socials_value'][$i]) >0 && strlen($form_data['socials_keys'][$i])> 0){
                        $singledata = array();
                        $singledata['title'] = ucwords(strtolower($form_data['socials_keys'][$i]));
                        $singledata['url'] = (($form_data['link_socials_value'][$i]));
                        $social_url[] = $singledata;
                     }
                 }
            }
             $insertData['social_url']      =  json_encode($social_url);


            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != '') {

                $f_name         =$_FILES['logo']['name'];
                $f_tmp          =$_FILES['logo']['tmp_name'];
                $f_size         =$_FILES['logo']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="assets/admin/images/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Logo Upload Failed .');
                     $insertData['logo'] = 'logo.png';
                }
                else
                {
                   $insertData['logo'] = $f_newfile;
                   
                }
             }
                 if(isset($_FILES['seal_logo']['name']) && $_FILES['seal_logo']['name'] != '') {

                $f_name         =$_FILES['seal_logo']['name'];
                $f_tmp          =$_FILES['seal_logo']['tmp_name'];
                $f_size         =$_FILES['seal_logo']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="assets/admin/images/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Seal Logo Upload Failed .');
                     $insertData['seal_logo'] = 'seal-logo.png';
                }
                else
                {
                   $insertData['seal_logo'] = $f_newfile;
                   
                }
             }
                 
                $result = $this->company_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Company successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Company Addition failed');
                }
            }// check already    
            redirect(base_url().'admin/company');
          }  
        
    }

    
    
    
}

?>