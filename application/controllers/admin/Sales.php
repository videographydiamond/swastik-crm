<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Sales extends BaseController
{


   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/company_model');
        $this->load->model('admin/booking_status_model');
        $this->load->model('admin/booking_payments_model');
        $this->load->model('admin/payment_mode_model');
        $this->load->model('admin/payment_type_model');
        $this->load->model('admin/agent_model');
        $this->load->model('admin/product_model');
        $this->load->model('admin/customer_model');
        $this->load->model('admin/farmers_model');
        $this->load->model('admin/city_model');
        $this->load->model('admin/state_model');
        $this->load->model('admin/district_model');
        $this->load->model('admin/call_type_model');
        $this->load->model('admin/call_direction_model');
        $this->load->model('admin/customer_call_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/admin_model');
        $this->load->model('admin/sale_model');
        $this->load->model('admin/sale_dtl_model');

        $this->perPage =100; 
    }

    


    public function index()
    {



        $this->isLoggedIn();


        $this->global['module_id']      = get_module_byurl('admin/sales');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(empty($action_requred))
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }



          $data = array();

            $uid         = $this->input->get('uid');
            if(isset($uid) && $uid !=='')
            {
                 $userid   = $uid;
            }else
            {
                $userid = $this->session->userdata('userId');
            }

            
            
 
            $conditions = array(); 
            $where_search = array();

            $data['edit_data'] = array();
            $data['customer_call_dtl'] = array();

            $form_type  = $this->input->get('form_type');
            
                
        

                $where_search =  array();
                 $search_farmer_id    = @$this->input->get('farmer_id');
                $search_name         = @$this->input->get('customer_name');
                $search_mobile       = @$this->input->get('customer_mobile');
                $search_alt_mobile   = @$this->input->get('customer_alter_mobile');
                $status1              = @$this->input->get('status1');
                $state2              = @$this->input->get('state2');
                $district2           = @$this->input->get('district2');
                $city2               = @$this->input->get('city2');
                $invoice_no          = @$this->input->get('invoice_no'); 
                $invoice_date        = @$this->input->get('invoice_date'); 
                 
                if(!empty($invoice_date))
                {
                     $where_search['booking_date'] =  $invoice_date;
                }
                if(!empty($invoice_no))
                {
                    $where_search['id'] =  $invoice_no;
                }
                if(!empty($search_farmer_id))
                {
                    $where_search['farmer_id'] =  $search_farmer_id;
                }
                if(!empty($search_name))
                {
                    $where_search['customer_name'] =  $search_name;
                } 
                 if(!empty($status1))
                {
                    $where_search['booking_status'] =  $status1;
                } 
                
                if(!empty($search_mobile))
                {
                    $where_search['customer_mobile'] =  $search_mobile;
                }
                if(!empty($search_alt_mobile))
                {
                    $where_search['customer_alter_mobile'] =  $search_alt_mobile;
                }
                if(!empty($state2))
                {
                    $where_search['state'] =  $state2;
                }
                
                if(!empty($district2))
                {
                    $where_search['district'] =  $district2;
                }
                if(!empty($city2))
                {
                    $where_search['city'] =  $city2;
                }
                if(!empty($search_type))
                {
                    $where_search['search_type'] =  $search_type;
                } 
               

                
                 
               
                    $conditions['returnType'] = 'count'; 
                    $conditions['userid'] = $userid; 
                    $conditions['form_type'] = $form_type; 
                    $conditions['where'] = $where_search; 
                    $totalRec = $this->sale_model->getRows($conditions);

 




            $this->load->library('pagination'); 

                $conditions = array(); 
                
                $uriSegment = 4; 

                // Get record count 
                

                // Pagination configuration 
                $config['base_url']    = base_url().'admin/sales/index'; 
                $config['uri_segment'] = $uriSegment; 
                $config['total_rows']  = $totalRec; 
                $config['per_page']    = $this->perPage; 
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;
             

 
  


            $config['full_tag_open'] = ' <ul class="pagination  justify-content-center mt-4" id="query-pagination">';
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
                'form_type' => $form_type, 
                'limit' => $this->perPage 
                ); 

                
                    /*$conditions['userid'] = $userid;
                $conditions['form_type'] = $form_type;  echo "<pre>";
                    print_r( $conditions);
                    echo "</pre>"; */

                 $data['bookings']   = $this->sale_model->getRows($conditions); 


 
                $data['pagination'] = $this->pagination->create_links(); 
 
                $data['pagination_total_count'] =  $totalRec;
 
                   

/* 
  echo "<pre>";
print_r($this->db->last_query());  
echo "</pre>";  */



         $form_type  = $this->input->get('form_type');
         if($form_type =='search')
         {
            $customer_id    = $this->input->get('customer_id');
            $mobile         = $this->input->get('mobile');

            

            if($customer_id !=='' || $mobile !=='')
            {   
                $isserch = false;
                $where = array();
                if(!empty($customer_id))
                {   
                    $isserch = true;

                     $where['sku_id'] = $customer_id;
                }

                if(!empty($mobile))
                {
                    $isserch = true;
                     $where['customer_mobile'] = $mobile;
                }

                if($isserch)
                {

                    $customer = $this->customer_model->findDynamic($where);
                    if(!empty($customer))
                    {
                        $data['edit_data'] = $customer[0];


                        $where = array();
                        $where['customer'] = $data['edit_data']->id;
                        //$data['customer_call_dtl'] =$this->customer_call_detail($data['edit_data']->id);
                       // $data['customer_call_dtl'] = $this->customer_call_model->findDynamic($where);
                    }
                    


                     
                }



                
                 
                 
                
            }

         }
         



        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,customer_name,customer_title,sku_id';
        $data['all_customers'] = $this->customer_model->findDynamic($where);
        
        $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,name,title';
        $data['all_users'] = $this->admin_model->findDynamic($where);

                $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['states'] = $this->state_model->findDynamic($where);

        /*$where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['districts'] = $this->district_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        $data['cities'] = $this->city_model->findDynamic($where);*/

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['payments_types'] = $this->payment_type_model->findDynamic($where);

        

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'id';
        $data['calltypes'] = $this->call_type_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['bookings_status'] = $this->booking_status_model->findDynamic($where); 

        $where = array();
        $where['status !='] = '0';
        $where['orderby'] = '-id';
        $data['all_agents'] = $this->admin_model->findDynamic($where);
        

         


        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $where['field'] = 'id,name,title';
        $data['all_products'] = $this->product_model->findDynamic($where); 


        

 


         $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['calldirections'] = $this->call_direction_model->findDynamic($where); 

        

         



  
        

       /* echo "<pre>";
        print_r($data['show_summary']);die;
         echo "</pre>";*/
        $this->global['pageTitle'] = 'Sales';
        $this->loadViews("admin/sale/list", $this->global, $data , NULL);
        
    }

    // Add New 

    public function create()
    {
    
            $this->isLoggedIn();
                

     $this->global['module_id']      = get_module_byurl('admin/sales');
    $role_id                        = $this->session->userdata('role_id');
    $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
    if(@$action_requred->create !=='create')
    {
        $this->session->set_flashdata('error', 'Un-autherise Access');
        redirect(base_url());
    }


            $data = array();
            $userid = $this->session->userdata('userId');
            $company_id = $this->session->userdata('company_id');

            $where = array();
        $where['status'] = '1';
        $where['field'] = 'id,customer_name,customer_title,sku_id';
        $data['all_customers'] = $this->customer_model->findDynamic($where);
        
        $where = array();
        $where['status'] = '1'; 
        $where['field'] = 'id,name,title';
        $data['all_users'] = $this->admin_model->findDynamic($where);


        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['states'] = $this->state_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['districts'] = $this->district_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        $data['cities'] = $this->city_model->findDynamic($where);

         

         
         $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['payments_mode'] = $this->payment_mode_model->findDynamic($where);

         
        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['all_products'] = $this->product_model->findDynamic($where); 

        $where = array();
        $where['status !='] = '0';
        $where['orderby'] = '-id';
        $data['all_agents'] = $this->admin_model->findDynamic($where); 


          
         
        $data['company_data'] = $this->company_model->find($company_id);
        

 

        $this->global['pageTitle'] = 'Add New Sales';
        $this->loadViews("admin/sale/addnew", $this->global, $data , NULL);
        
    } 

    // Insert Member *************************************************************
    public function insertnow()
    {

          
        $this->isLoggedIn();
		$this->load->library('form_validation');            
        $this->form_validation->set_rules('farmer_id','Farmer','trim|required');
        $this->form_validation->set_rules('customer_name','customer_name','trim|required');
        $this->form_validation->set_rules('customer_mobile','customer_mobile','trim|required');
         
        $company_id = $this->session->userdata('company_id');
        
        //form data 
        
        if($this->form_validation->run() == FALSE)
        {
            $this->create();
        }
        else
        {

             $form_data  = $this->input->post();



                   


           

            $insertData = array();
            
            $insertData['farmer_id']                    = $form_data['farmer_id'];
            $insertData['booking_id']                   = $form_data['booking_id'];
            $insertData['customer_name']                = $form_data['customer_name'];
            $insertData['customer_mobile']              = $form_data['customer_mobile'];
            $insertData['customer_alter_mobile']        = $form_data['customer_alter_mobile'];
            $insertData['state']                        = $form_data['state'];
            $insertData['district']                     = $form_data['district'];
            $insertData['city']                         = $form_data['city'];
            $insertData['reverse_charge']               = $form_data['reverse_charge'];
            $insertData['booking_date']                 = (isset($form_data['booking_date']) && $form_data['booking_date'] !=='')?$form_data['booking_date']:date("Y-m-d H:i:s");
            $insertData['supply_address']               = $form_data['supply_address'];
            $insertData['supply_date']                  = $form_data['supply_date'];
            $insertData['vehicle_no']                   = $form_data['vehicle_no'];
            $insertData['transport_type']               = $form_data['transport_type'];
            $insertData['agent_id']                     = $this->session->userdata('userId');
            $insertData['created_by']                   = $this->session->userdata('userId');
            $insertData['assigned_to']                  = $this->session->userdata('userId');
            $insertData['company_id']                   = $company_id;
            $insertData['bank_trans_id']                = $form_data['bank_trans_id'];
            $insertData['booking_status']               = 'completed';
            $insertData['billing_address']              = $form_data['billing_address'];
            $insertData['same_billing']                 = (isset($form_data['same_billing'])?($form_data['same_billing']):'');
            $insertData['delivery_address']             = $form_data['delivery_address'];
            $insertData['create_date']                  = date("Y-m-d");
            $insertData['comment']                      = $form_data['comment'];
            $insertData['trans_desctription']           = $form_data['trans_desctription'];

            $result_insert  = $this->sale_model->save($insertData);

            
                                



                         

 
                if(!empty($result_insert))
                {

                    $items = $form_data['items'];
                    $gst_amountss = 0;
                    $discount_amount = 0;
                    if(!empty($items))
                    {

                        foreach ($items as $item) {

                            $gst_amountss       = $gst_amountss + $item['gstVal'];
                            $discount_amount    = $discount_amount + $item['discount'];

                            $insertData_dtl = array();
                            $insertData_dtl['farmer_id']        = $form_data['farmer_id'];
                            $insertData_dtl['sale_id']          = $result_insert;
                            $insertData_dtl['booking_id']       = $form_data['booking_id'];
                            $insertData_dtl['product_id']       = $item['product_id'];
                            $insertData_dtl['tax_rate']         = $item['gst'];
                            $insertData_dtl['tax_amount']       = $item['gstVal'];
                            $insertData_dtl['cgst_amount']      = $item['cgstVal'];
                            $insertData_dtl['cgst_rate']        = $item['cgstRate'];
                            $insertData_dtl['sgst_amount']      = $item['sgstVal'];
                            $insertData_dtl['sgst_rate']        = $item['sgstRate'];
                            $insertData_dtl['igst_amount']      = $item['igstVal'];
                            $insertData_dtl['igst_rate']        = $item['igstRate'];
                            $insertData_dtl['price']            = $item['price'];
                            $insertData_dtl['quantity']         = $item['quantity'];
                            $insertData_dtl['discount']         = $item['discount'];
                            $insertData_dtl['sub_total_amount'] = $item['subTotalAmount'];
                            $result_dtl_insert  = $this->sale_dtl_model->save($insertData_dtl);

                            


                        }
                    }
                    $insertData = array();
                    $insertData['id']                           = $result_insert;
                    $insertData['outstanding_amount']           = $form_data['balance'];
                    $insertData['gst_amount']                   = $gst_amountss;
                    $insertData['discount_amount']              = $discount_amount;
                    $insertData['balance']                      = $form_data['balance'];
                    $insertData['total']                        = $form_data['total'];
                    /*$insertData['advance']                      = $form_data['advance'];
                    $insertData['total_paid_amount']            = $form_data['advance'];*/
                    $insertData['payment_mode']                 = $form_data['payment_mode'];
                    $insertData['cheque_no']                    = $form_data['cheque_no'];
                    $insertData['bank_name']                    = $form_data['bank_name'];
                    $insertData['bank_branch']                  = $form_data['bank_branch'];

                     $this->sale_model->save($insertData);
                    



                    /*Start booking_payments_model*/
                    if($form_data['advance']  >0)
                    {
                        $insertData = array();
                        $insertData['amount']                       = $form_data['advance'];
                        $insertData['date_at']                      = date("Y-m-d H:i:s");
                        $insertData['payment_date']                 = $form_data['create_date'];
                        $insertData['created_by']                   = $this->session->userdata('userId');
                        $insertData['booking_id']                   = $result_insert;
                        $insertData['transaction_type']             = "sale";
                        $insertData['farmer_id']                    = $form_data['farmer_id'];
                        $insertData['status']                       =1;
                        $insertData['payment_mode']                 = $form_data['payment_mode'];
                        $insertData['cheque_no']                    = $form_data['cheque_no'];
                        $insertData['bank_name']                    = $form_data['bank_name'];
                        $insertData['bank_branch']                  = $form_data['bank_branch'];
                        $insertData['company_id']                   = $company_id;
                        $insertData['bank_transaction_id']          = $form_data['bank_trans_id'];
                         $this->booking_payments_model->save($insertData);
                    }

                     $this->update_amount($result_insert);
                    /*End booking_payments_model*/
                    $this->session->set_flashdata('success', 'Sales successfully Added');

                    
                }else
                {
                     $this->session->set_flashdata('error', 'Sales  Addition failed!');
                }

                    redirect(base_url().'admin/sales');
          }  
        
    } 

    public function insert_call_now()
    {
        $this->isLoggedIn();
        
        
        
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('customer','customer_name','trim|required');
        $this->form_validation->set_rules('call_type','call_type','trim|required');
        $this->form_validation->set_rules('assign_to','assign_to','trim|required');
        $this->form_validation->set_rules('call_back_date','call_back_date','trim|required');
        $this->form_validation->set_rules('call_direction','call_direction','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
                
                //pre($form_data);exit;
                $insertData['customer']              = $form_data['customer'];
                $insertData['call_type']                = $form_data['call_type'];
                $insertData['assign_to']                = ($form_data['assign_to']);
                $insertData['user_id']                = ($form_data['assign_to']);
                $insertData['call_back_date']           = $form_data['call_back_date'];
                $insertData['call_direction']           = $form_data['call_direction'];
                $insertData['current_conversation']     = $form_data['current_conversation'];
                $insertData['status']                   = '1';
                $insertData['date_at']                  = date("Y-m-d H:i:s");

                 
                $result = $this->customer_call_model->save($insertData);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Call Detail successfully Added');
                }
                else
                { 
                    $this->session->set_flashdata('error', 'Call Detail Addition failed');
                }
              
            redirect('admin/customer/addnew');
          }  
        
    }

    
    // Member list
    public function ajax_list()
    {
		$list = $this->customer_model->get_datatables();
		
		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn" name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
            $dateAt = date("d-m-Y H:ia", strtotime($temp_date));

            $no++;
            $row = array();
            $row[] = '<div class="btn-group">
                        <span class="badge bg-primary dropdown-toggle text-white dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                        Action<i class="mdi mdi-chevron-down"></i>
                        </span>
                        <div class="dropdown-menu" style="">
                        <a class="dropdown-item btn side_modal" data-userid="'.$currentObj->id.'"   >View</a>
                        <a class="dropdown-item text-danger deletebtn" href="#" data-userid="'.$currentObj->id.'">Delete</a>
                         
                        
                        </div>
                        </div>';

                                            /*<a  class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"  href="'.base_url().'admin/customer/edit/'.$currentObj->id.'" >
                                                                View Details
                                                            </a><a  class="btn btn-primary btn-sm btn-rounded waves-effect waves-light deletebtn  href="#" data-userid="'.$currentObj->id.'" >
                                                                Delete
                                                            </a>*/
            $row[] = $dateAt;
            
            $row[] = $currentObj->sku_id;
            $row[] = $currentObj->customer_title;
            $row[] = $currentObj->customer_mobile;
            $row[] = $currentObj->customer_alter_mobile;
            $row[] = $currentObj->state;
            $row[] = $currentObj->district;
            $row[] = $currentObj->city;
            $row[] = $currentObj->leatest_calltype;
            $row[] = $currentObj->leatest_calldir;
            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->customer_model->count_all(),
                        "recordsFiltered" => $this->customer_model->count_filtered(),
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
            redirect('admin/agency');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->customer_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
         

        $this->isLoggedIn();

        $this->global['module_id']      = get_module_byurl('admin/sales');
        $role_id                        = $this->session->userdata('role_id');
        $action_requred                 = get_module_role($this->global['module_id']['id'],$role_id);
        if(@$action_requred->edit !=='edit')
        {
            $this->session->set_flashdata('error', 'Un-autherise Access');
            redirect(base_url());
        }

        $data = array();
        $userid = $this->session->userdata('userId');
        $company_id = $this->session->userdata('company_id');





            $data['edit_data'] = array();

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['states'] = $this->state_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        $data['districts'] = $this->district_model->findDynamic($where);

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        $data['cities'] = $this->city_model->findDynamic($where);

         
        
  

        $where = array();
        $where['status']        = '1';
        $where['orderby']       = 'title';
        $data['payments_modes'] = $this->payment_mode_model->findDynamic($where);


        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['payments_types'] = $this->payment_type_model->findDynamic($where);

         

        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'title';
        $data['all_products'] = $this->product_model->findDynamic($where); 

         


         $data['edit_data'] = $this->sale_model->find($id);

        $where = array();

            $where['sale_id']       = $id; 
            $where['company_id']    = $company_id; 


            $invoice_dtls = $this->sale_dtl_model->getOrderDetail($where);
 
              $data['edit_order_dtail_data'] = $invoice_dtls;

         

        $data['company_data'] = $this->company_model->find($company_id);


        $data['payment_details']    = $this->booking_payments_model->getPaymentDetail($id,'sale'); 


        $this->global['pageTitle'] = 'Edit Sale Invoice';
         
        $this->loadViews("admin/sale/edit", $this->global, $data , NULL);
        
    } 

    // Delete  *****************************************************************
      function delete()
    {
        
        $this->isLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->sale_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE,'message'=>'successfully deleted'))); }
        else { echo(json_encode(array('status'=>FALSE,'message'=>'successfully deleted'))); }
    }

    // Update Agency*************************************************************
    public function update()
    {
		
        $this->isLoggedIn();
        
        
        $this->isLoggedIn();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('customer_name','customer_name','trim|required');
        $this->form_validation->set_rules('customer_mobile','customer_mobile','trim|required');
        $this->form_validation->set_rules('farmer_id','Farmer ','trim|required');
         
        $form_data  = $this->input->post();
        
        
        if($this->form_validation->run() == FALSE)
        {

              $this->edit($form_data['sale_id']);
             
        }
        else
        {
            $get_farmer_id = $form_data['farmer_id'];
               







                //$get_customerid

            $insertData = array();
            $insertData['id']                           = $form_data['sale_id'];
            $insertData['farmer_id']                    = $form_data['farmer_id'];
            $insertData['booking_id']                   = $form_data['booking_id'];
            $insertData['customer_name']                = $form_data['customer_name'];
            $insertData['customer_mobile']              = $form_data['customer_mobile'];
            $insertData['customer_alter_mobile']        = $form_data['customer_alter_mobile'];
            $insertData['state']                        = $form_data['state'];
            $insertData['district']                     = $form_data['district'];
            $insertData['city']                         = $form_data['city'];
            $insertData['reverse_charge']               = $form_data['reverse_charge'];
            $insertData['booking_date']                 = (isset($form_data['booking_date']) && $form_data['booking_date'] !=='')?$form_data['booking_date']:date("Y-m-d H:i:s");
            $insertData['supply_address']               = $form_data['supply_address'];
            $insertData['supply_date']                  = $form_data['supply_date'];
            $insertData['vehicle_no']                   = $form_data['vehicle_no'];
            $insertData['transport_type']               = $form_data['transport_type'];
            $insertData['booking_status']               = 'completed';
            $insertData['billing_address']              = $form_data['billing_address'];
            $insertData['same_billing']                 = (isset($form_data['same_billing'])?($form_data['same_billing']):'');
            $insertData['delivery_address']             = $form_data['delivery_address'];
            $insertData['update_at']                    = date("Y-m-d");
            $insertData['comment']                      = $form_data['comment'];
            $insertData['trans_desctription']           = $form_data['trans_desctription'];

            $result_insert  = $this->sale_model->save($insertData);




            $items = $form_data['items'];
                    $gst_amountss = 0;
                    $discount_amount = 0;
                    if(!empty($items))
                    {

                        foreach ($items as $item) {

                            $gst_amountss       = $gst_amountss + $item['gstVal'];
                            $discount_amount    = $discount_amount + $item['discount'];

                            $insertData_dtl = array();
                            if(isset($item['editid']) &&  $item['editid'] !=='')
                            {
                                $insertData_dtl['id']        = $item['editid'];    
                            }
                            $insertData_dtl['farmer_id']        = $form_data['farmer_id'];
                            $insertData_dtl['sale_id']          = $form_data['sale_id'];
                            $insertData_dtl['booking_id']       = $form_data['booking_id'];
                            $insertData_dtl['product_id']       = $item['product_id'];
                            $insertData_dtl['tax_rate']         = $item['gst'];
                            $insertData_dtl['tax_amount']       = $item['gstVal'];
                            $insertData_dtl['cgst_amount']      = $item['cgstVal'];
                            $insertData_dtl['cgst_rate']        = $item['cgstRate'];
                            $insertData_dtl['sgst_amount']      = $item['sgstVal'];
                            $insertData_dtl['sgst_rate']        = $item['sgstRate'];
                            $insertData_dtl['igst_amount']      = $item['igstVal'];
                            $insertData_dtl['igst_rate']        = $item['igstRate'];
                            $insertData_dtl['price']            = $item['price'];
                            $insertData_dtl['quantity']         = $item['quantity'];
                            $insertData_dtl['discount']         = $item['discount'];
                            $insertData_dtl['sub_total_amount'] = $item['subTotalAmount'];
                            $result_dtl_insert  = $this->sale_dtl_model->save($insertData_dtl);

                            


                        }
                    }
                    $insertData = array();
                    $insertData['id']                           = $form_data['sale_id'];
                    $insertData['outstanding_amount']           = $form_data['balance'];
                    $insertData['gst_amount']                   = $gst_amountss;
                    $insertData['discount_amount']              = $discount_amount;
                    $insertData['balance']                      = $form_data['balance'];
                    $insertData['total']                        = $form_data['total'];
                   /* $insertData['advance']                      = $form_data['advance'];
                    $insertData['total_paid_amount']            = $form_data['advance'];*/
                    
                    $this->sale_model->save($insertData);
            /*ADDING TO OUTSTANDING AMOUNT*/

                                $booking_id  = $form_data['sale_id'];
                               $this->update_amount($booking_id);

            /*ADDING TO OUTSTANDING AMOUNT END*/


                                



                         

 
                if( $result_insert || $result_dtl_insert  )
                {
                     $this->session->set_flashdata('success', 'Sales successfully Update');

                    
                }else
                {
                     $this->session->set_flashdata('error', 'You Have No Make Any Changes!');
                }
                redirect(base_url().'admin/sales'); 
                    
          }  

          
          /*redirect(base_url().'admin/bookings/'.$form_data['id'].'/edit'); */
        
    }

    public function customer_call_detail()
    {
         $form_data  = $this->input->post('id');
         $id = $form_data;
        if(empty($id))
        {
            $result = array();
        }else
        {
            /*start data*/
            $this->db->select('cc.*,user.title as username, call.title as calltype, direction.title as calldirection');
            $this->db->from('z_customer_call as cc');
            $this->db->where('cc.customer', $id);
            $this->db->join('z_admin as user', 'user.id = cc.assign_to', 'left');
            $this->db->join('z_call_type as call', 'call.id = cc.call_type', 'left');
            $this->db->join('z_call_direction as direction', 'direction.id = cc.call_direction', 'left');
            $this->db->order_by("cc.id", "desc");
            $query = $this->db->get(); 
            $result = $query->result_array();        

        /*end  data*/

        }
        $result = json_encode($result);
        echo  $result;
        


    }

    public function state_change($state_id='',$selectedDistrict='')
    {
          
        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'name';
        if(!empty($state_id))
        {
            $where['state_id'] = $state_id;
        }
        $districts = $this->district_model->findDynamic($where);
        $html_content = '<option value="">Choose District</option>';
        if(!empty($districts))
        {
            foreach ($districts as $district ) {
                $selected = '';
                if(isset($selectedDistrict) && $selectedDistrict ==$district->id)
                {
                    $selected = 'selected';
                }
                $html_content.= '<option value="'.$district->id .'" '.$selected.'>'.$district->name .'</option>';
            }    
        }
        echo $html_content;
        
    } 
    public function district_change($district_id='',$selected_city='')
    {
          
        $where = array();
        $where['status'] = '1';
        $where['orderby'] = 'city';
        if(!empty($district_id))
        {
            $where['district_id'] = $district_id;
        }
        $cities = $this->city_model->findDynamic($where);
        $html_content = '<option value="">Choose Tehsil</option>';
        if(!empty($cities))
        {
            foreach ($cities as $city ) {
                $selected = '';
                if(isset($selected_city) && $selected_city ==$city->id)
                {
                    $selected = 'selected';
                }
                $html_content.= '<option value="'.$city->id .'" '.$selected.'>'.$city->city .'</option>';
            }    
        }
        echo $html_content;
        
    }

    public function change_booking_status($id)
    {

        
        $this->isLoggedIn();
        $update_booking_status  = $this->input->post('update_booking_status');
        $insertData                 = array();
        $insertData['id']           = $id;
        $insertData['booking_status']= $update_booking_status;
        $result = $this->booking_model->save($insertData);

        $single_arr     = $this->booking_model->find($id);
        $logged         = $this->booking_log_model->booking_log($single_arr);

        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Update Changes Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed Update Changes!'
            );
        }

        echo json_encode($response_result);


         
    }

    public function update_amount($booking_id)
    {
        /*ADDING TO OUTSTANDING AMOUNT*/

                                 
                                $where = array();
                                $where['status']            = '1';
                                $where['transaction_type']  = 'sale';
                                $where['booking_id']        = $booking_id;
 
                                $fetch_all_payment = $this->booking_payments_model->findDynamic($where);
                                $total_paid_amount = 0;
                                $total_refund_amount = 0;
                                $outstanding_amount = 0;
                                if(!empty($fetch_all_payment))
                                {
                                    foreach ($fetch_all_payment as $key => $value)
                                    {
                                         if($value->payment_type =='payment')
                                         {
                                            $total_paid_amount = $total_paid_amount + $value->amount;
                                          }else if($value->payment_type =='refund')
                                         { 
                                            $total_refund_amount = $total_refund_amount + $value->amount;
                                         } 
                                    }
                                }


                                $single_arr         = $this->sale_model->find($booking_id);
                               

                                 

                                    
                                    $balance            =  $single_arr->total;
                                    $outstanding_amount = ($balance-$total_paid_amount);
                                 
                                

                                $insertData                         = array();
                                $insertData['total_paid_amount']    = $total_paid_amount;
                                $insertData['refunded_amount']      = $total_refund_amount;
                                $insertData['outstanding_amount']   = $outstanding_amount;
                                $insertData['id']                   = $booking_id;  
                                $price_updated                      = $this->sale_model->save($insertData);
            
    }

    public function delete_payment($id,$booking_id)
    {

        
        $this->isLoggedIn();
        $update_booking_status  = $this->input->post('update_booking_status');
        $insertData                     = array();
        $insertData['id']               = $id;
        $insertData['status']           = 0;
        $result                 = $this->booking_payments_model->save($insertData);

        $this->update_amount($booking_id);

  
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Deleted Payment Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed Deleted Payment !'
            );
        }

        echo json_encode($response_result);


         
    }

    public function add_payment($id)
    {

        
        $this->isLoggedIn();
         $form_data  = $this->input->post();

        $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['booking_id']       = $id;
        $insertData['payment_type']     = 'payment';
        $insertData['transaction_type']     = 'sale';
        $insertData['payment_mode']     = $form_data['payment_mode'];
        $insertData['bank_transaction_id']= $form_data['payment_bank_transaction_id'];
        $insertData['amount']           = $form_data['payment_amount'];
        $insertData['status']           = 1;
        $insertData['date_at']          = date("Y-m-d H:i:s");
        $insertData['created_by']       = $this->session->userdata('userId');
        $insertData['customer_id']      = $form_data['custID'];
        $insertData['cheque_no']        = $form_data['cheque_no'];
        $insertData['bank_name']        = $form_data['bank_name'];
        $insertData['bank_branch']      = $form_data['bank_branch'];


        //booking data fetch
        $single_arr         = $this->sale_model->find($id);
        $balance            =  $single_arr->total;
        $total_paid_amount  = $single_arr->total_paid_amount + $form_data['payment_amount'];
        $outstanding_amount = ($balance-$total_paid_amount);

         
        $result = $this->booking_payments_model->save($insertData);

        $insertData                         = array();
        $insertData['total_paid_amount']    = $total_paid_amount;
        $insertData['outstanding_amount']   = $outstanding_amount;
        $insertData['id']                   = $id;  
        $price_updated                      = $this->sale_model->save($insertData);

        //get and update to log
        $this->update_amount($id);
        /*$single_arr     = $this->booking_model->find($id);
        $logged         = $this->booking_log_model->booking_log($single_arr);*/


        //get and update to log end
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Add Payment Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed Add Payment!'
            );
        }

        echo json_encode($response_result);


         
    }

    public function cancel_status($id)
    {

        
        $this->isLoggedIn();
         $form_data  = $this->input->post();

        $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['booking_id']       = $id;
        $insertData['payment_type']     = $form_data['payment_type'];
         
         
        $insertData['amount']           = $form_data['cancel_charges'];
        $insertData['status']           = 1;
        $insertData['date_at']          = date("Y-m-d H:i:s");
        $insertData['created_by']       = $this->session->userdata('userId');
        $insertData['customer_id']      = $form_data['custID'];
        $insertData['farmer_id']        = $form_data['farmer_id'];
        
        //booking data fetch
        $single_arr     = $this->booking_model->find($id);
        
         
        $result = $this->booking_payments_model->save($insertData);

        $insertData  = array();
        $insertData['cancellation_charge']      = $form_data['cancel_charges'];
        $insertData['cancellation_reason']        = $form_data['cancel_reason'];
        $insertData['cancellation_date']        =  $form_data['payment_create_date'];
        $insertData['booking_status']        =  $form_data['booking_status'];
        $insertData['cancel_by']        = $this->session->userdata('userId');;
         
        $insertData['id']  = $id;  
        $price_updated    = $this->booking_model->save($insertData);

        //get and update to log
        $single_arr     = $this->booking_model->find($id);
        $logged         = $this->booking_log_model->booking_log($single_arr);
        //get and update to log end
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Cancellation Saved Successfully Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed To Add Cancellation!'
            );
        }

        echo json_encode($response_result);


         
    }

    public function edit_payment($id)
    {
         
        
        $this->isLoggedIn();
         $form_data  = $this->input->post();
         $booking_id  = $form_data['booking_id']; 
         if($form_data['payment_amount'] ==$form_data['x_payment_amount'])
         {

            $response_result = array(
                'status'=>0,
                'message'=>'Update Some Amount !'
            );

            $insertData = array();
            $insertData['payment_date']     = $form_data['payment_create_date'];
            $insertData['id']               = $id;
            $insertData['payment_mode']     = $form_data['payment_mode'];
            $insertData['payment_type']     = $form_data['payment_type'];
            $insertData['bank_transaction_id']= $form_data['payment_bank_transaction_id'];
            $insertData['update_at']        = date("Y-m-d H:i:s");
            $insertData['update_by']        = $this->session->userdata('userId');
            $insertData['cheque_no']        = $form_data['cheque_no'];
            $insertData['bank_name']        = $form_data['bank_name'];
            $insertData['bank_branch']      = $form_data['bank_branch'];

 
                
                 
               
                /*$total_paid_amount  = $single_arr->total + $form_data['payment_amount'];
                $outstanding_amount = ($balance-$total_paid_amount);*/
         
                 
                $result = $this->booking_payments_model->save($insertData);

                 if($result)
                {
                    $response_result = array(
                        'status'=>1,
                        'message'=>'Update Payment Successfully !'
                    );
                }else
                {
                    $response_result = array(
                        'status'=>0,
                        'message'=>'Failed Update Payment!'
                    );
                }



         }else
         {
                $booking_id  = $form_data['booking_id'];
                $where = array();
                $where['status'] = '1';
                $where['transaction_type'] =  'sale';
                $where['booking_id'] = $booking_id;
                $where['id !='] = $id;

                $fetch_all_payment = $this->booking_payments_model->findDynamic($where);
                $total_paid_amount = 0;
                $total_refund_amount = 0;
                if(!empty($fetch_all_payment))
                {
                    foreach ($fetch_all_payment as $key => $value)
                    {
                         if($value->payment_type =='payment')
                         {
                            $total_paid_amount = $total_paid_amount + $value->amount;
                          }else if($value->payment_type =='refund')
                         { 
                            $total_refund_amount = $total_refund_amount + $value->amount;
                         } 
                    }
                }


                $single_arr         = $this->booking_model->find($booking_id);
               

                if($form_data['payment_type']=='payment')
                {

                    $total_paid_amount = $total_paid_amount + $form_data['payment_amount'];
                    $balance            =  $single_arr->total;
                    $outstanding_amount = ($balance-$total_paid_amount);
                }
                if($form_data['payment_type']=='refund')
                {
                   $total_refund_amount = $total_refund_amount + $form_data['payment_amount'];

                   $outstanding_amount = ($single_arr->total_paid_amount-$total_refund_amount);
                }








           

         $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['id']               = $id;
        $where['transaction_type'] =  'sale';
        $insertData['payment_type']     = $form_data['payment_type'];
        $insertData['payment_mode']     = $form_data['payment_mode'];
        $insertData['bank_transaction_id']= $form_data['payment_bank_transaction_id'];
        $insertData['amount']           = $form_data['payment_amount'];
        $insertData['status']           = 1;
        $insertData['update_at']        = date("Y-m-d H:i:s");
        $insertData['update_by']        = $this->session->userdata('userId');
        $insertData['cheque_no']        = $form_data['cheque_no'];
        $insertData['bank_name']        = $form_data['bank_name'];
        $insertData['bank_branch']      = $form_data['bank_branch'];


        
         
       
        /*$total_paid_amount  = $single_arr->total + $form_data['payment_amount'];
        $outstanding_amount = ($balance-$total_paid_amount);*/
 
         
        $result = $this->booking_payments_model->save($insertData);

        $insertData                         = array();
        $insertData['total_paid_amount']    = $total_paid_amount;
        $insertData['refunded_amount']      = $total_refund_amount;
        $insertData['outstanding_amount']   = $outstanding_amount;
        $insertData['id']                   = $booking_id;  
        $price_updated                      = $this->sale_model->save($insertData);

        //get and update to log
         
        /*$single_arr     = $this->booking_model->find($booking_id);
        $logged         = $this->booking_log_model->booking_log($single_arr);*/
        //get and update to log end
        $response_result = array(
                'status'=>0,
                'message'=>''
        );

        if($result)
        {
            $response_result = array(
                'status'=>1,
                'message'=>'Update Payment Successfully !'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'message'=>'Failed Update Payment!'
            );
        }
         }
         $this->update_amount($booking_id);

        

        echo json_encode($response_result);


         
    }

    public function add_refund($id)
    {

        
        $this->isLoggedIn();
         $form_data  = $this->input->post();

        $insertData = array();
        $insertData['payment_date']     = $form_data['payment_create_date'];
        $insertData['booking_id']       = $id;
        $insertData['payment_type']     = 'refund';
        $insertData['transaction_type']     = 'sale';
        $insertData['payment_mode']     = $form_data['payment_mode'];
        $insertData['bank_transaction_id']= $form_data['payment_bank_transaction_id'];
        $insertData['amount']           = $form_data['payment_amount'];
        $insertData['date_at']          = date("Y-m-d H:i:s");
        $insertData['status']           = 1;
        $insertData['created_by']       = $this->session->userdata('userId');
        $insertData['customer_id']      = $form_data['custID'];
        $insertData['cheque_no']        = $form_data['cheque_no'];
        $insertData['bank_name']        = $form_data['bank_name'];
        $insertData['bank_branch']      = $form_data['bank_branch'];

         
     $response_result = array(
                    'status'=>0,
                    'message'=>''
            );

                $where = array();
                $where['status'] = '1';
                $where['transaction_type'] = 'sale';
                $where['booking_id'] = $id; 

                $fetch_all_payment = $this->booking_payments_model->findDynamic($where);
                 $total_refund_amount = 0;
                if(!empty($fetch_all_payment))
                {
                    foreach ($fetch_all_payment as $key => $value)
                    {
                         if($value->payment_type =='refund')
                         { 
                            $total_refund_amount = $total_refund_amount + $value->amount;
                         } 
                    }
                }


                $single_arr         = $this->sale_model->find($id);
               

               
                 
                   $total_refund_amount = $total_refund_amount + $form_data['payment_amount'];

                   $outstanding_amount = ($single_arr->total_paid_amount-$total_refund_amount);
                

 
             
            $result = $this->booking_payments_model->save($insertData);

            $insertData  = array();
             
           /* $insertData['total_paid_amount']  = $total_paid_amount;*/
            $insertData['outstanding_amount']  = $outstanding_amount;
            $insertData['refunded_amount']  = $total_refund_amount;
            $insertData['id']  = $id;  
            $price_updated    = $this->sale_model->save($insertData);

            //get and update to log
             $this->update_amount($id);
            /*$single_arr     = $this->booking_model->find($id);
            $logged         = $this->booking_log_model->booking_log($single_arr);*/
            //get and update to log end
            
           

            if($result)
            {
                $response_result = array(
                    'status'=>1,
                    'message'=>'Add Refund Successfully !'
                );
            }else
            {
                $response_result = array(
                    'status'=>0,
                    'message'=>'Failed Add Refund!'
                );
            }

        /*}else
        {
             $response_result = array(
                    'status'=>0,
                    'message'=>"Your Refund Amount shout not Greater than Total Paid Amount"
            );
        }
       */
        echo json_encode($response_result);


         
    }


    public function single($id='')
    {
         $this->isLoggedIn();
        $single_arr = $this->booking_model->find($id);
         
        echo  json_encode($single_arr);
    }
    public function booking_logs($id='')
    {
         $this->isLoggedIn();
         $userid = $this->session->userdata('userId');
         $where_search['booking_id'] = $id;
         $conditions = array( 
                    'where' => $where_search, 
                    'userid' =>  $userid, 
                 ); 
        $booking_logs = $this->booking_log_model->getRows($conditions);
         
        if(!empty($booking_logs))
        {
            $arra_empt = [];
            foreach ($booking_logs as $bookin_log)
            {
                 

                   $arra_empt2=[];
                    $arra_empt2['id']                    =$bookin_log['id'];
                    $arra_empt2['booking_id']            =$bookin_log['booking_id'];
                    $arra_empt2['stage']                 =$bookin_log['stage'];
                    $arra_empt2['farmer_id']           =$bookin_log['farmer_id'];
                    $arra_empt2['customer_name']         =$bookin_log['customer_name'];
                    $arra_empt2['customer_mobile']       =$bookin_log['customer_mobile'];
                    $arra_empt2['customer_alter_mobile'] =$bookin_log['customer_alter_mobile'];
                    $arra_empt2['father_name']           =$bookin_log['father_name'];
                    $arra_empt2['state']                 =$bookin_log['state'];
                    $arra_empt2['other_state']           =$bookin_log['other_state'];
                    $arra_empt2['district']              =$bookin_log['district'];
                    $arra_empt2['other_district']        =$bookin_log['other_district'];
                    $arra_empt2['city']                  =$bookin_log['city'];
                    $arra_empt2['other_city']            =$bookin_log['other_city'];
                    $arra_empt2['village']               =$bookin_log['village'];
                    $arra_empt2['pincode']               =$bookin_log['pincode'];
                    $arra_empt2['booking_date']          =date('d M Y',strtotime($bookin_log['booking_date']));
                    $arra_empt2['req_delivery_date']     =$bookin_log['req_delivery_date'];
                    $arra_empt2['delivery_date']         =($bookin_log['delivery_date']=='0000-00-00' || $bookin_log['delivery_date']==null)?'':date('d M Y',strtotime($bookin_log['delivery_date']));
                    $arra_empt2['supply_address']        =$bookin_log['supply_address'];
                    $arra_empt2['vehicle_no']            =$bookin_log['vehicle_no'];
                    $arra_empt2['agent_id']              =$bookin_log['agent_id'];
                    $arra_empt2['crates']                =$bookin_log['crates'];
                    $arra_empt2['bank_trans_id']         =$bookin_log['bank_trans_id'];
                    $arra_empt2['contract']              =$bookin_log['contract'];
                    $arra_empt2['productive_plants']     =$bookin_log['productive_plants'];
                    $arra_empt2['driver_name']           =$bookin_log['driver_name'];
                    $arra_empt2['booking_status']        =$bookin_log['booking_status'];
                    $arra_empt2['crop_status']           =$bookin_log['crop_status'];
                    $arra_empt2['billing_address']       =$bookin_log['billing_address'];
                    $arra_empt2['same_billing']          =$bookin_log['same_billing'];
                    $arra_empt2['delivery_address']      =$bookin_log['delivery_address'];
                    $arra_empt2['advance']               =number_format($bookin_log['advance'],2);
                    $arra_empt2['create_date']           =date('d M Y',strtotime($bookin_log['create_date']));
                    $arra_empt2['balance']               =$bookin_log['balance'];
                    $arra_empt2['payment_mode']          =$bookin_log['payment_mode'];
                    $arra_empt2['cheque_no']             =$bookin_log['cheque_no'];
                    $arra_empt2['bank_name']             =$bookin_log['bank_name'];
                    $arra_empt2['bank_branch']           =$bookin_log['bank_branch'];
                    $arra_empt2['product_id']            =$bookin_log['product_id'];
                    $arra_empt2['uom']                   =$bookin_log['uom'];
                    $arra_empt2['price']                 =number_format($bookin_log['price'],2);
                    $arra_empt2['quantity']              =$bookin_log['quantity'];
                    $arra_empt2['cgst_rate']             =$bookin_log['cgst_rate'];
                    $arra_empt2['sgst_rate']             =$bookin_log['sgst_rate'];
                    $arra_empt2['igst_rate']             =$bookin_log['igst_rate'];
                    $arra_empt2['cgst_amount']           =$bookin_log['cgst_amount'];
                    $arra_empt2['sgst_amount']           =$bookin_log['sgst_amount'];
                    $arra_empt2['igst_amount']           =$bookin_log['igst_amount'];
                    $arra_empt2['total_paid_amount']     =$bookin_log['total_paid_amount'];
                    $arra_empt2['outstanding_amount']    =$bookin_log['outstanding_amount'];
                    $arra_empt2['cancellation_reason']    =$bookin_log['cancellation_reason'];
                    $arra_empt2['discount']              =number_format($bookin_log['discount'],2);
                    $arra_empt2['total']                 =number_format($bookin_log['total'],2);
                    $arra_empt2['pending_bill']          =$bookin_log['pending_bill'];
                    $arra_empt2['status']                =$bookin_log['status'];
                    $arra_empt2['created_by']            =$bookin_log['created_by'];
                    $arra_empt2['date_at']               =date('d M Y',strtotime($bookin_log['date_at']));
                    $arra_empt2['document']              =(isset($bookin_log['document'])?"<a href='".base_url()."uploads/admin/document/".$bookin_log['document']."'>":"");
                    $arra_empt2['assigned_to']           =$bookin_log['assigned_to'];
                    $arra_empt2['delivery_expect_start_date']=($bookin_log['delivery_expect_start_date']=='0000-00-00' || $bookin_log['delivery_expect_start_date']==null)?'':date('d M Y',strtotime($bookin_log['delivery_expect_start_date']));
                    $arra_empt2['delivery_expect_end_date']=($bookin_log['delivery_expect_end_date']=='0000-00-00' || $bookin_log['delivery_expect_end_date']==null)?'':date('d M Y',strtotime($bookin_log['delivery_expect_end_date']));
                    $arra_empt2['update_at']             =date('d M Y',strtotime($bookin_log['update_at']));
                    $arra_empt2['company_id']            =$bookin_log['company_id'];
                    $arra_empt2['createdby']             =$bookin_log['createdby'];
                    $arra_empt2['booked_status']         =$bookin_log['booked_status'];
                    $arra_empt2['booked_badges']         =$bookin_log['booked_badges'];
                    $arra_empt2['executive']             =$bookin_log['executive'];
                    $arra_empt2['productname']           =$bookin_log['productname'];
                    $arra_empt2['paymentmodename']       =$bookin_log['paymentmodename'];
                    $arra_empt2['contractstatusname']    =$bookin_log['contractstatusname'];
                    $arra_empt2['assignedto']            =$bookin_log['assignedto'];
                    $arra_empt2['cropstatusname']        =$bookin_log['cropstatusname'];

                    $arra_empt[]= $arra_empt2;
            }
        }
        echo  json_encode($arra_empt);
    }

    public function invoice($id)
    {

        $this->isLoggedIn();

        $data = array();
         $userid = $this->session->userdata('userId');
         $company_id = $this->session->userdata('company_id');
         $where_search['id'] = $id;
         $conditions = array( 
                    'where' => $where_search 
                 ); 
        $booked = $this->sale_model->getRows($conditions);
         $data['company_details'] = '';
         $data['receipt_dtl'] = '';
        if(!empty($booked))
        {
            $receipt_dtl = $booked[0];

            $where_search =  array();
            $where_search['id'] = $receipt_dtl['company_id'];
            $conditions = array( 
                'where' => $where_search 
            ); 

                $where = array();
                 
                $where['sale_id']       = $id; 
                $where['company_id']    = $company_id; 


                $invoice_dtls = $this->sale_dtl_model->getOrderDetail($where);
                /* echo "<pre>";
                    print_r($invoice_dtl);
                    echo "</pre>";
                    die;
                */
             $data['receipt_dtl'] = $receipt_dtl;
             $data['invoice_dtls'] = $invoice_dtls;
             $company_details = $this->company_model->findCompanyDetail($conditions);

            if(!empty($company_details))
            {
                $data['company_details'] =   $company_details[0];   
            }

             
           

            
        }
        
 
        $this->global['pageTitle'] = 'Sale Invoice';
        $this->loadViews("admin/sale/sale-invoice", $this->global, $data , NULL);

    }
    public function agreement($id)
    {

        $this->isLoggedIn();

        $data = array();
         $userid = $this->session->userdata('userId');
         $where_search['id'] = $id;
         $conditions = array( 
                    'where' => $where_search 
                 ); 
        $booked = $this->booking_model->getRows($conditions);
         $data['company_details'] = '';
         $data['receipt_dtl'] = '';
        if(!empty($booked))
        {
            $receipt_dtl = $booked[0];

            $where_search =  array();
            $where_search['id'] = $receipt_dtl['company_id'];
            $conditions = array( 
                'where' => $where_search 
            ); 

             $data['receipt_dtl'] = $receipt_dtl;
             $company_details = $this->company_model->findCompanyDetail($conditions);

            if(!empty($company_details))
            {
                $data['company_details'] =   $company_details[0];   
            }
           

            
        }
        
 
        $this->global['pageTitle'] = 'Booking Agreement';
        $this->loadViews("admin/sale/booking-agreement", $this->global, $data , NULL);

    }
    public function view($id)
    {

        $this->isLoggedIn();

        $data = array();
         $userid = $this->session->userdata('userId');
          $company_id = $this->session->userdata('company_id');
         $where_search['id'] = $id;
         $conditions = array( 
                    'where' => $where_search 
                 ); 
        $booked = $this->sale_model->getRows($conditions);
         $data['company_details'] = '';
         $data['receipt_dtl'] = '';
        if(!empty($booked))
        {
            $receipt_dtl = $booked[0];

            $where_search =  array();
            $where_search['id'] = $receipt_dtl['company_id'];
            $conditions = array( 
                'where' => $where_search 
            ); 

            $where = array();

            $where['sale_id']       = $id; 
            $where['company_id']    = $company_id; 


            $invoice_dtls = $this->sale_dtl_model->getOrderDetail($where);

             $data['receipt_dtl'] = $receipt_dtl;
              $data['invoice_dtls'] = $invoice_dtls;
             $data['payment_details']    = $this->booking_payments_model->getPaymentDetail($id,'sale'); 
             $company_details = $this->company_model->findCompanyDetail($conditions);

            if(!empty($company_details))
            {
                $data['company_details'] =   $company_details[0];   
            }
           

            
        }
        
 
        $this->global['pageTitle'] = 'Sale Transaction Details';
        $this->loadViews("admin/sale/invoice-view", $this->global, $data , NULL);

    }

    public function export()
    {

         $this->isLoggedIn();



                $userid = $this->session->userdata('userId');
                $where_search   = array(); 
                $conditions     = array();

                 $where_search =  array();
                 $search_farmer_id    = @$this->input->get('farmer_id');
                $search_name         = @$this->input->get('customer_name');
                $search_mobile       = @$this->input->get('customer_mobile');
                $search_alt_mobile   = @$this->input->get('customer_alter_mobile');
                $status1              = @$this->input->get('status1');
                $state2              = @$this->input->get('state2');
                $district2           = @$this->input->get('district2');
                $city2               = @$this->input->get('city2');
                $invoice_no          = @$this->input->get('invoice_no'); 
                $invoice_date        = @$this->input->get('invoice_date'); 
                 
                if(!empty($invoice_date))
                {
                     $where_search['booking_date'] =  $invoice_date;
                }
                if(!empty($invoice_no))
                {
                    $where_search['id'] =  $invoice_no;
                }
                if(!empty($search_farmer_id))
                {
                    $where_search['farmer_id'] =  $search_farmer_id;
                }
                if(!empty($search_name))
                {
                    $where_search['customer_name'] =  $search_name;
                } 
                 if(!empty($status1))
                {
                    $where_search['booking_status'] =  $status1;
                } 
                
                if(!empty($search_mobile))
                {
                    $where_search['customer_mobile'] =  $search_mobile;
                }
                if(!empty($search_alt_mobile))
                {
                    $where_search['customer_alter_mobile'] =  $search_alt_mobile;
                }
                if(!empty($state2))
                {
                    $where_search['state'] =  $state2;
                }
                
                if(!empty($district2))
                {
                    $where_search['district'] =  $district2;
                }
                if(!empty($city2))
                {
                    $where_search['city'] =  $city2;
                }
                if(!empty($search_type))
                {
                    $where_search['search_type'] =  $search_type;
                } 
                
                
            

             $conditions = array( 
                 
                'where' => $where_search, 
                'userid' =>  $userid
                 
                
                ); 




           
            
             $resultfound = $this->sale_model->getRows($conditions);

            $content = "Invoice No,Invoice Date ,Order Status ,Customer Id,Customer Name ,Primary Number, Tehsil, District,State,Payment Mode,Bank Trxn Id, Total Billed Amount,Discount Amount,Received Amount,Outstanding Amount, Vehicle No.,Place of Supply,Transportation,Comment,Transaction Description \n";
                
               /* echo "<pre>";
                print_r($resultfound );
                echo "</pre>";*/
            if(!empty($resultfound))
            {
                foreach ($resultfound as $key => $value) 
                {
                    
                    $billing_address =trim($value['billing_address']);
                    $billing_address =str_replace("\n", " ", $billing_address);
                    $billing_address =str_replace("\r", " ", $billing_address);

                    $comment =trim($value['comment']);
                    $comment =str_replace("\n", " ", $comment);
                    $comment =str_replace("\r", " ", $comment); 

                    $trans_desctription =trim($value['trans_desctription']);
                    $trans_desctription =str_replace("\n", " ", $trans_desctription);
                    $trans_desctription =str_replace("\r", " ", $trans_desctription); 

                    $supply_address =trim($value['supply_address']);
                    $supply_address =str_replace("\n", " ", $supply_address);
                    $supply_address =str_replace("\r", " ", $supply_address);
                     
                    $delivery_address =trim( $value['delivery_address']);
                    $delivery_address =str_replace("\n", " ", $delivery_address);
                    $delivery_address =str_replace("\r", " ", $delivery_address);
                     
                     $content.= str_replace(",", " ", $value['id']).",";
                    $content.= str_replace(",", " ", date('d M Y',strtotime($value['booking_date']))).",";
                    $content.= str_replace(",", " ", ucwords($value['booking_status'])).",";
                    $content.= str_replace(",", " ", $value['farmer_id']).",";
                    $content.= str_replace(",", " ", $value['customer_name']).",";
                    $content.= str_replace(",", " ", $value['customer_mobile']).",";
                    $content.= str_replace(",", " ", $value['city']).",";
                    $content.= str_replace(",", " ", $value['district']).",";
                    $content.= str_replace(",", " ", $value['state']).",";
                    $content.= str_replace(",", " ", $value['paymentmodename']).",";
                    $content.= str_replace(",", " ", $value['bank_trans_id']).",";
                    $content.= str_replace(",", " ", $value['total']).",";
                    $content.= str_replace(",", " ", $value['discount_amount']).",";
                    $content.= str_replace(",", " ", $value['total_paid_amount']).",";
                    $content.= str_replace(",", " ", ($value['outstanding_amount']+0)).",";
                    
                     $content.= str_replace(",", " ", $value['vehicle_no']).",";
                     $content.= str_replace(",", " ", $supply_address).",";
                     $content.= str_replace(",", " ",  ucwords($value['transport_type']) ).",";
                     $content.= str_replace(",", " ",  $comment).",";
                     $content.= str_replace(",", " ",  $trans_desctription).",";
                     $content.= str_replace(",", " ", $delivery_address).",";
 
                           $content.="\n";
                }
            }        

 
                    
        $filename = 'invoice-export-'.date('d-m-Y-h-s').'.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        print_r($content);
        die; 
    }

    public function get_all_state()
    {

            
            $where = array();
            $where['country_id'] = '105';
            $where['status'] = 1;
            $where['field'] = 'id,name';
             

            $returnData = $this->state_model->findDynamic($where);

          $response_result = array(
                'status'=>0,
                'data'=>'',
                'message'=>'Not data found !'
        );

        if($returnData)
        {
            $response_result = array(
                'status'=>1,
                'data'=>$returnData,
                'message'=>'Data Found .'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'data'=>'Failed Fetch Data!',
                'message'=>'Empty Data Found .'
            );
        }

        echo json_encode($response_result);
          
    }  
    public function get_all_district()
    {

            
            $where = array();
            $where['status'] = 1;
            $where['field'] = 'id,name';
             

            $returnData = $this->district_model->findDynamic($where);

          $response_result = array(
                'status'=>0,
                'data'=>'',
                'message'=>'Not data found !'
        );

        if($returnData)
        {
            $response_result = array(
                'status'=>1,
                'data'=>$returnData,
                'message'=>'Data Found .'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'data'=>'Failed Fetch Data!',
                'message'=>'Empty Data Found .'
            );
        }

        echo json_encode($response_result);
          
    }  
    public function get_all_city()
    {

            
            $where = array();
            $where['status'] = 1;
            $where['field'] = 'id,city';
             

            $returnData = $this->city_model->findDynamic($where);

          $response_result = array(
                'status'=>0,
                'data'=>'',
                'message'=>'Not data found !'
        );

        if($returnData)
        {
            $response_result = array(
                'status'=>1,
                'data'=>$returnData,
                'message'=>'Data Found .'
            );
        }else
        {
            $response_result = array(
                'status'=>0,
                'data'=>'Failed Fetch Data!',
                'message'=>'Empty Data Found .'
            );
        }

        echo json_encode($response_result);
          
    }  
    
    
    
}

?>