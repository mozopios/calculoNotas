<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Calculo Notas</h1>

</div>

<!-- Content Row -->

<div class="row">

    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"></h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form  method="post" action="./?sec=formulario">
<!--                <form method="get">-->
                    <input type="hidden" name="sec" value="formulario" />
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Introduce un array en formato json</label>
                        <input class="form-control" id="exampleFormControlInput1" type="text" name="datos">
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>

