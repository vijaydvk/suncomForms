$(document).ready(function () { 
	var counter = 2;
	var clover_counter = 2;
	var rma_counter = 2;
	var register_counter = 2
	var storesDetails = [];
	var districtDetailsForDropDowJSON = [];
	var storeManagerForDropDownJSON = [];
	var SMDMForDropDownJSON = [];
	$.when(getStoreForDropdown()).done(function(){	
		$.when(getDistrictDetailsForDropDown()).done(function(){
			$.when(getStoreManagerForDropDown()).done(function(){
				dispDropDown();
				$.when(getSMDMForDropDown()).done(function(){
					selectDropDown();
				});
			});
		});
		$('[data-toggle="tooltip"]').tooltip();
	});
	
	function getStoreForDropdown()
	{
		return $.ajax({
			url:'controller/index1.php?action=getStoreForDropdown&store_id='+$('#store_id').val(),
			type:'POST',
			success:function(data){
				storesDetails = $.parseJSON(data);     
        },		
		error: function() {
			console.log("market - getStoreForDropdown - Error - line 16"); 
			console.log('something bad happened'); }
		}) ;
	}

	function getDistrictDetailsForDropDown()
	{
		return $.ajax({
			url:'controller/index1.php?action=getDistrictDetailsForDropDown',
			type:'POST',
			success:function(data){
				districtDetailsForDropDowJSON = $.parseJSON(data);     
        },		
		error: function() {
			console.log("market - getDistrictDetailsForDropDown - Error - line 34"); 
			console.log('something bad happened'); }
		}) ;
	}
	function getStoreManagerForDropDown()
	{
		return $.ajax({
			url:'controller/index1.php?action=getStoreManagerForDropDown',
			type:'POST',
			success:function(data){
				storeManagerForDropDownJSON = $.parseJSON(data);     
        },		
		error: function() {
			console.log("market - getStoreManagerForDropDown - Error - line 47"); 
			console.log('something bad happened'); }
		}) ;
	}
	
	function getSMDMForDropDown()
	{
		return $.ajax({
			url:'controller/index1.php?action=getSMDMForDropDown&store_id='+$('#store_id').val(),
			type:'POST',
			success:function(data){
				SMDMForDropDownJSON = $.parseJSON(data);     
        },		
		error: function() {
			console.log("market - getSMDMForDropDown - Error - line 72"); 
			console.log('something bad happened'); }
		}) ;		
	}
	
	function dispDropDown()
	{
		var index;
		$('#store_location').html('');
		//$("#store_location").append('<option value="" selected>-- Please Select One --</option>');
		$("#current_manager").append('<option value="" selected>-- Please Select One --</option>');
		$("#new_manager").append('<option value="" selected>-- Please Select One --</option>');
		$("#district_manager").append('<option value="" selected>-- Please Select One --</option>');		
		//for(index=0;index < storesForDropDownJSON.length;index++)
		//{
			//$("#store_location").append('<option value="' + storesForDropDownJSON[index].store_id + '">' + storesForDropDownJSON[index].store_name + '</option>');
		//}
		for(index=0;index < storeManagerForDropDownJSON.length;index++)
		{
			$("#current_manager").append('<option value="' + storeManagerForDropDownJSON[index].uid + '">' + storeManagerForDropDownJSON[index].name + '</option>');
			$("#new_manager").append('<option value="' + storeManagerForDropDownJSON[index].uid + '">' + storeManagerForDropDownJSON[index].name + '</option>');
		}
		for(index=0;index < districtDetailsForDropDowJSON.length;index++)
		{
			$("#district_manager").append('<option value="' + districtDetailsForDropDowJSON[index].id + '">' + districtDetailsForDropDowJSON[index].name + '</option>');
		}
		$('#store_address').html(storesDetails[0].store_address+","+storesDetails[0].store_city+","+storesDetails[0].store_state+" "+storesDetails[0].store_zip +"<br>"
									+"UID: "+storesDetails[0].store_uid+"<br>"+storesDetails[0].store_phone+"<br>"+storesDetails[0].store_email);
									
		$('#store_image').attr("src","http://www.mysuncomportal.com/"+storesDetails[0].store_image);
	}
	
/* 	$('#hard_count_number').blur(function(){
		var dynamic_form = "";
		var loop_count = $('#hard_count_number').val();
		for (i=0;i<loop_count;i++)
		{
			dynamic_form = dynamic_form + '<div class="col-lg-6" style="float:left;"><div class="form-group-material"><input id="imei'+i+'" type="text" name="imei'+i+'" required="" placeholder="IMEI" class="input-material"></div></div><div class="col-lg-6" style="float:left;"><div class="form-group-material"><input id="reasonmissing'+i+'" type="text" name="reasonmissing'+i+'" required="" placeholder="Reason" class="input-material"></div></div>';	
		}
		//console.log(dynamic_form);
		$('#IMEI_View').html(dynamic_form);
	}); */
	
	$('#radioBtn a').on('click', function(){
		var sel = $(this).data('title');
		var tog = $(this).data('toggle');
		$('#'+tog).prop('value', sel);
		
		$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
		$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
	});
	
	$(document).mouseover(function(){
		$(this).focus();
	});
	$('input').mousemove(function(){
		$(this).focus();
	});
	
	  $(".num").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	
	$('#save_images').click(function(){
		console.log( $("#old_manager_signature").jSignature("getData"));
		console.log( $("#new_manager_signature").jSignature("getData"));
		console.log( $("#district_manager_signature").jSignature("getData"));
	});	
	
	$('#save_images').click(function(e){
		var image_signature = $("#old_manager_signature").jSignature("getData");
		request = $.ajax({
			url: 'index.php',
			data: {"action": "saveHanoff","mode":"insert","image_signature":image_signature	},
			type: 'POST',
		});
		request.done(function (response){
		
		});
		request.fail(function ( jqXHR, textStatus, errorThrown)
		{

		}); 
	});

	$('#phone_missing_imei_add').click(function(){
		var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'IMEI_View' + counter);
		 	newTextBoxDiv.after().html('<div class="col-lg-6" style="float:left;">'+
							'<div class="form-group-material">'+
								'<input id="imei[]" type="text" name="imei[]" required="" placeholder="IMEI" class="input-material">'+
							'</div>'+
						'</div>'+
						'<div class="col-lg-6" style="float:left;">'+
							'<div class="form-group-material">'+
								'<input id="reasonmissing[]" type="text" name="reasonmissing[]" required="" placeholder="Reason" class="input-material">'+
							'</div>'+
						'</div>');
            
		newTextBoxDiv.appendTo("#phone_missing_div");

					
		counter++;
	});
	
	$('#phone_missing_imei_remove').click(function(){
		counter--;			
        $("#IMEI_View" + counter).remove();
	});

	$('#clover_devices_add').click(function(){
		var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'CLOVER_View' + clover_counter)
		 .attr("class","col-md-12");
		 	newTextBoxDiv.after().html('<div class="col-lg-6" style="float:left;">'+
										'<div class="form-group-material">'+
										  '<input id="clover_device_imei[]" name="clover_device_imei[]" required="" placeholder="" class="input-material" type="text">'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-6" style="float:left;">'+
										'<div class="form-group-material">'+
										  '<input id="clover_device_reason[]" name="clover_device_reason[]" required="" placeholder="" class="input-material" type="text">'+
										'</div>'+
									'</div>');
            
		newTextBoxDiv.appendTo("#Clover_Devices_Div");					
		clover_counter++;
	});
	
	$('#clover_devices_remove').click(function(){
		clover_counter--;			
        $("#CLOVER_View" + clover_counter).remove();
	});
	
	$('#rma_add').click(function(){
		var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'RMA_View' + rma_counter)
		 .attr("class","col-md-12");
		 	newTextBoxDiv.after().html('<div class="col-lg-6" style="float:left;">'+
										'<div class="form-group-material">'+
										  '<input id="rma_imei[]" name="rma_imei[]" required="" placeholder="" class="input-material" type="text">'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-6" style="float:left;">'+
										'<div class="form-group-material">'+
										  '<input id="rma_reason[]" name="rma_reason[]" required="" placeholder="" class="input-material" type="text">'+
										'</div>'+
									'</div>');
            
		newTextBoxDiv.appendTo("#RMA_Div");					
		rma_counter++;
	});
	
	$('#rma_remove').click(function(){
		rma_counter--;			
        $("#RMA_View" + rma_counter).remove();
	});	
	
	$('#register_add').click(function(){
		var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'Register_view' + register_counter)
		 .attr("class","col-md-12");
		 	newTextBoxDiv.after().html('<div class="col-lg-4" style="float:left;padding-top:15px;">'+
							'<h3 class="h6" style="text-align:left;">Register #'+register_counter+'</h3>'+
							'</div>'+
							'<div class="col-lg-4" style="float:left;">'+
								'<div class="form-group-material">'+
								  '<input id="register_amt[]" name="register_amt[]" required="" placeholder="amount" class="input-material" type="text">'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-4" style="float:left;">'+
								'<div class="form-group-material">'+
								 '<input id="register_comments[]" name="register_comments[]" required="" placeholder="comments" class="input-material" type="text">'+
								'</div>'+
							'</div>');
            
		newTextBoxDiv.appendTo("#Register_Div");					
		register_counter++;
	});
	
	$('#register_remove').click(function(){
		if(register_counter>2)
		{		
			register_counter--;			
			$("#Register_view" + register_counter).remove();
		}
	});
	
	function selectDropDown()
	{
		$('#current_manager').val(SMDMForDropDownJSON[0].RSM_ID);  
		$('#district_manager').val(SMDMForDropDownJSON[0].DM_ID); 
		//$('#current_manager').prop('disabled', 'disabled');
		//$('#district_manager').prop('disabled', 'disabled');
		var dm_img_src = "img/"+SMDMForDropDownJSON[0].DM_ID+".png";
		var om_img_src = "img/"+SMDMForDropDownJSON[0].RSM_ID+".png";
		$("#old_manager_img").bind("error", function () {
			//console.log("error");
		}).attr("src", om_img_src);
		$("#old_manager_img").bind("load", function () {
			$('#old_manager_signature_div').hide();
			$('#old_manager_signature_div_img').show();
		}).attr("src", om_img_src);	
		$("#district_manager_img").bind("error", function () {
			//console.log("error");
		}).attr("src", dm_img_src);
		$("#district_manager_img").bind("load", function () {
			$('#district_manager_signature_div').hide();
			$('#district_manager_signature_div_img').show();
		}).attr("src", dm_img_src);			
	}
	
	$('#save_button').click(function (){
		
		

		var hardcount_imei = [];
		$("input[name='imei[]']").each(function() {
			hardcount_imei.push($(this).val());
		});
		
		
		var hardcount_reason = [];
		$("input[name='reasonmissing[]']").each(function() {
			hardcount_reason.push($(this).val());
		});
		
		var clover_device_imei = [];
		$("input[name='clover_device_imei[]']").each(function() {
			clover_device_imei.push($(this).val());
		});		
		
		var clover_device_reason = [];
		$("input[name='clover_device_reason[]']").each(function() {
			clover_device_reason.push($(this).val());
		});

		var rma_imei = [];
		$("input[name='rma_imei[]']").each(function() {
			rma_imei.push($(this).val());
		});
		
		
		var rma_reason = [];
		$("input[name='rma_reason[]']").each(function() {
			rma_reason.push($(this).val());
		});	

		var register_amt = [];
		$("input[name='register_amt[]']").each(function() {
			register_amt.push($(this).val());
		});
		
		
		var register_comments = [];
		$("input[name='register_comments[]']").each(function() {
			register_comments.push($(this).val());
		});		

 		var form = $('#handoff_form')[0];
		var formdata = new FormData(form);
		if ($("#old_manager_signature_div").css('display') === 'block') {
			   formdata.append("oldmgr_sig",$("#old_manager_signature").jSignature("getData"));
			}
		if ($("#district_manager_signature_div").css('display') === 'block') {
			   formdata.append("dmgr_sig",$("#district_manager_signature").jSignature("getData"));
			   //console.log($("#district_manager_signature").jSignature("getData"));
			}
		if ($("#new_manager_signature_div").css('display') === 'block') {
			   formdata.append("nmgr_sig",$("#new_manager_signature").jSignature("getData"));
			   //console.log($("#district_manager_signature").jSignature("getData"));
			}	
		//if(hardcount_imei.length>1 && hardcount_reason.length>1)
		//{
			//console.log("here");
			formdata.append("hardcount_imei",hardcount_imei);
			formdata.append("hardcount_reason",hardcount_reason);
			formdata.append("clover_device_imei",clover_device_imei);
			formdata.append("clover_device_reason",clover_device_reason);
			formdata.append("rma_imei",rma_imei);
			formdata.append("rma_reason",rma_reason);
			formdata.append("register_amt",register_amt);
			formdata.append("register_comments",register_comments);			
			
		//}
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url: 'index.php?action=saveHanoff&mode=insert',
			data: formdata,
			processData: false,
			contentType: false,
			//dataType: 'json',
			cache: false,
			timeout: 600000,
			success: function(){
			},
		});	 
		
	});
	
	$('#new_manager').change(function()
	{
		//console.log($('#new_manager').val());
		var nm_img_src = "img/"+$('#new_manager').val()+".png";		
		$("#new_manager_img").bind("error", function () {
			//console.log("error");
		}).attr("src", nm_img_src);
		$("#new_manager_img").bind("load", function () {
			$('#new_manager_signature_div').hide();
			$('#new_manager_signature_div_img').show();
		}).attr("src", nm_img_src);	
	});
	
});
						
							
                              
                              
                            
						
						
							