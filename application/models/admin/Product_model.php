<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Product_model extends Base_model

{

    public $table = "z_product";

 



    var $column_order = array(null,  'c.name','p.title','p.hsn','p.price','p.usage_unit','p.tax_rate','p.discount','p.source','p.date_at','p.status'); //set column field database for datatable orderable

    var $column_search = array('c.name','p.title','p.hsn','p.price','p.usage_unit','p.tax_rate','p.discount','p.source','p.date_at','p.status'); //set column field database for datatable searchable 

    var $order = array('p.id' => 'desc'); // default order



        



        function __construct() {



            parent::__construct();



        }







     function delete($id) {



        $this->db->where('id', $id);



        $this->db->delete($this->table);        



        return $this->db->affected_rows();



    }

	

	

	// cart product

	public function cart_product($data) {

			

			//$this->db->select('*');

			$this->db->from($this->table);

			foreach($data as $k=>$v)

			{

				

				if(isset($where))

				{

					$where .= " OR id='".$k."'";

				}

				else

					$where = "id='".$k."'";

			}

			

			$this->db->where($where);

			

			$query = $this->db->get();

           if ($query->num_rows() > 0) {



               $result = $query->result();

               $temp = $query->result();

			   foreach($temp as $k=>$v)

			   {

				   $result[$k]->no_item = $data[$v->id]; 

			   }

			   return $result;

			}

			else {



                return array();



            }



			exit;

            



        }

		

		// Find

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
             $this->db->select('p.*,c.name as category'); 
            $this->_get_datatables_query();

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query()

        {     

 
             $this->db->from($this->table. ' as p');  
            $this->db->join('z_product_category as c', 'c.id = p.category_id','left');


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

             if(isset($_POST['category_id']) && !empty($_POST['category_id'])) // here order processing

            {

                $this->db->where('category_id', $_POST['category_id']);

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











  