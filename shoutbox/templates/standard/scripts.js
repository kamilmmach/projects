$(document).ready(function(){
	
	$("#text_div").animate({ scrollTop: $("#text_div").attr("scrollHeight") - $('#text_div').height() }, 1000);
	$("input:text:visible:first").focus();

	var sendform = '<form id="form_sendmsg" action="" method="post"><p><input id="text" class="text long" name="text" type="text" /> <input id="submit" class="submit" name="submit" type="submit" value="OK" /></p></form>';

	$("#topic_change").dblclick(function(){
		if($("#topic_text").is(':visible'))
		{
			$("#topic_text").slideUp(100, function(){$("#topic_change_form").slideDown(100);});
		}
		else
		{
			$("#topic_change_form").slideUp(100, function(){$("#topic_text").slideDown(100);});
			$('#topic_input').val($("#topic_text").text());
		}
	});
			
	$("#topic_change_form").submit(function(event){
		$("#topic").append('<img src="images/ajax-loader.gif" id="loading" alt="" />');
		$(".loading").fadeIn(250);
			
		$.ajax({
			url: "ajax.php?a=change_topic",
			type: 'POST',
			data: 'topic_input=' + $('#topic_input').val(),
					
			success: function(result) {
				$("#loading").fadeOut(250);
				if(result == "OK")
				{
					upd();
				}
				$("#topic_change_form").slideUp(100, function(){$("#topic_text").slideDown(100);});
			}
		});
			
		event.preventDefault();
	});
	
	function sendmsg(event){
		$.ajax({
			url: "ajax.php?a=sendmsg",
			type: 'POST',
			data: 'text=' + $('#text').val(),
					
			success: function(result) {
				if(result == "OK")
				{
					upd();
					$("#text").val('');
				}
			}
			});
			
		event.preventDefault();
	}
		
	$("#form_sendmsg").submit(sendmsg);
		
	
	$("#loginhref").click(function(event){
	
		$("#login").slideUp(100, function(){$("#logindiv").slideDown(100);});
		event.preventDefault();
	});
	
	$("#logout").click(function(event){
	
		$.ajax({
			url: "ajax.php?a=logout",
			type: 'POST',
			data: 'logout=1',
					
			success: function(result) {
				if(result == 'OK')
				{
					$("div.infobar").slideUp(250);
					
				}
			}
		});
		event.preventDefault();
	});
	
	$("#loginform").submit(function(event){
		$("#p_login").append('<img src="images/ajax-loader.gif" id="loading2" alt="" />');
		$("#loading2").fadeIn(250);
			
		$.ajax({
			url: "ajax.php?a=login",
			type: 'POST',
			data: 'login=' + $('#loginek').val() + '&pass=' + $('#pass').val(),
					
			success: function(result) {
				$("#loading2").fadeOut(250);

				if(result == 'OK')
				{
					$("#logindiv").remove();
					$(".infobar").append(sendform);
					$("#form_sendmsg").submit(sendmsg);
				}
				else
				{
					alert('Login failed! Check your user and password and try again.');
				}
			}
		});
			
		event.preventDefault();
	});
	
	function doshit(shit)
	{
		shit = shit.replace(/<b>/gi, "[b]");
		shit = shit.replace(/<\/b>/gi, "[/b]");
		shit = shit.replace(/<u>/gi, "[u]");
		shit = shit.replace(/<\/u>/gi, "[/u]");
		shit = shit.replace(/<i>/gi, "[i]");
		shit = shit.replace(/<\/i>/gi, "[/i]");
		return shit;
	}
	
	function upd(){
		$.ajax({
			url: "ajax.php?a=getmsgs",
						
			success: function(result) {
				if(result.length > 10)
				{
					$("div.content_text").replaceWith('<div class="content_text">' + result + '</div>');
					$("#text_div").animate({ scrollTop: $("#text_div").attr("scrollHeight") - $('#text_div').height() }, 1000);
				}
			}
		});
		
		$.ajax({
			url: "ajax.php?a=gettopic",
						
			success: function(result) {
				var data = result.split("\n");
				
				if(data[0] == 'OK')
				{
					$("#topic_who").text(data[1]);
					$("#topic_text").text('');
					$("#topic_text").append(data[2]);
					$("#topic_input").val(doshit(data[2]));
				}
			}
		});
	}
	
	setInterval(upd, 15000);
			
});