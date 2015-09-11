<?php namespace Quallsbenson\WebComponents\Search\Traits;


trait SearchResultTrait{

	/**
	* @return string name of result content
	**/

	public function resultTitle()
	{

		return $this->title;

	}

	/**
	* @return string body of search result content
	**/

	public function resultBody()
	{

		return $this->body;

	}

	/**
	* @return string url to result resource
	**/

	public function resultUrl()
	{

		return $this->url;

	}


}