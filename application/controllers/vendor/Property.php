<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Property extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/property_model');
    }

    
    public function index()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Property : Ale-izba';
        $this->vendorView("vendor/property/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isVendorLoggedIn();
        $data = array();

       
        $where  = array();
        $where['table']  = 'rc_rel_agent';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agentList'] = $this->property_model->findDynamic($where);

        $where  = array();
        $where['table']  = 'rc_rel_agency';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agencyList'] = $this->property_model->findDynamic($where);

        $this->global['pageTitle'] = 'Add New Property : Ale-izba';
        $this->vendorView("vendor/property/addnew", $this->global, $data , NULL);
        
    } 

    // Insert  *************************************************************
    public function insertnow()
    {
        $form_data  = $this->input->post();
        
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
            $returnData = $this->property_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{

                $insertData['name'] = $form_data['name'];
                $insertData['price'] = $form_data['price'];
                $insertData['second_price'] = $form_data['second_price'];
                $insertData['price_prefix'] = $form_data['price_prefix'];
                $insertData['price_suffix'] = $form_data['price_suffix'];
                $insertData['area_size'] = $form_data['area_size'];
                $insertData['area_size_postfix'] = $form_data['area_size_postfix'];
                $insertData['land_area'] = $form_data['land_area'];
                $insertData['land_area_size_postfix'] = $form_data['land_area_size_postfix'];
                $insertData['rooms'] = $form_data['rooms'];
                $insertData['bedrooms'] = $form_data['bedrooms'];
                $insertData['bathrooms'] = $form_data['bathrooms'];
                $insertData['garages'] = $form_data['garages'];
                $insertData['garage_size'] = $form_data['garage_size'];
                $insertData['year_built'] = $form_data['year_built'];
                $insertData['property_id'] = $form_data['property_id'];
                $insertData['map_show'] = $form_data['map_show'];
                $insertData['street_view'] = $form_data['street_view'];
                $insertData['address'] = $form_data['address'];
                $insertData['street_address'] = $form_data['street_address'];
                $insertData['zip'] = $form_data['zip'];
                $insertData['mark_properties'] = $form_data['mark_properties'];
                $insertData['must_logged'] = $form_data['must_logged'];
                $insertData['desclaimer'] = $form_data['desclaimer'];
                $insertData['video_url'] = base64_encode($form_data['video_url']);
                $insertData['virtual_url'] = base64_encode($form_data['virtual_url']);
                $insertData['contact_info'] = $form_data['contact_info'];
                $insertData['contact_info_agent_id'] = $form_data['contact_info_agent_id'];
                $insertData['contact_info_agency_id'] = $form_data['contact_info_agency_id'];
                $insertData['diplay_slider'] = isset($form_data['diplay_slider'])?$form_data['diplay_slider']:'';
                $insertData['floor_plan_title'] = $form_data['floor_plan_title'];
                $insertData['floor_plan_bedrooms'] = $form_data['floor_plan_bedrooms'];
                $insertData['floor_plan_bathrooms'] = $form_data['floor_plan_bathrooms'];
                $insertData['floor_plan_price'] = $form_data['floor_plan_price'];
                $insertData['floor_plan_price_postfix'] = $form_data['floor_plan_price_postfix'];
                $insertData['floor_plan_size'] = $form_data['floor_plan_size'];
                $insertData['floor_plan_description'] = $form_data['floor_plan_description'];
                $insertData['private_note'] = $form_data['private_note'];
                $insertData['energy_class'] = $form_data['energy_class'];
                $insertData['energy_performance'] = $form_data['energy_performance'];
                $insertData['renewal_energy_performance'] = $form_data['renewal_energy_performance'];
                $insertData['energy_performance_building'] = $form_data['energy_performance_building'];
                $insertData['epc_current_rating'] = $form_data['epc_current_rating'];
                $insertData['epc_potential_rating'] = $form_data['epc_potential_rating'];
                $insertData['property_top_type'] = $form_data['property_top_type'];
                $insertData['property_content_layout'] = $form_data['property_content_layout'];
                $insertData['descripton'] = $form_data['descripton'];
                $insertData['status'] = 1;
                $insertData['date_at'] = date("Y-m-d H:i:s");
                $insertData['upload_by'] = "admin";
                $insertData['user_id'] = $this->session->userdata('userId');
    			 
                $i = 0;
                $media = array();
                while($i < 20)
                {
                    if(isset($_FILES['media'.$i]['name']) && $_FILES['media'.$i]['name'] != '') {

                        $f_name         =$_FILES['media'.$i]['name'];
                        $f_tmp          =$_FILES['media'.$i]['tmp_name'];
                        $f_size         =$_FILES['media'.$i]['size'];
                        $f_extension    =explode('.',$f_name);
                        $f_extension    =strtolower(end($f_extension));
                        $f_newfile      =uniqid().'.'.$f_extension;
                        $store          ="uploads/property/".$f_newfile;
                    
                        if(!move_uploaded_file($f_tmp,$store))
                        {
                            $this->session->set_flashdata('error', 'Media Upload Failed .');
                        }
                        else
                        {
                           $media[$i] = $f_newfile;
                        }
                     }else{
                        break;
                     }
                     $i++;
                }// while end
                $insertData['img'] = (isset($media[0]))?$media[0]:'';
                $insertData['media'] = json_encode($media, true);
                // document
                $i = 0;
                $document = array();
                while($i < 20)
                {
                    if(isset($_FILES['document'.$i]['name']) && $_FILES['document'.$i]['name'] != '') {

                        $f_name         =$_FILES['document'.$i]['name'];
                        $f_tmp          =$_FILES['document'.$i]['tmp_name'];
                        $f_size         =$_FILES['document'.$i]['size'];
                        $f_extension    =explode('.',$f_name);
                        $f_extension    =strtolower(end($f_extension));
                        $f_newfile      =uniqid().'.'.$f_extension;
                        $store          ="uploads/propertydocs/".$f_newfile;
                    
                        if(!move_uploaded_file($f_tmp,$store))
                        {
                            $this->session->set_flashdata('error', 'document Upload Failed .');
                        }
                        else
                        {
                           $document[$i] = $f_newfile;
                        }
                     }else{
                        break;
                     }
                     $i++;
                }// while end
                $insertData['document'] = json_encode($document, true);


                // slider image
                if(isset($_FILES['slider_image']['name']) && $_FILES['slider_image']['name'] != '') {

                    $f_name         =$_FILES['slider_image']['name'];
                    $f_tmp          =$_FILES['slider_image']['tmp_name'];
                    $f_size         =$_FILES['slider_image']['size'];
                    $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="uploads/property/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'Slider image Upload Failed .');
                    }
                    else
                    {
                       $insertData['slider_img'] = $f_newfile;
                    }
                }

                 // Floor plan image
                if(isset($_FILES['floor_plan_img']['name']) && $_FILES['floor_plan_img']['name'] != '') {

                    $f_name         =$_FILES['floor_plan_img']['name'];
                    $f_tmp          =$_FILES['floor_plan_img']['tmp_name'];
                    $f_size         =$_FILES['floor_plan_img']['size'];
                    $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="uploads/property/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'Slider image Upload Failed .');
                    }
                    else
                    {
                       $insertData['floor_plan_img'] = $f_newfile;
                    }
                }
              
                
                 
    			$result = $this->property_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Property successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Property Addition failed');
                }
            }// check already 
            redirect('vendor/property/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
        $list = $this->property_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $dateAt = date("dMY H:ia", strtotime($temp_date));
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn" name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img src ="'.base_url().'uploads/property/'.$currentObj->img.'" width="100" alt = "Ale-izba"/>';
            $row[] = $currentObj->name;
            $row[] = $currentObj->price_prefix." ".$currentObj->price;
            $row[] = $currentObj->area_size." ".$currentObj->area_size_postfix;
            $row[] = $currentObj->rooms;
            $row[] = $currentObj->address;
            $row[] = $dateAt;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/property/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->property_model->count_all(),
                        "recordsFiltered" => $this->property_model->count_filtered(),
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
            redirect('vendor/property');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->property_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        $this->isVendorLoggedIn();
        
        if($id == null)
        {
            redirect('vendor/property');
        }
       
        $where  = array();
        $where['table']  = 'rc_rel_agent';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agentList'] = $this->property_model->findDynamic($where);

        $where  = array();
        $where['table']  = 'rc_rel_agency';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agencyList'] = $this->property_model->findDynamic($where);

        $data['edit_data'] = $this->property_model->find($id);
        $this->global['pageTitle'] = 'Property ';
        $this->vendorView("vendor/property/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->property_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Property','trim|required');
        $this->form_validation->set_rules('id','Id','trim|required');
        
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
                $insertData['second_price'] = $form_data['second_price'];
                $insertData['price_prefix'] = $form_data['price_prefix'];
                $insertData['price_suffix'] = $form_data['price_suffix'];
                $insertData['area_size'] = $form_data['area_size'];
                $insertData['area_size_postfix'] = $form_data['area_size_postfix'];
                $insertData['land_area'] = $form_data['land_area'];
                $insertData['land_area_size_postfix'] = $form_data['land_area_size_postfix'];
                $insertData['rooms'] = $form_data['rooms'];
                $insertData['bedrooms'] = $form_data['bedrooms'];
                $insertData['bathrooms'] = $form_data['bathrooms'];
                $insertData['garages'] = $form_data['garages'];
                $insertData['garage_size'] = $form_data['garage_size'];
                $insertData['year_built'] = $form_data['year_built'];
                $insertData['property_id'] = $form_data['property_id'];
                $insertData['map_show'] = $form_data['map_show'];
                $insertData['street_view'] = $form_data['street_view'];
                $insertData['address'] = $form_data['address'];
                $insertData['street_address'] = $form_data['street_address'];
                $insertData['zip'] = $form_data['zip'];
                $insertData['mark_properties'] = $form_data['mark_properties'];
                $insertData['must_logged'] = $form_data['must_logged'];
                $insertData['desclaimer'] = $form_data['desclaimer'];
                $insertData['video_url'] = base64_encode($form_data['video_url']);
                $insertData['virtual_url'] = base64_encode($form_data['virtual_url']);
                $insertData['contact_info'] = $form_data['contact_info'];
                $insertData['contact_info_agent_id'] = $form_data['contact_info_agent_id'];
                $insertData['contact_info_agency_id'] = $form_data['contact_info_agency_id'];
                $insertData['diplay_slider'] = isset($form_data['diplay_slider'])?$form_data['diplay_slider']:'';
                $insertData['floor_plan_title'] = $form_data['floor_plan_title'];
                $insertData['floor_plan_bedrooms'] = $form_data['floor_plan_bedrooms'];
                $insertData['floor_plan_bathrooms'] = $form_data['floor_plan_bathrooms'];
                $insertData['floor_plan_price'] = $form_data['floor_plan_price'];
                $insertData['floor_plan_price_postfix'] = $form_data['floor_plan_price_postfix'];
                $insertData['floor_plan_size'] = $form_data['floor_plan_size'];
                $insertData['floor_plan_description'] = $form_data['floor_plan_description'];
                $insertData['private_note'] = $form_data['private_note'];
                $insertData['energy_class'] = $form_data['energy_class'];
                $insertData['energy_performance'] = $form_data['energy_performance'];
                $insertData['renewal_energy_performance'] = $form_data['renewal_energy_performance'];
                $insertData['energy_performance_building'] = $form_data['energy_performance_building'];
                $insertData['epc_current_rating'] = $form_data['epc_current_rating'];
                $insertData['epc_potential_rating'] = $form_data['epc_potential_rating'];
                $insertData['property_top_type'] = $form_data['property_top_type'];
                $insertData['property_content_layout'] = $form_data['property_content_layout'];
                $insertData['descripton'] = $form_data['descripton'];
                $insertData['status'] = $form_data['status'];
                $insertData['update_at'] = date("Y-m-d H:i:s");
                $insertData['update_by'] = $this->session->userdata('userId');
                 
                $i = 0;
                $media = array();
                while($i < 20)
                {
                    if(isset($_FILES['media'.$i]['name']) && $_FILES['media'.$i]['name'] != '') {

                        $f_name         =$_FILES['media'.$i]['name'];
                        $f_tmp          =$_FILES['media'.$i]['tmp_name'];
                        $f_size         =$_FILES['media'.$i]['size'];
                        $f_extension    =explode('.',$f_name);
                        $f_extension    =strtolower(end($f_extension));
                        $f_newfile      =uniqid().'.'.$f_extension;
                        $store          ="uploads/property/".$f_newfile;
                    
                        if(!move_uploaded_file($f_tmp,$store))
                        {
                            $this->session->set_flashdata('error', 'Media Upload Failed .');
                        }
                        else
                        {
                           $media[$i] = $f_newfile;
                        }
                     }
                     $i++;
                }// while end
                // this function for array serialize 
                $mdiaArr =  array();
                if(!empty($media)){
                    foreach ($media as $v) {
                        $mdiaArr[] = $v;
                    }
                }
                if(isset($form_data['media_old']) && !empty($form_data['media_old'])){
                       foreach ($form_data['media_old'] as $v) {
                            $mdiaArr[] = $v;
                        } 
                    }

                $insertData['img'] = (isset($mdiaArr[0]))?$mdiaArr[0]:'';
                $insertData['media'] = json_encode($mdiaArr, true);
                // document
                $i = 0;
                $document = array();
                while($i < 20)
                {
                    if(isset($_FILES['document'.$i]['name']) && $_FILES['document'.$i]['name'] != '') {

                        $f_name         =$_FILES['document'.$i]['name'];
                        $f_tmp          =$_FILES['document'.$i]['tmp_name'];
                        $f_size         =$_FILES['document'.$i]['size'];
                        $f_extension    =explode('.',$f_name);
                        $f_extension    =strtolower(end($f_extension));
                        $f_newfile      =uniqid().'.'.$f_extension;
                        $store          ="uploads/propertydocs/".$f_newfile;
                    
                        if(!move_uploaded_file($f_tmp,$store))
                        {
                            $this->session->set_flashdata('error', 'document Upload Failed .');
                        }
                        else
                        {
                           $document[$i] = $f_newfile;
                        }
                     }
                     $i++;
                }// while end
                // this function for array serialize 
                if(!empty($document)){
                    $documentArr =  array();
                    foreach ($document as $v) {
                        $documentArr[] = $v;
                    }
                }
                if(isset($form_data['document_old']) && !empty($form_data['document_old'])){
                   foreach ($form_data['document_old'] as $v) {
                        $documentArr[] = $v;
                    } 
                }
                $insertData['document'] = json_encode($documentArr, true);


                // slider image
                if(isset($_FILES['slider_image']['name']) && $_FILES['slider_image']['name'] != '') {

                    $f_name         =$_FILES['slider_image']['name'];
                    $f_tmp          =$_FILES['slider_image']['tmp_name'];
                    $f_size         =$_FILES['slider_image']['size'];
                    $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="uploads/property/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'Slider image Upload Failed .');
                    }
                    else
                    {
                       $insertData['slider_img'] = $f_newfile;
                    }
                }else{
                    $insertData['slider_img'] = $form_data['slider_img_old'];
                }

                 // Floor plan image
                if(isset($_FILES['floor_plan_img']['name']) && $_FILES['floor_plan_img']['name'] != '') {

                    $f_name         =$_FILES['floor_plan_img']['name'];
                    $f_tmp          =$_FILES['floor_plan_img']['tmp_name'];
                    $f_size         =$_FILES['floor_plan_img']['size'];
                    $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="uploads/property/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'Slider image Upload Failed .');
                    }
                    else
                    {
                       $insertData['floor_plan_img'] = $f_newfile;
                    }
                }else{
                    $insertData['floor_plan_img'] = $form_data['floor_plan_img_old'];
                }

            $result = $this->property_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Property successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Property Updation failed');
            }
            redirect('vendor/property/edit/'.$insertData['id']);
          }  
        
    }

    
    
    
}

?>