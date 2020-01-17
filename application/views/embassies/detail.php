<div class="container" style="margin-bottom: 40px;">
	<div class="row clearfix">
	<?
		$requirement = $this->m_requirement->load($nation->alias);
		
		$info = new stdClass();
		$info->nation = $nation->name;
		$tips = $this->m_tips->items($info, 1);
		
		if (!empty($item)) {
	?>
		<div class="col-sm-7 embassy-l">
			<h1 class="page-title"><?=$item->title?></h1>
			<div><?=$item->content?></div>
			<p>--&gt;</p>
			<? if (!empty($requirement)) {?>
			<p><a title="<?=$requirement->title?>" href="<?=site_url("visa-requirements/".$nation->alias)?>"><?=$requirement->title?></a></p>
			<? } ?>
			<? if (!empty($tips)) {?>
			<p><a title="<?=$tips[0]->title?>" href="<?=site_url("vietnam-visa-tips/view/{$tips[0]->alias}")?>"><?=$tips[0]->title?></a></p>
			<? } ?>
		</div>
	<?
		} else {
	?>
		<div class="col-sm-7 embassy-l">
			<h1 class="page-title">Vietnam Embassy in <?=$nation->name?></h1>
			<p>At present, there is no information about the Embassy of Vietnam in <?=$nation->name?>. </p>
			<p>- Visit the nearest Vietnam Embassy in the neighboring country to apply for a visa by yourself, or </p>
			<p>- Apply online at <a title="<?=SITE_NAME?>" href="<?=BASE_URL_HTTPS."/apply-visa.html"?>"><?=SITE_NAME?></a> for a Vietnam visa on arrival (picked up at the arrival airport in Vietnam) </p>
			<p>--&gt;</p>
			<? if (!empty($requirement)) {?>
			<p><a title="<?=$requirement->title?>" href="<?=site_url("visa-requirements/".$nation->alias)?>"><?=$requirement->title?></a></p>
			<? } ?>
			<? if (!empty($tips)) {?>
			<p><a title="<?=$tips[0]->title?>" href="<?=site_url("vietnam-visa-tips/view/{$tips[0]->alias}")?>"><?=$tips[0]->title?></a></p>
			<? } ?>
			<div style="margin-top:20px;">
				<p>If you have any queries or comments, kindly <a title="contact us" href="<?=site_url("contact")?>">contact us</a> to get support.</p>
			</div>
		</div>
	<?
		}
	?>
		<div class="col-sm-5 d-none d-sm-none d-md-block">
			<div class="embassy-r">
				<h4>Embassy of Vietnam in other countries</h4>
				<div class="embassy-scroll">
				<?
					$char = "A";
					do {
						?>
						<div class="line-embassy">
							<div class="bgnumber"><?=$char?></div>
							<ul class="list-embassy">
							<?
							if (!empty($nations) && sizeof($nations)) {
								foreach ($nations as $nation) {
									if (substr($nation->name, 0, 1) == $char) {
										$info->nation = $nation->name;
										$embassies = $this->m_embassy->items($info, 1);
									?>
									<li>
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
						<?
					} while ($char++ < "Z");
				?>
				</div>
			</div>
		</div>
	</div>
</div>