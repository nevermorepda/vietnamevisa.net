<div class="cluster-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-sm-8 col-xs-12">
				<h1 class="item-title"><?=$item->title?></h1>
				<div class="clearfix">
					<?
						$types = array("[FLIGHT]", "[HOTEL]", "[TOUR]", "[AIRPORT-SERVICE]");
						$ctype = "";
						for ($i=0; $i < sizeof($types); $i++) {
							if (strpos($item->content, $types[$i]) !== FALSE) {
								$item->content = str_ireplace($types[$i], "", $item->content);
								$ctype = $types[$i];
								break;
							}
						}
					?>
					<?=$item->content?>
				</div>
			</div>
			<div class="col-lg-4 col-sm-4 d-none d-sm-none d-md-block">
				<div class="wg wg_1">
					<div class="wg_h text-center ">
						<h3 class="wg_t font-weight-bold m-0">WHY US?</h3>
					</div>
					<div class="wg_m wg_1m">
						<ul class="lt1">
							<li>Saving your time and money</li>
							<li>Fast and reliable procedure</li>
							<li>24/7 support online </li>
							<li>One stop site</li>
							<li>Secure customer’s information</li>
						</ul>
					</div>
				</div>
				<div class="support-online-widget">
					<div class="font-weight-bold text-center title">SUPPORT ONLINE</div>
					<div class="content">
						<p><i>Our pleasure to support you 24/7</i></p>

						<table class="table-borderless" cellpadding="2" width="100%">
							<tbody>
							<tr>
								<td>Address</td><td>:</td>
								<td class="address" style="padding-left: 8px"><a href="<?=ADDRESS?>"><?=ADDRESS?></a></td>
							</tr>
							<tr>
								<td>Email</td><td>:</td>
								<td class="email" style="padding-left: 8px"><a href="<?=MAIL_INFO?>"><?=MAIL_INFO?></a></td>
							</tr>
							<tr>
								<td>Tollfree</td><td>:</td>
								<td class="phone" style="padding-left: 8px"><a href="tel:<?=TOLL_FREE?>" title="TOLL FREE"><img class="pr-1" alt="TOLL FREE" src="<?=IMG_URL?>flags/United States.png"/><?=TOLL_FREE?></a></td>
							</tr>
							<tr>
								<td>Hotline</td><td>:</td>
								<td class="phone" style="padding-left: 8px"><a href="tel:<?=HOTLINE?>" title="HOTLINE"><img class="pr-1" alt="HOTLINE" src="<?=IMG_URL?>flags/Vietnam.png"/><?=HOTLINE?></a></td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
		<?
			if ($ctype == $types[0]) {
				require_once(APPPATH."views/booking/flight.php");
			}
			else if ($ctype == $types[1]) {
				require_once(APPPATH."views/booking/hotel.php");
			}
			else if ($ctype == $types[2]) {
				require_once(APPPATH."views/booking/tour.php");
			}
			else if ($ctype == $types[3]) {
				require_once(APPPATH."views/booking/airport_service.php");
			}
		?>
	</div>
</div>

