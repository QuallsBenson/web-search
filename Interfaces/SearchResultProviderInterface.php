<?php namespace Quallsbenson\WebComponents\Search\Interfaces;


interface SearchResultProviderInterface{



	public function __construct( $keywords, array $results = array() );

	/**
	* sorts through search results and orders them 
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderInterface 
	**/

	public function order( array $options = array() );


	/**
	* used with the usort function to compare one result to another and order them
	* based on defined criteria
	* @return -1 | 1 | 0 
	**/

	public function compare( SearchResultInterface $result1, SearchResultInterface $result2 );


	/**
	* determine the score of the result based on algorithm
	* @return float score
	**/

	public function score( SearchResultInterface $result );


	/**
	* Set the keywords used to compare results with one another
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderInterface 
	**/

	public function setKeywords( $keywords );


	/**
	* Get the keywords of the search
	* @return string $keywords
	**/

	public function getKeywords();


	/**
	* Does this instance contain results
	* @return bool true or false
	**/

	public function hasResults();


	/**
	* Return all the results
	* @return array of Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface
	**/

	public function all();

	/**
	* Return only filterd results
	* @return array of Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface
	**/

	public function allFiltered();

	/**
	* Merge other search results with these
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderInterface 
	**/

	public function merge( array $results );


	/**
	* filter the search results based
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchProviderInterface
	**/

	public function filter( $criteria, $filterMode = -1 );

	/**
	* set the service responsible for filtering the search results 
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchProviderInterface
	**/

	public function setFilterProvider( SearchResultFilterInterface $filter );

}
