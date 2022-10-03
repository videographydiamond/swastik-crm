<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Country extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/country_model');

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
        $this->global['pageTitle'] = 'Country';
        $this->loadViews("admin/country/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();
        $data = array();
        $this->global['pageTitle'] = 'Add New Country';
        $this->loadViews("admin/country/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('countryCode','Country Code','trim|required');
         
        

        
        
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
            $where['countryCode']  = $form_data['countryCode'];
            $returnData     = $this->country_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['countryCode'].' already Exist.');
            }else{

                $insertData['name'] = $form_data['name'];
                $insertData['countryCode'] = $form_data['countryCode'];
                
                $insertData['status'] = $form_data['status1'];
    			
               
    			$result = $this->country_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Country successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Country Addition failed');
                }
            }// check already    
            redirect('admin/country/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->country_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            // $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn form-control form-control-sm " name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $currentObj->name;
            $row[] = $currentObj->countryCode;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/country/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->country_model->count_all(),
                        "recordsFiltered" => $this->country_model->count_filtered(),
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
            redirect('admin/country');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->country_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();
        if($id == null)
        {
            redirect('admin/country');
        }

        $data['edit_data'] = $this->country_model->find($id);
        $this->global['pageTitle'] = 'Country ';
        $this->loadViews("admin/country/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->country_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Country*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Country','trim|required');
        $this->form_validation->set_rules('countryCode','Code','trim|required');
        
        $this->form_validation->set_rules('id','Id','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {

                $where = array();
                $where['countryCode']   = $form_data['countryCode'];
                $where['id !=']         = $form_data['id'];
                $returnData         = $this->country_model->findDynamic($where);
            


            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['countryCode'].' already Exist.');
            }else{
                $insertData['id'] = $form_data['id'];
                $insertData['name'] = $form_data['name'];
                $insertData['countryCode'] = $form_data['countryCode'];
                $insertData['status'] = $form_data['status1'];
                
                
             

                $result = $this->country_model->save($insertData);
                

                if($result > 0)
                {
                    $this->session->set_flashdata('success', ' Country successfully Updated');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Country Updation failed');
                }
            }
            
            redirect('admin/country/edit/'.$form_data['id']);
          }  
        
    }

    
    
    
}

?>