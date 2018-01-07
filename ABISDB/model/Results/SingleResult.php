<?php

namespace abisDB\model;

class SingleResult implements IResultModel
{
    private $title = 'AbisDB::abisDBSingleResult::title';
    private $result = 'AbisDB::abisDBSingleResult::resultArray';

    public function __construct(array $result, string $title)
    {
        $this->result = $result;
        $this->title = $title;
    }

    public function getArray() : array
    {
        return $this->result;
    }

    public function getTitle() : string
    {
        return $this->title;
    }
}