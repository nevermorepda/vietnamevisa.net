<script type="text/javascript" src="<?=JS_URL?>apply.hotel.js"></script>
<div class="service-form">
	<div class="service-title">Make an Hotel Reservation Request</div>
	<p>
	You will need to fill some information to complete your request.<br/>
	We will confirm to you by phone or email within 2 hours.
	</p>
	<div class="clearfix">
		<form name="frmRequestService" class="form-horizontal" role="form" action="<?=site_url("booking/hotel")?>" method="POST">
			<div class="row clearfix">
				<div class="col-md-6">
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Check-in Date <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" name="checkinDate" value="" class="form-control checkin-date" placeholder="mm/dd/yyyy" />
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Check-out Date <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" name="checkoutDate" value="" class="form-control checkout-date" placeholder="mm/dd/yyyy" />
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Destination <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<select id="destination" name="destination" class="form-control destination">
									<option value="Buon Ma Thuot">Buon Ma Thuot</option>
									<option value="Can Tho">Can Tho</option>
									<option value="Chau Doc">Chau Doc</option>
									<option value="Da Lat">Da Lat</option>
									<option value="Da Nang">Da Nang</option>
									<option value="Hai Phong">Hai Phong</option>
									<option value="Ha Long">Ha Long</option>
									<option value="Ha Noi">Ha Noi</option>
									<option value="Ho Chi Minh">Ho Chi Minh</option>
									<option value="Hoi An">Hoi An</option>
									<option value="Hue">Hue</option>
									<option value="Nha Trang">Nha Trang</option>
									<option value="Phan Thiet">Phan Thiet</option>
									<option value="Phnom Penh">Phnom Penh</option>
									<option value="Phu Quoc">Phu Quoc</option>
									<option value="Quy Nhon">Quy Nhon</option>
									<option value="Sapa">Sapa</option>
									<option value="Siem Riep">Siem Riep</option>
									<option value="Vung Tau">Vung Tau</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Budget</label>
							</div>
							<div class="col-md-12">
								<select id="budget" name="budget" class="form-control budget">
									<option value="10-50">$10-$50</option>
									<option value="60-100">$60-$100</option>
									<option value="100-200">$100-$200</option>
									<option value="200-300">$200-$300</option>
									<option value="300-400">$300-$400</option>
									<option value="400">Over $400</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Star(s)</label>
							</div>
							<div class="col-md-12">
								<select id="stars" name="stars" class="form-control stars">
									<option value="1">1 star</option>
									<option value="2">2 stars</option>
									<option value="3">3 stars</option>
									<option value="4">4 stars</option>
									<option value="5">5 stars</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Number of Rooms <span class="required"></span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="rooms" name="rooms" class="form-control rooms" />
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Type of Room</label>
							</div>
							<div class="col-md-12">
								<select id="occupancy" name="occupancy" class="form-control occupancy">
									<option value="Single">Single</option>
									<option value="Double">Double</option>
									<option value="Twins">Twins</option>
									<option value="Tripple">Tripple</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Your Name <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="fullname" name="fullname" value="" class="form-control fullname" />
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Your Email <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="email" name="email" value="" class="form-control email" />
								<span class="help-block">Your booking status will be sent to this email</span>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Phone Number</label>
							</div>
							<div class="col-md-12">
								<input type="text" id="phone" name="phone" value="" class="form-control phone" />
								<span class="help-block">To contact and assist you directly in urgent case.</span>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Special Request</label>
							</div>
							<div class="col-md-12">
								<textarea id="special-request" name="specialRequest" class="form-control" rows="6"></textarea>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<button type="submit" class="btn btn-danger btnstep">Send Request</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	var dateoptions = {
		dateFormat : 'mm/dd/yy',
		numberOfMonths: 2,
		minDate: 0
	};
	$(".checkin-date").datepicker(dateoptions);
	$(".checkout-date").datepicker(dateoptions);
});
</script>