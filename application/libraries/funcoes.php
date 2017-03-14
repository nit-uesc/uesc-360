<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Funcoes
{
	public function antiInjection($sql)
	{
		$sqlWords = "/([Ff][Rr][Oo][Mm]|[Ss][Ee][Ll][Ee][Cc][Tt]|[Cc][Oo][Uu][Nn][Tt]|[Tt][Rr][Uu][Nn][Cc][Aa][Tt][Ee]|[Ee][Xx][Pp][Ll][Aa][Ii][Nn]|[Ii][Nn][Ss][Ee][Rr][Tt]|[Dd][Ee][Ll][Ee][Tt][Ee]|[Ww][Hh][Ee][Rr][Ee]|[Uu][Pp][Dd][Aa][Tt][Ee]|[Ee][Mm][Pp][Tt][Yy]|[Dd][Rr][Oo][Pp] [Tt][Aa][Bb][Ll][Ee]|[Ll][Ii][Mm][Ii][Tt]|[Ss][Hh][Oo][Ww] [Tt][Aa][Bb][Ll][Ee][Ss]|[Oo][Rr]|[Oo][Rr][Dd][Ee][Rr] [Bb][Yy]|#|\*|--|\\\)/";

		// remove palavras que contenham sintaxe sql
		$sql = preg_replace($sqlWords, "", $sql);
		$sql = trim($sql);      //limpa espaços vazios
		$sql = strip_tags($sql);//tira tags html e php
		$sql = addslashes($sql);//Adiciona barras invertidas a uma string
		return $sql;
	}

	//Entrada: 	aaaa-mm-dd hh:mm:ss
	//Saída:	Última modificação em dd/mm/aaaa às hh:mm:ss
	public function lastModified($date)
	{
		$ano = substr($date, 0, 4);
		$mes = substr($date, 5, 2);
		$dia = substr($date, 8, 2);
		$hor = substr($date, 11, 8);
		return 'Última modificação em '.$dia.'/'.$mes.'/'.$ano.' às '.$hor;
	}

	//Entrada: 	aaaa-mm-dd
	// ou
	//Entrada: 	aaaa-mm-dd hh:mm:ss
	//Saída:	dd/mm/aaaa
	public function formatoDataHumano($date)
	{
		$ano = substr($date, 0, 4);
		$mes = substr($date, 5, 2);
		$dia = substr($date, 8, 2);
		return $dia.'/'.$mes.'/'.$ano;
	}

	//Entrada:	dd/mm/aaaa
	//Saída: 	aaaa-mm-dd
	public function formatoDataBanco($date)
	{
		$dia = substr($date, 0, 2);
		$mes = substr($date, 3, 2);
		$ano = substr($date, 6, 4);
		return $ano.'-'.$mes.'-'.$dia;
	}

}