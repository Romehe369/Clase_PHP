<?php
class cAlumno{
    ///////////////////// Atributo ////////////////// 
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
    # Obtenemos el codigo del alumno
    function get_Codigo(){
        return $this->Codigo;
    }
     # Obtenemos el nombre del alumno
    function get_Nombre(){
        return $this->Nombre;
    }
    # Mostramos los resultados
    function ImprimirFila(){
        echo '<tr><th>'.$this->Codigo.'</th><th>'.$this->Nombre.'</th></tr>';
    }
}
?>