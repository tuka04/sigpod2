<?php
$x = array();
for($i=0;$i<65536;$i++){
	exec("nmap 143.106.193.3 -p ".$i, $x);
	$s = explode(" ",$x[5]);
	foreach ($s as &$v){
		$v = rtrim($v);
		$v = ltrim($v);
	}
	if($s[1]!="closed"){
		if(count($s)==4)
			echo $s[0]." ".$s[1]." ".$s[2]." ".$s[3]."\r\n";
		else 
			echo $s[0]." ".$s[1]." ".$s[2]."\r\n";
	}
	$x = array();	
}
?>