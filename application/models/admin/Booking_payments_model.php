<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Booking_payments_model extends Base_model
{

    public $table = "z_booking_payments";

    //set column field database for datatable orderable
    var $column_order = array(null, 'title', 'status');

    //set column field database for datatable searchable 
    var $column_search = array('title', 'status'); 

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

        public function getPaymentDetail($id,$transaction_type='booking')
        {
            $result = array();
            if(!empty($id))
            {
                $this->db->select('pay.*, petype.title as paynmenttype, pemtmode.title as paynmentmode');
                $this->db->from($this->table. ' as pay'); 
                $this->db->join('z_payment_type as petype', 'petype.slug = pay.payment_type', 'left');
                $this->db->join('z_payment_mode as pemtmode', 'pemtmode.slug = pay.payment_mode', 'left');
                $this->db->where('pay.status', 1); 
                $this->db->where('pay.transaction_type', $transaction_type); 
                $this->db->where('pay.booking_id', $id); 
                $this->db->order_by("pay.id", "asc");

                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():array(); 
            }
                
        return $result; 
        }



}











  