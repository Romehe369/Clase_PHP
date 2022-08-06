<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Examen Matriculados</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <h3 class="pb-3 pt-5">Agregar Archivos</h3>
            <!-- Para Agregar CSV -->
            <div class="col-12 pb-3">
                <div class="mb-3">
                    <!-- Creamos un formulario para leer los archivos -->
                    <form action="Cargar.php" method="post" enctype="multipart/form-data">
                            <label for="formFile" class="form-label">Matriculados General 2022 (.csv)</label>
                            <!-- Leemos docentes, en nombre Docentes -->
                            <input class="form-control mb-3" name="Docentes" type="file" id="formFile">
                            <label for="formFile" class="form-label">Docentes 2022 (.csv)</label>
                            <!-- Leemos alumnos Matriculados General 2022, en nombre Matriculados_General -->
                            <input class="form-control mb-3" name="Matriculados_General" type="file" id="formFile">
                            <label for="formFile" class="form-label">Distribución docente de tutorias en 2021-1 (.csv)</label>
                            <!-- Leemos alumnos Distribución docente de tutorias en 2021-1, en nombre archivo1 -->
                            <input class="form-control mb-3" name="Distribucion_docente" type="file" id="formFile">
                            <input type="submit" class="btn btn-primary" value="Cargar">
                    </form>
                </div>
            </div>
        </div>
            <div class="col-6 text p-3">
                <?php
                    include 'AllFunctions.php';
                    #Leemos los archivos
                    if (!isset($_FILES["Matriculados_General"])) {
                        throw new Exception("Selecciona un archivo CSV válido.");
                    }
                    if (!isset($_FILES["Distribucion_docente"])) {
                        throw new Exception("Selecciona un archivo CSV válido.");
                    }
                    #Cada archivo sera leido
                    $Matriculados_General   = $_FILES["Matriculados_General"];
                    $Distribucion_docente    = $_FILES["Distribucion_docente"];
                    #Creamo un objeto
                    $Mox=new Group73();
                    #Obtenemos los matriculados en genereal
                    $Arreglo_Matriculados=$Mox->csv_Array($Matriculados_General,0);
                    #Obtenemos la de alumnos con tutor del anterior semestre
                    $Arreglo_Dis_Docentes=$Mox->csv_Array($Distribucion_docente,0);
                    #$Mox->Imprimir($Arreglo_Dis_Docentes);
                    #Obtenemos el alumno y el docente del anterior semestre
                    $Arreglo_Dis_Docentes_Anterior=$Mox->csv_Array($Distribucion_docente,3);
                    #Obtenemos los alumnos no matriculados
                    $Alumnos_No_Matriculados=$Mox->Diferencia($Arreglo_Dis_Docentes,$Arreglo_Matriculados);
                    #$Mox->Imprimir($Arreglo_Matriculados);
                    #Obtenemos los alumnos sin tutor
                    $AlumnosSinTutor=$Mox->Diferencia($Arreglo_Matriculados,$Arreglo_Dis_Docentes);
                    $Mostrar=$Arreglo_Dis_Docentes_Anterior;
                ?>
            </div>
    </div>
    <div class="container mt-5">
        <div class="row"> 
            <form action="Ejecutar.php" method="post" enctype="multipart/form-data">
                <h3>EXPORTAR</h3>
                <h5>Alumnos sin tutor</h5><p><p>
                <th><a action="Ejecutar.php" <?php $Mostrar=$AlumnosSinTutor ?> class="btn btn-info">EXPORTAR</a></th>
                <th><a href="#Ejecutar?id=<?php $Mostrar=$Arreglo_Dis_Docentes ?>" class="btn btn-success">VER</a></th>
                <p><p>
                <h5>Alumnos no matriculados</h5><p><p>
                <th><a href="actualizar.php?id=<?php echo $row['Cod_Asignatura'] ?>" class="btn btn-info">EXPORTAR</a></th>
                <th><a href="delete.php?id=<?php echo $row['Cod_Asignatura'] ?>" class="btn btn-success">VER</a></th>
                <p><p>
                <h5>Distribucion de tutores</h5><p><p>
                <th><a href="actualizar.php?id=<?php echo $row['Cod_Asignatura'] ?>" class="btn btn-info">GUARDAR</a></th>
                <th><a href="delete.php?id=<?php echo $row['Cod_Asignatura'] ?>" class="btn btn-success">VER</a></th>
            </form>
            <div class="col-md-8" id="Ejecutar">
                            <table class="table" >
                                <thead class="table-success table-striped" id="Ejecutar" >
                                    <tr>
                                    <th>Numero</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php  
                                        $Mox->Imprimir($Alumnos_No_Matriculados);
                                        $Mox->GenerarCSV($Alumnos_No_Matriculados);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>  
            </div>
</body>
</html>