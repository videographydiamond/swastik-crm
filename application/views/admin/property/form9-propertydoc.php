<?php 
if(isset($edit_data->document)){
    $document = json_decode($edit_data->document,true);

}
?>
<div class="row documentConUploadFile">
    <?php 
    if(isset($document) & !empty($document)){
    foreach($document as $k=>$v){ ?>
    <div class="col-sm-4 editdocument" id="document_id<?php echo $k?>" >
        <div class="form-group">
            <label for="document<?php echo $k?>">Document</label><br/>
            <span> <?php echo $v; ?></span>
            <span class="mediaCloseBtn documentCloseBtn" data-target="#document_id<?php echo $k?>" >x</span>
            <input type="hidden" name="document_old[]" value="<?php echo $v ?>"  >
            <!-- <input type="file" id="document<?php echo $k?>" name ="document<?php echo $k?>" class="form-control" > -->
        </div> 
    </div><!--// col-sm-4-->
    <?php }}else{ ?>
    <div class="col-sm-4">
        <!--Upload Document-->         
        <div class="form-group">
            <label for="document0">Property Documents</label>
            <input type="file" id="document0" name ="document0" class="form-control" >
        </div> 
    </div><!--// col-sm-4-->
    <?php } ?>
</div>

<div class="row mt-lg">
    <div class="col-sm-4">
        <!--Upload Document-->         
        <div class="form-group">
            <button type="button" id="addMoreDocument" class="btn btn-primary"  >Add More Document +</button>
        </div> 
    </div><!--// col-sm-6-->
</div>


<script type="text/javascript">
    $(document).ready(function(){
        window.count = 1;
        //var ext = "<?php echo isset($edit_data)?'s':'' ?>";
        $("#addMoreDocument").click(function(){
            var file = '<div class="col-sm-4"><div class="form-group"><label for="document">Upload Document</label><input type="file" id="document'+window.count+'" name ="document'+window.count+'" class="form-control" ></div> </div>';
            $(".documentConUploadFile").append(file);
            window.count++;
        });

        // delete image
        $(".documentCloseBtn").click(function(){
            var delitem = $(this).attr("data-target");
            $(delitem).remove();   
        });
    });    
</script>
