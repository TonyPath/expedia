
<script type="text/javascript">

</script>

<style type="text/css">
.template {
	display:none;
}
</style>

<section class="frmSearchHotelHomePage"  style="padding-top:120px;">


<form action="<?php base_url();?>hotel/index" method="get">

	<input type="hidden" id="item_id" name="item_id" value="" />
	<input type="hidden" id="item_category" name="item_category" value="" />
	
	<div class="row">

		<div class="column_4">
			City, Landmark, Airport<br/>
			<input type="text" id="destination_string" name="destination_string" value=""  />
		</div>
		
		<div class="column_3">
			Check In (Optional)<br/>
			<input type="text" id="arrival_date" name="arrival_date" value=""  />
		</div>
		
		<div class="column_3">
			Check Out (Optional)<br/>
			<input type="text" id="departure_date" name="departure_date"  value="" />
		</div>
		
		<div class="column_2">
			Nights<br/>
			<input type="text" id="nights" name="nights" value="" disabled />
		</div>

	</div>
	
	<div class="row" id="no_result" style="color:red; font-size:12pt; display: none;">
		<div class="column_12">
		No result found matching your criteria.
		</div>
	</div>
	
	<div class="row" id="blank_destination" style="color:red; font-size:12pt; display: none;">
		<div class="column_12">
		Please enter a city, landmark, airport.
		</div>
	</div>
	
	<br />
	
	<div class="row">
		
		<div class="column_2">
			Rooms<br/>
			<select id="search_room" name="search_room" class="select">
					<?php foreach(range(1, 8) as $room_id) :?>
					<option value="<?php echo $room_id; ?>"><?php echo $room_id; ?></option>
					<?php endforeach; ?>
			</select>
		</div>
		
		<div class="column_8" id="room-group-container">
		</div>
		
		<div class="column_2">
			<input type="button" class="button" value="Search"  id="btnSearchHotel" />			
		</div>
		
	</div>

</form>

</section>

<div class="template">
	<div id="room-group-template">
	<div class="row">
	
		<div class="column_2 room-field"></div>
	
		<div class="column_3 adult-field">
		
			<div id="adult-block-0">
				<span class="">Adults</span>
				
					<select class="select sp_room" id="adult-1">
						<?php foreach(range(1, 4) as $a_id) :?>
						<option value="<?php echo $a_id; ?>"><?php echo $a_id; ?></option>
						<?php endforeach; ?>
					</select>
					
			</div>
		
		</div>
		
		<div class="column_3 child-field">
			
			<div id="children-block-0" class="children-block">
				<span class="">Children</span>
				<select class="select child-box" id="children-1">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
				</select>
				
				<?php foreach(range(0, 3) as $id) :?>				
				<div id="age-block-<?php echo $id; ?>" style="display:none" class="age-block">
					<span class="">Age</span>
					<select class="sp_room age-field" id="age-<?php echo $id; ?>">
						<option value="0"><1</option>
						<?php foreach(range(1, 17) as $id) : ?>
						<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
	</div>
</div>