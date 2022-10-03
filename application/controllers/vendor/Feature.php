<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Feature extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/feature_model');
    }

    
    public function index()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Feature : Ale-izba';
        $this->vendorView("vendor/feature/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isVendorLoggedIn();
        $data = array();

        
        

        $this->global['pageTitle'] = 'Add New Feature : Ale-izba';
        $this->vendorView("vendor/feature/addnew", $this->global, $data , NULL);
        
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
            $returnData = $this->feature_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{

                $insertData['name'] = $form_data['name'];
                $insertData['slug'] = $form_data['slug'];
                $insertData['status'] = $form_data['status'];
                if(isset($_FILES['img']['name']) && $_FILES['img']['name'] != '') {

                    $f_name         =$_FILES['img']['name'];
                    $f_tmp          =$_FILES['img']['tmp_name'];
                    $f_size         =$_FILES['img']['size'];
                    $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="assets/images/icon/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'Icon Upload Failed .');
                    }
                    else
                    {
                       $insertData['img'] = $f_newfile;
                       
                    }
                 }
    			
                 
    			$result = $this->feature_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Feature successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Feature Addition failed');
                }
            }// check already    
            redirect('vendor/feature/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
        
		$list = $this->feature_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            // $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn" name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img src ="'.base_url().'assets/images/icon/'.$currentObj->img.'" width="30" alt = "Ale-izba"/>';
            $row[] = $currentObj->name;
            $row[] = $currentObj->slug;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/feature/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->feature_model->count_all(),
                        "recordsFiltered" => $this->feature_model->count_filtered(),
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
            redirect('vendor/feature');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->feature_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isVendorLoggedIn();
        if($id == null)
        {
            redirect('vendor/feature');
        }
        
        

        $data['edit_data'] = $this->feature_model->find($id);
        $this->global['pageTitle'] = 'Feature ';
        $this->vendorView("vendor/feature/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->feature_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Feature','trim|required');
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
            $insertData['slug'] = $form_data['slug'];
            $insertData['status'] = $form_data['status'];
            if(isset($_FILES['img']['name']) && $_FILES['img']['name'] != '') {

                $f_name         =$_FILES['img']['name'];
                $f_tmp          =$_FILES['img']['tmp_name'];
                $f_size         =$_FILES['img']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="assets/images/icon/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Flag Upload Failed .');
                }
                else
                {
                    $file = "assets/images/icon/".$form_data['old_img'];
                    if(file_exists ( $file))
                    {
                        unlink($file);
                    }
                    $insertData['img'] = $f_newfile;
                   
                }
             }
            $result = $this->feature_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Feature successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Feature Updation failed');
            }
            redirect('vendor/feature/edit/'.$insertData['id']);
          }  
        
    }

    
    
    
}

?>