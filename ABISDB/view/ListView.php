<?php

namespace abisDB\view;

class ListView implements IResultView
{
    private $resultArray;
    private $title;

    public function __construct(array $results, $title)
    {
        $this->resultArray = $results;
        $this->title = $title;
    }

    public function getHTML() : string
    {
        $result = "<div class='result'><h3>{$this->title}</h3>";

        if (count($this->resultArray) > 0)
        {
            $result .= "<table style='width:100%'><tr>";
            foreach ($this->resultArray[0] as $key => $value) {
                $result .= "<th>{$key}</th>";
            }
            $result .= "</tr>";
    
            foreach ($this->resultArray as $num => $instance) {
                $resultDisplay = "<tr>";
                $num = $num + 1;
    
                foreach ($instance as $value) {
                    $num = $num + 1;
                    $resultDisplay .= "<td>$value</td>";
                }
    
                $result .= $resultDisplay . "</tr>";
            }

            $result .= "</table>";
        } else {
            $result .= "No results matching your search criteria!";
        }

        return $result . "</div>";
    }
}