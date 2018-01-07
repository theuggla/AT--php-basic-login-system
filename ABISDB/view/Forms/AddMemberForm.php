<?php

namespace abisDB\view;

class AddMemberForm
{
    public function getHTML()
    {
        return '
        <p>Please enter the information of the member to add. To add an member, there needs to be a matching person already in the database. If you are unsure, view all people in the database and select the personID of the person you want to add as an member.</p>
        <form method="POST">
        <p>PersonID: <input type="text" name="form[Member][personID]" value=""></p>
        <p>MemberID: <input type="text" name="form[Member][memberID]" value=""></p>
        <p>Start date (YYYY-MM-DD): <input type="text" name="form[Member][startDate]" value=""></p>
        <p>Date paid (YYYY-MM-DD): <input type="text" name="form[Member][datePaid]" value=""></p>
        <input type="submit" value="Submit">
        </form>
        ';
    }
}