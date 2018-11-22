<?php 
	//echo "close by admin";
	//exit;
?>
<!DOCTYPE html>
<html>
<head>	

		
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Integration</title>
	
	
    <!-- Ext -->
    <script type="text/javascript" src="libs/ext/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="libs/ext/ext-all.js"></script>
    
    <script type="text/javascript" src="libs/ext/ux/TableGrid.js"></script>
    <script type="text/javascript" src="libs/ext/ux/SearchField.js"></script>
	<link rel="stylesheet" type="text/css" href="libs/ext/resources/css/ext-all.css" />
	
	<!-- <script type="text/javascript" src="libs/ext/export_excel/Exporter-all.js"></script> -->

	
	
    <!-- Jquery -->
	<script type='text/javascript' src='libs/jquery/jquery-1.10.2.min.js'></script>
	<!--<script type='text/javascript' src='libs/jquery/jquery-ui.js'></script>
    <link rel="stylesheet" type="text/css" href="libs/jquery/jquery-ui.css" /> -->
    

    <!-- style -->
   <link rel="stylesheet" type="text/css" href="styles/style.css?_=<?php echo time(); ?>" />
    <!-- Apps -->
	<script type="text/javascript" src="js/init_.js?_=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="js/init_grid.js?_=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="js/init_form_customer.js?_=<?php echo time(); ?>"></script>
    <script type="text/javascript">
	Ext.onReady(function () {
		celtac = new Celtac_class();
		//$('#date1').datepicker();
	});//end domready
    </script>

</head>
<body>
    <!-- <p> date :<input type ="text" id="date1"></p> -->
	<div id="view"></div>
    
</body>
</html>
