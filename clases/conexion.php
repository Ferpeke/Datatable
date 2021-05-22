<?php

    class conectar {
        public function conexion() {
            $conexion = mysqli_connect('localhost', 'root', 'Nandodrago4', 'juegos', '33061');
            
            $conexion->set_charset('utf8');
            return $conexion;

        }
    }

    // $obj = new conectar();

    // if ($obj -> conexion()) {
    //     echo "conectado";
    // }

?>