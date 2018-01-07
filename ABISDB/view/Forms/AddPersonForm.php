<?php

namespace abisDB\view;

class AddPersonForm
{
    public function getHTML()
    {
        return '
        <p>Please enter the information of the person to add</p>
        <form method="POST">
        <p>First Name: <input type="text" name="form[Person][firstName]" value=""></p>
       <p>Last Name: <input type="text" name="form[Person][lastName]" value=""></p>
       <p>SSID: <input type="text" name="form[Person][SSID]" value=""></p>
       <p>Phone Number: <input type="text" name="form[Person][phoneNumber]" value=""></p>
       <p>Email: <input type="text" name="form[Person][mail]" value=""></p>
       <p>Address: <input type="text" name="form[Person][address]" value=""></p>
       <p>Account Number: <input type="text" name="form[Person][accountNumber]" value=""></p>
       <p>Contact person\'s personal ID: <input type="text" name="form[Person][personOfContact]" value=""></p>
        <input type="submit" value="Submit">
        </form>
        ';
    }
}