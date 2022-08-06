<?php
class Group73{
    #Indicara que funcion realizara
    function csv_Array($file,$Num){
        $tmp      = $file["tmp_name"];
        #$filename = $file["name"];
        $size     = $file["size"];
        if ($size < 0) {
            throw new Exception("Selecciona un archivo válido por favor.");
        }
        $fila = 0;
        #Vamos abrir los archivos 
        if (($gestor = fopen($tmp, "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                //echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
                #Creamos un arreglo Bidimencional 
                $val_doc=substr($datos[0], 0, 7);
                if($Num==3 and strlen($datos[1])>1){
                    if((strtolower($datos[0]) != "codigo" and strtolower($datos[1]) != "codigo"  and $datos[0]!="Nuevo Tutorado")){
                        if($val_doc == "Docente"){
                            $Arreglo[$fila][0]=$val_doc;
                            $Arreglo[$fila][1]=$datos[1];
                        }
                        else{
                            $Arreglo[$fila][0]=$datos[0];
                            $Arreglo[$fila][1]=$datos[1];
                        }
                        $fila++;
                    }
                }
                else
                {
                    if(strlen($datos[1])>1 and ($val_doc != "Docente" and strtolower($datos[0]) != "codigo" 
                    and strtolower($datos[1]) != "codigo"  and $datos[0]!="Nuevo Tutorado")){
                        if(strlen($datos[0])>=4){
                            $Arreglo[$fila][0]=$datos[0];
                            $Arreglo[$fila][1]=$datos[1];
                        }
                        else{
                            $Arreglo[$fila][0]=$datos[1];
                            $Arreglo[$fila][1]=$datos[2];
                        }
                        $fila++;
                    }  
                }
            }
            fclose($gestor);
        }
        return $Arreglo;
    }
    function Imprimir($Array){
        if(!empty($Array)){
            $Pos=0;
            for($row = 0; $row < count($Array); $row++){
                $Pos++;
                echo '<tr><th>'.$Pos.'</th><th>'.$Array[$row][0].'</th><th>'.$Array[$row][1].'</th></tr>';
            }
        }
    }
    function Diferencia($ArrA,$ArrB){
        $fila=0;
        $Arreglo=array();
        for($x = 0; $x < count($ArrA); $x++){
            $Existe=false;
            for($y = 0; $y < count($ArrB); $y++){
                if($ArrA[$x][0]==$ArrB[$y][0]){
                    $Existe=true;
                    break;
                }
            }
            if($Existe==false){
                $Arreglo[$fila][0]=$ArrA[$x][0];
                $Arreglo[$fila][1]=$ArrA[$x][1];
                $fila++;
            }
        }
        return $Arreglo;
    }
    #Funcion donde se hace el balanceo
    /*
    Tenemos Alumnos_Sin_tutor que corresponde a los alumnos nuevos y lo que volvieron a tomar
    el curso
     */
    function Balancear($Alumnos_Sin_Tutor,$Docentes,$Distribucion_Tutor_Anterior){
        #$Crear_Array_Multidimencional=[][];
        $Alumnos_Por_Docentes=[];
        #Este indice indicara el numero de inicio para el nuevo arreglo
        $Indice=0;
        $Indice_Siguiente=0;
        $Tamanio=count($Distribucion_Tutor_Anterior);
        for($pos = 0; $pos < $Tamanio; $pos++){
            if($Distribucion_Tutor_Anterior[$pos][0]=="Docente"){
                $Indice=0;
                if(strlen($Indice>0)){
                    $Crear_Array_Multidimencional[$Indice_Siguiente]=$Alumnos_Por_Docentes;
                    $Indice_Siguiente++;
                }
            }
            if(strlen($Distribucion_Tutor_Anterior[$pos])>1){
                $Alumnos_Por_Docentes[$Indice]=$Distribucion_Tutor_Anterior[$pos];
                $Indice++;
            }
        }
    }
    #Funcion donde procedemos a guardar los resultados
    function GenerarCSV($datos){

        // Creamos y abrimos un archivo con el nombre 'archivo.csv' para escribir los datos que recibimos del formulario
        if (unlink('archivo.csv')){
            // file was successfully deleted
            $fp = fopen('archivo.csv', 'a');
            // Escribimos los datos en el archivo 'archivo.csv'
            for($x = 0; $x < count($datos); $x++){
                fputcsv($fp, $datos[$x]);
            }
            // Después de terminar de escribir los datos, cerramos el archivo 'archivo.csv'
            fclose($fp);
            
            // Redireccionamos a la página del formulario, le pasamos el estado en 1
            #header('Location: index.php?estado=1');
            exit();
        } 
        else{
            // there was a problem deleting the file
        }
    }
}
?>