<?php
script('orcid', 'personal');
style('orcid', 'personal');

?>

<fieldset id="orcidPersonalSettings" class="section">
	<h2 id="orcid-info" style="width: 100px">ORCID</h2>

	<div class='orcid-popup'>
		<p>
			ORCID provides you with digital identifier that uniquely identifies you as a researcher.
			Learn more at <a href="https://orcid.org">orcid.org</a>.<br/>
			Connecting an ORCID identifier allows seamless publication of datasets and
			attribution of these datasets to you.
		</p>
	</div>
	<br/>
	<div id="orcid_user_content">
		Your ORCID: <strong id="orcid_id"></strong>
		<a title="" data-original-title="Copy Orcid" class="clipboardButton icon icon-clippy"
		   data-clipboard-target="#orcid_id" style="width: 16px; height: 16px;"></a>
		<br />
	</div>

	<div>
		<button id="orcid_request_button">
			<img id="orcid-id-logo"
				 src="https://orcid.org/sites/default/files/images/orcid_24x24.png"
				 width='24' height='24' alt="ORCID logo"/>Create or Connect your
			ORCID iD
		</button>
	</div>
</fieldset>

