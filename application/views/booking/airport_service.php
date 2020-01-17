<?
	$arrival_ports = $this->m_arrival_port->items(NULL, 1);
?>

<script type="text/javascript" src="<?=JS_URL?>apply.service.js"></script>
<div class="service-form clearfix">
	<div class="service-title">Needing Extra Service ?</div>
	<p>Please complete the form then we contact to you soon.</p>
	<div class="airport-service-form clearfix">
		<form name="frmRequestService" class="form-horizontal" role="form" action="<?=site_url("booking/airport_service")?>" method="POST">
			<div class="service-options clearfix">
				<div class="step-title">1. What you need?</div>
				<div class="row clearfix">
					<div class="col-md-8">
						<div class="clearfix">
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Airport fast track ?</label>
								</div>
								<div class="col-md-8">
									<div class="row clearfix">
										<div class="col-md-4">
											<input type="radio" id="airport-fast-track-vip" name="airport-fast-track" value="2" class="airport-fast-track" checked="checked"> <label for="airport-fast-track-vip">VIP</label>
										</div>
										<div class="col-md-4">
											<input type="radio" id="airport-fast-track-normal" name="airport-fast-track" value="1" class="airport-fast-track"> <label for="airport-fast-track-normal">Normal</label>
										</div>
										<div class="col-md-4">
											<input type="radio" id="airport-fast-track-no" name="airport-fast-track" value="0" class="airport-fast-track"> <label for="airport-fast-track-no">No</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Car pick-up ?</label>
								</div>
								<div class="col-md-8">
									<div class="row clearfix">
										<div class="col-md-4">
											<input type="radio" id="car-pickup-yes" name="car-pickup" value="1" class="car-pickup" checked="checked"> <label for="car-pickup-yes">Yes</label>
										</div>
										<div class="col-md-4">
											<input type="radio" id="car-pickup-no" name="car-pickup" value="0" class="car-pickup"> <label for="car-pickup-no">No</label>
										</div>
									</div>
									<div class="car-select" id="car-select" style="display: none; margin-top: 5px;">
										<div class="row ">
											<div class="col-md-6">
												<select class="form-control car-type" name="car-type" id="car-type">
													<option value="Economic Car" selected="selected">Economic Car</option>
												</select>
											</div>
											<div class="col-md-6">
												<select class="form-control num-seat" name="num-seat" id="num-seat">
													<option value="4" selected="selected">4 seats</option>
													<option value="7">7 seats</option>
													<option value="16">16 seats</option>
													<option value="24">24 seats</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Arrival port / airport</label>
								</div>
								<div class="col-md-8">
									<select id="arrival-port" name="arrival-port" class="form-control arrival-port">
										<?
											foreach ($arrival_ports as $arrival_port) {
												if (in_array($arrival_port->code, array("SGN", "HAN", "DAN", "CXR"))) {
										?>
										<option value="<?=$arrival_port->id?>"><?=$arrival_port->airport?></option>
										<?
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Number of person</label>
								</div>
								<div class="col-md-8">
									<select id="group-size" name="group-size" class="form-control group-size">
										<? for ($i=1; $i<=15; $i++) { ?>
										<option value="<?=$i?>"><?=$i." person".(($i>1)?"s":"")?></option>
										<? } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel-fees">
							<ul>
								<li class="clearfix">
									<label>Number of person:</label>
									<span class="group-size-t">...</span>
								</li>
								<li class="clearfix">
									<label>Arrival port:</label>
									<span class="arrival-port-t">...</span>
								</li>
								<li class="clearfix">
									<label>Airport fast track:</label>
									<span class="airport-fast-track-t price">0 $</span>
								</li>
								<li class="clearfix car-pickup-li">
									<label>Car pick-up:</label>
									<span class="car-pickup-t price">0 $</span>
								</li>
								<li class="clearfix" id="promotion_li" style="background-color: #F8F8F8;">
									<div id="promotion-box-input" >
										<div class="row clearfix">
											<label class="col-md-6">Got a promotion code?</label>
											<div class="col-md-6">
												<div class="input-group">
													<input type="text" class="promotion form-control" id="promotion_code" name="promotion_code" value=""/>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="clearfix total">
									<label>TOTAL FEES:</label>
									<span class="total_price">20 $</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="div"></div>
			<div class="contact-information clearfix">
				<div class="step-title">2. Who we can pickup at the airport?</div>
				<div class="row clearfix">
					<div class="col-md-8">
						<div class="clearfix">
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Welcome name <span class="required">*</span></label>
								</div>
								<div class="col-md-8">
									<div class="row clearfix">
										<div class="col-md-4">
											<select id="name-prefix" name="name-prefix" class="form-control name-prefix">
												<option value="Mr.">Mr.</option>
												<option value="Mrs.">Mrs.</option>
												<option value="Mss.">Mss.</option>
											</select>
										</div>
										<div class="col-md-8">
											<input type="text" id="welcome-name" name="welcome-name" class="form-control welcome-name" value="" placeholder="John Smith">
										</div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Arrival date and time <span class="required">*</span></label>
								</div>
								<div class="col-md-8">
									<div class="input-group">
										<input type="text" id="arrival-date" name="arrival-date" value="" class="arrival-date form-control" readonly placeholder="mm/dd/yyyy 10:30AM">
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Flight number <span class="required">*</span></label>
								</div>
								<div class="col-md-8">
									<input type="text" id="flight-number" name="flight-number" class="form-control flight-number" value="" placeholder="VN123">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="welcome-board">
							<div class="welcome">Welcome to Vietnam</div>
							<div class="welcome-name-t"></div>
							<div>Flight No: <span class="flight-number-t"></span></div>
							<div>Arrival time: <span class="arrival-time-t"></span> (GMT +7)</div>
						</div>
					</div>
				</div>
			</div>
			<div class="div"></div>
			<div class="contact-information">
				<div class="step-title">3. Who we can contact via Email?</div>
				<div class="row clearfix">
					<div class="col-md-8">
						<div class="clearfix">
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Your fullname <span class="required">*</span></label>
								</div>
								<div class="col-md-8">
									<input type="text" id="fullname" name="fullname" class="form-control fullname" value="">
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Email <span class="required">*</span></label>
								</div>
								<div class="col-md-8">
									<input type="text" id="email" name="email" class="form-control email" value="">
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Phone number</label>
								</div>
								<div class="col-md-8">
									<input type="text" id="phone-number" name="phone-number" class="form-control phone-number" value="">
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Comment</label>
								</div>
								<div class="col-md-8">
									<textarea type="text" id="special-request" name="special-request" class="form-control special-request" value="" rows="5"></textarea>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label class="control-label">Captcha <span class="required">*</span></label>
								</div>
								<div class="col-md-8">
									<div class="left">
										<input type="text" style="width: 100px" value="" id="security_code" name="security_code" required="" class="form-control">
									</div>
									<div class="left" style="margin-left: 10px; line-height: 30px;">
										<label class="security-code"><?=$this->util->createSecurityCode()?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
					</div>
				</div>
			</div>
			<div class="div"></div>
			<div class="payment-method">
				<div class="step-title">4. Your payment method</div>
				<p class="hidden">Select one of below payment method to proceed the payment</p>
				<div class="row">
					<div class="col-xs-6 col-sm-6 text-center">
						<label for="payment3"><img class="img-responsive" src="<?=IMG_URL?>payment/paypal.png" alt="Paypal" /></label>
						<br />
						<div class="radio">
							<label><input id="payment3" type="radio" name="payment" value="Paypal" checked="checked" />Paypal</label>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 text-center hidden">
						<label for="payment1"><img class="img-responsive" src="<?=IMG_URL?>payment/onepay.png" alt="OnePay" /></label>
						<br />
						<div class="radio">
							<label><input id="payment1" type="radio" name="payment" value="OnePay" />OnePay</label>
						</div>
					</div>
				</div>
			</div>
			<div class="contact-button text-center">
				<!-- <button type="submit" class="btn btn-danger btnstep">SUBMIT</button> -->
				<div class="show-button m-4">
					<a class="btn btn-general" type="submit">SUBMIT</a>
					<div class="bg-btn transition" style="width: 100%;"></div>
				</div>
			</div>
		</form>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".arrival-date").daterangepicker({
		singleDatePicker: true,
		timePicker: true,
		timePickerIncrement: 5,
		startDate: "<?=date('m/d/Y H:i', strtotime("+1 hour"))?>",
		endDate: "<?=date('m/d/Y H:i', strtotime("+1 hour"))?>",
		locale: {
			format: 'MM/DD/YYYY h:mm A'
        }
    });
	$(".fa-arrival-date").click(function(){
		$(".arrival-date").trigger("click");
	});
});
</script>
<script>
	$(document).ready(function() {
		$('.btn').mouseenter(function() {
			$(this).parent().find('.bg-btn').css({'top':'0px','left':'0px'});
		});
		$('.btn').mouseleave(function() {
			$(this).parent().find('.bg-btn').css({'top':'10px','left':'10px'});
		});
	});
</script>
