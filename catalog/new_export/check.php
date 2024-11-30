<?
require_once('/home/p4082/public_html/catalog/new_export/cur_step.php');

$headers = "Content-type: text/html; charset=utf-8 \r\n"; 
$headers .= "From: alex@flxmd.by";	
mail("alex@flxmd.by", "trojCronJob", $cur_step, $headers);

if($cur_step == 'error' or $cur_step == 'wait'){
	file_put_contents('/home/p4082/public_html/catalog/new_export/cur_step.php', '<?$cur_step = "step1";?>');
}
?>