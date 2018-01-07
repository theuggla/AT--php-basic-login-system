<?php

namespace abisDB\view;

class ViewProducer
{
    public function getCorrectView(\abisDB\model\IResultModel $resultModel) : IResultView
    {
        $resultType = get_class($resultModel);
        $resultArray = $resultModel->getArray();
        $resultTitle = $resultModel->getTitle();

        switch ($resultType) {
            case \abisDB\model\ListResult::class:
                return new \abisDB\view\ListView($resultArray, $resultTitle);
                break;
            case \abisDB\model\SingleResult::class:
                return new \abisDB\view\SingleView($resultArray, $resultTitle);
                break;
            default:
                return "Does not work";
                break;
        }
    }
}