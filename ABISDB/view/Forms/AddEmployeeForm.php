<?php

namespace abisDB\view;

class AddEmployeeForm
{
    public function getHTML()
    {
        return '
        <p>Please enter the information of the employee to add. To add an employee, there needs to be a matching person already in the database. If you are unsure, view all people in the database and select the personID of the person you want to add as an employee.</p>
        <form method="POST">
        <p>PersonID: <input type="text" name="form[Employee][personID]" value=""></p>
        <p>EmployeeID: <input type="text" name="form[Employee][empID]" value=""></p>
        <p>Nationality: <input type="text" name="form[Employee][nationality]" value=""></p>
        <p>Gender: <input type="text" name="form[Employee][gender]" value=""></p>
        <p>Education: <input type="text" name="form[Employee][education]" value=""></p>
        <input type="submit" value="Submit">
        </form>
        ';
    }
}