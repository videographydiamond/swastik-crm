<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class District extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/district_model');
       $this->load->model('admin/state_model');
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
        $this->global['pageTitle'] = 'District';
        $this->loadViews("admin/district/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();
        $data = array();

            $where  = array();
            $where['status']  = '1';
            $where['field']  = 'id,name ';
             $where['orderby'] = 'name';
            $data['countryList'] = $this->country_model->findDynamic($where);

             $where  = array();
            $where['status']        = '1';
            $where['country_id']    = 105;
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['stateList'] = $this->state_model->findDynamic($where);
        

        $this->global['pageTitle'] = 'Add New District';
        $this->loadViews("admin/district/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		 $role = $this->session->userdata('role');
         
        if($role==1)
        {
             
        }else
        {
            $this->session->set_flashdata('error', 'Un-Authorized Page Access !');
             redirect(base_url().'admin', 'refresh');
        }
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('country_id','Select Country','trim|required');
        $this->form_validation->set_rules('state_id','Select State','trim|required');
         
        
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
            $form_data['name'] = ucwords($form_data['name']);
            $where = array();
            $where['name']          =  $form_data['name'];
            $where['country_id']    = $form_data['country_id'];
            $where['state_id']    = $form_data['state_id'];
             


            $returnData = $this->district_model->findDynamic($where);
           /* print_r($this->db->last_query());
             print_r( $returnData );die;*/
             if($form_data['name']== "Other")
             {
                $this->session->set_flashdata('error', $form_data['name'].' Not Allow.');
             }
            else if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{

                $insertData['name'] = $form_data['name'];
                $insertData['country_id'] = $form_data['country_id'];
                $insertData['state_id'] = $form_data['state_id'];
                $insertData['status'] = $form_data['status1'];
                $insertData['date_at'] = date("Y-m-d H:i:s");;
    			
                 
    			$result = $this->district_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'District successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'District Addition failed');
                }
            }// check already    
            redirect(base_url().'admin/district/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
         
		$list = $this->district_model->get_datatables();
		
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
           $row[] = $currentObj->country;
           $row[] = $currentObj->state;

            $edit_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':'<a class="btn btn-sm btn-info" href="'.base_url().'admin/district/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;';
            $delete_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':'<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';

            $status_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':$btn;
            $status_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':$btn;
            $row[] = $currentObj->name;
            $row[] =$status_btn;
            $row[] = $edit_btn.$delete_btn;;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->district_model->count_all(),
                        "recordsFiltered" => $this->district_model->count_filtered(),
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
            redirect('admin/state');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->district_model->save($insertData);
        
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
            redirect('admin/district');
        }

         $where  = array();
            $where['status']  = '1';
            $where['field']  = 'id,name ';
             $where['orderby'] = 'name';
            $data['countryList'] = $this->country_model->findDynamic($where);

             $where  = array();
            $where['status']        = '1';
            $where['country_id']    = 105;
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['stateList'] = $this->state_model->findDynamic($where);
        
        

        $data['edit_data'] = $this->district_model->find($id);
        $this->global['pageTitle'] = 'District';
        $this->loadViews("admin/district/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->district_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('country_id','Select Country','trim|required');
        $this->form_validation->set_rules('state_id','Select State','trim|required');
        $this->form_validation->set_rules('id','ID','trim|required');
        
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
            $form_data['name'] = ucwords($form_data['name']);
            $where = array();
            $where['name']          =  $form_data['name'];
            $where['country_id']    = $form_data['country_id'];
            $where['state_id']    = $form_data['state_id'];
            $where['id !=']    = $form_data['id'];
             


            $returnData = $this->district_model->findDynamic($where);



            $form_data['name'] = ucfirst($form_data['name']);

                 if($form_data['name']== "Other")
             {
                $this->session->set_flashdata('error', $form_data['name'].' Not Allow.');
             }
            else if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else
            {
                    $insertData = array();
                    $insertData['id']   = $form_data['id'];
                    $insertData['name'] = $form_data['name'];
                    $insertData['country_id'] = $form_data['country_id'];
                    $insertData['state_id'] = $form_data['state_id'];
                    $insertData['status'] = $form_data['status1'];
                    $insertData['update_at'] = date("Y-m-d H:i:s");

                    $result = $this->district_model->save($insertData);
                    

                    if($result > 0)
                    {
                        $this->session->set_flashdata('success', ' State successfully Updated');
                    }
                    else
                    { 
                        $this->session->set_flashdata('error', 'State Updation failed');
                    }
            }


           
            redirect(base_url().'admin/district/edit/'.$form_data['id']);
          }  
        
    }

    
    
    
}

?>