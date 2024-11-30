<?
	$seri_sect = file_get_contents("cur_sections.php");
	$seri_cat = file_get_contents("cur_catalog.php");
	$seri_off = file_get_contents("cur_offers.php");
	
	$sections = unserialize($seri_sect);
	
	$ex_seri_cat = explode('*-razdelitel-massivov-*', $seri_cat);
	$catalog = array();
	foreach($ex_seri_cat as $ex_ser){
		if(!empty($ex_ser)){
			$part_cat = unserialize($ex_ser);
			$catalog = $catalog + $part_cat;
		}
	}

	$ex_seri_off = explode('*-razdelitel-massivov-*', $seri_off);
	$offers = array();
	foreach($ex_seri_off as $ex_off){
		if(!empty($ex_off)){
			$part_off = unserialize($ex_off);
			$offers = array_merge($offers, $part_off);
		}
	}

	echo 'sect = '.count($sections).'<br />';
	echo 'off = '.count($offers).'<br />';
	echo 'cat = '.count($catalog).'<br />';

	//echo '$sections = '.'<pre style="display:block;">'; print_r($sections); echo '</pre>';
	echo '$catalog = '.'<pre style="display:block;">'; print_r($catalog); echo '</pre>';
	echo '$offers = '.'<pre style="display:block;">'; print_r($offers); echo '</pre>';
?>