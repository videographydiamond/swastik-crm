<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Property2 extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('admin/property2_model');
        $this->load->model('admin/type_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/feature2_model');
        $this->load->model('admin/extra_info_model');
        $this->load->model('admin/portal_model');
        $this->load->model('admin/video_model');
        $this->load->model('admin/property_img_model');
        $this->load->model('admin/landlord_model');
    }

    
    public function index()
    {
        $this->isVendorLoggedIn();

        $data = array();

       
         
        $data['get_property_list'] =  $this->property2_model->get_property_list();
 


        $this->global['pageTitle'] = 'Property2 : Ale-izba';

        $this->vendorView("vendor/property2/list", $this->global, $data , NULL);
        
    }

    // Add New 
    public function addnew()
    {
    
        $this->isVendorLoggedIn();
        $data = array();
        
        $where  = array();
        $where['table']  = 'rc_rel_agent';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agentList'] = $this->property2_model->findDynamic($where);

        

        $where  = array();
        $where['table']  = 'rc_rel_agency';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agencyList'] = $this->property2_model->findDynamic($where);


        $where  = array();
        $where['table']  = 'users';
        $where['status']  = '1';
        $where['type']  = '2';
        $where['field']  = 'id,fname';
        $data['userLists'] = $this->user_model->findDynamic($where);


        $where  = array();
        $where['table']  = 'rc_rel_type';
        $where['status']  = '1';
         
        $where['field']  = 'id,name';
        $data['propertyTypeLists'] = $this->type_model->findDynamic($where);

        // Assign list array ======================================
        $data['TypeList']  = $this->type_model->getTypeList();
        $data['EmirateList']  = $this->type_model->getEmirateList();
        $data['CommunityList']  = $this->type_model->getCommunityList();
        $data['SubLocationList']  = $this->type_model->getSubLocationList();
        $data['listFrequency']  = $this->type_model->listFrequency();
        $data['listFeatureStatus']  = $this->type_model->listFeatureStatus();
        $data['CountNumberList']  = $this->type_model->getCountNumberList();
        $data['DeveloperList']  = $this->type_model->getDeveloperList();
        $data['listCheques']  = $this->type_model->listCheques();
        $data['listFurnissing']  = $this->type_model->listFurnissing();
        $data['listLsm']  = $this->type_model->listLsm();
        $data['listTypeOfContact']  = $this->type_model->listTypeOfContact();
        $data['listNationality']  = $this->type_model->listNationality();
        $data['listSecure']  = $this->type_model->listSecure();
        $data['listAssignTo']  = $this->type_model->listAssignTo();
        $data['listPropertyStatus']  = $this->type_model->listPropertyStatus();
        //Recreation and Family
        $data['RecreationAndFamily']  = $this->type_model->RecreationAndFamily();
        //Health and Fitness
        $data['HealthAndFitness']  = $this->type_model->HealthAndFitness();
        //Laundry and Kitchen
        $data['LaundryAndKitchen']  = $this->type_model->LaundryAndKitchen();
        //Building
        $data['BuildingList']  = $this->type_model->BuildingList();
        $data['FlooringList']  = $this->type_model->FlooringList();
        //Business and Security
        $data['BusinessAndSecurity']  = $this->type_model->BusinessAndSecurity();
        //Miscellaneous
        $data['MiscellaneousList']  = $this->type_model->MiscellaneousList();
        $data['PetPolicyList']  = $this->type_model->PetPolicy();
        //Technology
        $data['TechnologyList']  = $this->type_model->TechnologyList();
        //Features
        $data['FeaturesList']  = $this->type_model->FeaturesList();
        //Cleaning and Maintenance
        $data['CleaningAndMaintenanceList']  = $this->type_model->CleaningAndMaintenanceList();
         //Video Host List
        $data['VideoHostList']  = $this->type_model->VideoHostList();
         //Portals List
        $data['PortalsList']  = $this->type_model->PortalsList();


         //SalutaionList 
        $data['SalutaionList']  = $this->type_model->SalutaionList();

         //PurooseList 
        $data['PurposeList']  = $this->type_model->PurposeList();
         

         //RoleList 
        $data['RoleList']  = $this->type_model->RoleList();


        $this->global['pageTitle'] = 'Add New Property2 : Ale-izba';

        $this->vendorView("vendor/property2/addnew", $this->global, $data , NULL);
        
    } 




//Edit New Property

public function editnew($id= null)
    {
        $data = array();
        if($id == null)
        {
            redirect('vendor/property2');
        }
    
       
        $data['PropertyData'] = $this->property2_model->find($id);
         if(empty($data['PropertyData']))
        {
            redirect('vendor/property2');
        }
        $this->isVendorLoggedIn();

        
        
        $where  = array();
        $where['table']  = 'rc_rel_agent';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agentList'] = $this->property2_model->findDynamic($where);


        $where  = array();
        
       

        $where  = array();
        $where['table']  = 'property_feature';
        $where['property_id']  = $id;
        $FeaturesData = $this->property2_model->findDynamic($where);
        $data['FeaturesData'] = $FeaturesData[0];

         $where  = array();
        $where['table']  = 'property_extra_info';
        $where['property_id']  = $id;
        $ExtraInfoData = $this->property2_model->findDynamic($where);
        $data['ExtraInfoData'] = $ExtraInfoData[0];

         $where  = array();
        $where['table']  = 'property_portal';
        $where['property_id']  = $id;
        $portalData = $this->property2_model->findDynamic($where);
        $data['portalData'] = $portalData[0];

        // Fetch Property wise images
        $PropertyImagesData = $this->property_img_model->get_property_images($id);
        $data['PropertyImagesData']  = $PropertyImagesData[0];
   


        // Fetch Property wise floor Plan
        $PropertyVideoData = $this->video_model->get_property_video($id);
        $data['PropertyVideoData']  = $PropertyVideoData[0];

        // Fetch Property wise images
        $PropertyPlansData = $this->property_img_model->get_property_plans($id);
         $data['PropertyPlansData'] = $PropertyPlansData[0];

        // Fetch Property wise Document
       
        $PropertyDocsData = $this->property_img_model->get_property_docs($id);
        $data['PropertyDocsData'] = $PropertyDocsData[0];

        // Fetch Property wise Land Lord
       
        $PropertyLandlordData = $this->landlord_model->get_property_landlord($id);
        $data['PropertyLandlordData'] = $PropertyLandlordData[0];
        


        $where  = array();
        $where['table']  = 'users';
        $where['status']  = '1';
        $where['type']  = '2';
        $where['field']  = 'id,fname';
        $data['userLists'] = $this->user_model->findDynamic($where);


        $where  = array();
        $where['table']  = 'rc_rel_type';
        $where['status']  = '1';
         
        $where['field']  = 'id,name';
        $data['propertyTypeLists'] = $this->type_model->findDynamic($where);

        // Assign list array ======================================
        $data['TypeList']  = $this->type_model->getTypeList();
        $data['EmirateList']  = $this->type_model->getEmirateList();
        $data['CommunityList']  = $this->type_model->getCommunityList();
        $data['SubLocationList']  = $this->type_model->getSubLocationList();
        $data['listFrequency']  = $this->type_model->listFrequency();
        $data['listFeatureStatus']  = $this->type_model->listFeatureStatus();
        $data['CountNumberList']  = $this->type_model->getCountNumberList();
        $data['DeveloperList']  = $this->type_model->getDeveloperList();
        $data['listCheques']  = $this->type_model->listCheques();
        $data['listFurnissing']  = $this->type_model->listFurnissing();
        $data['listLsm']  = $this->type_model->listLsm();
        $data['listTypeOfContact']  = $this->type_model->listTypeOfContact();
        $data['listNationality']  = $this->type_model->listNationality();
        $data['listSecure']  = $this->type_model->listSecure();
        $data['listAssignTo']  = $this->type_model->listAssignTo();
        $data['listPropertyStatus']  = $this->type_model->listPropertyStatus();
        //Recreation and Family
        $data['RecreationAndFamily']  = $this->type_model->RecreationAndFamily();
        //Health and Fitness
        $data['HealthAndFitness']  = $this->type_model->HealthAndFitness();
        //Laundry and Kitchen
        $data['LaundryAndKitchen']  = $this->type_model->LaundryAndKitchen();
        //Building
        $data['BuildingList']  = $this->type_model->BuildingList();
        $data['FlooringList']  = $this->type_model->FlooringList();
        //Business and Security
        $data['BusinessAndSecurity']  = $this->type_model->BusinessAndSecurity();
        //Miscellaneous
        $data['MiscellaneousList']  = $this->type_model->MiscellaneousList();
        $data['PetPolicyList']  = $this->type_model->PetPolicy();
        //Technology
        $data['TechnologyList']  = $this->type_model->TechnologyList();
        //Features
        $data['FeaturesList']  = $this->type_model->FeaturesList();
        //Cleaning and Maintenance
        $data['CleaningAndMaintenanceList']  = $this->type_model->CleaningAndMaintenanceList();
         //Video Host List
        $data['VideoHostList']  = $this->type_model->VideoHostList();
         //Portals List
        $data['PortalsList']  = $this->type_model->PortalsList();

         //SalutaionList 
        $data['SalutaionList']  = $this->type_model->SalutaionList();

         //PurooseList 
        $data['PurposeList']  = $this->type_model->PurposeList();
         
         //RoleList 
        $data['RoleList']  = $this->type_model->RoleList();
         


        $this->global['pageTitle'] = 'Add New Property2 : Ale-izba';

        $this->vendorView("vendor/property2/editnew", $this->global, $data , NULL);
        
    } 

    // Insert  *************************************************************
    public function insertnow()
    {
        $form_data  = $this->input->post();
        
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
        //$this->form_validation->set_rules('EnTitle','EnTitle','trim|required');
        $this->form_validation->set_rules('type','Type','required');
        $this->form_validation->set_rules('emirate','Emirate','required');
        $this->form_validation->set_rules('community','Community','required');
        $this->form_validation->set_rules('rent','Rent','required');
        $this->form_validation->set_rules('developer','Developer','required');
        $this->form_validation->set_rules('area','Area','required');
        $this->form_validation->set_rules('assign_to','Assign To','required');


         // $this->form_validation->set_rules('name','name','trim|required');
        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            $this->addnew();
        }
        else
        {
            $insertData['type']         = $form_data['type'];
            $insertData['purpose']      = $form_data['purpose'];
            $insertData['location']     = $form_data['location'];
            $insertData['emirate']      = $form_data['emirate'];
            $insertData['community']    = $form_data['community'];
            $insertData['unit']         = $form_data['unit'];
            $insertData['unit_plot']    = $form_data['unit_plot'];
            $insertData['unit_street']  = $form_data['unit_street'];
            $insertData['views']        = $form_data['views'];
            $insertData['external_reference'] = $form_data['external_reference'];
            $insertData['rent']        = $form_data['rent'];
            $insertData['frequency']    = $form_data['frequency'];
            $insertData['annual_commission_percent'] = $form_data['annual_commission_percent'];
            $insertData['annual_commission_aed'] = $form_data['annual_commission_aed'];

            $insertData['FeatureStatus'] = (isset($form_data['FeatureStatus'])) ? json_encode($form_data['FeatureStatus'], true) : "";
            $insertData['beds']        = $form_data['beds'];
            
            $insertData['baths']    = $form_data['baths'];
            $insertData['parking']      = $form_data['parking'];
            $insertData['year_built']   = $form_data['year_built'];
            $insertData['developer']    = $form_data['developer'];
            $insertData['plot_area']    = $form_data['plot_area'];
            $insertData['area']    = $form_data['area'];
            $insertData['deposit_percent'] = $form_data['deposit_percent'];
            $insertData['deposit_aed']  = $form_data['deposit_aed'];
            $insertData['cheques']      = $form_data['cheques'];

            $insertData['EnTitle']         = $form_data['EnTitle'];
            $insertData['description']        = $form_data['description'];
            $insertData['ArTitle']   = $form_data['ArTitle'];
            $insertData['ArDescription']        = $form_data['ArDescription'];
            $insertData['lsm']          = $form_data['lsm'];
            $insertData['tansaction']   = $form_data['tansaction'];
            $insertData['permit']       = $form_data['permit'];
            $insertData['permit_expiry']= $form_data['permit_expiry'];
            $insertData['landlord']     = $form_data['landlord'];
            $insertData['rented']       = (isset($form_data['rented'])) ? $form_data['rented']: "";
            $insertData['source']       = $form_data['source'];
            $insertData['assign_to']    = $form_data['assign_to'];
            $insertData['note'] = $form_data['note'];
            $insertData['status']       = $form_data['status'];
            $insertData['date_at']      = date("Y-m-d H:i:s");
            $insertData['user_id']      = $this->session->userdata('userId');
    			 
            
            // Property2 Add Data End 
            $result = $this->property2_model->save($insertData);
            $property_id = $result; 
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Property2 successfully Added');

                // Featurs Add Data Start 
               
                $insertData = array();
                $insertData['RecreationAndFamily']  =  (isset($form_data['RecreationAndFamily'])) ? json_encode($form_data['RecreationAndFamily'], true): "";
                $insertData['HealthAndFitness']     =  (isset($form_data['HealthAndFitness'])) ? json_encode($form_data['HealthAndFitness'], true): "";
                $insertData['LaundryAndKitchen']    =  (isset($form_data['LaundryAndKitchen'])) ? json_encode($form_data['LaundryAndKitchen'], true): "";
                $insertData['BuildingList']         =  (isset($form_data['BuildingList'])) ? json_encode($form_data['BuildingList'], true): "";
                $insertData['BusinessAndSecurity']  =  (isset($form_data['BusinessAndSecurity'])) ? json_encode($form_data['BusinessAndSecurity'], true): "";
                $insertData['Miscellaneous']        =  (isset($form_data['Miscellaneous'])) ? json_encode($form_data['Miscellaneous'], true): "";
                $insertData['Technology']           =   (isset($form_data['Technology'])) ? json_encode($form_data['Technology'], true): "";
                $insertData['Features']             =  (isset($form_data['Features'])) ? json_encode($form_data['Features'], true): "";
                $insertData['CleaningAndMaintenance']=  (isset($form_data['CleaningAndMaintenance'])) ? json_encode($form_data['CleaningAndMaintenance'], true): "";
                $insertData['CompletionYear']       = $form_data['CompletionYear'];
                $insertData['ElevatorsinBuilding']  = $form_data['ElevatorsinBuilding'];
                $insertData['Flooring']             = $form_data['Flooring'];
                $insertData['View']                 = $form_data['View'];
                $insertData['Floor']                = $form_data['Floor'];
                $insertData['OtherFacilities']      = $form_data['OtherFacilities'];
                $insertData['LandArea']             = $form_data['LandArea'];
                $insertData['NumberOfBathrooms']    = $form_data['NumberOfBathrooms'];
                $insertData['NumberOfBedrooms']     = $form_data['NumberOfBedrooms'];
                $insertData['NearbySchools']        = $form_data['NearbySchools'];
                $insertData['NearbyHospitals']      = $form_data['NearbyHospitals'];
                $insertData['NearbyShoppingMalls']  = $form_data['NearbyShoppingMalls'];
                $insertData['DistanceFromAirport']  = $form_data['DistanceFromAirport'];
                $insertData['NearbyPublicTransport']= $form_data['NearbyPublicTransport'];
                $insertData['OtherNearbyPlaces']    = $form_data['OtherNearbyPlaces'];
                $insertData['PetPolicy']            = $form_data['PetPolicy'];
                $insertData['date_at']      = date("Y-m-d H:i:s");
                $insertData['property_id']         = $property_id;
                
                $result = $this->feature2_model->save($insertData);
                // Featurs Add Data end 


                  // extra Info Model Add Data Start 
                $insertData = array();

                $insertData['KeyLocation']          = $form_data['KeyLocation'];
                $insertData['YearlyServiceCharges'] = $form_data['YearlyServiceCharges'];
                $insertData['Str']                  = $form_data['Str'];
                $insertData['MonthlyCoolingCharge'] = $form_data['MonthlyCoolingCharge'];
                $insertData['Dewa']                 = $form_data['Dewa'];
                $insertData['MonthlyCoolingProvider']= $form_data['MonthlyCoolingProvider'];

                $insertData['property_id']          = $property_id;
                $insertData['status']               = '1';
                $insertData['date_at']              = date("Y-m-d H:i:s");

                     $result = $this->extra_info_model->save($insertData);
                  // extra Info Model  Add Data end 


                // PortalsList  Add Data Start 
                $insertData = array();

                $insertData['PortalsList']          = (isset($form_data['PortalsList'])) ? json_encode($form_data['PortalsList'], true): "";
                $insertData['property_id']          = $property_id;
                $insertData['status']               = '1';
                $insertData['date_at']              = date("Y-m-d H:i:s");

                $result = $this->portal_model->save($insertData);
                // PortalsList  Add Data Start 


                // VIDEOS Link  Add Data Start 
                $insertData = array();

                $insertData['VideoTitle']      = (isset($form_data['VideoTitle'])) ? json_encode($form_data['VideoTitle'], true): "";
                $insertData['VideoLink']       = (isset($form_data['VideoLink'])) ? json_encode($form_data['VideoLink'], true): "";
                $insertData['VideoHostList']   = (isset($form_data['VideoHostList'])) ? json_encode($form_data['VideoHostList'], true): "";

                $insertData['property_id']          = $property_id;
                $insertData['status']               = '1';
                $insertData['date_at']              = date("Y-m-d H:i:s");

                $result = $this->video_model->save($insertData);
                // VIDEOS Link   Add Data Start 

                // Images Add Data Start 
                $insertData = array();

                $insertData['image']    = (isset($form_data['imageName'])) ? json_encode($form_data['imageName'], true): "";
                $insertData['action']   = "Images";
                $insertData['alt']      =   "Property Images";
                $insertData['property_id'] = $property_id;
                $insertData['status']      = '1';
                $insertData['date_at']     = date("Y-m-d H:i:s");

                $result = $this->property_img_model->save($insertData);
                // Images Add Data End 

                  // Plan Image Add Data Start 
                $insertData = array();

                $insertData['image']    = (isset($form_data['imagePlanName'])) ? json_encode($form_data['imagePlanName'], true): "";
                $insertData['action']   = "Plan";
                $insertData['alt']      =   "Property Plan";
                $insertData['Title']=   (isset($form_data['floorTitle'])) ? json_encode($form_data['floorTitle'], true): ""; 
                $insertData['property_id'] = $property_id;  
                $insertData['status']      = '1';
                $insertData['date_at']     = date("Y-m-d H:i:s");

                $result = $this->property_img_model->save($insertData);
                // Plan Image Add Data End 

                 // Plan Image Add Data Start 
                $insertData = array();

                $insertData['image']    = (isset($form_data['docsName'])) ? json_encode($form_data['docsName'], true): "";
                $insertData['action']   = "Docs";
                $insertData['alt']      =   "Property Document";
                $insertData['Title']=   (isset($form_data['DocsTitle'])) ? json_encode($form_data['DocsTitle'], true): ""; 
                $insertData['property_id'] = $property_id;  
                $insertData['status']      = '1';
                $insertData['date_at']     = date("Y-m-d H:i:s");

                $result = $this->property_img_model->save($insertData);
                // Plan Image Add Data End 

                 // Landlord Add Data Start 
                $insertData = array();

                $insertData['Salutation']   = $form_data['Salutation'];
                $insertData['FirstName']    = $form_data['FirstName'];;
                $insertData['LastName']     = $form_data['LastName'];;
                $insertData['Email']        = $form_data['Email']; 
                $insertData['Mobile']       = $form_data['Mobile'];
                $insertData['AlternateMobile']=$form_data['AlternateMobile'];
                $insertData['TypeOFContact']= (isset($form_data['TypeOFContact'])) ? $form_data['TypeOFContact'] : "0";
                $insertData['Role']         = (isset($form_data['Role'])) ? json_encode($form_data['Role'], true): "";
                $insertData['Nationality']  = $form_data['Nationality'];
                $insertData['ContactSource']= $form_data['ContactSource'];
                $insertData['ContactAssignTo']=$form_data['ContactAssignTo'];
                $insertData['property_id']  = $property_id;  
                $insertData['status']       = '1';
                $insertData['date_at']      = date("Y-m-d H:i:s");

                $result = $this->landlord_model->save($insertData);
                // Landlord Add Data End 
            }
            else
            { 
                $this->session->set_flashdata('error', 'Property2 Addition failed');
            }
            
            redirect('vendor/property2/addnew');
        }  
        
    }


    // Member list
    public function ajax_list()
    {
        $list = $this->property2_model->get_datatables();
        $TypeList = $this->type_model->getTypeList();
        $PurposeList = $this->type_model->PurposeList();
        $listAssignTo = $this->type_model->listAssignTo();
		



		$data = array();
        $no =(isset($_POST['start']))?$_POST['start']:'';
        foreach ($list as $currentObj) {

            $temp_date = $currentObj->date_at;
            $dateAt = date("dMY H:ia", strtotime($temp_date));
            $selected = ($currentObj->status == 0)?" selected ":"";
            $btn = '<select class="statusBtn" name="statusBtn" data-id="'.$currentObj->id.'">';
            $btn .= '<option value="1"  >Active</option>';
            $btn .= '<option value="0" '.$selected.' >Inactive</option>';
            $btn .= '</select>';
            
$checkbox = '<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>';


            $no++;
            $row = array();
            $row[] = $checkbox;
            $row[] = $no;
            $row[] = $currentObj->external_reference;
            $row[] = (isset($PurposeList[$currentObj->purpose]))? $PurposeList[$currentObj->purpose]:"";
            $row[] = (isset($TypeList[$currentObj->type]))? $TypeList[$currentObj->type]:"";
            $row[] = $currentObj->beds;
            $row[] = $currentObj->location;
            $row[] = $currentObj->area;
            $row[] = $currentObj->rent;
            $row[] = (isset($listAssignTo[$currentObj->assign_to]))? $listAssignTo[$currentObj->assign_to]:"";
            $row[] = '';
            $row[] = $dateAt;
            $row[] = $btn;
              
             $row[] = '<div class="progress progress-xs">
                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                   
                </div>
              </div><div class="progress progress-xs">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                   
                </div>
              </div> ';
            
            $row[] = '<a title="Edit" ><i class="fa fa-pepper-hot"></i></a>&nbsp;&nbsp;';
             $row[] = 'button2';
            
            $row[] = '<a class="" href="'.base_url().'vendor/property2/editnew/'.$currentObj->id.'" title="Edit" ><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;<a href="#" title="Print"><i class="fa fa-file-text-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"   title="More" ><i class="fa fa-ellipsis-v"></i></a>&nbsp;&nbsp;<br><a class="deletebtn" href="#" data-userid="'.$currentObj->id.'"  title="Delete" ><i class="fa fa-archive"></i></a>';
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => (isset($_POST['draw']))?$_POST['draw']:'',
                        "recordsTotal" => $this->property2_model->count_all(),
                        "recordsFiltered" => $this->property2_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    // Status Change
 
    public function statusChange($id = NULL)
    {
        $this->isVendorLoggedIn();
        if($_POST['id'] == null)
        {
            redirect('vendor/property2');
        }

        $insertData['id'] = $_POST['id'];
        $insertData['status'] = $_POST['status'];
        $result = $this->property2_model->save($insertData);
        exit;
    } 

    // Edit
 
    public function edit($id = NULL)
    {
        $this->isVendorLoggedIn();
        
        if($id == null)
        {
            redirect('vendor/property2');
        }
       
        $where  = array();
        $where['table']  = 'rc_rel_agent';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agentList'] = $this->property_model->findDynamic($where);

        $where  = array();
        $where['table']  = 'rc_rel_agency';
        $where['status']  = '1';
        $where['field']  = 'id,name';
        $data['agencyList'] = $this->property_model->findDynamic($where);

        $data['edit_data'] = $this->property_model->find($id);
        $this->global['pageTitle'] = 'Property2 ';
        $this->vendorView("vendor/property2/edit", $this->global, $data , NULL);
        
    } 

    // Delete  property *****************************************************************
      function delete()
    {
        
        $this->isVendorLoggedIn();
        $delId = $this->input->post('id');  
        
        $result = $this->property2_model->delete($delId); 
            
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    // Update Propert *************************************************************
    public function update()
    {
        
        $this->isVendorLoggedIn();
        $this->load->library('form_validation');            
         
        $this->form_validation->set_rules('id','Id','trim|required');
        //$this->form_validation->set_rules('EnTitle','EnTitle','trim|required');
        $this->form_validation->set_rules('type','Type','required');
        $this->form_validation->set_rules('emirate','Emirate','required');
        $this->form_validation->set_rules('community','Community','required');
        $this->form_validation->set_rules('rent','Rent','required');
        $this->form_validation->set_rules('developer','Developer','required');
        $this->form_validation->set_rules('area','Area','required');
        $this->form_validation->set_rules('assign_to','Assign To','required');

        
        //form data 
        $form_data  = $this->input->post();
        if($this->form_validation->run() == FALSE)
        {
            
                $this->editnew($form_data['id']);
        }
        else
        {

            $insertData['id']           = $form_data['id'];
            $insertData['type']         = $form_data['type'];
            $insertData['purpose']      = $form_data['purpose'];
            $insertData['location']     = $form_data['location'];
            $insertData['emirate']      = $form_data['emirate'];
            $insertData['community']    = $form_data['community'];
            $insertData['unit']         = $form_data['unit'];
            $insertData['unit_plot']    = $form_data['unit_plot'];
            $insertData['unit_street']  = $form_data['unit_street'];
            $insertData['views']        = $form_data['views'];
            $insertData['external_reference'] = $form_data['external_reference'];
            $insertData['rent']        = $form_data['rent'];
            $insertData['frequency']    = $form_data['frequency'];
            $insertData['annual_commission_percent'] = $form_data['annual_commission_percent'];
            $insertData['annual_commission_aed'] = $form_data['annual_commission_aed'];

            $insertData['FeatureStatus'] = (isset($form_data['FeatureStatus'])) ? json_encode($form_data['FeatureStatus'], true) : "";
            $insertData['beds']        = $form_data['beds'];
            
            $insertData['baths']    = $form_data['baths'];
            $insertData['parking']      = $form_data['parking'];
            $insertData['year_built']   = $form_data['year_built'];
            $insertData['developer']    = $form_data['developer'];
            $insertData['plot_area']    = $form_data['plot_area'];
            $insertData['area']    = $form_data['area'];
            $insertData['deposit_percent'] = $form_data['deposit_percent'];
            $insertData['deposit_aed']  = $form_data['deposit_aed'];
            $insertData['cheques']      = $form_data['cheques'];

            $insertData['EnTitle']         = $form_data['EnTitle'];
            $insertData['description']        = $form_data['description'];
            $insertData['ArTitle']   = $form_data['ArTitle'];
            $insertData['ArDescription']        = $form_data['ArDescription'];
            $insertData['lsm']          = $form_data['lsm'];
            $insertData['tansaction']   = $form_data['tansaction'];
            $insertData['permit']       = $form_data['permit'];
            $insertData['permit_expiry']= $form_data['permit_expiry'];
            $insertData['landlord']     = $form_data['landlord'];
            $insertData['rented']       = (isset($form_data['rented'])) ? $form_data['rented']: "";
            $insertData['source']       = $form_data['source'];
            $insertData['assign_to']    = $form_data['assign_to'];
            $insertData['note'] = $form_data['note'];
            $insertData['status']       = $form_data['status'];
            $insertData['date_at']      = date("Y-m-d H:i:s");
            $insertData['user_id']      = $this->session->userdata('userId');
                 
            
            // Property2 Add Data End 
            $result = $this->property2_model->save($insertData);
            $property_id = $result; 
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Property2 successfully Updated');

                // Featurs Add Data Start 
               
                $insertData = array();
                $insertData['id']       = $form_data['FeaturesID'];
                $insertData['RecreationAndFamily']  =  (isset($form_data['RecreationAndFamily'])) ? json_encode($form_data['RecreationAndFamily'], true): "";
                $insertData['HealthAndFitness']     =  (isset($form_data['HealthAndFitness'])) ? json_encode($form_data['HealthAndFitness'], true): "";
                $insertData['LaundryAndKitchen']    =  (isset($form_data['LaundryAndKitchen'])) ? json_encode($form_data['LaundryAndKitchen'], true): "";
                $insertData['BuildingList']         =  (isset($form_data['BuildingList'])) ? json_encode($form_data['BuildingList'], true): "";
                $insertData['BusinessAndSecurity']  =  (isset($form_data['BusinessAndSecurity'])) ? json_encode($form_data['BusinessAndSecurity'], true): "";
                $insertData['Miscellaneous']        =  (isset($form_data['Miscellaneous'])) ? json_encode($form_data['Miscellaneous'], true): "";
                $insertData['Technology']           =   (isset($form_data['Technology'])) ? json_encode($form_data['Technology'], true): "";
                $insertData['Features']             =  (isset($form_data['Features'])) ? json_encode($form_data['Features'], true): "";
                $insertData['CleaningAndMaintenance']=  (isset($form_data['CleaningAndMaintenance'])) ? json_encode($form_data['CleaningAndMaintenance'], true): "";
                $insertData['CompletionYear']       = $form_data['CompletionYear'];
                $insertData['ElevatorsinBuilding']  = $form_data['ElevatorsinBuilding'];
                $insertData['Flooring']             = $form_data['Flooring'];
                $insertData['View']                 = $form_data['View'];
                $insertData['Floor']                = $form_data['Floor'];
                $insertData['OtherFacilities']      = $form_data['OtherFacilities'];
                $insertData['LandArea']             = $form_data['LandArea'];
                $insertData['NumberOfBathrooms']    = $form_data['NumberOfBathrooms'];
                $insertData['NumberOfBedrooms']     = $form_data['NumberOfBedrooms'];
                $insertData['NearbySchools']        = $form_data['NearbySchools'];
                $insertData['NearbyHospitals']      = $form_data['NearbyHospitals'];
                $insertData['NearbyShoppingMalls']  = $form_data['NearbyShoppingMalls'];
                $insertData['DistanceFromAirport']  = $form_data['DistanceFromAirport'];
                $insertData['NearbyPublicTransport']= $form_data['NearbyPublicTransport'];
                $insertData['OtherNearbyPlaces']    = $form_data['OtherNearbyPlaces'];
                $insertData['PetPolicy']            = $form_data['PetPolicy'];
                $insertData['date_at']      = date("Y-m-d H:i:s");
                $insertData['property_id']         = $property_id;
                
                $result = $this->feature2_model->save($insertData);
                // Featurs Add Data end 


                  // extra Info Model Add Data Start 
                $insertData = array();

                $insertData['id']       = $form_data['ExtraInfoID'];
                $insertData['KeyLocation']          = $form_data['KeyLocation'];
                $insertData['YearlyServiceCharges'] = $form_data['YearlyServiceCharges'];
                $insertData['Str']                  = $form_data['Str'];
                $insertData['MonthlyCoolingCharge'] = $form_data['MonthlyCoolingCharge'];
                $insertData['Dewa']                 = $form_data['Dewa'];
                $insertData['MonthlyCoolingProvider']= $form_data['MonthlyCoolingProvider'];

                $insertData['property_id']          = $property_id;
                $insertData['status']               = '1';
                $insertData['date_at']              = date("Y-m-d H:i:s");

                     $result = $this->extra_info_model->save($insertData);
                  // extra Info Model  Add Data end 


                // PortalsList  Add Data Start 
                $insertData = array();
                $insertData['id']       = $form_data['PortalsID'];
                $insertData['PortalsList']          = (isset($form_data['PortalsList'])) ? json_encode($form_data['PortalsList'], true): "";
                $insertData['property_id']          = $property_id;
                $insertData['status']               = '1';
                $insertData['date_at']              = date("Y-m-d H:i:s");

                $result = $this->portal_model->save($insertData);
                // PortalsList  Add Data Start 


                // VIDEOS Link  Add Data Start 
                $insertData = array();
                $insertData['id']       = $form_data['videoID'];
                $insertData['VideoTitle']      = (isset($form_data['VideoTitle'])) ? json_encode($form_data['VideoTitle'], true): "";
                $insertData['VideoLink']       = (isset($form_data['VideoLink'])) ? json_encode($form_data['VideoLink'], true): "";
                $insertData['VideoHostList']   = (isset($form_data['VideoHostList'])) ? json_encode($form_data['VideoHostList'], true): "";

                $insertData['property_id']          = $property_id;
                $insertData['status']               = '1';
                $insertData['date_at']              = date("Y-m-d H:i:s");

                $result = $this->video_model->save($insertData);
                // VIDEOS Link   Add Data Start 

                // Images Add Data Start 
                $insertData = array();
                $insertData['id']       = $form_data['imageID'];
                $insertData['image']    = (isset($form_data['imageName'])) ? json_encode($form_data['imageName'], true): "";
                $insertData['action']   = "Images";
                $insertData['alt']      =   "Property Images";
                $insertData['property_id'] = $property_id;
                $insertData['status']      = '1';
                $insertData['date_at']     = date("Y-m-d H:i:s");

                $result = $this->property_img_model->save($insertData);
                // Images Add Data End 

                  // Plan Image Add Data Start 
                $insertData = array();
                $insertData['id']       = $form_data['planID'];
                $insertData['image']    = (isset($form_data['imagePlanName'])) ? json_encode($form_data['imagePlanName'], true): "";
                $insertData['action']   = "Plan";
                $insertData['alt']      =   "Property Plan";
                $insertData['Title']=   (isset($form_data['floorTitle'])) ? json_encode($form_data['floorTitle'], true): ""; 
                $insertData['property_id'] = $property_id;  
                $insertData['status']      = '1';
                $insertData['date_at']     = date("Y-m-d H:i:s");

                $result = $this->property_img_model->save($insertData);
                // Plan Image Add Data End 

                 // docs  Add Data Start 
                $insertData = array();
                $insertData['id']       = $form_data['docID'];
                $insertData['image']    = (isset($form_data['docsName'])) ? json_encode($form_data['docsName'], true): "";
                $insertData['action']   = "Docs";
                $insertData['alt']      =   "Property Document";
                $insertData['Title']=   (isset($form_data['DocsTitle'])) ? json_encode($form_data['DocsTitle'], true): ""; 
                $insertData['property_id'] = $property_id;  
                $insertData['status']      = '1';
                $insertData['date_at']     = date("Y-m-d H:i:s");

                $result = $this->property_img_model->save($insertData);
                // docs Image Add Data End 

                 // Landlord Add Data Start 
                $insertData = array();
                 $insertData['id']       = $form_data['landlordID'];
                $insertData['Salutation']   = $form_data['Salutation'];
                $insertData['FirstName']    = $form_data['FirstName'];;
                $insertData['LastName']     = $form_data['LastName'];;
                $insertData['Email']        = $form_data['Email']; 
                $insertData['Mobile']       = $form_data['Mobile'];
                $insertData['AlternateMobile']=$form_data['AlternateMobile'];
                $insertData['TypeOFContact']= (isset($form_data['TypeOFContact'])) ? $form_data['TypeOFContact'] : "0";
                $insertData['Role']         = (isset($form_data['Role'])) ? json_encode($form_data['Role'], true): "";
                $insertData['Nationality']  = $form_data['Nationality'];
                $insertData['ContactSource']= $form_data['ContactSource'];
                $insertData['ContactAssignTo']=$form_data['ContactAssignTo'];
                $insertData['property_id']  = $property_id;  
                $insertData['status']       = '1';
                $insertData['date_at']      = date("Y-m-d H:i:s");

                $result = $this->landlord_model->save($insertData);
                // Landlord Add Data End 
            }
            else
            { 
                $this->session->set_flashdata('error', 'Property2 Addition failed');
            }
            
            redirect('vendor/property2/editnew');
        }
    }
 
    
}

?>