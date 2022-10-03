<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Document_category extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/document_category_model');
       $this->load->model('admin/document_model');
       $this->load->model('admin/product_model');
        $this->load->model('admin/crop_model');


         $this->global['module_id']      = get_module_byurl('admin/document_category');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {

         $this->global['module_id']      = get_module_byurl('admin/document_category');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->view !=='view')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Document Category';
        $this->loadViews("admin/doc-category/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
        $this->isLoggedIn();

         $this->global['module_id']      = get_module_byurl('admin/document_category');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->create !=='create')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $where = array(); 
        $where['status'] = '1'; 
        $crop_list = $this->crop_model->findDynamic($where);
        $data['crop_lists'] =  $crop_list;

        $this->global['pageTitle'] = 'Add New Category';
        $this->loadViews("admin/doc-category/addnew", $this->global,  $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('crop_id','Crop','trim|required');
        $this->form_validation->set_rules('name','Category','trim|required');
         
        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {

            $form_data['name'] = ($form_data['name']);
            $form_data['title'] = ($form_data['name']);

             
            $form_data['slug'] = clean_slug(strtolower($form_data['name']));
            

            $where = array();
            $where['name'] =  ($form_data['name']);
             
            $resul_exist = $this->document_category_model->findDynamic($where);
            
            if(!empty($resul_exist))
            {
               $this->session->set_flashdata('error', $form_data['name'].' Category Already Added');

                redirect(base_url().'admin/document_category/addnew');
            }else{

                 $insertData['name']         = $form_data['name'];
                $insertData['title']         = $form_data['title'];
                $insertData['crop_id']         = $form_data['crop_id'];
                $insertData['slug']         = $form_data['slug'];
                $insertData['status']       = $form_data['status1'];
                $insertData['description']  = $form_data['description'];
                $insertData['date_at']      = date("Y-m-d H:i:s");
                $insertData['created_by']   = $this->session->userdata('userId');
                
            }


            
             
             
			$result = $this->document_category_model->save($insertData);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Category successfully Added');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Category Addition failed');
            }
            redirect(base_url().'admin/document_category');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->document_category_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        $role = $this->session->userdata('role');
        foreach ($list as $currentObj) {


            /*find count product total*/
                $where = array();
                $where['document_cat_id'] = $currentObj->id;
                $where['field'] = 'id';
                $result_exist = $this->document_model->findDynamic($where);
                $total_product_count = count($result_exist);
            /*find count product total*/


   // $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn form-control form-control-sm " name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1" '.(($currentObj->status ==1)?" selected ":"").' >Active</option>';
            $btn .= '<option value="0" '.(($currentObj->status ==0)?" selected ":"").'  >Inactive</option>';
            $btn .= '</select>';


            $temp_date = $currentObj->date_at;
            $date_at = date("d-m-Y", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] =  $currentObj->id;
            $row[] = $currentObj->title;
            $row[] = '<a target="_BLANK" href="'.base_url().'admin/kdocuments?document_cat_id='.$currentObj->id.'" title="Edit" ><span class="badge bg-success">View  '.$total_product_count.'</span></a>';
            $row[] = $currentObj->description;
            $row[] = $btn;
            $row[] = $date_at;
             $delete_btn = ' ';
        if($role==1)
        {
              
              $delete_btn = '<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
        } 
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/document_category/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>'.$delete_btn;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->document_category_model->count_all(),
                        "recordsFiltered" => $this->document_category_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();
        if($id == null)
        {
            redirect(base_url().'admin/category');
        }

         $where = array(); 
        $where['status']        = '1'; 
        $crop_list              = $this->crop_model->findDynamic($where);
        $data['crop_lists']     =  $crop_list;


        $data['edit_data'] = $this->document_category_model->find($id);
        $this->global['pageTitle'] = 'Edit Category';
        $this->loadViews("admin/doc-category/edit", $this->global, $data , NULL);
        
        
    } 

    // Update category*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('crop_id','Crop','trim|required');
        $this->form_validation->set_rules('name','Category','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {

            $form_data['slug'] = clean_slug(strtolower($form_data['name']));

            $where = array();
            $where['name'] =  ($form_data['name']);

            $where['id !='] = $form_data['id'];


            $resul_exist = $this->document_category_model->findDynamic($where);
            if(empty($resul_exist))
            {




                $insertData['id']           = $form_data['id'];
                $insertData['name']         = $form_data['name'];
                $insertData['title']         = $form_data['name'];
                $insertData['crop_id']         = $form_data['crop_id'];
                $insertData['slug']         = $form_data['slug'];
                $insertData['status']       = $form_data['status1'];
                $insertData['description']  = $form_data['description'];
                 
                
                $insertData['update_at']    = date("Y-m-d H:i:s");
                $insertData['updated_by']    = $this->session->userdata('userId');
                $result = $this->document_category_model->save($insertData);

                 if($result > 0)
                {
                    $this->session->set_flashdata('success', ' Category successfully Updated');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Category Updation failed');
                }
                redirect(base_url().'admin/document_category');
            }else
            {
                $this->session->set_flashdata('error',  $form_data['name'].' Category Already Exist');
                redirect(base_url().'admin/document_category/edit/'.$form_data['id']);
            }
            
            
			
			/*if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {

				$f_name         =$_FILES['image']['name'];
                $f_tmp          =$_FILES['image']['tmp_name'];
                $f_size         =$_FILES['image']['size'];
                $f_extension    =explode('.',$f_name);
                $f_extension    =strtolower(end($f_extension));
                $f_newfile      =uniqid().'.'.$f_extension;
                $store          ="uploads/doc-category/".$f_newfile;
            
                if(!move_uploaded_file($f_tmp,$store))
                {
                    $this->session->set_flashdata('error', 'Image Upload Failed .');
                }
                else
                {
					$file = "uploads/doc-category/".$form_data['old_image'];
					if(file_exists ( $file))
					{
						unlink($file);
					}
					$insertData['image'] = $f_newfile;
                   
                }
             }
*/
            
			

           
          }  
        
    }

    public function statusChange($id = NULL)
    {
        $this->isLoggedIn();
        if($_POST['id'] == null)
        {
            redirect(base_url().'admin/category');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->document_category_model->save($insertData);
         if ($result > 0) { echo(json_encode(array('status'=>TRUE,'message'=>"successfully status changed"))); }
        else { echo(json_encode(array('status'=>FALSE,'message'=>"status failed failed"))); }
        exit;
        
    }

     // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');
        $where = array();
        $where['document_cat_id'] = $delId;
         
        $returnExistProduct= $this->document_model->findDynamic($where);
        if(empty($returnExistProduct))
        {
             $result = $this->document_category_model->delete($delId); 
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE,'message'=>'Deleted Succesfully'))); }
            else { echo(json_encode(array('status'=>FALSE,'message'=>'Failed In Deletion Operation!'))); }
        }else
        {

          echo(json_encode(array('status'=>FALSE,'message'=>'Delete All kdocuments fist Of This Category')));  
        }
         
    
         
    }
    
    
}

?>