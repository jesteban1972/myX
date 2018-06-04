<?php
/**
 * script 'praxisEditProcess.php'.
 * 
 * script to process the edition of an already existing experience
 * or the insertion of a new one.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-02
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

if (isset($_POST['praxisID'])) {
// script called form praxis.php': edition of an already existing experience.

    $praxisEdit = true;
    $praxisID = intval($_POST['praxisID']);

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
 * insertion process of a new experience:
 * 
 * within this script, unlike 'amorEditProcess.php' or 'locusEditProcess.php',
 * part of the data are taken from $_SESSION, from the variables
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

/*
 * lover(s) data are verified and retrieved. the process is performed for each
 * one of the participating lovers.
 * 
 * two sets of lovers should be distinguish:
 * i) already existing lovers: processing their data is trivial, because they
 * are already in the DB. only the identifier is needed, and its value is taken
 * from the $_POST array.
 * ii) new lovers: this lovers should be inserted in the DB. to process their
 * data the array $_SESSION['tempAmorData'] is used.
 * 
 * it is important to consider the treatement order:
 * already existing lovers will be processed first, after them the new ones.
 */

/* 
 * $amoresAmount is the amount of lovers participating in the experience.
 * its value is the sum of:
 * i) the already existing lovers, sizeof($_POST['amorID']), and
 * ii) the amount of new lovers, sizeof($_SESSION['tempAmorData'])
 */

$amores = array();
$amoresAmount = sizeof($_POST['amorID']) + sizeof($_SESSION['tempAmorData']);
$amorExistingLastIndex = sizeof($_POST['amorID']) - 1; // zero based

// existing lovers are processed:
for ($i = 0; $i < ($amorExistingLastIndex + 1); $i++) {
    
    $amores[$i] = array("amorID" => $_POST['amorID'][$i]);
    
    //$amorID[$i] = $_POST['amorID'][$i];
    
}

// new lovers are processed:
$amorNewIndex = 0;
for ($i = ($amorExistingLastIndex + 1); $i < $amoresAmount; $i++) {

//for ($i = 0; $i < $amoresAmount; $i++) {
    
    //if (isset($_SESSION['tempAmorData'][$i])) {
        // new lover, data read from $_SESSION['tempAmorData']
    
        // only field 'alias' is compulsory:
        if (trim($_SESSION['tempAmorData'][$amorNewIndex]['alias']) === "")
            throw new Exception();

        // amorID is calculated:
        $queryString = <<<QUERY
SELECT MAX(`amorID`)
FROM `amores`      
QUERY;
        $maxAmorID = $pdo->query($queryString)->fetchColumn();
        $amores[$i] = array(
            "amorID" => ($maxAmorID === null) ? 1 : intval($maxAmorID) + 1,
            "amorAchtung" => $_SESSION['tempAmorData'][$amorNewIndex]['achtung'],
            "alias" => $_SESSION['tempAmorData'][$amorNewIndex]['alias'],
            "rating" => $_SESSION['tempAmorData'][$amorNewIndex]['rating'],
            "genre" => $_SESSION['tempAmorData'][$amorNewIndex]['genre'],
            "descr1" => $_SESSION['tempAmorData'][$amorNewIndex]['descr1'],
            "descr2" => $_SESSION['tempAmorData'][$amorNewIndex]['descr2'],
            "descr3" => $_SESSION['tempAmorData'][$amorNewIndex]['descr3'],
            "descr4" => $_SESSION['tempAmorData'][$amorNewIndex]['descr4'],
            "web" => $_SESSION['tempAmorData'][$amorNewIndex]['web'],
            "name" => $_SESSION['tempAmorData'][$amorNewIndex]['name'],
            "photo" => $_SESSION['tempAmorData'][$amorNewIndex]['photo'],
            "phone" => $_SESSION['tempAmorData'][$amorNewIndex]['phone'],
            "email" => $_SESSION['tempAmorData'][$amorNewIndex]['email'],
            "other" => $_SESSION['tempAmorData'][$amorNewIndex]['other']
        );
        
        $amorNewIndex++;
        
//        $amorID[$amorNewIndex] = ($maxAmorID === null) ? 1 : intval($maxAmorID) + 1;
//
//        // data are retrieved:
//        $amorAchtung[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['achtung'];
//        $alias[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['alias'];
//        $amorRating[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['rating'];
//        $genre[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['genre'];
//        $descr1[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['descr1'];
//        $descr2[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['descr2'];
//        $descr3[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['descr3'];
//        $descr4[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['descr4'];
//        $amorWeb[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['web'];
//        $amorName[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['name'];
//        $photo[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['photo'];
//        $phone[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['phone'];
//        $email[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['email'];
//        $other[$amorNewIndex] = $_SESSION['tempAmorData'][$amorNewIndex]['other'];

//    } else { // already existing lover(s), data read from $_POST
//
//        $amorID[$i] = /*($_SESSION['tempPraxisData']['amor'] !== -1) ?
//            $_SESSION['tempPraxisData']['amor'] :*/
//            $_POST['amorID'][$i];
        
        //$amorExistingLastIndex++;

    //}
    
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
    
    for ($i = ($amorExistingLastIndex + 1); $i < $amoresAmount; $i++) {
        
        //if (isset($_SESSION['tempAmorData'][$i])) {

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

        $statement->bindParam(":amorID", $amores[$i]['amorID'], PDO::PARAM_INT);
        $statement->
            bindParam(":achtung", $amores[$i]['achtung'], PDO::PARAM_STR);
        $statement->bindParam(":alias", $amores[$i]['alias'], PDO::PARAM_STR);
        $statement->bindParam(":rating", $amores[$i]['rating'], PDO::PARAM_INT);
        $statement->bindParam(":genre", $amores[$i]['genre'], PDO::PARAM_INT);
        $statement->bindParam(":descr1", $amores[$i]['descr1'], PDO::PARAM_STR);
        $statement->bindParam(":descr2", $amores[$i]['descr2'], PDO::PARAM_STR);
        $statement->bindParam(":descr3", $amores[$i]['descr3'], PDO::PARAM_STR);
        $statement->bindParam(":descr4", $amores[$i]['descr4'], PDO::PARAM_STR);
        $statement->bindParam(":web", $amores[$i]['web'], PDO::PARAM_STR);
        $statement->bindParam(":name", $amores[$i]['name'], PDO::PARAM_STR);
        $statement->bindParam(":photo", $amores[$i]['photo'], PDO::PARAM_INT);
        $statement->bindParam(":phone", $amores[$i]['phone'], PDO::PARAM_STR);
        $statement->bindParam(":email", $amores[$i]['email'], PDO::PARAM_STR);
        $statement->bindParam(":other", $amores[$i]['other'], PDO::PARAM_STR);
        $statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);

        $statement->execute();

        //}
    
    }
    
    // assignations:
    
/*
 * one row is inserted for every lover who participates in the experience.
 */
    for($i = 0; $i < $amoresAmount; $i++) {
        
        if (!$praxisEdit) {

            $queryString = <<<QUERY
INSERT
INTO `assignations`
VALUES (:praxis,
    :amor)
QUERY;
        
            $statement = $pdo->prepare($queryString);

            $statement->bindParam(":praxis", $praxisID, PDO::PARAM_INT);
            $statement->
                bindParam(":amor", $amores[$i]['amorID'], PDO::PARAM_INT);

            $statement->execute();

        }
    }
    
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