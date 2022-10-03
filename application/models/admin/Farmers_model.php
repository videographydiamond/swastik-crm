<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Farmers_model extends Base_model
{

    public $table = "z_farmers";


     var $column_order = array('f.id', 'f.name', 'f.mobile', 'f.alt_mobile', 'f.father_name', 'f.whatsapp', 'f.village', 'f.address', 'st.name' ,'dt.name' ,'ct.city' , 'f.pincode', 'f.source','f.date_at','f.status'); //set column field database for datatable orderable
    var $column_search = array( 'f.id', 'f.name', 'f.mobile', 'f.alt_mobile', 'f.father_name', 'f.whatsapp', 'f.village', 'f.address', 'st.name' ,'dt.name' ,'ct.city' , 'f.pincode', 'f.source','f.date_at','f.status');  

   

    var $order = array('f.id' => 'desc'); // default order



        



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
            $this->db->select('f.*,ct.city as city,st.name as state,dt.name as district');
            $this->_get_datatables_query();

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query()
        {     

 
             $this->db->from($this->table. ' as f');  
            
            $this->db->join('z_states as st', 'st.id = f.state_id');
            $this->db->join('z_district as dt', 'dt.id = f.district_id');
            $this->db->join('z_cities as ct', 'ct.id = f.city_id');
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
           

                $this->db->select('f.*, cit.city as city, sta.name as state,ftype.title as farmertype, dist.name as district, source.title as source');
                $this->db->from($this->table. ' as f'); 
                $this->db->join('z_states as sta', 'sta.id = f.state_id', 'left');
                $this->db->join('z_farmer_type as ftype', 'ftype.id = f.farmer_type', 'left');
                $this->db->join('z_district as dist', 'dist.id = f.district_id', 'left');
                $this->db->join('z_cities as cit', 'cit.id = f.city_id', 'left');
                $this->db->join('z_lead_source as source', 'source.id = f.source', 'left');

                $role = $this->session->userdata('role');
                $company_id = $this->session->userdata('company_id');

                $where  = '';
                $userid = $params['userid'];
                /* $where.= "( f.status = 1 )";*/
                 
                  $where.= "   ( f.company_id = '".$company_id."')";
                 


               
                    

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {
                     
                    foreach($params['where'] as $key => $val){ 
                     if($key =='name' ||  $key =='father_name' )
                    {

                    
                    }else{
                        $where.= " AND ( f.".$key." = '".$val."' )";
                    }

                } 

                  if(isset($params['where']['name']))
                {
                     
                    $this->db->or_like('f.name', $params['where']['name']);
                 }
                 if(isset($params['where']['father_name']))
                {
                     
                    $this->db->or_like('f.father_name', $params['where']['father_name']);
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
                    $this->db->order_by('f.id', 'desc'); 
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

