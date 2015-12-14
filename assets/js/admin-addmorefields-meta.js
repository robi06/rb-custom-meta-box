jQuery(document).ready(function($) {
	//$( "#accordion" ).accordion();
	$('#uc-add-meta-box').on('click',function(e){

			if($("input.meta-box").val().length === 0){
				$("#addMoreFieldsModal").find("div.addmorefield-error").removeClass("hidden").html("Meta Box name is empty").focus();
				return false;
			}
			if($("input[name='meta-field-key']").val().length === 0 || $("input[name='meta-field-title']").val().length === 0){
				$("#addMoreFieldsModal").find("div.addmorefield-error").removeClass("hidden").html("Meta Field Key or Title field is empty").focus();
				return false;
			}
			e.preventDefault();
	                        var get_all_data = $('#uc-meta-form').serializeArray();

	                        $.ajax({
	                                    url: ajax_object.ajaxurl+'?action=uc_add_meta',
	                                    type: 'POST',
	                                    dataType:"json",
	                                    data: get_all_data,
	                                    success:function(result){
	                                           if(parseInt(result.success) === 1)
	                                           {
	                                           	$("#addMoreFieldsModal").find("div.addmorefield-error").removeClass("alert-warning").removeClass("hidden").addClass("alert-success").html(result.msg).focus();
	                                           	window.location.href=window.location.href;
	                                           }else{
	                                           	$("#addMoreFieldsModal").find("div.addmorefield-error").addClass("alert-warning").removeClass("hidden").removeClass("alert-success").html(result.msg).focus();
	                                           }


	                                           return false;
	                                    }
	                        });
	});

	$(".metabox-dropdown").on("change",function(){
		
		var selectedVal = $(this).find("option:selected").val();
		if(selectedVal === "Add New"){
			marker = jQuery('<span />').insertBefore("input.meta-box");
			$("input.meta-box").detach().attr("type", "text").attr("placeholder", "Meta Box Name").insertAfter(marker).val("").css({"margin-top": "15px"});
			marker.remove(); 
		}else{
			marker = jQuery('<span />').insertBefore("input.meta-box");
			$("input.meta-box").detach().attr("type", "hidden").insertAfter(marker).val(selectedVal);;
			marker.remove(); 
		}
	});
	$(".delete-field").on("click", function(){
		var _meta_key = $(this).attr("meta-key");
		var _meta_box = $(this).attr("meta-box");
		$.ajax({
	                        url: ajax_object.ajaxurl+'?action=uc_delete_meta_field',
	                        type: 'POST',
	                        dataType:"json",
	                        data: {'meta_key':_meta_key, 'meta_box': _meta_box,  "post_type":current_post_type.post_type},
	                        success:function(result){
	                               if(parseInt(result.success) === 1)
	                               {
	                               	$("#addMoreFieldsModal").find("div.addmorefield-error").removeClass("alert-warning").addClass("alert-success").html(result.msg).focus();
	                               	window.location.href=window.location.href;
	                               }else{
	                               	$("#addMoreFieldsModal").find("div.addmorefield-error").addClass("alert-warning").removeClass("alert-success").html(result.msg).focus();
	                               }


			      
	                               return false;
	                        }
		});
		return false;

	});
	$(".delete-metabox").on("click", function(){
		var _meta_box = $(this).attr("box-id");
		$.ajax({
	                        url: ajax_object.ajaxurl+'?action=uc_delete_meta_box',
	                        type: 'POST',
	                        dataType:"json",
	                        data: { 'meta_box': _meta_box, "post_type":current_post_type.post_type},
	                        success:function(result){
	                               if(parseInt(result.success) === 1)
	                               {
	                               	$("#addMoreFieldsModal").find("div.addmorefield-error").removeClass("alert-warning").addClass("alert-success").removeClass("hidden").html(result.msg).focus();
	                               	window.location.href=window.location.href;
	                               }else{
	                               	$("#addMoreFieldsModal").find("div.addmorefield-error").addClass("alert-warning").removeClass("alert-success").removeClass("hidden").html(result.msg).focus();
	                               }
	                               
	                        }
		});
		//window.location.href=window.location.href;
		return false;

	});
	
	
	$("select[name='region']").on("change",function(){

		_val = $(this).find("option:selected").val();
		if(_val === ""){
			$(".country").html("");	
		}else{
			$.ajax({
		                        url: ajax_object.ajaxurl+'?action=uc_get_countries_by_region',
		                        type: 'POST',
		                        data: { 'region': _val},
		                        success:function(result){
		                               $(".country").html(result);
		                               return false;
		                        }
			});
		}	

	});

	$("i.edit-metabox").on("click", function(){
		
		id = $(this).attr("box-id");
		$("#meta-"+id).removeClass("hidden");
		$("button[box-id="+id+"]").removeClass("hidden");
		$("a[href='#collapse"+id+"']").addClass("hidden")
		
	});
	$("button.editable-submit").on("click",function(){
		$id = $(this).attr("box-id");
		$("#meta-"+id).addClass("hidden");
		$("button[box-id="+id+"]").addClass("hidden");
		$("a[href='#collapse"+id+"']").removeClass("hidden");
		$.ajax({
	                        url: ajax_object.ajaxurl+'?action=uc_update_metabox',
	                        type: 'POST',
	                        dataType: "json",
	                        data: {'new-meta-box': $("#meta-"+id).val(), 'old-meta-box': id, "post_type":current_post_type.post_type,'post_id':current_post_type.post_id},
	                        success:function(result){
	                        	 if(parseInt(result.success) === 1)
	                               	{
	                               		$("a[href='#collapse"+id+"']").html($("#meta-"+id).val());
	                               		$("#addMoreFieldsModal").find("div.addmorefield-error").removeClass("alert-warning").addClass("alert-success").removeClass("hidden").html(result.msg).focus();
	                               		window.location.href=window.location.href;
	                               	}else{
	                               		$("#addMoreFieldsModal").find("div.addmorefield-error").addClass("alert-warning").removeClass("alert-success").removeClass("hidden").html(result.msg).focus();
	                               	}	
	                               	return false;
	                        }
		});
		
	});
	$("button.editable-cancel").on("click",function(){
		$id = $(this).attr("box-id");
		$("#meta-"+id).addClass("hidden");
		$("button[box-id="+id+"]").addClass("hidden");
		$("a[href='#collapse"+id+"']").removeClass("hidden")
		
	});
	$("i.edit-metabox").on("click", function(){
		
		id = $(this).attr("box-id");
		$("#meta-"+id).removeClass("hidden");
		$("button[box-id="+id+"]").removeClass("hidden");
		$("a[href='#collapse"+id+"']").addClass("hidden")
		
	});

	var showFieldTextRow = function(_id, _meta_key, _meta_box){
		$("#"+_id).find("td").find("span").removeClass("hidden");
		$("#"+_id).find("td").find("input").addClass("hidden");
		$("#"+_id).find("td").find("select").addClass("hidden");
		$("button[meta-key="+_meta_key+"]").addClass("hidden");
	}
	var showFormRow = function(_meta_key, _meta_box){
		
		$("#"+_meta_box+"_"+_meta_key).find("td").find("span").addClass("hidden");
		$("#"+_meta_box+"_"+_meta_key).find("td").find("input").removeClass("hidden");
		$("#"+_meta_box+"_"+_meta_key).find("td").find("select").removeClass("hidden");
		$("button[meta-key="+_meta_key+"]").removeClass("hidden");
	}


	$(".edit-field").on("click", function(){
		//console.log("asdf");
		showFormRow($(this).attr("meta-key"), $(this).attr("meta-box"));
		 return false;

	});
	

	$("button.field-cancel").on("click",function(){
		_meta_key = $(this).attr("meta-key");
		_meta_box = $(this).attr("meta-box");
		_id = _meta_box+"_"+_meta_key;

		showFieldTextRow(_id, _meta_key, _meta_box);
		
	});

	$("button.field-submit").on("click",function(){
		_meta_key = $(this).attr("meta-key");
		_meta_box = $(this).attr("meta-box");
		_id = _meta_box+"_"+_meta_key;

		showFieldTextRow(_id, _meta_key, _meta_box);
		
		_old_meta_key = _meta_key;
		_field_title = $("#"+_id).find("td").find("input[name='meta-field-title']").val();
		_field_key = $("#"+_id).find("td").find("input[name='meta-field-key']").val();
		_field_desc = $("#"+_id).find("td").find("input[name='meta-field-desc']").val();
		_field_type = $("#"+_id).find("td").find("select[name='type']").find("option:selected").val();

		$.ajax({
	                        url: ajax_object.ajaxurl+'?action=uc_update_metabox_field',
	                        type: 'POST',
	                        dataType: "json",
	                        data: {'label': _field_title, 'key': _field_key, 'desc':_field_desc,'type': _field_type, 'old_key':_old_meta_key,'meta_box':_meta_box, "post_type":current_post_type.post_type,'post_id':current_post_type.post_id},
	                        success:function(result){
	                        	 if(parseInt(result.success) === 1)
	                               	{
	                               		$("#addMoreFieldsModal").find("div.addmorefield-error").removeClass("alert-warning").addClass("alert-success").removeClass("hidden").html(result.msg).focus();
	                               		window.location.href=window.location.href;
	                               	}else{
	                               		$("#addMoreFieldsModal").find("div.addmorefield-error").addClass("alert-warning").removeClass("alert-success").removeClass("hidden").html(result.msg).focus();
	                               	}	
	                               	return false;
	                        }
		});
		
	});
	


});