<div class="row">
    <div class="col-sm-6">
        <!--Property Top Type-->         
        <div class="form-group">
            <label for="property_top_type">Property Top Type</label>
            <select class="form-control" name="property_top_type" id="property_top_type" >
                <option value="global" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "global" )?'selected':''; ?> >Global</option>
                <option value="virson1" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "virson1" )?'selected':''; ?> >Virson 1</option>
                <option value="virson2" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "virson2" )?'selected':''; ?> >Virson 2</option>
                <option value="virson3" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "virson3" )?'selected':''; ?> >Virson 3</option>
                <option value="virson4" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "virson4" )?'selected':''; ?> >Virson 4</option>
                <option value="virson5" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "virson5" )?'selected':''; ?> >Virson 5</option>
                <option value="virson6" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "virson6" )?'selected':''; ?> >Virson 6</option>
                <option value="virson7" <?php echo (isset($edit_data->property_top_type) && $edit_data->property_top_type == "virson7" )?'selected':''; ?> >Virson 7</option>
            </select>
            <small>Set the property top area type.</small>
        </div> 
    </div><!--// col-sm-6-->

    <div class="col-sm-6">
        <!--Property Content Layout-->         
        <div class="form-group">
            <label for="property_content_layout">Property Content Layout</label>
            <select class="form-control" name="property_content_layout" id="property_content_layout" >
                <option value="global" <?php echo (isset($edit_data->property_content_layout) && $edit_data->property_content_layout == "global" )?'selected':''; ?> >Global</option>
                <option value="default" <?php echo (isset($edit_data->property_content_layout) && $edit_data->property_content_layout == "default" )?'selected':''; ?> >Default</option>
                <option value="tab" <?php echo (isset($edit_data->property_content_layout) && $edit_data->property_content_layout == "tab" )?'selected':''; ?> >Tab</option>
                <option value="tabvertical" <?php echo (isset($edit_data->property_content_layout) && $edit_data->property_content_layout == "tabvertical" )?'selected':''; ?> >Tab Vertical</option>
                
            </select>
            <small>Set property content area type.</small>
        </div> 
    </div><!--// col-sm-6-->
    
</div>
