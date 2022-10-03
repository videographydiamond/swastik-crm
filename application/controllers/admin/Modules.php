<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Modules extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
       parent::__construct();
       $this->load->model('admin/module_model');
        
    }


    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Module';
        $this->loadViews("admin/module/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
		$this->isLoggedIn();
        $data = array();
        // category  
        $where['status'] = '1'; 
        $module_list = $this->module_model->findDynamic($where);
         $data['module_list'] =  $module_list;

		 
        $this->global['pageTitle'] = 'Add New Product';
        $this->loadViews("admin/module/addnew", $this->global, $data , NULL);
        
    } 
	
	// Get Sub category
	public function get_sub_category()
    {
		//$this->isLoggedIn();
		$id = $this->input->post('id');
		
		
		// Sub category 
		$where['category_id'] = $id;
		$where['status'] = '1';
		$where['field'] = 'id,name';
		$sub_category_list = $this->sub_category_model->findDynamic($where);
		$option = '';
		foreach($sub_category_list as $k=>$v){
			$option .= '<option value="'.$v->id.'">'.$v->name.'</option>';
		}
		
		
		echo $option;//$select_box = '<select class ="form-control" name="sub_category_id" id="sub_category_id">'.$option.'</select>	';
	
		
       
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		$form_data  = $this->input->post();
		 
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('module_name','Module Name','trim|required');
        $this->form_validation->set_rules('parent_id','Parent Module Name','trim|required');
        $this->form_validation->set_rules('module_url','Parent Module URL','trim|required');
         
          
         //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {

                $company_id = $this->session->userdata('company_id');
	       
                // check already exist
                $form_data['name'] = strtolower($form_data['module_name']);
                $form_data['title'] = ucwords($form_data['module_name']);
                $form_data['slug'] = clean_slug($form_data['module_name']);
                $where = array();
                $where['slug_url']     =  $form_data['slug'];
                $where['module_url']     =  $form_data['module_url'];
                $where['parent_id']       = $form_data['parent_id'];
                $where['status']          = $form_data['status1'];
 

                $returnData = $this->module_model->findDynamic($where);

            if(!empty($returnData))
            {
                 $this->session->set_flashdata('error', $form_data['name'].' already exist.');
            }else
            {

                        $where = array();
                        $where['slug_url']            = $form_data['slug'];
                        $returnExistSlug = $this->module_model->findDynamic($where);
                        if(!empty($returnExistSlug))
                        {
                           $form_data['slug'] = $form_data['slug']."-".count($returnExistSlug);
                        }else
                        {
                            $form_data['slug'] = $form_data['slug'];
                        }


                    $insertData  = array();
                    $insertData['module_name']      = $form_data['title'];
                    $insertData['parent_id']        = $form_data['parent_id'];
                    $insertData['slug_url']         = $form_data['slug'];
                    $insertData['icon_name']        = $form_data['icon_name'];
                    $insertData['orders_with']      = $form_data['orders_with'];
                    $insertData['target']           = $form_data['target'];
                    $insertData['company_id']       = $company_id;
                    $insertData['module_url']       = $form_data['module_url'];
                    $insertData['status']           = $form_data['status1'];
                    $insertData['created_at']       = date("Y-m-d H:i:s");
                    $insertData['created_by']       = $this->session->userdata('userId');
             
            
            
                $result = $this->module_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Module successfully Added');
                    redirect(base_url().'admin/modules');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'MOdule Addition failed');
                    redirect(base_url().'admin/modules/addnew');
                }
            }
            


                    
            redirect(base_url().'admin/modules/addnew');
          }  
        
    }


    //  list
    public function ajax_list()
    {
	
		$list = $this->module_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        $role = $this->session->userdata('role');
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->created_at;
            $date_at = date("d-m-Y", strtotime($temp_date));
            $no++;
            $row = array();
              // $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn form-control form-control-sm " name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1" '.(($currentObj->status ==1)?" selected ":"").' >Active</option>';
            $btn .= '<option value="0" '.(($currentObj->status ==0)?" selected ":"").'  >Inactive</option>';
            $btn .= '</select>';
            


            $row[] =  $no;
            $row[] =  $currentObj->parent_module_name;
            $row[] =  $currentObj->module_name; 
            $row[] =  $currentObj->module_url; 
            $row[] =  $currentObj->icon_name; 
            $row[] =  $currentObj->orders_with; 
            $row[] =  $currentObj->target; 
            $row[] =  $date_at;
            $row[] =  $btn;;
             
            $delete_btn = ' ';
        if($role==1)
        {
              
              $delete_btn = '<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
        } 
            
            $row[] = '<a title="'.$currentObj->module_url.'" class="btn btn-sm btn-info" href="'.base_url().'admin/modules/edit/'.$currentObj->id.'"><i class="fa fa-pen"></i></a>'. $delete_btn;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->module_model->count_all(),
                        "recordsFiltered" => $this->module_model->count_filtered(),
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
            redirect('admin/modules');
        }
		$data = array();
         // category  
        $where['status'] = '1'; 
        $module_list = $this->module_model->findDynamic($where);
         $data['module_list'] =  $module_list;
        // edit data 
        $data['edit_data'] = $this->module_model->find($id);
        
       
        $this->global['pageTitle'] = 'Edit Module';
        $this->loadViews("admin/module/edit", $this->global, $data , NULL);
    } 

    // Update *************************************************************
    public function update()
    {
		$form_data  = $this->input->post();
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('module_name','Module Name','trim|required');
        $this->form_validation->set_rules('parent_id','Parent Module Name','trim|required');
        $this->form_validation->set_rules('module_url','Parent Module URL','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {


                $form_data['module_name'] = strtolower($form_data['module_name']);
                $form_data['title'] = ucwords($form_data['module_name']);
                $form_data['slug'] = clean_slug($form_data['module_name']);
                $where = array();
                $where['slug_url']          =  $form_data['slug'];
                $where['module_url']        =  $form_data['module_url'];
                $where['parent_id']         = $form_data['parent_id'];
                $where['status']            = $form_data['status1'];
                $where['id !=']             = $form_data['id'];
 

                $returnData = $this->module_model->findDynamic($where);

            if(!empty($returnData))
            {
                 $this->session->set_flashdata('error', $form_data['name'].' already exist.');
            }else
            {


                        $where = array();
                        $where['slug_url']            = $form_data['slug'];
                        $where['id !=']            = $form_data['id'];
                        $returnExistSlug = $this->module_model->findDynamic($where);
                        if(!empty($returnExistSlug))
                        {
                           $form_data['slug'] = $form_data['slug']."-".count($returnExistSlug);
                        }else
                        {
                            $form_data['slug'] = $form_data['slug'];
                        }

                    $insertData  = array();
                    $insertData['id'] = $form_data['id'];


                    $insertData['module_name']             = $form_data['title'];
                     
                    $insertData['parent_id']        = $form_data['parent_id'];
                    $insertData['slug_url']         = $form_data['slug'];
                    $insertData['icon_name']        = $form_data['icon_name'];
                    $insertData['orders_with']        = $form_data['orders_with'];
                    $insertData['target']        = $form_data['target'];
                    $insertData['module_url']     =  $form_data['module_url'];
                    $insertData['status']           = $form_data['status1'];
                    $insertData['updated_at']       = date("Y-m-d H:i:s");
                    $insertData['updated_by']       = $this->session->userdata('userId');


                     

                
            
                    
                $result = $this->module_model->save($insertData);
                

                if($result > 0)
                {
                    $this->session->set_flashdata('success', ' Module successfully Updated');
                     redirect(base_url().'admin/modules');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Module Updation failed');
                    redirect(base_url().'admin/modules/edit/'.$insertData['id']);
                }
            }


            
            
            redirect(base_url().'admin/modules/edit/'.$form_data['id']);
          }  
        
    }

	
    // Delete  *****************************************************************
      function delete()
    {
		
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
		 
	
        $result = $this->module_model->delete($delId); 
			
         if ($result > 0) { echo(json_encode(array('status'=>TRUE,'message'=>'Deleted Succesfully'))); }
            else { echo(json_encode(array('status'=>FALSE,'message'=>'Failed In Deletion Operation!'))); }
    }

    public function single($id='')
    {
        $this->isLoggedIn();
        $single_arr = $this->module_model->find($id);
        echo  json_encode($single_arr);
    }

          // Status Change
 
    public function statusChange($id = NULL)
    {
        $this->isLoggedIn();
        if($_POST['id'] == null)
        {
            redirect('admin/product');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->module_model->save($insertData);
         if ($result > 0) { echo(json_encode(array('status'=>TRUE,'message'=>"successfully status changed"))); }
        else { echo(json_encode(array('status'=>FALSE,'message'=>"status failed failed"))); }
        exit;
        
    } 

    
    
}

?>