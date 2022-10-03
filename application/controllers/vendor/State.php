<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class State extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/state_model');
    }

    
    public function index()
    {
        $this->isVendorLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'State : Ale-izba';
        $this->vendorView("vendor/state/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isVendorLoggedIn();
        $data = array();

        $where  = array();
        $where['table']  = 'rc_rel_country';
        $where['status']  = '1';
        $where['field']  = 'id,name, code';
        $data['countryList'] = $this->state_model->findDynamic($where);
        

        $this->global['pageTitle'] = 'Add New State : Ale-izba';
        $this->vendorView("vendor/state/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isVendorLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('country_id','Select Country','trim|required');
        $this->form_validation->set_rules('code','State Code','trim|required');
        
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
            $returnData = $this->state_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{

                $insertData['name'] = $form_data['name'];
                $insertData['country_id'] = $form_data['country_id'];
                $insertData['code'] = $form_data['code'];
                $insertData['slug'] = $form_data['slug'];
                $insertData['status'] = $form_data['status'];
    			
                 
    			$result = $this->state_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'State successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'State Addition failed');
                }
            }// check already    
            redirect('vendor/state/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
        $where  = array();
        $where['table']  = 'rc_rel_country';
        $where['status']  = '1';
        $where['field']  = 'id,name, code';
        $TempcountryList = $this->state_model->findDynamic($where);
        foreach ($TempcountryList as $value) {
            $countryList[$value->id] = $value->name;
        }

		$list = $this->state_model->get_datatables();
		
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
            $row[] = (isset($countryList[$currentObj->country_id]))?$countryList[$currentObj->country_id]:'';
            $row[] = $currentObj->name;
            $row[] = $currentObj->code;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'vendor/state/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->state_model->count_all(),
                        "recordsFiltered" => $this->state_model->count_filtered(),
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
            redirect('vendor/state');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->state_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isVendorLoggedIn();
        if($id == null)
        {
            redirect('vendor/state');
        }
        $where  = array();
        $where['table']  = 'rc_rel_country';
        $where['field']  = 'id,name, code';
        $data['countryList'] = $this->state_model->findDynamic($where);
        

        $data['edit_data'] = $this->state_model->find($id);
        $this->global['pageTitle'] = 'State ';
        $this->vendorView("vendor/state/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->state_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','State','trim|required');
        $this->form_validation->set_rules('code','Code','trim|required');
        $this->form_validation->set_rules('slug','Slug','trim');
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
            $insertData['code'] = $form_data['code'];
            $insertData['slug'] = $form_data['slug'];
            $insertData['status'] = $form_data['status'];
            

            $result = $this->state_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' State successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'State Updation failed');
            }
            redirect('vendor/state/edit/'.$insertData['id']);
          }  
        
    }

    
    
    
}

?>