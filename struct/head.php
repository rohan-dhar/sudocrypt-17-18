			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
			<meta name="apple-mobile-web-app-capable" content="yes">
			<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

			<link rel="icon" href=<?php echo '"'.HTML_ROOT.'favicon.ico"'; ?>>

			<title><?php echo $title; ?></title>
	
			<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800" rel="stylesheet">

			<link rel="stylesheet" type="text/css" href= <?php echo '"'.HTML_ROOT.'css/ui.css"'; ?>>
			<link rel="stylesheet" type="text/css" href= <?php echo '"'.HTML_ROOT.'css/sweetalert.css"'; ?>>

			<script type="text/javascript" src=<?php echo '"'.HTML_ROOT.'js/jquery.js"'; ?>></script>
			<script type="text/javascript" src=<?php echo '"'.HTML_ROOT.'js/sweetalert.js"'; ?>></script>
			<script type="text/javascript" src=<?php echo '"'.HTML_ROOT.'js/velocity.js"'; ?>></script>			
			<script type="text/javascript" src=<?php echo '"'.HTML_ROOT.'js/ui.js"'; ?>></script>

<?php 
	$html = "";
	foreach ($styles as $k => $v){
		$html .= "\t\t\t".'<link rel="stylesheet" type="text/css" href="'.HTML_ROOT.$v.'">'."\n";
	}
	echo $html;

	$html = "";
	foreach ($scripts as $k => $v){
		$html .= "\t\t\t".'<script type="text/javascript" src="'.HTML_ROOT.$v.'"></script>'."\n";
	}
	echo $html;
?>