<?php namespace Quallsbenson\WebComponents\Search\Interfaces;


interface SearchResultInterface{

	/**
	* @return string name of result content
	**/

	public function resultTitle();

	/**
	* @return string body of search result content
	**/

	public function resultBody();

	/**
	* @return string url to result resource
	**/

	public function resultUrl();



}