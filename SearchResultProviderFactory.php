<?php namespace Quallsbenson\WebComponents\Search;

use Quallsbenson\WebComponents\Search\Interfaces\SearchResultFilterInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderFactoryInterface;
use Quallsbenson\WebComponents\Search\SearchResultProvider;

class SearchResultProviderFactory implements SearchResultProviderFactoryInterface{

	/**
	* create a new instance of SearchResultProvider
	* @return Quallsbenson\WebComponents\Search\Interfaces\SearchResultProvider
	**/

	public function make( $keywords, array $results, SearchResultFilterInterface $filter )
	{

		return new SearchResultProvider( $keywords, $results, $filter );

	}

}