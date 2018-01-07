<?php

namespace abisDB\model;

class ListResult implements IResultModel
{
    private $title = 'AbisDB::abisDBListResult::title';
    private $resultArray = 'AbisDB::abisDBListResult::resultArray';

    public function __construct(array $result, string $title)
    {
        $this->resultArray = $result;
        $this->title = $title;
    }

    public function getArray() : array
    {
        return $this->resultArray;
    }

    public function getTitle() : string
    {
        return $this->title;
    }
}