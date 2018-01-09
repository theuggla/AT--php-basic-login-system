<?php

namespace abisDB\model;

class RetrieveDataQuery
{
    private static $dbconnection;

    public function __construct($dbconnection)
    {
        self::$dbconnection = $dbconnection;

    }

    public function getAllMembers()
    {
        $query="SELECT 
    firstName AS 'First name', 
    lastName AS 'Last name', 
    mail AS 'Email' 
FROM 
    Person 
INNER JOIN
	Member
ON (Person.personID = Member.personID AND Member.datePaid > DATE_SUB(NOW(), INTERVAL 1 YEAR))";

        $result = self::$dbconnection->query($query);

        return (new \abisDB\model\ListResult($result->fetch_all(MYSQLI_ASSOC), "Members"));
    }

    public function getAllExpiringPermits()
    {
        $query='SELECT 
        firstName AS "First name", 
        lastName AS "Last name",
        LMAExpiry AS "Permit expires",
        CASE
          WHEN mail IS NOT NULL THEN mail
         ELSE "No personal mail"
         END AS "Personal email",
        CASE
          WHEN phoneNumber IS NOT NULL THEN phoneNumber
         ELSE "No personal phone"
         END AS "Personal phone",
        CASE
          WHEN contactMail IS NOT NULL THEN contactMail
         ELSE "No person of contact"
         END AS "Contact email",
        CASE
          WHEN contactPhone IS NOT NULL THEN contactPhone
         ELSE "No person of contact"
         END AS "Contact phone"
        FROM
        ((SELECT lastName, firstName, mail, phoneNumber, DATE(LMAExpiry) as LMAexpiry, personOfContact FROM Person 
            INNER JOIN Employee ON Person.personID = Employee.personID
            INNER JOIN Application ON Application.empID = Employee.empID
            INNER JOIN 
                (SELECT * from RefugeeApplication where (DATEDIFF(LmaExpiry, NOW()) <= 21)) AS expires 
            ON expires.caseNumber = Application.caseNumber) AS applicants
        LEFT JOIN
        (SELECT personID as contactID, mail as contactMail, phoneNumber as contactPhone from Person) as contacts
        ON applicants.personOfContact = contacts.contactID)';

        $result = self::$dbconnection->query($query);

        return (new \abisDB\model\ListResult($result->fetch_all(MYSQLI_ASSOC), "Expiring Permits"));
    }

    public function getPermanentWorkPermitEligibility()
    {
        $query='SELECT 
        firstName AS "First name",
        lastName AS "Last name",
        empID AS "Employee ID", 
        DATE(startDate) AS "Employee start date",
        CASE
        WHEN mail IS NOT NULL THEN mail
       ELSE "No personal mail"
       END AS "Personal email",
      CASE
        WHEN phoneNumber IS NOT NULL THEN phoneNumber
       ELSE "No personal phone"
       END AS "Personal phone",
      CASE
        WHEN contactMail IS NOT NULL THEN contactMail
       ELSE "No person of contact"
       END AS "Contact email",
      CASE
        WHEN contactPhone IS NOT NULL THEN contactPhone
       ELSE "No person of contact"
       END AS "Contact phone"
        FROM 
        ((SELECT lastName, firstName, contracts.empID AS empID, contracts.startDate AS startDate, mail, phoneNumber, personOfContact
            FROM Person INNER JOIN Employee ON Person.personID = Employee.personID
        INNER JOIN
        (SELECT *
         FROM 
          (SELECT
            empID, 
            MIN(startDate) as startDate,
            CASE
             WHEN MAX(endDate IS NULL) = 0 THEN MAX(endDate)
             END as endDate,
            CASE
             WHEN (hourlySalary * hoursPerWeek * 52) / 12 >= 13000 THEN true
             ELSE false
             END as salary
            FROM
            Contract
            GROUP BY empID, salary) 
          as normalizedContracts
          WHERE ( 
            (IF(DATE(NOW()) < 25, (MONTH(startDate) < MONTH(NOW()) - 4), (MONTH(startDate) < MONTH(NOW()) - 5)) OR (YEAR(startDate) < YEAR(NOW()))
            AND (endDate IS NULL))
            AND salary = true))
             as contracts
        ON Employee.empID = contracts.empID) as people
        LEFT JOIN
        (SELECT personID as contactID, mail as contactMail, phoneNumber as contactPhone from Person) as contacts
        ON people.personOfContact = contacts.contactID)';
        $result = self::$dbconnection->query($query);

        return (new \abisDB\model\ListResult($result->fetch_all(MYSQLI_ASSOC), "Eligible for Work Permit"));
    }

    public function getPermanentExpulsionRisk()
    {
        $query="SELECT 
        firstName AS 'First name', 
        lastName AS 'Last name',
        DATE(validityDate) as 'Second denial valid from',
        CASE
            WHEN mail IS NOT NULL THEN mail
            ELSE 'No personal mail'
        END AS 'Personal email',
        CASE
            WHEN phoneNumber IS NOT NULL THEN phoneNumber
            ELSE 'No personal phone'
        END AS 'Personal phone',
        CASE
            WHEN contactMail IS NOT NULL THEN contactMail
            ELSE 'No person of contact'
        END AS 'Contact email',
        CASE
            WHEN contactPhone IS NOT NULL THEN contactPhone
            ELSE 'No person of contact'
        END AS 'Contact phone'
    FROM
        ((SELECT 
            lastName, 
            firstName, 
            mail, 
            phoneNumber, 
            validityDate, 
            personOfContact 
        FROM 
            Person 
        INNER JOIN 
            Employee 
        ON Person.personID = Employee.personID
        INNER JOIN 
            (SELECT 
                validityDate, 
                caseNumber,
                empID
             FROM
                Decision 
            INNER JOIN 
                (SELECT 
                    Appeal.caseNumber, 
                    denials.empID
                 FROM 
                    Appeal 
                 INNER JOIN 
                    (SELECT caseNumber, empID
                     FROM 
                        (SELECT RefugeeApplication.caseNumber, empID
                         FROM 
                            RefugeeApplication INNER JOIN Application ON RefugeeApplication.caseNumber = Application.caseNumber
                         WHERE 
                            RefugeeApplication.dateMade 
                         IN 
                            (SELECT 
                                MAX(RefugeeApplication.dateMade) 
                            FROM 
                                RefugeeApplication INNER JOIN Application ON RefugeeApplication.caseNumber = Application.caseNumber
                            GROUP BY 
                                empID)
                            ) AS latestApplication 
                     INNER JOIN 
                        Decision 
                     ON (Decision.desicionForCase = latestApplication.caseNumber 
                         AND denied = true)
                     ) AS denials
                 ON Appeal.appealOfCaseNumber = denials.caseNumber 
                 ) AS firstAppeal
            ON (firstAppeal.caseNumber = Decision.desicionForCase 
                 AND denied = true)
            ) AS secondDenials 
        ON secondDenials.empID = Employee.empID
        ) AS deniedEmployees
    LEFT JOIN
        (SELECT 
            personID AS contactID, 
            mail AS contactMail, 
            phoneNumber AS contactPhone 
        FROM Person
        ) AS contacts
    ON deniedEmployees.personOfContact = contacts.contactID)";
        
        $result = self::$dbconnection->query($query);

        return (new \abisDB\model\ListResult($result->fetch_all(MYSQLI_ASSOC), "At Risk of Permanent Expulsion"));
    }

    public function getWorkPermitMaterial(string $personID)
    {
        $query='SELECT 
        firstName AS "First name", 
        lastName AS "Last name",
        SSID,
        address AS "Address",
        nationality AS "Nationality",
        gender AS "Gender",
        education AS "Education",
        CONCAT(FORMAT(workPercentage * 100.0, 2),"%") AS "Part time percentage",
        CONCAT(FORMAT(monthlySalary, 0)," kr") AS "Monthly Salary",
        contractStart AS "Contract Start",
        tasks AS "Tasks",
        CASE
          WHEN mail IS NOT NULL THEN mail
         ELSE "No personal mail"
         END AS "Personal email",
        CASE
          WHEN contactMail IS NOT NULL THEN contactMail
         ELSE "No person of contact"
         END as "Contact email"
        FROM ((SELECT lastName, firstName, SSID, mail, address, personOfContact, nationality, gender, education , workPercentage, monthlySalary, taskSummary.summary as tasks, DATE(firstContract.startDate) as contractStart
                FROM (select * from Person WHERE personID = ' . $personID . ') as people
                INNER JOIN 
                Employee ON people.personID = Employee.personID
                INNER JOIN
                (select empID, hoursPerWeek / 40 as workPercentage, ((hoursPerWeek * hourlySalary * 52) / 12) as monthlySalary from Contract where startDate IN (SELECT MAX(startDate) FROM Contract GROUP BY empID)) as latestContract
                ON Employee.empID = latestContract.empID
                INNER JOIN
                (select empID, startDate from Contract where startDate IN (SELECT MIN(startDate) FROM Contract GROUP BY empID)) as firstContract
                ON Employee.empID = firstContract.empID
                INNER JOIN
                (select empID, startDate, GROUP_CONCAT(tasks SEPARATOR "\n") as summary FROM (select empID, startDate, CONCAT(taskName, ": ", ssyks.SSYK) as tasks from (Tasks INNER JOIN (select empID, startDate, SSYK from ContractTasks) as ssyks ON ssyks.SSYK = Tasks.SSYK)) as tasks GROUP BY empID, startDate) as taskSummary
                ON taskSummary.empID = firstContract.empID AND taskSummary.startDate = firstContract.startDate
                ) as employees
        LEFT JOIN
        (SELECT personID as contactID, mail as contactMail, phoneNumber as contactPhone from Person) as contacts
        ON employees.personOfContact = contacts.contactID)';

        $result = self::$dbconnection->query($query);

        return (new \abisDB\model\SingleResult($result->fetch_all(MYSQLI_ASSOC), "Work permit material for Employee with person ID {$personID}"));
    }

    public function getAllPeople()
    {
        $query="SELECT 
        personID AS 'PersonID',
        address AS 'Address',
        accountNumber AS 'Account',
        firstName AS 'First name',
        lastName AS 'Last name',
        SSID AS 'SSID',
            CASE
                WHEN mail IS NOT NULL THEN mail
                ELSE 'No personal mail'
            END AS 'Personal email',
            CASE
                WHEN phoneNumber IS NOT NULL THEN phoneNumber
                ELSE 'No personal phone'
            END AS 'Personal phone',
            CASE
                WHEN contactMail IS NOT NULL THEN contactMail
                ELSE 'No person of contact'
            END AS 'Contact email',
            CASE
                WHEN contactPhone IS NOT NULL THEN contactPhone
                ELSE 'No person of contact'
            END AS 'Contact phone'
        FROM 
        Person INNER JOIN Employee on Person.personID = Employee.personID
        LEFT JOIN
    (SELECT 
        personID AS contactID, 
        mail AS contactMail, 
        phoneNumber AS contactPhone 
    FROM Person
    ) AS contacts
ON Person.personOfContact = contacts.contactID
        ";

        $result = self::$dbconnection->query($query);
        
        return (new \abisDB\model\ListResult($result->fetch_all(MYSQLI_ASSOC), "All people in the database"));
    }

    public function getAllEmployees()
    {
        $query="SELECT 
        Person.personID AS 'PersonID',
        address AS 'Address',
        accountNumber AS 'Account',
        firstName AS 'First name',
        lastName AS 'Last name',
        SSID AS 'SSID',
        empID AS 'Employee ID',
        nationality AS 'Nationality',
        gender AS 'Gender',
        education AS 'Education',
            CASE
                WHEN mail IS NOT NULL THEN mail
                ELSE 'No personal mail'
            END AS 'Personal email',
            CASE
                WHEN phoneNumber IS NOT NULL THEN phoneNumber
                ELSE 'No personal phone'
            END AS 'Personal phone',
            CASE
                WHEN contactMail IS NOT NULL THEN contactMail
                ELSE 'No person of contact'
            END AS 'Contact email',
            CASE
                WHEN contactPhone IS NOT NULL THEN contactPhone
                ELSE 'No person of contact'
            END AS 'Contact phone'
        FROM 
        Person INNER JOIN Employee ON Person.personID = Employee.personID
		LEFT JOIN
		(SELECT personID as contactID, mail as contactMail, phoneNumber as contactPhone from Person) as contacts
		ON personOfContact = contacts.contactID;";
        
        $result = self::$dbconnection->query($query);
                
        return (new \abisDB\model\ListResult($result->fetch_all(MYSQLI_ASSOC), "All employees in the database"));
    }
}