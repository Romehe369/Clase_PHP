<?php
class cAlumno{
    #El atributo identificador
    private $Codigo;
    # En esta variable se guarda nombres y apellidos
    private $Nombre;
    //Metodos como Contructor
    function crearAlumno($Codigo, $Nombre){
        $this->Codigo=$Codigo;
        while(strlen($this->Codigo)<6){
            $this->Codigo='0'.$this->Codigo;
        }
        $this->Nombre=$Nombre;
    }
    //Metodos Get
    function get_Codigo(){
        return $this->Codigo;
    }
    function get_Nombre(){
        return $this->Nombre;
    }
    #Imprimimos los nombres del aalumnos
    function ImprimirFila(){
        echo '<tr><th>'.$this->Codigo.'</th><th>'.$this->Nombre.'</th></tr>';
    }
}



?>