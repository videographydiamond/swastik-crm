<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Village_pin_model extends Base_model
{

    public $table = "z_village_pin";


     var $column_order = array(null, 'c.name','st.name' ,'dt.name' ,'cit.city' ,'vil.name' ,'vil.pincode' ,'vil.status', null); //set column field database for datatable orderable
    var $column_search = array( 'c.name','st.name' ,'dt.name' ,'cit.city' ,'vil.name','vil.pincode' ,'vil.status'); //set column field database for datatable searchable 

   

    var $order = array('vil.id' => 'desc'); // default order



        



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
            $this->db->select('vil.*,c.name as country,st.name as state,dt.name as district,cit.city as city_name');
            $this->_get_datatables_query();

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query()
        {     

 
             $this->db->from($this->table. ' as vil');  
            $this->db->join('z_countries as c', 'c.id = vil.country_id');
            $this->db->join('z_states as st', 'st.id = vil.state_id');
            $this->db->join('z_district as dt', 'dt.id = vil.district_id');
            $this->db->join('z_cities as cit', 'cit.id = vil.city_id');
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



}

