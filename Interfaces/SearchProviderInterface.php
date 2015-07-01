<?php namespace Quallsbenson\WebComponents\Search\Interfaces;


interface SearchProviderInterface{

	/**
	* @return $this
    **/

	public function search( $keywords, array $searchables );
	

	/**
	* @return array of search results
	**/

	public function results( $set = "*" );

	/**
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchProviderInterface
	**/

	public function addResultSet( $id, array $results ); 


	/**
	* @return bool true or false
	**/

	public function hasResults( $set = "*" );


	/**
	*    Set the result factory provider 
	*    @return Quallsbenson\WebComponents\Search\SearchProvider
	**/

	public function setResultProviderFactory( SearchResultProviderFactoryInterface $resultFactory );

	/**
	*    Get the result factory provider 
	*    @return Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderFactoryInterface
	**/

	public function resultProviderFactory();


	/**
	*    Set the result filter provider
	*    @return Quallsbenson\WebComponents\Search\SearchProvider
	**/


	public function setResultFilter( SearchResultFilterInterface $resultFilter );


	/**
	*    Get the result factory provider 
	*    @return Quallsbenson\WebComponents\Search\Interfaces\SearchResultFilterInterface
	**/

	public function resultFilter();	


}

