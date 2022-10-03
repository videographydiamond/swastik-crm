/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "members/deletemember",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
        
	jQuery(document).on("click", ".deleteEvent", function(){
		var id = $(this).data("eventid"),
			hitURL = baseURL + "events/deleteevent",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
        
        jQuery(document).on("click", ".deleteOrg", function(){
		var id = $(this).data("orgid"),
			hitURL = baseURL + "organizarions/deleteorg",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this organization ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("organization successfully deleted"); }
				else if(data.status = false) { alert("organization deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});


        jQuery(document).on("click", ".deleteAds", function(){
		var id = $(this).data("orgid"),
			hitURL = baseURL + "ads/deleteads",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this ads ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Ads successfully deleted"); }
				else if(data.status = false) { alert("Ads deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
        
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
