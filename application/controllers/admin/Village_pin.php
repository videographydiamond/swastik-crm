<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Village_pin extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/state_model');
       $this->load->model('admin/district_model');
       $this->load->model('admin/country_model');
       $this->load->model('admin/city_model');
       $this->load->model('admin/village_pin_model');
        $role = $this->session->userdata('role');
         
        
    }

    
    public function index()
    {
        $this->isLoggedIn();

        $data = array();
        
        $this->global['pageTitle'] = 'Village Pincode';
        $this->loadViews("admin/village_pin/list", $this->global, $data , NULL);
        
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
            $where['country_id']    =  ($this->session->userdata('leatest_country_id')?$this->session->userdata('leatest_country_id'):105);
            $where['field']         = 'id,name ';
            $where['orderby'] = 'name';
            $data['stateList'] = $this->state_model->findDynamic($where); 


            if($this->session->userdata('leatest_state_id'))
            {
                $where  = array();
                $where['status']        = '1';
                $where['country_id']    =  ($this->session->userdata('leatest_country_id')?$this->session->userdata('leatest_country_id'):105);
                
                $where['state_id']    =  $this->session->userdata('leatest_state_id');
                $where['field']         = 'id,name ';
                $where['orderby'] = 'name';
                $data['districtList'] = $this->district_model->findDynamic($where);   
            }
            
            if($this->session->userdata('leatest_district_id'))
            {
              $where  = array();
                $where['status']        = '1';
                $where['country_id']    = ($this->session->userdata('leatest_country_id')?$this->session->userdata('leatest_country_id'):105);
                $where['state_id']    = ($this->session->userdata('leatest_state_id')?$this->session->userdata('leatest_state_id'):1);
                $where['district_id']    = ($this->session->userdata('leatest_district_id')?$this->session->userdata('leatest_district_id'):1);
                $where['field']         = 'id,city ';
                $where['orderby'] = 'city';
                $data['cityList'] = $this->city_model->findDynamic($where);  
            }
            
             

  /*print_r($_SESSION);*/
       /* echo "<pre>";
        print_r( $data );
        echo "</pre>"; */ 

        $this->global['pageTitle'] = 'Add New Village';
        $this->loadViews("admin/village_pin/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('pincode','Pincode','trim|required');
        $this->form_validation->set_rules('country_id','Select Country','trim|required');
        $this->form_validation->set_rules('state_id','Select State','trim|required');
        $this->form_validation->set_rules('district_id','Select District','trim|required');
        $this->form_validation->set_rules('city_id','Select City','trim|required');
         
         
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
                        $bulk_masterid = array();
                        $bulk_masterid['leatest_country_id']  = $form_data['country_id'];
                        $bulk_masterid['leatest_state_id']    = $form_data['state_id'];
                        $bulk_masterid['leatest_district_id'] = $form_data['district_id'];
                        $bulk_masterid['leatest_city_id']     = $form_data['city_id'];
                     


            $this->session->set_userdata($bulk_masterid);

            // check already exist
            $form_data['name'] = strtolower(ltrim(rtrim($form_data['name'])));
            $form_data['name'] = ucwords($form_data['name']);

            $where = array();
            $where['name']          =  $form_data['name'];
            $where['pincode']       =  $form_data['pincode'];
            $where['country_id']    = $form_data['country_id'];
            $where['state_id']      = $form_data['state_id'];
            $where['district_id']   = $form_data['district_id'];
            $where['city_id']       = $form_data['city_id'];

            $returnData = $this->village_pin_model->findDynamic($where);
 
             if($form_data['name']== "Other")
             {
                $this->session->set_flashdata('error', $form_data['name'].' Not Allow.');
             }else if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{
                $insertData = array();
                $insertData['name'] = $form_data['name'];
                $insertData['pincode'] = $form_data['pincode'];
                $insertData['country_id'] = $form_data['country_id'];
                $insertData['state_id'] = $form_data['state_id'];
                $insertData['district_id'] = $form_data['district_id'];
                $insertData['city_id'] = $form_data['city_id'];
                $insertData['date_at'] = date("Y-m-d H:i:s");;
                $insertData['status'] = $form_data['status1'];
    			
                 
    			$result = $this->village_pin_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Village successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Village Addition failed');
                }
            }// check already    
            redirect(base_url().'admin/village_pin/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
         

		$list = $this->village_pin_model->get_datatables();
		
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
           $row[] = $currentObj->district;
            $edit_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':'<a class="btn btn-sm btn-info" href="'.base_url().'admin/village_pin/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;';
            $delete_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':'<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';

            $status_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':$btn;
            $status_btn =  (isset($currentObj->name) && $currentObj->name =='Other')?'':$btn;


           $row[] = $currentObj->city_name;
           $row[] = $currentObj->name;
           $row[] = $currentObj->pincode;
             $row[] = $btn;
            $row[] = $edit_btn.$delete_btn;;
           /* $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/village_pin/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';*/
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->village_pin_model->count_all(),
                        "recordsFiltered" => $this->village_pin_model->count_filtered(),
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
            redirect('admin/city');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->village_pin_model->save($insertData);
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
            redirect('admin/village_pin');
        }
        $data = array();
        $data['edit_data'] = $this->village_pin_model->find($id);


        $where  = array();
        $where['status']  = '1';
        $where['field']  = 'id,name ';
        $where['orderby'] = 'name';
        $data['countryList'] = $this->country_model->findDynamic($where);

        $where  = array();
        $where['status']        = '1';
        $where['country_id']    = $data['edit_data']->country_id;
        $where['field']         = 'id,name ';
        $where['orderby'] = 'name';
        $data['stateList'] = $this->state_model->findDynamic($where); 

        $where  = array();
        $where['status']        = '1';
        $where['country_id']    =$data['edit_data']->country_id;
        $where['state_id']    =$data['edit_data']->state_id;
        $where['field']         = 'id,name ';
        $where['orderby'] = 'name';
        $data['districtList'] = $this->district_model->findDynamic($where);
        
        $where  = array();
        $where['status']        = '1';
        $where['country_id']    =$data['edit_data']->country_id;
        $where['state_id']    =$data['edit_data']->state_id;
        $where['district_id']    =$data['edit_data']->district_id;
        $where['field']         = 'id,city';
        $where['orderby'] = 'city';
        $data['cityList'] = $this->city_model->findDynamic($where);
        

        
        $this->global['pageTitle'] = 'VIllage';
        $this->loadViews("admin/village_pin/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->village_pin_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','name','trim|required');
        $this->form_validation->set_rules('pincode','Pincode','trim|required');
        $this->form_validation->set_rules('country_id','Select Country','trim|required');
        $this->form_validation->set_rules('state_id','Select State','trim|required');
        $this->form_validation->set_rules('district_id','Select District','trim|required');
        $this->form_validation->set_rules('city_id','Select City','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
			
                $this->edit($form_data['id']);
        }
        else
        {
                  // check already exist
            $form_data['name'] = strtolower(ltrim(rtrim($form_data['name'])));
            $form_data['name'] = ucwords($form_data['name']);
            $where = array();
             $where['name']          =  $form_data['name'];
            $where['pincode']       =  $form_data['pincode'];
            $where['country_id']    = $form_data['country_id'];
            $where['state_id']      = $form_data['state_id'];
            $where['district_id']   = $form_data['district_id'];
            $where['city_id']       = $form_data['city_id'];
            $where['id !=']    = $form_data['id'];
             


            $returnData = $this->village_pin_model->findDynamic($where);
 
             if($form_data['name']== "Other")
             {
                $this->session->set_flashdata('error', $form_data['name'].' Not Allow.');
             }else if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{
                        $insertData =  array();
                        $insertData['id'] = $form_data['id'];
                        $insertData['name'] = $form_data['name'];
                        $insertData['pincode'] = $form_data['pincode'];
                        $insertData['country_id'] = $form_data['country_id'];
                        $insertData['state_id'] = $form_data['state_id'];
                        $insertData['district_id'] = $form_data['district_id'];
                        $insertData['city_id'] = $form_data['city_id'];
                        $insertData['update_at'] = date("Y-m-d H:i:s");;
                        $insertData['status'] = $form_data['status1'];

                    $result = $this->village_pin_model->save($insertData);
            

                    if($result > 0)
                    {
                        $this->session->set_flashdata('success', 'Village successfully Updated');
                        redirect(base_url().'admin/village_pin');
                    }
                    else
                    { 
                        $this->session->set_flashdata('error', 'Village Updation failed');
                        redirect(base_url().'admin/village_pin/edit/'.$form_data['id']);
                    }
                     
                    
            }

           
            
                redirect(base_url().'admin/village_pin/edit/'.$form_data['id']);

            
          }  
        
    }

    
    
    
}

?>