<?php
script('orcid', 'admin');
style('orcid', 'admin');

?>



<div class="section" id="orcid">
	<h2><?php p($l->t('ORCID API Credentials')) ?></h2>

	<p>
		<label><?php p($l->t('Redirect URL:')); ?></label><br />
		<label id="redirecturl"></label>
	</p>

	<p>
		<label><?php p($l->t('Client ID')); ?></label><br />
		<input type="text" id="orcid_client_appid" />
	</p>

	<p>
		<label><?php p($l->t('Client Secret')); ?></label><br />
		<input type="text" id="orcid_client_secret" />
	</p>

	<p>
		<input type="submit" id="clientsubmit" value="<?php p($l->t('Store ORCID Credentials')); ?>">
	</p>
</div>

