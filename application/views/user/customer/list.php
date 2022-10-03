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
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Call Details</h4>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0" id="example">
                                                <thead class="table-light">
                                                    <tr>
                                                         
                                                        <th class="align-middle">Action</th>
                                                        <th class="align-middle">Call Date</th>
                                                        <th class="align-middle">Customer</th>
                                                        <th class="align-middle">Call Type</th>
                                                        <th class="align-middle">Call Back</th>
                                                        <th class="align-middle">Call Direction</th>
                                                        <th class="align-middle">Conversation</th>
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
            hitURL = "<?php echo base_url() ?>admin/customer_call/delete",
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
            "url": "<?php echo site_url('user/customer_call/ajax_list')?>",
            "type": "POST",
            "data":{assign_to:"<?php echo $this->session->userdata('userId');?>"}
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