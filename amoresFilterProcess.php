<?php
/**
 * script amoresFilterProcess.php
 * XXX
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-04-06
*/

require_once 'core.inc';

if (isset($_POST['sent']) && intval($_POST['sent']) === 1) { // form already sent

    $designation = "Filtered query";
    $description = "Filtered query";
    $queryString = "SELECT * FROM `myX`.`amores` WHERE (";

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
        
        $queryString .= "`".$_POST['ruleFields'][$i]."`";        

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
    $queryString .= ") AND `amores`.`user` = ".$_SESSION['userID'];
    
/*
 * a new object PracticaQuery is instantiated having as queryString
 * the SQL statement created in this page.
 */
    
    $amoresQuery = new AmoresQuery($designation, $description, $queryString);

    // saves current list to $_SESSION:
    $_SESSION['amoresQuery'] = $amoresQuery;

    // redirect to 'amores.php':
    header("Location: amores.php");
    
}

?>