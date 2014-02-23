		<!-- begin header section -->
		
		<header class="bck theme_opacity noise text color white padding-none margin-none hide-phone" id="header" style="padding:0px 0">
			<div class="row" style="overflow:visible">
				<div class="column_2 logo" style="padding-top:12px">
					<h5 class="text bold   "  ><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>img/icons/stgu_logo.png" width="24" class="inline" style="margin-right:2px"/> staygusto</a></h5>
				</div>
				<div class="column_5 ">
					<div id="header_stay" class=" on-left wrapper-dropdown-2 column_2" tabindex="1" style="width:75px;margin-right:10px;" ">
						 STAY
						<ul class="dropdown">
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">POPULAR UNHOTEL</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">POPULAR HOTELS</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">MOST REQUESTED HOTELS THIS SEASON</a></li>
						</ul>
					</div>
					<div id="header_travel" class=" on-left wrapper-dropdown-2 column_2 " tabindex="2" style="width:90px; margin-right:10px;">
						 TRAVEL
						<ul class="dropdown">
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">POPULAR UNHOTEL</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">POPULAR HOTELS</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">MOST REQUESTED HOTELS THIS SEASON</a></li>
						</ul>
					</div>
					<div id="header_explore" class=" on-left wrapper-dropdown-2 column_2" tabindex="3" style="width:105px">
						 EXPLORE
						<ul class="dropdown">
							<li><a href="<?php echo base_url('en/search/results'); ?>">SEARCH RESULTS</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">LISTING DETAILS</a></li>
							<li><a href="<?php echo base_url('en/user/login'); ?>">LOGIN</a></li>
							<li><a href="<?php echo base_url('en/user/register'); ?>">REGISTER</a></li>
							<li><a href="<?php echo base_url('en/password/forgot'); ?>">FORGOT</a></li>
							<li><a href="<?php echo base_url('en/user'); ?>">EDIT PROFILE</a></li>
						</ul>
					</div>
				</div>
				<?php if(1==1){ ?>
				<div class="column_5 show-screen ">
					<div id="header_travel" class=" on-right wrapper-dropdown-10 column_2 margin-none " tabindex="2" style="width:110px; ">
						 Natasa <img src="<?php echo base_url();?>img/avatar3.jpg" width="23" class="on-left" style="margin-right:5px;"/>
						<ul class="dropdown">
							<li><a href="<?php echo base_url('en/user'); ?>">MY PROFILE</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">MY LISTINGS</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">MY ENQUIRES</a></li>
							<li><a href="<?php echo base_url('en/user/logout'); ?>">LOGOUT</a></li>
						</ul>
					</div>
					<div id="header_travel" class=" on-right wrapper-dropdown-10 border-right column_2 margin-none show-screen" tabindex="2" style="width:115px; ">
						 you may also
						<ul class="dropdown">
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">list your space (nonhotel)</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">personalize your experience</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">review favorite places</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">share your trips with friends</a></li>
						</ul>
					</div>
					<div class=" column_2 text center on-right border-right padding-top paddingsmall margin-none socials show-screen" style="width:45px; height:56px">
						<a href="<?php echo base_url('en/user/login'); ?>" class="text book block "><i class="fa fa-facebook "></i></a>
					</div>
					<div class=" column_2 text center on-right padding-top paddingsmall border-right border-left margin-none socials show-screen" style="width:45px; height:56px">
						<a href="<?php echo base_url('en/user/login'); ?>" class="text book block "><i class="fa fa-google-plus show-screen"></i></a>
					</div>
				</div>
				<?php } else {?>
				<div class=" column_5 ">
					
					<div class=" column_2 margin-none text right on-right padding-top socials padding-right margin-none " style="width:110px; height:56px ">
						<a href="<?php echo base_url('en/user/login'); ?>" class="text right tiny book " style="text-decoration:underline; font-size:12px ">login / signup</a>
					</div>
					<div id="header_travel" class=" on-right wrapper-dropdown-10 column_2 margin-none padding-bottom border-right" tabindex="2" style="width:115px; height:56px ">
						 you may also...
						<ul class="dropdown">
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">list your space (nonhotel)</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">personalize your experience</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">review favorite places</a></li>
							<li><a href="<?php echo base_url('en/listing/details/1'); ?>">share your trips with friends</a></li>
						</ul>
					</div>
					<div class=" column_2 text center on-right border-right padding-top paddingsmall socials margin-none " style="width:45px; height:56px">
						<a href="<?php echo base_url('en/user/login'); ?>" class="text book "><i class="fa fa-facebook "></i></a>
					</div>
					<div class=" column_2 text center on-right border-right border-left socials padding-top paddingsmall margin-none " style="width:45px; height:56px">
						<a href="<?php echo base_url('en/user/login'); ?>" class="text book "><i class="fa fa-google-plus "></i></a>
					</div>
				</div>
				<?php } ?>
			</div>
		</header>
		
		<!-- end header section -->
		
		
		<!-- begin header mobile section -->
		
		<header class="bck theme noise text color white padding-none margin-none show-phone" style=" height:40px; position:static">
			<div class="row">
				<div class="text center ">
					<h5 class="text bold " style="margin:6px;font-size:16px "><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>img/icons/stgu_logo.png" width="22" class="inline" style=" margin-right:2px; "/> staygusto</a></h5>
				</div>
			</div>
		</header>
		
		<!-- end header mobile section -->