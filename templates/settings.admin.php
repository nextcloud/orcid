<?php
script('orcid', 'admin');
style('orcid', 'admin');

?>

<fieldset id="orcidAdminSettings" class="section">
	<h2>
		<img src="/apps/user_orcid/img/orcid.png"> ORCID
	</h2>
	<table style="width: 650px;">
		<tr class="orcid_admin_head">
			<td class="orcid_admin_head" colspan="2">Client credentials</td>
		</tr>
		<tr>
			<td class="orcid_admin_left">Client App ID:</td>
			<td><input type='text' style="width: 250px" name='inputclientappid'
				id='inputclientappid' original-title=''
				title='Set the Client app ID for OAuth'></td>
		</tr>
		<tr>
			<td class="orcid_admin_left">Client Secret:</td>
			<td><input type='text' name='inputclientsecret' style="width: 250px"
				id='inputclientsecret' original-title=''
				title='Set the Client secret for OAuth'></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' value='Store OAuth values'
				style="width: 250px" original-title='' style="width: 250px"
				id='clientsubmit' name='clientsubmit' title='Store OAuth values'></input></td>
		</tr>
	</table>
	<div id='clientstatus' style="font-size: .8em;"></div>

</fieldset>

