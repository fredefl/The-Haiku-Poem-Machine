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
var lang = getUrlVars()["language"];
if(lang == undefined){
	var lang = userLanguage;
}
/**
* Downloads the newest poems for the poem showcase
*/
function downloadFeed () {
	if (mode == "view") {
		return;
	}
	$.ajax({
	  url: $("#base_url").val()+'live/?language='+lang,
	  success: function (data) {
	  	if (typeof data.poems == "undefined") {
	  		return;
	  	}
	  	$('#poemShowcase').html("");
	  	$.each(data.poems,function (index,element) {
	  		if (element.sentences == null) {
	  			return;
	  		}
	  		var poem = $('<a href="'+$("#base_url").val()+'poem/'+element.identifier+'"></a>');
	  		if (typeof element.title != "undefined") {
	  			poem.append('<p class="header">'+element.title+'</p>');
	  		}
	  		var sentences = $('<div class="sentences"></div>');
	  		$.each(element.sentences, function (sentenceIndex, sentence) {
	  			sentences.append('<span class="sentence">'+sentence.sentence+"</span><br>");
	  		});
			poem.append(sentences);
	  		poem.append("<em> - "+element.creator+"</em>");
	  		poem.append("<hr>");
	  		$('#poemShowcase').append(poem);
	  		if ($('#poemShowcase hr').length > 1) {
	  			$('#poemShowcase hr:last').remove();
	  		}
	  	});
	  }
	});	
}

$(function(){

	$("#addTag").live("click",function () {
		$('#addTagDialog').dialog({
			maxHeigth: 20,
			minWidth: 300,
			maxWidth: 300,
			resizable: false,
			modal: true
		});
	});

	$("#saveTagButton").live("click", function () {
		if ($("#tagInput").val() != "" && $("#tag-select").find("option:contains('"+$("#tagInput").val()+"')")) {
			$("#tag-select").append('<option selected>'+$("#tagInput").val()+'</option>').trigger("liszt:updated");

			$("#tag-select").trigger("liszt:updated");

			$("#tagInput").val("");

			$('#addTagDialog').dialog("close");
		}
	});

	if (typeof mode != undefined && mode == "view") {
		$.ajax({
			url : $("#base_url").val() + "collection/"+collection,
			success : function (data) {
				if (typeof data.poems != "undefined") {
					$.each(data.poems,function (index,poem) {
						var html = $("#poemTemplate").html();
						var sentences = "";
						html = html.replace("{title}",poem.title);
						html = html.replace("{creator}",poem.creator);

						var date = new Date(poem.time_created*1000);

						$.each(poem.sentences,function(sentenceId,sentence) {
							sentences += sentence.sentence+"<br>";
						});
						html = html.replace("{sentences}","<div>"+sentences+"</div>");
						html = html.replace("{date}","<u>"+date.toUTCString()+"</u>");
						$("#view").append(html);
					});
				}
				$("#view").removeClass("disabledPage");
				$("body").css("display","");
			}
		});
		return;
	} else {
		$("#create").removeClass("disabledPage");
	}
	
	downloadFeed();

	$.get(base_url+"tags").success(function (data) {
		var data = $.parseJSON(data);
		if ($(data.tags).length == 0) {
			return;
		}
		$.each(data.tags,function (index,element) {
			$("#tag-select").append("<option>"+element+"</option>");

			if (index == $(data.tags).length) {
				$("#tag-select").chosen({
		            no_results_text: translations.no_results_found
		        });
			}
		});
	});
	
	var questions = $('#questions');
	var box = $('#title');
	
	/**
	* Refresheshs the selectboxes
	*/
	function refreshSelects(){
		var selects = questions.find('select');
		// Improve the selects with the Chose plugin
		selects.chosen({
			no_results_text: translations.no_results_found
		});
		
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
	function fetchSelect(){
		
		if(working){
			return false;
		}
		working = true;
		$.getJSON($("#base_url").val()+'select/'+collection+'?language='+lang,{},function(jsonData){
			if (typeof jsonData.error_message != "undefined") {
				var boxTitle = jsonData.error_message;
			} else {
				var boxTitle = jsonData.boxTitle;
			}
			// Add the flags
			boxTitle += '<img id="flagDK" src="'+$("#base_url").val()+'assets/images/dk.png"/>\
						 <img id="flagGB" src="'+$("#base_url").val()+'assets/images/gb.png"/>';
			// Set the title of the box
			$('#title').html(boxTitle);

			var selectTitle = jsonData.selectTitle;
			if (typeof jsonData.selects != "undefined") {
				$.each(jsonData.selects,function(arrayIndex,sentenceNumber) {
					// Create options array
					var options = '';
					// Add a blank option
					options+= '<option value=""></option>';
					// Set the default text
					var defaultText = selectTitle.replace("{number_of_syllabels}",sentenceNumber);;
					if (typeof jsonData.sentences[sentenceNumber] != "undefined") {
						// Loop through sentencesj 
						$.each(jsonData.sentences[sentenceNumber],function(index,sentence){
							options+= '<option value="' + sentence + '">' + sentence + '</option>';
						});
					}
					// Add the select box
					$('<select data-placeholder="'+defaultText+'" data-syllabels="'+sentenceNumber+'" class="sentence-select">'+ options +'</select>').appendTo(box);
					$('<img src="'+base_url+'assets/images/add.png" style="margin-left:5px;" class="addIcon" id="addIcon' + currentSentenceNumber + '"></img>').appendTo(box);
					
					currentSentenceNumber++;
				});
			}
			refreshSelects();
			
			working = false;
			afterSelectCreation();
		});
		
	}
	// Initially load the product select
	fetchSelect();
	
	
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
     		$('#saveDialog').dialog("close");
		}
	});
	
	/**
	* When saveDialogSaveButton is clicked, send the data to the server.
	*/
	$('#saveDialogSaveButton').click(function () {
		ajaxCall($("#base_url").val()+'Pusher/send_message.php', { message : "update" });
		if (sendSelectValues($('#saveDialogName').val(),$('#saveDialogTitle').val()) === true) {
			$("#saveDialog").dialog("close");
		}
	});
	
	/**
	* Sends the data(poem) to the server
	*/
	function sendSelectValues (name,title) {
		if ($(".sentence-select option:selected").length != $(".sentence-select").length) {
			showError(translations.missing_fields,translations.alert,1500);
			return;
		}
		var object = {
			"creator" : name,
			"language" : userLanguage,
			"sentences" : [],
			"title" : title,
			"tags" : []
		};
		$(".sentence-select").each(function(index,element) {
			if ($(element).attr("data-syllabels") !== "undefined" && countSyllabels($(element).val(),translation_vowels) == $(element).attr("data-syllabels")) {
				object.sentences.push({
					"sentence" : $(element).val(),
					"language" : userLanguage,
					"syllabels" : countSyllabels($(element).val(),translation_vowels)
				});	
			}
		});

		var tags = $("#tag-select").val();

		for (var i = 0; i < tags.length; i++) {
			object.tags.push({
				"tag" : tags[i].toLowerCase()
			});
		};

		if (object.sentences.length != $(".sentence-select").length) {
			showError(translations.no_sentences_match,translations.alert,1000);
			return;
		}
		$.ajax({
			url : $("#base_url").val()+"poem/save/"+collection,
			type : "POST",
			data : JSON.stringify(object),
			error : function () {
				showError(translations.an_error_occured,translations.alert,1500);
			}
		});
		return true;
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
		if (saveDialog() == true) {
			$("#dialog").dialog("close");
		}	
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
	 * This function counts the number of syllabels
	 * @param  {string} word          The word to count in
	 * @param  {Array} syllabelsList The list of accepted syllabels
	 * @return {integer}
	 */
	function countSyllabels (word, syllabelsList) {
		var syllables = 0;
		word = word.toLowerCase();
		$.each(syllabelsList, function(index, element) {
			syllables += (word.split(element).length - 1);
		});

		return syllables;
	}

	/**
	* When a key is pressed in dialogSentence, count the number of syllables
	*/
	$('#dialogSentence').keyup(function(event) {
		var target = event.target;
        var value = target.value.toLowerCase();
		var index  = $('#dialogSentenceNumber').val();
		var allowedSyllables;

		//Needs to be rethought
		if($(".sentence-select").eq(index-1).attr("data-syllabels") !== "undefined") {
			allowedSyllables = $(".sentence-select").eq(index-1).attr("data-syllabels");	
		} else {
			allowedSyllables = 5;
		}

		var syllables = countSyllabels(value,translation_vowels);
		if(allowedSyllables == syllables) {
			$('#dialogValidationIcon').attr("src",base_url+"assets/images/validationOk.png");
		} else {
			$('#dialogValidationIcon').attr("src",base_url+"assets/images/validationError.png");
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
		var index = $('#dialogSentenceNumber').val();
		var sentence = $('#dialogSentence').val();
		if ($(".sentence-select").eq(index-1).attr("data-syllabels") == countSyllabels(sentence,translation_vowels)) {
			removeSelection(index-1);
			$('<option selected value="' + sentence + '">' + sentence + '</option>').appendTo($(".sentence-select").eq(index-1));
			$('<option value="' + sentence + '">' + sentence + '</option>').appendTo($('[data-syllabels="'+$(".sentence-select").eq(index-1).attr("data-syllabels")+'"]:not(:eq('+$(".sentence-select").eq(index-1)+'))'));
			$('[data-syllabels="'+$(".sentence-select").eq(index-1).attr("data-syllabels")+'"]').trigger("liszt:updated");
			return true;
		}
	}
	
	/**
	* Shows the "add your own sentence" dialog
	* @param {Integer} index	The jQuery index of the selected box 
	*/
	function showAddDialog (index) {
		var allowedSyllables;
		//This section needs to be converted
		if($(".sentence-select").eq(index-1).attr("data-syllabels") !== "undefined") {
			allowedSyllables = $(".sentence-select").eq(index-1).attr("data-syllabels");	
		} else {
			allowedSyllables = 5;
		}

		$('#dialogLabel').html($('#dialogLabel').attr("data-translated").replace("{number_of_syllabels}",allowedSyllables))
		$('#dialogValidationIcon').attr("src",base_url+"assets/images/validationError.png");
		$('#dialogSentenceNumber').val(index);
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
	function removeSelection (eq) {
		$(".sentence-select").eq(eq).removeAttr('selected');
	}
	
	/**
	* After the selectboxes are created, add on click functions to all of the addIcons and style the browsers.
	*/
	function afterSelectCreation () {
		$("button").button();
		$('#submitButton').show();
		styleBrowsers();
		$('body').fadeIn('slow');//sentence-select
		$(".addIcon").live("click",function () {
			showAddDialog(index($(this).prev("div").prev("select"), $(".sentence-select"))+1);
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

	function index (element, selector) {
		for (var i = 0; i <= selector.length; i++) {
			if (compare(selector.eq(i),element)) {
				return i;
			}
		};
	}

	function compare (element, object) {
		return ($(element).get(0) == $(object).get(0));
	}
	
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
		// Listen for new messages
		chat_channel.bind('haiku-update', function(data) {
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
