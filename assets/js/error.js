/**
 * This function shows an error
 * @param  {string} message The error message
 * @param  {string} alert   A translation for alert
 * @param {integer} time The number of miliseconds to show the dialog
 */
function showError (message, alert,time) {
	time = time || 2000;
	var errorContainer = $("#error").clone();
	var error = errorContainer.find("div");
	var html = error.html();
	var html = html.replace("{alert}",alert)
	var html = html.replace("{error}",message);
	error.html(html);
	errorContainer.attr("id","errorMessage");
	error.css("display","");
	$("body").append(errorContainer);
	if (time != "none" && time != "none") {
		setTimeout(function(){
			error.remove();
		},time);
	}
}
