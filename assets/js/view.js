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
	//On click in View By Time Button
	$("#Time").click(function(){
		//timeDialog
		 $('#timeDialog').dialog({
				maxHeigth: 20,
				minWidth: 300,
				maxWidth: 300,
				resizable: false,
				modal: true
		});
		//window.location = $("#base_url").val()+'view?time='+$("#current_time").val();
	});
	
	//Time Search Button all data is in Seconds
	$('#timeDialogClose').click(function(){
		//If Search by year is selected
		if($("#dialogSelect").val() == "Years"){
			var Time = parseInt($("#TimeInput").val()) * 3600*24*365;
		}
		
		//If search by Month is selected
		if($("#dialogSelect").val() == "Months"){
			var Time = parseInt($("#TimeInput").val()) * 3600*24*31;
		}
		
		//If Week is selected
		if($("#dialogSelect").val() == "Week"){
			var Time = parseInt($("#TimeInput").val()) * 3600*24*7;
		}
		
		//If Serach by day is selected
		if($("#dialogSelect").val() == "Days"){
			var Time = parseInt($("#TimeInput").val()) * 3600*24;
		}
		
		//If search by hour is selected
		if($("#dialogSelect").val() == "Hours"){
			var Time = parseInt($("#TimeInput").val()) * 3600;
		}
		
		//If search ny minute is selcted
		if($("#dialogSelect").val() == "Minutes"){
			var Time = parseInt($("#TimeInput").val()) * 60;
		}
		
		//If serach by second is selected only take the value no calculation
		if($("#dialogSelect").val() == "Seconds"){
			var Time = parseInt($("#TimeInput").val());
		}
		
		//Go to view controller with the correct number of second
		window.location = $("#base_url").val()+'view?time='+Time+LangString;
	});
	
	//View By Creator
	$("#Creator").click(function(){
		//nameDialog
		 $('#nameDialog').dialog({
				maxHeigth: 20,
				minWidth: 300,
				maxWidth: 300,
				resizable: false,
				modal: true
		});
		//window.location = $("#base_url").val();
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
	
	//Search By Name
	$('#nameDialogClose').click(function(){
		window.location = $("#base_url").val()+'view?creator='+$("#Name").val()+LangString;
	});
	
	//Id Search Button
	$('#idDialogClose').click(function(){
		window.location = $("#base_url").val()+'output?id='+$("#dialogId").val()+LangString;
	});
	
});