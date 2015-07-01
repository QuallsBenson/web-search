<?php namespace Quallsbenson\WebComponents\Search\Tests;

use Quallsbenson\WebComponents\Search\Interfaces\SearchableInterface;

class PostRepository implements SearchableInterface{

	public function search( $keywords )
	{
		//return an array of search results 
		return [new Post, new Post2];

	}

	public function searchId()
	{

		return "post";

	}


}