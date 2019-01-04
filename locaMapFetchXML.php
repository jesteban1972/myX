<?php
/**
 * script 'locaMapFetchXML.php'.
 * 
 * script to fetch the places from the DB into a XML file.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-22
 */

require_once 'session.inc';
require_once 'DB.inc';
require_once 'locus.inc';

function parseToXML($htmlStr) {
    
    $xmlStr = str_replace('<', '&lt;', $xmlStr); 
    $xmlStr = str_replace('>', '&gt;', $xmlStr); 
    $xmlStr = str_replace('"', '&quot;', $xmlStr); 
    $xmlStr = str_replace('\'', '&#39;' ,$xmlStr); 
    $xmlStr = str_replace('&', '&amp;', $xmlStr);
    
    return $xmlStr; 
}

// initialize XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("loca");
$documentNode = $dom->appendChild($node);

header("Content-type: text/xml");

// get a DB connection to work with:
$pdo = DB::getDBHandle();

// Select all the rows in the markers table
$queryString = <<<QRY
SELECT *
FROM `loca`
WHERE `user` = :userID
ORDER BY `loca`.`name`
QRY;

/*
 * JOIN `countries` ON `loca`.`country` = `countries`.`countryID`
    JOIN `kinds` ON `loca`.`kind` = `kinds`.`kindID`
 */

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();

// iterate through the rows, adding XML nodes for each one
foreach ($statement as $row) {

    // ADD TO XML DOCUMENT NODE
    $node = $dom->createElement('locus');
    $newnode = $documentNode->appendChild($node);
    $newnode->setAttribute('locusID', $row['locusID']);

    // experiences amount on place:
    $locus = new Locus(intval($row['locusID']));
    $newnode->setAttribute("practicaAmount", $locus->getPracticaAmount());

    if ($row['achtung'] !== "") {

        $newnode->setAttribute("achtung", $row['achtung']);

    }

    $newnode->setAttribute("name", $row['name']);
    //$newnode->setAttribute('country', $tuple['name']);
    //$newnode->setAttribute('kind', $tuple['denomination']);

    if ($row["descr"] !== "") {

        $newnode->setAttribute("descr", $row['descr']);

    }
    
    if ($row["address"] !== "") {

        $newnode->setAttribute("address", $row['address']);

    }

    if ($row['coordExact'] !== "") {

        $newnode->setAttribute("coordExact", $row['coordExact']);
        
    } else if ($row['coordGeneric'] !== "") {

        $newnode->setAttribute("coordGeneric", $row['coordGeneric']);
        
    }

    if ($row['web'] !== "") {

        $newnode->setAttribute("web", $row['web']);

    }

} // foreach  

echo $dom->saveXML();

?>