<?php 
if(isset($edit_data->media)){
    $media = json_decode($edit_data->media,true);

}
?>
<div class="row mediaConUploadFile">
     <?php 
    if(isset($media) & !empty($media)){
    foreach($media as $k=>$v){ ?>
    <div class="col-sm-4 editMedia" id="media_id<?php echo $k?>" >
        <div class="form-group">
            <label for="media<?php echo $k?>">Upload Media</label>
            <img src="<?php echo base_url('uploads/property/').$v; ?>" class="img-responsive" >
            <span class="mediaCloseBtn" data-target="#media_id<?php echo $k?>" >x</span>
            <input type="hidden" name="media_old[]" value="<?php echo $v ?>"  >
            <!-- <input type="file" id="media<?php echo $k?>" name ="media<?php echo $k?>" class="form-control" > -->
        </div> 
    </div><!--// col-sm-4-->
    <?php }}else{ ?>
    <div class="col-sm-4">
        <!--Upload Media-->         
        <div class="form-group">
            <label for="media0">Upload Media</label>
            <input type="file" id="media0" name ="media0" class="form-control" >
        </div> 
    </div><!--// col-sm-4-->
    <?php } ?>
</div>

<div class="row">
    <div class="col-sm-4">
        <!--Upload Media-->         
        <div class="form-group">
            <button type="button" id="addMoreMedia" class="btn btn-primary"  >Add More Media +</button>
        </div> 
    </div><!--// col-sm-6-->
</div>

<div class="row">
    <div class="col-sm-12">
        <!--Video Url-->         
        <div class="form-group">
            <label for="video_url">Video Url</label>
            <input type="text" id="video_url" name ="video_url" class="form-control" placeholder="Enter Video Url"  value="<?php echo isset($edit_data->video_url)?base64_decode($edit_data->video_url):'' ?>"  >
            <label><small></small><b>For example</b> https://www.youtube.com/watch?v=49d3Gn4541IaA</label>
        </div> 
    </div><!--// col-sm-6-->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        window.count = 1;
        //var ext = "<?php echo isset($edit_data)?'s':'' ?>";
        $("#addMoreMedia").click(function(){
            var file = '<div class="col-sm-4"><div class="form-group"><label for="media">Upload Media</label><input type="file" id="media'+window.count+'" name ="media'+window.count+'" class="form-control" ></div> </div>';
            $(".mediaConUploadFile").append(file);
            window.count++;
        });

        // delete image
        $(".mediaCloseBtn").click(function(){
            var delitem = $(this).attr("data-target");
            $(delitem).remove();   
        });
    });    
</script>
