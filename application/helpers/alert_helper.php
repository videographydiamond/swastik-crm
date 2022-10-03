<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('test_method'))

{

    function show_alert($type = '', $msg= '')

    {

        $strSuccess = '<div class="alert alert-success a_success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ##msg##</div>';

        $strError = '<div class="alert alert-danger a_danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ##msg##</div>';

        $strWarning = '<div class="alert alert-warning a_warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>##msg##</div>';



        if($type=="success"){

        	$msg= str_replace('##msg##', $msg, $strSuccess);

        }elseif($type=="error"){

        	$msg= str_replace('##msg##', $msg, $strError);

        }elseif($type=="warning"){

        	$msg= str_replace('##msg##', $msg, $strWarning);

        }

        echo $msg;

    }   

}

if(!function_exists('get_finacial_year_range'))
{
  function get_finacial_year_range($current_year) {
    $year = date('Y',strtotime($current_year));
    $month = date('m',strtotime($current_year));
    if($month<4){
        $year = $year-1;
    }
    $start_date = date('Y-m-d',strtotime(($year).'-04-01'));
    $end_date = date('Y-m-d',strtotime(($year+1).'-03-31'));
    $response = array('start_date' => $start_date, 'end_date' => $end_date);
    return $response;
}
}
if(!function_exists('arrayToSqlCsv'))
{
  function arrayToSqlCsv(array $array)
  {
    $stringgify = '';
    if(!empty($array))
    {
       
         
       $inc = 0;
        foreach ($array as $key => $value)
        {

          if($inc==0)
          {
            $stringgify.="'".$value."'";  
            
            
          }else
          {
            $stringgify.=", '".$value."'";
          }
          $inc++;

          
        }
       
      
    } 

    return $stringgify;
  }
}
if(!function_exists('clean_slug'))
{
    function clean_slug($string) 
    {
      $string = trim($string); // remove start and end espace all spaces with hyphens.
      $string = strtolower($string); // remove start and end espace all spaces with hyphens.
      $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.

      $string =  preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.
      $string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.
      return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}

if( !function_exists('menu_with_auth'))
{
  function menu_with_auth($parent_id = 0,$userid='' )
{
            $ci =& get_instance();
            $ci->load->database();
   
   
             $ci->db->select('admin_role.role_id as admin_role_role_id,admin_role.user_id as user_id,module_role.module_id as module_role_module_id, module_role.role_id as module_role_role_id,module.module_name as menu_title,module.module_url as menu_url,module.icon_name as icon_class,module.target as with_target,module.id as moduleid');
            $ci->db->from('z_module_role as module_role '); 
            $ci->db->join('z_admin_role as admin_role', 'admin_role.role_id = module_role.role_id' );
            $ci->db->join('z_module_m as module', 'module.id = module_role.module_id');

            if($parent_id >0)
            {
                $ci->db->where('module.parent_id',$parent_id);    
            }else
            {
                $ci->db->where('module.parent_id ',$parent_id); 
            }
            if($userid !=='')
            {
              $ci->db->where('admin_role.user_id',$userid);  
            }
             
             $ci->db->where('module_role.status',1); 
             $ci->db->where('admin_role.status',1); 
             $ci->db->where('module.status',1); 
             $ci->db->order_by('module.orders_with','ASC'); 

                $query = $ci->db->get();
                return $result = $query->result_array();
}
}

if(!function_exists('get_employees_att_by_monthyear')){
  function get_employees_att_by_monthyear($att_date)
  {

      $ci =& get_instance();
      $ci->load->database();

      $ci->db->select('c.*, admin.title as username');
      $ci->db->from('z_attendance as c'); 

      $ci->db->join('z_admin as admin', 'admin.id = c.user_id', 'left');

      $ci->db->where('c.att_date',$att_date); 
       
      $ci->db->order_by('c.user_id','ASC'); 

                $query = $ci->db->get();
                return $result = $query->result_array();
  }
}
if(!function_exists('get_booking_root')){
  function get_booking_root()
  {

      $ci =& get_instance();
      $ci->load->database();

      $ci->db->select('r.id,r.name');
      $ci->db->from('z_booking_route as r'); 

 
      $ci->db->where('r.status',1); 
       
      $ci->db->order_by('r.name','ASC'); 

                $query = $ci->db->get();
                return $result = $query->result_array();
  }
}
if(!function_exists('booking_roots')){
  function booking_roots($route_id)
  {

      $ci =& get_instance();
      $ci->load->database();


             
            $ci->db->select('r.city_id,r.start_end_points as edge,r.route_id,cit.city as root_point ');
            $ci->db->from('z_booking_route_dtl as r'); 
            $ci->db->join('z_cities as cit', 'cit.id = r.city_id', 'left');
              
            $ci->db->order_by("r.orders", "asc");
            $ci->db->group_by("r.city_id");
            $ci->db->where("r.route_id", $route_id);
           

            $query = $ci->db->get(); 
            $result = ($query->num_rows() > 0)?$query->result_array():array(); 

            return $result; 
 
  }
}

if(!function_exists('get_booking_date_between'))
{
  function get_booking_date_between(array $datarange,$status='')
  {
    $start_date = $datarange['start_date'];
    $end_date = $datarange['end_date'];
      $ci =& get_instance();
      $ci->load->database();
      $ci->db->select("b.id");
      $ci->db->from('z_booking as b'); 
 
       $ci->db->where( " ( b.delivery_date  >='".$start_date."' AND b.delivery_date  <='".$end_date."')");

      if($status !=='')
      {
        $ci->db->where( "b.booking_status",'delivered');      
      }else
      {
        $ci->db->where( "b.booking_status !=",'delivered');      
      }
 
      $query = $ci->db->get(); 
      $result = ($query->num_rows() > 0)?$query->num_rows():0; 

              return $result; 
   
  }
}
if(!function_exists('to_be_deliver')){
  function to_be_deliver($route_id,$city_id,$start_date,$end_date,$status)
  {

    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select("b.id");
    $ci->db->from('z_booking as b'); 
    $ci->db->join('z_village_pin as vil', 'vil.pincode = b.pincode', 'left');

    $ci->db->where("vil.city_id", $city_id);
    $ci->db->where( " ( b.delivery_date  >='".$start_date."' AND b.delivery_date  <='".$end_date."')");

    if($status !=='')
    {
      $ci->db->where( "b.booking_status",'delivered');      
    }else
    {
      $ci->db->where( "b.booking_status !=",'delivered');      
    }


    $query = $ci->db->get(); 
    $result = ($query->num_rows() > 0)?$query->result_array():array(); 

            return $result; 
 
  }
}
if(!function_exists('get_employees_att_check_inOutBydate')){
  function get_employees_att_check_inOutBydate($att_date,$user_id)
  {

      $ci =& get_instance();
      $ci->load->database();

      $ci->db->select('c.*');
      $ci->db->from('z_attendance_history as c'); 

 
      $ci->db->where('c.att_date',$att_date); 
      $ci->db->where('c.user_id',$user_id); 
       
      $ci->db->order_by('c.time','DESC'); 

                $query = $ci->db->get();
                return $result = $query->result_array();
  }
}

if( !function_exists('menu_list_without_auth'))
{
  function menu_list_without_auth($parent_id = 0)
{
            $ci =& get_instance();
            $ci->load->database();
   
   
            $ci->db->select('module.id,module.module_name');
            $ci->db->from('z_module_m as module  '); 
 
             
                $ci->db->where('module.parent_id',$parent_id);    
             
            $ci->db->order_by('module.orders_with','ASC'); 

                $query = $ci->db->get();
                return $result = $query->result_array();
}
}
if( !function_exists('check_module_role'))
{
  function check_module_role($module_id,$role_id)
{
            $ci =& get_instance();
            $ci->load->database();
   
   
            $ci->db->select('module_role.id,module_role.action_required');
            $ci->db->from('z_module_role as module_role  ');
            $ci->db->where('module_role.module_id',$module_id);    
            $ci->db->where('module_role.role_id',$role_id);    
            $ci->db->where('module_role.status',1);    
             
                $query = $ci->db->get();
                return $result = $query->result_array();
}
}

if( !function_exists('get_module_byurl'))
{
  function get_module_byurl($url)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('module.id ');
    $ci->db->from('z_module_m as module');
    $ci->db->where('module.module_url',$url);    
    $ci->db->where('module.status',1);    

    $query = $ci->db->get();
    $result = $query->result_array();
    if(!empty($result ))
    {
      return $result[0];
    }else{
      return array();
    }
}
}
 
if( !function_exists('get_module_role'))
{
  function get_module_role($module_id,$role_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('module_role.action_required ');
    $ci->db->from('z_module_role as module_role');
    $ci->db->where('module_role.module_id',$module_id);    
    $ci->db->where('module_role.role_id',$role_id);    
    $ci->db->where('module_role.status',1);    

    $query = $ci->db->get();
    $result = $query->result_array();
    if(!empty($result ))
    {
      return json_decode($result[0]['action_required']);
    }else{
      return json_decode('[]');
    }
}
}

  

if(!function_exists('getdistance'))
{
  function getdistance($lat1, $lon1, $lat2, $lon2, $unit='K') {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}
}



?>