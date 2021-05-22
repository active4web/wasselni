<?php
defined('BASEPATH') OR exit('No direct script access allowed');







$main_data=get_table("translate_txt");
foreach($main_data as $main_data){
$lang[$main_data->value]=$main_data->txt_en;
}
