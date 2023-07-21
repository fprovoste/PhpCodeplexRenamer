<?php

require "./vendor/autoload.php";

$people_json = file_get_contents('releaseList.json');

$json = json_decode($people_json);

$elementos = collect($json);

$elementos->each(function ($elemento){
    $carpeta = $elemento->Id;
    $descripcion = $elemento->Description;
    $txtDescripcion = ".".DIRECTORY_SEPARATOR.$carpeta.DIRECTORY_SEPARATOR."Descripcion.txt";
    if (!file_exists($txtDescripcion))
    {
        file_put_contents($txtDescripcion,$descripcion);
    }
    $archivos = collect($elemento->Files);
    $archivos->each(function ($archivo) use($carpeta)
    {
        if (file_exists($archivo->Url))
        {
            $nuevoArchivo = "./".$carpeta."/".$archivo->FileName;

            //echo $archivo->Url . " -> ".$nuevoArchivo. "\n";
            rename($archivo->Url,$nuevoArchivo);
        }
    });
});

