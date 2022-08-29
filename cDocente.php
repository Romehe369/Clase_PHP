<?php
class cDocente{
    private $Nombre;
    private $Categoria;
    #Indica si el docente es antiguo
    private $Antiguo;
    //Metodos como Contructor
    function crearDocente($Nombre,$Categoria,$Estado){
        $this->Categoria=$Categoria;
        $Antiguo=FALSE;
        if($Estado){
            $Antiguo=TRUE;
            #Elimianmos el caracter antes
            $Nombre = explode("antes", $Nombre);
            $this->Nombre=$Nombre[1];
        }
        else{
            $this->Nombre=$Nombre;
        }
    }
    //Metodos Get
    function get_Nombre(){
        return $this->Nombre;
    }
    function get_Categoria(){
        return $this->Categoria;
    }
    function get_antes(){
        return $this->Antiguo;
    }
    function ImprimirFila($Estado){
        if($Estado="Actual"){
            if($this->Antiguo==FALSE){
                echo '<tr><th>'.$this->Nombre.'</th><th>'.$this->Categoria.'</th></tr>';
            }
        }
        else{
            echo '<tr><th>'.$this->Nombre.'</th><th>'.$this->Categoria.'</th></tr>';
        }
    }
}
?>