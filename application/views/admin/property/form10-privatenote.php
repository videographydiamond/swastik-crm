<div class="row">
    <div class="col-sm-12">
        <!--Private Note-->         
        <div class="form-group">
            <label for="private_note">Private Note</label>
            <textarea rows="3" id="private_note" name ="private_note" class="form-control" placeholder="Enter Private Note"  ><?php echo isset($edit_data->private_note)?$edit_data->private_note:'' ?></textarea>
            <small>Write private note for this property, it will not display for public.</small>
        </div> 
    </div><!--// col-sm-12-->
</div>
