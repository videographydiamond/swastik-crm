<div class="row">
    <div class="col-sm-12">
       <!--Contact Info-->         
        <div class="form-group contactInfoInput">
            <label >What information do you want to display in agent data container?</label><br/>
            <label for="contact_info1" ><input type="radio" id="contact_info1" name ="contact_info" value="aurthor" <?php echo (isset($edit_data->contact_info) && $edit_data->contact_info == "aurthor")?'checked':'' ?> > Author Info</label><br/>
            <label for="contact_info2" ><input type="radio" id="contact_info2" name ="contact_info" value="agent" <?php echo (isset($edit_data->contact_info) && $edit_data->contact_info == "agent")?'checked':'' ?> > Agent Info (Choose agent from the list below)</label><br/>
            <label for="contact_info3" ><input type="radio" id="contact_info3" name ="contact_info" value="agency" <?php echo (isset($edit_data->contact_info) && $edit_data->contact_info == "agency")?'checked':'' ?> > Agency Info (Choose agency from the list below)</label><br/>
            <label for="contact_info4" ><input type="radio" id="contact_info4" name ="contact_info" value="dontdisplay" <?php echo (isset($edit_data->contact_info) && $edit_data->contact_info == "dontdisplay")?'checked':'' ?>> Don't Display</label><br/>
           
        </div>
    </div><!--// col-sm-12-->
</div>

<div class="row contactInfoSelectCon agentCon <?php echo (isset($edit_data->contact_info) && $edit_data->contact_info == "agent")?'':'hidden' ?> ">
    <div class="col-sm-12">
      	<!--agent-->                             
        <div class="form-group">
            <label for="contact_info_agent_id">Select Agent </label>
            <select class="form-control" name="contact_info_agent_id" id="contact_info_agent_id"  >
                <option value="0" >None</option>
                <?php foreach($agentList as $k=>$v){ ?>
                <option value="<?php echo $v->id;?>" <?php echo (isset($edit_data->contact_info_agent_id) && $edit_data->contact_info_agent_id ==  $v->id )?'selected':''; ?> ><?php echo $v->name;?></option>
                 <?php } ?>
            </select>
        </div> 
    </div><!--// col-sm-12-->
</div>
<div class="row contactInfoSelectCon agencyCon <?php echo (isset($edit_data->contact_info) && $edit_data->contact_info == "agency")?'':'hidden' ?> ">
    <div class="col-sm-12">
      	<!--agency-->                             
        <div class="form-group">
            <label for="contact_info_agency_id">Select Agency </label>
            <select class="form-control" name="contact_info_agency_id" id="contact_info_agency_id"  >
                <option value="0" >None </option>
                <?php foreach($agencyList as $k=>$v){ ?>
                <option value="<?php echo $v->id;?>" <?php echo (isset($edit_data->contact_info_agency_id) && $edit_data->contact_info_agency_id ==  $v->id )?'selected':''; ?>  ><?php echo $v->name;?></option>
                 <?php } ?>
            </select>
        </div> 
    </div><!--// col-sm-12-->
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('input:radio[name="contact_info"]').change(
	    function(){
	        if ($(this).is(':checked') && ( $(this).val() == 'agency' || $(this).val() == 'agent'))  {
	            $(".contactInfoSelectCon").addClass("hidden");
	            $("."+$(this).val()+"Con").removeClass("hidden");
	        }
	    });
	});
</script>