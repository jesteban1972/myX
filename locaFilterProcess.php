<?php
/**
 * script locaQueryProcess.php
 * XXX
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-04-06
*/

require_once 'core.inc';

if (isset($_POST['sent']) && intval($_POST['sent']) === 1) { // form already sent
    
    $designation = "Filtered query";
    $description = "Filtered query";
    $queryString = "SELECT * FROM `myX`.`loca`".
        " INNER JOIN `myX`.`countries`".
        " ON `myX`.`loca`.`country` = `myX`.`countries`.`countryID`".
        " INNER JOIN `myX`.`kinds`".
        " ON `myX`.`loca`.`kind` = `myX`.`kinds`.`kindID`".
        " WHERE (";

    for ($i = 0; $i < sizeof($_POST['ruleFields']); $i++) {

        if ($i > 0) {
            
            switch ($_POST['rulesBinding']) {
                
                case "all":
                    
                    $queryString .= " AND ";
                    break;
                
                case "any":
                    
                    $queryString .= " OR ";
                    break;
                
            }
        }
        
/*
 * as some fields in the tables 'loca', 'countries' and 'kinds' have same names
 * (achtung, name, rating, description, user),
 * the rule field is checked and, if needed, associated with the
 * corresponding table.
 */
        
        switch ($_POST['ruleFields'][$i]) {
            
            case 'country':
                
                $queryString .= "`countries`.`name`";
                break;
                
            case 'achtung': // unused    
            case 'rating':
            case 'name':
            case 'rating':
            case 'description':
                
                $queryString .= "`loca`.`".$_POST['ruleFields'][$i]."`";
                break;
            
            case 'kind':
                
                $queryString .= "`kinds`.`name`";
                break;
            
            default:
                
                $queryString .= "`".$_POST['ruleFields'][$i]."`";
                
        }

        switch ($_POST['ruleCriteria'][$i]) {
/*
 * all possibilities for all data types, ordered alphabetically.
 */

            case "beginsWith":
                
                $queryString .= " LIKE '".$_POST['ruleStrings'][$i]."%'";
                break;
            
            case "contains":
                
                $queryString .= " LIKE '%".$_POST['ruleStrings'][$i]."%'";
                break;
            
            case "doesNotContain":
                
                $queryString .= " NOT LIKE '%".$_POST['ruleStrings'][$i]."%'";
                break;
            
            case "endsWith":
                
                $query .= " LIKE '%".$_POST['ruleStrings'][$i]."'";
                break;
            
            case 'isGreaterThan':
                
                $queryString .= ' > '.$_POST['ruleStrings'][$i];
                break;

            case 'isLessThan':
                
                $queryString .= ' < '.$_POST['ruleStrings'][$i];
                break;

            case "isNotNumber":
                
                $queryString .= " != ".$_POST['ruleStrings'][$i];
                break;
            
            case "isNotString":
                
                $queryString .= " NOT LIKE '".$_POST['ruleStrings'][$i]."'";
                break;
            
            case "isNumber":
                
                $queryString .= " = ".$_POST['ruleStrings'][$i];
                break;
            
            case "isString":
                
                $queryString .= " LIKE '".$_POST['ruleStrings'][$i]."'";
                break;
            
        }
   
    }

    // include only the data of the current user:
    $queryString .= ") AND `loca`.`user` = ".$_SESSION['userID'];
    
/*
 * a new object LocaQuery is instantiated having as queryString
 * the SQL statement created in this page.
 */
    
    $locaQuery = new LocaQuery($designation, $description, $queryString);

    // saves current list to $_SESSION:
    $_SESSION['locaQuery'] = $locaQuery;

    // redirect to 'loca.php':
    header("Location: loca.php");
    
}

?>