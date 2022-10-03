<div class="row">
    <div class="col-sm-6">
        <!--Energy Class-->         
        <div class="form-group">
            <label for="energy_class">Energy Class</label>
            <select class="form-control" name="energy_class" id="energy_class" >
                <option value="A+" <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "A++" )?'selected':''; ?> >A+</option>
                <option value="A"  <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "A" )?'selected':''; ?> >A</option>
                <option value="B"  <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "B" )?'selected':''; ?> >B</option>
                <option value="C"  <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "C" )?'selected':''; ?> >C</option>
                <option value="D" <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "D" )?'selected':''; ?> >D</option>
                <option value="E" <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "D" )?'selected':''; ?> >E</option>
                <option value="F" <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "F" )?'selected':''; ?> >F</option>
                <option value="G" <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "G" )?'selected':''; ?> >G</option>
                <option value="H" <?php echo (isset($edit_data->energy_class) && $edit_data->energy_class == "H" )?'selected':''; ?> >H</option>
            </select>
        </div> 
    </div><!--// col-sm-6-->
    <div class="col-sm-6">
        <!--Global Energy Performance Index-->         
        <div class="form-group">
            <label for="energy_performance">Global Energy Performance Index</label>
            <input type="text" id="energy_performance" name ="energy_performance" class="form-control" placeholder="For example: 92.42 kWh / m²a" value="<?php echo isset($edit_data->energy_performance)?$edit_data->energy_performance:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-6">
       <!--Renewable energy performance index-->         
        <div class="form-group">
            <label for="renewal_energy_performance">Renewable energy performance index</label>
            <input type="text" id="renewal_energy_performance" name ="renewal_energy_performance" class="form-control" placeholder="For example: 00.00 kWh / m²a" value="<?php echo isset($edit_data->renewal_energy_performance)?$edit_data->renewal_energy_performance:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
    <div class="col-sm-6">
        <!--Energy performance of the building-->         
        <div class="form-group">
            <label for="energy_performance_building">Energy performance of the building</label>
            <input type="text" id="energy_performance_building" name ="energy_performance_building" class="form-control" placeholder="Enter Number Of Energy performance of the building" value="<?php echo isset($edit_data->energy_performance_building)?$edit_data->energy_performance_building:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-6">
        <!--EPC Current Rating-->         
        <div class="form-group">
            <label for="epc_current_rating">EPC Current Rating</label>
            <input type="text" id="epc_current_rating" name ="epc_current_rating" class="form-control" placeholder="Enter Number Of EPC Current Rating" value="<?php echo isset($edit_data->epc_current_rating)?$edit_data->epc_current_rating:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->

    <div class="col-sm-6">
        <!--EPC Potential Rating-->         
        <div class="form-group">
            <label for="epc_potential_rating">EPC Potential Rating</label>
            <input type="text" id="epc_potential_rating" name ="epc_potential_rating" class="form-control" placeholder="Enter Number Of EPC Potential Rating" value="<?php echo isset($edit_data->epc_potential_rating)?$edit_data->epc_potential_rating:'' ?>" >
        </div> 
    </div><!--// col-sm-6-->
    
</div>
