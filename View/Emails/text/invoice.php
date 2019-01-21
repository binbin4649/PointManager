<?php echo $Pmpage['company_name']."\n" ?>
<?php 
	foreach($Pmpage['invoice_names'] as $invoice_name){
		echo $invoice_name.'様'."\n";
	}
?>

いつもお世話になっております。
<?php echo $mailConfig['site_name'] ?> です。

下記の通り、請求書を送付させて頂きます。
引き続きよろしくお願い申し上げます。

【送付先】
〒<?php echo $Pmpage['invoice_zip']."\n" ?>
<?php echo $Pmpage['invoice_prefecture'].$Pmpage['invoice_address_1']."\n" ?>
<?php if($Pmpage['invoice_address_2']) echo $Pmpage['invoice_address_2']."\n" ?>
<?php echo $Pmpage['invoice_company_name'] ?> 御中
<?php echo $Pmpage['invoice_department_name'].' '.$Pmpage['invoice_position_name'].' '.$Pmpage['invoice_name'] ?> 様

【御請求内容】
締め日：<?php echo $Pmtotal['yyyymm']."\n" ?>
合計：<?php echo number_format($Pmtotal['total']) ?>円



---
　<?php echo $mailConfig['site_name'] ?>　
　<?php echo $mailConfig['site_url'] ?>　
　Mail:<?php echo $mailConfig['site_email'] ?>　