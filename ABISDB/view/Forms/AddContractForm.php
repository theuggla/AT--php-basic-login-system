<?php

namespace abisDB\view;

class AddContractForm
{
    public function getHTML()
    {
        return '
        <p>Please enter the information of the contract to add. To add a contract, there needs to be a matching employee already in the database. If you are unsure, view all employees in the database and select the empID of the person you want to add a contract for.</p>
        <form method="POST">
        <p>EmployeeID: <input type="text" name="form[Contract][empID]" value=""></p>
        <p>Start Date: <input type="text" name="form[Contract][startDate]" value=""></p>
        <p>End Date: <input type="text" name="form[Contract][endDate]" value=""></p>
        <p>Hourly Salary: <input type="text" name="form[Contract][hourlySalary]" value=""></p>
        <p>Hours Per Week: <input type="text" name="form[Contract][hoursPerWeek]" value=""></p>
        <input type="hidden" name="form[ContractTasks][empID]" value="">
        <input type="hidden" name="form[ContractTasks][startDate]" value="">
        <p>Task: <select name="form[ContractTasks][SSYK]">
        <option value="2277">Gardening</option>
        <option value="3388">Cleaning</option>
        <option value="6677">Cooking</option>
        <option value="8867">Carpenting</option>
      </select></p>
        <input type="submit" value="Submit">
        </form>
        ';
    }
}