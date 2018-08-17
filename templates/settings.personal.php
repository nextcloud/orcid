<?php
script('orcid', 'personal');
style('orcid', 'personal');

?>



<div class="section" id="orcid">
	<h2><?php p($l->t('ORCID')) ?></h2>

	<p>
		ORCID provides you with digital identifier that uniquely identifies you as a researcher.
		Learn more at <a href="https://orcid.org">orcid.org</a>.<br/>
		Connecting an ORCID identifier allows seamless publication of datasets and
		attribution of these datasets to you.
	</p>
<br />
	<p id="orcid_user_content">
				<label><?php p($l->t('Your ORCID:')); ?></label><br />
		<strong id="orcid_id"></strong>
	<label id="orcid_id"></label>
	</p>

	<p>
		<input type="submit" id="orcid_request_button" value="<?php p($l->t('Connect to ORCID')); ?>">
	</p>
</div>


