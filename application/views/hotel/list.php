<?php $copy_params = $_GET; ?>
<script type="text/javascript">

</script>

<style type="text/css">
.template {
	display:none;
}
</style>

<section style="padding-top:120px;">

	<div id="hotels-list" style = "min-height: 100px;"></div>
	
</section>


<script type="text/javascript">
var g_hashParams = JSON.stringify(<?php echo json_encode($copy_params); ?>);
var g_cache_key ='';
var g_cache_location = '';
var g_is_more_results = true;
var g_total_results = 0;
var g_items_showed = 0;
var g_allow_ajax_loading =false;
var g_total_results = 0;
var g_items_showed = 0;
</script>