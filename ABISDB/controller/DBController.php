<?php

namespace abisDB\controller;

class DBController {

    private $db = 'AbisDB::abisDBController::DB';
    private $dbView = 'AbisDB::abisDBController::abisDBView';
    private $viewProducer = 'AbisDB::abisDBController::getCorrectView';
    private $authorized = 'AbisDB::abisDBController::authorized';
    private $currentHTML = 'AbisDB::abisDBController::CurrentHTML';

    public function __construct(bool $authorized, \abisDB\model\DB $db, \abisDB\view\DBView $dbView)
    {
        $this->db = $db;
        $this->dbView = $dbView;
        $this->authorized = $authorized;
        $this->viewProducer = new \abisDb\view\ViewProducer();
    }

    public function getCurrentHTML() : string
    {
        return $this->currentHTML;
    }

    public function runDB()
    {
        $this->currentHTML = $this->dbView->displayInstructions($this->authorized);

        if ($this->authorized)
        {
            if ($this->dbView->querySelected())
            {
                $this->runQuery();
            } 
            else if ($this->dbView->formSelected())
            {
                $this->runForm();
            }
            
        }
    }

    private function runQuery()
    {
        $selectedQuery = $this->dbView->collectDesiredQuery();
        $queryArgument;

        if ($selectedQuery == 5)
        {
            $this->currentHTML .= $this->dbView->displayEmpIDForm();
            if ($this->dbView->empIDSelected())
            {
                $queryArgument = $this->dbView->getEmpID();
            }
        } else 
        {
            $queryArgument = '';
        }

        if (isset($queryArgument))
        {
            $this->db->runQuery($selectedQuery, $queryArgument);
            $resultView = $this->viewProducer->getCorrectView($this->db->getQueryResult());
            $this->currentHTML .= $this->dbView->displayQueryResult($resultView);
        }
    }

    private function runForm()
    {
        $selectedForm = $this->dbView->collectDesiredForm();
        $this->currentHTML .= $this->dbView->displaySelectedForm($selectedForm);

        if ($this->dbView->formSubmitted())
        {
            var_dump($this->dbView->getFormArguments());
            $this->db->addData($selectedForm, $this->dbView->getFormArguments());
        }
    }
}