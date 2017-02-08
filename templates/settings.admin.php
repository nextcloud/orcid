<?php
script('orcid', 'admin');
style('orcid', 'admin');

?>

<fieldset id="orcidAdminSettings" class="section">
	<h2>
		<img src="/apps/orcid/img/orcid.png"> ORCID
	</h2>
	<table style="width: 650px;">
		<tr class="orcid_admin_head">
			<td><div id="orcid_saving"><?php p($l->t('Saving')); ?></div></td>
			<td class="orcid_admin_head">ORCID API Credentials</td>
		</tr>

		<tr>
			<td class="orcid_admin_left orcid_moremargin">Redirect URL:</td>
			<td id="redirecturl"></td>
		</tr>
		<tr>
			<td class="orcid_admin_left">Client ID:</td>
			<td><input type='text' style="width: 300px" name='inputclientappid'
				id='inputclientappid' original-title=''
				title='Set the Client app ID for OAuth'></td>
		</tr>
		<tr>
			<td class="orcid_admin_left">Client Secret:</td>
			<td><input type='text' name='inputclientsecret' style="width: 300px"
				id='inputclientsecret' original-title=''
				title='Set the Client secret for OAuth'></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' value='Store ORCID Credentials'
				style="width: 250px" original-title='' style="width: 300px"
				id='clientsubmit' name='clientsubmit'
				title='Store ORCID Credentials'></input></td>
		</tr>
	</table>
	<div id='clientstatus' style="font-size: .8em;"></div>

</fieldset>

