<?php
ob_end_clean();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
$notification=$this->db->update("products",array("expired_date"=>'0'),array("expired_date"=>'1','expired_date_Val<'=>date('Y-m-d')));

$count_notify=count($notification);
echo "data: {$count_notify}\n\n";
sleep(1);
?>
