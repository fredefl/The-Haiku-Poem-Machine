function templateCollection (collection) {
	var templateHtml = $("#template").html();
	var creator = collection.creator || translations.anonymous;
	templateHtml = templateHtml.replace("{base_url}",base_url);
	templateHtml = templateHtml.replace("{identifier}",collection.identifier);
	templateHtml = templateHtml.replace("{creator}",creator);
	templateHtml = templateHtml.replace("{name}",collection.name);
	if (typeof collection.time_created != "undefined") {
		templateHtml = templateHtml.replace("{date}",collection.time_created);
	} else {
		templateHtml = templateHtml.replace("{date}","");
	}
	if (typeof collection.description != "undefined" && collection.description != null) {
		templateHtml = templateHtml.replace("{description}", collection.description);
	}

	var template = $(templateHtml);

	if (typeof collection.description == "undefined" || collection.description == null) {
		template.find(".description").remove();
	}
	return template;
}

function getData (currentPage) {
	$("#errorMessage").hide();
	page = currentPage;
	currentPage = currentPage || 1;
	$.ajax({
		url : base_url+"collections?page="+currentPage,
		success : function(data) {
			$("#collections").html("");
			if (typeof data.error_message != "undefined") {
				$("#collections-container").css("margin-top","90px");
				showError(data.error_message,translations.alert,"none");
				return;
			} else if (typeof data.collections == "undefined") {
				$("#collections-container").css("margin-top","90px");
				 showError(translations.not_found,translations.alert,"none");
				return;
			} else {
				$("#pages").val(data.pages);
				$("#collections-container").css("margin-top","");
				var collections = data.collections;
				$.each(collections,function (index,collection) {
					var template = templateCollection(collection);
					$("#collections").append(template);
				});
			}	
			pagination(data.pages, parseInt(currentPage));
			if (currentPage == 1) {
				$(".prev").button( "option", "disabled", true );
			}
			if (currentPage == data.pages) {
				$(".next").button( "option", "disabled", true );
			}
		}
	});	
}

function pagination (pages, currentPage) {
	$("#paginate-numbers").html("");
	if (currentPage < 2) {
		var offset = 1;
		var large = 3;
	} else {
		if (currentPage == pages) {
			var offset = currentPage-2;
			var large = currentPage;
		} else {
			var large = currentPage+1;
			var offset = currentPage-1;
		}
	}
	if (large > pages) {
		large = pages;
		offset = (offset-1 > 0)? offset-1 : offset;
	}
	if (offset == 0) {
		offset = 1;
	}
	for (var i = offset; i <= large; i++) {
		if (i == currentPage) {
			$("#paginate-numbers").append('<button class="ui-priority-primary" data-page="'+i+'">'+i+'</button>');
		} else {
			$("#paginate-numbers").append('<button data-page="'+i+'">'+i+'</button>');
		}
	};
	$("button").button();
}

jQuery(document).ready(function($) {
	getData($("#page").val());
});

$(".prev").click(function(){
	var page = parseInt($("#page").val());
	var pages = parseInt($("#pages").val())
	if (page != 1) {
		page = page-1;
		$("#page").val(page);
		getData(page);
	}
	if (page == 1) {
		$(".prev").button( "option", "disabled", true );
		$(".next").button( "option", "disabled", false );
	}
});

$(".next").click(function(){
	var page = parseInt($("#page").val());
	var pages = parseInt($("#pages").val())
	if (page != pages) {
		page = page+1;
		$("#page").val(page);
		getData(page);
		$(".prev").button( "option", "disabled", false );
		if (page == pages) {
			$(".next").button( "option", "disabled", true );
		} else {
			$(".next").button( "option", "disabled", false );
		}
	}
});

$('[data-page]').live("click",function () {
	if ($(this).attr("data-page") == $("#page").val()) {
		return;
	}
	getData($(this).attr("data-page"));
	var page = $(this).attr("data-page");
	var pages = parseInt($("#pages").val())
	$("#page").val(page);
	if (page == 1) {
		$(".prev").button( "option", "disabled", true );
	} else {
		$(".prev").button( "option", "disabled", false );
	}
	if (page == pages) {
		$(".next").button( "option", "disabled", true );
	} else {
		$(".next").button( "option", "disabled", false );
	}
});