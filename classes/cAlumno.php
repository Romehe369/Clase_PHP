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
    function get_AnioCodigo(){
        echo "anio";
        return $this->Codigo[0].$this->Codigo[1];
    }
    //Metodos Extras
    function to_Array(){
        return array($this->Codigo,$this->Nombre);
    }
    function ImprimirFila(){
        echo '<tr><th>'.$this->Codigo.'</th><th>'.$this->Nombre.'</th></tr>';
    }
}
?>