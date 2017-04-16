<?php
    //Mac only
   // init_set("display_errors",1);
    //errpr_reporting(E_ALL);
   //echo "validation file";

    function has_value($value){
        return isset($value) && $value !=="";
    }

    function for_errors($errors = array()){
            $op = "";
            if(!empty($errors)){
                    $op .= "Your attention is required on the following";

                    $op .= "<ul>";

                        foreach($errors as $key => $error){
                            $op .= "<li>{$error}</li>";
                        }

                    $op .= "</ul>";
            }
            return $op;
    }

?>

