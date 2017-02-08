<?php
script('orcid', 'personal');
style('orcid', 'personal');

?>

<fieldset id="orcidPersonalSettings" class="section">
	<h2 id="orcid-info" style="width: 100px">ORCID</h2>

	<?php
	if ($_['orcid'] !== '') {
		?>
		<br/>
		<div>
			<span>My ORCID : </span> <a class="orcid"
										href="https://orcid.org/<?php echo $_['orcid']; ?>">https://orcid.org/<?php echo $_['orcid']; ?></a>
		</div>
		<br/>
	<?php } ?>
	<div>
		<button id="connect-orcid-button">
			<img id="orcid-id-logo"
				 src="https://orcid.org/sites/default/files/images/orcid_24x24.png"
				 width='24' height='24' alt="ORCID logo"/>Create or Connect your
			ORCID iD
		</button>
	</div>
</fieldset>

