<?php

/* 
 * locusEditProcess.php
 * script to process the edition or insertion of a new place
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-12
 */

require_once 'session.inc';
require_once 'DB.inc';
//require_once 'user.inc';
//require_once 'exceptions.inc';


if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    // script called from outside the normal flush
    
} else {
    
    // the input is verified:
//    if ((isset($_POST['locusID']) && trim($_POST['locusID']) === "") ||
//        !isset($_POST['name']) ||
//        trim($_POST['name']) ||
//        !isset($_POST['country']) ||
//        trim($_POST['country']) === "" ||
//        !isset($_POST['kind']) ||
//        trim($_POST['kind']) === "" ||
//        !isset($_POST['description']) ||
//        trim($_POST['description']) === "" ||
//        !isset($_POST['rating']) ||
//        trim($_POST['rating']) === "")
//        throw new Exception();
    
    // get a DB connection to work with:
    $pdo = DB::getDBHandle();
    
    if (isset($_POST['locusID'])) { // called form locus.php: edit place
        
        $locusEdit = true;
        $locusID = intval($_POST['locusID']);
        
    } else { // called from loca.php: new place
        
        $locusEdit = false;
        
        // locusID is calculated:
        $maxLocusID =
            $pdo->query("SELECT MAX(`locusID`) FROM `loca`")->fetchColumn();
        $locusID = $maxLocusID === null ? 1 : intval($maxLocusID) + 1;
            
    }
    
    
    // the values are retrieved from $_POST:
    $name = $_POST['name'];
    $country = intval($_POST['country']);
    $kind = intval($_POST['kind']);
    $description = $_POST['description'];
    $rating = intval($_POST['rating']);
    
    // build the SQL query depending on $locusEdit:
    if ($locusEdit) { // update existing place

        // update query:
        $queryString = <<<QUERY
UPDATE `loca`
SET `name`=:name,
    `country`=:country,
    `kind`=:kind,
    `description`=:description,
    `rating`=:rating
WHERE `locusID`=:locusID
QUERY;
    
    } else { // insert new place   

        // insertion query:
        $queryString = <<<QUERY
INSERT
INTO `loca`
VALUES (:locusID,
    "",
    :name,
    :country,
    :kind,
    :description,
    :rating,
    "",
    "",
    "",
    "",
    :userID)
QUERY;

    }
    
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":locusID", $locusID, PDO::PARAM_INT);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->bindParam(":country", $country, PDO::PARAM_INT);
    $statement->bindParam(":kind", $kind, PDO::PARAM_INT);
    $statement->bindParam(":description", $description, PDO::PARAM_STR);
    $statement->bindParam(":rating", $rating, PDO::PARAM_INT);
    // (other fields)
    if (!$locusEdit)
        $statement->bindParam(":userID",$_SESSION['userID'], PDO::PARAM_INT);
    $statement->execute();

    // 99. redirect the user to the page 'amores.php':
    header ("Location: loca.php");

}

?>