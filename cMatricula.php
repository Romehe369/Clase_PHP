<?php
include 'cDocente.php';
include 'cAlumno.php';
class cMatricula{
    private $Docente;
    private $ArrAlumnos;
    private $Tamanio;
    //Metodos como Constructor
    function crearMatricula($Docente,$ArrAlumnos){
        $this->Docente=$Docente;
        $this->ArrAlumnos=$ArrAlumnos;
        $this->Tamanio=count($ArrAlumnos);
    }
    //Metodos Get
    //Metodos
    function ImprimirDocenteAlumnos(){
        $this->Docente->ImprimirFila("Antiguo");
        foreach($this->ArrAlumnos as $vAlumno){
            $vAlumno->ImprimirFila("Antiguo");
        }
    }
    function get_Docente(){
        return $this->Docente;
    }
    function get_ArrAlumnos(){
        return $this->ArrAlumnos;
    }
    function set_ArrAlumnos($ArraAlumnos){
        $this->ArrAlumnos=$ArraAlumnos;
        $this->Tamanio=count($this->ArrAlumnos);
    }
    function get_Tamanio(){
        return $this->Tamanio;
    }
    function Agregar_Alumno($Alumno){
        $this->ArrAlumnos[$this->Tamanio]=$Alumno;
        $this->Tamanio++;
    }
    function Eliminar_Alumno($Codigo){
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