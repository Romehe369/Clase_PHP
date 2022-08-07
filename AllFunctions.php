<?php
function Existe_Alumno($Codigo,$Lista_Alumnos_No_Matriculados){
    $Tamanio=count($Lista_Alumnos_No_Matriculados);
    for($po=0;$po<$Tamanio;$po++){
        if($Codigo==$Lista_Alumnos_No_Matriculados[$po][0]){
            return TRUE;
        }
    }
    return FALSE;
}
function Balancear_Alumnos($Alumnos_Sin_Tutor,$Docentes,$Crear_Array_Multidimencional,$Arreglos){
    $Contador=0;
    #Obtenemos el valor maximo
    $max=max($Arreglos);
    #Obtenemos el valor minimo
    $min=min($Arreglos);
    #Obtenemos una division entera
    $Medio=intdiv($max+$min,2);
    #Completar el numero de elementos
    $Incrementar=$max-$Medio;
    #echo  $Incrementar;
    #Obtenemos el tamanio de nuestro arreglo
    $Tamanio=count($Crear_Array_Multidimencional);
    $Posi_Fin=count($Crear_Array_Multidimencional[$Tamanio-1])+1;
    #Aqui empezamos a completar
    #echo "<br> Posicion cero :".$Alumnos_Sin_Tutor[count($Alumnos_Sin_Tutor)-1][0]."<br>";
    for($i=0;$i<$Tamanio;$i++){
        $Tam_Array=count($Crear_Array_Multidimencional[$i]);
        if($Tam_Array<$Medio){
            $j=0;
            $Posicion=$Tam_Array;
            while($j < $Incrementar){
                #Obtenemos 
                #echo "<br> Valor :".$Alumnos_Sin_Tutor[$Contador][0]." Val :".count($Alumnos_Sin_Tutor);
                $val_doc=substr($Alumnos_Sin_Tutor[$Contador][0], 0, 2);
                if($val_doc == "22"){
                    #echo $val_doc."<br>";
                    $Crear_Array_Multidimencional[$i][$Posicion-1]=$Alumnos_Sin_Tutor[$Contador];
                    #echo " Num: ".$Alumnos_Sin_Tutor[$Contador][0]." Posi : ".$Contador."<br>";
                    $Posicion++;
                    $Contador++;
                    $j++;
                }
                else{
                    $Crear_Array_Multidimencional[$Tamanio-1][$Posi_Fin-1]=$Alumnos_Sin_Tutor[$Contador];
                    $Contador++;
                    $Posi_Fin++;
                    #echo " Num ".$Contador."<br>";
                    #$Tamanio_new++;
                }
            }
        }
    }
    #Asignamos los alumnos restantes a nuestro arreglo final
    $Maximo=count($Alumnos_Sin_Tutor);
    #echo $Maximo." Val : ".count($Alumnos_Sin_Tutor);
    #$ValorInicio=$Contador-1;
    for($x = $Contador; $x < $Maximo; $x++){
        $Crear_Array_Multidimencional[$Tamanio-1][$Posi_Fin]=$Alumnos_Sin_Tutor[$x];
        #echo " Num: ".$Alumnos_Sin_Tutor[$x][0]." Posi : ".$x."<br>";
        $Posi_Fin++;
        #echo $x." Valor :".$Alumnos_Sin_Tutor[$x]."<br>";
    }
    return $Crear_Array_Multidimencional;
}
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
    #Verificamos que el docente sea nuevo
    function Es_Docente_Con_Tutor($Docente,$Docentes_Con_Tutor){
        $Es_Nuevo=TRUE;
        for($pos=0;$pos<$Tamanio;$pos++){
            if($Docente==$Docentes_Con_Tutor[$pos]){
                $Es_Nuevo=FALSE;
            }
        }
        return $Es_Nuevo;
    }
    function Existe_Alumno($Codigo,$Lista_Alumnos_No_Matriculados){
        $Tamanio=count($Lista_Alumnos_No_Matriculados);
        for($pos=0;$pos<$Tamanio;$pos++){
            if($Codigo==$Lista_Alumnos_No_Matriculados[$pos]){
                return TRUE;
            }
        }
        return FALSE;
    }
    #Funcion donde se hace el balanceo
    /*
    Tenemos Alumnos_Sin_tutor que corresponde a los alumnos nuevos y lo que volvieron a tomar
    el curso
     */
    function Balancear($Alumnos_Sin_Tutor,$Docentes,$Distribucion_Tutor_Anterior,$Alumnos_No_Matriculados){
        $Crear_Array_Multidimencional=[];
        $Alumnos_Por_Docentes=[];
        #Tamaño de los arreglos
        $Arreglos=[];
        #Este indice indicara el numero de inicio para el nuevo arreglo
        $Indice=0;
        $Indice_Siguiente=0;
        $Tamanio=count($Distribucion_Tutor_Anterior);
        for($pos = 0; $pos < $Tamanio; $pos++){
            if($Distribucion_Tutor_Anterior[$pos][0]=="Docente"){
                if(strlen($Indice>0)){
                    $Crear_Array_Multidimencional[$Indice_Siguiente]=$Alumnos_Por_Docentes;
                    $Arreglos[$Indice_Siguiente]=count($Alumnos_Por_Docentes);
                    $Indice_Siguiente++;
                }
                $Indice=0;
                $Alumnos_Por_Docentes=[];
            }
            if(count($Distribucion_Tutor_Anterior[$pos])>1){
                #echo $Distribucion_Tutor_Anterior[$pos][0]."<br>";
                if(Existe_Alumno($Distribucion_Tutor_Anterior[$pos][0],$Alumnos_No_Matriculados)==FALSE){
                    $Alumnos_Por_Docentes[$Indice]=$Distribucion_Tutor_Anterior[$pos];
                    $Indice++;
                }
            }
        }
        $Crear_Array_Multidimencional[$Indice_Siguiente]=$Alumnos_Por_Docentes;
        #$Arreglos[$Indice_Siguiente]=count($Alumnos_Por_Docentes);
        #Verificar
        #$Crear_Array_Multidimencional[$Indice_Siguiente]=$Alumnos_Por_Docentes;
        #Balancear los docentes con sus alumnos
        #echo count($Crear_Array_Multidimencional);
        $Resultado=Balancear_Alumnos($Alumnos_Sin_Tutor,$Docentes,$Crear_Array_Multidimencional,$Arreglos);
        $Resultado2=[];
        $Contador=0;
        for($i=0;$i<count($Resultado);$i++){
            $Valor_i=$Resultado[$i];
            $Tam=count($Valor_i);
            for($j=0;$j<$Tam;$j++){
                $Resultado2[$Contador]=$Valor_i[$j];
                $Contador++;
            }
        }
        return $Resultado2;
    }
    function GenerarCSV_No_Considerados($datos){
        $fp = fopen('No_Considerados_En_Tutoria.csv', 'w+');
        // Escribimos los datos en el archivo 'archivo.csv'
        for($x = 0; $x < count($datos); $x++){
            fputcsv($fp, $datos[$x]);
        }
        // Después de terminar de escribir los datos, cerramos el archivo 'archivo.csv'
        fclose($fp);
            
        // Redireccionamos a la página del formulario, le pasamos el estado en 1
        #header('Location: index.php?estado=1');
    }
    #Funcion donde procedemos a guardar los resultados
    function GenerarCSV_Distribucion($datos){
        $fp = fopen('Distribucion_balanceada_tutorias.csv', 'w+');
        // Escribimos los datos en el archivo 'archivo.csv'
        for($x = 0; $x < count($datos); $x++){
            fputcsv($fp, $datos[$x]);
        }
        // Después de terminar de escribir los datos, cerramos el archivo 'archivo.csv'
        fclose($fp);
        
        // Redireccionamos a la página del formulario, le pasamos el estado en 1
        #header('Location: index.php?estado=1');
    }
    
}
?>