<div class="row">
    <div class="col-sm-12">
        <!--Plan Title-->         
        <div class="form-group">
            <label for="floor_plan_title">Plan Title</label>
            <input type="text" id="floor_plan_title" name ="floor_plan_title" class="form-control" placeholder="Enter Plan Title"  value="<?php echo isset($edit_data->floor_plan_title)?$edit_data->floor_plan_title:'' ?>"  >
        </div> 
    </div><!--// col-sm-12-->
   
</div>

<div class="row">
    <div class="col-sm-6">
        <!--Bedrooms-->         
        <div class="form-group">
            <label for="floor_plan_bedrooms">Bedrooms</label>
            <input type="text" id="floor_plan_bedrooms" name ="floor_plan_bedrooms" class="form-control" placeholder="Enter Number Of Bedrooms"  value="<?php echo isset($edit_data->floor_plan_bedrooms)?$edit_data->floor_plan_bedrooms:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
    <div class="col-sm-6">
        <!--Bathrooms-->         
        <div class="form-group">
            <label for="floor_plan_bathrooms">Bathrooms</label>
            <input type="text" id="floor_plan_bathrooms" name ="floor_plan_bathrooms" class="form-control" placeholder="Enter Number Of Bathrooms"  value="<?php echo isset($edit_data->floor_plan_bathrooms)?$edit_data->floor_plan_bathrooms:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-6">
        <!--Price-->         
        <div class="form-group">
            <label for="floor_plan_price">Price</label>
            <input type="text" id="floor_plan_price" name ="floor_plan_price" class="form-control" placeholder="Enter Number Of Price"  value="<?php echo isset($edit_data->floor_plan_price)?$edit_data->floor_plan_price:'' ?>"  >
        </div> 
    </div><!--// col-sm-6-->
    <div class="col-sm-6">
        <!--Price Postfix-->         
        <div class="form-group">
            <label for="floor_plan_price_postfix">Price Postfix</label>
            <input type="text" id="floor_plan_price_postfix" name ="floor_plan_price_postfix" class="form-control" placeholder="Enter Number Of Price Postfix"  value="<?php echo isset($edit_data->floor_plan_price_postfix)?$edit_data->floor_plan_price_postfix:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-6">
        <!--Plan Size-->         
        <div class="form-group">
            <label for="floor_plan_size">Plan Size</label>
            <input type="text" id="floor_plan_size" name ="floor_plan_size" class="form-control" placeholder="Enter Number Of Plan Size"  value="<?php echo isset($edit_data->floor_plan_size)?$edit_data->floor_plan_size:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
    <div class="col-sm-6">
        <!--Plan Image-->         
        <div class="form-group">
            <label for="floor_plan_img">Plan image</label>
            <input type="file" id="floor_plan_img" name ="floor_plan_img" class="form-control" >
            <input type="hidden" name="floor_plan_img_old" value="<?php echo isset($edit_data->floor_plan_img)?$edit_data->floor_plan_img:'' ?>" >
            <small>Suggested size 800px x 600px</small>
        </div> 
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-12">
        <!--Floor Plan Description-->         
        <div class="form-group">
            <label for="floor_plan_description">Floor Plan Description</label>
            <textarea rows="4" id="floor_plan_description" name ="floor_plan_description" class="form-control" placeholder="Enter Floor Plan Description"  ><?php echo isset($edit_data->floor_plan_description)?$edit_data->floor_plan_description:'' ?></textarea>
        </div> 
    </div><!--// col-sm-12-->
</div>
