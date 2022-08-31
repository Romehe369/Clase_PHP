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
        # Alumnos de tutoria de un docente
        $this->ArrAlumnos=$ArrAlumnos;
        #Obtenemos la cantidad de alumnos
        $this->Tamanio=count($ArrAlumnos);
    }
    //Imprimimos alumnos de un docente
    function ImprimirDocenteAlumnos(){
        # Creamos un docente nuevo
        $AuxDocente = new cDocente();
        # Creamos un dato de informacion de categoria y numero de alumnos
        $AuxDocente->crearDocente($this->Docente->get_Nombre(), $this->Docente->get_Categoria()." NRO DE ALUMNOS : ".$this->Tamanio);
        #Modificamos el docente con sus categoria y numero de alumnos
        $this->Docente=$AuxDocente;  
        # Procedemos a mostrar el docente
        $this->Docente->ImprimirFila();
        # Procedemos a mostrar sus alumnos
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
    # Metodo para cambiar los alumnos de un determinado docente tutor
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
    #Esta funcion es para eliminar un alumno por codigo
    function EliminarAlumno($Codigo){
        # Nos indica el posicion de corte o eliminacion
        $Posicion_Corte=0;
        # Booleano donde se almacena si existe alumno y sera eliminado
        $Eliminado=FALSE;
        # Recorremos los alumnos de dicha clase de tutoria
        for($x = 0; $x < $this->Tamanio; $x++){
            # Obtenemos un alumno de la posicion x
            $Alumno=$this->ArrAlumnos[$x];
            # Verificamos si el codigo coincide con algun alumno
            if($Codigo==$Alumno->get_Codigo()){
                # Inidcamos que se ha encontrado para eliminarlo
                $Eliminado=TRUE;
                $Posicion_Corte=$x;
                break;
            }
        }
        if($Eliminado){ #Verificamos si se va eliminar
            for($x = $Posicion_Corte; $x < $this->Tamanio-1; $x++){
                #El alumno de la posicion de corte sera reemplazado popr el siguiente alumno
                $this->ArrAlumnos[$x]=$this->ArrAlumnos[$x+1];
            }
            # Eliminamos la ultimo posicion para no generar repetidos
            array_pop($this->ArrAlumnos);
            # Calculamos el nuevo tamanio
            $this->Tamanio=count($this->ArrAlumnos);
        }
        return $Eliminado;
    }
}
?>