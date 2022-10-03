<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Customer_call_model extends Base_model
{

    public $table = "z_customer_call";

    //set column field database for datatable orderable
    var $column_order = array(null,'cc.date_at', 'c.customer_title', 'ct.title', 'u.title', 'cc.call_back_date', 'cd.title',  'cc.current_conversation'); 

    //set column field database for datatable searchable 
    var $column_search = array('cc.date_at', 'c.customer_title', 'ct.title', 'u.title', 'cc.call_back_date', 'cd.title',  'cc.current_conversation'); 

    var $order = array('id' => 'desc'); // default order



        



        function __construct() {



            parent::__construct();



        }







     function delete($id) {



        $this->db->where('id', $id);



        $this->db->delete($this->table);        



        return $this->db->affected_rows();



    }







    public function find($id) {
            $query = $this->db->select('*')
                    ->from($this->table)
                    ->where('id', $id)
                    ->get();

            if ($query->num_rows() > 0) {
                $result = $query->result();
                return $result[0];
            } else {
                return array();
            }
        }

       // Get  List

        function get_datatables($customer='')
        {

            $this->db->select('cc.*, c.customer_title as customer_title, ct.title as call_type_title, u.title as user_title, cd.title as call_direction_title');
            $this->_get_datatables_query($customer);

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query($customer='')
        {     

 
            $this->db->from($this->table. ' as cc');  
            $this->db->join('z_customer as c', 'c.id = cc.customer');
            $this->db->join('z_call_type as ct', 'ct.id = cc.call_type');
            $this->db->join('z_users as u', 'u.id = cc.assign_to');
            $this->db->join('z_call_direction as cd', 'cd.id = cc.call_direction');

            $i = 0; 
                 

            foreach ($this->column_search as $item) // loop column 

            {

                if(isset($_POST['search']['value']) && $_POST['search']['value']) // if datatable send POST for search

                {

                    if($i===0) // first loop

                    {

                        $this->db->like($item, $_POST['search']['value']);

                    }

                    else

                    {

                        $this->db->or_like($item, $_POST['search']['value']);

                    }

                }

                $i++;

            }

             $this->db->where('cc.customer', $customer);

            if(isset($_POST['order'])) // here order processing
            {

                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

            } 

            else if(isset($this->order))

            {

                $order = $this->order;

                $this->db->order_by("cc.".key($order), $order[key($order)]);

            }

 

        }



        // Count  Filtered

        function count_filtered($customer)
        {

            $this->_get_datatables_query($customer);

            $query = $this->db->get();

            return $query->num_rows();

        }

        // Count all

        public function count_all($customer)
        {

            $this->db->from($this->table. ' as cc');

            return $this->db->count_all_results();

        }

        


        public function callSummary($data_param)
        {
            if(isset($data_param['userid']) && $data_param['userid'] !=='')
            {
                $userid = $data_param['userid'];
            }

                $current_date  = $data_param['current_date'];date('Y-m-d');
                $where     = array();
                $this->db->select('z_customer.id');
                $this->db->from('z_customer');
                 $where = " ";
                   

                   $role = $this->session->userdata('role');
                    $company_id = $this->session->userdata('company_id');
                    if($role ==1)
                    {
                        $where.= "  ( z_customer.status = 1 AND z_customer.farmer_id !='') ";
                    }else
                    {
                        $where.= "( z_customer.status = 1 AND z_customer.company_id=".$company_id." AND z_customer.farmer_id !='')";  
                    }
                    








                if(isset($data_param['userid']) && $data_param['userid'] !=='')
                {

                if($data_param['userid'] !=='all'){
                    $userid = $data_param['userid'];
                    $where.= " AND ( z_customer.assigned_to = '".$userid."') ";  
                }
                    
                } 
                   

                if(isset($data_param['stat_type']) && $data_param['stat_type'] =='call_type' && $data_param['call_type'] !=='' )
                {
                    $where.= " AND z_customer.last_call_type='".$data_param['call_type']."' AND z_customer.last_follow_date='".$current_date."'";

                }else if(isset($data_param['stat_type']) &&  $data_param['stat_type'] =='followup' && $data_param['followup_type'] !=='')
                {

                    if(isset($data_param['call_type']) && $data_param['call_type'] !=='')
                        {
                            $where.= " AND ( z_customer.last_call_type='".$data_param['call_type']."' )";    
                        }

                    if($data_param['followup_type']=='yesterday')
                    {
                         
                        $where.= "  AND (z_customer.last_call_back_date < '".$current_date."' AND  last_call_back_date != '0000-00-00')"; 

                        

                    }else if($data_param['followup_type']=='today')
                    {
                        
                        $where.= "  AND z_customer.last_call_back_date='".$current_date."'";    
                    }
                    else if($data_param['followup_type']=='tomorrow')
                    {
                        $tomorrow = date('Y-m-d',strtotime("+1 days",strtotime($current_date)));
                        $where.= "  AND z_customer.last_call_back_date='".$tomorrow."'";    
                    }
                    
                }
             
            

              
                $this->db->where($where); 


                $query = $this->db->get();

                return $result = $query->result();
        }

        public function getCallsummary($alltype, $userid, $stat_type, $current_date, $followup_type='')
        {

            $array = array();

            foreach ($alltype as $key => $value) 
            {
                  
                  
               


                $data_param                 = array();
                $data_param['userid']       =  $userid;
                $data_param['stat_type']    = $stat_type;
                $data_param['call_type']    = $value->id;
                $data_param['followup_type']= $followup_type;
                $data_param['current_date']= $current_date;
                
                $result             =   $this->callSummary($data_param);
                $sec_arr['id']      = $value->id; 
                $sec_arr['title']   = $value->title; 
                $sec_arr['total_count_call'] = count($result);
                $array[] = $sec_arr;

 
            }
             return $array;
            
        } 



}











  