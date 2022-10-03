<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Product extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
       parent::__construct();
       $this->load->model('admin/product_model');
       $this->load->model('admin/category_model');

         
    }


    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();

         $this->global['module_id']      = get_module_byurl('admin/product');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if( empty($action_requred) )
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }


        $this->global['pageTitle'] = 'Product';
        $this->loadViews("admin/product/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
		$this->isLoggedIn();
        $this->global['module_id']      = get_module_byurl('admin/product');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->create !=='create')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }
        $data = array();
        // category  
        $where['status'] = '1'; 
        $category_list = $this->category_model->findDynamic($where);
         $data['category_lists'] =  $category_list;

		 
        $this->global['pageTitle'] = 'Add New Product';
        $this->loadViews("admin/product/addnew", $this->global, $data , NULL);
        
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
        $this->form_validation->set_rules('name','Product Name','trim|required');
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('price','Price','trim|required');
          
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
                $form_data['slug'] = clean_slug($form_data['name']);
                $where = array();
                $where['name']              =  $form_data['name'];
                $where['category_id']       = $form_data['category_id'];
                $where['status']            = $form_data['status1'];
 

                $returnData = $this->product_model->findDynamic($where);

            if(!empty($returnData))
            {
                 $this->session->set_flashdata('error', $form_data['name'].' already exist.');
            }else
            {

                        $where = array();
                        $where['slug']            = $form_data['slug'];
                        $returnExistSlug = $this->product_model->findDynamic($where);
                        if(!empty($returnExistSlug))
                        {
                           $form_data['slug'] = $form_data['slug']."-".count($returnExistSlug);
                        }else
                        {
                            $form_data['slug'] = $form_data['slug'];
                        }


                    $insertData  = array();
                    $insertData['name']             = $form_data['name'];
                    $insertData['title']             = $form_data['title'];
                    $insertData['category_id']      = $form_data['category_id'];
                    $insertData['hsn']              = $form_data['hsn'];
                    $insertData['price']            = $form_data['price'];
                    $insertData['usage_unit']       = $form_data['usage_unit'];
                    $insertData['tax_rate']         = $form_data['tax_rate'];
                    $insertData['discount']         = $form_data['discount'];
                    $insertData['slug']             = $form_data['slug'];
                    $insertData['status']           = $form_data['status1'];
                    $insertData['date_at']          = date("Y-m-d H:i:s");
                    $insertData['source']         = $form_data['source'];
                    $insertData['created_by']          = $this->session->userdata('userId');
             
            
            
                $result = $this->product_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Product successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Product Addition failed');
                }
            }
            


                    
            redirect('admin/product/addnew');
          }  
        
    }


    //  list
    public function ajax_list()
    {
	
		$list = $this->product_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        $this->global['module_id']      = get_module_byurl('admin/product');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);

        $role = $this->session->userdata('role');
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $date_at = date("d-m-Y", strtotime($temp_date));
            $no++;
            $row = array();
              // $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn form-control form-control-sm " name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1" '.(($currentObj->status ==1)?" selected ":"").' >Active</option>';
            $btn .= '<option value="0" '.(($currentObj->status ==0)?" selected ":"").'  >Inactive</option>';
            $btn .= '</select>';
            


            $row[] =  $currentObj->id;
            $row[] =  $currentObj->category;
            $row[] =  $currentObj->title;
            $row[] =  $currentObj->hsn;
            $row[] =  $currentObj->price;
            $row[] =  $currentObj->usage_unit;
            $row[] =  $currentObj->tax_rate;
            $row[] =  $currentObj->discount;
            $row[] =  $currentObj->source;
            $row[] =   $btn;;
            $row[] = $date_at;
             
        

          $edit_btn =(@$action_requred->edit=='edit')?'<a class="btn btn-sm btn-info" href="'.base_url().'admin/product/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;':'';
            $delete_btn =(@$action_requred->delete=='delete')?'<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>':'';
        
            
            $row[] = $edit_btn."".$delete_btn;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->product_model->count_all(),
                        "recordsFiltered" => $this->product_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Edit
 
    public function edit($id = NULL)
    {
        $this->isLoggedIn();

        $this->global['module_id']      = get_module_byurl('admin/product');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->edit !=='edit')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

		if($id == null)
        {
            redirect('admin/product');
        }
		$data = array();
         // category  
        $where['status'] = '1'; 
        $category_list = $this->category_model->findDynamic($where);
         $data['category_lists'] =  $category_list;
        // edit data 
        $data['edit_data'] = $this->product_model->find($id);
        
       
        $this->global['pageTitle'] = 'Ale-izba : Edit Product';
        $this->loadViews("admin/product/edit", $this->global, $data , NULL);
    } 

    // Update *************************************************************
    public function update()
    {
		$form_data  = $this->input->post();
		
        $this->isLoggedIn();
        $this->load->library('form_validation');             
        $this->form_validation->set_rules('name','Product Name','trim|required');
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('price','Price','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {


            $form_data['name'] = strtolower($form_data['name']);
                $form_data['title'] = ucwords($form_data['name']);
                $form_data['slug'] = clean_slug($form_data['name']);
                $where = array();
                $where['name']              =  $form_data['name'];
                $where['category_id']       = $form_data['category_id'];
                $where['status']            = $form_data['status1'];
                $where['id !=']            = $form_data['id'];
 

                $returnData = $this->product_model->findDynamic($where);

            if(!empty($returnData))
            {
                 $this->session->set_flashdata('error', $form_data['name'].' already exist.');
            }else
            {


                        $where = array();
                        $where['slug']            = $form_data['slug'];
                        $where['id !=']            = $form_data['id'];
                        $returnExistSlug = $this->product_model->findDynamic($where);
                        if(!empty($returnExistSlug))
                        {
                           $form_data['slug'] = $form_data['slug']."-".count($returnExistSlug);
                        }else
                        {
                            $form_data['slug'] = $form_data['slug'];
                        }

                    $insertData  = array();
                    $insertData['id'] = $form_data['id'];


                    $insertData['name']             = $form_data['name'];
                    $insertData['title']             = $form_data['title'];
                    $insertData['category_id']      = $form_data['category_id'];
                    $insertData['hsn']              = $form_data['hsn'];
                    $insertData['price']            = $form_data['price'];
                    $insertData['usage_unit']       = $form_data['usage_unit'];
                    $insertData['tax_rate']         = $form_data['tax_rate'];
                    $insertData['discount']         = $form_data['discount'];
                    $insertData['source']         = $form_data['source'];
                    $insertData['slug']             = $form_data['slug'];
                    $insertData['status']           = $form_data['status1'];


                    $insertData['update_at'] = date("Y-m-d H:i:s");

                
            
                    
                $result = $this->product_model->save($insertData);
                

                if($result > 0)
                {
                    $this->session->set_flashdata('success', ' Product successfully Updated');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Product Updation failed');
                }
            }


            
            
            redirect(base_url().'admin/product/edit/'.$insertData['id']);
          }  
        
    }
	
	
    // Delete  *****************************************************************
      function delete()
    {
		
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
		 
	
        $result = $this->product_model->delete($delId); 
			
         if ($result > 0) { echo(json_encode(array('status'=>TRUE,'message'=>'Deleted Succesfully'))); }
            else { echo(json_encode(array('status'=>FALSE,'message'=>'Failed In Deletion Operation!'))); }
    }

    public function single($id='')
    {
        $this->isLoggedIn();
        $single_arr = $this->product_model->find($id);
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
        $result = $this->product_model->save($insertData);
         if ($result > 0) { echo(json_encode(array('status'=>TRUE,'message'=>"successfully status changed"))); }
        else { echo(json_encode(array('status'=>FALSE,'message'=>"status failed failed"))); }
        exit;
        
    } 

    
    
}

?>