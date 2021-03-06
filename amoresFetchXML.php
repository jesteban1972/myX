<?php
/** 
 * script 'amoresFetchXML.php'.
 * 
 * script to fetch the lovers from the DB into a XML file.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-03-01
 */

require_once 'session.inc';
require_once 'DB.inc';
require_once 'amor.inc';

function parseToXML($htmlStr) {
    
    $xmlStr = str_replace('<', '&lt;', $xmlStr); 
    $xmlStr = str_replace('>', '&gt;', $xmlStr); 
    $xmlStr = str_replace('"', '&quot;', $xmlStr); 
    $xmlStr = str_replace('\'', '&#39;' ,$xmlStr); 
    $xmlStr = str_replace('&', '&amp;', $xmlStr);
    
    return $xmlStr; 
}

// XML string and XML document and parent node are created:
$dom = new DOMDocument("1.0", "UTF-8");
$node = $dom->createElement("amores");
$documentNode = $dom->appendChild($node);

// get a DB connection to work with:
$pdo = DB::getDBHandle();

// Select all the rows in the markers table
$queryString = <<<QUERY
SELECT *
FROM `amores`
WHERE `user`=:userID
ORDER BY `alias`
QUERY;


$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();

// iterate through the rows, adding XML nodes for each one:
foreach ($statement as $row) {

    // ADD TO XML DOCUMENT NODE
    $amor = $dom->createElement("amor");
    $newnode = $documentNode->appendChild($amor);
    $newnode->setAttribute("amorID", $row['amorID']);

    // actung:
    if ($row['achtung'] !== "") {

        $achtung = $amor->appendChild($dom->createElement("achtung"));
        $achtung->appendChild($dom->createTextNode($row['achtung']));

    }
    
    // alias:
    $alias = $amor->appendChild($dom->createElement("alias"));
    $alias->appendChild($dom->createTextNode($row['alias']));
    
    // rating:
    if ($row['rating'] !== "") {
        
        $rating = $amor->appendChild($dom->createElement("rating"));
        $rating->setAttribute("rating", $row['rating']);
        
    }
    
    // genre:
    if ($row['genre'] !== "") {
        
        $genre = $amor->appendChild($dom->createElement("genre"));
        $genre->setAttribute("genre", $row['genre']);
        
    }
    
    // descr1:
    if ($row['descr1'] !== "") {
        
        $descr1 = $amor->appendChild($dom->createElement("descr1"));
        $descr1->appendChild($dom->createTextNode($row['descr1']));
        
    }
    
    // descr1:
    if ($row['descr2'] !== "") {
        
        $descr2 = $amor->appendChild($dom->createElement("descr2"));
        $descr2->appendChild($dom->createTextNode($row['descr2']));
        
    }
    
    // descr1:
    if ($row['descr3'] !== "") {
        
        $descr3 = $amor->appendChild($dom->createElement("descr3"));
        $descr3->appendChild($dom->createTextNode($row['descr3']));
        
    }
    
    // descr4:
    if ($row['descr4'] !== "") {
        
        $descr4 = $amor->appendChild($dom->createElement("descr4"));
        $descr4->appendChild($dom->createTextNode($row['descr4']));
        
    }

    // web:
    if ($row['web'] !== "") {
        
        $www = $amor->appendChild($dom->createElement("www"));
        $www->appendChild($dom->createTextNode($row['www']));
        
    }
    
    // name:
    if ($row['name'] !== "") {
        
        $name = $amor->appendChild($dom->createElement("name"));
        $name->appendChild($dom->createTextNode($row['name']));
        
    }
            
    // photo:
    if ($row['photo'] !== "") {
        
        $photo = $amor->appendChild($dom->createElement("photo"));
        $photo->appendChild($dom->createTextNode($row['photo']));
        
    }
    
    // phone:
    if ($row['phone'] !== "") {
        
        $telephone = $amor->appendChild($dom->createElement("phone"));
        $telephone->appendChild($dom->createTextNode($row['phone']));
        
    }
    
    // email:
    if ($row['email'] !== "") {
        
        $email = $amor->appendChild($dom->createElement("email"));
        $email->appendChild($dom->createTextNode($row['email']));
        
    }
    
    // other:
    if ($row['other'] !== "") {
        
        $other = $amor->appendChild($dom->createElement("other"));
        $other->appendChild($dom->createTextNode($row['other']));
        
    }

} // foreach  

$dom->formatOutput = true;
echo $dom->saveHTML();

// the XML file is saved:
$dom->save("amores.xml");

?>