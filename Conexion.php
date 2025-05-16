<?php
class Conexion {
    private function dbConect(){
        $_servername="localhost";
        $_username="root";
        $_password="";
        $_database="tienda_virtual";
        $_port = 3306; 

        $conn = mysqli_connect($_servername, $_username, $_password, $_database, $_port );
        mysqli_set_charset($conn,'utf8');
        //comprobar conexion
        if (!$conn){
            die("conection failed: ".mysqli_connect_error());
        }
        return $conn;

    }//fin dbconnect
    //creamos un metodo det data para devolver las select
    public function exec_query($sql){
        $mysqli=$this->dbConect();
        $res = $mysqli->query($sql);
        //Cerramos la conexion
        mysqli_close($mysqli);
        return $res;
    }
}
?>
