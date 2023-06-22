<?php 
namespace classe\lib;


define('DB_HOST', 'localhost');
define('DB_NAME', 'projeto');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8');


// define('DB_HOST', 'localhost');
// define('DB_NAME', 'fisioitupava');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_CHAR', 'utf8');
use \PDO;
use \PDOException;
use \Exception;

class MyPDO extends PDO {

	public function __construct()
	{
		$dns = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;
		//lança exceção quando ocorre um erro IMPRESCINDÍVEL.
		$options = [PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION];
		try{
		parent::__construct($dns,DB_USER,DB_PASS,$options);
		}catch(PDOException $e)
		{
			echo "Erro ao conectar no banco de dados, verifique se MyPDO.php foi configurada corretamente";
			die();
			//echo "MyPDO.php não foi configurada corretamente tem certeza que colocou as informações corretas no arquivo? Verifique HOST,DBNAME,DBUSER,PASS. <br> mensagem da exceção:<br>".$e;
		}
	}

	/**
	 * @author : Abner
	 * utilize esta função caso for executar uma query que tenha algum tipo de input do usuario.
	 * http://php.net/manual/pt_BR/pdo.prepare.php
	 * 
	 * @return objeto PDOStatement
	 * http://php.net/manual/pt_BR/class.pdostatement.php
	 * @param query sql que sera preparada.
	 * @param args, no formato [':coluna' => $valor]
	 * insert into tabela set valor1 = :valor1
	 * [':valor1' => $valor1]
	 */
	public function run($query,$args = []){

		if($args != null)
		{
			$stmt = $this->prepare($query);
			$params = [];
			foreach ($args as $key => $value) {
				if($key[0] != ":")
				{
					$key = ":".$key;
				}
				if($key !== null && $value !== null)
				{
					$params[$key] = $value;
				}
			}
			try{
				$stmt->execute($params);
			}catch(PDOException $e)
			{
				echo "erro interno, tente novamente, caso o erro se repita, contate um administrador.";
				
				//debug
				$text = 'verifique se o número de parametros da query, é diferente do número de parametros enviados<br>';
				$text .= 'ou se os nomes das colunas estão corretos <br><br>';
				$text .= $query;
				$text .= '<br>';
				

				print_r($text);
				echo "<pre>";
				print_r($params);
				echo "<br>";
				echo $e;
				
				die();
			}
			return $stmt;
		}else{
			throw new Exception("Utilize argumentos preparados.", 1);
			return false;
		}
		
	}

	/**
	 *utilize esta função caso for executar uma query estatica
	 *http://php.net/manual/pt_BR/pdo.query.php
	 */
	public function query($query){
		return parent::query($query);
	}

}