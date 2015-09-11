<?php namespace Quallsbenson\WebComponents\Search\Interfaces;


interface SearchableInterface{

	/**
	* @return null or array of SearchResultInterface
	**/

	public function search( $keywords );

	/**
	* @return string name of the searchable component
	**/

	public function searchId();

}