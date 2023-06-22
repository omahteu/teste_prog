<?php
	class uploadHelper {
		var $pasta;     // caminho de destino
		var $nome;      // nome do arquivo
		var $largura;    // largura limite desejada, em caso de imagem
		var $altura;    // altura limite desejada, em caso de imagem
		var $tmp_name;  // nome temporário
		var $img_marca; // caminho completo para a imagem da marca d'agua, em caso de imagem

		public function uploadArquivo($imagem = FALSE, $aleatorio = true) {
			if ($aleatorio) {
				$nome = explode(".",$this->nome);

				$this->nome = $this->nomeRandomico().".".end($nome);
			}

			if(move_uploaded_file($this->tmp_name, $this->pasta."/".$this->nome)) {
				if($imagem == TRUE){
					if(!empty($this->img_marca)){
						$this->marcaDagua();
					}
					if(!empty($this->largura) && !empty($this->altura)){
						$this->redimensiona();
					}
				}
			}
			return $this->nome;
		}

		public function getExtension($str) {
			$i = strrpos($str,".");
			if(!$i){
				return "";
			}
			$l = strlen($str) - $i;
			$extt = substr($str,$i+1,$l);
			return $extt;
		}

		function redimensiona() {
			$img = $this->pasta."/".$this->nome;
			$w = $this->largura;
			$h = $this->altura;
			//Checando GD
			if (!extension_loaded('gd') && !extension_loaded('gd2')) {
				trigger_error("GD não foi carregado", E_USER_WARNING);
				return false;
			}
			//Pegando tamanho da imagem
			$imgInfo = getimagesize($img);
			switch ($imgInfo[2]) {
				case 1: $im = imagecreatefromgif($img); break;
				case 2: $im = imagecreatefromjpeg($img);  break;
				case 3: $im = imagecreatefrompng($img); break;
				default:  trigger_error('Formato não suportado!', E_USER_WARNING);  break;
			}
			//Se a imagem e pequena não redimensiona
			if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
				$nHeight = $imgInfo[1];
				$nWidth = $imgInfo[0];
			}else{
				//Redimensione mas mantenha a proporção
				if ($w/$imgInfo[0] > $h/$imgInfo[1]) {
					$nWidth = $w;
					$nHeight = $imgInfo[1]*($w/$imgInfo[0]);
				}else{
					$nWidth = $imgInfo[0]*($h/$imgInfo[1]);
					$nHeight = $h;
				}
			}
			$nWidth = round($nWidth);
			$nHeight = round($nHeight);
			$newImg = imagecreatetruecolor($nWidth, $nHeight);
			/* Checando se a imagem é PNG ou GIF, então seta como transparent*/
			if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
				imagealphablending($newImg, false);
				imagesavealpha($newImg,true);
				$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
				imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
			}
			imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
			//Gera o arquivo e renomeia com $newfilename
			switch ($imgInfo[2]) {
				case 1: imagegif($newImg,$img); break;
				case 2: imagejpeg($newImg,$img,100);  break;
				case 3: imagepng($newImg,$img); break;
				default:  trigger_error('Falhou ao redimensionar a imagem!', E_USER_WARNING);  break;
			}
			return $img;
		}

		private function marcaDagua() {
			$cab_marca  = imagecreatefrompng($this->img_marca);
			$cab_imagem = imagecreatefromjpeg($this->pasta."/".$this->nome);
			$tam_imagem    = getimagesize($this->pasta."/".$this->nome);
			$tam_marca     = getimagesize($this->img_marca);
			$largura_img   = $tam_imagem[0];
			$altura_img    = $tam_imagem[1];
			$largura_marca = $tam_marca[0];
			$altura_marca  = $tam_marca[1];
			$eixo_x = ($largura_img - $largura_marca) - 5;
			$eixo_y = ($altura_img - $altura_marca) - 5;
			imagecolortransparent($cab_marca, imagecolorallocate($cab_marca, 4, 137, 193));
			imageCopyMerge($cab_imagem, $cab_marca, $eixo_x, $eixo_y, 0, 0, $largura_marca, $altura_marca, 50);
			imagejpeg($cab_imagem, $this->pasta."/".$this->nome, 90);
		}

		public function nomeRandomico() {
			$novoNome = "";
			for($i=0; $i<20; $i++) {
				$novoNome .= rand(0,9);
			}
			return $novoNome;
		}

		/**
		 * Função "wrapper" para facilitar o fazer upload de uma imagem.
		 * 
		 * @return O nome da imagem, caso o upoload foi um sucesso. Ou uma string o $defaultReturn, caso contrario.
		 */
		public function tryUploadImage ($fileFormName, $path, $tamanhoMaxImagem, $defaultReturn = null, $nome = "") {
			// Verifica senão há erros na imagem
			if ($_FILES[$fileFormName]["error"] == 0 && ($_FILES[$fileFormName]["size"] > 0 && $_FILES[$fileFormName]["size"] < $tamanhoMaxImagem)) {
				
				// Seta a pasta para armazenar a imagem
				$this->pasta 	=  $path;

				// Guarda a verificação se há um nome em uma variavel
				$dontHaveNome = ($nome == "");

				// Define o nome do arquivo
				if ($dontHaveNome) {
					$nome = $_FILES[$fileFormName]['name'];
				}
				else {
					// Remove caracteres especiais
					$nome = $this->removeSpecialChars($nome);

					// Adiciona o tipo do arquivo no final do nome do arquivo
					$nome .= ".".end(explode(".", $_FILES[$fileFormName]['name']));
				}

				// Seta o nome
				$this->nome      = $nome;

				// Seta o o caminho do arquivo temporário
				$this->tmp_name  = $_FILES[$fileFormName]['tmp_name'];
 
				$imagem = $this->uploadArquivo(TRUE, $dontHaveNome);
			}
			else {
				// Seta o default return senão foi possivel fazer o upload.
				$imagem = $defaultReturn;
			}

			return $imagem;
		}

		/**
		 * Função "wrapper" para facilitar o fazer upload de uma imagem e deletar uma antiga.
		 * 
		 * @return O nome da imagem, caso o upoload foi um sucesso. Ou uma string o $defaultReturn, caso contrario.
		 */
		public function tryUploadImageAndDeleteOld ($fileFormName, $path, $tamanhoMaxImagem, $oldImagePath, $defaultReturn = null, $nome = "") {
			// Tenta fazer upload
			$result = $this->tryUploadImage($fileFormName, $path, $tamanhoMaxImagem, $defaultReturn, $nome);

			// Verifica se o upload foi um sucesso
			if ($result != $defaultReturn) {
				// Deleta imagem antiga
				@unlink($oldImagePath);
			}

			return $result;
		}


		public function removeSpecialChars ($str) {
			$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		    $str = preg_replace('/[éèêë]/ui', 'e', $str);
		    $str = preg_replace('/[íìîï]/ui', 'i', $str);
		    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
		    $str = preg_replace('/[úùûü]/ui', 'u', $str);
		    $str = preg_replace('/[ç]/ui', 'c', $str);
		    $str = preg_replace('/[@#$%¨*]/ui', '', $str);

		    // Remove todos os espaços em branco
		    $str = preg_replace('/\s+/', '-', $str);

		    return $str;
		}
	}
?>