<?php

namespace abisDB\model;

interface IResultModel
{
    public function getArray() : array;
    public function getTitle() : string;
}