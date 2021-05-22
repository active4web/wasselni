<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?php
defined('BASEPATH') OR exit('No direct script access allowed');
global $lang;
if( isset($this->session->get_userdata('lang')['lang']) ){
	$lang = $this->session->get_userdata('lang')['lang'];
	}else{
	$lang = 'arabic';
	}


?>
	<?php
	 foreach($site_info as $site_info)
	?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<link rel="shortcut icon" href="<?= DIR_DES_STYLE ?>site_setting/<?= $site_info->favicon; ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
		<?php echo ( $lang == 'arabic' )?$site_info->name_site_ar: $site_info->name_site ; ?>
		</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" href="<?= DIR_DES?>css/owl.carousel.css">
		<link rel="stylesheet" href="<?= DIR_DES?>css/owl.theme.css">
<?php
if( $lang == 'arabic'){
?>
<link href="<?= DIR_DES?>css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?= DIR_DES?>css/style.css" rel="stylesheet" type="text/css">

<?php }else {?>
<link href="<?= DIR_DES?>css/bootstrap-en.css" rel="stylesheet" type="text/css">
<link href="<?= DIR_DES?>css/style.css" rel="stylesheet" type="text/css">
<link href="<?= DIR_DES?>css/style-en.css" rel="stylesheet" type="text/css">

<?php }?>
		<!--[if lt IE 7]>
			  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
		<!--[if lt IE 8]>
			  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
		<!--[if lt IE 9]>
			  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
			<style>
			@import url(https://fonts.googleapis.com/earlyaccess/notosanskufiarabic.css);
			</style>
