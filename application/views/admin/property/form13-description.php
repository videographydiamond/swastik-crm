<div class="row">
    <div class="col-sm-12">
        <!--Description-->         
        <div class="form-group">
            <label for="descripton">Description</label>
            <small>(Write Property Description)</small>
            <textarea rows="8" id="descripton" name ="descripton" class="form-control myTextEditor" placeholder="Enter Description"  ><?php echo isset($edit_data->descripton)?$edit_data->descripton:'' ?></textarea>
            
        </div> 
    </div><!--// col-sm-12-->
</div>
