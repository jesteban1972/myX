<?php
/**
 * script 'practicaFilterProcess.php'.
 * 
 * this script process the data about filtering which comes from the file
 * 'practicaQuery.php'.
 * 
 * it performs a query against the table 'practica' of the DB, initializes
 * an instance of class 'PracticaQuery'. this object is going to be used by
 * script 'practica.php', to which it will be redirected at the end of this script.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-30
*/

require_once 'core.inc';

if (isset($_POST['sent']) && intval($_POST['sent']) === 1) { // form already sent
    
    $designation = "Filtered query";
    $description = "Filtered query";
    $queryString = "SELECT * FROM `myX`.`practica`".
        " INNER JOIN `myX`.`loca`".
        " ON `myX`.`practica`.`locus` = `myX`.`loca`.`locusID`".
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
 * as some fields in the tables 'practica' and 'loca' have same names
 * (achtung, name, rating, description, user),
 * the rule field is checked and, if needed, associated with the
 * corresponding table.
 */
        
        switch ($_POST['ruleFields'][$i]) {
            
            case 'locus':
                
                $queryString .= "`loca`.`name`";
                break;
                
            case 'achtung': // unused    
            case 'rating':
            case 'name':
            case 'rating':
            case 'descr':
                
                $queryString .= "`practica`.`".$_POST['ruleFields'][$i]."`";
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
    $queryString .= ") AND `practica`.`user` = ".$_SESSION['userID'];
    
/*
 * a new object PracticaQuery is instantiated having as queryString
 * the SQL statement created in this page.
 */
    
    $practicaQuery =
        new PracticaQuery($designation, $description, $queryString);

    // saves current list to $_SESSION:
    $_SESSION['practicaQuery'] = $practicaQuery;

    // redirect to 'practica.php':
    header("Location: practica.php");
    
}

?>