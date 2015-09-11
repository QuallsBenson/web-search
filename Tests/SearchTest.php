<?php  namespace Quallsbenson\WebComponents\Search\Tests;

use Quallsbenson\WebComponents\Search\SearchProvider;
use Quallsbenson\WebComponents\Search\SearchResultProviderFactory;
use Quallsbenson\WebComponents\Search\SearchResultFilter;
use Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface;

require dirname(dirname(__FILE__)) .'/vendor/autoload.php';

class SearchTest extends \PHPUnit_Framework_TestCase{

	public function testSearchResult()
	{

		$searchProvider = new SearchProvider( new SearchResultProviderFactory, new SearchResultFilter );
		$postRepository = new PostRepository;

		$results 	 = $searchProvider->search( "Random Keyword Search", [$postRepository] )->results();

		$resultArray = $results->all(); 

		$this->assertEquals( count( $resultArray ), 2 );

		$resultArray = $searchProvider->search( "Another Search", [$postRepository, $postRepository] )->results()->all();

		$this->assertEquals( count( $resultArray ), 4 );

		return $searchProvider;

	}

	/**
	*
	* @depends testSearchResult
	**/


	public function testSearchResultOrder( $searchProvider )
	{

		$searchProvider->search( "The Second Post Example", [ new PostRepository ] );

		$orderedResults = $searchProvider->results('post')->order()->all();


		$this->assertEquals( $orderedResults[0]->id, 2 );
		$this->assertTrue( $orderedResults[0] instanceof SearchResultInterface );

		return $searchProvider;

	}


	/**
	*
	* @depends testSearchResult
	**/


	public function testSearchResultFilter( $searchProvider )
	{

		$searchProvider->search( "The Second Post Example", [ new PostRepository ] );

		//remove all non-matching
		$filteredResults = $searchProvider->results('post')->order()->filter(['title' => 'no match'], 1)->allFiltered();
		
		//remove only matching
		$secondFilter    = $searchProvider->results('post')->order()->filter(['title' => 'Example Title of Post'], 1)->allFiltered();

		
		$this->assertEquals( count( $filteredResults ), 0 );
		$this->assertEquals( count( $secondFilter ), 1 );


		return $searchProvider;

	}


}