<?php namespace Quallsbenson\WebComponents\Search\Tests;

use Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface;

class Post2 implements SearchResultInterface{

	use \Quallsbenson\WebComponents\Search\Traits\SearchResultTrait;

	public    $id = 2,
		  	  $title = "The Second Post Example",
		      $body  = "Here is the body of the content",
		      $url   = "example-url-2.com";

}


