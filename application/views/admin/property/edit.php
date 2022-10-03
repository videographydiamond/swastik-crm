<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <a href="<?php echo base_url();?>admin/property"> <i class="fa fa-pie-chart" aria-hidden="true"></i> Property</a>
        <small>Edit</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add New Property</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->                    
                    
                    <form role="form" id="member_form" action="<?php echo base_url() ?>admin/property/update" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--Property Name-->                             
                                    <div class="form-group">
                                        <label for="name">Property Name</label>
                                        <input type="text" id="name" name ="name" class="form-control" required="required" placeholder="Enter Property Name" value="<?php echo $edit_data->name; ?>" >
                                    </div> 
                                 </div> 
                             </div>
                             <!-- multi container forms-->
                             <div class="row">
                                <!-- menu-con-->
                                <div class="col-sm-3 menuCon ">
                                    <ul class="list-group adminLeftMenu">
                                      <li class="list-group-item menuBtn active1" data-target="informationCon"><i class="fa fa-home"></i>&nbsp;&nbsp; Information <i class="fa fa-angle-right pull-right"></i> </li>
                                      <li class="list-group-item menuBtn" data-target="mapCon"><i class="fa fa-map-marker"></i>&nbsp;&nbsp; Map <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="settingCon"><i class="fa fa-cog"></i>&nbsp;&nbsp; Property Settings <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="mediaCon"><i class="fa fa-photo"></i>&nbsp;&nbsp; Media <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="virtualCon"><i class="fa fa-film"></i>&nbsp;&nbsp; 360° Virtual Tour <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="contactInfoCon"><i class="fa fa-user"></i>&nbsp;&nbsp; Contact Information <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="sliderCon"><i class="fa fa-caret-square-o-right"></i>&nbsp;&nbsp; Slider <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="floorPlanCon"><i class="fa fa-building"></i>&nbsp;&nbsp; Floor Plan <i class="fa fa-angle-right pull-right"></i> </li>
                                      <li class="list-group-item menuBtn" data-target="propertyDocCon"><i class="fa fa-file"></i>&nbsp;&nbsp; Property Documents <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="privateNoteCon"><i class="fa fa-lightbulb-o"></i>&nbsp;&nbsp; Private Note <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="energyclassCon"><i class="fa fa-lightbulb-o"></i>&nbsp;&nbsp; Energy Class <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="layoutCon"><i class="fa fa-laptop"></i>&nbsp;&nbsp; Layout <i class="fa fa-angle-right pull-right"></i> </li>

                                      <li class="list-group-item menuBtn" data-target="descriptonCon"><i class="fa fa-edit"></i>&nbsp;&nbsp; Description <i class="fa fa-angle-right pull-right"></i> </li>

                                    </ul>
                                </div> 
                                <!-- menu-con-->
                                <div class="col-sm-9  formCon">
                                    <!-- form-1-->
                                    <div class="incCon informationCon ">
                                        <?php include_once "form1-information.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-2-->
                                    <div class="incCon mapCon hidden">
                                        <?php include_once "form2-map.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-3-->
                                    <div class="incCon settingCon hidden">
                                        <?php include_once "form3-setting.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-4-->
                                    <div class="incCon mediaCon hidden">
                                        <?php include_once "form4-media.php"; ?>
                                    </div>

                                    <!-- form-5-->
                                    <div class="incCon virtualCon hidden">
                                        <?php include_once "form5-virtual.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-6-->
                                    <div class="incCon contactInfoCon hidden">
                                        <?php include_once "form6-contactInfo.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-7-->
                                    <div class="incCon sliderCon hidden">
                                        <?php include_once "form7-slider.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-8-->
                                    <div class="incCon floorPlanCon hidden">
                                        <?php include_once "form8-floorplan.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-9-->
                                    <div class="incCon propertyDocCon hidden">
                                        <?php include_once "form9-propertydoc.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-10-->
                                    <div class="incCon privateNoteCon hidden">
                                        <?php include_once "form10-privatenote.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-11-->
                                    <div class="incCon energyclassCon hidden">
                                        <?php include_once "form11-eneryclass.php"; ?>
                                    </div>
                                    <!--// -->

                                    <!-- form-12-->
                                    <div class="incCon layoutCon hidden">
                                        <?php include_once "form12-layout.php"; ?>
                                    </div>
                                    <!--// -->
                                    <!-- form-13-->
                                    <div class="incCon descriptonCon hidden">
                                        <?php include_once "form13-description.php"; ?>
                                    </div>
                                    <!--// -->
                                </div>
                             </div> 
                             <!--// multi container forms-->

                             
                             
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-2">
                                    <!--Status-->
                                    <div class="form-group">
                                         <select class ="form-control" name="status" id="status">
                                            <option value="1" <?php echo ($edit_data->status == 1)?'selected':''; ?> >Active</option>
                                            <option value="0" <?php echo ($edit_data->status == 0)?'selected':''; ?> >Inactive</option>
                                        </select>   
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <input type="hidden" name="id" value="<?php echo $edit_data->id; ?>"/>
                                    <input type="submit" class="btn btn-primary" value="Update" />
                                    <!-- <input type="reset" class="btn btn-default" value="Reset" /> -->
                                </div>
                            </div><!--//row-->
                        </div>
                    </form>
                </div>
            </div><!--// col-12-->
            
        </div>    
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".menuBtn").click(function(){
            var target = "."+$(this).attr("data-target");
            $(".menuBtn").removeClass("active1");
            $(this).addClass("active1");
            $(".incCon").addClass("hidden");
            $(target).removeClass("hidden");
        });
    });
</script>
