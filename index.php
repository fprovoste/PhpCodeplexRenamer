<?php

require "./vendor/autoload.php";
$rootDir = "./releases/";
$releaseListFile = $rootDir."releaseList.json";
$people_json = file_get_contents($releaseListFile);

$json = json_decode($people_json);

$elementos = collect($json);

$elementos->each(function ($elemento) use($rootDir){
    $carpeta = $elemento->Id;
    $nuevoNombreCarpeta = $elemento->Name;
    $descripcion = $elemento->Description;
    $txtDescripcion = "$rootDir.".DIRECTORY_SEPARATOR.$carpeta.DIRECTORY_SEPARATOR."Descripcion.txt";
    if (!file_exists($txtDescripcion))
    {
        file_put_contents($txtDescripcion,$descripcion);
    }
    $archivos = collect($elemento->Files);
    $archivos->each(function ($archivo) use($rootDir,$carpeta)
    {
        if (file_exists($rootDir."/".$archivo->Url))
        {
            $nuevoArchivo = "$rootDir./".$carpeta."/".$archivo->FileName;
            echo $archivo->Url . " -> ".$nuevoArchivo. "\n";
            rename($rootDir."/".$archivo->Url,$nuevoArchivo);
        }
    });
    rename("$rootDir./".$carpeta,"$rootDir./".$nuevoNombreCarpeta);
});

