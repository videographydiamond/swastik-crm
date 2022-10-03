<h5 class="card-title mb-3">Call Details</h5>
                                        <form action="<?php echo base_url() ?>admin/customer_call/insertnow" method="post" role="form" enctype="multipart/form-data" >
                                             
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" id="customer" name="customer" aria-label="Floating label select example">
                                                              
                                                            <?php
                                                                if(!empty($all_customers))
                                                                {
                                                                    foreach ($all_customers as $customer) {
                                                                        ?>
<option value="<?php echo $customer->id;?>" <?php if(isset($edit_data->id) && $customer->id ==$edit_data->id){ echo "selected";}?>><?php echo $customer->sku_id;?> <?php echo $customer->customer_title;?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label for="customer">Choose Farmers <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" id="call_type" name="call_type" aria-label="Floating label select example">
                                                            <option value="" selected>Call Type</option>
                                                            <?php
                                                                if(!empty($calltypes))
                                                                {
                                                                    foreach ($calltypes as $calltype) {
                                                                        ?>
                                                                        <option value="<?php echo $calltype->id;?>"><?php echo $calltype->title;?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label for="call_type">Call Type <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                 
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" id="assign_to" name="assign_to" aria-label="Floating label select example">
                                                            <option value="" selected>Assign To</option>
                                                              <?php
                                                                if(!empty($all_users))
                                                                {
                                                                    foreach ($all_users as $user) {
                                                                        ?>
                                                                        <option value="<?php echo $user->id;?>" ><?php echo $user->sku_id;?> <?php echo $user->title;?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label for="assign_to">Assign To <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="date" class="form-control" id="call_back_date" name="call_back_date" placeholder="Call Back Date">
                                                        <label for="call_back_date">Call Back Date <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                 
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" id="call_direction" name="call_direction" aria-label="Floating label select example">
                                                            <option value="" selected>Call Direction</option>
                                                             <?php
                                                                if(!empty($calldirections))
                                                                {
                                                                    foreach ($calldirections as $calldirection) {
                                                                        ?>
                                                                        <option value="<?php echo $calldirection->id;?>"><?php echo $calldirection->title;?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label for="call_direction">Call Direction <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                            <div class="row">
                                                 
                                                <div class="col-md-12">
                                                     
                                                    <div class="form-floating mb-3">
                                                        <textarea   class="form-control" id="current_conversation" name="current_conversation" placeholder="Current Conversation" required ></textarea> 
                                                        <label for="current_conversation">Current Conversation <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                            <div>

                                                

                                                 <input type="hidden" name="id" value="<?php if(isset($edit_data->id)){echo $edit_data->id;} ?>"/>
                                                <button type="submit" class="btn btn-primary w-md">Save Call</button>
                                            </div>
                                        </form>