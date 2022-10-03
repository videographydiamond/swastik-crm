<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Company_model extends Base_model
{

    public $table = "z_company";

   var $column_order = array(null,  'c.id','c.title',null,null,'c.phone','c.email','c.website','c.gst_no','c.pan_no','c.nursury_address','c.office_address','st.name','dist.name','ct.city','c.bank_name','c.bank_account_number','c.bank_holder_name','c.bank_ifsc_code','c.bank_branch_address','c.social_url','c.date_at','c.status'); //set column field database for datatable orderable

    var $column_search = array('c.id','c.title','c.phone','c.email','c.website','c.gst_no','c.pan_no','c.nursury_address','c.office_address','st.name','dist.name','ct.city','c.bank_name','c.bank_account_number','c.bank_holder_name','c.bank_ifsc_code','c.bank_branch_address','c.social_url','c.date_at','c.status'); //set column field database for datatable searchable 


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

              $this->db->select('c.*,st.name as state_name,dist.name as district_name,ct.city as city_name'); 
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
            $this->db->join('z_states as st', 'st.id = c.state','left');
            $this->db->join('z_district as dist', 'dist.id = c.district','left');
            $this->db->join('z_cities as ct', 'ct.id = c.city','left');

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

    public function findCompanyDetail($params)
    {
                $this->db->select('c.*, cit.city as city, sta.name as state,sta.id as statecode, dist.name as district');
                $this->db->from($this->table. ' as c'); 
                $this->db->join('z_states as sta', 'sta.id = c.state', 'left');
                $this->db->join('z_district as dist', 'dist.id = c.district', 'left');
                $this->db->join('z_cities as cit', 'cit.id = c.city', 'left');

                $where  = '';
                $where.= "( c.status = 1 )"; 

                if(array_key_exists("where", $params)){
                    if(!empty($params['where']))
                    {

                    foreach($params['where'] as $key => $val){ 

                        $where.= " AND ( c.".$key." = '".$val."' )";
                         

                        } 
                    } 
                } 
                $this->db->where($where); 


                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():array(); 
                 return $result; 




    }


}











  