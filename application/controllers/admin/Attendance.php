<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Attendance extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/attendance_model');
        $this->load->model('admin/attendance_history_model');
        $this->load->model('admin/admin_model');
        $this->load->model('admin/role_model');
        $this->perPage =100; 
        $this->perPageAtt =500; 
        $this->perPageAttEmpLog =100; 
        $this->perPageAttEmpDetail =2; 
        
        
    }

    
    public function index()
    {

        

            $this->isLoggedIn();


            $this->global['module_id']      = get_module_byurl('admin/attendance');
            $role_id                        = $this->session->userdata('role_id');
            $role                         = $this->session->userdata('role');
            $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
            if(empty($action_requred))
            {
                $this->session->set_flashdata('error', 'Un-autherise Access');
                redirect(base_url());
            }

            if($role !=='1')
            {
             redirect(base_url()."admin/attendance/att_emp_log");   
            }


            $data           = array();
            $conditions     = array();
            $where_search   = array();
            $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid        = $uid;
            }else
            {
                $userid         = $this->session->userdata('userId');
            }
            $search_userid      = @$userid;
            $start_date          = @$this->input->get('start_date'); 
            $end_date            = @$this->input->get('end_date'); 
             
 
                 
                if(!empty($start_date))
                {
                     $where_search['start_date'] =  $start_date;
                 }
                if(!empty($end_date))
                {
                     $where_search['end_date'] =  $end_date;
                 }

            $conditions['returnType'] = 'count'; 
            $conditions['userid'] = $userid; 
            $conditions['where'] = $where_search; 
            $totalRec = $this->attendance_model->getRows($conditions);


            $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 4; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/attendance/index'; 
                $config['uri_segment'] = $uriSegment; 
                $config['total_rows']  = $totalRec; 
                $config['per_page']    = $this->perPage; 
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  float-end mt-4" id="query-pagination">';
            $config['full_tag_close'] = '</ul> ';
             
            $config['first_link'] = 'First&nbsp;Page';
            $config['first_tag_open'] = '<li class="page-item">  ';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last&nbsp;Page';
            $config['last_tag_open'] ='<li class="page-item">  ';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="page-item"> ';
            $config['next_tag_close'] = ' </li>';
 
            $config['prev_link'] = 'Previous';
            $config['prev_tag_open'] = '<li class="page-item"> ';
            $config['prev_tag_close'] = '</li>';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link active">';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="page-item"> ';
            $config['num_tag_close'] = ' </li>';

                // Initialize pagination library 
                $this->pagination->initialize($config); 
                
              

                // Define offset 
                $page = $this->uri->segment($uriSegment); 
                $offset = (!$page)?0:$page; 

                if($offset != 0){
                    $offset = ($offset-1) * $this->perPage;
                }

 
                // Get records 
                $conditions = array( 
                'start' => $offset, 
                'where' => $where_search, 
                'userid' =>  $userid, 
                'limit' => $this->perPage 
                ); 

                
                    /*$conditions['userid'] = $userid;
                $conditions['form_type'] = $form_type;  echo "<pre>";
                    print_r( $conditions);
                    echo "</pre>"; */

                 $data['attendance']   = $this->attendance_model->getRows($conditions); 
                 print_r($this->db->last_query());    


 
                $data['pagination'] = $this->pagination->create_links(); 
 
                $data['pagination_total_count'] =  $totalRec;


        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);


        

        $this->global['pageTitle'] = 'Attendance';
        $this->global['pageTitle'] = 'admin/attendance';

        $this->loadViews("admin/attendance/list", $this->global, $data , NULL);


        
    }
    public function att_emp_detail($uid)
    {

        

            $this->isLoggedIn();


            $this->global['module_id']      = get_module_byurl('admin/attendance');
            $role_id                        = $this->session->userdata('role_id');
            $role                         = $this->session->userdata('role');
            $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
            if(empty($action_requred))
            {
                $this->session->set_flashdata('error', 'Un-autherise Access');
                redirect(base_url());
            }

            if($role !=='1')
            {
                redirect(base_url()."admin/attendance");   
            }


            $data           = array();
            $conditions     = array();
            $where_search   = array();
            
            if(isset($uid) && $uid !=='')
            {
                 $userid        = $uid;
            }else
            {
                $userid         = $this->session->userdata('userId');
            }
            $search_userid      = @$userid; 
             
 
                 
                if(!empty($search_userid))
                {
                     $where_search['user_id'] =  $search_userid;
                 }
               

            $conditions['returnType'] = 'count'; 
            $conditions['userid'] = $userid; 
            $conditions['where'] = $where_search; 
            $totalRec = $this->attendance_model->getRowsEmpDetails($conditions);


            $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 5; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/attendance/att_emp_detail/'.$uid; 
                $config['uri_segment'] = $uriSegment; 
                $config['total_rows']  = $totalRec; 
                $config['per_page']    = $this->perPageAttEmpDetail; 
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  float-end mt-4" id="query-pagination">';
            $config['full_tag_close'] = '</ul> ';
             
            $config['first_link'] = 'First&nbsp;Page';
            $config['first_tag_open'] = '<li class="page-item">  ';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last&nbsp;Page';
            $config['last_tag_open'] ='<li class="page-item">  ';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="page-item"> ';
            $config['next_tag_close'] = ' </li>';
 
            $config['prev_link'] = 'Previous';
            $config['prev_tag_open'] = '<li class="page-item"> ';
            $config['prev_tag_close'] = '</li>';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link active">';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="page-item"> ';
            $config['num_tag_close'] = ' </li>';

                // Initialize pagination library 
                $this->pagination->initialize($config); 
                
              

                // Define offset 
                 $page = $this->uri->segment($uriSegment);  
                $offset = (!$page)?0:$page; 

                if($offset != 0){
                    $offset = ($offset-1) * $this->perPageAttEmpDetail;
                }

 
                // Get records 
                $conditions = array( 
                    'start' => $offset, 
                    'where' => $where_search, 
                    'userid' =>  $userid, 
                    'limit' => $this->perPage 
                ); 

                    
                $where          = array();
                $where['id']    = $userid;
                $where['field'] = 'id,name,title';
                $user_data      = $this->admin_model->findDynamic($where);
                $data['user_data']   =   $user_data[0];
                 $data['attendance']   = $this->attendance_model->getRowsEmpDetails($conditions); 



 
                $data['pagination'] = $this->pagination->create_links(); 
 
                $data['pagination_total_count'] =  $totalRec;


        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);


        

        $this->global['pageTitle'] = 'Attendance';
        $this->global['pageTitle'] = 'admin/attendance';

        $this->loadViews("admin/attendance/att-emp-detail", $this->global, $data , NULL);


        
    }


    public function att_emp_log()
    {
             $this->isLoggedIn();

            $this->global['module_id']      = get_module_byurl('admin/attendance');
            $this->global['module_id2']      = get_module_byurl('admin/attendance/addnew');
            $role_id                        = $this->session->userdata('role_id');
            $role                           = $this->session->userdata('role');
            $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
            if(empty($action_requred))
            {
                $this->session->set_flashdata('error', 'Un-autherise Access');
                redirect(base_url());
            }


            $data           = array();
            $conditions     = array();
            $where_search   = array();
            $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid        = $uid;
            }else
            {
                $userid         = $this->session->userdata('userId');
            }
            $search_userid      = @$userid;
            $start_date          = @$this->input->get('start_date'); 
            $end_date            = @$this->input->get('end_date'); 
             

                if(!empty($search_userid))
                {
                    $where_search['user_id'] =  $search_userid;
                }
                 
                if(!empty($start_date))
                {
                     $where_search['start_date'] =  $start_date;
                 }
                if(!empty($end_date))
                {
                     $where_search['end_date'] =  $end_date;
                 }

            $conditions['returnType'] = 'count'; 
            $conditions['userid'] = $userid; 
            $conditions['where'] = $where_search; 
            $totalRec = $this->attendance_model->getRowsEmpLog($conditions);


            $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 4; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/attendance/att_emp_log'; 
                $config['uri_segment'] = $uriSegment; 
                $config['total_rows']  = $totalRec; 
                $config['per_page']    = $this->perPageAttEmpLog; 
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  float-end mt-4" id="query-pagination">';
            $config['full_tag_close'] = '</ul> ';
             
            $config['first_link'] = 'First&nbsp;Page';
            $config['first_tag_open'] = '<li class="page-item">  ';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last&nbsp;Page';
            $config['last_tag_open'] ='<li class="page-item">  ';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="page-item"> ';
            $config['next_tag_close'] = ' </li>';
 
            $config['prev_link'] = 'Previous';
            $config['prev_tag_open'] = '<li class="page-item"> ';
            $config['prev_tag_close'] = '</li>';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link active">';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="page-item"> ';
            $config['num_tag_close'] = ' </li>';

                // Initialize pagination library 
                $this->pagination->initialize($config); 
                
              

                // Define offset 
                $page = $this->uri->segment($uriSegment); 
                $offset = (!$page)?0:$page; 

                if($offset != 0){
                    $offset = ($offset-1) * $this->perPageAttEmpLog;
                }

 
                // Get records 
                $conditions = array( 
                'start' => $offset, 
                'where' => $where_search, 
                'userid' =>  $userid, 
                'limit' => $this->perPageAttEmpLog 
                ); 

                
                    /*$conditions['userid'] = $userid;
                $conditions['form_type'] = $form_type;  echo "<pre>";
                    print_r( $conditions);
                    echo "</pre>"; */

                 $data['attendance']   = $this->attendance_model->getRowsEmpLog($conditions); 


 
                $data['pagination'] = $this->pagination->create_links(); 
 
                $data['pagination_total_count'] =  $totalRec;


        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);


        $this->global['module_id']      = get_module_byurl('admin/attendance');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $this->global['pageTitle'] = 'Attendance';
        $this->global['pageTitle'] = 'admin/attendance';

        $this->loadViews("admin/attendance/att-emp-log", $this->global, $data , NULL);

    }

    // Add New 
    public function addnew()
    {

         
        $this->isLoggedIn();
        


         $uid         = $this->input->get('uid');
        if(isset($uid) && $uid !=='')
        {
             $userid        = $uid;
        }else
        {
            $userid         = $this->session->userdata('userId');
        }


        $data = array();
        $where = array();
        $where['status !='] = 2;
        $where['field'] = 'id,name,title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);

        $where = array();
        $where['att_date']  = date('Y-m-d');
        $where['field']     = 'state';
        $where['status']    = '1';
        $where['orderby']   = '-id';
        $where['limit']     = '1';
        $where['user_id']   = $userid ;
        $data['checkInOutStatus'] = $this->attendance_history_model->findDynamic($where);
        if(!empty($data['checkInOutStatus']))
        {
            $data['checkInOutStatus'] = $data['checkInOutStatus'][0]->state;
        }else
        {
            $data['checkInOutStatus'] = 2;
        }
        $where = array();
        $where['status'] = '1';
        $data['all_roles'] = $this->role_model->findDynamic($where);
        $this->global['pageTitle'] = 'Add Attendance';
        $this->loadViews("admin/attendance/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {
        $this->isLoggedIn();
		
		
		
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('puch_time','Punch Time','trim|required');
          
         
        

        
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
            $company_id = $this->session->userdata('company_id');

            if(isset($form_data['uid']) && $form_data['uid'] !=='')
            {
                $userid = $form_data['uid'];    
            }else
            {
                $userid = $this->session->userdata('userId');
            }


             if($this->session->userdata('role') ==1)
            {
               
            }else
            {
                if(strtotime($form_data['puch_time']) <  strtotime($form_data['today_time']))
                {
                        $this->session->set_flashdata('error', 'Punch time Previous not allow');
                         redirect(base_url().'admin/attendance');
                }     
            }
            


            $where = array();
            $where['user_id']  = $userid;
            $where['att_date']  =  date("Y-m-d",strtotime($form_data['puch_time']));
            $returnData     = $this->attendance_model->findDynamic($where);
            $insertData = array();
            if(!empty($returnData))
            {
                $insertData['id'] = $returnData[0]->id;
                $insertData['update_at']   = date("Y-m-d H:i:s");
                $insertData['updated_by']   = $this->session->userdata('userId') ;
            }else
            {
                $insertData['checkin']      =  date("Y-m-d H:i:s",strtotime($form_data['puch_time']));;
                $insertData['company_id']   = $company_id;
                $insertData['date_at']      = date("Y-m-d H:i:s");
                $insertData['created_by']   = $this->session->userdata('userId') ;
                $insertData['user_id']      = $userid;
                $insertData['att_date']     =date("Y-m-d",strtotime($form_data['puch_time']));

            }
            if($form_data['state']==1)
            {
                $insertData['last_checkin'] =date("Y-m-d H:i:s",strtotime($form_data['puch_time']));
            }
            if($form_data['state']==2)
            {
                $insertData['last_checkout'] =date("Y-m-d H:i:s",strtotime($form_data['puch_time']));
            }

            $insertData['month']   = date("m",strtotime($form_data['puch_time']));
            $insertData['years']   = date("Y",strtotime($form_data['puch_time']));

                
               
    			$result = $this->attendance_model->save($insertData);
                if($result > 0)
                {


                    $dtl_data = array();
                    $dtl_data['att_id']     = $result;
                    $dtl_data['state']      = $form_data['state'];
                    $dtl_data['time']       = date("Y-m-d H:i:s",strtotime($form_data['puch_time']));
                    $dtl_data['att_date']   = date("Y-m-d",strtotime($form_data['puch_time']));
                    $dtl_data['month']   = date("m",strtotime($form_data['puch_time']));
                    $dtl_data['years']   = date("Y",strtotime($form_data['puch_time']));
                    $dtl_data['company_id'] = $company_id;
                    $dtl_data['created_at'] = date("Y-m-d H:i:s");
                    $dtl_data['created_by'] = $userid ;
                    $dtl_data['user_id']    = $userid;
                    $result_history = $this->attendance_history_model->save($dtl_data);
                   

                    $result_worked_hour  = $this->attendance_model->sum_worked_hour($result);


                    $date_a = new DateTime(@$result_worked_hour[0]->outtime);
                    $date_b = new DateTime(@$result_worked_hour[0]->intime);
                    $interval = date_diff($date_a,$date_b);

                     $insertData2 = array();
                    $insertData2['id'] = $result;
                    $insertData2['worked_hour'] = $interval->format('%h:%i:%s');
                    $this->attendance_model->save($insertData2);

                     

                    $this->session->set_flashdata('success', 'Puch successfully Added');
                     redirect(base_url().'admin/attendance');
                }
                else
                { 
                    $this->session->set_flashdata('error', ' Puch  Addition failed');
                     redirect(base_url().'admin/attendance/addnew');
                }
              
           redirect(base_url().'admin/attendance/addnew');
          }  
        
    }


    // Member list
    public function ajax_list()
    {
		$list = $this->attendance_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

             $temp_date = $currentObj->att_date;
             $dateAt = date("d M Y", strtotime($temp_date));

             $checkIndate = $currentObj->checkin;
             $InTime = date("h:i:s A", strtotime($checkIndate));

             $lastCheckIn = $currentObj->last_checkin;
             $lastInTime = date("h:i:s A", strtotime($lastCheckIn));
             $lastCheckOut = $currentObj->last_checkout;
             $lastOutTime = date("h:i:s A", strtotime($lastCheckOut));



            $date1 = $lastCheckIn;
            $date2 = $lastCheckOut;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $hour = round(abs($timestamp2 - $timestamp1)/(60*60),2) . " hour(s)";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dateAt; 
            $row[] = $InTime; 
            $row[] = $lastInTime; 
            $row[] = $lastOutTime; 
            $row[] = $currentObj->worked_hour; 
            $row[] = '<a class="btn btn-sm btn-info" href="'.base_url().'admin/attendance/view/'.$currentObj->id.'" title="Details" ><i class="fa fa-eye"></i></a>&nbsp;';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->attendance_model->count_all(),
                        "recordsFiltered" => $this->attendance_model->count_filtered(),
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
            redirect('admin/roles');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->attendance_model->save($insertData);
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
        exit;
    } 

    // Edit
 
    public function edit($id = NULL,$uid=null)
    {
        

         if($id)
        {
            $this->global['module_id']      = get_module_byurl('admin/attendance');
            $role_id                        = $this->session->userdata('role_id');
            $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
           
            if($action_requred->edit !=='edit')
            {
                $this->session->set_flashdata('error', 'Un-autherise Access');
                redirect(base_url());
            }

         }
    
        


         if(isset($uid) && $uid !=='')
        {
             $userid        = $uid;
        }else
        {
            $userid         = $this->session->userdata('userId');
        }


        $data = array();
        $where = array();
        $where['status !='] = 2;
        $where['field'] = 'id,name,title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);

        $where = array();
        
        $where['id']     = $id;
         
        $checkInOutHistory = $this->attendance_history_model->findDynamic($where);
        if(!empty($checkInOutHistory))
        {
            $data['checkInOutStatus'] = $checkInOutHistory[0]->state;
            $data['checkInOutHistoryData'] = $checkInOutHistory[0];
        }
         $where = array();
        $where['status'] = '1';
        $data['all_roles'] = $this->role_model->findDynamic($where);
        
        $this->global['pageTitle'] = 'Edit Employee Attendance';
        $this->loadViews("admin/attendance/edit", $this->global, $data , NULL);
        
    }   
    // Edit
 
    public function view($id = NULL,$date,$userid)
    {
        

        $this->isLoggedIn();

            $this->global['module_id']      = get_module_byurl('admin/attendance');
            $role_id                        = $this->session->userdata('role_id');
            $role                           = $this->session->userdata('role');
            $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
            if(empty($action_requred))
            {
                $this->session->set_flashdata('error', 'Un-autherise Access');
                redirect(base_url());
            }

            if($id == null)
            {
                redirect('admin/attendance');
            }

         $data = array();
        $this->global['pageTitle'] = 'Attendance Details ';
        $this->loadViews("admin/attendance/view", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->attendance_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Country*************************************************************
    public function update()
    {
        $this->isLoggedIn();
        
        
        
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('puch_time','Punch Time','trim|required');
          
         
        

        
        
        //form data 
        $form_data  = $this->input->post();
        $id         =  $form_data['id'];
        $uid        =  $form_data['uid'];
        $att_id     =  $form_data['att_id'];
         
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id,$uid);
        }
        else
        {
            $company_id = $this->session->userdata('company_id');
            $userid = $this->session->userdata('userId');

            $this->global['module_id']      = get_module_byurl('admin/attendance');
            $role_id                        = $this->session->userdata('role_id');
            $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
           
            if($action_requred->edit !=='edit')
            {
                $this->session->set_flashdata('error', 'Un-autherise Access');
                redirect(base_url());
            }

 
            


             
            $insertData = array();

            $insertData['id'] = $att_id;
            $insertData['update_at']   = date("Y-m-d H:i:s");
            $insertData['updated_by']   = $this->session->userdata('userId') ;
             
            if($form_data['state']==1)
            {
                $insertData['last_checkin'] =date("Y-m-d H:i:s",strtotime($form_data['puch_time']));
            }
            if($form_data['state']==2)
            {
                $insertData['last_checkout'] =date("Y-m-d H:i:s",strtotime($form_data['puch_time']));
            }

            $insertData['month']   = date("m",strtotime($form_data['puch_time']));
            $insertData['years']   = date("Y",strtotime($form_data['puch_time']));

                
               
                $result = $this->attendance_model->save($insertData);
                if($result > 0)
                {


                    $dtl_data = array();
                    $dtl_data['att_id']     = $result;
                    $dtl_data['id']         = $id;
                    $dtl_data['state']      = $form_data['state'];
                    $dtl_data['time']       = date("Y-m-d H:i:s",strtotime($form_data['puch_time']));
                    $dtl_data['att_date']   = date("Y-m-d",strtotime($form_data['puch_time']));
                    $dtl_data['month']   = date("m",strtotime($form_data['puch_time']));
                    $dtl_data['years']   = date("Y",strtotime($form_data['puch_time']));
                    $dtl_data['company_id'] = $company_id;
                    $dtl_data['update_at'] = date("Y-m-d H:i:s");
                    $dtl_data['updated_by'] = $userid ;
                    $dtl_data['user_id']    = $uid;
                    $result_history = $this->attendance_history_model->save($dtl_data);
                   

                    $result_worked_hour  = $this->attendance_model->sum_worked_hour($result);


                    $date_a = new DateTime(@$result_worked_hour[0]->outtime);
                    $date_b = new DateTime(@$result_worked_hour[0]->intime);
                    $interval = date_diff($date_a,$date_b);

                     $insertData2 = array();
                    $insertData2['id'] = $result;
                    $insertData2['worked_hour'] = $interval->format('%h:%i:%s');
                    $this->attendance_model->save($insertData2);

                     

                    $this->session->set_flashdata('success', 'Puch successfully Added');
                     redirect(base_url().'admin/attendance/att_emp_detail/'.$uid);
                }
                else
                { 
                    $this->session->set_flashdata('error', ' Puch  Addition failed');
                     redirect(base_url().'admin/attendance/att_emp_detail/'.$uid);
                }
              
           redirect(base_url().'admin/attendance/att_emp_detail/'.$uid);
          } 
        
    }

    public function trash_attendence()
    {
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        $att_id = $this->input->post('att_id');  
        $state = $this->input->post('state');  
        $result2 = 0;

        $insertData = array();

        $insertData['id'] = $att_id;
        $insertData['update_at']   = date("Y-m-d H:i:s");
        $insertData['updated_by']   = $this->session->userdata('userId') ;
         
        if($state==1)
        {
            $insertData['last_checkin'] =null;
        }
        if($state==2)
        {
            $insertData['last_checkout'] =null;
        }

        


        $result = $this->attendance_model->save($insertData);
        if($result)
        {
            $result2 = $this->attendance_history_model->delete($delId); 


            $where = array();
            $where['att_id']     = $result;
            $checkInOutHistory = $this->attendance_history_model->findDynamic($where);
            if(empty($checkInOutHistory))
            {
                $result3 = $this->attendance_model->delete($att_id); 
            }else
            {
                $result_worked_hour  = $this->attendance_model->sum_worked_hour($result);


                $date_a = new DateTime(@$result_worked_hour[0]->outtime);
                $date_b = new DateTime(@$result_worked_hour[0]->intime);
                $interval = date_diff($date_a,$date_b);

                $insertData2 = array();
                $insertData2['id'] = $result;
                $insertData2['worked_hour'] = $interval->format('%h:%i:%s');

                $this->attendance_model->save($insertData2);    
            }


            
           
        }




        

            
        if ($result2 > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

      //Exporting attendence data
    public function exportattn() {

        $this->form_validation->set_rules('start_date', ('start_date'),'required');
        $this->form_validation->set_rules('end_date', ('end_date'),'required');

        if ($this->form_validation->run() === true) {

            $data = $this->input->post();

            // create file name
             

            $content = "Employee ID,Date Format ,In time,Out time\n";

            //fetch data from db starts
            $appData = $this->attendance_history_model->get_attendence($data);

            $temp_uid = "";
            $temp_date = "";
            $ix = 1;

            $final_data = "";
            $i=1;

            // set Row
            $rowCount = 2;
            foreach ($appData as $value) 
            {
                $dt = new DateTime($value->time);

                if($temp_uid != $value->user_id ){

                    $temp_uid = $value->user_id;
                    $temp_date = $value->time;
                    $ix++;
                    $i=1;

                 }
                 else if(date("Y-m-d", strtotime($temp_date)) != date("Y-m-d", strtotime($value->time))){
                    
                    $rowCount++;
                    $temp_date = $value->time;

                    $i=1;
                 }

                if($i%2 !=0){

                     $content.= str_replace(",", " ", @$value->user_id).",";
                    $content.= str_replace(",", " ", @date("Y-m-d", strtotime($value->time))).",";
                    $content.= str_replace(",", " ", $dt->format('H:i:s')).",";
 

                     

                } else {

                    $content.= str_replace(",", " ", $dt->format('H:i:s')).",";
                    
                    $rowCount++;
                    $content.="\n";
                }



                 
                $i++;
            }
     
            $filename = 'attendance-export-'.date('d-m-Y-h-s').'.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        print_r($content);
         die;
            

        }else{
             $this->session->set_flashdata('exception',  ('Please Try Again'));
             redirect(base_url().'admin/attendance');
        }

        
    }
    

    public function datebetween_attendance()
    {

        

            $this->isLoggedIn();

            $data           = array();
            $conditions     = array();
            $where_search   = array();
            $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid        = $uid;
            }else
            {
                $userid         = $this->session->userdata('userId');
            }



            

            $search_userid      = @$userid;
            $start_date          = @$this->input->get('start_date'); 
            $end_date            = @$this->input->get('end_date'); 
             

                if(!empty($search_userid))
                {
                    $where_search['user_id'] =  $search_userid;
                }
                 
                if(!empty($start_date))
                {
                     $where_search['start_date'] =  $start_date;
                 }
                if(!empty($end_date))
                {
                     $where_search['end_date'] =  $end_date;
                 }

            $conditions['returnType'] = 'count'; 
            $conditions['userid'] = $userid; 
            $conditions['where'] = $where_search; 
            $totalRec = $this->attendance_model->getRowsAtt($conditions);


            $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 4; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/attendance/datebetween_attendance'; 
                $config['uri_segment'] = $uriSegment; 
                $config['total_rows']  = $totalRec; 
                $config['per_page']    = $this->perPageAtt; 
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  float-end mt-4" id="query-pagination">';
            $config['full_tag_close'] = '</ul> ';
             
            $config['first_link'] = 'First&nbsp;Page';
            $config['first_tag_open'] = '<li class="page-item">  ';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last&nbsp;Page';
            $config['last_tag_open'] ='<li class="page-item">  ';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="page-item"> ';
            $config['next_tag_close'] = ' </li>';
 
            $config['prev_link'] = 'Previous';
            $config['prev_tag_open'] = '<li class="page-item"> ';
            $config['prev_tag_close'] = '</li>';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link active">';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="page-item"> ';
            $config['num_tag_close'] = ' </li>';

                // Initialize pagination library 
                $this->pagination->initialize($config); 
                
              

                // Define offset 
                $page = $this->uri->segment($uriSegment); 
                $offset = (!$page)?0:$page; 

                if($offset != 0){
                    $offset = ($offset-1) * $this->perPageAtt;
                }

 
                // Get records 
                $conditions = array( 
                'start' => $offset, 
                'where' => $where_search, 
                'userid' =>  $userid, 
                'limit' => $this->perPageAtt 
                ); 

                
                    /*$conditions['userid'] = $userid;
                $conditions['form_type'] = $form_type;  echo "<pre>";
                    print_r( $conditions);
                    echo "</pre>"; */

                 $data['attendance']   = $this->attendance_model->getRowsAtt($conditions); 


 
                $data['pagination'] = $this->pagination->create_links(); 
 
                $data['pagination_total_count'] =  $totalRec;


        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_agents'] = $this->admin_model->findDynamic($where);


        $this->global['module_id']      = get_module_byurl('admin/attendance');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }


        $where = array();
        $where['id']         = $userid ;
        $where['field']         = 'title';
         
        $userData             = $this->admin_model->findDynamic($where);
        if(!empty($userData))
        {
            $data['username'] = $userData[0];
        }

        $this->global['pageTitle'] = 'Attendance';
        $this->global['pageTitle'] = 'admin/attendance';

        $this->loadViews("admin/attendance/datebetween-attendance", $this->global, $data , NULL);


        
    }

    public function insert_csv_attendance()
    {   

         if($_FILES['upload_data_csv']['size'] > 0)
        {
              $varables = [];
               $inc = 1;
               $current_date = date('Y-m-d Hi:s');
                $filename = $_FILES["upload_data_csv"]["tmp_name"];
            $file = fopen($filename, "r");
            $file2 = fopen($filename, "r");
             while($getData = fgetcsv($file, 10000, ","))
            {

               
                      

               if($inc==1)
               { 
                for ($i=0; $i < count($getData); $i++) 
                { 
                    $varables[] = $getData[$i];   
                }
               /* $error      = count($getData);
                $message    =  $varables ;*/
              } 
                
                $inc++; 
            }

             $inc = 1;
             
                
             if(!empty($varables))
            {
                 while ($getData = fgetcsv($file2, 10000, ","))
                {
                   
                    if($inc !== 1)
                    {

                        $employee_id = $getData[0];    
                        $date =         $getData[1];
                        $in =  $getData[2];
                        $out = $getData[3];
                        $attdate = date('Y-m-d', strtotime($date));
                        $in_time = date('H:i:s', strtotime($in));
                        $out_time = date('H:i:s', strtotime($out));
                        $indatetime = $attdate.' '.$in_time;
                        $outdatetime = $attdate.' '.$out_time;

                        $indata = array(
                            'user_id'    => $employee_id,
                            'att_date'    => $attdate,
                            'state'  => 1,
                            'time'   => $indatetime,
                        );
                        $outdata = array(
                            'user_id'    => $employee_id,
                            'att_date'    => $attdate,
                            'state'  => 2,
                            'time'   => $outdatetime,
                        );

                        if(empty($employee_id)){
                            $employee_msg = "";
                        }else{
                            $employee_msg = "For employee id ";
                        }

                        $where = array();
                        $where['att_date']  = $attdate;
                        $where['status']    = 1;
                        $where['user_id']   = $employee_id;
                        $attendaceMaped     = $this->attendance_model->findDynamic($where);

                            $insertData = array();
                            if(!empty($attendaceMaped))
                            {
                                $id = $attendaceMaped[0]->id;
                                $insertData['id']       = $id;
                                
                            } 
                         

                             
                            $insertData['last_checkin']     = $indatetime;
                            $insertData['att_date']         = $attdate;
                            $insertData['status']           = 1;
                            $insertData['user_id']          = $employee_id;
                            $att_id                         = $this->attendance_model->save($insertData);
                        
                        //Checking In time avalable or not
                        if(!empty($in)){

                            $respo_atten = $this->attendance_history_model->findDynamic($indata);
                            if(empty($respo_atten)){
                                $indata['created_at']   = $current_date;
                                $indata['att_id']       = $att_id;

                                $this->attendance_history_model->save($indata);
                            } 
                        }else{

                            $this->session->set_flashdata('error', "".$employee_msg.""."".$employee_id." In time data is missing at row no ".$inc." , Please correct your data and upload again.");
                        redirect(base_url().'admin/attendance');
                        }

                        //Checking Out time avalable or not
                        if(!empty($out)){
     
                            $respo_atten = $this->attendance_history_model->findDynamic($outdata);
                            if(empty($respo_atten)){
                                    $outdata['created_at']  = $current_date;
                                    $outdata['att_id']       = $att_id;
                                $this->attendance_history_model->save($outdata);
                            } 
                        }else{

                           $this->session->set_flashdata('error', "".$employee_msg.""."".$employee_id." Out time data is missing at row no ".$inc." , Please correct your data and upload again.");
                            redirect(base_url().'admin/attendance');
                        }


                            $result_worked_hour  = $this->attendance_model->sum_worked_hour($att_id);
                            $last_check_in  = $this->attendance_model->last_check_in($att_id);


                            $date_a = new DateTime(@$result_worked_hour[0]->outtime);
                            $date_b = new DateTime(@$result_worked_hour[0]->intime);
                            $interval = date_diff($date_a,$date_b);

                            $insertData2 = array();
                            $insertData2['id']              = $att_id;
                            $insertData2['checkin']         = @$result_worked_hour[0]->intime;
                            $insertData2['last_checkout']   = @$result_worked_hour[0]->outtime;
                            $insertData2['last_checkin']   = @$last_check_in[0]->lastintime;
                            $insertData2['worked_hour']     = $interval->format('%h:%i:%s');
                            $this->attendance_model->save($insertData2);


                    }
                   


                      $inc++;
                }



                $this->session->set_flashdata('success',   ('Successfully Uploaded'));
                redirect(base_url().'admin/attendance?uid=all');
            }




        }else
        {
            $this->session->set_flashdata('error', "Please select a file to upload attendance as given sample file.");
            redirect(base_url().'admin/attendance?uid=all');

            
        }
    }

    public function insert_csv_temp()
    {
        $error =0;
         $message = 'Empty';

        $filename = $_FILES["file"]["tmp_name"];
        if ( 0 < $_FILES['file']['error'] ) 
        {
         
            $error = 1;
            $message = $_FILES['file']['error'];

        }
        else
        {

            $file = fopen($filename, "r");
            $file2 = fopen($filename, "r");
            $file3 = fopen($filename, "r");
            $inc = 1;

            $varables = [];
            while($getData = fgetcsv($file, 10000, ","))
            {

               if($inc==1)
               { 
                for ($i=0; $i < count($getData); $i++) 
                { 
                    $varables[] = $getData[$i];   
                }
               /* $error      = count($getData);
                $message    =  $varables ;*/
              } 
                
                $inc++; 
            }

            if(!empty($varables))
            {
                 $inc = 1;
                    while($getData = fgetcsv($file2, 10000, ","))
                    {

                        if($inc==1)
                        {

                        }
                        else
                        {
                            for ($i=0; $i < count($varables); $i++)
                            {
                                if($getData[$i] =='' && ($varables[$i] =='Employee ID' || $varables[$i] =='Date Format' || $varables[$i] =='In time' || $varables[$i] =='Out time'))
                                {
                                    $error      = 1;
                                    $message    =  "Field <strong>".$varables[$i]."</strong> Is Missing on Line Number ".($inc);
                                     ;
                                } 

                                if($error ==1)
                                {
                                     $message_arr = array(
                                            'error'=>$error,
                                            'message'=>$message
                                        );

                                    echo json_encode($message_arr);die;
                                }
                            }
                        }
                        
                        $inc++; 
                    }
                     $inc = 1;


                 


            }else
            {
                $error      = 1;
                $message    =  "Main header Section Is Missing !";
            }


             
            
             
        }

         $message_arr = array(
            'error'=>$error,
            'message'=>$message
        );

    echo json_encode($message_arr);die;
    }

    
    
}

?>