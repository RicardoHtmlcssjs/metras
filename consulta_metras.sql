SELECT cedula, nombre, apellido, genero, correo, telefono, nombre_mesa, descripcion_estado, descripcion_municipio, codigo_situr , nombre_consejo_comunal, poblacion_impactar, capacidad_toneladas
from usuarios
INNER JOIN mesas ON pk_mesa=fk_mesa 
INNER JOIN consejos_comunales ON pk_consejo_comunal=fk_consejo_comunal 
INNER JOIN estado ON pk_estado=fk_estado
INNER JOIN municipio ON pk_municipio=fk_municipio
where fk_privilegio=1
ORDER BY descripcion_estado, nombre_mesa; ---perfecta para números de teléfonos ***este es el que uso para el listado del jefe
-----------------------
---------------

SELECT cedula, nombre, apellido, genero,
CASE fk_privilegio
           WHEN 1
           THEN 'Encargado'
           WHEN 2
           THEN 'Colaborador'
           WHEN 3
           THEN 'Administrador'   
           WHEN 4
           THEN 'Transcriptor'  
           WHEN 5
           THEN 'Técnico'         
           ELSE 'Estatus desconocido'
       END AS laboracomo,
 correo, telefono, nombre_mesa, descripcion_estado, descripcion_municipio, codigo_situr , nombre_consejo_comunal, poblacion_impactar, capacidad_toneladas
from usuarios
INNER JOIN mesas ON pk_mesa=fk_mesa 
INNER JOIN consejos_comunales ON pk_consejo_comunal=fk_consejo_comunal 
INNER JOIN estado ON pk_estado=fk_estado
INNER JOIN municipio ON pk_municipio=fk_municipio
ORDER BY descripcion_estado, nombre_mesa, fk_privilegio; ---perfecta para todos las pérsonas registradas en metras

----------------------