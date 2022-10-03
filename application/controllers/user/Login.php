<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login (LoginController)
 * Login class to control to authenticate user credentials and starts user's session.

 * @since : 15 November 2016
 */
class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/login_model');
        $this->load->model('admin/user_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        
        $this->isUserLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isUserLoggedIn()
    {

        $isUserLoggedIn = $this->session->userdata('isUserLoggedIn');

        if(!isset($isUserLoggedIn) || $isUserLoggedIn != TRUE)
        {
            $this->load->view('user/login');
        }
        else
        {

            redirect(base_url().'user/dashboard');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
       
       $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');

      if($this->form_validation->run() == FALSE)
        {
           $this->index();
        }
        else
        {

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $where = array();
            $where['email'] = $email;
            $where['type'] = 1;
            $where['password'] = md5($password);
             
            $where['status'] = "1";
            $result = $this->user_model->findDynamic($where);
			if(count($result) > 0)
            {
                foreach ($result as $res)
                {
                    $sessionArray = array(  'userId'=>$res->id,                   
                                            'role'=> "user",//$res->type,
                                            'email'=>$res->email,
                                            'phone'=>$res->phone,
                                            'fname'=>$res->fname,
                                            'name'=>$res->fname." ".$res->lname,
                                            'isUserLoggedIn' => TRUE
                                    );
                                    
                    $this->session->set_userdata($sessionArray);
                    
                   redirect(base_url().'user/dashboard');
                }
            }
            else	
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                
                redirect(base_url().'/user/login');
             }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $this->load->view('user/forgotpassword');
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->input->post('login_email');

            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
             
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "user/login/resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    }
                    
                    $sendStatus = resetPasswordEmail($data1);
                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('user/login/forgotPassword');
        }
    }

    // This function used to reset the password 
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('user/login');
        }
    }
    
    // This function used to create new password
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);
                
                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password changed failed';
            }
            
            setFlashData($status, $message);

            redirect("user/login");
        }
    }

    function logout()
    {
        $data = array(
                    'userId' => false,
                    'role' => false,
                    'email' => false,
                    'phone' => false,
                    'fname' => false,
                    'name' => false,
                    'isUserLoggedIn' => false
                     
                );

         


        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
       redirect(base_url("user/login"));
    }
}

?>