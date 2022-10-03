<div class="row">
    <div class="col-sm-12">
        <!--Map-->         
        <div class="form-group">
            <label >Map</label><br/>
            <label for="map_show1" ><input type="radio" id="map_show1" name ="map_show" value="1" <?php echo (isset($edit_data->map_show) && $edit_data->map_show == 1)?'checked':'' ?> > Show</label>&nbsp;&nbsp;&nbsp;
            <label for="map_show2" ><input type="radio" id="map_show2" name ="map_show" value="2" <?php echo (isset($edit_data->map_show) && $edit_data->map_show == 2)?'checked':'' ?> > Hide</label>
        </div>
        <!--Street View-->         
        <div class="form-group">
            <label for="street_view">Street View</label>
            <select id="street_view" name ="street_view" class="form-control" >
              <option value="0" <?php echo (isset($edit_data->street_view) && $edit_data->street_view == 0)?'selected':''; ?> >Hide</option>
              <option value="1" <?php echo (isset($edit_data->street_view) && $edit_data->street_view == 1)?'selected':''; ?> >Show</option>
            </select>
        </div> 
        <!--Address-->         
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name ="address" class="form-control" placeholder="Enter Address" value="<?php echo isset($edit_data->address)?$edit_data->address:'' ?>"  >
        </div> 

        <?php isset($edit_data->address)?str_replace(" ", "%20", $edit_data->address):'Dubai' ?>
        <!--Map-->         
        <div class="form-group">
            <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo isset($edit_data->address)?str_replace(" ", "%20", $edit_data->address):'Dubai' ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org">the avengers 123movies</a></div><style>.mapouter{position:relative;text-align:right;height:300px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:100%;}</style></div>
        </div> 

        
    </div><!--// col-sm-12-->
</div>

<script type="text/javascript">
 $(document).ready(function(){
  $("#address").keyup(function(){
    var address = $(this).val();
    var searchVal =  address.replace(/ /gi, "%20");
    //alert(searchVal);
    var src     = "https://maps.google.com/maps?q="+address+"&t=&z=13&ie=UTF8&iwloc=&output=embed";
    $("#gmap_canvas").attr("src",src);

  });
 });
</script>