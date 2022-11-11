<?php
declare (strict_types = 1);

if(isset($_POST["Enviar"])){
    $data["errores"] = checkForm($_POST);
    $data["input"] = filter_var_array($_POST);
    if(empty($data["errores"])){
        $arrayJson = json_decode($_POST["datos"],true);
        $resultado = datosAsignaturas($arrayJson);
        $data["resultado"] = $resultado;
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
            $erroresArrayJson = [];
            foreach($asignaturas as $asignatura => $alumnos){
                if(empty($asignatura)){
                    $erroresArrayJson .= "La asigantura no puede estar vacía <br />";
                }
                if(!is_array($alumnos)){
                    $erroresArrayJson .= "La asiganatura " . htmlentities($asignatura) . " no contiene un array de alumnos <br />";
                }
                else{
                    foreach ($alumnos as $nombreAlumno => $notas){
                        if(empty($nombreAlumno)){
                            $erroresArrayJson = "La asignatura " . htmlentities($asignatura) . " tiene un alumno sin nombre <br />";
                        }
                        if(!is_array($notas)){
                            $erroresArrayJson .= "El alumno " . htmlentities($nombreAlumno) . "no contiene un array de notas <br />";
                        }else{
                            foreach ($notas as $nota){
                                if(!is_numeric($nota)){
                                    $erroresArrayJson .= "La asignatura " . htmlentities($asignatura) . " tiene una nota que no es numerica <br />";
                                }
                                else{
                                    if($nota < 0 || $nota > 10){
                                        $erroresArrayJson = "La asignatura " . htmlentities($asignatura) ." en el alumno " . htmlentities($nombreAlumno) . " tiene una nota que no está entre 0 y 10";
                                    }
                                }  
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

function datosAsignaturas(array $arrayJson) : array{
    $resultado = array();
    $alumnos = array();
    foreach ($arrayJson as $asignatura => $alumno){
        $resultado[$asignatura] = array();
        $aprobados = 0;
        $suspensos = 0;
        $notaMaxima = array(
            "alumno" => "",
            "nota" => -1
        );
        
        $notaMinima = array(
            "alumno" => "",
            "nota" => 11
        );
        $notaAcumulada = 0;
        $contadorAlumnos = 0;
        
        foreach ($alumno as $nombreAlumno => $notas){
                if(!isset($alumnos[$nombreAlumno])){
                    $alumnos[$nombreAlumno] = ["aprobados" => 0 , "suspensos" => 0];
                }
                $acumulacionNotaAlumnoAsignatura = 0;
                for($i =0 ;$i<count($notas);$i++){
                    $acumulacionNotaAlumnoAsignatura += $notas[$i];
                }
                $nota = $acumulacionNotaAlumnoAsignatura/ count($notas);
                if($nota > $notaMaxima["nota"]){
                        $notaMaxima["alumno"] = $nombreAlumno;
                        $notaMaxima["nota"] = $nota;
                    }
                if($nota < $notaMinima["nota"]){
                        $notaMinima["alumno"] = $nombreAlumno;
                        $notaMinima["nota"] = ($nota);
                }
                $contadorAlumnos++;
                $notaAcumulada += $nota;

                if($nota < 5){
                    $suspensos++;
                    $alumnos[$nombreAlumno]["suspensos"]++;
                } else {
                    $aprobados++;
                    $alumnos[$nombreAlumno]["aprobados"]++;
                }
        }
        if($contadorAlumnos > 0){
            $resultado[$asignatura]["media"] = $notaAcumulada / $contadorAlumnos;
            $resultado[$asignatura]["max"] = $notaMaxima;
            $resultado[$asignatura]["min"] = $notaMinima; 
        }else{
            $resultado[$asignatura]["media"] = 0;
        }
        $resultado[$asignatura]["aprobados"] = $aprobados;
        $resultado[$asignatura]["suspensos"] = $suspensos;
    }
    return array("asignaturas" => $resultado, "alumnos" => $alumnos);
}

include 'views/templates/header.php';
include 'views/calculoNotas.aaron.view.php';
include 'views/templates/footer.php';

