<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--BootsTrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!--Css Style Interno-->
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Control Matriculas</title>
</head>
<body class="parallax-A">
    <div class="container">
        <div class="row">
            <h1 class="pt-5 pb-5 text-center">
                UNIVERSIDAD NACIONAL DE SAN ANTONIO ABAD DEL CUSCO
            </h1>
        </div>
        <div class="row">
            <!-- Para Agregar CSV -->
            <div class="col-4 text-center">
                <div class="borderRMox pb-3">
                    <img src="assets/img/logo.png" alt="">
                    <h2>
                        Ingeniería Informática y de Sistemas
                    </h2>
                </div>
            </div>
            <div class="col-8">
                <h1>Agregar Archivos</h1>
                <div class="linea lineaA"></div>
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
            #throw new Exception("Selecciona un archivo CSV válido.");
        } # Se ejecuta este bloque cuando no presenta ningun error
        else{
        #Se asigna los de los archivo a una direccion
        $FileAlumnos          = $_FILES["FileAlumnos"];
        $FileDistribucion     = $_FILES["FileDistribucion"];
        $FileDocente          = $_FILES["FileDocente"];
        
        $ControlMox=new AllFunctions();
        $ArrAlumnos2022=$ControlMox->csv_to_ArrayGeneral($FileAlumnos);
        $ArrDocente2022=$ControlMox->csv_to_ArrayGeneral($FileDocente);
        #Arreglo de matriculas -----Estan los alumnos antiguos
        $ArrMatriculas2021=$ControlMox->csv_to_ArrayGeneral($FileDistribucion);
        ?>
        <div class="container">
        <div class="row">
            <div class="col-6">
                <h3 class="pb-3">Tablas Entradas</h3>
                <div class="linea lineaA"></div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs pb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#DxD">Matriculados 2021</a>
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
            <?php 
        #Arreglo general de alumnos antiguos
        #$Total_Alumnos_Antiguos=$ControlMox->Lista_Alumnos($ArrMatriculas2021);
        $ArrDocentes2021=$ControlMox->ObtenerDocentesdeMatriculaArr($ArrMatriculas2021);
        $ArrAlumnos2021=$ControlMox->ObtenerAlumnosdeMatriculaArr($ArrMatriculas2021);
        #Obetenemos los alumnos nuevos
        #$Arr_Nuevos=$ControlMox->Diferencia($ArrAlumnos2022,$Total_Alumnos_Antiguos);
        $ArrAlumnosNoMatriculados=$ControlMox->DiferenciaAlumnos($ArrAlumnos2021,$ArrAlumnos2022);
        $ArrAlumnosSinTutor=$ControlMox->DiferenciaAlumnos($ArrAlumnos2022,$ArrAlumnos2021);
        $ArrExDocentes=$ControlMox->DiferenciaDocentes($ArrDocentes2021,$ArrDocente2022);
        $ArrDocentesSinTutorando=$ControlMox->DiferenciaDocentes($ArrDocente2022,$ArrDocentes2021);
        #Obtenemos los no matriculados
        $ArrMatriculas2022 = new cMatricula();
        $ArrMatriculas2022 = $ArrMatriculas2021;
        /*Actualizar datos de los docentes */
        $ControlMox->ActualizarCategoriaDocentes($ArrMatriculas2022,$ArrDocente2022);
        $ControlMox->QuitarExDocentes($ArrMatriculas2022,$ArrExDocentes);
        $ControlMox->AgregarNuevosDocentes($ArrMatriculas2022,$ArrDocentesSinTutorando);
        
        /*Actualizar datos de los Alumnos*/
        $ControlMox->Borrar_Alumnos_No_Matriculados($ArrMatriculas2022,$ArrAlumnosNoMatriculados);
        #$Arr_no_matriculados=$ControlMox->Diferencia($Total_Alumnos_Antiguos,$ArrAlumnos2022);
        # En nuestro clase matricula, todos alumnos antiguos que no estan matriculaods ahora, seran eliminados
        #$ControlMox->Borrar_Alumnos_No_Matriculados($ArrMatriculas2021,$Arr_no_matriculados);
        #Realizamos el balancear con los alumnos matriculados en 2021,  que  ahora estan matriculados 
        # en el presente semestre y los nuevos que se matricularon 
        $ControlMox->Balancear($ArrMatriculas2022,$ArrAlumnosSinTutor);
    ?> 
   <div class="col-6">
                <h3 class="pb-3">Tablas Salida</h3>
                <div class="linea lineaA"></div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs pb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#ArrAlumnosNoMatriculados">Alumnos No Matriculados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ArrAlumnosSinTutor">Alumnos Sin Tutor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ArrExDocentes">Ex-Docentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ArrDocentesSinTutorando">Docentes Sin Tutorandos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ArrMatricula2022">ArrMatricula2022</a>
                    </li>
                </ul>

                <div class="tab-content p-3">
                    <div class="tab-pane container active" id="ArrAlumnosNoMatriculados">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo "Nro. Alumnos: ".count($ArrAlumnosNoMatriculados);
                            if(!empty($ArrAlumnosNoMatriculados)){
                                $ControlMox->ImprimirTabla($ArrAlumnosNoMatriculados);
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane container" id="ArrAlumnosSinTutor">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo "Nro. Alumnos: ".count($ArrAlumnosSinTutor);
                            if(!empty($ArrAlumnosSinTutor)){
                                $ControlMox->ImprimirTabla($ArrAlumnosSinTutor);
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane container" id="ArrExDocentes">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Datos Importantes</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo "Nro. Docentes: ".count($ArrExDocentes);
                            if(!empty($ArrExDocentes)){
                                $ControlMox->ImprimirTabla($ArrExDocentes);
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane container" id="ArrDocentesSinTutorando">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoria</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo "Nro. Docentes: ".count($ArrDocentesSinTutorando);
                            if(!empty($ArrDocentesSinTutorando)){
                                $ControlMox->ImprimirTabla($ArrDocentesSinTutorando);
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane container" id="ArrMatricula2022">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo "Nro. Matriculas: ".count($ArrMatriculas2022);
                            if(!empty($ArrMatriculas2022)){
                                $ControlMox->ImprimirTablaMatricula($ArrMatriculas2022);
                            }
                        }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
        <?php
        ?>
        <div class="row">
            <a class="btn btn-success">Enviar</a>
        </div>
    </div>
</body>
</html>