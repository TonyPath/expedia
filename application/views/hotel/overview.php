<?php $hotel = $hotelOverview->hotel; ?>
<section class=""  style="padding-top:120px;">
<div class="row">
<h1>
<?php echo $hotel->name; ?>
<br/>
<?php echo $hotel->countryCode. ', '. $hotel->city.', '. $hotel->address; ?>
</h1>
</div>

<div class="row">


<h1>Hotel Images</h1>
<hr>
<div>
<?php 
if (isset($hotel->images)):
foreach ($hotel->images as $image): 
?>
<a target="_blank" href="<?php echo $image->bigUrl; ?>"><img src="<?php echo $image->thumbUrl; ?>" style="float:left" /></a>
<?php 
endforeach;
endif; 
?>
<div style="clear: both;"></div>
</div>


<h1>Hotel Description</h1>
<hr>
<div>
<table>

<tr><td colspan="2">
<?php echo $hotel->description; ?>
</td></tr>


</table>
</div>

<h1>Hotel Amenities</h1>
<hr>
<div>
<?php 
if (isset($hotel->amenities)):
foreach ($hotel->amenities as $hotel_amenity): 
echo "&nbsp;[&nbsp;".$hotel_amenity."&nbsp;]&nbsp;";
endforeach;
endif; 
?>
<div style="clear: both;"></div>
</div>

<hr/>

<?php if (isset($hotel->rooms)) :?>
<h1>Rooms</h1>
<hr>
<div>

<?php foreach ( $hotel->rooms as $room): ?>
<?php $ratesInfo = $room->ratesInfo->allRoomsAllDays; ?>
<br/><br/>
<div class="row">

<div class="column_6">
<h1>
<?php echo html_entity_decode($room->description); ?>
</h1>
</div>

<div class="column_6" style="text-align:right;">
<?php if ($room->ratesInfo->isPromo === true) :?>
<?php echo "&nbsp;&nbsp;&nbsp;<del>".$ratesInfo->totalBasePrice."</del>"; ?>
<?php endif;?>

<?php echo $ratesInfo->totalPrice; ?>
</div>
</div>

<div class="row"><div class="column_12">
<?php 
if (isset($room->amenities)):
echo "<strong>Room Amenities:</strong>";
foreach ($room->amenities as $rootAmenity): 
echo " &nbsp;[&nbsp;".$rootAmenity."&nbsp;]&nbsp;";
endforeach;
endif; 
?>
</div>
</div>

<div class="row"><div class="column_12">
<?php 
if (isset($room->bedTypes)):
echo "<strong>Επιλογές κρεβατιών:</strong>";
foreach ($room->bedTypes as $bedType): 
echo "&nbsp;[&nbsp;".$bedType."&nbsp;]&nbsp;";
endforeach;
endif; 
?>
</div>
</div>

<div class="row"><div class="column_12">
<?php 
if (isset($room->valueAdds)):
echo "<strong>Cool Extras:</strong>";
foreach ($room->valueAdds as $valueAdss): 
echo "&nbsp;[&nbsp;".$valueAdss."&nbsp;]&nbsp;";
endforeach;
endif; 
?>
</div>
</div>

</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<hr>


</div>
</section>
