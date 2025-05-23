<?php

class Crud {
    public mysqli $con;

    public function __construct($user,$passdb,$host) {
        $this->con = new mysqli($host,$user,$passdb);
    }

    public function connectDb($nombreDb) {
        if ($this->con) {
            $this->con->select_db($nombreDb);
        } else {
            die("No se puede seleccionar la base de datos proporcionada: ".$nombreDb);
        }
    }

    public function closeCon() {
        $this->con->close();
    }

    public function __destruct() {
        $this->closeCon();
    }

    public function checkLogin(string $username, string $password): bool {
        try {
            $query = "SELECT password_hash FROM cuentas WHERE email = ?";
            
            $stmt = $this->con->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();

            if ($result) {
                return password_verify($password, $result['password_hash']);
            }
        } catch (mysqli_sql_exception $e) {
            error_log('Error al consultar la base de datos: ' . $e->getMessage());
        }

        return false;
    }

    public function storageUser(string $username): bool {
        try {
            
            $queryCuenta = "SELECT id, email, rol FROM cuentas WHERE email = ?";
            $stmtCuenta = $this->con->prepare($queryCuenta);
            $stmtCuenta->bind_param('s', $username);
            $stmtCuenta->execute();
            $resultCuenta = $stmtCuenta->get_result()->fetch_assoc();

            if ($resultCuenta) {
                switch ($resultCuenta['rol']) {
                    case 'ADMIN':
                        $_SESSION['usuario'] = [
                            'id' => $resultCuenta['id'],
                            'email' => $resultCuenta['email'],
                            'rol' => $resultCuenta['rol']
                        ];
                        break;

                    case 'CLIENTE':
                        $queryCliente = "SELECT cuenta_id, nombre, apellido1, apellido2, telefono, permisos_informes FROM clientes WHERE cuenta_id = ?";
                        $stmtCliente = $this->con->prepare($queryCliente);
                        $stmtCliente->bind_param('i', $resultCuenta['id']); // Usar 'i' para integers
                        $stmtCliente->execute();
                        $resultCliente = $stmtCliente->get_result()->fetch_assoc();

                        if ($resultCliente) {
                            $_SESSION['usuario'] = [
                                'id' => $resultCliente['cuenta_id'],
                                'email' => $resultCuenta['email'],
                                'rol' => $resultCuenta['rol'],
                                'nombre' => $resultCliente['nombre'],
                                'apellido1' => $resultCliente['apellido1'],
                                'apellido2' => $resultCliente['apellido2'] ?? '',
                                'telefono' => $resultCliente['telefono'] ?? ''
                            ];
                        } else {
                            return false;
                        }
                        break;

                    case 'NEGOCIO':
                        $queryNegocio = "SELECT cuenta_id, nombre_comercial, permisos_terminos FROM negocios WHERE cuenta_id = ?";
                        $stmtNegocio = $this->con->prepare($queryNegocio);
                        $stmtNegocio->bind_param('i', $resultCuenta['id']); // Usar 'i' para integers
                        $stmtNegocio->execute();
                        $resultNegocio = $stmtNegocio->get_result()->fetch_assoc();

                        if ($resultNegocio) {
                            $_SESSION['usuario'] = [
                                'id' => $resultNegocio['cuenta_id'],
                                'email' => $resultCuenta['email'],
                                'rol' => $resultCuenta['rol'],
                                'nombre_negocio' => $resultNegocio['nombre_comercial']
                            ];
                        } else {
                            return false;
                        }
                        break;

                    default:
                        return false;
                }

                return true;
            }

        } catch (mysqli_sql_exception $e) {
            var_dump(''. $e->getMessage());
            error_log('Error al consultar la base de datos: ' . $e->getMessage());
        }

        return false;
    }

    public function registrarUsuarioCliente(string $nombre, string $apellidos, string $email, string $password, bool $informes, bool $terminos): bool {
        return true;
    }

}

?>