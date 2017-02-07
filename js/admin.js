$(document).ready(function() {

	// if stored, get our ORCID from database and put it in the text field
	$.ajax(OC.linkTo('orcid', 'ajax/settings/getOrcidInfo.php'), {
		type: "GET",
		dataType: 'json',
		success: function(s) {
			clientAppID = s['clientAppID'];
			clientSecret = s['clientSecret'];
			document.getElementById('inputclientappid').value = clientAppID;
			document.getElementById('inputclientsecret').value = clientSecret;
		}
	});

	// catch clicks on our 'Store OAuth' values button
	$('#clientsubmit').click(function() {
		// get the values from textfield and throw them into app settings
		inputclientappid = $('#inputclientappid').val();
		inputclientsecret = $('#inputclientsecret').val();

		$.ajax(OC.linkTo('orcid', 'ajax/settings/setOrcidInfo.php'), {
			type: "POST",
			data: {
				clientAppID: inputclientappid,
				clientSecret: inputclientsecret
			},
			dataType: 'json',
			success: function(s) {
				document.getElementById('clientstatus').style.color = "green";
				document.getElementById('clientstatus').innerHTML = "Stored.";
			}
		});

	});

});
