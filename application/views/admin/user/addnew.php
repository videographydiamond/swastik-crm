<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Add New Contact</h4>
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
            <?php } ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-6">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title mb-3">Customer Detail</h5>
                  <form action="<?php echo base_url() ?>admin/customer/insertnow" method="post" role="form" enctype="multipart/form-data" >
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="customer_id" name="customer_id" placeholder="Customer ID" readonly >
                              <label for="customer_id">Customer Id</label>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer ID" required />
                              <label for="customer_name">Customer Name <span class="text-danger">*</span></label>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="customer_mobile"  name="customer_mobile"  placeholder="Customer Mobile" required  />
                              <label for="customer_mobile">Mobile <span class="text-danger">*</span></label>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-floating mb-3">
                              <input type="text" class="form-control" id="customer_alter_mobile" placeholder="Customer ID" name="customer_alter_mobile">
                              <label for="customer_alter_mobile">ALT Mobile</label>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-floating mb-3">
                              <select class="form-select" id="state" name="state" aria-label="Floating label select example">
                                 <option value="" selected>Choose State</option>
                                 <?php
                                    if(!empty($states))
                                    {
                                        foreach ($states as $state) {
                                            ?>
                                 <option value="<?php echo $state->id;?>"><?php echo $state->name;?></option>
                                 <?php
                                    }
                                    }
                                    ?>
                              </select>
                              <label for="state">Choose State </label>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-floating mb-3">
                              <select class="form-select" id="city" name="city" aria-label="Floating label select example">
                                 <option value="" selected>Choose District</option>
                                 <?php
                                    if(!empty($cities))
                                    {
                                        foreach ($cities as $city) {
                                            ?>
                                 <option value="<?php echo $city->id;?>"><?php echo $city->city;?></option>
                                 <?php
                                    }
                                    }
                                    ?>
                              </select>
                              <label for="city">Choose District</label>
                           </div>
                        </div>
                     </div>
                     <div>
                        <button type="submit" class="btn btn-primary w-md">Save Customer</button>
                     </div>
                  </form>
               </div>
               <!-- end card body -->
            </div>
            <!-- end card -->
         </div>
         <!-- end col -->
         <div class="col-xl-6">
            <div class="card">
               <div class="card-body">
                  <?php
                     include_once 'add-call.php';
                     ?>
               </div>
            </div>
            <!-- end card body -->
         </div>
         <!-- end card -->
      </div>
      <!-- end col -->
      <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Customer</h4>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0" id="example">
                                                <thead class="table-light">
                                                    <tr>
                                                         
                                                        <th class="align-middle">Action</th>
                                                        <th class="align-middle">Date</th>
                                                        <th class="align-middle">CustomerID</th>
                                                        <th class="align-middle">Name</th>
                                                        <th class="align-middle">Mobile</th>
                                                        <th class="align-middle">ALT Mobile</th>
                                                        <th class="align-middle">District</th>
                                                        <th class="align-middle">State</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
   </div>
</div>

 <script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
 <script type="text/javascript">
    jQuery(document).ready(function(){
        //$('#example').DataTable();

         jQuery(document).on("click", ".deletebtn", function(){

          var userId = $(this).data("userid"),
            hitURL = "<?php echo base_url() ?>admin/customer/delete",
            currentRow = $(this);
          
          var confirmation = confirm("Are you sure to delete?");
          
          if(confirmation)
          {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : userId } 
            }).done(function(data){           
              currentRow.parents('tr').remove();
              if(data.status = true) { alert("successfully deleted"); }
              else if(data.status = false) { alert("deletion failed"); }
              else { alert("Access denied..!"); }
            });
          }
    });
    });
   
</script>
<script type="text/javascript">
 



var table;
 
$(document).ready(function() {
 

 
    //datatables
    table = $('#example').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/customer/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});
</script>