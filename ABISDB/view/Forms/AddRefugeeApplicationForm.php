<?php

namespace abisDB\view;

class AddRefugeeApplicationForm
{
    public function getHTML()
    {
        return '
        <p>Please enter the information of the applicaton to add. To add an application, there needs to be a matching employee already in the database. If you are unsure, view all employees in the database and select the empID of the person you want to add as an application for.</p>
        <form method="POST">
        <p>EmployeeID: <input type="text" name="form[Application][empID]" value=""></p>
        <p>Case number: <input type="text" name="form[Application][caseNumber]" value=""></p>
        <p>Date made: <input type="text" name="form[Application][dateMade]" value=""></p>
        <input type="hidden" name="form[RefugeeApplication][caseNumber]" value="">
        <input type="hidden" name="form[RefugeeApplication][dateMade]" value="">
        <p>LMA expiry: <input type="text" name="form[RefugeeApplication][LMAExpiry]" value=""></p>
        <p>Temp work permit: Yes <input type="radio" name="form[RefugeeApplication][tempWorkPermit]" value="1"> No <input type="radio" name="form[RefugeeApplication][tempWorkPermit]" value="0"></p>
        <input type="submit" value="Submit">
        </form>
        ';
    }
}