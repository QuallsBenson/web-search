<?php namespace Quallsbenson\WebComponents\Search\Interfaces;


interface SearchResultProviderFactoryInterface{

	/**
	* create a new instance of SearchResultProvider
	* @return Quallsbenson\WebComponents\Search\Interfaces\SearchResultProvider
	**/

	public function make( $keywords, array $results, SearchResultFilterInterface $filter );

}