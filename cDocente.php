<?php
class cDocente{
    private $Nombre;
    private $Categoria;
    //Metodos como Contructor
    function crearDocente($Nombre,$Categoria){
        $this->Categoria=$Categoria;
        $this->Nombre=$Nombre;
    }
    //Metodos Get
    function get_Nombre(){
        return $this->Nombre;
    }
    function get_Categoria(){
        return $this->Categoria;
    }
    function ImprimirFila(){
        echo '<tr><th>'.$this->Nombre.'</th><th>'.$this->Categoria.'</th></tr>';
    }
}
?>