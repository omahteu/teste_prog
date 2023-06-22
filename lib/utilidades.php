<?php 
class utilidades {
	
	public static function dateBR2MySQL($data, $mode = 'mysql') {
		
		if($mode == 'mysql') {
			
			$data = implode("-",array_reverse(explode("/",$data)));
			
					
		} else if($mode == 'br') {
			
			$data = implode("/",array_reverse(explode("-",$data)));			
			
		} else {
			
			$data = false;
			
		}
		
		return $data;
		
	}

	public static function horaFormata($hora){
		$hora = substr($hora,0,-3);
		return $hora;
	}

	public static function valorFin2Num($valor){
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.',$valor);
		return $valor;
	}

    public static function encode($str){
		for($i=0;$i<2;$i++)  {
			$str=strrev(base64_encode($str));
		}
		return $str;
    }

    public static function decode($str){
		for($i=0; $i<2;$i++){
			$str=base64_decode(strrev($str));
		}
		return $str;
    }

	public static function anti_injection($dados){

		$regex = '/(from|select|insert|delete|where|drop table|show tables|truncate table|#|\*|--|\\\\|;)/mi';

		$seg = preg_replace($regex,"",$dados);

		$seg = trim($seg);
		$seg = strip_tags($seg);
		$seg = addslashes($seg);

		return $seg;
	}
	
	public static function getIp(){	
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){	
			$ip = $_SERVER['HTTP_CLIENT_IP'];	
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){	
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];	
		}
		else{	
			$ip = $_SERVER['REMOTE_ADDR'];	
		}	
		return $ip;	
	}
	

	public function cortaTexto($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (!empty($line_matchings[1])) {
					// if it's an "empty element" with or without xhtml-conform closing slash
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// do nothing
					// if tag is a closing tag
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// delete tag from $open_tags list
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
						unset($open_tags[$pos]);
						}
					// if tag is an opening tag
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// add tag to the beginning of $open_tags list
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings[1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length> $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calculate the real length of all entities in the legal range
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if($total_length>= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		// if the words shouldn't be cut in the middle...
		if (!$exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...and cut the text in this position
				$truncate = substr($truncate, 0, $spacepos);
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if($considerHtml) {
			// close all unclosed html-tags
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}
	

	/**
	 * Verifica se algum campo do que foi especificado está vazio.
	 * 
	 * @return
	 * 		null 	-> Quando os campos estiverem preenchidos.
	 * 		string 	-> Quando algum campo que foi especificado está vazio.
	 */
	public static function checkEmptyFields($fieldsArr, $fieldsPost) {
		$result = null;

		// Verifica cada campo
		foreach ($fieldsArr as $field) {

			// Verifica se não é uma variavel numérica, pois o empty do php considera o 0 como uma variavel vazia.
			// Se passar na verificação is_numeric á variavel não é vazia.
			if (!is_numeric($fieldsPost[$field]) && (empty($fieldsPost[$field]) || $fieldsPost[$field] == '')) {
				$result = "O campo \"<b>$field</b>\" n&atilde;o pode estar vazio. Por favor tente novamente";

				// Para de verificar
				break;
			}

		}

		return $result;
	}

	/**
	 * Retorna o nome do arquivo sem a sua extenção
	 */
	public static function getFileName($fullFileName)
	{
		// Busca o ponto final do arquivo
		$endDotPostion = strpos($fullFileName, '.');

		// Verifica se não encontrou o ponto separador do nome da extensao
		if ($endDotPostion == false)
		{
			// Retorna o nome inteiro
			return $fullFileName;
		}

		// Retorna o nome sem a parte apos o ponto final separador do nome da extesão
		return substr($fullFileName, 0, $endDotPostion);
	}

	/**
	 * Retorna um novo nome de imaegm único.
	 */
	public static function createImageName($start, $middle)
	{
	    // Adiciona o tempo ao nome desta imagem para evitar substituições
	    $name .= $start.'-'.$middle.'-'.time();

	    // Verifica se o nome execede o tamanho máximo permitido para o nome do arquivo
	    if (strlen($name) > 250)
	    {
	        $name = substr($name, 0, 250);
	    }

	    return $name;
	}

	public static function removeSpecialChars($string){
	  //List (Array) of special chars
	  $pattern = array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/","/[{}\[\]'\"^~;:°?&*+@#$%!\/()|=.,\\\]/");

	  //List (Array) of letters
	  $replacement = array('a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'n', 'N', 'c', 'C', '');

	  return preg_replace($pattern , $replacement, $string);
	}

	public static function removeUnwantedChars($string){
		$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		$str = strtr( $string, $unwanted_array );
		return $str;
	}

}
?>