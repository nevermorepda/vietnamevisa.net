<div class="">
	<div class="container">
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
</div>

