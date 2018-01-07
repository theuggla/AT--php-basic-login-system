<?php

namespace abisDB;

require_once('ABISDB/controller/DBController.php');
require_once('ABISDB/model/DB.php');
require_once('ABISDB/model/RetrieveDataQuery.php');
require_once('ABISDB/model/PutDataQuery.php');
require_once('ABISDB/view/DBView.php');
require_once('ABISDB/view/ViewProducer.php');
require_once('ABISDB/view/IResultView.php');
require_once('ABISDB/model/Results/IResultModel.php');
require_once('ABISDB/model/Results/ListResult.php');
require_once('ABISDB/view/ListView.php');
require_once('ABISDB/model/Results/SingleResult.php');
require_once('ABISDB/view/SingleView.php');
require_once('ABISDB/view/Forms/AddPersonForm.php');
require_once('ABISDB/view/Forms/AddEmployeeForm.php');
require_once('ABISDB/view/Forms/AddMemberForm.php');
require_once('ABISDB/view/Forms/AddContractForm.php');
require_once('ABISDB/view/Forms/AddRefugeeApplicationForm.php');
require_once('ABISDB/view/Forms/AddAppealForm.php');
require_once('ABISDB/view/Forms/AddDesicionForm.php');

class AbisDB
{
    private static $dbconnection = 'AbisDB::DBConnection';
    private $currentHTML = 'AbisDB::CurrentHTML';

    public function __construct($dbconnection)
    {
        self::$dbconnection = $dbconnection;
    }
    
    public function runDB(bool $authorized = false)
    {
        $this->assertThereIsASession();

        $db = new \abisDB\model\DB(self::$dbconnection);
        $dbview = new \abisDB\view\DBView();
        $dbcontroller = new \abisDB\controller\DBController($authorized, $db, $dbview);

        $dbcontroller->runDB();
        $this->currentHTML = $dbcontroller->getCurrentHTML();
    }

    public function getCurrentHTML() : string
    {
        return $this->currentHTML;
    }

    private function assertThereIsASession()
    {
        assert(isset($_SESSION));
    }
}
