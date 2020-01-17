<div class="embassy">
	<div class="embassy-banner">
		<div class="container">
			<div class="alternative-breadcrumb">
			<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
			</div>
		</div>
	</div>
	<div class="">
		<div class="container center" style="margin-top: 20px; margin-bottom: 20px">
			<h1>Vietnam Embassy Worldwide</h1>
			<p class="f20">This page provides you a complete information on Vietnamese embassies' address and contacts in all countries by continent.<br/>
				Please click on the link below to get started.
			</p>
		</div>
	</div>
	<div class="container">
		<div class="pagination center">
		<?
			$char = "A";
			do {
				?>
				<a title="<?=$char?>" href="#eb_<?=$char?>"><?=$char?></a>
				<?
			} while ($char++ < "Z");
		?>
		</div>
		
		<div class="nations clearfix">
			<?
				$char = "A";
				do {
					?>
					<div class="row embassies" id="eb_<?=$char?>">
						<div class="col-sm-1 col-xs-2 number"><?=$char?></div>
						<div class="col-sm-11 col-xs-10">
							<ul class="row list">
							<?
							if (!empty($nations) && sizeof($nations)) {
								foreach ($nations as $nation) {
									if (substr($nation->name, 0, 1) == $char) {
										$info = new stdClass();
										$info->nation = $nation->name;
										$embassies = $this->m_embassy->items($info, 1);
									?>
									<li class="col-sm-3 col-xs-6">
										<a title="Vietnam embassy in <?=$nation->name?>" href="<?=site_url("vietnam-embassies/view/{$nation->alias}")?>"><?=$nation->name?></a>
										<? if (!empty($embassies)) { ?>
										<img class="png" alt="Vietnam embassy in <?=$nation->name?>" title="Vietnam embassy in <?=$nation->name?>" src="<?=IMG_URL?>stick.png" />
										<? } ?>
									</li>
									<?
									}
								}
							}
							?>
							</ul>
						</div>
					</div>
					<?
				} while ($char++ < "Z");
			?>
		</div>
	</div>
</div>