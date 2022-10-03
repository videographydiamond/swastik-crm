<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Crop_type extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/crop_model');

        $role = $this->session->userdata('role');
         
        if($role==1)
        {
             
        }else
        {
            $this->session->set_flashdata('error', 'Un-Authorized Page Access !');
             redirect(base_url().'admin', 'refresh');
        }
    }

    
    public function index()
    {
        $this->isLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Crop Type';
        $this->loadViews("admin/crop-type/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();
        $data = array();
        $this->global['pageTitle'] = 'Add New Crop Type';
        $this->loadViews("admin/crop-type/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
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
            $form_data['name'] =  strtolower($form_data['name']);
            $form_data['slug'] =  clean_slug($form_data['name']);
            $form_data['title'] =  ucwords($form_data['name']);
            $where = array();
            $where['title']  = $form_data['title'];
            $returnData     = $this->crop_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{

                $insertData = array();
                $insertData['name']         = $form_data['name'];
                $insertData['title']        = $form_data['title'];
                $insertData['slug']         = $form_data['slug'];
                $insertData['status']       = $form_data['status1'];
                $insertData['date_at']      = date("Y-m-d H:i:s");
    			$result = $this->crop_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Crop Type successfully Added');
                     redirect(base_url().'admin/crop_type');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Crop Type Addition failed');
                     redirect(base_url().'admin/crop_type/addnew');
                }
            }   
            redirect('admin/crop_type/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->crop_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

             $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn form-control form-control-sm " name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
              $dateAt = date("d M Y H:ia", strtotime($temp_date));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->title;
            $row[] = $dateAt;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/crop_type/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->crop_model->count_all(),
                        "recordsFiltered" => $this->crop_model->count_filtered(),
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
            redirect('admin/crop_type');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->crop_model->save($insertData);
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();
        if($id == null)
        {
            redirect('admin/crop_type');
        }

        $data['edit_data'] = $this->crop_model->find($id);
        $this->global['pageTitle'] = 'Crop Type Edit ';
        $this->loadViews("admin/crop-type/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->crop_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Country*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Country','trim|required');
         
        
        $this->form_validation->set_rules('id','Id','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {


             // check already exist
            $form_data['name'] =  strtolower($form_data['name']);
            $form_data['slug'] =  clean_slug($form_data['name']);
            $form_data['title'] =  ucwords($form_data['name']);
            $where = array();
            $where['title']  = $form_data['title'];
            $where['id !=']         = $form_data['id'];
            $returnData     = $this->crop_model->findDynamic($where);


                 
            


            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{
                 $insertData = array();
                $insertData['id'] = $form_data['id'];
               
                $insertData['name']         = $form_data['name'];
                $insertData['title']        = $form_data['title'];
                $insertData['slug']         = $form_data['slug'];
                $insertData['status']       = $form_data['status1'];
                $insertData['update_at']      = date("Y-m-d H:i:s");
                
                
             

                $result = $this->crop_model->save($insertData);
                

                if($result > 0)
                {
                    $this->session->set_flashdata('success', ' Crop Type successfully Updated');
                    redirect(base_url().'admin/crop_type');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Crop Type Updation failed');
                    redirect(base_url().'admin/crop_type/edit/'.$form_data['id']);
                }
            }
            
            redirect(base_url().'admin/crop_type/edit/'.$form_data['id']);
          }  
        
    }

    
    
    
}

?>