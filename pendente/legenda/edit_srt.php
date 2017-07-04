<?php

	class SubRipText{
		var $subtitles = Array();
		
		function addSubtitle($pos,$start,$end,$titles){
			$this->subtitles[$pos]["start"] = $start;
			$this->subtitles[$pos]["end"] = $end;
			$this->subtitles[$pos]["titles"] = $titles;
			//echo $pos . " - " . $this->subtitles[$pos]["titles"];
		}
	}	

	function RemoveEspacos($Msg){
		$a = array(
		"[\r]"=>"",
		"[\n]"=>"");
		
		return preg_replace(array_keys($a), array_values($a), $Msg);
	}

	function RemoveAcentos($var){
		$var = strtolower($var);
	 	$var = ereg_replace("[áàâãª]","a",$var);
	 	$var = ereg_replace("[éèê]","e",$var);
	 	$var = ereg_replace("[óòôõº]","o",$var);
	 	$var = ereg_replace("[úùû]","u",$var);
	 	$var = str_replace("ç","c",$var);
	 	return $var;
	}
		
	$ponteiro = fopen("legendas/analshit-ts.srt",'r');
	$subrip = new SubRipText();
	$pos;
	$start;
	$end;
	$titles = "";
		
	while(!feof($ponteiro)){
		
			//echo $linha;
			//echo "==";
			//echo strlen($linha);
			$linha = fgets($ponteiro, 4096);
			if(floor($linha) != 0){
				$pos = RemoveEspacos($linha);
						
				$linha = fgets($ponteiro, 4096);
				if(substr($linha,13,3) == '-->'){	 		
					$array = split("-->",$linha);
					$start = $array[0];
					$end = RemoveEspacos($array[1]);
				}
			
				$linha = fgets($ponteiro, 4096);				
				while(strlen($linha) > 2){		
					$titles .= RemoveEspacos($linha) . '<br>';
					$linha = fgets($ponteiro, 4096);
				}
			  
				if(strlen($titles)){	
					$subrip->addSubtitle($pos,$start,$end,$titles);
					$titles = "";
				}
		  }
	}
	
	foreach($subrip->subtitles as $key=>$subtitle){
		$subtitle = array_map("htmlentities",$subtitle);
		$key = (string)$key;
		$subrip->subtitles[$key]['titles'] = $subtitle['titles'];
	}

	echo json_encode($subrip->subtitles);
	fclose($ponteiro);
?>