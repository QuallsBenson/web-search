<?php namespace Quallsbenson\WebComponents\Search\Tests;

use Quallsbenson\WebComponents\Search\Interfaces\SearchResultInterface;

class Post implements SearchResultInterface{

	use \Quallsbenson\WebComponents\Search\Traits\SearchResultTrait;

	public    $id = 1,
		  	  $title = "Example Title of Post",
		      $body  = "Example Body of Post",
		      $url   = "example-url.com";

}


