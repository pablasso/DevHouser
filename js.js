function sendEmail()
{
	var name = $("input#name").val();
	var twitter = $("input#twitter").val();
	var work = $("input#work").val();
	var dataString = 'name='+ name + '&twitter=' + twitter + '&work=' + work;

	$.ajax({
		type: "POST",
		url: "send_email.php",
		data: dataString,
		success: function(data) {
			$('#form').fadeOut(800, function() {
				$('#message').html("<p><strong>" + data + "</strong></p>");
			});
		}
	});
	return false;
}