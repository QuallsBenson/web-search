<?php namespace Quallsbenson\WebComponents\Search;

use Quallsbenson\WebComponents\Search\Interfaces\SearchProviderInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchableInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderFactoryInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultFilterInterface;


class SearchProvider implements SearchProviderInterface{


	protected $keywords, 
	          $results = [],
	          $resultFactory,
	          $resultFilter;


    public function __construct( SearchResultProviderFactoryInterface $resultFactory, SearchResultFilterInterface $resultFilter )
    {

    	$this->setResultProviderFactory( $resultFactory )
    		 ->setResultFilter( $resultFilter );

    }


	/**
	* Search given searchable items by given keywords
	* @return Quallsbenson\WebComponents\Search\SearchProvider
	**/


    public function search( $keywords, array $searchables )
    {

    	$this->reset();

    	$this->keywords = $keywords;
    	$allResults 	= []; 

    	foreach( $searchables as $searchable )
    	{

			if( ! $searchable instanceof SearchableInterface )
			{
				throw new \Exception("Search class " .get_class( $searchable ) ." must implement Quallsbenson\WebComponents\Search\Interfaces\SearchableInterface" );
			}

			//perform search on searchable item
			$results = $searchable->search( $keywords );


			if( !is_array( $results ) && $results )
			{
				throw new \Exception( "Search class " .get_class( $searchable ) ." returns " .gettype( $results ) .", must be either array or evaluate to false" );
			}

			//push results to the result array 
			$this->addResultSet( $searchable->searchId(), $results );

			$allResults = array_merge( $allResults, $results );

    	}

    	//create new result set for ALL results combined
    	$this->addResultSet( "*", $allResults );

    	return $this;

    }


    /**
    *	Push a group of results to the result array
    *   @return Quallsbenson\WebComponents\Search\SearchProvider
    **/


	public function addResultSet( $id, array $results )
	{

		$this->results[ $id ] = $this->resultProviderFactory()->make( $this->keywords, $results, $this->resultFilter() ); 
		return $this;

	}

	/**
	*	Get a result set
	*   @return Quallsbenson\WebComponents\Search\SearchResultProvider
	**/

	public function getResultSet( $id )
	{

		if(!isset( $this->results[ $id ] ))
			throw new \Exception( "attempted to get non-existent result set: '" .$id ."'" );

		return $this->results[ $id ];

	}

	/**
	*    Set the result factory provider 
	*    @return Quallsbenson\WebComponents\Search\SearchProvider
	**/

	public function setResultProviderFactory( SearchResultProviderFactoryInterface $resultFactory )
	{

		$this->resultFactory = $resultFactory;

		return $this;

	}

	/**
	*    Get the result factory provider 
	*    @return Quallsbenson\WebComponents\Search\Interfaces\SearchResultProviderFactoryInterface
	**/

	public function resultProviderFactory()
	{

		return $this->resultFactory;

	}

	/**
	*    Set the result filter provider
	*    @return Quallsbenson\WebComponents\Search\SearchProvider
	**/


	public function setResultFilter( SearchResultFilterInterface $resultFilter )
	{

		$this->resultFilter = $resultFilter;

		return $this;

	}

	/**
	*    Get the result factory provider 
	*    @return Quallsbenson\WebComponents\Search\Interfaces\SearchResultFilterInterface
	**/

	public function resultFilter()
	{

		return $this->resultFilter;

	}	


	/**
	* 	Get all results, or just one or more sets
	*   note: this method, will merge all retreived results into one
	*   SearchResultProvider object
	*   @return Quallsbenson\WebComponents\Search\SearchResultProvider
	**/


	public function results( $set = "*" )
	{

		if( trim($set) === "*" ) 
			return $this->getResultSet("*");
			
		else 
			$sets = func_get_args();

		//if only one result set, then return it
		if( count( $sets ) === 1 )
			return $this->getResultSet( $sets[0] );


		//return a new Result Provider with combined results
		//if more than one result is selected
		$resultProvider = $this->resultProviderFactory()->make( $this->keywords, [], $this->resultFilter() );


		//loop through each result group and add them to 
		//the result provider 
		foreach($sets as $set)
		{

			$results = $this->getResultSet( $set );

			$resultProvider->merge( $results->all() );

		}

		return $resultProvider;

	}

	/**
	* check if a set, or combination of sets have results
	* @return bool true or false
	**/

	public function hasResults( $set = "*" )
	{

		$resultProvider = call_user_func_array( [$this, "results"] , func_get_args() );

		return $resultProvider->hasResults();

	}

	/**
	* resets all results to empty array
	* @return $this
	**/


	public function reset()
	{

		$this->results = [];

		return $this;

	}


}