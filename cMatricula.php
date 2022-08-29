<?php
include 'cDocente.php';
include 'cAlumno.php';
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
        $this->Docente->ImprimirFila("Antiguo");
        foreach($this->ArrAlumnos as $vAlumno){
            $vAlumno->ImprimirFila("Antiguo");
        }
    }
    # Obtenemos el nombre del docente
    function get_Docente(){
        return $this->Docente;
    }
    # Obtenemos la lista de alumnos
    function get_ArrAlumnos(){
        return $this->ArrAlumnos;
    }

    function set_ArrAlumnos($ArraAlumnos){
        $this->ArrAlumnos=$ArraAlumnos;
        $this->Tamanio=count($this->ArrAlumnos);
    }
    #Obtenemos el tamanio de la lista
    function get_Tamanio(){
        return $this->Tamanio;
    }
    #Agregamos un alumno a nuestra lista de alumnos
    function Agregar_Alumno($Alumno){
        #Agregamos al final de la posicion
        $this->ArrAlumnos[$this->Tamanio]=$Alumno;
        #Incrementamos la cantidad de alumnos
        $this->Tamanio++;
    }
    /* Metodo para eliminar un alumno de la lista*/ 
    function Eliminar_Alumno($Codigo){
        #Indicamos un posicion de donde se va dividir
        $Posicion_Corte=0;
        #Creamos una variable donde indica si se ha eleminado un alumno
        $Eliminado=FALSE;
        #Recorremos la lista de alumnos
        for($x = 0; $x < $this->Tamanio; $x++){
            #Obtenemos un alumno de la posicion x
            $Alumno=$this->ArrAlumnos[$x];
            #Comparamos su el codigo a eliminar con un deternminado alumno
            if($Codigo==$Alumno->get_Codigo()){
                # Si se ha encontrado el alumno le indicaremos si se va eliminar el alumno
                $Eliminado=TRUE;
                # Guardamos la posicion de donde se va eliminar
                $Posicion_Corte=$x;
                #Salimos del bucle
                break;
            }
        }
        # Verificamos si vamos eliminar o no
        if($Eliminado){
            for($x = $Posicion_Corte; $x < $this->Tamanio-1; $x++){
                #Saltamos al elemento siguiente reemplazando el anterior y asi eliminando dicho elemento
                $this->ArrAlumnos[$x]=$this->ArrAlumnos[$x+1];
            }
            #Eliminamos el ultimo elemento porque si no podria generarse repeticion de alumnos
            array_pop($this->ArrAlumnos);
            #Obtenemos el nuevo tamanio
            $this->Tamanio=count($this->ArrAlumnos);
        }
        # Retornamos si se ha eliminado
        return $Eliminado;
    }
}



?>