<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Customer_call_model extends Base_model
{

    public $table = "z_customer_call";

    //set column field database for datatable orderable
    var $column_order = array(null,'cc.date_at', 'c.customer_title', 'ct.title',  'cc.call_back_date', 'cd.title',  'cc.current_conversation'); 

    //set column field database for datatable searchable 
    var $column_search = array('cc.date_at', 'c.customer_title', 'ct.title',  'cc.call_back_date', 'cd.title',  'cc.current_conversation'); 

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

            $this->db->select('cc.*, c.customer_title as customer_title, ct.title as call_type_title, cd.title as call_direction_title');
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
            $this->db->join('z_customer as c', 'c.id = cc.customer', 'left');
            $this->db->join('z_call_type as ct', 'ct.id = cc.call_type', 'left');
             $this->db->join('z_call_direction as cd', 'cd.id = cc.call_direction', 'left');

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

             $this->db->where('cc.assign_to', $customer);
               

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
            $this->db->where('cc.assign_to', $customer);


            return $this->db->count_all_results();

        }



}











  