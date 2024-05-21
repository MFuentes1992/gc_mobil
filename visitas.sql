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
