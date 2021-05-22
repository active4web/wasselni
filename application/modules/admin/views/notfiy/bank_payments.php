<?php
ob_end_clean();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
$notification=$this->db->get_where("request_courses",array("view"=>'1',"type_payment"=>'1'))->result();
$count_notify=count($notification);
echo "data: {$count_notify}\n\n";
sleep(1);
?>
