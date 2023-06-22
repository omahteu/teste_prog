<?php 

/**
 * 
 */
class artigosVO {
	
	private $id;
	private $titulo;
    private $descricao;
    private $capa;
    
    public function prepare()
    {
      return get_object_vars($this);
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }
    public function getCapa()
    {
        return $this->capa;
    }
    public function setCapa($capa)
    {
        $this->capa = $capa;

        return $this;
    }
   
}
?>