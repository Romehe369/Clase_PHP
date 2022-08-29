<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Matriculados</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <h3 class="pb-3 pt-5">Agregar Archivos</h3>
            <!-- Para Agregar CSV -->
            <div class="col-12 pb-3">
                <div class="mb-3">
                    <form action="index.php" method="post" enctype="multipart/form-data">
                            <label for="formFile" class="form-label">Alumnos Matriculados General 2022 (.csv)</label>
                            <input class="form-control mb-3" name="FileAlumnos" type="file" id="formFile">
                            
                            <label for="formFile" class="form-label">Distribución docente de tutorias 2021-1 (.csv)</label>
                            <input class="form-control mb-3" name="FileDistribucion" type="file" id="formFile">
                            
                            <label for="formFile" class="form-label">Docente 2022 (.csv)</label>
                            <input class="form-control mb-3" name="FileDocente" type="file" id="formFile">
                            
                            <input type="submit" class="btn btn-primary" value="Cargar">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        /* Iniciar Valores */
        include 'AllFunctions.php';
        if (!isset($_FILES["FileAlumnos"]) or !isset($_FILES["FileDistribucion"]) or !isset($_FILES["FileDocente"])) {
            throw new Exception("Selecciona un archivo CSV válido.");
        }
        $FileAlumnos          = $_FILES["FileAlumnos"];
        $FileDistribucion     = $_FILES["FileDistribucion"];
        $FileDocente          = $_FILES["FileDocente"];
        
        $ControlMox=new AllFunctions();
        $ArrAlumnos2022=$ControlMox->csv_to_ArrayGeneral($FileAlumnos);
        $ArrDocente2022=$ControlMox->csv_to_ArrayGeneral($FileDocente);
        #Arreglo de matriculas -----Estan los alumnos antiguos
        $ArrMatriculas2021=$ControlMox->csv_to_ArrayGeneral($FileDistribucion);
        #Arreglo general de alumnos antiguos
        $Total_Alumnos_Antiguos=$ControlMox->Lista_Alumnos($ArrMatriculas2021);
        #Obetenemos los alumnos nuevos
        $Arr_Nuevos=$ControlMox->Diferencia($ArrAlumnos2022,$Total_Alumnos_Antiguos);
        #Obtenemos los no matriculados
        $Arr_no_matriculados=$ControlMox->Diferencia($Total_Alumnos_Antiguos,$ArrAlumnos2022);
        #$Arr_No_Matriculados=$ControlMox->Diferencia($ArrMatriculas2021,$ArrAlumnos2022,2);
        $ControlMox->Borrar_Alumnos_No_Matriculados($ArrMatriculas2021,$Arr_no_matriculados);
        $ControlMox->Balancear($ArrMatriculas2021,$Arr_Nuevos);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="pb-3">Tablas</h3>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs pb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#DxD">Tabla balanceada</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Alumno">Alumnos 2022</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Docente">Docentes 2022</a>
                    </li>
                </ul>

                <div class="tab-content p-3">
                    <div class="tab-pane container active" id="DxD">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($ArrMatriculas2021)){
                                $ControlMox->ImprimirTablaMatricula($ArrMatriculas2021);
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane container" id="Alumno">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($ArrAlumnos2022)){
                                $ControlMox->ImprimirTabla($ArrAlumnos2022);
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane container" id="Docente">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoria</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($ArrDocente2022)){
                                $ControlMox->ImprimirTabla($ArrDocente2022);
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>