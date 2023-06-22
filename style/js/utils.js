function showErrorAlert (message)
{
	var alert = '<div class="alert alert-danger" role="alert">' + message + '</div>';

	$("#alerts").append(alert);
}

function showSuccessAlert (message)
{
	var alert = '<div class="alert alert-success" role="alert">' + message + '</div>';

	$("#alerts").append(alert);
}

function removeAllAlerts()
{
	$("#alerts").empty();
}

function addDisabledAttribute(elementId)
{
	$('#'+elementId).attr('disabled', 'disabled');
}

function removeDisabledAttribute(elementId)
{
	$('#'+elementId).removeAttr('disabled');
}