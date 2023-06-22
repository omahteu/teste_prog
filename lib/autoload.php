<?php
/**
 * @author Abner
 * @param $className, nome da classe com namespace
 * facilita os imports, porém torna-se
 */

function autoload($ClassName)
{
	$arquivo = __DIR__."/../".strtr($ClassName,'\\','/').".php";
	if(file_exists($arquivo))
	{
		include_once $arquivo;
	}
}

spl_autoload_register('autoload');
?>