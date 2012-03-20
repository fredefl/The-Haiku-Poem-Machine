$(document).ready(function() {
  	$('button').button();  
});

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
	if($('#All').length){
		//All Poems
		$("#All").click(function(){
			window.location = $("#base_url").val()+'view'+Lang;
		});
	}
	
	if($('#Print').length){
		//Print Poem
		$("#Print").click(function(){
			window.location = $("#base_url").val()+'printpoem'+Lang;
		});
	}
	
	if($('#Return').length){
		//Return
		$("#Return").click(function(){
			window.location = $("#base_url").val()+Lang;
		});
	}
});