<?php
class cDocente{
    # Nombre del docente
    private $Nombre;
    # Atributo de categoria
    private $Categoria;
    //Metodos como Contructor de cDocente
    function crearDocente($Nombre,$Categoria){
        $this->Categoria=$Categoria;
        $this->Nombre=$Nombre;
    }
    //Metodos Get
    # Obtenemos el nombre del docente
    function get_Nombre(){
        return $this->Nombre;
    }
    # Obtenemos la categoria del docente
    function get_Categoria(){
        return $this->Categoria;
    }
    # Asiganmos una categoria a docente
    function set_Categoria($Categoria){
        $this->Categoria= $Categoria;
    }
    //Metodos to
    function to_Array(){
        return array($this->Nombre,$this->Categoria);
    }
    # Imprimimos los resultados
    function ImprimirFila(){
        echo '<tr><th>'.$this->Nombre.'</th><th>'.$this->Categoria.'</th></tr>';
    }
}
?>