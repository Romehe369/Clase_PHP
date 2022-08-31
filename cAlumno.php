<?php
class cAlumno{
    private $Codigo;
    private $Nombre;
    #Indica si el alumno es retirado, nuevo, exsistente.
    private $Estado;

    //Metodos como Contructor
    function crearAlumno($Codigo, $Nombre,$Estado){
        $this->Codigo=$Codigo;
        while(strlen($this->Codigo)<6){
            $this->Codigo='0'.$this->Codigo;
        }
        $this->Nombre=$Nombre;
        $this->Estado=$Estado;
    }
    //Metodos Get
    function get_Codigo(){
        return $this->Codigo;
    }
    function get_Nombre(){
        return $this->Nombre;
    }
    function get_Estado(){
        return $this->Estado;
    }
    function ImprimirFila($Estado){
        echo '<tr><th>'.$this->Codigo.'</th><th>'.$this->Nombre.'</th></tr>';
    }
}



?>