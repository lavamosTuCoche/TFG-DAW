<?php

include_once 'functions.php';


    class CRUD {
 
        public ?mysqli $con = null;

        public function crearCuenta( $email,$passwordHash):bool {

            $sqlCuenta = "INSERT INTO CUENTAS (EMAIL, PASSWORD, FECHA_REGISTRO) VALUES (?, ?, NOW())";
            $stmtCuenta = $this->con->prepare($sqlCuenta);
            
            if (!$stmtCuenta) {
                throw new Exception("Error al preparar la consulta de cuenta: " . $this->con->error);
                return false;
            }
    
            $stmtCuenta->bind_param("ss", $email, $passwordHash);
            
            if (!$stmtCuenta->execute()) {
                throw new Exception("Error al registrar la cuenta: " . $stmtCuenta->error);
                return false;
            }

            return true;
        }

        public function crearCliente( $email, $nombre, $apellido1, $apellido2, $imagen, $permisosInformes, $permisosTerminos):bool { 
            
            $sqlCliente = "INSERT INTO CLIENTES (EMAIL, NOMBRE, APELLIDO1, APELLIDO2, 
                IMAGEN, PERMISOS_INFORMES, PERMISOS_TERMINOS
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
            $stmtCliente = $this->con->prepare($sqlCliente);
                
            if (!$stmtCliente) {
                throw new Exception("Error al preparar la consulta de cliente: " . $this->con->error);
                return false;
            }
        
            $stmtCliente->bind_param(
                "sssssii",
                $email,
                $nombre,
                $apellido1,
                $apellido2,
                $imagen,
                $permisosInformes,
                $permisosTerminos
            );
        
            if (!$stmtCliente->execute()) {
                throw new Exception("Error al registrar el cliente: " . $stmtCliente->error);
                return false;
            }

            return true;
        }

        public function registrarUsuarioCliente(
            string $nombre,string $apellidos,string $email,
            string $password,bool $permisosInformes,
            bool $permisosTerminos,?string $imagen = 'img/clienteDefault.jpg'
        ): bool {
            try {
        
                $this->con->begin_transaction();
        
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $apellidosSeparados = separarApellidos($apellidos);
                $apellido1 = $apellidosSeparados[0];
                $apellido2 = $apellidosSeparados[1];
                $permisosInformes = ($permisosInformes === 'on')? 0 : 1;
                $permisosTerminos = ($permisosTerminos === 'on')? 0 : 1;
                
                $resultCuenta = $this->crearCuenta($email,$passwordHash);

                if ( !$resultCuenta ) {
                    return false;
                }

                $resultCliente = $this->crearCliente($email,$nombre,$apellido1,$apellido2,$imagen,$permisosInformes,$permisosTerminos);
        
                if ( !$resultCliente ) {
                    return false;
                }

                $this->con->commit();
                return true;
        
            } catch (Exception $e) {
                if (isset($this->con)) {
                    $this->con->rollback();
                }
                echo $this->con->error;
                return false;
            }
        }

        function registrarUsuarioNegocio() {

            

        }

        function registrarUsuarioAdmin() {

            

        }

        function abrirConexion($host,$username,$password,$dbname) {
            $this->con = new mysqli($host,$username,$password,$dbname);
        }

        function cerrarConexion() {
            if ($this->con) {
                $this->con->close();
            }
        }
        

    }

    $crud = new CRUD();

?>