<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class UserModel extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getUserByEmail(string $email) {
            try {                
                $query = sprintf("SELECT u.id, u.name, u.id_profile, u.email, u.id_instalacion, u.password FROM users as u WHERE u.email = '%s' AND status = 1", $email);                
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }            
        }

        public function getProfiles(string $email) {
            try {
                $query = sprintf("SELECT 
                    u.id_profile, 
                    ui.foto 
                FROM users as u 
                JOIN users_informacion as ui
                ON u.id = ui.id_user
                WHERE u.email = '%s' AND u.status = 1", $email);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function changePassword(string $email, string $newPassword) {
            try {
                $query = sprintf("UPDATE users SET password = '%s', updated_at = NOW() WHERE email = '%s'", $newPassword, $email);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function getInstalacionDebt(int $instalacion) {
            try {
                $query = sprintf("SELECT 
                    cr.id, 
                    cr.id_instalacion, 
                    cr.id_residente, 
                    cr.monto_pendiente, 
                    IF(crt.descripcion IS NULL, ca.descripcion, crt.descripcion) AS descripcion, 
                    IF(crt.id_tipo_recargo = 2 AND CURDATE() >= crt.fecha_aplicacion_recargo, 
                    IF(crt.id_tipo_monto_recargo = 2, 
                    crt.recargo_monto, (crt.recargo_monto/100)*crt.monto), 0.00) AS recargo, 
                    IF(crt.id_tipo_descuento = 2 AND CURDATE() <= crt.fecha_aplicacion_descuento, 	                 
                    IF(crt.id_tipo_monto_descuento = 2, 
                    crt.monto_descuento, (crt.monto_descuento/100)*crt.monto), 0.00) AS descuento 
                FROM cuotas_residente cr 
                LEFT JOIN cuotas_recurrentes crt 
                ON cr.id_cuota_recurrente = crt.id 
                LEFT JOIN cuotas_adicionales ca 
                ON cr.id_cuota_adicional = ca.id 
                WHERE pagado = 0 AND id_instalacion = %d", $instalacion);
                return $this->execQuery($query);
            }catch(\Throwable $th) {
                echo $th;
            }
        }

        public function getInstalacionEquity(int $instalacion) {
            try {
                $query = sprintf("SELECT (IFNULL(SUM(ia.monto_disponible), 0)+(IFNULL((select sum(sf.monto_disponible) 
                    FROM saldos_a_favor sf WHERE sf.id_instalacion = %d), 0))) AS monto_disponible 
                    FROM ingresos_asignados ia WHERE ia.id_instalacion = %d", $instalacion, $instalacion);
                return $this->execQuery($query);
            }catch(\Throwable $th) {
                echo $th;
            }
        }
    }
?>