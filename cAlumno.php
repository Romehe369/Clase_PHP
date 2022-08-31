<?php
class cAlumno{
    private $Codigo;
    private $Nombre;
    #Indica si el alumno es retirado, nuevo, exsistente.

    //Metodos como Contructor
    function crearAlumno($Codigo, $Nombre){
        $this->Codigo=$Codigo;
        #Actualizamos el codigo a 6 digitos
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
    function ImprimirFila(){
        echo '<tr><th>'.$this->Codigo.'</th><th>'.$this->Nombre.'</th></tr>';
    }
}
?>