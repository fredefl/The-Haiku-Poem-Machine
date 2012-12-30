$("#submitButton").live("click",function () {
	if ($("#creator").val() != "" && $("#name").val() != "" && $("#languages-select").val() != null && $("#description").val() != "") {
		var selects = [];
		for (var i = 0; i < $(".syllabels-select").length; i++) {
			selects.push($(".syllabels-select:eq("+i+")").attr("data-value"));
		};
		$.ajax({
			url : base_url + "collection/create",
			type : "POST",
			data : JSON.stringify({
				"creator" : $("#creator").val(),
				"name" : $("#name").val(),
				"selects" : selects,
				"languages" : $("#languages-select").val(),
				"description" : $("#description").val()
			}),
			error : function () {

			},
			success : function (data) {
				data = $.parseJSON(data);
				if (data.status == "success") {
					$("#create").addClass("disabledPage");
					$("#done").removeClass("disabledPage");
					$("#url").val(data.url);
					$("#url").focus();
					$('#copy').zclip({
				        path:js_url+'ZeroClipboard.swf',
				        copy:$('#url').val()
				    });
				    $("#go").attr("href",data.url);
				} else {
					//Show error
				}
			}
		});
	}
});

$(".addSelect").live("click",function () {
	$('#selectSyllabelsDialog').dialog({
		maxHeigth: 20,
		minWidth: 300,
		maxWidth: 300,
		resizable: false,
		modal: true
	});
	$("#syllabelsDialogClose").text(translations.add_button_text);
	$("#selectSyllabelsDialog").attr("data-mode","add");
});

$(".syllabels-select").live("click",function () {
	$('#selectSyllabelsDialog').dialog({
		maxHeigth: 20,
		minWidth: 300,
		maxWidth: 300,
		resizable: false,
		modal: true
	});
	$("#syllabelsDialogClose").text(translations.edit_button_text);
	$("#selectSyllabelsDialog").attr("data-mode","edit");
	$("#Syllabels").val($(this).attr("data-value"));
	$("#selectSyllabelsDialog").attr("data-select-id",$(this).attr("data-select-id"));
});

$("#syllabelsDialogClose").live("click",function () {
	editSyllabels($("#selectSyllabelsDialog").attr("data-mode"));
});

function editSyllabels (mode) {
	var value = $("#Syllabels").val();
	value = value.toLowerCase();
	if (value == "unlimited" || isInt(value) ) {
		if (value == "unlimited") {
			var text = translations.unlimited;
		} else {
			var text = value;
		}
		$('#selectSyllabelsDialog').dialog("destroy");
		$("#Syllabels").val("");
		if (mode == "add") {
			var template = $(".syllabels-select:last").clone();
			template.attr("data-select-id",$(".syllabels-select") +1);
			$(".syllabels-select:last").after(template);
			var addButton = $(".addSelect").clone();
			$(".addSelect").remove();
			$('.syllabels-select:last').after(addButton);
			$('.syllabels-select:last').find("span").text(translations.syllabels_text.replace("{number_of_syllabels}",text));
			$('.syllabels-select:last').attr("data-value",value);
		} else {
			$('.syllabels-select[data-select-id="'+$('#selectSyllabelsDialog').attr("data-select-id")+'"]').find("span").text(translations.syllabels_text.replace("{number_of_syllabels}",text));
			$('.syllabels-select[data-select-id="'+$('#selectSyllabelsDialog').attr("data-select-id")+'"]').attr("data-value",value);
		}
	}
}

$("#Syllabels").keypress(function(e) {
    if(e.which == 13) {
        editSyllabels($("#selectSyllabelsDialog").attr("data-mode"));
    }
});

function isInt(value) { 
    return !isNaN(parseInt(value,10)) && (parseFloat(value,10) == parseInt(value,10)); 
}

$('.shadow:has(input:text[value=""])').addClass("shadow-not-valid").removeClass("shadow");

$("input").keypress(function () {
	$('.shadow:has(input:empty)').addClass("shadow-not-valid").removeClass("shadow");
	$('.shadow-not-valid:not(:has(input:text[value=""]))').removeClass("shadow-not-valid").addClass("shadow");
});