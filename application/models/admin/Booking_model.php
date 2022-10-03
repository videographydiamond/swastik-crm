<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Booking_model extends Base_model
{

    public $table = "z_booking";

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
                $this->db->join('z_admin as executive', 'executive.id = c.agent_id', 'left'); 
                $this->db->join('z_admin as admin', 'admin.id = c.created_by', 'left');
                $this->db->join('z_admin as admin2', 'admin2.id = c.assigned_to', 'left');
                /*$this->db->join('z_call_direction as calldirection', 'calldirection.id = c.last_call_direction', 'left');*/
                
               /* $this->db->join('z_admin as admin3', 'admin3.id = c.last_follower', 'left');*/
                /*$this->db->join('z_call_type as last_ctype', 'last_ctype.id = c.last_follow_call_type', 'left');*/

                $where  = '';
                $userid = $this->session->userdata('userId');
                 $role = $this->session->userdata('role');
                
                   
                

                    $company_id = $this->session->userdata('company_id');
                    if($role ==1)
                    {
                        $where.= "( c.status = 1 )";
                    }else
                    {
                        $where.= "( c.status = 1 AND c.company_id=".$company_id." )";  
                    }
                    
              /*  if($role==1)
                {
                    if(isset($params['form_type']) && $params['form_type']=='inquiry')
                    {
                        $where.= "( c.created_by = '".$params['userid']."' OR c.assigned_to='".$params['userid']."')";       
                    }else
                    {
                        $where.= "( c.status = 1 )";    
                    }
                    //$where.= "( c.status = '1' )";
                    
                }else
                {
                     $where.= "( c.created_by = '".$userid."' OR c.assigned_to='".$userid."')";

                }*/
                    

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {

                    $not_array = array();
                    $not_array[] = 'manage_booking_type';
                    $not_array[] = 'booking_delivery_status';
                    $not_array[] = 'delivery_start_date';
                    $not_array[] = 'delivery_end_date';
                    $not_array[] = 'booking_type';
                    $not_array[] = 'customer_title';
                    $not_array[] = 'customer_mobile';
                    $not_array[] = 'customer_alter_mobile';
                    $not_array[] = 'billing_address';
                    $not_array[] = 'other_city';
                    $not_array[] = 'other_district';
                    $not_array[] = 'other_state';
                    $not_array[] = 'req_delivery_date';
                    $not_array[] = 'start_date';
                    $not_array[] = 'end_date';
                    $not_array[] = 'search_type';
                    $not_array[] = 'advance_booking_status_value';
                    $not_array[] = 'advance_crop_status_value';
                    $not_array[] = 'advance_product_id_value';
                    $not_array[] = 'advance_agent_id_value';
                    $not_array[] = 'advance_state_value';
                    $not_array[] = 'advance_district_value';
                    $not_array[] = 'advance_city_value';
                    $not_array[] = 'plant_rate_amount';
                    $not_array[] = 'advance_plan_rate';
                    $not_array[] = 'advance_plan_quantity';
                    $not_array[] = 'advance_plant_quantity_amount';
                    $not_array[] = 'advance_oustanding';
                    $not_array[] = 'oustanding_amount';
                    $not_array[] = 'advance_recieved';
                    $not_array[] = 'advance_recieved_amount';
                    $not_array[] = 'advance_discount';
                    $not_array[] = 'advance_discount_amount';



                     
                     
                    foreach($params['where'] as $key => $val){ 
                   // $this->db->where('c.'.$key, $val); 
                    if(in_array($key, $not_array))
                    {

                    
                    }else{

                        $where.= " AND ( c.".$key." = '".$val."' )";
                    }

                    

                } 


                
                

                  if(isset($params['where']['booking_type']) && $params['where']['booking_type'] !=='')
                {
                    switch ($params['where']['booking_type']){
                        case 'today':
                            $start_date     = date('Y-m-d');
                            $end_date       = date('Y-m-d');
                            $params['where']['start_date'] = $start_date;
                            $params['where']['end_date']   = $end_date;
                            break;
                         case 'week':
                            $start_date = date('Y-m-d',strtotime("-7 days"));
                            $end_date  = date('Y-m-d');
                            $params['where']['start_date'] = $start_date;
                            $params['where']['end_date']   = $end_date;
                            break;
                        case 'month':
                            $currentmonth = date("Y-m");

                            $start_date     = $currentmonth."-01";
                            $end_date       =$currentmonth."-31";
                            
                            $params['where']['start_date'] = $start_date;
                            $params['where']['end_date']   = $end_date;
                            break;
                        case 'previous_month':
                            $currentdate = date("Y-m-d");

                            $prevcurrentdate = date("Y-m", strtotime ( '-1 month' , strtotime ( $currentdate ) )) ;
                            $start_date = $prevcurrentdate."-01";
                            $end_date =  $prevcurrentdate."-31";

                            $params['where']['start_date'] = $start_date;
                            $params['where']['end_date']   = $end_date;
                            break;
                        
                        default:
                             
                            break;
                    }

                     
                    
                } 

                 if(isset($params['where']['customer_title']))
                {
                     
                    $this->db->or_like('farmer.name', $params['where']['customer_title']);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                }
                 if(isset($params['where']['customer_mobile']))
                {
                     
                    $this->db->where('farmer.mobile', $params['where']['customer_mobile']);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                } 
                if(isset($params['where']['customer_alter_mobile']))
                {
                     
                    $this->db->where('farmer.alt_mobile', $params['where']['customer_alter_mobile']);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                }
                if(isset($params['where']['manage_booking_type']) && $params['where']['manage_booking_type'] =='harvesting')
                {
                     
                    //$this->db->('customer_name', $params['where']['customer_name']);
                    $names = array('under-harvesting', 'delivered','under-production','ready-harvest','marketed');
                    $this->db->where_in('booking_status', $names);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                } 
                if(isset($params['where']['manage_booking_type']) && $params['where']['manage_booking_type'] =='delivery')
                {


                    
                    if(isset($params['where']['delivery_start_date']) && isset($params['where']['delivery_end_date']))
                    {
                        $start_date     = $params['where']['delivery_start_date'];
                        $end_date       = $params['where']['delivery_end_date'];
                        $where.= " AND ( c.delivery_date  >='".$start_date."' AND c.delivery_date  <='".$end_date."' )";    
                    }

                    if(isset($params['where']['booking_delivery_status']) && $params['where']['booking_delivery_status'] =='delivered')
                    {
                     $where.= " AND ( c.booking_status ='delivered')";       
                    }else{
                        $where.= " AND ( c.booking_status !='delivered')";       
                    }





                    
                    
                } 

                if(isset($params['where']['billing_address']))
                {
                     
                    $this->db->or_like('billing_address', $params['where']['billing_address']);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                } 
                if(isset($params['where']['other_city']))
                {
                     
                    $this->db->or_like('other_city', $params['where']['other_city']);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                }
                if(isset($params['where']['other_district']))
                {
                     
                    $this->db->or_like('other_city', $params['where']['other_district']);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                }
                if(isset($params['where']['other_state']))
                {
                     
                    $this->db->or_like('other_city', $params['where']['other_state']);
                     //$where.= " (c.customer_title like '%".$params['where']['customer_title']."%')";
                } 
                if(isset($params['where']['req_delivery_date']))
                {
                    $str = $params['where']['req_delivery_date'];
                    $exploded_data = explode(":",$str);

                    $start_date = $exploded_data[0];
                    $end_date = $exploded_data[1];
                     
                       /* $this->db->where('order_date >=', $first_date);
                        $this->db->where('order_date <=', $second_date);*/

                        $where.= " AND ( c.delivery_expect_start_date  >='".$start_date."' AND c.delivery_expect_end_date  <='".$end_date."' )";
                }
                if(isset($params['where']['start_date']) && isset($params['where']['end_date']))
                {
                    

                    $start_date = $params['where']['start_date'];
                    $end_date = $params['where']['end_date'];
                     
                       

                        $where.= " AND ( c.create_date  >='".$start_date."' AND c.create_date  <='".$end_date."' )";
                }

                /*advance search type*/

                if(isset($params['where']['search_type']) && $params['where']['search_type'] =="Advance")
                {

                     
                    
                     if(isset($params['where']['advance_booking_status_value']) )
                    {
                        $var = explode(',', $params['where']['advance_booking_status_value']);
                         
                        $csvexploded =  arrayToSqlCsv($var);


                         
                        $where.= " AND ( c.booking_status IN (".$csvexploded.") )";
                    }
                     if(isset($params['where']['advance_crop_status_value']) )
                    {
                        $var = explode(',', $params['where']['advance_crop_status_value']);
                         
                        $csvexploded =  arrayToSqlCsv($var);


                         
                        $where.= " AND ( c.crop_status IN (".$csvexploded.") )";
                    }
                     if(isset($params['where']['advance_agent_id_value']) )
                    {
                        $var = explode(',', $params['where']['advance_agent_id_value']);
                         
                        $csvexploded =  arrayToSqlCsv($var);


                         
                        $where.= " AND ( c.agent_id IN (".$csvexploded.") )";
                    }
                    if(isset($params['where']['advance_product_id_value']) )
                    {
                        $var = explode(',', $params['where']['advance_product_id_value']);
                         
                        $csvexploded =  arrayToSqlCsv($var);


                         
                        $where.= " AND ( c.product_id IN (".$csvexploded.") )";
                    }
                    if(isset($params['where']['advance_state_value']) )
                    {
                        $var = explode(',', $params['where']['advance_state_value']);
                         
                        $csvexploded =  arrayToSqlCsv($var);


                         
                        $where.= " AND ( c.state IN (".$csvexploded.") )";
                    }
                    if(isset($params['where']['advance_district_value']) )
                    {
                        $var = explode(',', $params['where']['advance_district_value']);
                         
                        $csvexploded =  arrayToSqlCsv($var);


                         
                        $where.= " AND ( c.district IN (".$csvexploded.") )";
                    }
                    if(isset($params['where']['advance_city_value']) )
                    {
                        $var = explode(',', $params['where']['advance_city_value']);
                         
                        $csvexploded =  arrayToSqlCsv($var);


                         
                        $where.= " AND ( c.city IN (".$csvexploded.") )";
                    }
                    /*print_r($params['where']['advance_plan_rate']);
                    print_r($params['where']['plant_rate_amount']);die;*/
                    if(isset($params['where']['advance_plan_rate']) && $params['where']['plant_rate_amount'] !=='')
                    {
                        $symbole = $params['where']['advance_plan_rate'];
                        $amount = $params['where']['plant_rate_amount'];
                        $where.= " AND ( c.price ".$symbole."  ".$amount." )";
                    } 
                    if(isset($params['where']['advance_plan_quantity']) &&  $params['where']['advance_plant_quantity_amount'] !=='')
                    {
                        $symbole = $params['where']['advance_plan_quantity'];
                        $amount = $params['where']['advance_plant_quantity_amount'];
                        $where.= " AND ( c.quantity ".$symbole."  ".$amount." )";
                    }
                     
                    if(isset($params['where']['advance_oustanding']) &&   $params['where']['oustanding_amount'] !=='')
                    {
                        $symbole = $params['where']['advance_oustanding'];
                        $amount = $params['where']['oustanding_amount'];
                        $where.= " AND ( c.outstanding_amount ".$symbole."  ".$amount." )";
                    }
                    if(isset($params['where']['advance_recieved']) &&   $params['where']['advance_recieved_amount'] !=='')
                    {
                        $symbole = $params['where']['advance_recieved'];
                        $amount = $params['where']['advance_recieved_amount'];
                        $where.= " AND ( c.advance ".$symbole."  ".$amount." )";

                    }


                    if(isset($params['where']['advance_discount']) && $params['where']['advance_discount_amount'] !=='')
                    {
                        $symbole = $params['where']['advance_discount'];
                        $amount = $params['where']['advance_discount_amount'];
                        $where.= " AND ( c.discount ".$symbole."  ".$amount." )";
                         
                    }
                     
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

            
            $role = $this->session->userdata('role');
            $company_id = $this->session->userdata('company_id');
            if($role ==1)
            {
                $where.= "( c.status = 1 )";
            }else
            {
                $where.= "( c.status = 1 AND c.company_id=".$company_id." )";  
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


    public function booking_log($id)
    {
        $single_arr = $this->find($id);
        if(!empty($single_arr))
        {
            $single = $single_arr;
            $insertData = array();
            $insertData['customer_id']                  = $get_customerid;
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
            $insertData['delivery_expect_start_date']   = $start_date;
            $insertData['delivery_expect_end_date']     = $end_date;
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
            $insertData['balance']                      = $single->balance;
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
             
             $result_insert = $this->booking_model->save($insertData);
        }
    }

     
    public function total_summary($variable,$types= array())
    {

        
        $globl_arr = [];
        $start_date = '';
        $end_date = '';
         $company_id = $this->session->userdata('company_id');
         if(isset($types['month_wise']) && $types['month_wise'] !=='')
        {
            $exploded = explode('-', $types['month_wise']);
            $start_date = $exploded[0]."-".$exploded[1]."-01";
            $end_date = $exploded[0]."-".$exploded[1]."-31";
        } 
    
        foreach ($variable as $key => $value1) {



            $booking_status         = $value1;
            $where                  = array();
            $where['field']         = 'id,quantity';

            if(isset($types['month_wise']) && $start_date !=='' && $end_date !=='')
            {
                $where['booking_date >=']= $start_date;    
                $where['booking_date <=']= $end_date;    
            }
            if(isset($types['product_id']) &&$types['product_id'])
            {
                $where['product_id']= $types['product_id'];    
            }
            $where['booking_status']= $booking_status;
            $where['company_id'] = $company_id;
            $booked_no_of_booking   = 0;
            $no_of_plant            = 0;

            $total_booked = $this->booking_model->findDynamic($where);
            if(!empty($total_booked))
            {
                foreach ($total_booked as $key => $value) {
                     $booked_no_of_booking+= 1;
                     $no_of_plant+= $value->quantity;
                }
            }

            $array = [];
            $array["name"]  = $value1;
             $array[$booking_status."_booking"]  =  $booked_no_of_booking;
            $array[$booking_status."_plant"]    =  $no_of_plant;

            $globl_arr[] = $array;
        }

        return $globl_arr;


    }

    public function getBookedSummary()
    {
        $show_summary  = [];
        
         

        $where_data = array();
        $where_data[] = 'booked';
        $where_data[] = 'delivered';
        $where_data[] = 'cancelled';
        $where_data[] = 'processing';
        $total_summary = $this->total_summary($where_data);
        $show_summary['total_summary'] = $total_summary;
        $types = array();
        $types['month_wise'] = date('Y-m-d');
        $total_summary_current_month = $this->total_summary($where_data,$types);
        $show_summary['total_summary_current_month'] = $total_summary_current_month;

        $types = array();
        $types['month_wise'] = date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        $total_summary_previous_month = $this->total_summary($where_data,$types);
        $show_summary['total_summary_previous_month'] = $total_summary_previous_month;



         $query = $this->db->select("id,product_id")->from($this->table)->group_by('product_id')->get();

         if ($query->num_rows() > 0) {

                $product_id_group_array = $query->result();

            } else {

                $product_id_group_array = array();

            }
            $products_data  = array();
            if(!empty($product_id_group_array))
            {
                foreach ($product_id_group_array as $key => $value)
                {
                    if($value->product_id)
                    {
                         $where = array();
                        $where['table'] = 'z_product';
                        $where['field'] = 'id,title';
                        $where['id'] = $value->product_id;
                        $product_data = $this->booking_model->findDynamic($where);
                        $types = array();
                        $types['product_id'] = $value->product_id;
                         $products_data[] = $this->total_summary($where_data,$types);
                        $show_summary['productname'][] =  (isset($product_data[0]->title) && $product_data[0]->title !=='')?($product_data[0]->title):'';;
                    }
                   
                }
            }

            $show_summary['products'] = $products_data;
            /*echo "<pre>";
            print_r($product_id_group_array);
            echo "</pre>";*/
        

        return  $show_summary;

    }

     

}  