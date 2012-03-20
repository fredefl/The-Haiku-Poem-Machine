$(function(){
	function getUrlVars()
	{
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}

	var lang = getUrlVars()["lang"];
	if(lang != "da-DK" || lang != undefined){
		var Lang = "?lang="+lang;
	}
	if(lang != "da-DK" || lang != undefined){
		var LangString = "&lang="+lang;
	}
	if(lang == undefined){
		var LangString = "";
		var Lang = "";
	}
	//Share Poem
	$("#Share").click(function(){
		window.location = $("#base_url").val()+'share'+Lang;
	});
	
	//Id
	$("#Id").click(function(){
		//idDialog
		 $('#idDialog').dialog({
				maxHeigth: 20,
				minWidth: 300,
				maxWidth: 300,
				resizable: false,
				modal: true
		});
		//window.location = $("#base_url").val()+'view?time='+$("#current_time").val();
	});
	
	//Search Button
	$('#idDialogClose').click(function(){
		window.location = $("#base_url").val()+'output?id='+$("#dialogId").val()+LangString;
	});
});