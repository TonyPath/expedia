<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>staygusto</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!--[if lt IE 9]>
	<script src="<?php echo base_url('js/html5shiv/html5shiv.js')?>"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,500,600,700&subset=latin,greek-ext,latin-ext,cyrillic-ext' rel='stylesheet' type='text/css'>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.css" rel="stylesheet">
	<?php echo $layout_minifyStyles;?>

</head>
<body>
<div id="background_wrap"></div>
<?php echo $position_header; ?>

<?php if($show_searchbar){ echo $position_searchbar; }?>

<div id="container">
	<div id="body">
	    <?php echo $position_main; ?>
	</div>
</div>
<?php echo $position_footer; ?>
	
<?php echo $layout_minifyScripts;?>
 
 
</body>
</html>