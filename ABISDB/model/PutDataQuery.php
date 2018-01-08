<?php

namespace abisDB\model;

class PutDataQuery
{
    private static $dbconnection;

    public function __construct($dbconnection)
    {
        self::$dbconnection = $dbconnection;

    }

    public function addRowsToTables($forms)
    {
        if (count($forms) > 1)
        {
            $forms = $this->normalizeKeys($forms);
        }
        foreach($forms as $table=>$data)
        {
            $valueString = '';
            
            foreach($data as $key=>$value)
            {
                $data[$key] = $this->fixValues($value);
                $valueString .= "'{$value}',";
            }

            $valueString = preg_replace("/,$/", '', $valueString);
            $valueString = preg_replace("/''/", 'NULL', $valueString);
    
            $sql  = "INSERT INTO {$table}";
            $sql .= " (".implode(", ", array_keys($data)).")";
            $sql .= " VALUES ({$valueString}) ";
    
            $result = self::$dbconnection->query($sql);

            var_dump($sql);
            echo mysqli_error(self::$dbconnection);
        }

        return $result;
    }

    private function normalizeKeys($forms)
    {
        $arrayKeys = array_keys($forms);
        $keys = array_intersect_key($forms[$arrayKeys[0]], $forms[$arrayKeys[1]]);
        $result = array_merge($forms[$arrayKeys[1]], $keys);
        $forms[$arrayKeys[1]] = $result;

        return $forms;
    }

    private function fixValues($value)
    {
        $value = trim($value);
        
        if ($value==="")
        {
            $value = NULL;
        } else {
            $value = mysqli_real_escape_string(self::$dbconnection, $value);
        }

        return $value;
    }
}