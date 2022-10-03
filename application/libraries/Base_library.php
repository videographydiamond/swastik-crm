<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Chamiel
 * @project		Chamiel
 * @author		Subhash Mamgai
 * @copyright	Copyright (c) 2013 - 2014, Subhash
 * @license		http://www.chamiel.com/contactus.html
 * @link		http://www.chamiel.com
 * 
 */

class Base_library  {
	
   

    

    public function onload() { 
        $CI = get_instance();
        $l_data = array();
        $CI->load->library('base_library');
        $CI->load->model('admin/wishlist_model');
        $where = array();
        $where['status'] = '1'; 
        $where['field'] = 'id,name,image'; 
        $db_data = $CI->category_model->findDynamic($where);
        foreach($db_data as $k=>$v)
        {
            if($v->id < 4)
                $l_data['menu_service'][$v->id] =  $v->name;  
            else
                $l_data['menu_system'][$v->id] =  $v->name;
            $l_data['category'][$v->id]['name']  =$v->name;           
            $l_data['category'][$v->id]['image']  =$v->image;           
        } 

        // Cart Details
        // add to card session
        $l_data['cart'] = $session_data = $CI->session->userdata('cart_to_cart');
        if(!empty($l_data['cart']))
        {
            $l_data['cart_data'] = $CI->product_model->cart_product($l_data['cart']);
            $l_data['no_cart'] = count($l_data['cart_data']); 
        }
        
        // Wish List
        $l_data['user_id'] = $CI->session->userdata('userId');
        $CI->load->helper('cookie');
        $get_cookie = get_cookie('whishlist');
            
        if(!empty($get_cookie))
        {   
            $temp_wishlist = explode(',', $get_cookie);
            $product_list = array();
            foreach($temp_wishlist as $k=>$v)
            {

                $l_data['wish_product'][$v] = $v;
                $product_list[] = $v;
            }



            $l_data['wishlist']= $CI->wishlist_model->wishlist($product_list);
        }

        //print_r($l_data['wishlist']);exit;

        /*$l_data['user_id'] = $CI->session->userdata('userId');
        if(!empty($l_data['user_id']))
        {
            


            


            // $where = array();
            // $l_data['wishlist']= $CI->wishlist_model->wishlist($l_data['user_id']);
            // if(!empty($l_data['wishlist']))
            // {
            //     foreach($l_data['wishlist'] as $k=>$v)
            //     {
            //         $l_data['wish_product'][$v->id] = $v->id;
            //     }
            // }
        }*/


       return  $l_data;  
    }



    public function page_content() { 
        $CI = get_instance();
        $l_data = array();
        $CI->load->library('base_library');

        $controller = $CI->uri->segment(1);
        if($CI->uri->segment(2))
        {
            $page_url = $CI->uri->segment(2);
        }
        else
        {
            $page_url = $controller;
        }

        $where = array();
        $where['page_url'] = $page_url;
        $where['status'] = '1';
        $where['table'] = 'z_content';
        $db_data = $CI->category_model->findDynamic($where);
        
        return  $db_data;  
    }






  

}

 
