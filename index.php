<?php  
    session_start();  
    include('functions.php');
    $lineBreak=0;
    $columns=5;
    $rows=5;
    $column_val=0;
    $row_val=0;
    $message="Hello";

    if (isset($_SESSION['arraySession'])) {
        // Create a copy from current state of the session array
        $chairStatusFinal[0] = $_SESSION['arraySession'];
    }
    /**Capturing values sent by forms (column, row, checkbox) using Post method*/
    
    // (Action variable) (Checkbox)
    /** Post method sends all content inside the form (Post= package that contains html elements with values), 
     * to filter that content we use the name property of each html element,
     * this will bring us the value that is conteined in the property value (name= "r", value="R") -> return "R" as string.
     */
    
        // If in the post method (package) exists an html element with the property name "r":
    if(isset($_POST['r'])){
        // If the html element with the property name "r" contains a value that is greater than 0:
        if(strlen($_POST['r'])>0){
            // Save the content (value property) of that html element in a variable that is called $action.
            $action = $_POST['r']; // = R
        }
    }elseif(isset($_POST['b'])){
        if(strlen($_POST['b'])>0){
            $action = $_POST['b']; // = B
        }
    }elseif(isset($_POST['l'])){
        if(strlen($_POST['l'])>0){
            $action = $_POST['l']; // = L
        }
    }else{
        $action = false; // = false
    }
    

    //MODIFY GRID
    // (Column and Row variables) )(Inputs)
    if(isset($_POST['column'])){
        $column_val = $_POST['column'];
    }

    if(isset($_POST['row'])){
        $row_val = $_POST['row'];
    }

    //If each input contains a vale that its length is greater than 0 and if the action variable is not false:
    if(strlen($column_val)>0 and strlen($row_val)>0 and $action !== false) {
        // If the action submited was sent the the button called "c":
        if(isset($_POST['c'])){
            // This function calculates the chair position which is gonna be modified
            $positionGrid = calculatorChair($column_val, $row_val);
            $parameter = $action;
            //Array modified which is sent to graphicator
            $chairStatusFinal = sessionArray($positionGrid, $parameter);
            $message=true;
            $actionMessage = $chairStatusFinal[1];

            // Convert from PHP array to JSON string.
            $javaScriptArray = json_encode($chairStatusFinal[0]);
            // Convert from JSON string to PHP array
            //$myArray = json_decode($javaScriptArray)
        }
    }else{
        if(isset($_POST['c'])){
            // This variable contains the array index and the action that has to be done
            $positionGrid = false;
            $parameter = false;
            //Array modified which is sent to graphicator
            $chairStatusFinal = sessionArray($positionGrid, $parameter);
            $message=false;
            $actionMessage = "Please forms must be filled out";
            $javaScriptArray = json_encode($chairStatusFinal[0]);
        }
    }

    //RESTART GRID
    if(isset($_POST['restart'])){
        // This variable contains the array index and the action that has to be done
        $positionGrid = false;
        $parameter = true;
        $message=true;
        //Array modified which is sent to graphicator
        $chairStatusFinal = sessionArray($positionGrid, $parameter);
        $actionMessage = $chairStatusFinal[1];
        $javaScriptArray = json_encode($chairStatusFinal[0]);
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_teatro.css">
    <title>Document</title>
    <script src="java_script_functions.js"></script>
</head>

<body class="background">
    
    <div class="header">
        <div>
            THEATER BOOKING APP
        </div>
    </div>

    <div class="grid_container">

        <div class="orientation_text_bold">
            <div class="ch_grid_horiz">
                <?php for($i=0; $i<$columns; $i++){ ?>
                    <div class="chairs_index_bold"><?php echo $i+1?></div>
                <?php } ?>
            </div>
        </div>

        <div class="internal_grid">
            
            <div class="vertical_text orientation_text_bold">
                <div class="chairs_grid_row">
                <?php for($i=0; $i<$rows; $i++){ ?>
                    <div class="chairs_index_bold"><?php echo $i+1?></div>
                <?php } ?>
                </div>
            </div>

            <div>
                <div class="chairs_grid_row">
                    <?php
                        graphicator($chairStatusFinal[0], $lineBreak);
                    ?>
                </div>
            </div>
        </div>
        
            <?php 
                if($message===true){?>
                    <div class="afirmativeMessage">
                    <?php echo $actionMessage;?>
                    </div>
                <?php }
                if($message===false){?>
                    <div class="negativeMessage">
                    <?php echo $actionMessage;?>
                    </div>
                <?php }
            ?>
        
    </div>
    <div class="btn_grid_container">

       <!--forms-->
        <form id="form_val" class="form_orientation" method="post" action="index.php">
            <!--Input column-->
            <label>Column</label>
            <input fomr="form_val" name="column" type="number" id="column" >
            <!--Input row-->
            <label>Row</label>
            <input form="form_val" name="row" type="number" id="row">
        </form>

        <!--Checkbox and button-->
        <form class="btn_div">
            <!--Checkbox book-->
            <input id="check_btn1" form="form_val" value="R" type="radio" name="r">
            <label class= "check_btn" name="labelBook" for="check_btn1">Book</label>
            <!--Checkbox buy-->
            <input id="check_btn2" form="form_val" value="V" type="radio" name="b">
            <label class= "check_btn" name="labelBook2" for="check_btn2">Buy</label>
            <!--Checkbox release-->
            <input id="check_btn3" form="form_val" value="L" type="radio" name="l">
            <label class= "check_btn" name="labelBook3" for="check_btn3">Release</label>
            <!--Button confirm-->
            <button form="form_val" value="confirm" type="submit" name="c" class="btn_style">Confirm</button>
            
        </form>
        <form class="btn_div">
            <!--Button restart-->
            <button form="form_val" value="confirm" type="submit" name="restart" class="btn_style">Restart chairs</button>
        </form>
        
    </div>

    <div class="footer">
        <div class="strong">Description app</div> 
        <div class="soft">This application allows you to simulate a theater were you can:<br> book (R), buy (V) and relese (L) a chair</div>
        <div class="strong">Developer</div>
        <div class="soft">Jairo Johan Lasso Ch</div>
        <div class="strong">Technologies used</div>
        <div class="soft">PHP, CSS, HTML, JavaScript</div>
        <div class="strong">Additional information</div>
        <div class="soft">This application uses procedural PHP (NON-OOP). Even so, <br>
            this one has incorporated other features such as: session variables to <br>
            storage the information in the server side</div>
    </div> 
    <script>            
        /**Variables */
        let positionGrid = "<?php echo $positionGrid;?>";
        let parameters = "<?php echo $parameter;?>";
        //Conver from JSON string to JavaScript Array
        let actualArray = JSON.parse('<?php echo $javaScriptArray; ?>');
        /**Functions */                        
        let finalArray = actualArrayGra(actualArray, positionGrid, parameters);
    </script>        
</body>
</html>