<?php
include_once  './classes/cMatricula.php';
class AllFunctions{
    /* Funciones de Entrada */
    //Refactorizar csv_a_Array
    function csv_to_ArrayAlumno($tmp){
        $ArrAlumnos=array();
        if (($gestor = fopen($tmp, "r")) !== FALSE){
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                if($datos[0]!=='codigo'){
                    $AuxAlumno=new cAlumno();
                    $AuxAlumno->crearAlumno($datos[0],$datos[1],TRUE);
                    $ArrAlumnos[]= $AuxAlumno;
                }
            }
        }
        fclose($gestor);
        return $ArrAlumnos;
    }
    function csv_to_ArrayDocente($tmp){
        $ArrDocente=array();
        if (($gestor = fopen($tmp, "r")) !== FALSE){
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                if($datos[0]!=='Nombre'){
                    $AuxDocente=new cDocente();
                    $AuxDocente->crearDocente($datos[0],$datos[1],FALSE);
                    $ArrDocente[]= $AuxDocente;
                }
            }
        }
        fclose($gestor);
        return $ArrDocente;
    }
    function csv_to_ArrayMatricula($tmp){
        $ArrMatricula = array();
        $ArrAuxAlumnos = array();
        $AuxDocente = new cDocente();
        if (($gestor = fopen($tmp, "r")) !== FALSE){
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                if(substr($datos[0], 0, 7)==='Docente'){
                    if(!empty($ArrAuxAlumnos)){
                        $AuxMatricula = new cMatricula();
                        $AuxMatricula->crearMatricula($AuxDocente, $ArrAuxAlumnos);
                        $ArrMatricula[]=$AuxMatricula;
                    }
                    $ArrAuxAlumnos = array();
                    $AuxDocente = new cDocente();
                    //Espacio de prueba
                    $Datos1=$datos[1]." /";
                    $val=explode(' /' ,$Datos1);
                    if(strlen($val[1])>1){
                        $AuxDocente->crearDocente($val[1], '---');
                        $AuxDocente->crearDocente($val[0], '---');
                    }
                    else{
                        $AuxDocente->crearDocente($val[0], '---');
                    }
                }
                if($datos[0]!=='CODIGO' and substr($datos[0], 0, 7)!=='Docente'){
                    #echo $datos[0]."<br>";
                    if(strlen($datos[0])>3){
                        $AuxAlumno = new cAlumno();
                        $AuxAlumno->crearAlumno($datos[0],$datos[1],TRUE);
                        $ArrAuxAlumnos[]= $AuxAlumno;
                    }
                }
            }
        }
        #Agregamos el ultimo docente y alumno a nuestra tabla
        $AuxMatricula = new cMatricula();
        $AuxMatricula->crearMatricula($AuxDocente, $ArrAuxAlumnos);
        $ArrMatricula[]=$AuxMatricula;
        fclose($gestor);
        return $ArrMatricula;
    }
    function csv_to_ArrayGeneral($file){
        $tmp      = $file["tmp_name"];
        $filename = $file["name"];
        $size     = $file["size"];
        // Marcar errores */
       if($size<=0){
            throw new Exception("Este Archivo esta Vacio");
        }
        // CONTROL DE FORMATOS 
        $TipoArchivo=explode(".",$filename)[1]; 
        switch ($TipoArchivo) {
            case "Matriculados":
                return $this->csv_to_ArrayMatricula($tmp);
              break;
            case "Docente":
                return $this->csv_to_ArrayDocente($tmp);
              break;
            case "Alumnos":
                return $this->csv_to_ArrayAlumno($tmp);
              break;
            default:
              echo "Lo Siento no es uno de los formatos que dominamos, Intente con otro";
              return array();
          }
    }
    function ObtenerDocentesdeMatriculaArr($ArrMatricula){
        $ArrResult=array();
        foreach($ArrMatricula as $vMatricula){
            $ArrResult[]=$vMatricula->get_Docente();
        }
        return $ArrResult;
    }
    #Obtenemos todos los alumnos matriculados en el semestre anterior
    function ObtenerAlumnosdeMatriculaArr($ArrMatricula){
        #Los alumnos se almacenan en este arreglo
        $ArrResult=array();
        foreach($ArrMatricula as $vMatricula){
            $ArrResult=array_merge($ArrResult, $vMatricula->get_Alumnos());
        }
        return $ArrResult;
    }
    # En Arr_Matriculados_Anterior_S viene los los alumnos matriculados en anterior semestre 
    # y en Arr_Alumnos_No_Matriculados estan los alumnos que ya estan matriculados en este semestre
    function Borrar_Alumnos_No_Matriculados($Arr_Matriculados_Anterior_S,$Arr_Alumnos_No_Matriculados){
        $Tamanio=count($Arr_Matriculados_Anterior_S);
        for($x = 0; $x < count($Arr_Alumnos_No_Matriculados); $x++){
            #Obtenemos los codigos a eliminar
            $Eliminar=$Arr_Alumnos_No_Matriculados[$x]->get_Codigo();
            #Recorremos buscando si existe el alumno para eliminarlo
            for($y = 0; $y < count($Arr_Matriculados_Anterior_S); $y++){
                $Eliminado=$Arr_Matriculados_Anterior_S[$y]->EliminarAlumno($Eliminar);
                if($Eliminado){
                    break;
                }
            }
        }
    }function DiferenciaAlumnos($ArrAlumnosA, $ArrAlumnosB){
        $Arreglo=array();
        for($x = 0; $x < count($ArrAlumnosA); $x++){
            $Existe=false;
            for($y = 0; $y < count($ArrAlumnosB); $y++){
                if($ArrAlumnosA[$x]->get_Codigo()==$ArrAlumnosB[$y]->get_Codigo()){
                    $Existe=true;
                    break;
                }
            }
            if($Existe==false){
                $Arreglo[]=$ArrAlumnosA[$x];
            }
        }
        return $Arreglo;
    }
    function DiferenciaDocentes($ArrDocentesA,$ArrDocentesB){
        $Arreglo=array();
        for($x = 0; $x < count($ArrDocentesA); $x++){
            $Existe=false;
            for($y = 0; $y < count($ArrDocentesB); $y++){
                if($ArrDocentesA[$x]->get_Nombre()==$ArrDocentesB[$y]->get_Nombre()){
                    $Existe=true;
                    break;
                }
            }
            if($Existe==false){
                $Arreglo[]=$ArrDocentesA[$x];
            }
        }
        return $Arreglo;
    }
    function ActualizarCategoriaDocentes($MatriculasAntigua,$DocentesActuales){
        #Agregar Categoria a los docentes que no tengan
        # o su categoria haya cambiado (Se cambia a todos)
        foreach($MatriculasAntigua as $Matricula){
            for($i=0; $i<count($DocentesActuales) ;$i++){
                if($Matricula->get_Docente()->get_Nombre()===$DocentesActuales[$i]->get_Nombre()){
                    $Matricula->get_Docente()->set_Categoria($DocentesActuales[$i]->get_Categoria());
                }
            }
        }
    }
    function QuitarExDocentes($MatriculasAntigua,$ExDocentes){
        foreach($MatriculasAntigua as $Matricula){
            for($i=0; $i<count($ExDocentes) ;$i++){
                if($Matricula->get_Docente()->get_Nombre()===$ExDocentes[$i]->get_Nombre()){
                    $Matricula->get_Docente()->crearDocente('*','*');
                }
            }
        }
    }
    function AgregarNuevosDocentes($MatriculasAntigua,$NuevosDocentes){
        #Se Evita Dañar el Arreglo $NuevosDocentes
        $NuevosDocentesAux=$NuevosDocentes;
        $i=0;
        #Agregar Nuevos Docentes
        foreach($MatriculasAntigua as $Matricula){
            #Se buscan los Cupos(Docentes Vacios) vacios
            if($Matricula->get_Docente()->get_Nombre()==='*' and !empty($NuevosDocentesAux)){
                $Matricula->get_Docente()->crearDocente(
                    $NuevosDocentesAux[$i]->get_Nombre(),
                    $NuevosDocentesAux[$i]->get_Categoria()
                );
                unset($NuevosDocentesAux[$i]);
                $i++;
            }
        }
    }
    /* Funciones de Proceso*/
    function Balancear($Matricula,$AlumnoSinTutor,$Docentes_Sin_Tutorando){
        $Medio=15;
        $Contador=0;
        for($y = 0; $y < count($Matricula); $y++){
            #Obtenemos la cantidad de alumnos por docente
            $Tamanio=$Matricula[$y]->get_numAlumnos();
            if($Tamanio<$Medio and $Contador<count($AlumnoSinTutor)){
                #Completar alumnos de AlumnoSinTutor
                $Cantidad=$Medio-$Tamanio;
                for($x = 0; $x < $Cantidad; $x++){
                    #Agregamos un alumno cada que este desbalanceado
                    $Matricula[$y]->Agregar_Alumno($AlumnoSinTutor[$Contador]);
                    $Contador++;
                }
            }
        }
        #Cuando sobra alumnos tomamos un docente sin tutorando y agregamoslos sobrantes a ese 
        #Docente
        if($Contador<count($AlumnoSinTutor)){
            # Posicion en el areglo de docentes sin tutorando
            $Pos_Docente=0;
            # Agregamos los alumnos sobrantes en un arreglo
            $Arr_Alumnos_Agregar=Array();
            # Recorremos el arreglo agregando los sobrantes a
            for($y = $Contador; $y < count($AlumnoSinTutor); $y++){
                $Arr_Alumnos_Agregar[]=$AlumnoSinTutor[$y];
            }
            #Creamos un tipo de cMatricula_Tutorando
            $AuxMatricula = new cMatricula();
            #Asignamos un docente sin tutrando
            $AuxMatricula->crearMatricula($Docentes_Sin_Tutorando[$Pos_Docente], $Arr_Alumnos_Agregar);
            #Agregamos el nuevo docente con sus alumnos
            $Matricula[]=$AuxMatricula;
        }
    }
    // En este modulo obtenemos la diferencia de dos tablas
    /*
        ArraA y ArrB deben contener objetos del mismo tipo, y el getcodigo
        obtener el id de dicho objetos, en este caso lista de alumnos
     */
    /* Solo Funciona Con Parametros cDocente y cAlumno */
    function ImprimirTabla($Array){
        foreach($Array as $Dato){
            $Dato->ImprimirFila();
        }
    }
    function ImprimirTablaMatricula($Array){
        foreach($Array as $Dato){
            $Dato->ImprimirDocenteAlumnos();
        }
    }
    /* Funciones de Salida */
    function Array_to_Csv(){
        $fp = fopen('xyz.csv', 'w+');
        // Escribimos los datos en el archivo 'archivo.csv'
        for($x = 0; $x < count($datos); $x++){
            fputcsv($fp, $datos[$x]);
        }
        fclose($fp); 
    }
}
?>