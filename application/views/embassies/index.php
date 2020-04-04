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
		<!-- <div class="pagination center">
		<?
			// $char = "A";
			// do {
				?>
				<a title="<?//=$char?>" href="#eb_<?//=$char?>"><?//=$char?></a>
				<?
			//} while ($char++ < "Z");
		?>
		</div> -->
		
		<!-- <div class="nations clearfix">
			<?
				// $char = "A";
				// do {
					?>
					<div class="row embassies" id="eb_<?//=$char?>">
						<div class="col-sm-1 col-xs-2 number"><?//=$char?></div>
						<div class="col-sm-11 col-xs-10">
							<ul class="row list">
							<?
							// if (!empty($nations) && sizeof($nations)) {
							// 	foreach ($nations as $nation) {
							// 		if (substr($nation->name, 0, 1) == $char) {
							// 			$info = new stdClass();
							// 			$info->nation = $nation->name;
							// 			$embassies = $this->m_embassy->items($info, 1);
									?>
									<li class="col-sm-3 col-xs-6">
										<a title="Vietnam embassy in <?//=$nation->name?>" href="<?//=site_url("vietnam-embassies/view/{$nation->alias}")?>"><?//=$nation->name?></a>
										<?// if (!empty($embassies)) { ?>
										<img class="png" alt="Vietnam embassy in <?//=$nation->name?>" title="Vietnam embassy in <?//=$nation->name?>" src="<?//=IMG_URL?>stick.png" />
										<?// } ?>
									</li>
									<?
									//}
								//}
						//	}
							?>
							</ul>
						</div>
					</div>
					<?
				//} while ($char++ < "Z");
			?>
		</div> -->
		<?
			$regions = array();
			foreach ($nations as $nation) {
				if (!in_array($nation->region, $regions)) {
					$regions[] = $nation->region;
				}
			}
			sort($regions);
		?>
		<? foreach ($regions as $region) { ?>
		<div class="nations clearfix">
			<div class="row embassies" id="eb_A">
				<div class="col-sm-3 col-xs-2 number"><?=$region?></div>
				<div class="col-sm-9 col-xs-10">
					<ul class="row list">
						<? 
						$info = new stdClass();
						$info->region = $region;
						$countries = $this->m_country->items($info, 1);
						$c = count($countries);
						$c_col = round($c/4);

						?>
						<li class="col-sm-3 col-xs-6">
							<? for ($i=0; $i < $c_col; $i++) { 
								if (!empty($countries[$i])) {
									$info = new stdClass();
									$info->nation = $countries[$i]->name;
									$embassies = $this->m_embassy->items($info, 1);
							?>
							<div style="display: block">
								<a title="Vietnam embassy in <?=$countries[$i]->name?>" href="<?=site_url("vietnam-embassies/view/{$this->util->slug($countries[$i]->name)}")?>"><?=$countries[$i]->name?></a>
								<? if (!empty($embassies)) { ?>
								<img class="png" alt="Vietnam embassy in <?=$countries[$i]->name?>" title="Vietnam embassy in <?=$countries[$i]->name?>" src="<?=IMG_URL?>stick.png" />
								<? } ?>
							</div>
							<? } } ?>
						</li>
						<li class="col-sm-3 col-xs-6">
							<? for ($i=$c_col; $i < $c_col*2; $i++) { 
								if (!empty($countries[$i])) {
									$info = new stdClass();
									$info->nation = $countries[$i]->name;
									$embassies = $this->m_embassy->items($info, 1);
							?>
							<div style="display: block">
								<a title="Vietnam embassy in <?=$countries[$i]->name?>" href="<?=site_url("vietnam-embassies/view/{$this->util->slug($countries[$i]->name)}")?>"><?=$countries[$i]->name?></a>
								<? if (!empty($embassies)) { ?>
								<img class="png" alt="Vietnam embassy in <?=$countries[$i]->name?>" title="Vietnam embassy in <?=$countries[$i]->name?>" src="<?=IMG_URL?>stick.png" />
								<? } ?>
							</div>
							<? } } ?>
						</li>
						<li class="col-sm-3 col-xs-6">
							<? for ($i=$c_col*2; $i < $c_col*3; $i++) { 
								if (!empty($countries[$i])) {
									$info = new stdClass();
									$info->nation = $countries[$i]->name;
									$embassies = $this->m_embassy->items($info, 1);
							?>
							<div style="display: block">
								<a title="Vietnam embassy in <?=$countries[$i]->name?>" href="<?=site_url("vietnam-embassies/view/{$this->util->slug($countries[$i]->name)}")?>"><?=$countries[$i]->name?></a>
								<? if (!empty($embassies)) { ?>
								<img class="png" alt="Vietnam embassy in <?=$countries[$i]->name?>" title="Vietnam embassy in <?=$countries[$i]->name?>" src="<?=IMG_URL?>stick.png" />
								<? } ?>
							</div>
							<? } } ?>
						</li>
						<li class="col-sm-3 col-xs-6">
							<? for ($i=$c_col*3; $i < $c_col*4; $i++) { 
								if (!empty($countries[$i])) {
									$info = new stdClass();
									$info->nation = $countries[$i]->name;
									$embassies = $this->m_embassy->items($info, 1);
							?>
							<div style="display: block">
								<a title="Vietnam embassy in <?=$countries[$i]->name?>" href="<?=site_url("vietnam-embassies/view/{$this->util->slug($countries[$i]->name)}")?>"><?=$countries[$i]->name?></a>
								<? if (!empty($embassies)) { ?>
								<img class="png" alt="Vietnam embassy in <?=$countries[$i]->name?>" title="Vietnam embassy in <?=$countries[$i]->name?>" src="<?=IMG_URL?>stick.png" />
								<? } ?>
							</div>
							<? } } ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<? } ?>
	</div>
</div>