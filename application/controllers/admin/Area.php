<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Area extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/area_model');
    }

    
    public function index()
    {
        $this->isLoggedIn();

        $data = array();
        $this->global['pageTitle'] = 'Area : Ale-izba';
        $this->loadViews("admin/area/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isLoggedIn();
        $data = array();

        $where  = array();
        $where['table']  = 'rc_rel_area';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['parentList'] = $this->area_model->findDynamic($where);

        $where  = array();
        $where['table']  = 'rc_rel_city';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['cityList'] = $this->area_model->findDynamic($where);
        

        $this->global['pageTitle'] = 'Add New Area : Ale-izba';
        $this->loadViews("admin/area/addnew", $this->global, $data , NULL);
        
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
            $where = array();
            $where['name'] = $form_data['name'];
            $returnData = $this->area_model->findDynamic($where);
            if(!empty($returnData)){
               $this->session->set_flashdata('error', $form_data['name'].' already Exist.');
            }else{

                $insertData['name'] = $form_data['name'];
                $insertData['parent_id'] = $form_data['parent_id'];
                $insertData['city_id'] = $form_data['city_id'];
                $insertData['slug'] = $form_data['slug'];
                $insertData['status'] = $form_data['status'];
    			
                 
    			$result = $this->area_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Area successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Area Addition failed');
                }
            }// check already    
            redirect('admin/area/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
        // city list
        $where  = array();
        $where['table']  = 'rc_rel_city';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $TempcityList = $this->area_model->findDynamic($where);
        foreach ($TempcityList as $value) {
            $cityList[$value->id] = $value->name;
        }
        // area list
        $where  = array();
        $where['table']  = 'rc_rel_area';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $TempareaList = $this->area_model->findDynamic($where);
        foreach ($TempareaList as $value) {
            $areaList[$value->id] = $value->name;
        }

		$list = $this->area_model->get_datatables();
		
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
            $row[] = $currentObj->name;
            $row[] = (isset($areaList[$currentObj->parent_id]))?$areaList[$currentObj->parent_id]:'';
            $row[] = (isset($cityList[$currentObj->city_id]))?$cityList[$currentObj->city_id]:'';
            $row[] = $currentObj->slug;
            $row[] = $btn;
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/area/edit/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$currentObj->id.'"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->area_model->count_all(),
                        "recordsFiltered" => $this->area_model->count_filtered(),
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
            redirect('admin/area');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->area_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        

        $this->isLoggedIn();
        if($id == null)
        {
            redirect('admin/area');
        }
        $where  = array();
        $where['table']  = 'rc_rel_area';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['parentList'] = $this->area_model->findDynamic($where);

        $where  = array();
        $where['table']  = 'rc_rel_city';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['cityList'] = $this->area_model->findDynamic($where);
        

        $data['edit_data'] = $this->area_model->find($id);
        $this->global['pageTitle'] = 'Area ';
        $this->loadViews("admin/area/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->area_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update category*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Area','trim|required');
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
            $insertData['parent_id'] = $form_data['parent_id'];
            $insertData['city_id'] = $form_data['city_id'];
            $insertData['slug'] = $form_data['slug'];
            $insertData['status'] = $form_data['status'];

            $result = $this->area_model->save($insertData);
			

            if($result > 0)
            {
                $this->session->set_flashdata('success', ' Area successfully Updated');
            }
            else
            { 
                $this->session->set_flashdata('error', 'Area Updation failed');
            }
            redirect('admin/area/edit/'.$insertData['id']);
          }  
        
    }

    
    
    
}

?>