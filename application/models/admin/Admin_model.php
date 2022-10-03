<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Admin_model extends Base_model
{

    public $table = "z_admin";

    //set column field database for datatable orderable
    var $column_order = array(null, 'name', 'slug', 'status'); 

    //set column field database for datatable searchable 
    var $column_search = array('name'); 

    var $order = array('id' => 'asc'); // default order



        



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

            $this->_get_datatables_query();

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query()
        {     

            $this->db->from($this->table);

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

            $this->db->from($this->table);

            return $this->db->count_all_results();

        }




        function getRows($params = array())
        {
           

                $this->db->select('a.*, cit.city as city, sta.name as state, dist.name as district ');
                $this->db->from($this->table. ' as a'); 
                $this->db->join('z_states as sta', 'sta.id = a.state_id', 'left');
                $this->db->join('z_district as dist', 'dist.id = a.district_id', 'left');
                $this->db->join('z_cities as cit', 'cit.id = a.city_id', 'left');
                  
                    $role = $this->session->userdata('role');
                    $company_id = $this->session->userdata('company_id');

                $where  = '';
                $userid = $params['userid'];
               /* $where.= "( a.status = 1 )";*/
               if($role==1)
               {
                  $where.= "( a.status = 1 OR  a.status = 0 )";
                 //$where.= "   ( a.company_id = '".$company_id."')";
            }else{
                $where.= "   ( a.created_by = '".$userid."')";
            }
            
            

               
                    

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {
                     
                    foreach($params['where'] as $key => $val){ 
                     if($key =='customer_title')
                    {

                    
                    }else{
                        $where.= " AND ( a.".$key." = '".$val."' )";
                    }

                } 

                  if(isset($params['where']['customer_title']))
                {
                    if(!empty($where))
                    {
                        
                    }
                    $this->db->or_like('customer_title', $params['where']['customer_title']);
                 }
                 

 
                     
                }
                
            }

            $this->db->where($where); 
           
         if(array_key_exists("returnType",$params) && $params['returnType'] == 'count')
         {
                $result = $this->db->count_all_results(); 
            }else{ 
                if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                    if(!empty($params['id'])){ 
                        $this->db->where('id', $params['id']); 
                    } 
                    $query = $this->db->get(); 
                    $result = $query->row_array(); 
                }else{ 
                    $this->db->order_by('a.id', 'desc'); 
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











  