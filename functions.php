<?php
    // This function calcultes the position and the action that has to be done in the chair grid
    function calculatorChair($column_val, $row_val){
        $formula = ($column_val*5-(5-$row_val))-1;
        return $formula; 
    }

    function sessionArray($possitionGrid, $parameter){
        
            
            if($possitionGrid===false and $parameter===true){
                $_SESSION['arraySession'] = array_fill(0, 25, "L");
                $finalArray = array($_SESSION['arraySession'], "The grid has been restarted");
            // If positionGrid and $paramenter are different than false:
            }elseif(!($possitionGrid===false and $parameter===false)){
                // It a previous session variable was created, use it to create a copy from that
                /**
                 * To update a session array is important to use the the isset metthod,
                 * to check if a session variable was created previously
                 */
                if (isset($_SESSION['arraySession'])) {
                    // Create a copy from current state of the session array
                    $copyArray = $_SESSION['arraySession'];
                } else {
                    /**
                     * Otherwise, create a new array that starts with 0 and finishes with 25, 
                     * each value will be and (L) letter,
                     * you can change it to any letter or value
                     * */
                    $copyArray = array_fill(0, 25, "L");
                }
                /**
                 * TASK: verify whether the parameter in positionGrind value is:
                 * Rule 1: If the value in any grid position is V, we cannot change it unless we restart the entire grid when the movie finishes.
                 * Rule 2: If the value in any grid position is R, this can be changed to L or V. ***
                 * Rule 3: If the value in any grid position is L, thi can be changed to R or V.
                 */
                                // General
                // get a session array value according to the posittion grid
                // save that value inside a variable ($arrayParameter) and then compare it with $parameter variable 
                
                //Rule 2: 
                // condition: If $arrayParamenter === "R" and $paramenter !== "R" ->
                // Apply complement or else;

                //Rule 3: 
                // condition: If $arrayParamenter === "L" and $paramenter !== "L" ->
                // Apply complement or else;

                //Rule 1:
                // condition: If $arrayParamenter === "V" ->
                // Apply else;
    
                $arrayParamenter = $copyArray[$possitionGrid];
                
                if($arrayParamenter==="R" and $parameter !=="R"){

                    // Updates the current copied array and creates a new copied array
                    $copyArray[$possitionGrid] = $parameter;
                    // The session variable is updated according to the new copied array
                    $_SESSION['arraySession'] = $copyArray;
                    
                    // Switch statement determines which is the message sent
                    switch($parameter){
                        case "V" : $message = "Succcess, chair Bought";
                            break;
                        case "L" : $message = "Success, chair Released";
                            break;
                    }
                    
                    // A copy form the new session array is created 
                    $finalArray = array($_SESSION['arraySession'], $message);
                }elseif($arrayParamenter==="L" and $parameter !=="L"){
                    
                    // Updates the current copied array and creates a new copied array
                    $copyArray[$possitionGrid] = $parameter;
                    // The session variable is updated according to the new copied array
                    $_SESSION['arraySession'] = $copyArray;
                    
                    // Switch statement determines which is the message sent
                    switch($parameter){
                        case "V" : $message = "Succcess, chair Bought";
                            break;
                        case "R" : $message = "Success, chair Reserved";
                            break;
                    }
                    
                    // A copy form the new session array is created 
                    $finalArray = array($_SESSION['arraySession'], $message);
                }else{

                    // Switch statement determines which is the message sent
                    switch($arrayParamenter){
                        case "V" : $message = "Chair is already sold";
                            break;
                        case "R" : $message = "Chair is already Reserved";
                            break;
                        case "L" : $message = "Chair is already Released";
                            break;    
                    }

                    // A copy from the (current-new) session variable is created                    
                    $finalArray = array($_SESSION['arraySession'], $message);
                    }
            }else{
                /**
                 * It verifies if a previous session variable was created, 
                 * if that is true, we can use that one to send it as the new session array
                 */
                if (isset($_SESSION['arraySession'])) {
                    // A copy from the (current-new) session variable is created                    
                    $finalArray = array($_SESSION['arraySession'], "Success4");
                } else {
                    // Otherwise, create a new array that starts with 0 and finishes with 25 L values
                    $finalArray = array(array_fill(0, 25, "L"), "success5");
                }
            }
        // According to the result of the previous if statement, a copy of the current or new session array will be returned    
        return $finalArray;
        
    }

    //This function graphicates the array inside the grid
    function graphicator($chairStatus, $lineBreak){ 
        foreach($chairStatus as $chair){
            echo "<div> $chair</div>";
            switch($lineBreak){
                case 4: 
                    echo 
                        "</div><div class='chairs_grid_row'>";
                    break;
                default:
                    break;
            $lineBreak++;        
            }
        }
    }
