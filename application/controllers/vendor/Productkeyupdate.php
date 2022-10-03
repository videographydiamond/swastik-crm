<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Productkeyupdate extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
       parent::__construct();
       $this->load->model('admin/product_model');
       $this->load->model('productkey_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isVendorLoggedIn();
        $this->global['pageTitle'] = 'Ale-izba : Product Key Update';
        $this->vendorView("vendor/productkeyupdate/list", $this->global, NULL , NULL);
        
    }

    // Add New 
    public function addnew()
    {
		$this->isVendorLoggedIn();
		// category
		$data = array();
        $this->global['pageTitle'] = 'Ale-izba : Add New Product';
        $this->vendorView("vendor/productkeyupdate/addnew", $this->global, $data , NULL);
        
    } 
	
	// Get Sub category
	public function get_sub_category()
    {
		//$this->isVendorLoggedIn();
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
        $this->isVendorLoggedIn();
		$form_data  = $this->input->post();
		 
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('productKey','Product Key','trim|required');
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
	        
            $insertData['productKey'] = base64_encode($form_data['productKey']);
            $insertData['orderId'] = 0;
            $insertData['status'] = 0;
            $insertData['insertat'] = date("Y-m-d H:i:s");
            
			$result = $this->productkey_model->save($insertData);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Product Key successfully Added');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Product Key Addition failed');
            }
            redirect('vendor/productkeyupdate/addnew');
          }  
        
    }


    //  list
    public function ajax_list()
    {
	
		$list = $this->productkey_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            
            
            $no++;
            $row = array();
            $row[] = $currentObj->productKey;
            $row[] = $currentObj->orderId;
            $row[] = $currentObj->insertat;
            $row[] = ($currentObj->status == 1)?"Assigned":"New";
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/productkeyupdate/edit/'.$currentObj->id.'" Title="Edit Row" ><i class="fa fa-pencil"></i></a> ';//<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>
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
        $this->isVendorLoggedIn();
		if($id == null)
        {
            redirect('vendor/productkeyupdate');
        }
		$data = array();
        // edit data 
        $data['edit_data'] = $this->productkey_model->find($id);
      
       
        $this->global['pageTitle'] = 'Ale-izba : Edit ProductKey';
        $this->vendorView("vendor/productkeyupdate/edit", $this->global, $data , NULL);
    } 

    // Update *************************************************************
    public function update()
    {
		$form_data  = $this->input->post();
		
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('id','Productkey Id Is Empty','required');
		$this->form_validation->set_rules('productKey','Product Key','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {
            
            $insertData['id'] = $form_data['id'];
			$insertData['productKey'] = $form_data['productKey'];
            $insertData['updateat'] = date("Y-m-d H:i:s");
            
			$result = $this->productkey_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Product Key successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Product Key Updation failed');
            }
            redirect('vendor/Productkeyupdate/edit/'.$insertData['id']);
          }  
        
    }
	
	
    // Delete  *****************************************************************
      function delete()
    {
		
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
		$db_data = $this->product_model->find($delId);
		//print_r($db_data);
		if(!empty($db_data))
		{
			$i = 1;
			while($i <= 3)
			{
				$image = 'image'.$i;
				$file = "uploads/product/".$db_data->$image;
				
				if(file_exists ( $file))
				{
					unlink($file);
				}
				$i++;
			}
		}
	
        $result = $this->product_model->delete($delId); 
			
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    
    
    
}

?>