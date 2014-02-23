<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http:yourdomain/min/builder/
 **/

/**
 * STOP ADDING base TO GROUP NAMES IT DOESN'T MAKE SENSE
 *
 * also: Please keep controller styles & scripts together and put them after the layout styles & scripts
 */
return
    array(
        "layout_styles" =>
            array(
                "../css/tuktuk.css",
                "../css/tuktuk.theme.css",
            	"../css/tuktuk.icons.css",
            	"../js/dropdownlist/css/style.css",
            	"../js/ResponsiveMultiLevelMenu/css/component.css",
            	"../css/jquery-ui.css",
            ),

        "layout_styles_print" =>
            array(
//                 "../css/blueprint/print.css",
            ),

        "layout_scripts" =>
            array(
                "../js/jquery-1.10.2.min.js",
            	"../js/jquery-ui-1.10.3.min.js",
                //"../js/dropdown/script.js",
                "../js/stgu.scripts.generic.js",
            	"../js/html5shiv/html5shiv.js",
            	"../js/ResponsiveMultiLevelMenu/js/modernizr.custom.js",
            	"../js/ResponsiveMultiLevelMenu/js/jquery.dlmenu.js",
            	"../js/stgu.scripts.form.js",
            ),

            // Controllers
		"homepage_styles" =>
            array(
            	"../js/royalslider/royalslider.css",
            	"../js/DropKick/dropkick.css",
            	//"../js/datepicker_jqueryui/datepicker_jqueryui.css",
            	//"../js/datepicker_verbose/css/ui.daterangepicker.css",
            ),
            
        "homepage_scripts" =>
            array(
            	"../js/stgu.scripts.homepage.js",
            	"../js/royalslider/jquery.royalslider.min.js",
            	"../js/DropKick/jquery.dropkick.js",
            	
            	"../js/hotel/home/index.js"
            	
            	//"../js/datepicker_verbose/js/daterangepicker.jQuery.js",
            	//"../js/datepicker_verbose/js/date.js",
            	//"../js/nlform/nlform.js",
            ),

		"hotel_list_scripts" => 
			array(
				"../js/hotel/list.js",
				"../js/hotel/scrollpagination.js"
			),

        "expedia_scripts" =>
            array(
            		"../js/stgu.scripts.searchFormExpedia.js",
            		//"../js/nlform/nlform.js",
            ),
            
        "listing_styles" =>
            array(
            ),
            
        "listing_scripts" =>
            array(
            	"../js/stgu.scripts.listingDetails.js",
            ),
            
        "search_styles" =>
            array(
            ),
            
        "search_scripts" =>
            array(
            	"../js/stgu.scripts.searchResults.js",
            ),
            
            // JS plugins
        "form_styles" =>
            array(
            	"../js/validationEngine/css/validationEngine.jquery.css",
            ),
            
        "form_scripts" =>
            array(
            	"../js/jquery.form.min.js",
            	"../js/validationEngine/js/jquery.validationEngine.js",
            	"../js/validationEngine/js/jquery.validationEngine-en.js",
            	"../js/stgu.scripts.form.js",
            ),
            
         "datepicker_styles" =>
            array(
                //"../js/datepicker/css/bootstrap.css",
            ),

         "datepicker_scripts" =>
            array(
                //"../js/datepicker/javascript/zebra_datepicker.js",
               // "../js/stgu.scripts.zebraInit.js",
            ),
            
         "datepicker_jqueryui_styles" =>
            array(
            		//"../js/datepicker_jqueryui/datepicker_jqueryui.css"
            ),
            
         "slider_styles" =>
            array(
                "../js/slider/css/idangerous.swiper.css",
                "../js/slider/css/main.css",
            ),
         "slider_scripts" =>
            array(
                "../js/slider/js/idangerous.swiper-2.1.min.js",
                "../js/slider/js/script.js",
            ),
            
         "sliding_boxes_styles" =>
            array(
                "../js/sliding_boxes/css/style.css",
            ),
         "sliding_boxes_scripts" =>
            array(
                "../js/sliding_boxes/js/script.js",
            ),
            
         "easydropdown_styles" =>
            array(
                "../js/easydropdown/themes/easydropdown.css",
            ),
         "easydropdown_scripts" =>
            array(
                "../js/easydropdown/src/jquery.easydropdown.js",
            ),
            
         "dropdownlist_styles" =>
            array(
            	"../js/dropdownlist/css/style.css",
            ),
         "dropdownlist_scripts" =>
            array(
            	"../js/dropdownlist/js/modernizr.custom.79639.js",
            ),
            
         "dragsliders_styles" =>
            array(
                "../js/dragsliders/jquery.nouislider.css",
            ),
         "dragsliders_scripts" =>
            array(
                "../js/dragsliders/jquery.nouislider.js",
            ),
    );
