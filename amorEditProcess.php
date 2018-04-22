<?php
/* 
 * script 'amorEditProcess.php'.
 * 
 * script to process the edition or insertion of a new lover
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-13
 */

require_once 'session.inc';
require_once 'DB.inc';
//require_once 'user.inc';
//require_once 'exceptions.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();


// TODO: verify the input:
//if (!isset($_POST['username'])
//        || trim($_POST['username']) === ""
//        || !isset($_POST['password'])
//        || trim($_POST['username']) === "") {
//    
//    throw new Exception();
//    
//}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    if (isset($_POST['amorID'])) { // called form amor.php: edit lover
        
        $amorEdit = true;
        $amorID = intval($_POST['amorID']);

    } else { // called from amor.php: new lover
        
        $amorEdit = false;
        
        // amorID is calculated:
        $maxAmorID =
            $pdo->query("SELECT MAX(`amorID`) FROM `amores`")->fetchColumn();
        $amorID = $maxAmorID === null ? 1 : intval($maxAmorID) + 1;
            
    }
    
    // the values are retrieved from $_POST:
    $alias = $_POST['alias'];
    $genre = intval($_POST['genre']);
    $descr1 = $_POST['descr1'];
    $descr2 = $_POST['descr2'];
    $descr3 = $_POST['descr3'];
    $descr4 = $_POST['descr4'];
    $rating = intval($_POST['rating']);
    $www = $_POST['www'];
    $name = $_POST['name'];
    $photo = intval($_POST['photo']);
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $other = $_POST['other'];
    
    // build the SQL query depending on $amorEdit:
    if ($amorEdit) { // update existing lover

        // update query:
        $queryString = <<<QUERY
UPDATE `amores`
SET `alias`=:alias,
    `genre`=:genre,
    `descr1`=:descr1,
    `descr2`=:descr2,
    `descr3`=:descr3,
    `descr4`=:descr4,
    `rating`=:rating,
    `www`=:www,
    `name`=:name,
    `photo`=:photo,
    `telephone`=:telephone,
    `email`=:email,
    `other`=:other
WHERE `amorID`=:amorID
QUERY;
    
    } else { // insert new lover   

        // insertion query:
        $queryString = <<<QUERY
INSERT
INTO `amores`
VALUES (:amorID,
    "",
    :alias,
    :genre,
    :descr1,
    :descr2,
    :descr3,
    :descr4,
    :rating,
    :www,
    :name,
    :photo,
    :telephone,
    :email,
    :other,
    :userID)
QUERY;

    }
    
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":amorID", $amorID, PDO::PARAM_INT);
    $statement->bindParam(":alias", $alias, PDO::PARAM_STR);
    $statement->bindParam(":genre", $genre, PDO::PARAM_INT);
    $statement->bindParam(":descr1", $descr1, PDO::PARAM_STR);
    $statement->bindParam(":descr2", $descr2, PDO::PARAM_STR);
    $statement->bindParam(":descr3", $descr3, PDO::PARAM_STR);
    $statement->bindParam(":descr4", $descr4, PDO::PARAM_STR);
    $statement->bindParam(":rating", $rating, PDO::PARAM_INT);
    $statement->bindParam(":www", $www, PDO::PARAM_STR);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->bindParam(":photo", $photo, PDO::PARAM_INT);
    $statement->bindParam(":telephone", $telephone, PDO::PARAM_STR);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->bindParam(":other", $other, PDO::PARAM_STR);
    if (!$amorEdit)
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
    $statement->execute();

    // 99. redirect the user to the page 'amor.php' or 'amores.php':
    if ($amorEdit) {
        
        header ("Location: amor.php?amorID=".$amorID);
        
    } else {
        
        header ("Location: amores.php");
    }
    

} /*else script called from outside the normal flush, throw exception*/

?>