
<div class="wrapper">
	<div class="topbar style1">
		<div class="container-full">
			<div class="leftSide logo-group">
				<div class="text">
				<b>SOUKEXPRESS</b> Manager
				<span class="version">Beta release</span>
				</div>
			</div>

			<div class="rightSide options">
				<ul class="unstyle inline has-topbar-submenu">
					<li><button class="btn btn-red show_vertical_menu"><i class="fa fa-bars"></i></button></li>
					<li><button class="btn btn-default show_library hide"><i class="fas fa-images"></i></button></li>
				</ul>
			</div>


			<br clear="all">
		</div>
	</div>
	
<!--
Verticla Menu
-->

<?php 
$path = APP_PAGES.APP_TEMPLATE.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."vertical_menu.php";
if(file_exists($path)){
	include_once($path);
}else{
	echo "Verticla Menu";
}

//var_dump(Util::getActionByCode($lang, "2"));

?>