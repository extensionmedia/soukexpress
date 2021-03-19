<html xmlns="http://www.w3.org/1999/xhtml" dir="<?= $dir ?>" lang="<?= ($lang=="")? "fr" : $lang ?>">

<head>
	<?php $CONTENT = Util::getLanguageContent($lang, "content"); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
	<title><?= $CONTENT["name"]." : ".$CONTENT["description"] ?></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<link href="<?= HTTP.HOST ?>templates/global/css/api/Ycss-1.1.1.css" rel="stylesheet">
	<link href="<?= HTTP.HOST ?>templates/<?= APP_TEMPLATE ?>/css/app.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="<?= HTTP.HOST ?>templates/global/images/logo.png" />	

</head>
<body>

<div class="wrapper"> <!-- START THE MAIN CONTAINER / WRAPPER -->