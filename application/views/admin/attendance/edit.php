<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Attendance Form</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/attendance">Attendance Log List</a></li>
                     <li class="breadcrumb-item active">Edit Employe Attendance </li>
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
            <ul class="nav nav-tabs" role="tablist">
              <?php if($checkInOutStatus ==1)
              {
                ?>
                <li class="nav-item">
                  <a class="nav-link  active " data-bs-toggle="tab" href="#check-in" role="tab" aria-selected="<?php echo (($checkInOutStatus ==1))?'true':''?>">
                  <span>Check In</span>    
                  </a>
               </li> 
                <li class="nav-item">
                  <a class="nav-link disabled" >
                  <span>Checkout</span>    
                  </a>
               </li>
                <?php
              }else if($checkInOutStatus ==2)
              {
                ?>
                 <li class="nav-item">
                  <a class="nav-link disabled" >
                  <span>Check In</span>    
                  </a>
               </li>
                 <li class="nav-item">
                    <a class="nav-link <?php echo (($checkInOutStatus ==2))?'active':''?>" data-bs-toggle="tab" href="#check-out" role="tab" aria-selected="<?php echo (($checkInOutStatus ==2))?'false':''?>">
                    <span>Checkout</span>    
                    </a>
                 </li>
                <?php
              }
              ?>
               
               
            </ul>
            <div class="tab-content p-3 text-muted">
               <div class="tab-pane <?php echo (($checkInOutStatus ==1))?'active':''?>" id="check-in" role="tabpanel">
                  <div class="row">
                     <div class="col-lg-12">
                        <form  action="<?php echo base_url() ?>admin/attendance/update" method="post" role="form" enctype="multipart/form-data"  >
                           <div class="card">
                              <h5 class="card-header bg-success text-white border-bottom ">
                                 <div class="row ">
                                    <div class="col-sm-9">
                                       Check In 
                                    </div>
                                 </div>
                              </h5>
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="row">
                                          <label for="name" class="col-sm-4 col-form-label">Employee Name<span class="text-danger">*</span></label>
                                          <div class="col-sm-8"> 
                                            <?php
                                        if($this->session->userdata('role')==1)
                                        {
                                          ?>
                                             <select class=" form-control form-control-sm " id="uid" name="uid" aria-label="Floating label select example" >
                                               
                                               <?php
                                                  if(!empty($all_agents))
                                                  { 
                                                    $userid = $checkInOutHistoryData->user_id;
                                                      foreach ($all_agents as $all_agent) {
                                                         
                                                            ?>
                                                            <?php   
                                                            if($all_agent->id==$userid)
                                                            {
                                                              ?>
                                                                <option value="<?php echo $all_agent->id;?>" selected > <?php echo ( ($all_agent->id)?$all_agent->id:'')." ".$all_agent->title;?></option>
                                                              <?php
                                                            }
                                                              ?> 
                                                        
                                               
                                               <?php
                                                      }
                                                  }
                                                  ?>

                                            </select>
                                          <?php
                                        }else
                                        {
                                          ?>
                                          <input type="text" class="form-control form-control-sm" value="<?php echo $this->session->userdata('name')?>" readonly >
                                          <?php
                                        }
                                      ?>
                                              
                                          </div>
                                       </div>
                                    </div>
                                    
                                 </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                       <div class="row">
                                          <label for="name" class="col-sm-4 col-form-label">Punch Time<span class="text-danger">*</span></label>
                                          <div class="col-sm-8"> 
                                              <input type="datetime-local" name="puch_time" class="form-control form-control-sm" <?php echo ($this->session->userdata('role') =='1')?'':'readonly';?> value="<?php echo  date('Y-m-d H:i:s',strtotime($checkInOutHistoryData->time));?>" required />
                                          </div>
                                       </div>
                                    </div>
                                    
                                 </div>
                              </div>
                              <div class="card-footer">
                                 <div class="row">
                                <div class="col-sm-6">
                                 <div class="float-end">
                                    <input type="submit" class="btn btn-primary btn-sm" value="Update Check In" <?php echo (($checkInOutStatus ==1 && $this->session->userdata('role') !=='1' ))?'disabled':''?> />
                                    <input type="hidden" name="state" value="1"  />
                                     <input type="hidden" name="id" value="<?php echo $checkInOutHistoryData->id;?>"  />
                                    <input type="hidden" name="uid" value="<?php echo $checkInOutHistoryData->user_id;?>"  />
                                    <input type="hidden" name="att_id" value="<?php echo $checkInOutHistoryData->att_id;?>"  />
                                    <input type="hidden" name="today_time" value="<?php echo date("Y-m-d H:i:s");?>"  />
                                 </div>
                                 </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="tab-pane <?php echo (($checkInOutStatus ==2))?'active':''?> " id="check-out" role="tabpanel">
                  <div class="row">
                     <div class="col-lg-12">
                        <form  action="<?php echo base_url() ?>admin/attendance/update" method="post" role="form" enctype="multipart/form-data"  >
                           <div class="card">
                              <h5 class="card-header bg-success text-white border-bottom ">
                                 <div class="row ">
                                    <div class="col-sm-9">
                                       Check Out
                                    </div>
                                 </div>
                              </h5>
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="row">
                                          <label for="name" class="col-sm-4 col-form-label">Employee Namew<span class="text-danger">*</span></label>
                                          <div class="col-sm-8"> 
                                              <?php
                                        if($this->session->userdata('role')==1)
                                        {
                                          ?>
                                             <select class=" form-control form-control-sm " id="uid" name="uid" aria-label="Floating label select example" >
                                               
                                               <?php
                                                  if(!empty($all_agents))
                                                  {
                                                     $userid = $checkInOutHistoryData->user_id;
                                                      foreach ($all_agents as $all_agent) {
                                                         
                                                            ?>
                                                            <?php   
                                                            if($all_agent->id==$userid)
                                                            {
                                                              ?>
                                                                <option value="<?php echo $all_agent->id;?>" selected > <?php echo ( ($all_agent->id)?$all_agent->id:'')." ".$all_agent->title;?></option>
                                                              <?php
                                                            }
                                                              ?> 
                                                        
                                               
                                               <?php
                                                      }
                                                }
                                                  ?>

                                            </select>
                                          <?php
                                        }else
                                        {
                                          ?>
                                          <input type="text" class="form-control form-control-sm" value="<?php echo $this->session->userdata('name')?>" readonly >
                                          <?php
                                        }
                                      ?>
                                          </div>
                                       </div>
                                     
                                       <div class="row">
                                          <label for="name" class="col-sm-4 col-form-label">Punch Time<span class="text-danger">*</span></label>
                                          <div class="col-sm-8"> 
                                            <input type="datetime-local" name="puch_time" class="form-control form-control-sm" <?php echo  ($this->session->userdata('role') =='1')?'':'readonly';?> value="<?php echo  date('Y-m-d H:i:s',strtotime($checkInOutHistoryData->time));?>" required />
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="card-footer">
                                <div class="row">
                                <div class="col-sm-6">
                                 <div class="float-end">
                                    <input type="submit" class="btn btn-primary btn-sm" value="Update Check Out" <?php echo (($checkInOutStatus ==2 && $this->session->userdata('role') !=='1' ) )?'disabled':''?> />
                                    <input type="hidden" name="state" value="2"  />
                                    <input type="hidden" name="id" value="<?php echo $checkInOutHistoryData->id;?>"  />
                                    <input type="hidden" name="uid" value="<?php echo $checkInOutHistoryData->user_id;?>"  />
                                    <input type="hidden" name="att_id" value="<?php echo $checkInOutHistoryData->att_id;?>"  />
                                     <input type="hidden" name="today_time" value="<?php echo date("Y-m-d H:i:s");?>"  />
                                 </div>
                                </div>
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
</div>
</div>
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>