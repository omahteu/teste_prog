<?php

use classe\lib\MyPDO;

/**
 * 
 */
class artigosBO
{

	private $table = 'artigos';
	private $primaryKey = 'id';

	public function Add($vo, $returnId = false)
	{
		$pdo = new MyPDO();

		$query = "INSERT INTO artigos (titulo, descricao) VALUES (:titulo, :descricao)";

		$params = $vo;

		/** prepare retorna um array que possui nome da coluna -> valor da coluna.
		 * exemplo ['nome' => 'Abner'] dos atributos a serem armazenados no banco.
		 * esta função deve existir em toda classe que voce deseja salvar,
		 * ela utiliza get_object_vars($this); para retornar um array do tipo
		 * $nomeDaVariavel => $valorDaVariavel
		 * portanto tenha certeza que os nomes das variaveis sejam os mesmos nomes das colunas
		 * do banco de dados
		 */

		$pdo->run($query, $params);
		if ($returnId) {
			return $pdo::lastInsetId();
		}
		return true;
	}

	function Edit($artigos)
	{
		$pdo = new MyPDO();
		$consulta = "UPDATE artigos SET titulo = :titulo, descricao = :descricao WHERE id = :id";
		$params = $artigos;
		$pdo->run($consulta, $params);
	}

	function Get($id)
	{
		$pdo = new MyPDO();

		$query = "SELECT * FROM artigos WHERE id = $id";

		$stmt = $pdo->query($query);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	function GetAll()
	{

		$pdo = new MyPDO();

		$query = "SELECT * FROM artigos";
		$stmt = $pdo->query($query);

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


		return $results;
	}

	public function countNoticias()
	{
		$pdo = new MyPDO();

		//MyPDO->query() apenas usado para queries estaticas, NÃO SEGURO, utilize MyPdo->run() caso tenha input de usuario
		$stmt = $pdo->query("SELECT COUNT(id) FROM artigos");
		$results = $stmt->fetch(MyPDO::FETCH_ASSOC);

		return (int) $results["COUNT(id)"];
	}

	function Count()
	{

		$db = new DBMySQL();

		$query = "SELECT COUNT(id) AS total FROM artigos";

		$db->do_query($query);

		$result = $db->getRow();

		return $result;
	}

	function Delete($id)
	{
		$pdo = new MyPDO();
		$query = "DELETE FROM artigos WHERE id = $id";
		$pdo->query($query);
	}
}
