<?php

namespace abisDB\model;

class DB
{
    private static $putDataQuery;
    private static $retrieveDataQuery;

    private $latestQueryResult;
    private $latestFormResult;

    public function __construct($dbconnection)
    {
        $this->latestQueryResult = 'No query has been run yet.';
        $this->latestFormResult = '';
        self::$retrieveDataQuery = new \abisDB\model\RetrieveDataQuery($dbconnection);
        self::$putDataQuery = new \abisDB\model\PutDataQuery($dbconnection);
    }

    public function runQuery(string $queryNumber, string $queryArgument)
    {
        switch ($queryNumber) {
            case 1:
                $this->latestQueryResult = self::$retrieveDataQuery->getAllMembers();
                break;
            case 2:
                $this->latestQueryResult = self::$retrieveDataQuery->getAllExpiringPermits();
                break;
            case 3:
                $this->latestQueryResult = self::$retrieveDataQuery->getPermanentWorkPermitEligibility();
                break;
            case 4:
                $this->latestQueryResult = self::$retrieveDataQuery->getPermanentExpulsionRisk();
                break;
            case 5:
                $this->latestQueryResult = self::$retrieveDataQuery->getWorkPermitMaterial($queryArgument);
                break;
            case 6:
                $this->latestQueryResult = self::$retrieveDataQuery->getAllPeople();
                break;
            case 7:
                $this->latestQueryResult = self::$retrieveDataQuery->getAllEmployees();
                break;
            default:
                $this->latestQueryResult = "No such query";
        }
    }

    public function getQueryResult()
    {
        return $this->latestQueryResult;
    }

    public function addData($selectedType, $typeArguments)
    {
        $this->latestFormResult = self::$putDataQuery->addRowsToTables($typeArguments);
    }
}
