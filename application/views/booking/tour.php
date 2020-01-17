<script type="text/javascript" src="<?=JS_URL?>apply.tour.js"></script>
<div class="service-form">
	<div class="service-title">Make an Tour Booking Request</div>
	<p>
	You will need to fill some information to complete your request.<br/>
	We will confirm to you by phone or email within 2 hours.
	</p>
	<div class="clearfix">
		<form name="frmRequestService" class="form-horizontal" role="form" action="<?=site_url("booking/tour")?>" method="POST">
			<div class="row clearfix">
				<div class="col-md-6">
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Arrival Date <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="arrivalDate" name="arrivalDate" value="" class="form-control arrival-date" placeholder="mm/dd/yyyy" />
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Departure Date <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="departureDate" name="departureDate" value="" class="form-control departure-date" placeholder="mm/dd/yyyy" />
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
								<label class="control-label">Category</label>
							</div>
							<div class="col-md-12">
								<select id="category" name="category" class="form-control category">
									<option value="All" selected="selected" value="">All</option>
									<option value="Beach Relax">Beach Relax</option>
									<option value="Central Vietnam tours">Central Vietnam tours</option>
									<option value="Cycling Tours ( Biking tours)">Cycling Tours ( Biking tours)</option>
									<option value="Excursions in Dalat">Excursions in Dalat</option>
									<option value="Excursions in Halong">Excursions in Halong</option>
									<option value="Excursions in Hanoi">Excursions in Hanoi</option>
									<option value="Excursions in Hoian">Excursions in Hoian</option>
									<option value="Excursions in Hue">Excursions in Hue</option>
									<option value="Excursions in Nhatrang">Excursions in Nhatrang</option>
									<option value="Excursions in Phu Quoc">Excursions in Phu Quoc</option>
									<option value="Excursions in Saigon &amp; Mekong Delta">Excursions in Saigon &amp; Mekong Delta</option>
									<option value="Excursions in Sapa">Excursions in Sapa</option>
									<option value="Free &amp; Easy">Free &amp; Easy</option>
									<option value="Golf tours">Golf tours</option>
									<option value="Northern Vietnam tours">Northern Vietnam tours</option>
									<option value="Photograph Around">Photograph Around</option>
									<option value="Southern Vietnam tours">Southern Vietnam tours</option>
									<option value="Througout Vietnam tours">Througout Vietnam tours</option>
									<option value="Vietnamese Culinary">Vietnamese Culinary</option>
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
									<option value="Under $50">Under $50</option>
									<option value="$50-$100">$50-$100</option>
									<option value="$100-$150">$100-$150</option>
									<option value="$150-$200">$150-$200</option>
									<option value="$200-$250">$200-$250</option>
									<option value="$250-$300">$250-$300</option>
									<option value="$300-$400">$300-$400</option>
									<option value="$400-$500">$400-$500</option>
									<option value="$500-$1000">$500-$1000</option>
									<option value="$1000-$1200">$1000-$1200</option>
									<option value="$1200-$1400">$1200-$1400</option>
									<option value="$1400-$1600">$1400-$1600</option>
									<option value="$1600-$1800">$1600-$1800</option>
									<option value="$1800-$2000">$1800-$2000</option>
									<option value="From $2000">From $2000</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">How many Travelers? <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="travelers" name="travelers" value="" class="form-control travelers" />
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
	$(".arrival-date").datepicker(dateoptions);
	$(".departure-date").datepicker(dateoptions);
});
</script>