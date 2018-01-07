<?php

namespace abisDB\view;

class SingleView implements IResultView
{
    private $result;
    private $title;

    public function __construct(array $result, $title)
    {
        $this->result = $result;
        $this->title = $title;
    }

    public function getHTML() : string
    {
        $result = "<div class='result'><h3>{$this->title}</h3>";

        if (count($this->result) > 0)
        {
            $result .= "";
            foreach ($this->result[0] as $key => $value) {
                $result .= "<p><b>{$key}:</b> {$value}</p>";
            }

        } else {
            $result .= "No results matching your search criteria!";
        }

        return $result . "</div>";
    }
}