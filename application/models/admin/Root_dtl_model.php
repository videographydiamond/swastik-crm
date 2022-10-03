<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Root_dtl_model extends Base_model
{

    public $table = "z_booking_route_dtl";

    //set column field database for datatable orderable
    var $column_order = array(null, 'r.name','c.city','rdtl.start_end_points','rdtl.pin', 'rdtl.create_at','rdtl.status'); 

    //set column field database for datatable searchable 
    var $column_search = array('r.name','c.city','rdtl.start_end_point','rdtl.pin', 'rdtl.create_at','rdtl.status'); 

    var $order = array('rdtl.orders' => 'DESC'); // default order



        



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
            $this->db->select('rdtl.*,r.name as root_name,c.city as city_name,rdtl.start_end_points as pin'); 
            $this->_get_datatables_query();

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query()
        {     
            $this->db->from($this->table. ' as rdtl');  
            $this->db->join('z_booking_route as r', 'r.id = rdtl.route_id','left');
            $this->db->join('z_cities as c', 'c.id = rdtl.city_id','left');
             
             

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

             
             if(isset($_POST['route_id']) && !empty($_POST['route_id'])) // here order processing

            {

                $this->db->where('rdtl.route_id', $_POST['route_id']);

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











  