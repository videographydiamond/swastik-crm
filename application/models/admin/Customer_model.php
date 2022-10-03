<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Customer_model extends Base_model
{

    public $table = "z_customer";

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
           

                $this->db->select('c.*, farmer.name  as farmername,farmer.is_premium  as premium, farmer.mobile  as farmermobile,farmer.alt_mobile  as farmeraltmobile,cit.city as city, sta.name as state, ftype.title as farmertype, crop.title as cropname, dist.name as district, ctype.title as calltype,   calldirection.title as calldir,   admin.title as createdby,   admin2.title as assignedto,   admin3.title as lastfollower,   admin3.title as lastfollower,   last_ctype.title as lastcalltype');
                $this->db->from($this->table. ' as c'); 
                $this->db->join('z_farmers as farmer', 'farmer.id = c.farmer_id', 'left');
                $this->db->join('z_states as sta', 'sta.id = farmer.state_id', 'left');
                $this->db->join('z_farmer_type as ftype', 'ftype.id = farmer.farmer_type', 'left');
                $this->db->join('z_crop as crop', 'crop.id = farmer.crop_id', 'left');
                $this->db->join('z_district as dist', 'dist.id = farmer.district_id', 'left');
                $this->db->join('z_cities as cit', 'cit.id = farmer.city_id', 'left');
                $this->db->join('z_call_type as ctype', 'ctype.id = c.last_call_type', 'left');
                 
                $this->db->join('z_call_direction as calldirection', 'calldirection.id = c.last_call_direction', 'left');
                $this->db->join('z_admin as admin', 'admin.id = c.created_by', 'left');
                $this->db->join('z_admin as admin2', 'admin2.id = c.assigned_to', 'left');
                $this->db->join('z_admin as admin3', 'admin3.id = c.last_follower', 'left');
                $this->db->join('z_call_type as last_ctype', 'last_ctype.id = c.last_follow_call_type', 'left');

                $where  = '';
                 
                    $role = $this->session->userdata('role');
                    $company_id = $this->session->userdata('company_id');
                    $current_date = date("Y-m-d");
                    if($role ==1)
                    {
                        $where.= "( c.status = 1 AND c.farmer_id !='')";
                    }else
                    {
                        $where.= "( c.status = 1 AND c.company_id=".$company_id."  AND c.farmer_id !='')";  
                    }
                    
                    
                   


 
        
                
                     

               
                    

            if(array_key_exists("where", $params)){

                 if(isset($params['uid']) && $params['uid'] !=='all')
                    {
                        $userid = $params['uid'];
                        $where.= " AND ( c.assigned_to = '".$userid."')";
                    }


                if(!empty($params['where']))
                {
                     
                    foreach($params['where'] as $key => $val){ 
                     if($key =='customer_title' || $key =='farmer_type' || $key =='crop_id' || $key =='customer_mobile'  || $key =='customer_alt_mobile' || $key =='state' || $key =='stat_type' ||   $key =='from_date' || $key =='to_date' || $key =='current_date'  || $key =='exp_from_date'  || $key =='exp_to_date' )
                    {

                    
                    }else{
                        $where.= " AND ( c.".$key." = '".$val."' )";
                    }

                }
                

                    if(isset($params['where']['current_date']))
                    {

                         $current_date = $params['where']['current_date'];
                    } 
                    if(isset($params['where']['customer_title']))
                    {

                        $this->db->or_like('farmer.name', $params['where']['customer_title']);
                    }  
                    if(isset($params['where']['crop_id']))
                    {

                        $this->db->where('farmer.crop_id', $params['where']['crop_id']);
                    }
                    if(isset($params['where']['farmer_type']))
                    {

                        $this->db->where('farmer.farmer_type', $params['where']['farmer_type']);
                    }
                    if(isset($params['where']['customer_mobile']))
                    {

                        $this->db->where('farmer.mobile', $params['where']['customer_mobile']);
                    }
                    if(isset($params['where']['customer_alt_mobile']))
                    {

                        $this->db->where('farmer.alt_mobile', $params['where']['customer_alt_mobile']);
                    }
                    if(isset($params['where']['state']))
                    {

                        $this->db->where('farmer.state_id', $params['where']['state']);
                    }
                    if(isset($params['where']['city']))
                    {

                        $this->db->where('farmer.city_id', $params['where']['city']);
                    }
                    if(isset($params['where']['district']))
                    {

                        $this->db->where('farmer.district_id', $params['where']['district']);
                    }

                 if(isset($params['where']['from_date']) && isset($params['where']['to_date']))
                {
                    $fromdate = $params['where']['from_date'];
                    $to_date = $params['where']['to_date'];

                    $where.= " AND (c.date_at >= '".$fromdate."' AND c.date_at <= '".$to_date."' )";
                  } 
                  if(isset($params['where']['exp_from_date']) && isset($params['where']['exp_to_date']))
                {
                    $fromdate = $params['where']['exp_from_date'];
                    $to_date = $params['where']['exp_to_date'];

                    $where.= " AND (c.last_follow_date >= '".$fromdate."' AND c.last_follow_date <= '".$to_date."' )";
                  }
                if(isset($params['where']['stat_type']))
                {
                    if($params['where']['stat_type'] =='followup' && $params['followup_type']=='yesterday')
                    {
                         

                         
                         $back_date = $current_date;
                        /*$where.= "  AND c.last_call_back_date < '".$back_date."'"; */
                         $where.= "  AND (c.last_call_back_date <'".$back_date."' AND  c.last_call_back_date != '0000-00-00')";  


                    }else if($params['where']['stat_type'] =='followup' && $params['followup_type']=='today')
                    {
                         

                        $back_date =  $current_date;
                        $where.= "  AND c.last_call_back_date='".$back_date."'"; 


                    }else if($params['where']['stat_type'] =='followup' && $params['followup_type']=='tomorrow')
                    {
                         

                         $back_date = date('Y-m-d',strtotime("+1 days",strtotime( $current_date )));
                        $where.= "  AND c.last_call_back_date='".$back_date."'"; 


                    }else if($params['where']['stat_type'] =='call_type2')
                    {
                        $current_date = $current_date;
                        $where.= " AND (c.last_follow_date='".$current_date."')";
                    }else if($params['where']['stat_type'] =='all')
                    {
                        $current_date = $current_date;
                        $where.= " AND (c.last_follow_date='".$current_date."')";
                         

                          
                    }else if($params['where']['stat_type'] =='allcall')
                    {
                        $current_date =  $current_date;
                        $where.= " AND (c.last_follow_date='".$current_date."')";
                    }
                     
                    
                }

 
                     
                }
                
            }

            $this->db->where($where); 
           
         if(array_key_exists("returnType",$params) && $params['returnType'] == 'count')
         {
                if(isset($params['where']['stat_type']) && @$params['where']['stat_type'] =='all')
                {

                    $this->db->group_by('c.farmer_id'); 
                }

                //$result = $this->db->count_all_results(); 
                    $query = $this->db->get(); 
                    $result = $query->num_rows() ; 
            }else{ 
                if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                    if(!empty($params['id'])){ 
                        $this->db->where('id', $params['id']); 
                    } 

                    $query = $this->db->get(); 
                    $result = $query->row_array(); 
                }else{ 

                    if(isset($params['where']['stat_type']) && @$params['where']['stat_type'] =='all')
                    {
                          
                         $this->db->group_by('c.farmer_id'); 
                    }

                    $this->db->order_by('c.update_at', 'desc'); 
                    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 

                         $this->db->limit($params['limit'],$params['start']); 
                    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                        $this->db->limit($params['limit']); 
                    } 
                     
                    $query = $this->db->get(); 
                    $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
                } 
            } 
             
             return $result; 
    } 



}











  