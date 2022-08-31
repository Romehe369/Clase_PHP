<?php
include 'cMatricula.php';

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
                        $AuxDocente->crearDocente($val[1], '---',TRUE);
                        $AuxDocente->crearDocente($val[0], '---',FALSE);
                    }
                    else{
                        $AuxDocente->crearDocente($val[0], '---',FALSE);
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
    #Obtenemos todos los alumnos matriculados en el semestre anterior
    function Lista_Alumnos($ArrB){
        #Los alumnos se almacenan en este arreglo
        $Arreglo_alumnos=[];
        # Tamanio, 
        $Tamanio=0;
        for($y = 0; $y < count($ArrB); $y++){
            # Obtenemos los alumnos de cada docente
            $ArrayC=$ArrB[$y]->get_ArrAlumnos();
            # Recorremos cada alumno y agregamos a otra lista
            for($xi = 0; $xi < count($ArrayC); $xi++){
                $Arreglo_alumnos[$Tamanio]=$ArrayC[$xi];
                $Tamanio++;
            }
        }
        return $Arreglo_alumnos;
    }
    # En ArraA viene los valores anteriores y en ArrB estan los alumnos que ya estan en
    # este semestre
    function Borrar_Alumnos_No_Matriculados($ArraA,$ArrB){
        $Tamanio=count($ArraA);
        for($x = 0; $x < count($ArrB); $x++){
            #Obtenemos los codigos a eliminar
            $Eliminar=$ArrB[$x]->get_Codigo();
            #Este recorremos buscando si existe el alumno para eliminarlo
            for($y = 0; $y < count($ArraA); $y++){
                $Eliminado=$ArraA[$y]->Eliminar_Alumno($Eliminar);
                if($Eliminado){
                    break;
                }
            }
        }
    }
    /* Funciones de Proceso*/
    function Balancear($ArrA,$ArrB){
        $Medio=15;
        $Contador=0;
        for($y = 0; $y < count($ArrA); $y++){
            #Obtenemos la cantidad de alumnos por docente
            $Tamanio=$ArrA[$y]->get_Tamanio();
            if($Tamanio<$Medio and $Contador<count($ArrB)){
                #Completar alumnos de ArrB
                $Cantidad=$Medio-$Tamanio;
                for($x = 0; $x < $Cantidad; $x++){
                    #Agregamos un alumno cada que este desbalanceado
                    $ArrA[$y]->Agregar_Alumno($ArrB[$Contador]);
                    $Contador++;
                }
            }
        }
    }
    // En este modulo obtenemos la diferencia de dos tablas
    /*
        ArraA y ArrB deben contener objetos del mismo tipo, y el getcodigo
        obtener el id de dicho objetos, en este caso lista de alumnos
     */
    function Diferencia($ArrA,$ArrB){
        $fila=0;
        $Arreglo=array();
        for($x = 0; $x < count($ArrA); $x++){
            $Existe=false;
            for($y = 0; $y < count($ArrB); $y++){
                if($ArrA[$x]->get_Codigo()==$ArrB[$y]->get_Codigo()){
                    $Existe=true;
                    break;
                }
            }
            if($Existe==false){
                $AuxAlumno = new cAlumno();
                $AuxAlumno->crearAlumno($ArrA[$x]->get_Codigo(),$ArrA[$x]->get_Nombre(),$ArrA[$x]->get_Estado());
                $Arreglo[$fila]= $AuxAlumno;
                $fila++;
            }
        }
        return $Arreglo;
    }
    /* Solo Funciona Con Parametros cDocente y cAlumno */
    function ImprimirTabla($Array){
        foreach($Array as $Dato){
            $Dato->ImprimirFila("Antiguo");
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