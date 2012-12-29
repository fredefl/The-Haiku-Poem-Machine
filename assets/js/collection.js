$("#submitButton").live("click",function () {
	if ($("#creator").val() != "" && $("#name").val() != "" && $("#languages-select").val() != null && $("#selects").val()) {
		$.ajax({
			url : base_url + "collection/create",
			type : "POST",
			data : JSON.stringify({
				"creator" : $("#creator").val(),
				"name" : $("#name").val(),
				"selects" : $("#selects").val(),
				"languages" : $("#languages-select").val()
			})
		});
	}
});