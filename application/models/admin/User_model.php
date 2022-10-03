<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class User_model extends Base_model
{

    public $table = "z_users";

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
/*
        public function menu_with_auth($parent_id = '')
        {
            $userid = $this->session->userdata('userId');
            $this->db->select('admin_role.role_id as admin_role_role_id,admin_role.user_id as user_id,module_role.module_id as module_role_module_id, module_role.role_id as module_role_role_id,module.module_name as menu_title,module.module_url as menu_url,module.icon_name as icon_class,module.target as with_target');
            $this->db->from('z_module_role as module_role '); 
            $this->db->join('z_admin_role as admin_role', 'admin_role.role_id = module_role.role_id' );
            $this->db->join('z_module_m as module', 'module.id = module_role.module_id');
            if($parent_id >0)
            {
                $this->db->where('module.parent_id',$parent_id);    
            }else
            {
                $this->db->where('module.parent_id !=',$parent_id); 
            }
             
             $this->db->where('admin_role.user_id',$userid); 
             $this->db->order_by('module.orders_with','ASC'); 

                $query = $this->db->get();
                return $result = $query->result_array();
        }
         */



}











  