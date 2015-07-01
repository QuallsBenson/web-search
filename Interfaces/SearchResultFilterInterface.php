<?php namespace Quallsbenson\WebComponents\Search\Interfaces;



interface SearchResultFilterInterface{

	/**
	* filters array of results by given criteria
	* @return array of filtered results
	**/

	public function filterResults( array $results, $criteria, $mode );


}