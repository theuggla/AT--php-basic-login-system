<?php

namespace abisDB\view;

class DBView
{
    private static $empChosen = "emp";
    private static $queryChosen = "query";
    private static $query1 = "query=1";
    private static $query2 = "query=2";
    private static $query3 = "query=3";
    private static $query4 = "query=4";
    private static $query5 = "query=5";
    private static $query6 = "query=6";
    private static $query7 = "query=7";
    private static $formChosen = "form";
    private static $form1 = "form=Person";
    private static $form2 = "form=Employee";
    private static $form3 = "form=Member";
    private static $form4 = "form=Contract";
    private static $form5 = "form=RefugeeApplication";
    private static $form6 = "form=Appeal";
    private static $form7 = "form=Desicion";

    private $addPersonForm;
    private $addEmployeeForm;
    private $addMemberForm;
    private $addContractForm;
    private $addRefugeeApplicationForm;
    private $addAppealForm;
    private $addDesicionForm;

    public function __construct()
    {
        $this->addPersonForm = new \abisDB\view\AddPersonForm();
        $this->addEmployeeForm = new \abisDB\view\AddEmployeeForm();
        $this->addMemberForm = new \abisDB\view\AddMemberForm();
        $this->addContractForm = new \abisDB\view\AddContractForm();
        $this->addRefugeeApplicationForm = new \abisDB\view\AddRefugeeApplicationForm();
        $this->addAppealForm = new \abisDB\view\AddAppealForm();
        $this->addDesicionForm = new \abisDB\view\AddDesicionForm();
    }

    public function displayInstructions(bool $authorized)
    {
        if ($authorized) {
            return
            "<p>Welcome to the Abis database!</p>"
            ."<p>"
            . $this->getActionsHTML()
            ."</p>"
            ;
        }
        else {
            return
            "<p>Please log in to use the database</p>"
            ;
        }
    }

    public function querySelected() : bool
    {
        return isset($_GET[self::$queryChosen]);
    }

    public function collectDesiredQuery()
    {
        return $_GET[self::$queryChosen];
    }

    public function displayQueryResult(\abisDB\view\IResultView $result)
    {
        return "{$result->getHTML()}";
    }

    public function formSelected() : bool
    {
        return isset($_GET[self::$formChosen]);
    }

    public function collectDesiredForm()
    {
        return $_GET[self::$formChosen];
    }

    public function formSubmitted() : bool
    {
        return isset($_POST[self::$formChosen]);
    }

    public function getFormArguments()
    {
        return $_POST[self::$formChosen];
    }

    public function displaySelectedForm(string $form)
    {
        $HTML;

        switch ($form)
        {
            case "Person":
                $HTML = $this->addPersonForm->getHTML();
                break;
            case "Employee":
                $HTML = $this->addEmployeeForm->getHTML();
                break;
            case "Member":
                $HTML = $this->addMemberForm->getHTML();
                break;
            case "Contract":
                $HTML = $this->addContractForm->getHTML();
                break;
            case "RefugeeApplication":
                $HTML = $this->addRefugeeApplicationForm->getHTML();
                break;
            case "Appeal":
                $HTML = $this->addAppealForm->getHTML();
                break;
            case "Desicion":
                $HTML = $this->addDesicionForm->getHTML();
                break;
            default:
                $HTML = 'No such form.';
                break;
        }

        return "<div class='form'>{$HTML}</div>";
    }

    public function displayEmpIDForm()
    {
        return "<div class='form'>
                <p>Please enter the peronal ID of the employee to get.</p>
                <form method='post'>
                Personal ID:<br>
                <input type='text' name='emp' value=''><br>
                <input type='submit' value='Submit'>
                </form>
                </div>";
    }

    public function empIDSelected() : bool
    {
        return isset($_POST[self::$empChosen]);
    }

    public function getEmpID()
    {
        return $_POST[self::$empChosen];
    }

    private function getActionsHTML()
    {
        return
        '
        <div>
            <div class="queries">
            <p>Choose the query you want to run.</p>
            <p><a href="?' . self::$query1 . '">Get all members information</a></p>
            <p><a href="?' . self::$query2 . '">Get all expiring permits</a></p>
            <p><a href="?' . self::$query3 . '">Get all people eligible for a permanent work permit</a></p>
            <p><a href="?' . self::$query4 . '">Get everyone in risk of being permanently denied to stay in the country</a></p>
            <p><a href="?' . self::$query5 . '">Get the material for a specific employee\'s Working Permit </a></p>
            <p><a href="?' . self::$query6 . '">Get all persons information</a></p>
            <p><a href="?' . self::$query7 . '">Get all employees information</a></p>
            </div>
            <div class="forms">
            <p>Choose the form you want to use.</p>
            <p><a href="?' . self::$form1 . '">Add person</a></p>
            <p><a href="?' . self::$form2 . '">Add employee</a></p>
            <p><a href="?' . self::$form3 . '">Add member</a></p>
            <p><a href="?' . self::$form4 . '">Add contract</a></p>
            <p><a href="?' . self::$form5 . '">Add refugee application</a></p>
            <p><a href="?' . self::$form6 . '">Add appeal</a></p>
            <p><a href="?' . self::$form7 . '">Add desicion</a></p>
            </div>
        </div>
        ';
    }
}
