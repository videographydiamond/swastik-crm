<div class="row">
    <div class="col-sm-12">
        <!--slider display-->         
        <div class="form-group">
            <label >Do you want to display this property on the custom property slider?</label><br/>
            <label for="diplay_slider1" ><input type="radio" id="diplay_slider1" name ="diplay_slider" value="1" <?php echo (isset($edit_data->diplay_slider) && $edit_data->diplay_slider == "1")?'checked':'' ?> > Yes</label>&nbsp;&nbsp;&nbsp;
            <label for="diplay_slider2" ><input type="radio" id="diplay_slider2" name ="diplay_slider" value="2" <?php echo (isset($edit_data->diplay_slider) && $edit_data->diplay_slider == "2")?'checked':'' ?> > No</label>
            <br/><small>Upload an image below if you selected yes.</small>
        </div> 
    </div><!--// col-sm-12-->

    <div class="col-sm-12">
        <!--Upload slider image-->         
        <div class="form-group">
            <label for="slider_image">Upload slider image</label>
            <img src="<?php echo isset($edit_data->slider_img)?base_url('uploads/property/').$edit_data->slider_img:''; ?>" class="img-responsive" >
            <input type="hidden" name="slider_img_old" value="<?php echo isset($edit_data->slider_img)?$edit_data->slider_img:''; ?>"  >
            <input type="file" id="slider_image" name ="slider_image" class="form-control" >
            <small>Suggested size 2000px x 700px</small>
        </div> 
    </div><!--// col-sm-12-->
    
</div>

