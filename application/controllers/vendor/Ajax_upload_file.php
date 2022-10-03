<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.

 * @since : 15 November 2016
 */
class Ajax_upload_file extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
         $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->database();
    }
	 
  public function multipleImageStore()
  {
  
     
	  $countfiles = count($_FILES['files']['name']);
	    
   
  $emptyName = array();
      for($i=0;$i<$countfiles;$i++){
  
        if(!empty($_FILES['files']['name'][$i])){
        
		 
					$f_name         =$_FILES['files']['name'][$i];
					$f_tmp          =$_FILES['files']['tmp_name'][$i];
					$f_size         =$_FILES['files']['size'][$i];
					$f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="./uploads/property/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'thumb Upload Failed .');
                    }
                    else
                    {
                      $emptyName[] = $f_newfile;
                       
                    }
		}
  
      }
      echo json_encode($emptyName);
  
  }

   public function multipleImagePlanStore()
  {
  
     
    $countfiles = count($_FILES['files']['name']);
      
   
  $emptyName = array();
      for($i=0;$i<$countfiles;$i++){
  
        if(!empty($_FILES['files']['name'][$i])){
        
     
          $f_name         =$_FILES['files']['name'][$i];
          $f_tmp          =$_FILES['files']['tmp_name'][$i];
          $f_size         =$_FILES['files']['size'][$i];
          $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="./uploads/propertyplans/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'thumb Upload Failed .');
                    }
                    else
                    {
                      $emptyName[] = $f_newfile;
                       
                    }
    }
  
      }
      echo json_encode($emptyName);
  
  }
    


    public function multipleDocsStore()
  {
  
     
    $countfiles = count($_FILES['files']['name']);
      
   
  $emptyName = array();
      for($i=0;$i<$countfiles;$i++){
  
        if(!empty($_FILES['files']['name'][$i])){
        
     
          $f_name         =$_FILES['files']['name'][$i];
          $f_tmp          =$_FILES['files']['tmp_name'][$i];
          $f_size         =$_FILES['files']['size'][$i];
          $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="./uploads/propertydocs/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'thumb Upload Failed .');
                    }
                    else
                    {
                      $emptyName[] = $f_newfile;
                       
                    }
    }
  
      }
      echo json_encode($emptyName);
  
  }


  // upload staff thumbnail
    public function staff_upload_thumbnail()
  {
  
     
       
 
      $emptyName ='';
  
        if(!empty($_FILES['files']['name'][0])){
        
     
          $f_name         =$_FILES['files']['name'][0];
          $f_tmp          =$_FILES['files']['tmp_name'][0];
          $f_size         =$_FILES['files']['size'][0];
          $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="./uploads/agency/staff/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'thumb Upload Failed .');
                    }
                    else
                    {
                      $emptyName = $f_newfile;
                       
                    }
    }
  
     
      echo json_encode($emptyName);
  
  }

  // upload image for watermark images
   public function watermark_upload_stamp()
  {
    
    // stamp image
    $watermarkImagePath = 'codexworld-logo.png'; 
    // main image
    $targetDir = "./uploads/agency/watermark/main.jpg"; 
    if(!empty($_FILES["files"]["name"][0]))
    {
        // File upload path 
        $fileName = basename($_FILES["files"]["name"][0]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg'); 
        if(in_array($fileType, $allowTypes)){ 
            // Upload file to the server 
            if(move_uploaded_file($_FILES["files"]["tmp_name"][0], $targetFilePath))
            {
                // Load the stamp and the photo to apply the watermark to 
                $watermarkImg = imagecreatefrompng($watermarkImagePath); 
                switch($fileType){ 
                    case 'jpg': 
                        $im = imagecreatefromjpeg($targetFilePath); 
                        break; 
                    case 'jpeg': 
                        $im = imagecreatefromjpeg($targetFilePath); 
                        break; 
                    case 'png': 
                        $im = imagecreatefrompng($targetFilePath); 
                        break; 
                    default: 
                        $im = imagecreatefromjpeg($targetFilePath); 
                } 
                 
                // Set the margins for the watermark 
                $marge_right = 10; 
                $marge_bottom = 10; 
                 
                // Get the height/width of the watermark image 
                $sx = imagesx($watermarkImg); 
                $sy = imagesy($watermarkImg); 
                 
                // Copy the watermark image onto our photo using the margin offsets and  
                // the photo width to calculate the positioning of the watermark. 
                imagecopy($im, $watermarkImg, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($watermarkImg), imagesy($watermarkImg)); 
                 
                // Save image and free memory 
                imagepng($im, $targetFilePath); 
                imagedestroy($im); 
     
                if(file_exists($targetFilePath))
                {
                    $statusMsg = "The image with watermark has been uploaded successfully.";
                    $response = array(
                    'status' => 'success',
                    'message' =>  $statusMsg
                  );
                }else{
                    $statusMsg = "Image upload failed, please try again.";
                    $response = array(
                    'status' => 'error',
                    'message' =>  $statusMsg
                  );
                }  
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file.";
                $response = array(
                'status' => 'error',
                'message' =>  $statusMsg
              );
            } 
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, and PNG files are allowed to upload.';
            $response = array(
            'status' => 'error',
            'message' =>  $statusMsg
          );
        } 
    }else{ 
        $statusMsg = 'Please select a file to upload.';

        $response = array(
        'status' => 'error',
        'message' =>  $statusMsg
      );
         
    }
      echo json_encode($response);
    }

//setting alginment
   public function watermark_setting_stamp()
  {
  
        $this->load->library('image_lib');
        $form_data  = $this->input->post();
         
        $range      = $form_data['range'];
        $position   = $form_data['water_position'];
        $emptyName = "main_thumb.jpg";
        $watermarkName   = $form_data['watermarkName'];
        $alignment = explode("_$",$position);


        

        // upload water mark start 
        $config['image_library'] = 'gd2';
        $config['source_image'] = "./uploads/agency/watermark/main.jpg";
        $config['wm_type'] = 'overlay';
        $config['wm_overlay_path'] = "./uploads/agency/watermark/".$watermarkName;  
        $config['wm_opacity'] = $range;
        $config['create_thumb'] = TRUE;

        
        $config['width'] = '80';
        $config['height'] = '80';
        
         
        $config['wm_vrt_alignment'] = $alignment[1];
        $config['wm_hor_alignment'] = $alignment[0];
        /*$config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'center';*/
              $this->image_lib->initialize($config);
              
              if (!$this->image_lib->watermark()) {
              echo $this->image_lib->display_errors();
              }
			  $imzbd  = "<img src='".base_url()."uploads/agency/watermark/".$emptyName."'  id='main_image'  name='main_image' width='315' height='200'>";  
			  echo json_encode($imzbd);
			 
          //echo "<img src='".base_url()."uploads/agency/watermark/"' id="main_image"  name="main_image" width="315" height="200">";
  
  }
  
  // upload company profile logo
    public function company_profile_logo()
  {
 
      $emptyName ='';
  
        if(!empty($_FILES['files']['name'][0])){
        
     
          $f_name         =$_FILES['files']['name'][0];
          $f_tmp          =$_FILES['files']['tmp_name'][0];
          $f_size         =$_FILES['files']['size'][0];
          $f_extension    =explode('.',$f_name);
                    $f_extension    =strtolower(end($f_extension));
                    $f_newfile      =uniqid().'.'.$f_extension;
                    $store          ="./uploads/agency/company_profile/".$f_newfile;
                
                    if(!move_uploaded_file($f_tmp,$store))
                    {
                        $this->session->set_flashdata('error', 'Logo Upload Failed .');
                    }
                    else
                    {
                      $emptyName = $f_newfile;
                       
                    }
    }
  
     
      echo json_encode($emptyName);
  
  }

    
}

?>