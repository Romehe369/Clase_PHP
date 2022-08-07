<?php 
    include 'AllFunctions.php';
    $Mostrar=[];
    $Alumnos_No_Matriculados=[];
?>
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
        <h3 class="pb-3 pt-5">Agregar Archivos</h3>
        <!-- Creamos un formulario para leer los archivos -->
        <form action="index.php" method="post" enctype="multipart/form-data">
            <label for="formFile" class="form-label">Matriculados General 2022 (.csv)</label>
            <!-- Leemos docentes, en nombre Docentes -->
            <input class="form-control mb-3" name="Matriculados_General" type="file" id="formFile">

            <label for="formFile" class="form-label">Docentes 2022 (.csv)</label>
            <!-- Leemos alumnos Matriculados General 2022, en nombre Matriculados_General -->
            <input class="form-control mb-3" name="Docentes" type="file" id="formFile">

            <label for="formFile" class="form-label">Distribución docente de tutorias en 2021-1 (.csv)</label>
            <!-- Leemos alumnos Distribución docente de tutorias en 2021-1, en nombre archivo1 -->
            <input class="form-control mb-3" name="Distribucion_docente" type="file" id="formFile">
            <input type="submit" class="btn btn-primary" value="Cargar y exportar">
        </form>
        <?php
            #Leemos los archivos
            if (!isset($_FILES["Matriculados_General"])) {
                #throw new Exception("Selecciona un archivo CSV válido");
            }
            if (!isset($_FILES["Distribucion_docente"])) {
                #throw new Exception("Selecciona un archivo CSV válido.");
            }
            else{
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
                $Mostrar=$AlumnosSinTutor;
            ?>
        <p>
        <h6> EXPORTAR:LOS DATOS SE GUARDAN EN:</p>
        <ul>
            <li>\xampp\htdocs\"Nombre de la carpeta"\No_Considerados_En_Tutoria.csv<br></li>
            <li>\xampp\htdocs\"Nombre de la carpeta"\Distribucion_balanceada_tutorias.csv<br></li></ul>
        </h6>
        <p>
            <b>Aqui podemos vizualizar los datos de los alumnos sin tutor:</b>
        <p>
        <div class="row"> 
            <div class="tab-pane container" id="Ejecutar">
                <table class="table" >
                    <thead class="table-success table-striped" id="Ejecutar" >
                        <th>Numero</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                    </thead>
                    <tbody>
                        <?php  
                            $Mox->Imprimir($AlumnosSinTutor);
                            $Balanceado=$Mox->Balancear($AlumnosSinTutor,$AlumnosSinTutor,$Arreglo_Dis_Docentes_Anterior,$Alumnos_No_Matriculados);
                            $Mox->GenerarCSV_No_Considerados($Alumnos_No_Matriculados);
                            #$Mox->GenerarCSV($Alumnos_No_Matriculados);
                            $Mox->GenerarCSV_Distribucion($Balanceado);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>         
    </div>
</body>
</html>