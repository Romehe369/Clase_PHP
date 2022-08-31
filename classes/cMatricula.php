<?php
include_once 'cDocente.php';
include_once 'cAlumno.php';
class cMatricula{
    #Nombre del docente
    private $Docente;
    #Lista de alumnos del docente
    private $ArrAlumnos;
    #Cantidad de alumnos
    private $Tamanio;
    //Metodos como Constructor
    function crearMatricula($Docente,$ArrAlumnos){
        $this->Docente=$Docente;
        $this->ArrAlumnos=$ArrAlumnos;
        #Obtenemos la cantidad de alumnos
        $this->Tamanio=count($ArrAlumnos);
    }
    //Imprimimos alumnos de un docente
    function ImprimirDocenteAlumnos(){
        $AuxDocente = new cDocente();
        $AuxDocente->crearDocente($this->Docente->get_Nombre(), $this->Docente->get_Categoria()." NRO DE ALUMNOS : ".$this->Tamanio);
        $this->Docente=$AuxDocente;  
        $this->Docente->ImprimirFila();
        foreach($this->ArrAlumnos as $vAlumno){
            $vAlumno->ImprimirFila();
        }
    }
    # Obtenemos el nombre del docente
    function get_Docente(){
        return $this->Docente;
    }
    # Obtenemos la lista de alumnos
    function get_Alumnos(){
        return $this->ArrAlumnos;
    }
    function set_ArrAlumnos($ArraAlumnos){
        $this->ArrAlumnos=$ArraAlumnos;
        $this->Tamanio=count($this->ArrAlumnos);
    }
    #Obtenemos el tamanio de la lista
    function get_numAlumnos(){
        return $this->Tamanio;
    }
    #Agregamos un alumno a nuestra lista de alumnos
    function Agregar_Alumno($Alumno){
        #Agregamos al final de la posicion
        $this->ArrAlumnos[$this->Tamanio]=$Alumno;
        #Incrementamos la cantidad de alumnos
        $this->Tamanio++;
    }
    function to_Array(){
        $Arr=$this->Docente->to_Array();
        foreach($this->ArrAlumnos as $vAlumno){
            $Arr=array_merge($Arr, $vAlumno->get_Alumnos());
        }
        return $Arr;
    }
    //Metodos
    function NumAlumnosdeUnCodigo($str2DigCodigo){
        if(strlen($str2DigCodigo)!==2){
            $i=0;
            foreach($this->ArrAlumnos as $vAlumno){
                $Code=$vAlumno->get_Codigo();
                if($Code[0].$Code[1]===$str2DigCodigo){
                    $i++;
                }
            }
            return $i;
        }
        return -1;
    }
    function EliminarAlumno($Codigo){
        $Posicion_Corte=0;
        $Eliminado=FALSE;
        for($x = 0; $x < $this->Tamanio; $x++){
            $Alumno=$this->ArrAlumnos[$x];
            #echo $Alumno->get_Codigo()." Codigo <br>";
            if($Codigo==$Alumno->get_Codigo()){
                #Salir del bucle
                $Eliminado=TRUE;
                $Posicion_Corte=$x;
                break;
            }
        }
        if($Eliminado){
            for($x = $Posicion_Corte; $x < $this->Tamanio-1; $x++){
                $this->ArrAlumnos[$x]=$this->ArrAlumnos[$x+1];
                $Eliminado=TRUE;
            }
            array_pop($this->ArrAlumnos);
            $this->Tamanio=count($this->ArrAlumnos);
        }
        return $Eliminado;
    }
}



?>