<?
	$k_single_supple = -1;
	$arr_passenger = array("adults" => 1,"children" => 2, "infants" => 3);

	$arrdurationmerger = array();
	$arrduration = array();
	$arrtype = array();
	$hassupplement = false;
	$hasinfants = false;

	foreach($rates as $rate){
		$duartion = array();
		if ($rate->type_passenger == 3) {
			$hasinfants = true;
		}
		if ($rate->single_supplement) {
			$hassupplement = true;
		} else {
			if (!array_key_exists($rate->type_passenger, $arrduration)) {
				$arrduration[$rate->type_passenger] = array();
			}
			if (!in_array($rate->group_size, $arrduration[$rate->type_passenger])) {
				$arrduration[$rate->type_passenger][$rate->group_size] = $rate->group_size;
			}
			if (!in_array($rate->type_passenger,$arrtype)) {
				$arrtype[$rate->type_passenger] = $rate->type_passenger;
			}
			if (!in_array($rate->group_size, $arrdurationmerger)) {
				$arrdurationmerger[] = $rate->group_size;
			}
		}
	}
	ksort($arrdurationmerger);
	$arrcolspan = array();
	foreach($arrduration as $key=>$val) {
		$count = 0;
		foreach($arrdurationmerger as $valduration) {
			if (!in_array($valduration,$val)) {
				$count++;
				$arrcolspan[$key][$key_colspan] = $count;
			}
			else {
				$key_colspan = $valduration;
				$count = 0;
			}
		}
	}
	if (sizeof($arrdurationmerger)) {
		$arrduration_txt = array();
		$arrduration_key = array_values($arrdurationmerger);
		$arrduration_len = sizeof($arrduration_key);
		for($k=0; $k<$arrduration_len; $k++){
			$next = (($arrduration_len > ($k+1))?($arrduration_key[$k+1]):NULL);
			$curr = $arrduration_key[$k];
			if ($next == NULL) {
				$arrduration_txt[$curr] = $curr." plus";
			} else if (($curr+1) < $next) {
				$arrduration_txt[$curr] = $curr."-".($next-1)." pax";
			} else {
				$arrduration_txt[$curr] = $curr." pax";
			}
		}
	}
?>
<div class="booking-tour">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div class="box-content">
					<h1 class="heading mb-4"><?=$item->title;?></h1>
					<div class="description mb-4"><?=$item->description;?></div>
				</div>
				<div class="price-table">
					<table class="price table table-bordered">
						<tbody>
							<tr style="background-color: #ed1c24;;" class="tbl-heading">
								<td colspan="<?=sizeof($arrduration_txt)+($hassupplement?1:0)+1?>"><h3 class="heading-table text-white font-weight-semibold mb-0">TOUR RATES (price/passenger)</h3></td>
							</tr>
							<tr class="tbl-content">
								<th class="heading-text">No. of pax</th>
								<? foreach ($arrduration_txt as $duration => $val) { ?>
								<th class="text-center heading-pax"><?=$val?></th>
								<? } ?>
								<? if ($hassupplement) { ?>
								<th class="text-center heading-pax">Single Supplement</th>
								<? } ?>
							</tr>
							<tr class="tbl-content">
								<?
									$irow = 0;
									foreach ($arrtype as $type => $valtype) {
										switch($valtype) {
											case "1":
												$passenger = "Adults"; break;
											case "2":
												$passenger = "Children (Age 5 - 12)"; break;
											case "3":
												$passenger = "Infants"; break;
											default: 
												$passenger = "Adults"; break;
										}
										if ($irow++) {
											echo '</tr><tr class="tbl-content">';
										}
										echo '<td class="heading-text font-weight-bold" style="min-width:110px;">'.$passenger.'</td>';
										$arrpassenger = array($arr_passenger["adults"]=>0,$arr_passenger["children"]=>0,$arr_passenger["infants"]=>0,'rowspan_1'=>0,'rowspan_2'=>0,'rowspan_3'=>0);
										foreach ($arrduration[$valtype] as $duration => $valduration) {
											$colspan = (array_key_exists($valtype,$arrcolspan) && array_key_exists($valduration,$arrcolspan[$valtype])) ? ($arrcolspan[$valtype][$valduration]+1) : 1;
											$hasrate = 0;
											foreach ($rates as $rate) {
												if ($rate->group_size == $valduration && !$rate->single_supplement && $rate->type_passenger == $valtype) {
													echo '<td '.(($colspan) ? "colspan='{$colspan}'" : "").' class="text-center"><span class="price font-weight-semibold">'.number_format($rate->price,0,'.',',').'</span> <span class="unit font-weight-semibold">USD</span></td>';
													$hasrate = 1;
													unset($rate);
													break;
												}
											}
											if (!$hasrate) {
												echo '<td class="text-center">-</td>';
											}
										}
										if ($hassupplement) {
											$hasrate = 0;
											foreach ($rates as $rate) {
												if ($rate->type_passenger == $valtype && $rate->single_supplement) {
													echo '<td class="text-center"><span class="price font-weight-semibold">+'.number_format($rate->price,0,'.',',').' <span class="unit font-weight-semibold">USD</span></td>';
													$hasrate = 1;
													unset($rate);
													break;
												}
											}
											if (!$hasrate) {
												echo '<td class="text-center">-</td>';
											}
										}
									}
								?>
							</tr>
						</tbody>
					</table>
					<span class="text-danger font-weight-semibold">* Infants: (Under 5 years old - Free for 1 child only)</span>
				</div>
				<div class="panel-detail highlights">
					<h3 class="heading-title">HIGHLIGHTS</h3>
					<?=$item->highlights;?>
				</div>
				<div class="panel-detail itinerary">
					<h3 class="heading-title">ITINERARY</h3>
					<?=$item->itinerary;?>
				</div>
				<div class="panel-detail inclusion">
					<h3 class="heading-title">INCLUSION</h3>
					<?=$item->inclusion;?>
				</div>
				<div class="panel-detail exclusion">
					<h3 class="heading-title">EXCLUSION</h3>
					<?=$item->exclusion;?>
				</div>
				<div class="panel-detail notes">
					<h3 class="heading-title">CANCELLATION POLICY AND REFUND</h3>
					<div><p>All sales are final and incur 100% cancellation penalties.</p></div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box-transfer">
					<form action="">
						<div class="heading p-3"><?=$item->title;?></div>
						<div class="p-3">
							<div class="select-date mb-3">
								<label class="title">Select Date</label>
								<input id="datepicker" width="100%" value=""/>
								<script>
									$('#datepicker').datepicker({
									uiLibrary: 'bootstrap4',
									format: 'yyyy-mm-dd',
									value: '<?=date('Y-m-d',strtotime('+1days'));?>',
									minDate: '<?=date('Y-m-d',strtotime('+1days'));?>',
								});
								</script>
							</div>
							<div class="passenger mb-3">
								<label class="title">Guest</label>
								<div class="box-passenger">
									<div class="type-passenger clearfix">
										<p class="label float-left">Adults</p>
										<div class="touchspin float-right">
											<div class="minus-btn">
												<span class="operation" style="padding: 0 10px; cursor:pointer;" typ="adult">-</span>
											</div>
											<div class="passenger-amount">
												<span class="amount-adults" style="padding: 0 10px;">1</span>
											</div>
											<div class="plus-btn">
												<span class="operation" style="padding: 0 8px; cursor:pointer;" typ="adult">+</span>
											</div>
										</div>
									</div>

									<div class="type-passenger clearfix">
										<p class="label float-left">Childrens</p>
										<div class="touchspin float-right">
											<div class="minus-btn">
												<span class="operation" style="padding: 0 10px; cursor:pointer;" typ="child">-</span>
											</div>
											<div class="passenger-amount">
												<span class="amount-childs" style="padding: 0 10px; ">0</span>
											</div>
											<div class="plus-btn">
												<span class="operation" style="padding: 0 8px; cursor:pointer;" typ="child">+</span>
											</div>
										</div>
									</div>

									<div class="type-passenger clearfix">
										<p class="label float-left">Infants</p>
										<div class="touchspin float-right">
											<div class="minus-btn">
												<span class="operation" style="padding: 0 10px; cursor:pointer;" typ="infant">-</span>
											</div>
											<div class="passenger-amount">
												<span class="amount-infants" style="padding: 0 10px;">0</span>
											</div>
											<div class="plus-btn">
												<span class="operation" style="padding: 0 8px; cursor:pointer;" typ="infant">+</span>
											</div>
										</div>
									</div>

								</div>
							</div>
							<script>
								get_tour_fee();
								$('.operation').click(function(event) {
									a = parseFloat($(this).parents('.touchspin').find('.passenger-amount > span').html());
									typ = $(this).attr('typ');
									if($(this).html() == '+') {
										$(this).parents('.touchspin').find('.passenger-amount > span').html(a+1);
									} else {
										if (((typ == 'adult') && (a > 1)) || ((typ == 'child') && (a > 0)) || ((typ == 'infant') && (a > 0))) {
											$(this).parents('.touchspin').find('.passenger-amount > span').html(a-1);
										}
									}
									get_tour_fee();
								});
										// ad = parseInt($('.amount-adults').html());
										// ac = parseInt($('.amount-childs').html());
										// ai = parseInt($('.amount-infants').html());

										// pa = parseFloat($('.price-adults').html());
										// pc = parseFloat($('.price-childs').html());
										// pi = parseFloat($('.price-infants').html());
										// total = ((ad*pa)+(ac*pc));
										// if (ai > 1) {
										// 	total += (pi*ai);
										// }
								function get_tour_fee() {
									var p = {};
										p['amount-adult'] = parseInt($('.amount-adults').html());
										p['amount-child'] = parseInt($('.amount-childs').html());
										p['amount-infant'] = parseInt($('.amount-infants').html());
										p['id'] = <?=$item->id;?>;
										
									$.ajax({
										url: '<?=site_url('tours/ajax_api');?>',
										type: 'post',
										dataType: 'json',
										data: p,
										success: function(result) {
											$('.total').html(reuslt);
										}
									});
								}
							</script>
							<div class="promotion-code">
								<label class="title">Promo code</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2">
									<div class="input-group-append">
										<button class="btn btn-danger" type="button">Apply</button>
									</div>
								</div>
							</div>
							<div class="total-price mb-3 clearfix">
								<label class="title float-left">Total price</label>
								<div class="float-right" style="font-size: 20px; font-weight: 600; color: #ed1c24;"><span class="total"></span>USD</div>
							</div>
							<a class="btn btn-success w-100 btn-review py-2 text-white font-weight-bold mb-3">PROCEED TO PAYMENT</a>
							<div class="text-center">
								<div>We accept online payment with</div>
								<ul class="payment-list">
									<li class="icon-payment-paypal"><i class="fa fa-cc-paypal" aria-hidden="true"></i></li>
									<li class="icon-payment-mastercard"><i class="fa fa-cc-mastercard" aria-hidden="true"></i></li>
									<li class="icon-payment-visa"><i class="fa fa-cc-visa" aria-hidden="true"></i></li>
									<!-- <li class="icon-payment-american-express"></li>
									<li class="icon-western-union"></li>
									<li class="icon-one-pay"></li> -->
								</ul>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>