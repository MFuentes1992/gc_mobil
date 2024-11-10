## --- Get All active visits by Owner
SELECT 
	v.nombre_visita as nombre,
	v.fecha_ingreso as desde, 
	v.fecha_salida as hasta,
 	ti.tipo_ingreso as tipo, 
	v.multiple_entrada as acceso, 
	v.notificaciones as avisos, 
	u.email,
	tv.tipo_visita,
	v.uniqueID,
    v.estatus_registro as estado
FROM visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id
JOIN lst_tipo_ingreso_visita as ti 
ON v.id_tipo_ingreso = ti.id
JOIN lst_tipo_visita as tv
ON v.id_tipo_visita = tv.id
WHERE u.email = 'rocio@email.com' AND v.estatus_registro = 1

## --- Get all active visits By Type

SELECT
        v.nombre_visita as nombre,
        v.fecha_ingreso as desde,
        v.fecha_salida as hasta,
        ti.tipo_ingreso as tipo,
        v.multiple_entrada as acceso,
        v.notificaciones as avisos,
        u.email,
        tv.tipo_visita,
        v.uniqueID,
    v.estatus as estado
FROM visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id
JOIN lst_tipo_ingreso_visita as ti
ON v.id_ingreso = ti.id
JOIN lst_tipo_visita as tv
ON v.id_tipo_visita = tv.id
WHERE tv.id = 1 AND v.estatus = 1

## -- Get all active visits by Date
SELECT
        v.nombre_visita as nombre,
        v.fecha_ingreso as desde,     
        v.fecha_salida as hasta,
        ti.tipo_ingreso as tipo,
        v.multiple_entrada as acceso,
        v.notificaciones as avisos,
        u.email,
        tv.tipo_visita,
        v.uniqueID,
    v.estatus as estado
FROM visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id   
JOIN lst_tipo_ingreso_visita as ti
ON v.id_ingreso = ti.id  
JOIN lst_tipo_visita as tv  
ON v.id_tipo_visita = tv.id
WHERE CAST(v.fecha_ingreso as DATE) BETWEEN '2024-01-10' and '2024-01-31' AND v.estatus = 1

## -- Get All Historical Visits
SELECT
        v.nombre_visita as nombre,
        v.fecha_ingreso as desde,     
        v.fecha_salida as hasta,
        ti.tipo_ingreso as tipo,
        v.multiple_entrada as acceso,
        v.notificaciones as avisos,
        u.email,
        tv.tipo_visita,
        v.uniqueID,
    v.estatus as estado
FROM tbl_visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id   
JOIN lst_TipoIngreso as ti
ON v.id_ingreso = ti.id  
JOIN lst_TipoVisita as tv  
ON v.id_tipo_visita = tv.id
WHERE CAST(v.fecha_ingreso as DATE) < NOW()

## -- GET visit by uniqueID
SELECT
        v.nombre_visita as nombre,
        v.fecha_ingreso as desde,     
        v.fecha_salida as hasta,
        ti.tipo_ingreso as tipo,
        v.multiple_entrada as acceso,
        v.notificaciones as avisos,
        u.email,
        tv.tipo_visita,
        v.uniqueID,
    v.estatus as estado
FROM tbl_visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id   
JOIN lst_TipoIngreso as ti
ON v.id_ingreso = ti.id  
JOIN lst_TipoVisita as tv  
ON v.id_tipo_visita = tv.id
WHERE v.uniqueID = '64a3498d-1299-4bc2-ae0f-07b3867d7bb1' AND v.estatus = 1

## -- Get All visits By Residence
SELECT
        v.nombre_visita as nombre,
        v.fecha_ingreso as desde,
        v.fecha_salida as hasta,
        ti.tipo_ingreso as tipo,
        v.multiple_entrada as acceso,
        v.notificaciones as avisos,
        u.email,
        tv.tipo_visita,
        v.uniqueID,
	i.seccion as manzana,
	i.numero as num_int,
	r.nombre as residencial,
	r.calle as calle,
	r.numero_ext as num_ext,
	r.colonia as colonia,
	r.ciudad as ciudad,
	r.estado as estado,
	r.codigo_postal as cp,
    v.estatus as estado
FROM tbl_visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id
JOIN lst_TipoIngreso as ti
ON v.id_ingreso = ti.id
JOIN lst_TipoVisita as tv
ON v.id_tipo_visita = tv.id
JOIN instalaciones as i
ON i.id = u.id_instalacion
JOIN recintos as r
ON r.id = i.id_recinto
WHERE i.id = 1 AND v.estatus = 1

## -- Get All visits by residence numer and land owner
SELECT
        v.nombre_visita as nombre,
        v.fecha_ingreso as desde,
        v.fecha_salida as hasta,
        ti.tipo_ingreso as tipo,
        v.multiple_entrada as multiple_entrada,
        v.notificaciones as notificaciones,
        u.email as emailAutor,
        tv.tipo_visita,
        v.uniqueID,
        i.seccion as seccion,
        i.numero as num_int,
        r.nombre as residencial,
        r.calle as calle,
        r.numero_ext as num_ext,
        r.colonia as colonia,
        r.ciudad as ciudad,
        r.estado as estado,
        r.codigo_postal as cp,
    v.estatus_registro as estado
FROM visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id
JOIN lst_tipo_ingreso_visita as ti 
ON v.id_tipo_ingreso = ti.id    
JOIN lst_tipo_visita as tv  
ON v.id_tipo_visita = tv.id
JOIN instalaciones as i
ON i.id = u.id_instalacion
JOIN recintos as r
ON r.id = i.id_recinto
WHERE i.id = 50 and u.email = 'rocio@email.com' AND v.estatus_registro = 1

## -- Get All visits by residence numer and land owner and type of visits
SELECT
        v.nombre_visita as nombre,
        v.fecha_ingreso as desde,
        v.fecha_salida as hasta,
        ti.tipo_ingreso as tipo,
        v.multiple_entrada as multiple_entrada,
        v.notificaciones as notificaciones,
        u.email as emailAutor,
        tv.tipo_visita,
        v.uniqueID,
        i.seccion as seccion,
        i.numero as num_int,
        r.nombre as residencial,
        r.calle as calle,
        r.numero_ext as num_ext,
        r.colonia as colonia,
        r.ciudad as ciudad,
        r.estado as estado,
        r.codigo_postal as cp,
    v.estatus_registro as estado
FROM visitas as v RIGHT JOIN users as u
ON v.id_usuario =  u.id
JOIN lst_tipo_ingreso_visita as ti 
ON v.id_tipo_ingreso = ti.id    
JOIN lst_tipo_visita as tv  
ON v.id_tipo_visita = tv.id
JOIN instalaciones as i
ON i.id = u.id_instalacion
JOIN recintos as r
ON r.id = i.id_recinto
WHERE i.id = 50 and u.email = 'rocio@email.com' AND v.estatus_registro = 1 AND tv.id = 1


SELECT 
	i.seccion as manzana,
    i.numero as num_int,
    r.nombre as residencial,
    r.calle as calle,
    r.numero_ext as num_ext,
    r.colonia as colonia,
    r.ciudad as ciudad,
    r.estado as estado,
    r.codigo_postal as cp
FROM instalaciones as i LEFT JOIN recintos as r
ON r.id = i.id_recinto
WHERE i.id in (3,13) AND i.estatus_registro = 1


# ---- SP to expire visitas

DELIMITER //
CREATE PROCEDURE expire_visita()
BEGIN
	UPDATE visitas 
    SET estatus_registro = 0
    WHERE fecha_salida < NOW();
END //
DELIMITER ;



SET GLOBAL event_scheduler = ON;

CREATE EVENT visitas_scheduler
ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 MINUTE
ON COMPLETION PRESERVE
DO 
CALL expire_visita();


# ---- GET Casetas & Codes
SELECT 
    cv.id,
    cv.id_caseta,
    cv.codigo_activacion,
    cv.estatus_registro,
    cv.estatus_uso,
    c.caseta,
    c.numero_celular,
FROM codigo_activacion as cv LEFT JOIN info_caseta_vigilancia as c
ON cv.id_caseta = c.id
WHERE codigo_activacion = '%s' AND cv.estatus_registro = 1


// --- Adeudos by instalacion
SELECT 
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
 WHERE pagado = 0 AND id_instalacion = 1


// -- Vigilantes, Get Recinto and Caseta info

SELECT 
    c.numero_celular,
    c.numero_telefono,
    c.extension_telefono,
    r.nombre,
    r.logo,
    CONCAT(r.calle, ' ', r.numero_ext, ', ', r.colonia, ', ', r.ciudad, ', ', r.codigo_postal, ', ', r.estado) as direccion
FROM info_caseta_vigilancia as c
LEFT JOIN recintos as r
ON c.id_recinto = r.id
LEFT JOIN codigos_vigilancia as cv
ON c.id = cv.id_caseta
WHERE cv.codigo_activacion = "UGG3IRXE5E" AND c.estatus_registro = 1 AND r.estatus_registro = 1

# --- GET Instalaciones - user data by recinto and active status
SELECT 
	i.id as idInstalacion,
    i.seccion,
    i.numero as numInt,
    usersInfo.id as idUsuario,
    usersInfo.name as owner
FROM instalaciones as i
INNER JOIN 
(
SELECT
  users.id,
  users.id_profile,
  SUBSTRING_INDEX(SUBSTRING_INDEX(users.id_instalacion, ',', numbers.n), ',', -1) idInstalacion,
  users.name,
  users.email,
  users.status
FROM
  (SELECT 1 n UNION ALL SELECT 2
   UNION ALL SELECT 3 UNION ALL SELECT 4) numbers INNER JOIN users
  ON CHAR_LENGTH(users.id_instalacion)
     -CHAR_LENGTH(REPLACE(users.id_instalacion, ',', ''))>=numbers.n-1
ORDER BY
  id, n
) usersInfo
ON i.id = usersInfo.idInstalacion
WHERE i.id_recinto = 1 and usersInfo.status = 1 AND i.estatus_registro = 1
    