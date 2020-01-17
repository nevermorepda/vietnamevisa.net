<?
	$nations = $this->m_nation->items();
	$tour = $this->m_tour->load($booking->tour_id);

	$birthyear = (!empty($booking->birth_day) ? date("Y",strtotime($booking->birth_day)) : "");
	$birthmonth = (!empty($booking->birth_day) ? date("n",strtotime($booking->birth_day)) : "");
	$birthdate = (!empty($booking->birth_day) ? date("j",strtotime($booking->birth_day)) : "");
?>
<div class="applyform">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="box-booking-detail border">
					<div class="thumbnail">
						<img src="<?=BASE_URL.$tour->thumbnail?>">
					</div>
					<div class="p-4">
						<div class="title mb-3">
							<h2><?=$tour->title?></h2>
						</div>
						<div class="arrival-date border-bottom clearfix pb-3 mb-3">
							<div class="name-prefix"><strong>Date</strong></div>
							<div class="font-weight-semibold"><?=date("M/d/Y",strtotime($booking->arrival_date))?></div>
						</div>
						<div class="total-passenger border-bottom pb-3 mb-3">
							<div class="name-prefix"><strong>Total Passenger</strong></div>
							<div class="font-weight-semibold">Adults: <?=$booking->adults?> - Children: <?=$booking->children?> - Infants <?=$booking->infants?></div>
						</div>
						<div class="total-price mb-3">
							<div class="name-prefix"><strong>Total Price</strong></div>
							<div class="text-danger font-size-30px font-weight-semibold total-t"><?=number_format(($booking->total_fee), 2,'.',',')?> USD</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="heading-payment pb-3">
					<h1>Contact Details</h1>
					<div class="explain pb-3">
						We need your contact details to send you a confirmation email and for our guides to contact and pick you up before the tour. Rest assured, we will never share your information with any third party.
					</div>
					<form action="<?=site_url('tours/checkout')?>" method="POST">
						<div class="form-group">
							<div class="name-prefix mb-1"><strong>Contact Name</strong></div>
							<input type="text" class="form-control" id="fullname" name="fullname" value="<?=$booking->contact_fullname?>" />
						</div>
						<div class="row mb-3">
							<div class="col-12 col-sm-6 col-md-12 col-lg-6 mb-3 mb-lg-0">
								<div class="name-prefix mb-1"><strong>Email</strong></div>
								<input type="email" class="form-control" id="email" name="email" pattern="^[\w_.]+@[a-z]+(\.[a-z]+){1,2}$" value="<?=$booking->contact_email?>"/>
							</div>
							<div class="col-12 col-sm-6 col-md-12 col-lg-6 pl-3 pl-lg-0">
								<div class="name-prefix mb-1"><strong>Date of birth</strong></div>
								<div class="row">
									<div class="col-4 pl-3 pr-md-0">
										<select id="birthyear" name="birthyear" class="form-control birthyear_0 birthdate" applicant-num="0">
											<option value="">...</option>
											<? for ($y=(date("Y") - 100); $y<=date("Y"); $y++) { ?>
											<option value="<?=$y?>"><?=$y?></option>
											<? } ?>
										</select>
										<script> $("#birthyear").val("<?=$birthyear?>"); </script>
									</div>
									<div class="col-4 pl-0 pl-md-1 pr-md-0">
										<select id="birthmonth" name="birthmonth" class="form-control birthmonth_0 birthdate" applicant-num="0">
											<option value="">...</option>
											<? for ($m=1; $m<=12; $m++) { ?>
											<option value="<?=$m?>"><?=date('M', mktime(0, 0, 0, $m, 10))?></option>
											<? } ?>
										</select>
										<script> $("#birthmonth").val("<?=$birthmonth?>"); </script>
									</div>
									<div class="col-4 pr-3 pl-md-1 pl-0">
										<select id="birthdate_0" name="birthdate" class="form-control birthdate_0">
											<option value="">...</option>
											<? for ($d=1; $d<=31; $d++) { ?>
											<option value="<?=$d?>"><?=$d?></option>
											<? } ?>
										</select>
										<script> $("#birthdate_0").val("<?=$birthdate?>"); </script>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12 col-sm-6 col-md-12 col-lg-6">
								<div class="name-prefix mb-1"><strong>Nationality</strong></div>
								<select class="form-control" id="nation_id" name="nation_id">
									<option value="">Select country</option>
									<? foreach($nations as $nation) { ?>
										<option value="<?=$nation->id?>" data-code="<?=strtolower($nation->code);?>"><?=$nation->name?></option>
									<? } ?>
								</select>
							</div>
							<div class="col-12 col-sm-6 col-md-12 col-lg-6 pl-3 pl-lg-0">
								<div class="name-prefix mb-1"><strong>Phone number</strong></div>
								<input type="text" class="form-control" id="phone" name="phone" value="<?=str_replace("+ ","",$booking->contact_phone)?>" autocomplete="off"/>
							</div>
						</div>
						<div class="mb-3">
							<div class="name-prefix mb-1"><strong>Pick me at</strong></div>
							<input type="text" class="form-control" id="pickup" name="pickup" value="<?=$booking->pickup?>" required />
						</div>
						<? if (!empty($option_tours)) { ?>
						<div class="mb-3">
							<div class="name-prefix mb-1">Which option do you want to go for?</div>
							<? foreach($option_tours as $key=>$option_tour){ ?>
								<div class="mb-1">
									<input type="radio" id="option_<?=$option_tour->id?>" name="tour_option_id" value="<?=$option_tour->id?>" <?=(empty($key) ? "checked" : "")?>>
									<label for="option_<?=$option_tour->id?>"><?=$option_tour->title?></label>
								</div>
							<? } ?>
						</div>
						<? } ?>
						<div class="mb-3">
							<div class="name-prefix mb-1"><strong>Do you have any special request?</strong></div>
							<textarea class="form-control" rows="3" id="message" name="message" placeholder="Please offer more useful information about you before the trip, we will adjust to meet your demands."><?=$booking->contact_message?></textarea>
						</div>
						<div class="mb-3">
							<div class="name-prefix mb-1"><strong>How do you know about us?</strong></div>
							<input type="text" class="form-control" id="from_source" name="from_source" value="<?=$booking->from_source?>" placeholder="e.g. Tripadvisor, Facebook, Instagram, Youtube, Google, Expedia, etc."/>
						</div>
						<!-- <div class="row my-3">
							<div class="col-4 name-prefix">Allergic</div>
							<div class="col-4">
								<input class="select-allergic" type="radio" id="no_allergic" name="rb_allergic" value="0" <?=(($booking->rb_allergic==0)?"checked='checked'":"")?>/>
								<label for="no_allergic">No</label>
							</div>
							<div class="col-4">
								<input class="select-allergic" type="radio" id="yes_allergic" name="rb_allergic" value="1" <?=(($booking->rb_allergic==1)?"checked='checked'":"")?>/>
								<label for="yes_allergic">Yes</label>
							</div>
							<div class="col-12 pt-1">
								<input class="form-control d-none" type="text" id="allergic" name="allergic" placeholder="Please state the ingredients or kinds of food/drinks you're allergic to" value="<?=$booking->allergic?>"/>
							</div>
						</div> -->
						<? if (!empty($arrbiketours) && in_array($item->category_id,$arrbiketours)) { ?>
						<div class="row">
							<div class="col-12">
								<div class="font-weight-semibold mb-1">For your safety</div>
								<div>* Please indicate your individual weight (including all your travel companions) in the options below so we can arrange the most suitable guide and equipment for you</div>
							</div>
						</div>
						<div class="box-transfer pt-3 pb-4">
							<div class="box-passenger border" id="collapse-passenger">
								<div class="d-flex px-3 border-bottom">
									<div class="w-50 align-self-center">< 80 kg (176 lbs)</div>
									<div class="w-50">
										<input type="text" class="form-control text-center input-touchspin bg-transparent" id="less_80_kg" value="<?=$booking->less_80_kg?>" name="less_80_kg" required>
									</div>
								</div>
								<div class="d-flex px-3">
									<div class="w-50 align-self-center">> 80 kg (176 lbs)</div>
									<div class="w-50">
										<input type="text" class="form-control text-center input-touchspin bg-transparent" id="greater_80_kg" value="<?=$booking->greater_80_kg?>" name="greater_80_kg" required>
									</div>
								</div>
							</div>
						</div>
						<? } ?>
						<div class="mb-3 payment-method">
							<h2 class="font-size-20px font-weight-semibold mb-3 heading-payment">Payment information</h2>
							<div class="name-prefix mb-2">Payment</div>
							<div class="group-content row">
								<div class="col-4">
									<div class="form-check-inline">
										<label class="payment-list pointer form-check-label" for="pay_pal">
											<img src="<?=IMG_URL?>payment/paypal.png" alt="PayPal" class="img-fluid d-block"/>
											<input class="form-check-input d-inline-block mt-2" type="radio" id="pay_pal" name="payment_method" value="Paypal" <?=(($booking->payment_method=="Paypal"||empty($booking->payment_method))?"checked='checked'":"")?> />Credit Card by Paypal
										</label>
										
									</div>
								</div>
								<div class="col-4">
									<div class="form-check-inline">
										<label class="payment-list pointer form-check-label" for="one_pay">
											<img src="<?=IMG_URL?>payment/onepay.png" alt="OnePay" class="img-fluid d-block"/>
											<input class="form-check-input d-inline-block mt-2" type="radio" id="one_pay" name="payment_method" value="OnePay" <?=$booking->payment_method=="OnePay"?"checked='checked'":""?>/>Credit Card by OnePay
										</label>
									</div>
								</div>
								<!-- <div class="col-4">
									<div class="form-check-inline">
										<label class="payment-list pointer form-check-label" for="bank_transfer">
											<img src="<?=IMG_URL?>payment/bank_transfer.png" alt="Bank Transfer" class="img-fluid d-block"/>
											<input class="form-check-input d-inline-block mt-2" type="radio" id="bank_transfer" name="payment_method" value="Bank Transfer" <?=$booking->payment_method=="Bank Transfer"?"checked='checked'":""?>/>Bank transfer
										</label>
									</div>
								</div> -->
							</div>
						</div>
						<div class="mt-5">
							<button class="btn btn-primary btn-checkout pl-5 pr-5 pt-2 pb-2" type="submit">PAY NOW</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>