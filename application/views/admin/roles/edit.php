<style>
  .table>:not(caption)>*>*
  {
    padding: 0;
  }
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Role</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/roles">Role List</a></li>
                     <li class="breadcrumb-item active">Edit Role</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <?php $this->load->helper('form'); ?>
            <div class="row">
               <div class="col-md-12">
                  <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show " role="alert" >', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); ?>
               </div>
            </div>
            <?php
               $this->load->helper('form');
               $error = $this->session->flashdata('error');
               if($error)
               {
                   ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <?php echo $error; ?> 
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }
               $success = $this->session->flashdata('success');
               if($success)
               {
                   ?>
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
               <?php echo $success; ?> 
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }
               ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-12">
            <div class="row">
               <div class="col-lg-12">
                  <form  action="<?php echo base_url() ?>admin/roles/update" method="post" role="form" enctype="multipart/form-data"  >
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Edit Role
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="text"  class="form-control form-control-sm" id="name" name="name" placeholder="Crop Type Name*" value="<?php echo $edit_data->title;?>" required>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="status1" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm" id="status1" name="status1" style="display: block!important">
                                          <option value="1" <?php echo ($edit_data->status == 1)?'selected':''; ?> >Active</option>
                                          <option value="0" <?php echo ($edit_data->status == 0)?'selected':''; ?> >Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-12">
                           </div>
                        </div>
                        <div class="card-footer">
                           <div class="float-end">
                              <input type="hidden" name="id" value="<?php echo $edit_data->id; ?>"/>
                              <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                              <input type="reset" class="btn btn-default btn-sm" value="Reset" />
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-12">
            <div class="row">
               <div class="col-lg-12">
                  <form  action="<?php echo base_url() ?>admin/roles/update_role_module" method="post" role="form" enctype="multipart/form-data"  >
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">

                           <div class="row ">
                              <div class="col-sm-9">
                                Define Role Module
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                            
                            <div class="table-responsive mytablestyle">
                              <table class="table align-middle table-nowrap mb-0 table-striped">
                                <tr style="width: 100%">
                                        <td style="width: 33%" ></td>
                                        <td style="width: 33%"></td>
                                        <td style="width: 33%"></td>
                                        
                                      </tr>
                                <?php

                                  $menu_list_without_auth = menu_list_without_auth();
                                  if(!empty($menu_list_without_auth ))
                                  {
                                    foreach ($menu_list_without_auth  as $key)
                                    {

                                      $menu1_is_checked = check_module_role($key['id'],$edit_data->id);
                                          

                                     /* echo "<pre>";
                                      print_r($menu1_is_checked); 
                                      echo "</pre>"; */
                                      ?>
                                      <tr >
                                        <td colspan='3'>
                                          <div class="form-check form-check-primary ">

                                           <input class="form-check-input toggle-menu" id="menu1_access_<?php echo $key['id'];?>"   type="checkbox" <?php if(!empty($menu1_is_checked)){ ?> checked="true" <?php } ?> name="module_checked[<?php echo $key['id'];?>]" value="1">
                                            <label for="menu1_access_<?php echo $key['id'];?>"><?php echo  $key['module_name'];?> </label>
                                          </div>
                                       </td>
                                      </tr>
                                      <?php 

                                      $menu_list_without_auth2 = menu_list_without_auth($key['id']);
                                      if(!empty($menu_list_without_auth2 ))
                                      {
                                        foreach ($menu_list_without_auth2  as $key2)
                                        {
                                          $menu2_is_checked = check_module_role($key2['id'],$edit_data->id);


                                          $create   = '';
                                          $edit     = '';
                                          $delete   = '';
                                          $view     = '';
                                          $lists     = '';
                                          
                                          /*print_r($menu2_is_checked);*/
                                          if(!empty($menu2_is_checked[0]))
                                          {
                                              $action_required = $menu2_is_checked[0]['action_required'];
                                              $action_required_dec  =  json_decode($action_required);
                                              if(@$action_required_dec->create=='create')
                                              {
                                                $create   = 'create';
                                              }
                                              if(@$action_required_dec->edit=='edit')
                                              {
                                                 $edit     = 'edit';
                                              }
                                              if(@$action_required_dec->delete =='delete')
                                              {
                                                 $delete   = 'delete';
                                              }
                                              if(@$action_required_dec->view =='view')
                                              {
                                                $view     = 'view';
                                              }
                                              if(@$action_required_dec->lists =='lists')
                                              {
                                                $lists     = 'lists';
                                              }
                                              
                                          }
                                           
                                          $menu_list_without_auth3 = menu_list_without_auth($key2['id']);
                                          ?>
                                          <tr >
                                            <td colspan="1">&nbsp;</td>
                                            <td colspan="2" >
                                              <div class="form-check form-check-primary ">
 
                                          <input class="form-check-input" id="menu2_access_<?php echo $key2['id'];?>"   type="checkbox"  <?php if(!empty($menu2_is_checked)){ ?> checked="true" <?php } ?>  name="module_checked[<?php echo $key2['id'];?>]" value="1">
                                            <label for="menu2_access_<?php echo $key2['id'];?>"><?php echo  $key2['module_name'];?> </label>
                                          </div>
                                            <?php 
                                              if(empty($menu_list_without_auth3))
                                              {
                                                /*creating action for edit update delete and view */
                                                ?>
                                          <div class="m-2" >
                                            <div class="form-check form-check-inline form-check-primary">
                                              <input class="form-check-input" type="checkbox" <?php if(!empty($lists)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key2['id'];?>][inlineRadioOptions][lists]" id="lists<?php echo $key2['id'];?>" value="lists">
                                              <label class="form-check-label" for="lists<?php echo $key2['id'];?>">list</label>
                                            </div>
                                            <div class="form-check form-check-inline form-check-primary">
                                              <input class="form-check-input" type="checkbox" <?php if(!empty($create)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key2['id'];?>][inlineRadioOptions][create]" id="create<?php echo $key2['id'];?>" value="create">
                                              <label class="form-check-label" for="create<?php echo $key2['id'];?>">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline form-check-primary">
                                                <input class="form-check-input" type="checkbox" <?php if(!empty($edit)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key2['id'];?>][inlineRadioOptions][edit]" id="edit<?php echo $key2['id'];?>" value="edit">
                                                <label class="form-check-label" for="edit<?php echo $key2['id'];?>">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline form-check-primary">
                                                <input class="form-check-input" type="checkbox" <?php if(!empty($delete)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key2['id'];?>][inlineRadioOptions][delete]" id="delete<?php echo $key2['id'];?>" value="delete">
                                                <label class="form-check-label" for="delete<?php echo $key2['id'];?>">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline form-check-primary">
                                                <input class="form-check-input" type="checkbox" <?php if(!empty($view)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key2['id'];?>][inlineRadioOptions][view]" id="view<?php echo $key2['id'];?>" value="view">
                                                <label class="form-check-label" for="view<?php echo $key2['id'];?>">View</label>
                                            </div>
                                          </div>
                                                <?php
                                                /*creating action for edit update delete and view */

                                              }
                                            ?>
                                              </td>
                                          </tr>
                                          <?php

                                           
                                            if(!empty($menu_list_without_auth3 ))
                                            {
                                              foreach ($menu_list_without_auth3  as $key3)
                                              {

                                                $menu3_is_checked = check_module_role($key3['id'],$edit_data->id);

                                                $create   = '';
                                                $edit     = '';
                                                $delete   = '';
                                                $view     = '';
                                                $lists     = '';
                                                
                                                /*print_r($menu2_is_checked);*/
                                                if(!empty($menu3_is_checked[0]))
                                                {
                                                    $action_required = $menu3_is_checked[0]['action_required'];
                                                    $action_required_dec  =  json_decode($action_required);
                                                    if(@$action_required_dec->create=='create')
                                                    {
                                                      $create   = 'create';
                                                    }
                                                    if(@$action_required_dec->edit=='edit')
                                                    {
                                                       $edit     = 'edit';
                                                    }
                                                    if(@$action_required_dec->delete =='delete')
                                                    {
                                                       $delete   = 'delete';
                                                    }
                                                    if(@$action_required_dec->view =='view')
                                                    {
                                                      $view     = 'view';
                                                    } 
                                                    if(@$action_required_dec->lists =='lists')
                                                    {
                                                      $lists     = 'lists';
                                                    }
                                                    
                                                }


                                                ?>
                                                <tr >
                                                  <td colspan="2">&nbsp;</td><td colspan="1" >
                                                        <div class="form-check form-check-primary ">
                                                           <input class="form-check-input" id="menu3_access_<?php echo $key3['id'];?>"   type="checkbox"   <?php if(!empty($menu3_is_checked)){ ?> checked="true" <?php } ?> name="module_checked[<?php echo $key3['id'];?>]" value="1">
                                                            <label for="menu3_access_<?php echo $key3['id'];?>"><?php echo  $key3['module_name'];?> </label>
                                                        </div>

                                                        <div class="m-2" >
                                                          <div class="form-check form-check-inline form-check-primary">
                                                            <input class="form-check-input" type="checkbox" <?php if(!empty($lists)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key3['id'];?>][inlineRadioOptions][lists]" id="lists<?php echo $key3['id'];?>" value="lists">
                                                            <label class="form-check-label" for="lists<?php echo $key3['id'];?>">List</label>
                                                          </div>
                                                          <div class="form-check form-check-inline form-check-primary">
                                                            <input class="form-check-input" type="checkbox" <?php if(!empty($create)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key3['id'];?>][inlineRadioOptions][create]" id="create<?php echo $key3['id'];?>" value="create">
                                                            <label class="form-check-label" for="create<?php echo $key3['id'];?>">Create</label>
                                                          </div>
                                                          <div class="form-check form-check-inline form-check-primary">
                                                              <input class="form-check-input" type="checkbox" <?php if(!empty($edit)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key3['id'];?>][inlineRadioOptions][edit]" id="edit<?php echo $key3['id'];?>" value="edit">
                                                              <label class="form-check-label" for="edit<?php echo $key3['id'];?>">Edit</label>
                                                          </div>
                                                          <div class="form-check form-check-inline form-check-primary">
                                                              <input class="form-check-input" type="checkbox" <?php if(!empty($delete)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key3['id'];?>][inlineRadioOptions][delete]" id="delete<?php echo $key3['id'];?>" value="delete">
                                                              <label class="form-check-label" for="delete<?php echo $key3['id'];?>">Delete</label>
                                                          </div>
                                                          <div class="form-check form-check-inline form-check-primary">
                                                              <input class="form-check-input" type="checkbox" <?php if(!empty($view)){ ?> checked="true" <?php } ?> name="option_data[<?php echo $key3['id'];?>][inlineRadioOptions][view]" id="view<?php echo $key3['id'];?>" value="view">
                                                              <label class="form-check-label" for="view<?php echo $key2['id'];?>">View</label>
                                                          </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php       
                                              }
                                            }        
                                        }
                                      }      
                                    }
                                  }

                                  /*echo "<pre>";
                                  print_r($menu_list_without_auth);
                                  echo "</pre>";*/
                                ?>
                                
                              </table>
                            </div>
                        </div>
                        <div class="card-footer">
                           <div class="float-end">
                              <input type="hidden" name="role_id" value="<?php echo $edit_data->id; ?>"/>
                              <input type="submit" class="btn btn-primary btn-sm" value="Save Module Role" />
                              <input type="reset" class="btn btn-default btn-sm" value="Reset" />
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>