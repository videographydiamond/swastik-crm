<div class="row">
    <div class="col-sm-12">
        <!--360° Virtual Tour-->         
        <div class="form-group">
            <label for="virtual_url">360° Virtual Tour</label>
            <textarea rows="4" id="virtual_url" name ="virtual_url" class="form-control" placeholder="Enter virtual tour iframe/embeded code"  ><?php echo isset($edit_data->virtual_url)?base64_decode($edit_data->virtual_url):'' ?></textarea>
        </div> 
    </div><!--// col-sm-12-->
</div>
