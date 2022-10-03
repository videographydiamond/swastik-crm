<div class="row">
    <div class="col-sm-6">
        <!--price-->         
        <div class="form-group">
            <label for="price">Sale or Rent Price <span class="text-danger"> *</span></label>
            <input type="text" id="price" name ="price" class="form-control" required placeholder="Enter the price" value="<?php echo isset($edit_data->price)?$edit_data->price:'' ?>" >
        </div> 

        <!--Second Price-->         
        <div class="form-group">
            <label for="second_price">Second Price <small> (Optional) </small></label>
            <input type="text" id="second_price" name ="second_price" class="form-control" placeholder="Enter Second Price" value="<?php echo isset($edit_data->second_price)?$edit_data->second_price:'' ?>" >
        </div>
        
        <!--Price Prefix-->         
        <div class="form-group">
            <label for="price_prefix">Price Prefix<small> (For Example: Start From) </small></label>
            <input type="text" id="price_prefix" name ="price_prefix" class="form-control" placeholder="Enter Price Prefix" value="<?php echo isset($edit_data->price_prefix)?$edit_data->price_prefix:'' ?>"  >
        </div>

        <!--After The Price-->         
        <div class="form-group">
            <label for="price_suffix">After The Price<small> (For Example: Monthly) </small></label>
            <input type="text" id="price_suffix" name ="price_suffix" class="form-control" placeholder="Enter After The Price" value="<?php echo isset($edit_data->price_suffix)?$edit_data->price_suffix:'' ?>" >
        </div>

        <!--Area Size-->         
        <div class="form-group">
            <label for="area_size">Area Size<span class="text-danger"> *</span></label>
            <input type="text" id="area_size" name ="area_size" class="form-control onlyNumer" placeholder="Enter Area Size" value="<?php echo isset($edit_data->area_size)?$edit_data->area_size:'' ?>" >
        </div>

        <!--Area Size Postfix-->         
        <div class="form-group">
            <label for="area_size_postfix">Area Size Postfix<small> (For example: Sq Ft) </small></label>
            <input type="text" id="area_size_postfix" name ="area_size_postfix" class="form-control" placeholder="Enter Area Size Postfix" value="<?php echo isset($edit_data->area_size_postfix)?$edit_data->area_size_postfix:'' ?>" >
        </div>

        <!--Land Area-->         
        <div class="form-group">
            <label for="land_area">Land Area</label>
            <input type="text" id="land_area" name ="land_area" class="form-control onlyNumer" placeholder="Enter Land Area" value="<?php echo isset($edit_data->land_area)?$edit_data->land_area:'' ?>" >
        </div>

        <!--Land Area Size Postfix-->         
        <div class="form-group">
            <label for="land_area_size_postfix">Land Area Size Postfix<small> (For example: Sq Ft) </small></label>
            <input type="text" id="land_area_size_postfix" name ="land_area_size_postfix" class="form-control" placeholder="Enter Land Area Size Postfix" value="<?php echo isset($edit_data->land_area_size_postfix)?$edit_data->land_area_size_postfix:'' ?>" >
        </div>

    </div><!--// col-sm-6-->
    <div class="col-sm-6">
        <!--Rooms-->         
        <div class="form-group">
            <label for="rooms">Rooms</label>
            <input type="text" id="rooms" name ="rooms" class="form-control onlyNumer" placeholder="Enter Rooms" value="<?php echo isset($edit_data->rooms)?$edit_data->rooms:'' ?>"  >
        </div>

        <!--Bedrooms-->         
        <div class="form-group">
            <label for="bedrooms">Bedrooms</label>
            <input type="text" id="bedrooms" name ="bedrooms" class="form-control onlyNumer" placeholder="Enter Bedrooms" value="<?php echo isset($edit_data->bedrooms)?$edit_data->bedrooms:'' ?>" >
        </div>
        

        <!--Bathrooms-->         
        <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <input type="text" id="bathrooms" name ="bathrooms" class="form-control onlyNumer" placeholder="Enter Bathrooms" value="<?php echo isset($edit_data->bathrooms)?$edit_data->bathrooms:'' ?>" >
        </div>
        <!--Garages-->         
        <div class="form-group">
            <label for="garages">Garages</label>
            <input type="text" id="garages" name ="garages" class="form-control onlyNumer" placeholder="Enter Garages" value="<?php echo isset($edit_data->garages)?$edit_data->garages:'' ?>" >
        </div>
        <!--Garage Size-->         
        <div class="form-group">
            <label for="garage_size">Garage Size</label>
            <input type="text" id="garage_size" name ="garage_size" class="form-control onlyNumer" placeholder="Enter Garage Size"  value="<?php echo isset($edit_data->garage_size)?$edit_data->garage_size:'' ?>" >
        </div>
        <!--Year Built-->         
        <div class="form-group">
            <label for="year_built">Year Built</label>
            <input type="text" id="year_built" name ="year_built" class="form-control onlyNumer" placeholder="Enter Year Built" value="<?php echo isset($edit_data->year_built)?$edit_data->year_built:'' ?>" >
        </div>

        <!--Property ID-->         
        <div class="form-group">
            <label for="property_id">Property ID<small> (For Example: RC-42)</small></label>
            <input type="text" id="property_id" name ="property_id" class="form-control onlyNumer" placeholder="Enter Property ID" value="<?php echo isset($edit_data->property_id)?$edit_data->property_id:'' ?>" >
        </div>

       
    </div><!--// col-sm-6-->
</div>