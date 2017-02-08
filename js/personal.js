var oauthWindow;
var clientAppID;
var clientSecret;
var redirectUrl;

function getClient () {
	$.ajax(OC.linkTo('orcid', 'ajax/settings/getClient.php'), {
		type: "GET",
		dataType: 'json',
		success: function (s) {
			clientAppID = s['clientAppID'];
			clientSecret = s['clientSecret'];
			redirectUrl = s['redirectURL'];
		}
	});
}

function openORCID () {
	var oauthWindow = window
		.open("https://orcid.org/oauth/authorize?" + "client_id="
			+ clientAppID + "&response_type=code&scope=/authenticate&"
			+ "redirect_uri=" + redirectUrl, "_blank",
			"toolbar=no, scrollbars=yes, width=620, height=600, top=500, left=500");
}

function getOrcid () {
	$.ajax(OC.linkTo('orcid', 'ajax/settings/getOrcid.php'), {
		type: "GET",
		dataType: 'json',
		success: function (s) {
			orcid = s['orcid'];
			if (orcid) {

			}
		}
	});
}

function setOrcid (orcid) {
	$.ajax(OC.linkTo('orcid', 'ajax/settings/setOrcid.php'), {
		type: "POST",
		data: {
			orcid: orcid
		},
		dataType: 'json',
		success: function (s) {

		}
	});
}

$(document)
	.ready(
		function () {
			getClient();

			if ($('a.orcid').text() == "https://orcid.org/") {
				$('a.orcid').hide();
			}

			$('#connect-orcid-button').click(function (ev) {
				openORCID();
			});

			$("#orcid-info")
				.click(
					function (ev) {

						var html = "<div><h2>About ORCID <img class='orcid_img' src='"
							+ OC.webroot
							+ "/apps/orcid/img/orcid.png'></h2>\
				<a class='oc-dialog-close close svg'></a>\
				<div class='about-orcid'></div></div>";

						$(html).dialog({
							dialogClass: "oc-dialog-orcid",
							resizeable: true,
							draggable: true,
							modal: false,
							height: 320,
							width: 420,
							buttons: [{
								"id": "orcidinfo",
								"text": "OK",
								"click": function () {
									$(this).dialog("close");
								}
							}
							]
						});

						$('body')
							.append(
								'<div class="modalOverlay"></div>');

						$('.oc-dialog-close')
							.live(
								'click',
								function () {
									$(
										".oc-dialog-orcid")
										.remove();
									$('.modalOverlay')
										.remove();
								});

						$('.ui-helper-clearfix').css("display",
							"none");

						$.ajax(OC.linkTo('orcid',
							'AboutOrcid.php'), {
							type: 'GET',
							success: function (jsondata) {
								if (jsondata) {
									$('.about-orcid').html(
										jsondata);
								}
							},
							error: function (data) {
								alert("Unexpected error!");
							}
						});
					});

			$(document)
				.click(
					function (e) {
						if (!$(e.target).parents().filter(
								'.oc-dialog-orcid').length
							&& !$(e.target).filter(
								'#orcid-info').length) {
							$(".oc-dialog-orcid").remove();
							$('.modalOverlay').remove();
						}
					});

		});
