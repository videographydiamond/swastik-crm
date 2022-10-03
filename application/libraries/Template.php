<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
    class Template 
    {
        var $ci;
         
        function __construct() 
        {
            $this->ci =& get_instance();
        }
    



    function load($tpl_view, $body_view = null, $data = null) 
	{   
	    if ( ! is_null( $body_view ) ) 
	    {  //echo APPPATH.'views/front/'.$body_view;die;
	        if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view ) ) 
	        { 
	            $body_view_path =$tpl_view.'/'.$body_view;
	        }
	        else if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view.'.php' ) ) 
	        {
	            $body_view_path = $tpl_view.'/'.$body_view.'.php';
	        }
	        else if ( file_exists( APPPATH.'views/front/'.$body_view ) ) 
	        {   
	            $body_view_path = "front/".$body_view;
	        }
	        else if ( file_exists( APPPATH.'views/front/'.$body_view.'.php' ) ) 
	        {  
	            $body_view_path = "front/".$body_view.'.php';
	        }
	        else
	        {   
	            show_error('Unable to load the requested file: ' . $tpl_name
	            .'/'.$view_name.'.php');
	        }
	         
	        $body = $this->ci->load->view($body_view_path, $data, TRUE);
	         
	        if ( is_null($data) ) 
	        {
	            $data = array('body' => $body);
	        }
	        else if ( is_array($data) )
	        {
	            $data['body'] = $body;
	        }
	        else if ( is_object($data) )
	        {
	            $data->body = $body;
	        }
	    }
	     
	    $this->ci->load->view('front/templates/'.$tpl_view, $data);
	}


	function elements($body_view = null, $data = null) 
	{	 
		$tpl_view ="elements";			 
	    if ( ! is_null( $body_view ) ) 
	    {
	        if ( file_exists( APPPATH.'views/front/'.$tpl_view.'/'.$body_view ) ) 
	        {
	            $body_view_path = "front/".$tpl_view.'/'.$body_view;
	        }
	        else if ( file_exists( APPPATH.'views/front/'.$tpl_view.'/'.$body_view.'.php' ) ) 
	        {
	            $body_view_path = "front/".$tpl_view.'/'.$body_view.'.php';
	        }
	        else if ( file_exists( APPPATH.'views/front/'.$body_view ) ) 
	        {
	            $body_view_path = "front/".$body_view;
	        }
	        else if ( file_exists( APPPATH.'views/fornt/'.$body_view.'.php' ) ) 
	        {
	            $body_view_path = "front/".$body_view.'.php';
	        }
	        else
	        {   
	            show_error('Unable to load the requested file: ' . $tpl_name.'/'.$view_name.'.php');
	        }
	         
	        $body = $this->ci->load->view($body_view_path, $data, TRUE);
	         
	        if ( is_null($data) ) 
	        {
	            $data = array('body' => $body);
	        }
	        else if ( is_array($data) )
	        {
	            $data['body'] = $body;
	        }
	        else if ( is_object($data) )
	        {
	            $data->body = $body;
	        }
	    }
	     
	    $this->ci->load->view('front/elements/'.$body_view, $data);
	}

}


?>