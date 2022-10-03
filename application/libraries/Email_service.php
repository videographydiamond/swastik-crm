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



class Email_Service  {

	

    private $from;

    private $config;

    private $head;

    public $CI;

    

    private $SMTP_HOST;

    private $SMTP_PORT;

    private $SMTP_USER_NAME;

    private $SMTP_PASSWORD;

    public $IS_SMTP_ACTIVE = true;





    public function __construct() {



        $this->CI = & get_instance();

        if($this->CI->config->item('SMTP_ACTIVE') != 'YES' || $this->CI->config->item('SMTP_MODE') != 'LIVE') {

            $this->IS_SMTP_ACTIVE = false;

            return false;

        }        

        

        $this->CI->load->model('admin/email_template_model');

        $this->SMTP_HOST = $this->CI->config->item('SMTP_HOST');

        $this->SMTP_PORT = $this->CI->config->item('SMTP_PORT');

        $this->SMTP_USER_NAME = $this->CI->config->item('SMTP_USER_NAME');

        $this->SMTP_PASSWORD = $this->CI->config->item('SMTP_PASSWORD');

        $this->head = 'Ale-izba';

        $this->from = 'sapphireinfo@gmail.com';

        $this->regards = 'Hq Team';

        

        $this->config = Array(

        'protocol' => 'smtp',				 

        'smtp_host' => $this->SMTP_HOST,

        'smtp_port' => $this->SMTP_PORT,				 

        'smtp_user' => $this->SMTP_USER_NAME,

        'smtp_pass' => $this->SMTP_PASSWORD,				 

        'charset' => 'utf-8',

        'wordwrap' => TRUE,

        'mailtype' => 'html',	

        'crlf' => "\r\n",

        'newline' => "\r\n");



    }



    



    public function send($to, $subject, $message) { 



    	

	$this->CI->load->library('email');

       $this->CI->email->initialize($this->config);

        

        $this->CI->email->from($this->from, $this->head);

        

        //$this->CI->email->set_newline("\r\n");

        $this->CI->email->to($to);        

        $this->CI->email->subject($subject);

        $this->CI->email->message($message);

        //$this->email->set_mailtype("html");

        $this->CI->email->send();

	//echo $this->CI->email->print_debugger();die;

        

    }







    // Email send ********************************************

    

    public function email_send($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

           $data = $data['detail'];

           

           

            $attachment = (isset($data['email_attachment']))?"<br/> <br/> attachment File <br/><a href='".base_url()."uploads/mail_attachment/".$data['email_attachment']."'> Download attachment </a>":'';

            $contant    = $data['email_message'].$attachment;

            $email_to   = $data['email_to'];

            $subject    = $data['email_subject'];



            $this->send($email_to,$subject,$contant);   

            return true;

        } else {

            return false;

        }

    } 



    // Cutomer Registration Mail SEND Cutomer ********************************************

    

     // Cutomer Registration Mail SEND Cutomer ********************************************

    

    public function send_register_cutomer_email($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

           

           

            

                $attachment = "Mr ".$data['firstname']." ,<br/><br/> &nbsp;&nbsp;&nbsp; Succeessfully Registraion Complete.<br/><br/>";

                $attachment .= "Your Login Details is ".'<br/><br/>';

                $attachment .= "Email Id : ".$data['email'].'<br/><br/>';

                $attachment .= "Password : ".$data['password'].'<br/><br/>';

                //$attachment .= "Phone : ".$data['phone'].'<br/><br/>';

                $attachment .= 'Date : "'.date("d-m-Y H:i:s")."<br/><br/>";

                $attachment .= 'Thanks & Regards<br/>';

                $attachment .= 'Hq';

                $contant    = $attachment;

                $subject    = " Sapphire Softech Solutions Solution Registraion Succeessfully Done.";

           

                $email_to   = $data['email'];   

                $return = $this->send($email_to,$subject,$contant);   

            

            return true;

        } else {

            return false;

        }

    }



    // New Registration Send Admin Mail ***********************************

    public function send_register_admin_email($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

           

            $subject = "New Cutomer Registered. ";

            

            $contant = "Hi Admin ,<br/><br/> &nbsp;&nbsp;&nbsp; New Cutomer Registration Succeessfully Complete<br/><br/>";

            $contant .= "Cutomer Name :".$data['firstname']." ".$data['lastname']."<br/><br/>";

            $contant .= "Cutomer Email :".$data['email']."<br/><br/>";

            $contant .= "Registration Date :".date("d-m-Y")."<br/><br/>";

            $contant .= 'Thanks & Regards<br/>';

            $email_to   = $data['admin_email'];   

        

            $this->send($email_to,$subject,$contant);   

            return true;

        } else {

            return false;

        }

    }



     // User Forgot password Send Detials ********************************************

    

    public function send_forgot_password_email($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

           $this->CI = & get_instance();

           $template = $this->CI->email_template_model->find(9);

           

            if(!empty($template))

            {

                $subject = $template->subject;

                $message = $template->message; 

                $message = str_replace('##NAME##',$data['name'],$message);

                $message = str_replace('##RESETLINK##',$data['reset_link'],$message);

                $message = str_replace('##DATE##',date("d-m-Y H:i"),$message);

                $contant = $message;

             }

             else

             { 

                $attachment = "Mr ".$data['name']." ,<br/><br/> &nbsp;&nbsp;&nbsp; For Reset Your Password Click Link <br/><br/>";

                $attachment .= $data['reset_link'].'<br/><br/>';

                $attachment .= 'Date : "'.date("d-m-Y H:i:s")."<br/><br/>";

                $attachment .= 'Thanks & Regards<br/>';

                $attachment .= 'Zeno Strategics';

                $contant    = $attachment;

                $subject    = $data['message'];

            }   

            $email_to   = $data['email']; 



            $this->send($email_to,$subject,$contant);   

            return true;

        } else {

            return false;

        }

    } 







    // Contact Us Inquiry Mail send Admin ********************************************

    

    public function send_contact_inquiry_admin_email($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

           $this->CI = & get_instance();

           $template = $this->CI->email_template_model->find(12);

           

            if(!empty($template))

            {

                $subject = $template->subject;

                $message = $template->message; 

                $message = str_replace('##NAME##',$data['name'],$message);

                $message = str_replace('##PHONE##',$data['phone'],$message);

                $message = str_replace('##EMAIL##',$data['email'],$message);

                $message = str_replace('##MESSAGE##',$data['message'],$message);

                $message = str_replace('##DATE##',date("d-m-Y H:i"),$message);

                $contant = $message;

             }

             else

             { 

                $attachment = "Hi Admin ,<br/><br/> &nbsp;&nbsp;&nbsp; Getting New Contact Us Inquiry <br/><br/>";

                $attachment .= "Name : ".$data['name'].'<br/><br/>';

                $attachment .= "Email : ".$data['email'].'<br/><br/>';

                $attachment .= "Phone : ".$data['phone'].'<br/><br/>';

                $attachment .= "Message : ".$data['message'].'<br/><br/>';

                $attachment .= 'Date : "'.date("d-m-Y H:i")."<br/><br/>";

                $attachment .= 'Thanks & Regards<br/>';

                $attachment .= 'Zeno Strategics';

                $contant    = $attachment;

                $subject    = "Contact Us Inquiry .";

            }   

            $email_to   = $data['admin_email']; 



            $this->send($email_to,$subject,$contant);   

            return true;

        } else {

            return false;

        }

    } 









    // Get Touch Inquiery mail ********************************************

    

    public function send_get_touch_inquiery_admin_email($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

           $this->CI = & get_instance();

           $template = $this->CI->email_template_model->find(13);

           

            if(!empty($template))

            {

                $subject = $template->subject;

                $message = $template->message; 

                $message = str_replace('##NAME##',$data['get_tuch_user'],$message);

                $message = str_replace('##PHONE##',$data['get_tuch_number'],$message);

                $message = str_replace('##EMAIL##',$data['get_tuch_email'],$message);

                $message = str_replace('##DATE##',date("d-m-Y H:i"),$message);

                $contant = $message;

             }

             else

             { 

                $subject = "Getting New Customer GetTuch Inquiry.";

                $message = "Hello Admin ,<br/><br/>&nbsp;&nbsp;&nbsp; Getting a new Cutomer GetTuch Inquiry.<br/>";



                $message .= "Name : ".$data['get_tuch_user']."<br/>";

                $message .= "Phone : ".$data['get_tuch_number']."<br/>";

                $message .= "Email : ".$data['get_tuch_email']."<br/><br/>";

                $message .= "Date : ".date("d-m-Y H:i")."<br/>";

                $contant = $message;  

              } 

                 

              $email_to   = $data['admin_email'];

             



            $this->send($email_to,$subject,$contant);   

            return true;

        } else {

            return false;

        }

    } 









    // FAQS Mail send to Admin ********************************************

    

    public function send_faq_admin_email($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

           $this->CI = & get_instance();

           $template = '';//$this->CI->email_template_model->find(13);

           

            if(!empty($template))

            {

                $subject = $template->subject;

                $message = $template->message; 

                $message = str_replace('##NAME##',$data['name'],$message);

                $message = str_replace('##EMAIL##',$data['email'],$message);

                $message = str_replace('##QUESTION##',$data['question'],$message);

                $message = str_replace('##DATE##',date("d-m-Y H:i"),$message);

                $contant = $message;

             }

             else

             { 

                $subject = "Zenostrategics Customer FAQS Query . ";

                $message = "Hello Admin ,<br/><br/>&nbsp;&nbsp;&nbsp; Getting a new FAQS Query.<br/><br/>";



                $message .= "Name : ".$data['name']."<br/>";

                $message .= "Email : ".$data['email']."<br/><br/>";

                $message .= "Question : ".$data['question']."<br/><br/>";

                $message .= "Date : ".date("d-m-Y H:i")."<br/>";

                $contant = $message;  

              } 

                 

              $email_to   = $data['admin_email'];

             



            $this->send($email_to,$subject,$contant);   

            return true;

        } else {

            return false;

        }

    } 



    // Email Send Cutomer When Order Payment successfully done ********************************************

    

    public function send_mail_customer_payment_success($data) {

        if($this->IS_SMTP_ACTIVE) {

           $this->CI = & get_instance();

            $template = $this->CI->email_template_model->find(1);

            $order = $data['order_details'];

            $originalDate = $order->payment_date;

            $payment_date = date("d-m-Y H:i:s", strtotime($originalDate));

            

            if(!empty($template))

            {

                $subject = $template->subject;

                $message = $template->message; 

                $message = str_replace('##NAME##',$order->customer_or_business_name,$message);

                $message = str_replace('##PROPERTY##',$data['property_name'],$message);

                $message = str_replace('##TRANSACTION##',$order->transaction_id,$message);

                $message = str_replace('##PAYMENT##',$order->payment_amount,$message);

                $message = str_replace('##TAX##',$order->tax,$message);

                $message = str_replace('##TOTALPAYMENT##',$order->total_payment,$message);

                $message = str_replace('##DATE##',$payment_date,$message);

            }

            else

            {

                $subject = "Order Payment Successfully Done .";

                $message = "Hello ". $order->customer_or_business_name.",<br/>". $data['property_name']. "Order payment Successfully Done .";

            }  

            $contant = $message;

            $this->send($order->email,$subject,$contant);   

            return true;

        } else {

            return false;

        }

    }



}



 

