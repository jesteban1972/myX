<?php
/**
 * script 'praxisEditProcess.php'.
 * 
 * script to process the edition of an already existing experience
 * or the insertion of a new one.
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-18
 */

require_once 'core.inc';
//require_once 'session.inc';
require_once 'DB.inc';
//require_once 'user.inc';
//require_once 'exceptions.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}

// get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * first of all a boolean flag 'praxisEdit' is set to distinguish
 * if the script whether has been called:
 * i) for edition of an already existing experience
 * (when 'praxisID' has been received by GET), or
 * ii) for inserting a brand new experience, process which can imply
 * the insertion of another new data, such as a place and/or lover(s).
 */

if (isset($_GET['praxisID'])) {
// script called form praxis.php': edition of an already existing experience.

    $praxisEdit = true;
    $praxisID = intval($_GET['praxisID']);

} else {
// called from 'index.php' or 'practica.php': insertion of a new experience.

    $praxisEdit = false;

    // praxisID is calculated:
    $queryString = <<<QUERY
SELECT MAX(`praxisID`)
FROM `practica`
QUERY;
    $maxPraxisID = $pdo->query($queryString)->fetchColumn();
    $praxisID = ($maxPraxisID === null) ? 1 : intval($maxPraxisID) + 1;

}

/*
 * within this script, unlike 'amorEditProcess.php' or 'locusEditProcess.php',
 * data are not to be taken from $_POST but from $_SESSION, from the variables
 * $_SESSION['tempPraxisData], $_SESSION[tempLocusData] (includiyng also
 * $_SESSION['tempCountryData'] and $_SESSION['tempKindData]) and, finally,
 * $_SESSION['tempAmorData'][].
 * having all this data ready, a transaction is accomplished, having inserted
 * (or updated) all data, or none.
 * 
 * the following insertion order is neccesary because of the referential
 * integrity:
 * 1. country (if any, when inserting).
 * 2. kind (if any, when inserting).
 * 3. place (if any, when inserting).
 * 4. experience.
 * 5. lover(s) (if any, when inserting).
 * 6. assignations (when inserting).
 * 
 * when retrieving the data, we store them in variables with appropiate names,
 * usually corresponding with the corresponding field and being attentive with
 * duplicates (e.g. praxisName != amorName != locusName).
 */

// country data (if any) are verified and retrieved:
if (isset($_SESSION['tempCountryData'])) {
    
    // only name is compulsory:
    if (trim($_SESSION['tempCountryData']['name']) === "")
        throw new Exception();
    
    // countryID is calculated:
    $queryString = <<<QUERY
SELECT MAX(`countryID`)
FROM `countries`      
QUERY;
    $maxCountryID = $pdo->query($queryString)->fetchColumn();
    $countryID = ($maxCountryID === null) ? 1 : intval($maxCountryID) + 1;
    
    // data are retrieved:
    $countryName = $_SESSION['tempCountryData']['name'];
    
}

// kind data (if any) are verified and retrieved:
if (isset($_SESSION['tempKindData'])) {
    
    // only 'name' is compulsory:
    if (trim($_SESSION['tempKindData']['name']) === "")
        throw new Exception();
    
    // kindID is calculated:
    $queryString = <<<QUERY
SELECT MAX(`kindID`)
FROM `kinds`      
QUERY;
    $maxKindID = $pdo->query($queryString)->fetchColumn();
    $kindID = ($maxKindID === null) ? 1 : intval($maxKindID) + 1;
    
    // data are retrieved:
    $kindName = $_SESSION['tempKindData']['name'];
    
}

// place data (if any) are verified and retrieved:
if (isset($_SESSION['tempLocusData'])) {
    
    // only 'name' is compulsory:
    if (trim($_SESSION['tempLocusData']['name']) === "")
        throw new Exception();
    
    // kindID is calculated:
    $queryString = <<<QUERY
SELECT MAX(`locusID`)
FROM `loca`      
QUERY;
    $maxLocusID = $pdo->query($queryString)->fetchColumn();
    $locusID = ($maxLocusID === null) ? 1 : intval($maxLocusID) + 1;
    
    // data are retrieved:
    $locusAchtung = $_SESSION['tempLocusData']['achtung'];
    $locusName = $_SESSION['tempLocusData']['name'];
    $locusRating = $_SESSION['tempLocusData']['rating'];
    $address = $_SESSION['tempLocusData']['address'];
    $country = (isset($_SESSION['tempCountryData'])) ? $countryID : 1; //!!!
    $kind = (isset($_SESSION['tempKindData'])) ? $kindID : 1; //!!!
    $locusDescr = $_SESSION['tempLocusData']['descr'];
    $coordExact = $_SESSION['tempLocusData']['coordExact'];
    $coordGeneric = $_SESSION['tempLocusData']['coordGeneric'];
    $locusWeb = $_SESSION['tempLocusData']['web'];
    
}

// experience data:

/*
 * independently of $praxisEdit' form values the data are taken from
 * $_SESSION['tempPraxisData'], whose values have been updated everytime
 * when the script was left ('locusEdit.php' or 'amorEdit.php'),
 * or before the form was submitted.
 */



// compulsory fields: 'name', 'locus', 'date':
if (!isset($_SESSION['tempPraxisData']) ||
    trim($_SESSION['tempPraxisData']['name']) === "" ||
    ($_SESSION['tempPraxisData']['locus']) === "" || // -1 or possitive value
    trim($_SESSION['tempPraxisData']['date']) === ""
    )
        throw new Exception();

// data are retrieved:
$praxisAchtung = $_SESSION['tempPraxisData']['achtung'];
$praxisName = $_SESSION['tempPraxisData']['name'];
$praxisRating = $_SESSION['tempPraxisData']['rating'];
$favorite = $_SESSION['tempPraxisData']['favorite'];
$locus = ($_SESSION['tempPraxisData']['locus'] !== -1) ?
    $_SESSION['tempPraxisData']['locus'] :
    $locusID; //!!! check
$date = $_SESSION['tempPraxisData']['date'];
$ordinal = $_SESSION['tempPraxisData']['ordinal'];
$praxisDescr = $_SESSION['tempPraxisData']['descr'];
$tq = $_SESSION['tempPraxisData']['tq'];
$tl = $_SESSION['tempPraxisData']['tl'];

// lover(s) data (if any) are verified and retrieved:
// the following should be performed for each one of the temporary lovers:
if (isset($_SESSION['tempAmorData'][0])) {
    
    // only field 'alias' is compulsory:
    if (trim($_SESSION['tempAmorData'][0]['alias']) === "")
        throw new Exception();
    
    // amorID is calculated:
    $queryString = <<<QUERY
SELECT MAX(`amorID`)
FROM `amores`      
QUERY;
    $maxAmorID = $pdo->query($queryString)->fetchColumn();
    $amorID[0] = ($maxAmorID === null) ? 1 : intval($maxAmorID) + 1;
    
    // data are retrieved:
    $amorAchtung[0] = $_SESSION['tempAmorData'][0]['achtung'];
    $alias[0] = $_SESSION['tempAmorData'][0]['alias'];
    $amorRating[0] = $_SESSION['tempAmorData'][0]['rating'];
    $genre[0] = $_SESSION['tempAmorData'][0]['genre'];
    $descr1[0] = $_SESSION['tempAmorData'][0]['descr1'];
    $descr2[0] = $_SESSION['tempAmorData'][0]['descr2'];
    $descr3[0] = $_SESSION['tempAmorData'][0]['descr3'];
    $descr4[0] = $_SESSION['tempAmorData'][0]['descr4'];
    $amorWeb[0] = $_SESSION['tempAmorData'][0]['web'];
    $amorName[0] = $_SESSION['tempAmorData'][0]['name'];
    $photo[0] = $_SESSION['tempAmorData'][0]['photo'];
    $phone[0] = $_SESSION['tempAmorData'][0]['phone'];
    $email[0] = $_SESSION['tempAmorData'][0]['email'];
    $other[0] = $_SESSION['tempAmorData'][0]['other'];
    
} else { // already existing lover(s)
    
    $amor[0] = ($_SESSION['tempPraxisData']['amor'] !== -1) ?
        $_SESSION['tempPraxisData']['amor'] :
        $amorID[0]; //!!! check
    
}

/*
 * after all data has been retrieved, a DB transaction is accomplished,
 * inserting (or updating) all data, or none:
 */

try {
    
    $pdo->beginTransaction();
    
    // new country (if any) is inserted:
    if (isset($_SESSION['tempCountryData'])) {
        
        $queryString = <<<QUERY
INSERT
INTO `countries`
VALUES (:countryID,
    :name,
    :user)
QUERY;

        $statement = $pdo->prepare($queryString);
        
        $statement->bindParam(":countryID", $countryID, PDO::PARAM_INT);
        $statement->bindParam(":name", $countryName, PDO::PARAM_STR);
        $statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);
        
        $statement->execute();
        
    }
    
    // new kind (if any) is inserted:
    if (isset($_SESSION['tempKindData'])) {
        
        $queryString = <<<QUERY
INSERT
INTO `kinds`
VALUES (:kindID,
    :name,
    :user)
QUERY;

        $statement = $pdo->prepare($queryString);
        
        $statement->bindParam(":kindID", $kindID, PDO::PARAM_INT);
        $statement->bindParam(":name", $kindName, PDO::PARAM_STR);
        $statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);
        
        $statement->execute();
        
    }
    
    // new place (if any) is inserted:
    if (isset($_SESSION['tempLocusData'])) {
        
        $queryString = <<<QUERY
INSERT
INTO `loca`
VALUES (:locusID,
    :achtung,
    :name,
    :rating,
    :address,
    :country,
    :kind,
    :descr,
    :coordExact,
    :coordGeneric,
    :web,
    :user)
QUERY;

        $statement = $pdo->prepare($queryString);
        
        $statement->bindParam(":locusID", $locusID, PDO::PARAM_INT);
        $statement->bindParam(":achtung", $locusAchtung, PDO::PARAM_STR);
        $statement->bindParam(":name", $locusName, PDO::PARAM_STR);
        $statement->bindParam(":rating", $locusRating, PDO::PARAM_INT);
        $statement->bindParam(":address", $address, PDO::PARAM_STR);
        $statement->bindParam(":country", $countryID, PDO::PARAM_INT); //!!!
        $statement->bindParam(":kind", $kindID, PDO::PARAM_INT); // !!!
        $statement->bindParam(":descr", $locusDescr, PDO::PARAM_STR);
        $statement->bindParam(":coordExact", $coordExact, PDO::PARAM_STR);
        $statement->bindParam(":coordGeneric", $coordGeneric, PDO::PARAM_STR);
        $statement->bindParam(":web", $locusWeb, PDO::PARAM_STR);
        $statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);
        
        $statement->execute();
        
    }
    
    // experience is updated (when in edition) or inserted:
    
    if ($praxisEdit) { // update already existing experience
    
        // edition query:
        $queryString = <<<QUERY
UPDATE `practica`
SET `achtung` = :achtung,
    `name` = :name,
    `rating`= :rating,
    `favorite` = :favorite,
    `locus` = :locus,
    `date` = :date,
    `ordinal` = :ordinal,
    `descr` = :descr,
    `tq` = :tq,
    `tl` = :tl
WHERE `praxisID` = :praxisID
QUERY;
    
    } else { // insert new experience   

        // insertion query:
        $queryString = <<<QUERY
INSERT
INTO `practica`
VALUES (:praxisID,
    :achtung,
    :name,
    :rating,
    :favorite,
    :locus,
    :date,
    :ordinal,
    :descr,
    :tq,
    :tl,
    :user)
QUERY;

    }

    $statement = $pdo->prepare($queryString);
    
    if (!$praxisEdit)
        $statement->bindParam(":praxisID", $praxisID, PDO::PARAM_INT);
    $statement->bindParam(":achtung", $praxisAchtung, PDO::PARAM_STR);
    $statement->bindParam(":name", $praxisName, PDO::PARAM_STR);
    $statement->bindParam(":rating", $praxisRating, PDO::PARAM_INT);
    $statement->bindParam(":favorite", $favorite, PDO::PARAM_INT);
    $statement->bindParam(":locus", $locus, PDO::PARAM_INT);
    $statement->bindParam(":date", $date, PDO::PARAM_STR);
    $statement->bindParam(":ordinal", $ordinal, PDO::PARAM_STR);
    $statement->bindParam(":descr", $praxisDescr, PDO::PARAM_STR);
    $statement->bindParam(":tq", $tq, PDO::PARAM_INT);
    $statement->bindParam(":tl", $tl, PDO::PARAM_INT);
    if (!$praxisEdit)
        $statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);
    
    $statement->execute();
    
    // new lover(s) (if any) are inserted:
    
    //foreach... {{
    if (isset($_SESSION['tempAmorData'][0])) {
    
        $queryString = <<<QUERY
INSERT
INTO `amores`
VALUES (:amorID,
    :achtung,
    :alias,
    :rating,
    :genre,
    :descr1,
    :descr2,
    :descr3,
    :descr4,
    :web,
    :name,
    :photo,
    :phone,
    :email,
    :other,
    :user)
QUERY;

        $statement = $pdo->prepare($queryString);

        $statement->bindParam(":amorID", $amorID[0], PDO::PARAM_INT);
        $statement->bindParam(":achtung", $amorAchtung[0], PDO::PARAM_STR);
        $statement->bindParam(":alias", $alias[0], PDO::PARAM_STR);
        $statement->bindParam(":rating", $amorRating[0], PDO::PARAM_INT);
        $statement->bindParam(":genre", $genre[0], PDO::PARAM_INT);
        $statement->bindParam(":descr1", $descr1[0], PDO::PARAM_STR);
        $statement->bindParam(":descr2", $descr2[0], PDO::PARAM_STR);
        $statement->bindParam(":descr3", $descr3[0], PDO::PARAM_STR);
        $statement->bindParam(":descr4", $descr4[0], PDO::PARAM_STR);
        $statement->bindParam(":web", $amorWeb[0], PDO::PARAM_STR);
        $statement->bindParam(":name", $amorName[0], PDO::PARAM_STR);
        $statement->bindParam(":photo", $photo[0], PDO::PARAM_INT);
        $statement->bindParam(":phone", $phone[0], PDO::PARAM_STR);
        $statement->bindParam(":email", $email[0], PDO::PARAM_STR);
        $statement->bindParam(":other", $other[0], PDO::PARAM_STR);
        $statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);

        $statement->execute();
    
    }
    
    // {{ foreach...
    
    // assignations:
    
/*
 * one row is inserted for every lover who participates in the experience.
 */
    //foreach...{{
    if (!$praxisEdit) {
        
        $queryString = <<<QUERY
INSERT
INTO `assignations`
VALUES (:praxis,
    :amor)
QUERY;
        
        $statement = $pdo->prepare($queryString);
        
        $statement->bindParam(":praxis", $praxisID, PDO::PARAM_INT);
        $statement->bindParam(":amor", $amorID[0], PDO::PARAM_INT); // should be array
        
        $statement->execute();
        
    }
    //{{foreach...
    
    // commit transaction:
    $pdo->commit();
        
} catch (Exception $e) {
    
    $pdo->rollback();

}

// redirect the user to the page 'praxis.php' or 'practica.php':
if ($praxisEdit) {

    header ("Location: praxis.php?praxisID=".$praxisID);

} else {

    header ("Location: practica.php");
}

?>