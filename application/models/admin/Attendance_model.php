<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends Base_model
{

    public $table = "z_attendance";

    //set column field database for datatable orderable
    var $column_order = array(null, 'p.att_date','p.checkin', 'p.last_checkin', 'p.last_checkout', 'p.worked_hour',  'p.status',null); 

    //set column field database for datatable searchable 
    var $column_search = array('p.att_date','p.checkin', 'p.last_checkin', 'p.last_checkout', 'p.worked_hour',   'p.status'); 

    var $order = array('p.id' => 'DESC'); // default order



        



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
            $this->db->select('p.*');

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
            $this->db->where('p.user_id',$this->session->userdata('userId'));

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
            $this->db->where($this->table.'.user_id',$this->session->userdata('userId'));
            return $this->db->count_all_results();

        }

        public function sum_worked_hour($id)
        {
            $att_in = $this->db->select('MIN(a.time) as intime,MAX(a.time) as outtime')
                ->from('z_attendance_history a')
                 
                ->where('a.att_id',$id)
                ->get()
                ->result();
                return $att_in;
        }
        public function last_check_in($id)
        {
            $att_in = $this->db->select('MAX(a.time) as lastintime')
                ->from('z_attendance_history a')
                 
                ->where('a.att_id',$id)
                ->where('a.state',1)
                ->get()
                ->result();
                return $att_in;
        }

        function getRows($params = array())
        {
          /*  $this->db->select('*'); 
            $this->db->from($this->table); */

                $this->db->select('c.*, admin.title as username');
                $this->db->from($this->table. ' as c'); 
                 
                 $this->db->join('z_admin as admin', 'admin.id = c.user_id', 'left');
                
               

                $where  = '';
                $role = $this->session->userdata('role');
                $userid = $this->session->userdata('userId');
                $company_id = $this->session->userdata('company_id');

                $where.= "( c.status = 1 )";
                    
             
                    

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {

                    $not_array = array();
                    $not_array[] = 'start_date';
                    $not_array[] = 'end_date';
                    if($params['userid']=='all' && $role =='1' )
                    {
                        $not_array[] = 'user_id';
                    }
                    

                    foreach($params['where'] as $key => $val)
                    {
                       if(in_array($key, $not_array))
                        {

                        
                        }else{

                            $where.= " AND ( c.".$key." = '".$val."' )";
                        }

                        

                    } 


                
                 

                  if(isset($params['where']['start_date']) && isset($params['where']['end_date']))
                {
                    

                    $start_date = $params['where']['start_date'];
                    $end_date = $params['where']['end_date'];
                     
                       

                        $where.= " AND ( c.att_date  >='".$start_date."' AND c.att_date  <='".$end_date."' )";
                }

                

                 
                
 

                }
                
            }

            $this->db->where($where); 
            $this->db->order_by('att_date,user_id','desc'); 
            $this->db->group_by('att_date'); 
           




              
                


                
               
                


           
             

            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
                $result = $this->db->count_all_results(); 
            }else{ 
                if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                    if(!empty($params['id'])){ 
                        $this->db->where('id', $params['id']); 
                    } 
                    $query = $this->db->get(); 
                    $result = $query->row_array(); 
                }else{ 
                    $this->db->order_by('c.id', 'desc'); 
                    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 

                        //$starts = (($params['start']-1) < 0)?0:($params['start']-1);
                        $this->db->limit($params['limit'],$params['start']); 
                    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                        $this->db->limit($params['limit']); 
                    } 
                     
                    $query = $this->db->get(); 
                    $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
                } 
            } 
             
            // Return fetched data 
            return $result; 
    } 
    function getRowsEmpLog($params = array())
        {
          /*  $this->db->select('*'); 
            $this->db->from($this->table); */

                $this->db->select('c.*, admin.title as username');
                $this->db->from($this->table. ' as c'); 
                 
                 $this->db->join('z_admin as admin', 'admin.id = c.user_id', 'left');
                
               

                $where  = '';
                $role = $this->session->userdata('role');
                $userid = $this->session->userdata('userId');
                $company_id = $this->session->userdata('company_id');

                $where.= "( c.status = 1 )";
                    
             
                    

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {

                    $not_array = array();
                    $not_array[] = 'start_date';
                    $not_array[] = 'end_date';
                    if($params['userid']=='all' && $role =='1' )
                    {
                        $not_array[] = 'user_id';
                    }
                    

                    foreach($params['where'] as $key => $val)
                    {
                       if(in_array($key, $not_array))
                        {

                        
                        }else{

                            $where.= " AND ( c.".$key." = '".$val."' )";
                        }

                        

                    } 


                
                 

                  if(isset($params['where']['start_date']) && isset($params['where']['end_date']))
                {
                    

                    $start_date = $params['where']['start_date'];
                    $end_date = $params['where']['end_date'];
                     
                       

                        $where.= " AND ( c.att_date  >='".$start_date."' AND c.att_date  <='".$end_date."' )";
                }

                

                 
                
 

                }
                
            }

            $this->db->where($where); 
            $this->db->order_by('att_date,user_id','desc'); 
           




              
                


                
               
                


           
             

            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
                $result = $this->db->count_all_results(); 
            }else{ 
                if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                    if(!empty($params['id'])){ 
                        $this->db->where('id', $params['id']); 
                    } 
                    $query = $this->db->get(); 
                    $result = $query->row_array(); 
                }else{ 
                    $this->db->order_by('c.id', 'desc'); 
                    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 

                        //$starts = (($params['start']-1) < 0)?0:($params['start']-1);
                        $this->db->limit($params['limit'],$params['start']); 
                    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                        $this->db->limit($params['limit']); 
                    } 
                     
                    $query = $this->db->get(); 
                    $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
                } 
            } 
             
            // Return fetched data 
            return $result; 
    }
    function getRowsAtt($params = array())
        {
          /*  $this->db->select('*'); 
            $this->db->from($this->table); */

                $this->db->select('c.*, admin.title as username');
                $this->db->from($this->table. ' as c'); 
                 
                 $this->db->join('z_admin as admin', 'admin.id = c.user_id', 'left');
                
               

                $where  = '';
                $role   = $this->session->userdata('role');
                $userid = $this->session->userdata('userId');
                $company_id = $this->session->userdata('company_id');

                $where.= "( c.status = 1 )";
                    
             
                    

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {

                    $not_array = array();
                    $not_array[] = 'start_date';
                    $not_array[] = 'end_date';
                    

                    foreach($params['where'] as $key => $val)
                    {
                       if(in_array($key, $not_array))
                        {

                        
                        }else{

                            $where.= " AND ( c.".$key." = '".$val."' )";
                        }

                        

                    } 


                
                 

                  if(isset($params['where']['start_date']) && isset($params['where']['end_date']))
                {
                    

                    $start_date = $params['where']['start_date'];
                    $end_date = $params['where']['end_date'];
                     
                       

                        $where.= " AND ( c.att_date  >='".$start_date."' AND c.att_date  <='".$end_date."' )";
                }

                

                 
                
 

                }
                
            }

            $this->db->where($where); 
            $this->db->order_by('years,month,user_id','DESC'); 
 
           




              
                


                
               
                


           
             

            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
                $result = $this->db->count_all_results(); 
            }else{ 
                if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                    if(!empty($params['id'])){ 
                        $this->db->where('id', $params['id']); 
                    } 
                    $query = $this->db->get(); 
                    $result = $query->row_array(); 
                }else{ 
                    $this->db->order_by('c.id', 'desc'); 
                    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 

                        //$starts = (($params['start']-1) < 0)?0:($params['start']-1);
                        $this->db->limit($params['limit'],$params['start']); 
                    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                        $this->db->limit($params['limit']); 
                    } 
                     
                    $query = $this->db->get(); 
                    $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
                } 
            } 
             
            // Return fetched data 
            return $result; 
    } 

    function getRowsEmpDetails($params = array())
        {
          /*  $this->db->select('*'); 
            $this->db->from($this->table); */

                $this->db->select('c.*, admin.title as username');
                $this->db->from($this->table. ' as c'); 
                 
                 $this->db->join('z_admin as admin', 'admin.id = c.user_id', 'left');
                
               

                $where  = '';
                $role = $this->session->userdata('role');
                $userid = $this->session->userdata('userId');
                $company_id = $this->session->userdata('company_id');

                $where.= "( c.status = 1 )";
                    
             
                    

            if(array_key_exists("where", $params)){
                if(!empty($params['where']))
                {

                    $not_array = array();
                    $not_array[] = 'start_date';
                    $not_array[] = 'end_date';
                    if($params['userid']=='all' && $role =='1' )
                    {
                        $not_array[] = 'user_id';
                    }
                    

                    foreach($params['where'] as $key => $val)
                    {
                       if(in_array($key, $not_array))
                        {

                        
                        }else{

                            $where.= " AND ( c.".$key." = '".$val."' )";
                        }

                        

                    } 


                 
                

                 
                
 

                }
                
            }

            $this->db->where($where); 
            $this->db->order_by('c.att_date,c.user_id','desc'); 
            $this->db->group_by('c.att_date'); 
           




              
                


                
               
                


           
             

            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
                $result = $this->db->count_all_results(); 
            }else{ 
                if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                    if(!empty($params['id'])){ 
                        $this->db->where('id', $params['id']); 
                    } 
                    $query = $this->db->get(); 
                    $result = $query->row_array(); 
                }else{ 
                    $this->db->order_by('c.id', 'desc'); 
                    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 

                        //$starts = (($params['start']-1) < 0)?0:($params['start']-1);
                        $this->db->limit($params['limit'],$params['start']); 
                    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                        $this->db->limit($params['limit']); 
                    } 
                     
                    $query = $this->db->get(); 
                    $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
                } 
            } 
             
            // Return fetched data 
            return $result; 
    }



}











  