<?php

/* 
 * practicaFetchXML.php
 * script to fetch the experiences from the DB into a XML file
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-03-10
 */

require_once 'session.inc';
require_once 'DB.inc';
require_once 'praxis.inc';

function parseToXML($htmlStr) {
    
    $xmlStr = str_replace('<', '&lt;', $xmlStr); 
    $xmlStr = str_replace('>', '&gt;', $xmlStr); 
    $xmlStr = str_replace('"', '&quot;', $xmlStr); 
    $xmlStr = str_replace('\'', '&#39;' ,$xmlStr); 
    $xmlStr = str_replace('&', '&amp;', $xmlStr);
    
    return $xmlStr; 
}

// xml version="1.0" encoding="UTF-8" (XML document)
// and root element are created:
$dom = new DOMDocument("1.0", "UTF-8");

//$dom->encoding = "UTF-8";
//$dom->substituteEntities = false;
//$dom->libxml_disable_entity_loader(true);
$practicaNode = $dom->createElement("practica");
//$documentNode = $dom->appendChild($practicaNode);

//header("Content-type: text/xml"); // ; charset=utf-8

// get a DB connection to work with:
$pdo = DB::getDBHandle();

// Select all the rows in the table 'practica'
$queryString = <<<QUERY
SELECT *
FROM `practica`
WHERE `user`=:userID
ORDER BY `date`, `ordinal`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();

// iterate through the rows, adding XML nodes for each one
foreach ($statement as $row) {

    // ADD TO XML DOCUMENT NODE
    $praxisNode = $dom->createElement("praxis");
    $praxisNode->setAttribute("praxisID", $row['praxisID']);
    $practicaNode->appendChild($praxisNode);

    // achtung:
    if ($row['achtung'] !== "") {

        $achtungNode = $dom->createElement("achtung");        
        /*
         * XML Parsing Error: undefined entity &sigmaf;
         */
        $modifiedString = 
                
                // error: converts text to entities (&sigmaf; etc)
        $row['achtung'];
        //html_entity_decode($row['achtung']);
        //html_entity_decode($row['achtung'], ENT_XML1, "UTF-8");
        //html_entity_decode($row['achtung'], ENT_COMPAT | ENT_HTML401, "UTF-8");
        //htmlentities($row['achtung'], ENT_QUOTES | ENT_XML1, 'UTF-8');
        //htmlspecialchars($row['achtung']);
        //htmlspecialchars($row['achtung'], ENT_QUOTES, 'UTF-8', false);
        //htmlspecialchars($row['achtung'], ENT_XML1, 'UTF-8');
        //htmlspecialchars($row['achtung'], ENT_HTML5, 'UTF-8');
        //htmlspecialchars(html_entity_decode($row['achtung'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
        //mb_convert_encoding($row['achtung'], "UTF-8");
        //mb_convert_encoding($row['achtung'], "UTF-8", mb_detect_encoding($row['achtung'], "UTF-8", true));
          // error, muestra entidades erróneas
        //utf8_encode($row['achtung']);
        //utf8_encode(html_entity_decode($row['achtung']));
        //"<![CDATA[".$row['achtung']."]]>";
        
            // creates and displays entities (v.gr. &#7938;&sigmaf; &chi;&omega;&rho;&iota;&sigma;&theta;&#8182;&sigma;&iota;&nu;!)
        //mb_convert_encoding($row['achtung'], 'HTML-ENTITIES', "UTF-8");
        //htmlentities($row['achtung']);
        
            // outputs nothing
        //iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['achtung']);
        
        $achtungText = $dom->createTextNode($modifiedString);
        
        $achtungNode->appendChild($achtungText);
        $praxisNode->appendChild($achtungNode);        

    }
    
    // locus:
    $locusNode = $dom->createElement("locus");
    $locusNode->setAttribute("locusID", $row['locus']);
    $praxisNode->appendChild($locusNode);

    // time:
    $timeNode = $dom->createElement("time");
    $timeNode->setAttribute("date", $row['date']);
    if ($row['ordinal'] !== "")
        $timeNode->setAttribute("ordinal", $row['ordinal']);
    $praxisNode->appendChild($timeNode);
    
    // name:
    $nameNode = $dom->createElement("name");
    $nameText = $dom->createTextNode($row['name']);
    $nameNode->appendChild($nameText);
    $praxisNode->appendChild($nameNode);
    
    // rating:
    $ratingNode = $dom->createElement("rating");
    $ratingNode->setAttribute("rating", $row['rating']);
    $praxisNode->appendChild($ratingNode);
    
      
    // description:
    if ($row['description'] !== "") {
        
        $descriptionNode = $dom->createElement("description");
        $descriptionText = $dom->createTextNode($row['description']);
        $descriptionNode->appendChild($descriptionText);
        $praxisNode->appendChild($descriptionNode);
        
    }
    
    // tq:
    if (!empty($row['tq']))
        $praxisNode->setAttribute("tq", $row['tq']);
    
    // tl:
    if (!empty($row['tl']))
        $praxisNode->setAttribute("tl", $row['tl']);
    
    // favorite:
    if (!empty($row['favorite']))
        $praxisNode->setAttribute("favorite", "true");

} // foreach  

$dom->appendChild($practicaNode);

$dom->formatOutput = true;
echo $dom->saveHTML();

// the XML file is saved:
$dom->save("practica.xml"); // Achtung! no lo crea por los permisos!

?>