<html xmlns="http://www.w3.org/1999/xhtml" dir="<?= $dir ?>" lang="<?= ($lang=="")? "fr" : $lang ?>">

<head>
	<?php $TOPBAR = Util::getLanguageContent($lang, "topbar"); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
	<title><?= $TOPBAR["name"]." : ".$TOPBAR["description"] ?></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!--<link href="<?= HTTP.HOST ?>templates/global/css/fontawesome.css" rel="stylesheet">-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw" crossorigin="anonymous">
	
	<link href="<?= HTTP.HOST ?>templates/global/css/api/Ycss-1.1.1.css" rel="stylesheet">
	<link href="<?= HTTP.HOST ?>templates/global/css/api/sweetalert2.min.css" rel="stylesheet">
	<link href="<?= HTTP.HOST ?>templates/<?= APP_TEMPLATE ?>/css/app.css" rel="stylesheet">
	<link href="<?= HTTP.HOST ?>templates/global/css/tailwind.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="<?= HTTP.HOST ?>templates/global/images/logo.png" />

</head>
<body>
