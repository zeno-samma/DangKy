<?php

//--Cau hinh firewall--//
$laivt_fw_conf['max_lockcount']=10;//So lan toi da phat hien dau hieu DDOS va khoa IP do vinh vien 
$laivt_fw_conf['max_connect']=10;//So ket noi toi da dc gioi han boi $laivt_fw_conf['time_limit']
$laivt_fw_conf['time_limit']=10;//Thoi gian dc thuc hien toi da $laivt_fw_conf['max_connect'] ket noi
$laivt_fw_conf['time_wait']=10;//Thoi gian cho de dc mo khoa khi IP bi khoa tam thoi
$laivt_fw_conf['fanpage']='https://www.facebook.com/kiemthehay/';//Email lien lac voi Admin
$laivt_fw_conf['htaccess']="../.htaccess";//Duong dan toi file htaccess tren server
//--Ket thuc cau hinh Firewall--//
?>