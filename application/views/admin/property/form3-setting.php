<div class="row">
    <div class="col-sm-6">
        <!--Street Address-->         
        <div class="form-group">
            <label for="street_address">Street Address</label>
            <input type="text" id="street_address" name ="street_address" class="form-control" placeholder="Enter Street Address" value="<?php echo isset($edit_data->street_address)?$edit_data->street_address:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
    <div class="col-sm-6">
        <!--Zip/Postal Code-->         
        <div class="form-group">
            <label for="zip">Zip/Postal Code</label>
            <input type="text" id="zip" name ="zip" class="form-control" placeholder="Enter Zip/Postal Code" value="<?php echo isset($edit_data->zip)?$edit_data->zip:'' ?>"  >
        </div> 
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-6">
        <!--mark properties-->         
        <div class="form-group">
            <label >Do you want to mark this property as featured?</label><br/>
            <label for="mark_properties" ><input type="radio" id="mark_properties" name ="mark_properties" value="1" <?php echo (isset($edit_data->mark_properties) && $edit_data->mark_properties == 1)?'checked':'' ?> > Yes</label>&nbsp;&nbsp;&nbsp;
            <label for="mark_properties1" ><input type="radio" id="mark_properties1" name ="mark_properties" value="0" <?php echo (isset($edit_data->mark_properties) && $edit_data->mark_properties == 0)?'checked':'' ?> > No</label>
        </div>
    </div><!--// col-sm-6-->

    <div class="col-sm-6">
        <!--mark properties-->         
        <div class="form-group">
            <label >The user must be logged in to view this property?</label><br/>
            <label for="must_logged" ><input type="radio" id="must_logged" name ="must_logged" value="1" <?php echo (isset($edit_data->must_logged) && $edit_data->must_logged == 1)?'checked':'' ?> > Yes</label>&nbsp;&nbsp;&nbsp;
            <label for="must_logged1" ><input type="radio" id="must_logged1" name ="must_logged" value="0" <?php echo (isset($edit_data->must_logged) && $edit_data->must_logged == 0)?'checked':'' ?> > No</label>
        </div>
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-12">
        <!--Desclaimer-->         
        <div class="form-group">
            <label for="desclaimer">Desclaimer</label>
            <textarea rows="3" id="desclaimer" name ="desclaimer" class="form-control" placeholder="Enter Desclaimer"  ><?php echo isset($edit_data->desclaimer)?$edit_data->desclaimer:'' ?></textarea>
        </div> 
    </div><!--// col-sm-12-->
</div>
