<?php

namespace abisDB\view;

class AddAppealForm
{
    public function getHTML()
    {
        return '
        <p>Please enter the information of the appeal to add. To add an appeal, there needs to be a matching application to appeal already in the database. If you are unsure, view all refugee applications in the database and select the caseNumber and date made of the application you want to add an appeal for.</p>
        <form method="POST">
        <p>EmployeeID: <input type="text" name="form[Application][empID]" value=""></p>
        <p>Case number: <input type="text" name="form[Application][caseNumber]" value=""></p>
        <p>Date made (YYYY-MM-DD): <input type="text" name="form[Application][dateMade]" value=""></p>
        <input type="hidden" name="form[Appeal][caseNumber]" value="">
        <input type="hidden" name="form[Appeal][dateMade]" value="">
        <p>Case number of the application to appeal: <input type="text" name="form[Appeal][appealOfCaseNumber]" value=""></p>
        <p>Date the application to appeal was made: (YYYY-MM-DD)<input type="text" name="form[Appeal][appealOfCaseNumberDateMade]" value=""></p>
        <input type="submit" value="Submit">
        </form>
        ';
    }
}