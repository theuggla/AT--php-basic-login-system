<?php

namespace abisDB\view;

class AddDesicionForm
{
    public function getHTML()
    {
        return '
        <p>Please enter the information of the desicion to add. To add a desicion, there needs to be a matching application already in the database. If you are unsure, view all applications in the database and select the caseNumber and date made of the application you want to add a desicion for.</p>
        <form method="POST">
        <p>Case number for the application the desicion is for: <input type="text" name="form[Decision][desicionForCase]" value=""></p>
        <p>Date the application the desicion is for was made: <input type="text" name="form[Decision][desicionForDateMade]" value=""></p>
        <p>Legal validity date of desicion (YYYY-MM-DD): <input type="text" name="form[Decision][validityDate]" value=""></p>
        <p>Denied: Yes <input type="radio" name="form[Decision][denied]" value="1"> No <input type="radio" name="form[RefugeeApplication][tempWorkPermit]" value="0"></p>
        <input type="submit" value="Submit">
        </form>
        ';
    }
}