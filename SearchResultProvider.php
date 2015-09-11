<?php namespace Quallsbenson\WebComponents\Search;

use Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultFilterInterface;

class SearchResultProvider implements SearchResultProviderInterface{


	protected $results = [],
			  $keywords,
			  $filter,
			  $filteredResults = [];


	public function __construct( $keywords, array $results = array(), SearchResultFilterInterface $filter = null )
	{

		$this->setKeywords( $keywords );

		if( !empty( $results) )
			$this->merge( $results );

		if( $filter )
			$this->setFilterProvider( $filter );

	}


	/**
	* Does this instance contain results
	* @return bool true or false
	**/

	public function hasResults()
	{

		$results = $this->all();

		return !empty( $results );

	}	


	/**
	* sorts through search results and orders them 
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderInterface 
	**/

	public function order( array $options = array() )
	{

		if(!$this->hasResults()) return $this;

		usort( $this->results, [$this, 'compare'] );

		return $this;

	}


	/**
	* used with the usort function to compare one result to another and order them
	* based on defined criteria
	* @return -1 | 1 | 0 
	**/

	public function compare( SearchResultInterface $result1, SearchResultInterface $result2 )
	{

		$score1 = $this->score( $result1 );
		$score2 = $this->score( $result2 );

		if($score1 === $score2) return 0;

		return ($score1 > $score2) ? -1 : 1;

	}


	/**
	* determine the score of the result based on algorithm
	* @return float score
	**/

	public function score( SearchResultInterface $result )
	{

		$titlePercent = 0;
		$bodyPercent  = 0;	

		similar_text( $this->getKeywords(), $result->resultTitle() , $titlePercent );
		similar_text( $this->getKeywords(), $result->resultBody() , $bodyPercent );

		return $score = ( $titlePercent * .5 ) + $bodyPercent;

	}


	/**
	* Set the keywords used to compare results with one another
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderInterface 
	**/

	public function setKeywords( $keywords )
	{

		$this->keywords = (string) $keywords;

		return $this;

	}


	/**
	* Get the keywords of the search
	* @return string $keywords
	**/

	public function getKeywords()
	{

		return $this->keywords;

	}


	/**
	* Return all the results
	* @return array of Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface
	**/

	public function all()
	{

		return $this->results;

	}

	/**
	* Return only filterd results
	* @return array of Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface
	**/

	public function allFiltered()
	{

		return $this->filteredResults;

	}


	/**
	* Merge other search results with these
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderInterface 
	**/

	public function merge( array $results )
	{

		$this->results = array_merge( $this->results, $results );

		return $this;

	}


	/**
	* set the service responsible for filtering the search results 
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchProviderInterface
	**/
	
	public function setFilterProvider( SearchResultFilterInterface $filter )
	{

		$this->filter = $filter;

	}

	/**
	* filter the search results
	* @param mixed $criteria
	* @param int $filterMode, -1 remove matches, 1 remove non-matches 
	* @return instance of self Quallsbenson\WebComponents\Search\Interfaces\SearchProviderInterface
	**/

	public function filter( $criteria, $filterMode = 1 )
	{

		$this->filteredResults = $this->filter->filterResults( $this->results, $criteria, $filterMode );

		return $this;

	}


}
