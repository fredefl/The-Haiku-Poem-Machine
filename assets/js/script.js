/**
* 
* @param {} 
* @return {} 
*/
/**
* Downloads the newest poems for the poem showcase
* @param {String} pName    A name to display with greeting.
* @return {String}   Returns a string value containing name and greeting
*/
function example () {
	
}
/**
* Get the GET variables from the url.
*/
function getUrlVars(){
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
var currentSentenceNumber = 1;
		var lang = getUrlVars()["lang"];
		if(lang == undefined){
			var lang = "";
		}
/**
* Downloads the newest poems for the poem showcase
*/
function downloadFeed () {
	$.ajax({
	  url: $("#base_url").val()+'live/?language='+lang,
	  success: function (data) {
		  $('#poemShowcase').html(data);
	  }
	});	
}

$(function(){
	
	downloadFeed();
	
	var questions = $('#questions');
	var box = $('#title');
	
	/**
	* Refresheshs the selectboxes
	*/
	function refreshSelects(){
		var selects = questions.find('select');
		// Improve the selects with the Chose plugin
		selects.chosen();
		
		// Listen for changes
		selects.unbind('change').bind('change',function(){
			
			// The selected option
			var selected = $(this).find('option').eq(this.selectedIndex);
			// Look up the data-connection attribute
			var connection = selected.data('connection');
			
			
			// Removing the li containers that follow (if any)
			selected.closest('#questions li').nextAll().remove();
			
			if(connection){
				fetchSelect(connection);
			}

		});
	}
	
	var working = false;
	 
	/**
	* Fetches select data from server
	* @param {No idea} I don't know
	*/
	function fetchSelect(val){
		
		if(working){
			return false;
		}
		working = true;
		$.getJSON($("#base_url").val()+'ajax/?language'+lang,{},function(jsonData){
			// Loop throug sentence numbers
			var boxTitle = jsonData.boxTitle;
			// Add the flags
			boxTitle += '<img id="flagDK" src="assets/images/dk.png"/>\
						 <img id="flagGB" src="assets/images/gb.png"/>';
			// Set the title of the box
			$('#title').html(boxTitle);
			var selectTitle = jsonData.selectTitle;
			$.each(jsonData,function(sentenceNumber,sentences) {
				if(sentenceNumber == 5 || sentenceNumber == 7){
					// Create options array
					var options = '';
					// Add a blank option
					options+= '<option value=""></option>';
					// Set the default text
					var defaultText = sentenceNumber + ' ' + selectTitle;
					// Loop through sentences
					$.each(sentences,function(index,sentence){
						options+= '<option value="' + sentence + '">' + sentence + '</option>';
					});
					// Add the select box
					$('<select data-placeholder="'+defaultText+'" id="sentence' + currentSentenceNumber + '">'+ options +'</select>').appendTo(box);
					$('<img src="assets/images/add.png" style="margin-left:5px;" class="addIcon" id="addIcon' + currentSentenceNumber + '"></img>').appendTo(box);
					
					currentSentenceNumber++;
				}
			});
			$.each(jsonData,function(sentenceNumber,sentences) {
				if(sentenceNumber == '5') {
					// Create options array
					var options = '';
					// Add a blank option
					options+= '<option value=""></option>';
					// Set the default text
					var defaultText = sentenceNumber + ' ' + selectTitle;
					// Loop through sentences
					$.each(sentences,function(index,sentence){
						options+= '<option value="' + sentence + '">' + sentence + '</option>';
					});
					// Add the select box
					$('<select data-placeholder="'+defaultText+'" id="sentence' + currentSentenceNumber + '">'+ options +'</select>').appendTo(box);
					$('<img src="assets/images/add.png" style="margin-left:5px;" class="addIcon" id="addIcon' + currentSentenceNumber + '"></img>').appendTo(box);
				}
			});
			
			refreshSelects();
			
			working = false;
			afterSelectCreation();
		});
		
	}
	// Initially load the product select
	fetchSelect('productSelect');
	
	
	/**
	* When the submitButton is clicked, the saveDialog will be revealed.
	*/
	$('#submitButton').click(function(e) {
        $('#saveDialog').dialog({
			maxHeigth: 20,
			minWidth: 300,
			maxWidth: 300,
			resizable: false,
			modal: true
		});
    });
	
	/**
	* When enter is pressed on saveDialogName, click on saveDialogSaveButton.
	*/
	$('#saveDialogName').keypress(function(event) {
  		if ( event.which == 13 ) {
     		$('#saveDialogSaveButton').click();
		}
	});
	
	/**
	* When saveDialogSaveButton is clicked, send the data to the server.
	*/
	$('#saveDialogSaveButton').click(function () {
		$('#creatorForm').val($('#saveDialogName').val());
		ajaxCall($("#base_url").val()+'Pusher/send_message.php', { message : "update" });
		sendSelectValues();
	});
	
	/**
	* Sends the data(poem) to the server
	*/
	function sendSelectValues () {
		var sentence1 = $('#sentence1 option:selected').val();	
		var sentence2 = $('#sentence2 option:selected').val();	
		var sentence3 = $('#sentence3 option:selected').val();	
		$("#sentence1Form").val(sentence1);
		$("#sentence2Form").val(sentence2);
		$("#sentence3Form").val(sentence3);
		$('#submitForm').submit();
	}
	
	/**
	* Adds some CSS style, based on the browser being used.
	*/
	function styleBrowsers() {
		var deviceAgent = navigator.userAgent.toLowerCase();
    	var webkitFirefox = deviceAgent.match(/(webkit|firefox)/);
		var webkitOpera = deviceAgent.match(/(webkit|opera)/);
    	if (webkitFirefox) {
			// Webkit & Firefox
			$('#dialogValidationIcon').addClass('dialogValidationIcon_WebkitFirefox');
		}
		if (webkitOpera) {
			// Webkit & Opera
			$('.addIcon').addClass('addIcon_WebkitOpera');	
		}
	}
	
	/**
	* When dialogSaveButton is clicked, add the data to the selects and close the dialog box
	*/
	$('#dialogSaveButton').click(function () {
		saveDialog();
		$("#dialog").dialog("close");
	});
	
	/**
	* When enter is pressed in dialogSentence, click on dialogSaveButton.
	*/
	$('#dialogSentence').keypress(function(event) {
  		if ( event.which == 13 ) {
     		$('#dialogSaveButton').click();
		}
	});
	
	/**
	* When a key is pressed in dialogSentence, count the number of syllables
	*/
	$('#dialogSentence').keyup(function(event) {
		var target = event.target;
        var value = target.value.toLowerCase();
		var sentenceNumber  = $('#dialogSentenceNumber').val();
		var allowedSyllables;
		if(sentenceNumber != 2) {
			allowedSyllables = 5;	
		} else {
			allowedSyllables = 7;
		}
		var syllables = 0;
		syllables += (value.split("a").length - 1);
		syllables += (value.split("e").length - 1);
		syllables += (value.split("i").length - 1);
		syllables += (value.split("o").length - 1);
		syllables += (value.split("u").length - 1);
		syllables += (value.split("y").length - 1);
		syllables += (value.split("æ").length - 1);
		syllables += (value.split("ø").length - 1);
		syllables += (value.split("å").length - 1);
		if(allowedSyllables == syllables) {
			$('#dialogValidationIcon').attr("src","assets/images/validationOk.png");
		} else {
			$('#dialogValidationIcon').attr("src","assets/images/validationError.png");
		}
    });
	
	/**
	* Adds the content of dialogSentence to the select box and scrolls to the top of the page.
	*/
	function saveDialog () {
		// Ipad customizations.
		$('#dialogSentence').blur();
		$('html, body').animate({scrollTop:0}, 'fast');
		// ---
		var sentenceNumber = $('#dialogSentenceNumber').val();
		var sentence = $('#dialogSentence').val();
		removeSelection(sentenceNumber);
		$('<option selected value="' + sentence + '">' + sentence + '</option>').appendTo("#sentence" + sentenceNumber);
		$("#sentence"+sentenceNumber).trigger("liszt:updated");
	}
	
	/**
	* Shows the "add your own sentence" dialog
	* @param {Integer} sentenceNumber	The currently used select box (1-3)
	*/
	function showAddDialog (sentenceNumber) {
		var allowedSyllables;
		if(sentenceNumber == 1 || sentenceNumber == 3) {
			allowedSyllables = 5;	
		} else {
			allowedSyllables = 7;
		}
		$('#dialogLabel').html($('#dialogLabel').attr("data-translated").replace("{0}",allowedSyllables))
		$('#dialogValidationIcon').attr("src","assets/images/validationError.png");
		$('#dialogSentenceNumber').val(sentenceNumber);
		$('#dialogSentence').val('');
		$('#dialog').dialog({
			maxHeigth: 20,
			minWidth: 300,
			maxWidth: 300,
			resizable: false,
			modal: true
		});
		// ------- IPAD
		var deviceAgent = navigator.userAgent.toLowerCase();
    	var iPad = deviceAgent.match(/(ipad)/);
    	if (iPad) {
			$('#dialogSentence').removeAttr('style');
			$('#dialogSentence').attr('style','width:230px;');
		}
			
	}
	
	/**
	* Removes all selections in the desired selectbox
	* @param {Integer} sentenceNumber	The currently used select box (1-3)
	*/
	function removeSelection (sentenceNumber) {
		$("#sentence" + sentenceNumber + " option:selected").removeAttr('selected');
	}
	
	/**
	* After the selectboxes are created, add on click functions to all of the addIcons and style the browsers.
	*/
	function afterSelectCreation () {
		$("button").button();
		$('#submitButton').show();
		styleBrowsers();
		$('body').fadeIn('slow');
		$('#addIcon1').click(function(e) {
			showAddDialog(1);
		});
		$('#addIcon2').click(function(e) {
			showAddDialog(2);
		});
		$('#addIcon3').click(function(e) {
			showAddDialog(3);
		});
		/**
		* When the Danish flag is clicked, send the user to the Danish page
		*/
		$('#flagDK').click(function () {
			document.location = $("#base_url").val()+'?language=danish';
		});
		/**
		* When the English(GB) flag is clicked, send the user to the English(GB) page
		*/
		$('#flagGB').click(function () {
			document.location = $("#base_url").val()+'?language=english';
		});
	};
	
	// Variables
	var pusher;
	var chat_channel;
	
	// Send message function
	function ajaxCall(ajax_url, ajax_data) {
		$.ajax({
			type : "POST",
			url : ajax_url,
			dataType : "json",
			data: ajax_data,
			async: false
		});
	}
	
	// Create pusher object
	pusher = new Pusher('9b245d36fea0d2611317');
	// Set the channel auth endpoint
	Pusher.channel_auth_endpoint = $("#base_url").val()+'Pusher/pusher_auth.php';
	// Subscribe to the chat channel
	chat_channel = pusher.subscribe('haiku-update-channel');
	// Listen for the connected event
	pusher.connection.bind('connected', function() {
		console.log('Connected');
		// Listen for new messages
		chat_channel.bind('haiku-update', function(data) {
			console.log('Got data');
			// Call function to handle the data
			setTimeout("downloadFeed()",2000);
		});
	});
	
	/*
		Share
	*/
	
		
	
	/*
		Copyright
	*/
});
