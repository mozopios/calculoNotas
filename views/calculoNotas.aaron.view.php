<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Calculo Notas</h1>

</div>

<!-- Content Row -->

<div class="row">
    <?php
    if(isset($data["resultado"])){
    ?>
    <div class="col-lg-4 col-12">
        <div class="alert alert-success">
            <h6>Todo Aprobado</h6>
            <ol>
                <?php
                    foreach($data["resultado"]["alumnos"] as $nombreAlumno => $datos){
                        if($datos["suspensos"] === 0){
                            echo "<li>$nombreAlumno</li>";
                        }
                    }
                ?>
            </ol>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="alert alert-warning">
            <h6>Han suspendido 1</h6>
            <ol>
                <?php
                    foreach($data["resultado"]["alumnos"] as $nombreAlumno => $datos){
                        if($datos["suspensos"] == 1){
                            echo "<li>$nombreAlumno</li>";
                        }
                    }
                ?>
            </ol>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="alert alert-info">
            <h6>Promocionan</h6>
            <ol>
                <?php
                    foreach($data["resultado"]["alumnos"] as $nombreAlumno => $datos){
                        if($datos["suspensos"] <= 1){
                            echo "<li>$nombreAlumno</li>";
                        }
                    }
                ?>
            </ol>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="alert alert-danger">
            <h6>No promocionan</h6>
            <ol>
                <?php
                    foreach($data["resultado"]["alumnos"] as $nombreAlumno => $datos){
                        if($datos["suspensos"] > 2){
                            echo "<li>$nombreAlumno</li>";
                        }
                    }
                ?>
            </ol>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"></h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form  method="post" action="./?sec=calculoNotas.aaron">
<!--                <form method="get">-->
                    <input type="hidden" name="sec" value="formulario" />
                    <div class="mb-3">
                        <label for="areaTexto">Introduce un array en formato json</label>
                        <textarea class="form-control" id="areaTexto" name="datos" rows = 10><?php echo isset($data["input"]["datos"]) ? $data["input"]["datos"] : "";?></textarea>
                        <p class="text-danger small"><?php echo isset($data["errores"]["datos"]) ? $data["errores"]["datos"] : "";?></p>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="Enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>

