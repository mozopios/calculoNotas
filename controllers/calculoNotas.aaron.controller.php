<?php
declare (strict_types = 1);

if(isset($_POST["Enviar"])){
    $data["errores"] = checkForm($_POST);
    $_POST["input"] = filter_var_array($_POST);
    if(empty($data["errores"])){
        
    }
}

function checkForm(array $post) : array {
    $errores = array();
    if(empty($post["datos"])){
        $errores["datos"] = "Este campo no puede estar vacío";
    }else{
        $asignaturas = json_decode($post["datos"], true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $errores["datos"] = "El formato del Json no es correcto";
        }
        else{
            $erroresArrayJson = array();
            foreach($asignaturas as $asignatura => $alumnos){
                if(empty($asignatura)){
                    $erroresArrayJson .= "La asigantura no puede estar vacía <br />";
                }
                if(!is_array($alumnos)){
                    $erroresArrayJson .= "La asiganatura " . htmlentities($asignatura) . " no contiene un array de alumnos <br />";
                }
                else{
                    foreach ($alumnos as $nombreAlumno => $nota){
                        if(empty($nombreAlumno)){
                            $erroresArrayJson .= "La asignatura " . htmlentities($asignatura) ." tiene un alumno sin nombre <br />";
                        }
                        if(!is_int($nota)){
                            $erroresArrayJson .= "La asignatura " . htmlentities($asignatura) . " tiene una nota que no es un int ". htmlentities($nota);
                        }
                        else{
                            if($nota < 0 || $nota > 10){
                                $erroresArrayJson .= "La asigantura " . htmlentities($asignatura) . " el alumno " . htmlentities($alumnos) . " tiene una nota " . htmlentities($nota) . " que no esta en el ragon de 0 a 10";
                            }
                        }
                    }
                }
            }
            if(!empty($erroresArrayJson)){
                $errores["datos"] = $erroresArrayJson;
            }
        }
    }
    return $errores;
}

include 'views/templates/header.php';
include 'views/calculoNotas.aaron.view.php';
include 'views/templates/footer.php';

