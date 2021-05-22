<?php

		$target_dir = "sql_v.png";
//$target_file = $target_dir . basename($_FILES["file"]["name"]);
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
/*$modified = date("Y-m-d",filemtime($target_file));
echo $modified;*/
$modified = stat($target_dir);
echo "<pre>";
print_r($modified);
echo "</pre>";
echo date("Y-m-d",$modified[8]);

?>