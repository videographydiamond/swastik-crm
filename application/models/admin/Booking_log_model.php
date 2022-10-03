<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Booking_log_model extends Base_model
{

    public $table = "z_booking_log";

    //set column field database for datatable orderable
    var $column_order = array(null, 'c.date_at', 'c.sku_id', 'c.customer_title','c.customer_mobile','c.customer_alter_mobile',  'sta.name', 'dist.name', 'cit.city', 'ctype.name', 'calldirection.name'); 

    //set column field database for datatable searchable 
    var $column_search = array('c.date_at', 'c.sku_id', 'c.customer_title','c.customer_mobile','c.customer_alter_mobile',  'sta.name', 'dist.name', 'cit.city', 'ctype.name', 'calldirection.name'); 

    var $order = array('c.id' => 'desc'); // default order



        



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

        function get_datatables()
        {
            $this->db->select('c.*, cit.city as city, sta.name as state, dist.name as district, ctype.title as leatest_calltype,   calldirection.title as leatest_calldir');
            $this->_get_datatables_query();

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query()
        {     

            $this->db->from($this->table. ' as c'); 
            $this->db->join('z_states as sta', 'sta.id = c.state', 'left');
            $this->db->join('z_district as dist', 'dist.id = c.district', 'left');
            $this->db->join('z_cities as cit', 'cit.id = c.city', 'left');
            $this->db->join('z_call_type as ctype', 'ctype.id = c.last_call_type', 'left');
            $this->db->join('z_call_direction as calldirection', 'calldirection.id = c.last_call_direction', 'left');

            
            

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

             

            if(isset($_POST['order'])) // here order processing
            {

                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

            } 

            else if(isset($this->order))

            {

                $order = $this->order;

                $this->db->order_by(key($order), $order[key($order)]);

            }

        }



        // Count  Filtered

        function count_filtered()
        {

            $this->_get_datatables_query();

            $query = $this->db->get();

            return $query->num_rows();

        }

        // Count all

        public function count_all()
        {

            $this->db->from($this->table. ' as c');

            return $this->db->count_all_results();

        }

        function getRows($params = array())
        {
          /*  $this->db->select('*'); 
            $this->db->from($this->table); */


                $this->db->select('c.*,farmer.alt_mobile as customeraltmobile ,farmer.mobile as customermobile ,farmer.name as customername, cit.city as city, sta.name as state, dist.name as district,    admin.title as createdby, bookstatus.title as booked_status, bookstatus.badges as booked_badges, executive.title as executive, product.title as productname, paymentmode.title as paymentmodename, contractstatus.title as contractstatusname,admin2.title as assignedto, cropstatus.title as cropstatusname');
                $this->db->from($this->table. ' as c'); 
                $this->db->join('z_states as sta', 'sta.id = c.state', 'left');
                $this->db->join('z_farmers as farmer', 'farmer.id = c.farmer_id', 'left');
                $this->db->join('z_district as dist', 'dist.id = c.district', 'left');
                $this->db->join('z_cities as cit', 'cit.id = c.city', 'left');
                $this->db->join('z_crop_status as cropstatus', 'cropstatus.slug = c.crop_status', 'left'); 
                $this->db->join('z_booking_status as bookstatus', 'bookstatus.slug = c.booking_status', 'left'); 
                $this->db->join('z_contract_status as contractstatus', 'contractstatus.slug = c.contract', 'left'); 
                $this->db->join('z_payment_mode as paymentmode', 'paymentmode.slug = c.payment_mode', 'left'); 
                $this->db->join('z_product as product', 'product.id = c.product_id', 'left'); 
                 
                /*$this->db->join('z_call_direction as calldirection', 'calldirection.id = c.last_call_direction', 'left');*/
                $this->db->join('z_admin as executive', 'executive.id = c.agent_id', 'left'); 
                $this->db->join('z_admin as admin', 'admin.id = c.created_by', 'left');
                $this->db->join('z_admin as admin2', 'admin2.id = c.assigned_to', 'left');
               /* $this->db->join('z_admin as admin3', 'admin3.id = c.last_follower', 'left');*/
                /*$this->db->join('z_call_type as last_ctype', 'last_ctype.id = c.last_follow_call_type', 'left');*/

                $where  = '';
                $userid = $this->session->userdata('userId');
                 $role = $this->session->userdata('role');
                

                 $where.= "( c.status = 1 )";
                

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {
                     
                    foreach($params['where'] as $key => $val){ 
                   // $this->db->where('c.'.$key, $val); 
                     
                        $where.= " AND ( c.".$key." = '".$val."' )";
                    

                } 

                  


                
 
                     
                }
                
            }

            $this->db->where($where); 
           




              
                


                
               
                


           
             

            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
                $result = $this->db->count_all_results(); 
            }else{ 
                if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                    if(!empty($params['id'])){ 
                        $this->db->where('id', $params['id']); 
                    } 
                    $query = $this->db->get(); 
                    $result = $query->row_array(); 
                }else{ 
                    $this->db->order_by('c.id', 'desc'); 
                    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 

                        //$starts = (($params['start']-1) < 0)?0:($params['start']-1);
                        $this->db->limit($params['limit'],$params['start']); 
                    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                        $this->db->limit($params['limit']); 
                    } 
                     
                    $query = $this->db->get(); 
                    $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
                } 
            } 
             
            // Return fetched data 
            return $result; 
    } 

             
    public function get_booking_data($whereData,$userid)
    {


            //$userid = $this->session->userdata('userId');
            $role = $this->session->userdata('role');
          
            $this->db->select('c.id');
            $this->db->from($this->table .' as c');

            $where ='';

            $where.= "( c.status = 1 )";    
            if($role==1)
                {

                }else
                {
                     $where.= "AND ( c.created_by = '".$userid."' OR c.assigned_to='".$userid."')";

                }



            if($whereData['title'] !=='all')
            {
                $this->db->where('c.booking_status', $whereData['title']); 
            }
            
            $this->db->where($where); 

            $query = $this->db->get(); 
            $result = ($query->num_rows() > 0)?$query->result_array():array(); 
            return $result ; 
                
                    



    }


    public function booking_log($single_arr)
    {
       
        if(!empty($single_arr))
        {
            $single = $single_arr;
            $insertData = array();
            $insertData['booking_id']                   = $single->id;
            $insertData['stage']                        = $single->stage;
            $insertData['farmer_id']                    = $single->farmer_id;
            $insertData['customer_name']                = $single->customer_name;
            $insertData['customer_mobile']              = $single->customer_mobile;
            $insertData['customer_alter_mobile']        = $single->customer_alter_mobile;
            $insertData['father_name']                  = $single->father_name;
            $insertData['state']                        = $single->state;
            $insertData['other_state']                  = $single->other_state;
            $insertData['district']                     = $single->district;
            $insertData['other_district']               = $single->other_district;
            $insertData['city']                         = $single->city;
            $insertData['other_city']                   = $single->other_city;
            $insertData['village']                      = $single->village;
            $insertData['pincode']                      = $single->pincode;
            $insertData['booking_date']                 = $single->booking_date;
            $insertData['req_delivery_date']            = $single->req_delivery_date;
            $insertData['delivery_expect_start_date']   = $single->delivery_expect_start_date;
            $insertData['delivery_expect_end_date']     = $single->delivery_expect_end_date;
            $insertData['delivery_date']                = $single->delivery_date;
            $insertData['req_delivery_date']            = $single->req_delivery_date;
            $insertData['delivery_date']                = $single->delivery_date;
            $insertData['supply_address']               = $single->supply_address;
            $insertData['vehicle_no']                   = $single->vehicle_no;
            $insertData['agent_id']                     = $single->agent_id;
            $insertData['bank_trans_id']                = $single->bank_trans_id;
            $insertData['crates']                       = $single->crates;
            $insertData['contract']                     = $single->contract;
            $insertData['productive_plants']            = $single->productive_plants;
            $insertData['driver_name']                  = $single->driver_name;
            $insertData['booking_status']               = $single->booking_status;
            $insertData['crop_status']                  = $single->crop_status;
            $insertData['billing_address']              = $single->billing_address;
            $insertData['same_billing']                 = $single->same_billing;
            $insertData['delivery_address']             = $single->delivery_address;
            $insertData['advance']                      = $single->advance;
            $insertData['create_date']                  = $single->create_date;;
            $insertData['update_at']                    = date("Y-m-d H:i:s");
            $insertData['balance']                      = $single->balance;
            $insertData['outstanding_amount']           = $single->outstanding_amount;
            $insertData['total_paid_amount']            = $single->total_paid_amount;
            $insertData['refunded_amount']                  = $single->refunded_amount;
            $insertData['cancellation_charge']           = $single->cancellation_charge;
            $insertData['cancellation_reason']           = $single->cancellation_reason;
            $insertData['cancellation_date']            = $single->cancellation_date;
            $insertData['cancel_by']                    = $single->cancel_by;
            $insertData['payment_mode']                 = $single->payment_mode;
            $insertData['cheque_no']                    = $single->cheque_no;
            $insertData['bank_name']                    = $single->bank_name;
            $insertData['bank_branch']                  = $single->bank_branch;
            $insertData['product_id']                   = $single->product_id;
            $insertData['uom']                          = $single->uom;
            $insertData['price']                        = $single->price;
            $insertData['quantity']                     = $single->quantity;
            $insertData['cgst_rate']                    = $single->cgst_rate;
            $insertData['sgst_rate']                    = $single->sgst_rate;
            $insertData['igst_rate']                    = $single->igst_rate;
            $insertData['cgst_amount']                  = $single->cgst_amount;
            $insertData['sgst_amount']                  = $single->sgst_amount;
            $insertData['igst_amount']                  = $single->igst_amount;
            $insertData['discount']                     = $single->discount;
            $insertData['total']                        = $single->total;
            $insertData['pending_bill']                 = $single->pending_bill;
            $insertData['company_id']                   = $single->company_id;
            $insertData['created_by']                   = $this->session->userdata('userId');
            $insertData['assigned_to']                  = $this->session->userdata('userId');

                        $product_set = array();
                        $product_set['product_id']                   = $single->product_id;
                        $product_set['uom']                          = $single->uom;
                        $product_set['price']                        = $single->price;
                        $product_set['quantity']                     = $single->quantity;
                        $product_set['cgst_rate']                    = $single->cgst_rate;
                        $product_set['sgst_rate']                    = $single->sgst_rate;
                        $product_set['igst_rate']                    = $single->igst_rate;
                        $product_set['cgst_amount']                  = $single->cgst_amount;
                        $product_set['sgst_amount']                  = $single->sgst_amount;
                        $product_set['igst_amount']                  = $single->igst_amount;
                        $product_set['discount']                     = $single->discount;

            $insertData['product_set']                  = json_encode($product_set);
             
             $result_insert = $this->save($insertData);
        }
    }



}











  