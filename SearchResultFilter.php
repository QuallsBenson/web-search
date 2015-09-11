<?php namespace Quallsbenson\WebComponents\Search;

use Quallsbenson\WebComponents\Search\Interfaces\SearchResultFilterInterface;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface;

class SearchResultFilter implements SearchResultFilterInterface{


	/**
	* performs filter on given search results array, and returns filtered array
	* @return bool true to keep object, false to remove it
	**/


	public function filterResults( array $results, $criteria, $mode )
	{

		$filteredResults = [];

		for( $i = 0; isset( $results[$i] ); $i++ )
		{

			$keep = true;

			if( is_callable( $criteria ) )
			{

				$keep = $this->filterCallback( $results[$i], $criteria );

			}

			else
			{

				$match = $this->propertiesMatch( $results[$i], $criteria );


				if( $match && $mode === -1 || !$match && $mode === 1)
				{

					$keep = false;

				}

			}

			if($keep) $filteredResults[] = $results[$i];

		}

		return $filteredResults;

	}


	/**
	* compares array key:value to object property:value
	* @return bool true if a match, false if not
	**/

	public function propertiesMatch( SearchResultInterface $result, array $properties )
	{

		foreach( $properties as $k => $v )
		{

			if( $result->{$k} !== $v ) return false;

		}

		return true;

	}

	/**
	* passes object to callback, and removes or keeps based on return value
	* called only in $this::filterResults
	* @return bool true to keep object, false to remove it
	**/

	protected function filterCallback( SearchResultInterface $result, callable $callback )
	{

		return call_user_func_array( $callback , $result ) ? true : false;

	}


}