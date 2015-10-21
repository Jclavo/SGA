-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2015 a las 05:18:22
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sga`
--

DROP DATABASE IF EXISTS `sga`;
CREATE DATABASE IF NOT EXISTS `sga` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sga`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_anio_academico_actual`(
OUT vin_anio_academico_id INT)
BEGIN
	
    declare var_anio_academico INT;
    
	select id
			from anio_academico
		where activo = 1
			and estado = 1
				into var_anio_academico;
    
    SET vin_anio_academico_id = var_anio_academico;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_anio_academico_obtenerActual`()
BEGIN
	select id,anio
		from anio_academico
			where activo = 1
				and estado = 1
					limit 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrera_agregar`(
IN vin_nombre VARCHAR(50),
IN vin_estado INT,
IN vin_usuario_creacion INT
)
BEGIN
	
    DECLARE var_carrera_id int;
    DECLARE var_existe_carrera int;
    
    select count(id)
		 from carrera
		 where nombre = vin_nombre
			and estado != 2
				into var_existe_carrera;
    
    if (var_existe_carrera = 0) then
		INSERT INTO carrera(
							nombre,
							estado,
							fecha_creacion,
							usuario_creacion) 
					VALUES(
							vin_nombre,
							vin_estado,
							now(),
							vin_usuario_creacion);
		
		SET var_carrera_id  = LAST_INSERT_ID();
		
		SELECT 1 as vout_resultado, "Carrera insertada correctamente." as vout_mensaje, var_carrera_id as id;
	else
		SELECT 0 as vout_resultado, "Carrera ya existe." as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrera_editar`(
IN vin_id INT,
IN vin_nombre VARCHAR(50),
IN vin_estado INT
)
BEGIN

	DECLARE var_carrera_id int;
    DECLARE var_existe_carrera int;
    
    select count(id)
		 from carrera
		 where nombre = vin_nombre
			and id != vin_id
			and estado != 2
				into var_existe_carrera;
                
    if (var_existe_carrera = 0) then            
                
		UPDATE carrera
			SET nombre = vin_nombre,
				estado = vin_estado
				WHERE id= vin_id;
		
		SELECT 1 as vout_resultado, "Carrera actualizada correctamente" as vout_mensaje;
    else
		SELECT 0 as vout_resultado, "Carrera ya existe." as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrera_eliminar`(
IN vin_id INT
)
BEGIN
	UPDATE carrera
		SET estado = 2
			WHERE id = vin_id;		
            
	SELECT 1 as vout_resultado, "Carrera eliminada correctamente" as vout_mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrera_getById`(
OUT vin_nombre VARCHAR(50),
IN vin_id INT)
BEGIN
	SELECT nombre
    FROM carrera
	WHERE id = vin_id
	AND estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrera_getByNombre`(
OUT vout_id INT,
IN vin_nombre VARCHAR(50)
)
BEGIN
	SELECT id
    FROM carrera
    WHERE nombre = vin_nombre
    AND estado = 1
    INTO vout_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrera_obtener`()
BEGIN
	SELECT c.id, c.nombre, c.estado
    FROM carrera c
    WHERE c.estado != 2
    order by c.nombre asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carrera_obtenerXDocente`(
IN vin_usuario_id int)
BEGIN
SELECT c.id, c.nombre
    FROM carrera c
		inner join usuario_carrera uc on uc.carrera_id = c.id
        inner join usuario u on u.id = uc.usuario_id
    WHERE u.id = vin_usuario_id
    and c.estado = 1
    and uc.estado = 1
    and u.estado = 1
    order by c.nombre asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ciclo_obtener`()
BEGIN
	select id, nombre
	from ciclo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_agregar`(
IN vin_nombre VARCHAR(50),
IN vin_pre_requisito INT,
IN vin_credito INT,
IN vin_carrera_id INT,
IN vin_ciclo_id INT,
IN vin_estado INT,
IN vin_usuario_creacion INT
)
BEGIN
	
    DECLARE var_curso_id INT;
    DECLARE var_carrera_prerequisito INT;
    DECLARE var_curso_existe INT;
    
    select count(id)
		from curso
		where nombre = vin_nombre
			and carrera_id = vin_carrera_id
			and estado != 2
			into var_curso_existe;
    
    if(var_curso_existe > 0 ) then
		SELECT 0 as vout_resultado, "El curso ya existe." as vout_mensaje, var_curso_id as id;
    end if;
    
    

    if(vin_pre_requisito = '-1') then 
		set vin_pre_requisito = 0;
	else
		
	   select carrera_id
			from curso
            where id = vin_pre_requisito
            and estado = 1
            into var_carrera_prerequisito;
            
		if (var_carrera_prerequisito != vin_carrera_id) then
			
            SELECT 0 as vout_resultado, "El curso de pre-requisito no pertenece a la misma carrera." as vout_mensaje, var_curso_id as id;
            
        end if;
	
    end if;
	
	INSERT INTO curso(
				nombre,
                pre_requisito,
                creditos,
                carrera_id,
                ciclo_id,
                estado,
                fecha_creacion,
                usuario_creacion) 
			VALUES(
				vin_nombre,
                vin_pre_requisito,
                vin_credito,
                vin_carrera_id,
                vin_ciclo_id,
                vin_estado,
                now(),
                vin_usuario_creacion);
	
	SET var_curso_id  = LAST_INSERT_ID();
	
	SELECT 1 as vout_resultado, "Curso insertado correctamente" as vout_mensaje, var_curso_id as id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_editar`(
IN vin_curso_id INT,
IN vin_nombre VARCHAR(50),
IN vin_pre_requisito INT,
IN vin_credito INT,
IN vin_carrera_id INT,
IN vin_ciclo_id INT,
IN vin_estado INT
)
BEGIN
	
    DECLARE var_curso_id INT;
    DECLARE var_carrera_prerequisito INT;
    DECLARE var_curso_existe INT;
    
    select count(id)
		from curso
		where nombre = vin_nombre
			and carrera_id = vin_carrera_id
            and id != vin_curso_id
			and estado != 2
			into var_curso_existe;
    
    if(var_curso_existe > 0 ) then
		SELECT 0 as vout_resultado, "El curso ya existe." as vout_mensaje, var_curso_id as id;
    end if;
    
    

    if(vin_pre_requisito = '-1') then 
		set vin_pre_requisito = 0;
	else
		
	   select carrera_id
			from curso
            where id = vin_pre_requisito
            and estado = 1
            into var_carrera_prerequisito;
            
		if (var_carrera_prerequisito != vin_carrera_id) then
			
            SELECT 0 as vout_resultado, "El curso de pre-requisito no pertenece a la misma carrera." as vout_mensaje, var_curso_id as id;
            
        end if;
	
    end if;
	
	UPDATE curso
		SET nombre = vin_nombre,
			pre_requisito = vin_pre_requisito,
			creditos = vin_credito,
			carrera_id = vin_carrera_id,
			ciclo_id = vin_ciclo_id,
			estado = vin_estado
		where id = vin_curso_id
			and estado != 2;

	SELECT 1 as vout_resultado, "Curso actualizado correctamente" as vout_mensaje;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_eliminar`(
IN vin_id INT
)
BEGIN
	UPDATE curso
		SET estado = 2
			WHERE id = vin_id;		
            
	SELECT 1 as vout_resultado, "Curso eliminado correctamente" as vout_mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_existe`(
OUT vin_existe INT,
IN vin_nombre VARCHAR(50),
IN vin_carrera_id INT
)
BEGIN
	SELECT count(*)
    FROM curso
    WHERE nombre = vin_nombre
    AND carrera_id = vin_carrera_id
    AND estado = 1
    INTO vin_existe;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_getAllByCarrera`(
IN vin_carrera_id INT)
BEGIN
	SELECT curso.id,curso.nombre,curso.pre_requisito,curso.creditos,curso.carrera_id,carrera.nombre,curso.ciclo_id,ciclo.id
    FROM curso curso
    INNER JOIN carrera carrera ON curso.carrera_id = carrera.id
    INNER JOIN ciclo ciclo ON curso.ciclo_id = ciclo.id
    WHERE curso.carrera_id = vin_carrera_id
    AND curso.estado = 1
    AND carrera.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_horario_agregar`(
IN vin_horario_id INT,
IN vin_curso_id INT,
IN vin_anio_academico varchar(45),
IN vin_estado INT,
IN vin_usuario_creacion INT)
BEGIN
	
    declare var_existe int;
    
    select count(id)
		from curso_horario
            where curso_id = vin_curso_id
            and anio_academico = vin_anio_academico
            and estado != 2
            into var_existe;
    
    if(var_existe = 0) then 
		INSERT INTO curso_horario(
								 curso_id,
                                 horario_id,
								 anio_academico,
								 estado,
								 fecha_creacion,
								 usuario_creacion) 
						  VALUES(
								vin_curso_id,
                                vin_horario_id,
								vin_anio_academico,
								vin_estado,
								now(),
								vin_usuario_creacion);
			
		SELECT 1 as vout_resultado, 'Horario del curso agregado satisfactoriamente.' as vout_mensaje;
	else
		SELECT 0 as vout_resultado, 'Horario del curso ya existe.' as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_horario_editar`(
IN vin_curso_horario_id INT,
IN vin_horario_id INT,
IN vin_curso_id INT,
IN vin_anio_academico varchar(45),
IN vin_estado INT
)
BEGIN
	
    declare var_existe int;
    
    select count(id)
		from curso_horario
			where id != vin_curso_horario_id
            and curso_id = vin_curso_id
            and anio_academico = vin_anio_academico
            and estado != 2
            into var_existe;
    
    if(var_existe = 0) then 
				UPDATE curso_horario
					SET horario_id = vin_horario_id,
						curso_id = vin_curso_id,
						anio_academico = vin_anio_academico,
						estado = vin_estado
					WHERE
						id = vin_curso_horario_id;
			
		SELECT 1 as vout_resultado, 'Horario del curso modificado satisfactoriamente.' as vout_mensaje;
	else
		SELECT 0 as vout_resultado, 'Horario del curso ya existe.' as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_horario_eliminar`(
IN vin_curso_horario_id INT
)
BEGIN

	UPDATE curso_horario
		SET estado = 2
			WHERE id = vin_curso_horario_id;
			
	SELECT 1 as vout_resultado, 'Horario del curso eliminado satisfactoriamente.' as vout_mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_horario_obtener`()
BEGIN
	select 
		ch.id as id,
        ch.estado,
        ch.anio_academico,
		car.id as carrera_id,
		car.nombre as carrera_nombre,
		ch.curso_id as curso_id, 
		c.nombre as curso_nombre, 
		ch.horario_id as horario_id,
		concat(h.descripcion,' | ',h.horas) as horario
			from curso_horario ch
				inner join curso c on c.id = ch.curso_id
				inner join horario h on h.id = ch.horario_id
				inner join carrera car on car.id = c.carrera_id
			where ch.estado = 1
				and c.estado = 1
				and h.estado = 1
				and car.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_obtener`()
BEGIN
	SELECT curso.id,
           curso.nombre as nombre_curso,
           
           case curso.pre_requisito  
			  when 0 then null 
              else (select c.id as pre_requisito
							from curso c
                            where c.id = curso.pre_requisito
                            and c.estado = 1
                            limit 1)  
			end as pre_requisito,
            case curso.pre_requisito  
			  when 0 then null
              else (select c.nombre as pre_requisito_nombre
							from curso c
                            where c.id = curso.pre_requisito
                            and c.estado = 1
                            limit 1)  
			end as pre_requisito_nombre,
           curso.creditos,
           curso.carrera_id,
		   carrera.nombre as carrera_nombre,
           curso.ciclo_id,
           ciclo.nombre as ciclo_nombre,
           curso.estado
		FROM curso curso
			INNER JOIN carrera carrera ON curso.carrera_id = carrera.id
			INNER JOIN ciclo ciclo ON curso.ciclo_id = ciclo.id
		WHERE curso.estado != 2
			AND carrera.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_obtenerXcarrera`(
IN vin_carrera_id int
)
BEGIN
SELECT curso.id,
       concat(curso.nombre,' - ',ciclo.nombre) as nombre 
		FROM curso curso
			INNER JOIN carrera carrera ON curso.carrera_id = carrera.id
			INNER JOIN ciclo ciclo ON curso.ciclo_id = ciclo.id
		WHERE curso.carrera_id = vin_carrera_id
			AND curso.estado = 1
			AND carrera.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_obtenerXCarreraXDocente`(
IN vin_carrera_id int,
IN vin_usuario_id int
)
BEGIN
SELECT curso.id,
       concat(curso.nombre,' - ',ciclo.nombre) as nombre 
		FROM curso curso
			INNER JOIN carrera carrera ON curso.carrera_id = carrera.id
			INNER JOIN ciclo ciclo ON curso.ciclo_id = ciclo.id
            INNER JOIN usuario_curso uc ON uc.curso_id = curso.id
            inner join usuario u on u.id = uc.usuario_id
		WHERE curso.carrera_id = vin_carrera_id
			and u.id = vin_usuario_id
			AND curso.estado = 1
			AND carrera.estado = 1
            and uc.estado = 1
            and u.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_obtenerXUsuario`(
IN vin_usuario int)
BEGIN
	select c.id , concat(c.nombre,' | ',c.creditos) as nombre 
		from curso c
			inner join carrera car on car.id = c.carrera_id
			inner join usuario_carrera uc on uc.carrera_id = car.id
			inner join usuario u on u.id = uc.usuario_id
		where u.id = vin_usuario
			and c.estado = 1
            and car.estado = 1
            and uc.estado = 1
            and u.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_obteneXId`(
IN vin_curso_id INT)
BEGIN
	select 1 as vout_resultado, id, nombre, creditos
			from curso 
		where id = vin_curso_id
			and estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_reporteXDocente`(
IN vin_usuario_id int)
BEGIN
	select c.nombre as curso,
		c.creditos as creditos,
		car.nombre as carrera,
		ci.nombre as ciclo,
		h.descripcion as turno_horario,
		h.horas as hora_horario,
		ch.anio_academico
			from curso c
				inner join curso_horario ch on ch.curso_id = c.id
				inner join horario h on h.id = ch.horario_id
				inner join ciclo ci on ci.id = c.ciclo_id
				inner join carrera car on car.id = c.carrera_id
				inner join usuario_curso uc on uc.curso_id = c.id
				inner join usuario u on u.id = uc.usuario_id
			where c.estado = 1
				and u.id = vin_usuario_id
				and c.estado = 1
				and ch.estado = 1
				and h.estado = 1
				and car.estado = 1
				and uc.estado = 1
				and u.estado = 1
					order by ch.anio_academico desc,car.nombre asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso_validarPrerequisito`(
IN curso_id INT,
IN usuario_id INT
)
BEGIN
	declare var_prerequisito int;
    declare var_curso_aprobado int;
    
	select pre_requisito 
		from curso
		where id = curso_id
			and estado = 1
				into var_prerequisito;

	if (var_prerequisito = 0) then
		select 1 as vout_resultado;
    else
		
        select n.estado 
				from nota n
			where curso_id = var_prerequisito
				and usuario_id = usuario_id
				and estado = 1
					into var_curso_aprobado;
    
		if(var_curso_aprobado is null) then
			select 0 as vout_resultado, 'El prerequisito del curso no ha sido aprobado.' as vout_mensaje;
        else
			select 1 as vout_resultado;
        end if;
        
    end if;
    
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_horario_obtener`()
BEGIN
	select id, concat(descripcion,' | ',horas) as nombre
		from horario
			where estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_matricula_cursoGuardar`(
IN vin_matricula_id INT,
IN vin_curso_id INT)
BEGIN
	INSERT INTO matricula_curso(
					matricula_id,
					curso_id,
					estado) 
				VALUES(
					vin_matricula_id,
					vin_curso_id,
					1);
                    
	select 1 as vout_resultado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_matricula_curso_guardarNota`(
IN vin_id INT,
IN vin_nota DECIMAL(4,2),
IN vin_indice INT
)
BEGIN

	if(vin_indice = 1) then
		update matricula_curso
		set nota_1 = vin_nota
		where id = vin_id; 
    else
		if(vin_indice = 2) then
			update matricula_curso
			set nota_2 = vin_nota
			where id = vin_id;
		else
			update matricula_curso
			set nota_3 = vin_nota
			where id = vin_id;
		end if;
	end if;
    
    select 1 as vout_resultado;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_matricula_curso_obtenerNotas`(
IN  vin_usuario_id INT)
BEGIN
	select c.nombre as curso,c.creditos as creditos,ci.nombre as ciclo, mc.promedio as promedio
		from matricula m
			inner join matricula_curso mc on mc.matricula_id = m.id
			inner join curso c on c.id = mc.curso_id
			inner join ciclo ci on ci.id = c.ciclo_id
		where usuario_id = vin_usuario_id
			and mc.estado = 1
            and m.estado = 1
            and c.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_matricula_curso_obtenerNotasXCurso`(
IN vin_curso_id INT)
BEGIN
	select mc.id, 
		concat(ui.nombres,' ',ui.apellido_paterno,' ',ui.apellido_materno) as nombre,
		mc.nota_1,
		mc.nota_2,
		mc.nota_3,
		mc.promedio
			from matricula m 
				inner join matricula_curso mc on mc.matricula_id = m.id
				inner join curso c on c.id = mc.curso_id
				inner join usuario u on u.id = m.usuario_id
				inner join usuario_info ui on ui.usuario_id = u.id
			where c.id = vin_curso_id
            and m.estado = 1
            -- and mc.estado = 1
            and c.estado = 1
            and u.estado = 1
            and ui.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_matricula_curso_obtenerPromedio`(
IN vin_id INT)
BEGIN

	update matricula_curso
    set promedio = ((nota_1+nota_2+nota_3)/3),
		estado = 1
    where id = vin_id;
		
	select 1 as vout_resultado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_matricula_existeXUsuario`(
IN vin_usuario_id INT,
IN vin_anio_academico_id INT
)
BEGIN
	declare var_existe_matricula int;
    
	select count(id) 
			from matricula
		where usuario_id = vin_usuario_id
			and anio_academico_id = vin_anio_academico_id
			and estado = 1
				into var_existe_matricula;
                
	if var_existe_matricula = 0 then
		select 1 as vout_resultado;
    else 
		select 0 as vout_resultado, 'Usted ya se matriculo.' as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_matricula_matricular`(
IN vin_usuario_id INT,
IN vin_anio_academico_id INT
)
BEGIN
	
    declare var_matricula_id int;
    
    INSERT INTO matricula(
				usuario_id,
                anio_academico_id,
                estado,
                fecha_creacion,
                usuario_creacion) 
			VALUES(
				vin_usuario_id,
                vin_anio_academico_id,
                1,
                now(),
                vin_usuario_id);
	
	SET var_matricula_id  = LAST_INSERT_ID();
	
	SELECT 1 as vout_resultado, 'Matricula Realizada correctamente.' as vout_mensaje, var_matricula_id as matricula_id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_nota_existe`(
OUT vin_existe INT,
IN vin_id INT
)
BEGIN
	SELECT count(*) 
    FROM nota 
    WHERE id = vin_id  
    AND estado = 1
    INTO vin_existe;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_nota_insert`(
IN vin_id INT,
IN vin_curso_id INT,
IN vin_usuario_id INT,
IN vin_nota_opcion INT,
IN vin_nota DECIMAL(2,2),
IN vin_usuario_creacion INT
)
BEGIN
	CALL sp_usuario_existe(@existe,vin_usuario_id);
    IF(@existe > 0) THEN
		SET @existe = NULL;
        CALL sp_usuario_info_existe(@existe,vin_usuario_id);
		IF(@existe is null or  @existe = 0) THEN
			CALL sp_usuario_info_insert(@usuario_info_id,vin_nombres,vin_apellido_paterno,vin_apellido_materno,
			vin_edad,vin_sexo,vin_celular,vin_fecha_nacimiento,vin_usuario_id,vin_usuario_creacion);
			
			SELECT 1 as vout_resultado, "Datos del usuario insertada correctamente" as vout_mensaje, @usuario_info_id as id;
		ELSE
			CALL sp_usuario_info_update(vin_nombres,vin_apellido_paterno,vin_apellido_materno,
			vin_edad,vin_sexo,vin_celular,vin_fecha_nacimiento,vin_usuario_id);
			SELECT 1 as vout_resultado, "Datos del usuario modificado correctamente" as vout_mensaje;
        END IF;
	ELSE
		SELECT 0 as vout_resultado, "Usuario no existe" as vout_mensaje;
    END IF;
    SET @existe = NULL;
    SET @usuario_info_id = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_perfil_existe`(
OUT vout_existe INT,
IN vin_id INT
)
BEGIN
	SELECT count(*) 
    FROM perfil 
    WHERE id = vin_id  
    AND estado = 1
    INTO vout_existe;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_perfil_obtenerActivos`()
BEGIN
	
    select id, nombre
    from perfil
    where estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_publicacion_agregar`(
IN vin_titulo VARCHAR(200),
IN vin_mensaje VARCHAR(5000),
IN vin_estado INT,
IN vin_usuario_creacion INT
)
BEGIN
	
    DECLARE var_publicacion_id int;
    DECLARE var_existe_publicacion int;
    
    select count(id)
		 from publicacion
		 where titulo = vin_titulo
			and estado != 2
				into var_existe_publicacion;
    
    if (var_existe_publicacion = 0) then
		INSERT INTO publicacion(
							titulo,
                            mensaje,
							estado,
							fecha_creacion,
							usuario_creacion) 
					VALUES(
							vin_titulo,
                            vin_mensaje,
							vin_estado,
							now(),
							vin_usuario_creacion);
		
		SET var_publicacion_id  = LAST_INSERT_ID();
		
		SELECT 1 as vout_resultado, "Publicacion insertada correctamente." as vout_mensaje, var_publicacion_id as id;
	else
		SELECT 0 as vout_resultado, "Titulo de la publicacion ya existe." as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_publicacion_editar`(
IN vin_id INT,
IN vin_titulo VARCHAR(200),
IN vin_mensaje VARCHAR(5000),
IN vin_estado INT
)
BEGIN

	DECLARE var_publicacion_id int;
    DECLARE var_existe_publicacion int;
    
    select count(id)
		 from publicacion
		 where titulo = vin_titulo
			and id != vin_id
			and estado != 2
				into var_existe_publicacion;
                
    if (var_existe_publicacion = 0) then            
                
		UPDATE publicacion
			SET titulo = vin_titulo,
				mensaje = vin_mensaje,
				estado = vin_estado
				WHERE id= vin_id;
		
		SELECT 1 as vout_resultado, "Publicacion actualizada correctamente" as vout_mensaje;
    else
		SELECT 0 as vout_resultado, "Titulo de publicacion ya existe." as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_publicacion_eliminar`(
IN vin_id INT
)
BEGIN
	UPDATE publicacion
		SET estado = 2
			WHERE id = vin_id;		
            
	SELECT 1 as vout_resultado, "Publicacion eliminada correctamente" as vout_mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_publicacion_obtener`()
BEGIN
	select id,titulo,estado
	from publicacion
	where estado != 2
    order by fecha_creacion desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_publicacion_obtenerActivos`()
BEGIN
	select titulo,mensaje
	from publicacion
	where estado = 1
    order by fecha_creacion desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_publicacion_obtenerXId`(
IN vin_id INT)
BEGIN
	select id,titulo,mensaje,estado
	from publicacion
	where id = vin_id
    and estado != 2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_agregar`(
IN vin_dni VARCHAR(8),
IN vin_perfil_id INT,
IN vin_estado INT,
IN vin_usuario_creacion INT)
BEGIN
	
	declare var_usuario_id int;
    
    INSERT INTO usuario (dni,clave,perfil_id,usuario_creacion) 
	VALUES(vin_dni,AES_ENCRYPT(vin_dni,'ASDFG'),vin_perfil_id,vin_usuario_creacion);
	
	SET var_usuario_id  = LAST_INSERT_ID();
	
	SELECT 1 as vout_exito, var_usuario_id as usuario_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_cambiarContrasenha`(
IN vin_usuario_id INT,
IN vin_contrasenha_antigua varchar(500),
IN vin_contrasenha_nueva1 varchar(500),
IN vin_contrasenha_nueva2 varchar(500)
)
BEGIN

	declare var_existe_contrasenha int; 
    
    select count(*) 
			from usuario
		where id = vin_usuario_id
			and clave = AES_ENCRYPT(vin_contrasenha_antigua,'ASDFG')
			and estado = 1
				into var_existe_contrasenha;
	
    if(var_existe_contrasenha = 0) then
		SELECT 0 as vout_resultado, 'Contrasenha incorrecta' as vout_mensaje;
    else
		if (vin_contrasenha_nueva1 = vin_contrasenha_nueva2) then
        
			UPDATE usuario
				SET clave = AES_ENCRYPT(vin_contrasenha_nueva1,'ASDFG')
					WHERE id = vin_usuario_id
						and estado = 1;
            
            SELECT 1 as vout_resultado, 'Contrasenha actualizada correctamente' as vout_mensaje;
        else 
            SELECT 0 as vout_resultado, 'La contrasenha nuevas no conciden.' as vout_mensaje;
        end if;
    end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_carrera_guardar`(
IN vin_usuario_id INT,
IN vin_carrera_id INT,
IN vin_usuario_creacion INT)
BEGIN

	declare var_existe INT;
    
    select count(id)
		from usuario_carrera
			where usuario_id = vin_usuario_id
				and carrera_id = vin_carrera_id
					into var_existe;
                    
	if(var_existe = 0) then
		INSERT INTO usuario_carrera(
				usuario_id,
                carrera_id,
                estado,
                fecha_creacion,
                usuario_creacion) 
			VALUES(
				vin_usuario_id,
				vin_carrera_id,
                1,
                now(),
                vin_usuario_creacion);
    else 
    
		UPDATE usuario_carrera
			SET carrera_id = vin_carrera_id
			where usuario_id = vin_usuario_id;
    end if;
    
    select 1 as vout_exito;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_curso_agregar`(
IN vin_docente_id INT,
IN vin_curso_id INT,
IN vin_anio_academico varchar(45),
IN vin_estado INT,
IN vin_usuario_creacion INT)
BEGIN
	
    declare var_existe int;
    
    select count(id)
		from usuario_curso
			where usuario_id = vin_docente_id
            and curso_id = vin_curso_id
            and anio_academico = vin_anio_academico
            and estado != 2
            into var_existe;
    
    if(var_existe = 0) then 
		INSERT INTO usuario_curso(
								 usuario_id,
								 curso_id,
								 anio_academico,
								 estado,
								 fecha_creacion,
								 usuario_creacion) 
						  VALUES(
								vin_docente_id,
								vin_curso_id,
								vin_anio_academico,
								vin_estado,
								now(),
								vin_usuario_creacion);
			
		SELECT 1 as vout_resultado, 'Docente - curso agregado satisfactoriamente.' as vout_mensaje;
	else
		SELECT 0 as vout_resultado, 'Docente - curso ya existe.' as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_curso_editar`(
IN vin_usuario_curso_id INT,
IN vin_docente_id INT,
IN vin_curso_id INT,
IN vin_anio_academico varchar(45),
IN vin_estado INT
)
BEGIN
	
    declare var_existe int;
    
    select count(id)
		from usuario_curso
			where id != vin_usuario_curso_id
            and usuario_id = vin_docente_id
            and curso_id = vin_curso_id
            and anio_academico = vin_anio_academico
            and estado != 2
            into var_existe;
    
    if(var_existe = 0) then 
				UPDATE usuario_curso
					SET usuario_id = vin_docente_id,
						curso_id = vin_curso_id,
						anio_academico = vin_anio_academico,
						estado = vin_estado
					WHERE
						id = vin_usuario_curso_id;
			
		SELECT 1 as vout_resultado, 'Docente - curso modificado satisfactoriamente.' as vout_mensaje;
	else
		SELECT 0 as vout_resultado, 'Docente - curso ya existe.' as vout_mensaje;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_curso_eliminar`(
IN vin_usuario_curso_id INT
)
BEGIN

	UPDATE usuario_curso
		SET estado = 2
			WHERE id = vin_usuario_curso_id;
			
	SELECT 1 as vout_resultado, 'Docente - curso eliminado satisfactoriamente.' as vout_mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_curso_obtener`()
BEGIN
SELECT  uc.id,
		u.id as usuario_id,
		concat(ui.nombres,' ',ui.apellido_paterno,' ',apellido_materno) as usuario_nombre,
        uc.estado as usuario_curso_estado,
        c.id as curso_id,
        c.nombre as curso_nombre,
        car.id as carrera_id,
        car.nombre as carrera_nombre,
        uc.anio_academico
		FROM usuario u
			inner join perfil p  on u.perfil_id = p.id
			left join usuario_info ui on ui.usuario_id = u.id
            inner join usuario_curso uc on uc.usuario_id = u.id
            inner join curso c on c.id = uc.curso_id
            inner join carrera car on car.id = c.carrera_id
		WHERE u.perfil_id = 2
			and uc.estado != 2
			and u.estado = 1
            and p.estado = 1
			and ui.estado = 1
            and c.estado = 1
			and car.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_editar`(
IN vin_id INT,
IN vin_dni VARCHAR(8),
IN vin_perfil_id INT,
IN vin_estado INT
)
BEGIN

	UPDATE usuario 
		SET dni = vin_dni,
			perfil_id = vin_perfil_id,
            estado = vin_estado
		WHERE id = vin_id
			AND estado != 2;
            
	  SELECT 1 as vout_resultado;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_eliminar`(
IN vin_id int,
IN vin_usuario_creacion INT
)
BEGIN

	if(vin_id != vin_usuario_creacion) then
		UPDATE usuario
			SET estado = 2
				WHERE id = vin_id;
				
		UPDATE usuario_info
			SET estado = 2
				WHERE usuario_id = vin_id;
				
		SELECT 1 as vout_resultado, "usuario eliminado correctamente." as vout_mensaje;
	else
		SELECT 0 as vout_resultado, "No se puede eliminar usuario porque esta en sesion." as vout_mensaje;
    end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_existe`(
OUT vin_existe INT,
IN vin_id INT
)
BEGIN
	SELECT count(*)
    FROM usuario
    WHERE id = vin_id
    AND estado = 1
    INTO vin_existe;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_getByDni`(
OUT vout_id INT,
IN vin_dni VARCHAR(8))
BEGIN
	
    SELECT id
    FROM usuario
    WHERE dni = vin_dni
    AND estado = 1
    INTO vout_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_getOpcionById`(
IN vin_id INT)
BEGIN
	-- con este sp obtenemos las rutas a las que tiene acceso el usuario
	SELECT o.nombre, o.ruta
	FROM opcion o
	INNER JOIN perfil_opcion po
	ON po.opcion_id = o.id
	INNER JOIN perfil p
	ON po.perfil_id = p.id
	INNER JOIN usuario u
	ON u.perfil_id = p.id
	WHERE u.id = vin_id
	AND u.estado = 1
	AND p.estado = 1
	AND po.estado = 1
	AND o.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_info_agregar`(
IN vin_usuario_id INT,
IN vin_nombres VARCHAR(50),
IN vin_apellido_paterno VARCHAR(50),
IN vin_apellido_materno VARCHAR(50),
IN vin_edad INT,
IN vin_sexo CHAR,
IN vin_celular VARCHAR(50),
IN vin_fecha_nacimiento timestamp,
IN vin_estado int,
IN vin_usuario_creacion INT
)
BEGIN
	INSERT INTO usuario_info(
				usuario_id,
				nombres,
                apellido_paterno,
                apellido_materno,
                edad,
                sexo,
                celular,
			    fecha_nacimiento,
                estado,
                fecha_creacion,
                usuario_creacion) 
		 VALUES(
				vin_usuario_id,
				vin_nombres,
                vin_apellido_paterno,
                vin_apellido_materno,
                vin_edad,
                vin_sexo,
                vin_celular,
			    vin_fecha_nacimiento,
                vin_estado,
                now(),
                vin_usuario_creacion);
                
	SELECT 1 as vout_exito, 'Usuario registrado correctamente' as vout_mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_info_delete`(
IN vin_usuario_id INT)
BEGIN
	CALL sp_usuario_existe(@existe,vin_usuario_id);
    IF(@existe > 0) THEN
		UPDATE usuario_info
		SET estado = 0
		WHERE usuario_id = vin_usuario_id;
        SELECT 1 as vout_resultado, "Datos del usuario eliminado correctamente" as vout_mensaje;
	ELSE
		SELECT 0 as vout_resultado, "Usuario no existe" as vout_mensaje;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_info_editar`(
IN vin_usuario_id INT,
IN vin_nombres VARCHAR(50),
IN vin_apellido_paterno VARCHAR(50),
IN vin_apellido_materno VARCHAR(50),
IN vin_edad INT,
IN vin_sexo CHAR,
IN vin_celular VARCHAR(9),
IN vin_fecha_nacimiento timestamp,
IN vin_estado INT
)
BEGIN
	UPDATE usuario_info
		SET nombres = vin_nombres,
			apellido_paterno = vin_apellido_paterno,
			apellido_materno = vin_apellido_materno,
			edad = vin_edad,
			sexo = vin_sexo,
			celular = vin_celular,
			fecha_nacimiento = vin_fecha_nacimiento,
			estado = vin_estado
		WHERE usuario_id = vin_usuario_id
			AND estado != 2;
	
    SELECT 1 as vout_resultado, "usuario modificado correctamente" as vout_mensaje;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_info_existe`(
OUT vout_existe INT,
IN vin_id INT
)
BEGIN
	SELECT count(*) 
    FROM usuario_info 
    WHERE usuario_id = vin_id  
    AND estado = 1
    INTO vout_existe;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_info_save`(
IN vin_nombres VARCHAR(50),
IN vin_apellido_paterno VARCHAR(50),
IN vin_apellido_materno VARCHAR(50),
IN vin_edad INT,
IN vin_sexo CHAR,
IN vin_celular VARCHAR(9),
IN vin_fecha_nacimiento TIMESTAMP,
IN vin_usuario_id INT,
IN vin_usuario_creacion INT
)
BEGIN
	CALL sp_usuario_existe(@existe,vin_usuario_id);
    IF(@existe > 0) THEN
		SET @existe = NULL;
        CALL sp_usuario_info_existe(@existe,vin_usuario_id);
		IF(@existe is null or  @existe = 0) THEN
			CALL sp_usuario_info_insert(@usuario_info_id,vin_nombres,vin_apellido_paterno,vin_apellido_materno,
			vin_edad,vin_sexo,vin_celular,vin_fecha_nacimiento,vin_usuario_id,vin_usuario_creacion);
			
			SELECT 1 as vout_resultado, "Datos del usuario insertada correctamente" as vout_mensaje, @usuario_info_id as id;
		ELSE
			CALL sp_usuario_info_update(vin_nombres,vin_apellido_paterno,vin_apellido_materno,
			vin_edad,vin_sexo,vin_celular,vin_fecha_nacimiento,vin_usuario_id);
			SELECT 1 as vout_resultado, "Datos del usuario modificado correctamente" as vout_mensaje;
        END IF;
	ELSE
		SELECT 0 as vout_resultado, "Usuario no existe" as vout_mensaje;
    END IF;
    SET @existe = NULL;
    SET @usuario_info_id = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_iniciarSesion`(
IN vin_dni VARCHAR(8),
IN vin_perfil INT,
IN vin_clave VARCHAR(100)
)
BEGIN
	declare var_usuario_id int;
    declare var_existe int;
    declare var_existe_perfil int;
    
    CALL sp_usuario_getByDni(var_usuario_id,vin_dni);
    IF(var_usuario_id > 0) THEN
		
        
        select count(*)
        from usuario
        where dni = vin_dni
        and perfil_id = vin_perfil
        and estado =1
        into var_existe_perfil;
        
        IF(var_existe_perfil > 0) THEN
			SELECT count(*)
			FROM usuario
			WHERE dni = vin_dni
			AND clave = AES_ENCRYPT(vin_clave,'ASDFG')
			AND estado = 1
			INTO var_existe;
			
			IF(var_existe  > 0) THEN
				SELECT 1 as vout_resultado, "Usuario logeado" as vout_mensaje, var_usuario_id as id;
			ELSE
				SELECT 0 as vout_resultado, "Clave incorrecta" as vout_mensaje;
			END IF;
		else
			SELECT 0 as vout_resultado, "Perfil incorrecto." as vout_mensaje;
        end if;
	ELSE
		SELECT 0 as vout_resultado, "Usuario no existe" as vout_mensaje;
        
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_obtener`()
BEGIN
	SELECT u.id, u.dni as codigo_identificacion, 
		u.estado as estado_usuario,
        u.perfil_id,
		p.nombre as nombre_perfil,
        concat(ui.nombres,' ',ui.apellido_paterno,' ',apellido_materno) as nombre_usuario,
        ui.nombres,
        apellido_paterno,
        apellido_materno,
        ui.edad,
        ui.sexo as sexo_valor,
        case ui.sexo  
		  when 'M' then 'Masculino'  
		  when 'F' then 'Femenino'   
		end as sexo,
        
        ui.celular,
        ui.fecha_nacimiento,
        uc.carrera_id,
        c.nombre as carrera_nombre
        
		FROM usuario u
			inner join perfil p  on u.perfil_id = p.id
            left join usuario_info ui on ui.usuario_id = u.id
            left join usuario_carrera uc on uc.usuario_id = u.id
            left join carrera c on c.id = uc.carrera_id
		WHERE u.estado != 2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_obtenerInfoXId`(
IN vin_id INT)
BEGIN
	select concat(ui.nombres,' ',ui.apellido_paterno,' ',ui.apellido_materno) as nombre,
		p.nombre as perfil
			from usuario u
				inner join usuario_info ui on ui.usuario_id = u.id
				inner join perfil p on p.id = u.perfil_id
			where u.id = vin_id
				and u.estado = 1
				and ui.estado = 1
				and p.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_obtenerMenu`(
IN vin_usuario_id INT)
BEGIN
	
	select o.ruta, o.descripcion, o.icono
		from opcion o 
			inner join perfil_opcion po on po.opcion_id = o.id
			inner join perfil p on p.id = po.perfil_id
			inner join usuario u on u.perfil_id = p.id
		where u.id = vin_usuario_id
			and o.estado = 1
			and po.estado = 1
			and p.estado = 1
			and u.estado = 1
		order by o.orden asc, o.descripcion asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_obtenerXPerfil`(
in vin_perfil INT
)
BEGIN
	SELECT u.id,
		concat(ui.nombres,' ',ui.apellido_paterno,' ',apellido_materno) as nombre_usuario
		FROM usuario u
			inner join perfil p  on u.perfil_id = p.id
			left join usuario_info ui on ui.usuario_id = u.id
		WHERE u.perfil_id = vin_perfil
			and u.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_validarDNI`(
in vin_usuario_id int,
in vin_dni varchar(8),
in vin_perfil int
)
BEGIN
	declare var_existe_dni int;
    
	select count(id)
			from usuario
		where dni = vin_dni
			and id != vin_usuario_id
			and estado != 2
		into var_existe_dni;
        
	if(var_existe_dni = 0) then
		
        select 1 as vout_exito, vin_dni as dni, vin_perfil as perfil;
    else
		select 0 as vout_exito, 'DNI ya esta registrado' as vout_mensaje;
    end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio_academico`
--

CREATE TABLE IF NOT EXISTS `anio_academico` (
  `id` int(11) NOT NULL,
  `anio` varchar(45) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `anio_academico`
--

INSERT INTO `anio_academico` (`id`, `anio`, `activo`, `estado`) VALUES
(1, '2015 - II ', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE IF NOT EXISTS `carrera` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclo`
--

CREATE TABLE IF NOT EXISTS `ciclo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(7) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ciclo`
--

INSERT INTO `ciclo` (`id`, `nombre`) VALUES
(1, 'I'),
(2, 'II'),
(3, 'III'),
(4, 'IV'),
(5, 'V'),
(6, 'VI'),
(7, 'VII'),
(8, 'VIII'),
(9, 'IX'),
(10, 'X');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `pre_requisito` int(11) DEFAULT NULL,
  `creditos` int(11) NOT NULL,
  `carrera_id` int(11) NOT NULL,
  `ciclo_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_horario`
--

CREATE TABLE IF NOT EXISTS `curso_horario` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `horario_id` int(11) NOT NULL,
  `anio_academico` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE IF NOT EXISTS `horario` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `horas` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `descripcion`, `horas`, `estado`, `fecha_creacion`, `usuario_creacion`) VALUES
(1, 'Manhana', '7 - 1', 1, '2015-10-08 23:17:38', 1),
(2, 'Tarde', '2 - 8', 1, '2015-10-08 21:03:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE IF NOT EXISTS `matricula` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `anio_academico_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula_curso`
--

CREATE TABLE IF NOT EXISTS `matricula_curso` (
  `id` int(11) NOT NULL,
  `matricula_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `nota_1` decimal(4,2) DEFAULT '0.00',
  `nota_2` decimal(4,2) DEFAULT '0.00',
  `nota_3` decimal(4,2) DEFAULT '0.00',
  `promedio` decimal(4,2) DEFAULT '0.00',
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE IF NOT EXISTS `opcion` (
  `id` int(11) NOT NULL,
  `hijo` int(11) DEFAULT NULL,
  `descripcion` varchar(50) NOT NULL,
  `ruta` varchar(100) NOT NULL,
  `icono` varchar(45) NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`id`, `hijo`, `descripcion`, `ruta`, `icono`, `orden`, `estado`) VALUES
(1, NULL, 'Matricular', 'vista/com/matricula/matricula.php', '', 1, 1),
(2, NULL, 'Notas', 'vista/com/nota/nota.php', '', 2, 1),
(3, NULL, 'Ingresar Notas', 'vista/com/nota/IngresarNota.php', '', 1, 1),
(4, NULL, 'Mis Cursos', 'vista/com/curso/reporteCurso.php', '', 2, 1),
(5, NULL, 'Usuario', 'vista/com/usuario/usuario.php', '', 1, 1),
(6, NULL, 'Curso', 'vista/com/curso/curso.php', '', 2, 1),
(7, NULL, 'Carrera', 'vista/com/carrera/carrera.php', '', 3, 1),
(8, NULL, 'Docente - Curso', 'vista/com/docente_curso/docente_curso.php', '', 4, 1),
(9, NULL, 'Curso - Horario', 'vista/com/curso_horario/curso_horario.php', '', 5, 1),
(10, NULL, 'Publicaciones', 'vista/com/publicacion/publicacion.php', '', 6, 1),
(11, NULL, 'Inicio', 'vista/com/publicacion/reportePublicacion.php', '', -1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `nombre`, `estado`) VALUES
(1, 'Administrador', 1),
(2, 'Docente', 1),
(3, 'Alumno', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_opcion`
--

CREATE TABLE IF NOT EXISTS `perfil_opcion` (
  `id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `opcion_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil_opcion`
--

INSERT INTO `perfil_opcion` (`id`, `perfil_id`, `opcion_id`, `estado`) VALUES
(1, 1, 5, 1),
(2, 1, 6, 1),
(3, 1, 7, 1),
(4, 2, 3, 1),
(5, 2, 4, 1),
(6, 3, 1, 1),
(7, 3, 2, 1),
(9, 1, 8, 1),
(10, 1, 9, 1),
(11, 1, 10, 1),
(12, 1, 11, 1),
(13, 2, 11, 1),
(14, 3, 11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE IF NOT EXISTS `publicacion` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `mensaje` varchar(5000) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `clave` blob NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado, 1 = activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `dni`, `clave`, `perfil_id`, `estado`, `fecha_creacion`, `usuario_creacion`) VALUES
(1, '45960630', 0xaadc765ad59ef0d58e3597b63376bb26, 1, 1, '2015-09-14 02:03:33', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_carrera`
--

CREATE TABLE IF NOT EXISTS `usuario_carrera` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `carrera_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_curso`
--

CREATE TABLE IF NOT EXISTS `usuario_curso` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado,1 = activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_info`
--

CREATE TABLE IF NOT EXISTS `usuario_info` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `edad` int(11) NOT NULL,
  `sexo` char(1) NOT NULL,
  `celular` varchar(9) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '0 = eliminado, 1 = activo\n',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_info`
--

INSERT INTO `usuario_info` (`id`, `usuario_id`, `nombres`, `apellido_paterno`, `apellido_materno`, `edad`, `sexo`, `celular`, `fecha_nacimiento`, `estado`, `fecha_creacion`, `usuario_creacion`) VALUES
(1, 1, 'Jose', 'Clavo', 'Tafur', 25, 'M', '942051470', '1989-06-09', 1, '2015-10-15 05:42:28', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anio_academico`
--
ALTER TABLE `anio_academico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciclo`
--
ALTER TABLE `ciclo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_curso_carrera1_idx` (`carrera_id`), ADD KEY `fk_curso_ciclo1_idx` (`ciclo_id`);

--
-- Indices de la tabla `curso_horario`
--
ALTER TABLE `curso_horario`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_curso_horario_curso_idx` (`curso_id`), ADD KEY `fk_curso_horario_horario_idx` (`horario_id`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_matricula_usuario1_idx` (`usuario_id`), ADD KEY `fk_matricula_anio_academico_idx` (`anio_academico_id`);

--
-- Indices de la tabla `matricula_curso`
--
ALTER TABLE `matricula_curso`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_matricula_curso_matricula1_idx` (`matricula_id`), ADD KEY `fk_matricula_curso_curso1_idx` (`curso_id`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil_opcion`
--
ALTER TABLE `perfil_opcion`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_perfil_opcion_perfil1_idx` (`perfil_id`), ADD KEY `fk_perfil_opcion_opcion1_idx` (`opcion_id`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_usuario_perfil1_idx` (`perfil_id`);

--
-- Indices de la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_usuario_carrera_usuario1_idx` (`usuario_id`), ADD KEY `fk_usuario_carrera_carrera1_idx` (`carrera_id`);

--
-- Indices de la tabla `usuario_curso`
--
ALTER TABLE `usuario_curso`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_usuario_curso_curso1_idx` (`curso_id`), ADD KEY `fk_usuario_curso_usuario1_idx` (`usuario_id`);

--
-- Indices de la tabla `usuario_info`
--
ALTER TABLE `usuario_info`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_info_usuario_usuario_idx` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anio_academico`
--
ALTER TABLE `anio_academico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ciclo`
--
ALTER TABLE `ciclo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `curso_horario`
--
ALTER TABLE `curso_horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `matricula`
--
ALTER TABLE `matricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `matricula_curso`
--
ALTER TABLE `matricula_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `perfil_opcion`
--
ALTER TABLE `perfil_opcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `usuario_curso`
--
ALTER TABLE `usuario_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario_info`
--
ALTER TABLE `usuario_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
ADD CONSTRAINT `fk_curso_carrera1` FOREIGN KEY (`carrera_id`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_curso_ciclo1` FOREIGN KEY (`ciclo_id`) REFERENCES `ciclo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `curso_horario`
--
ALTER TABLE `curso_horario`
ADD CONSTRAINT `fk_curso_horario_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_curso_horario_horario` FOREIGN KEY (`horario_id`) REFERENCES `horario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
ADD CONSTRAINT `fk_matricula_anio_academico` FOREIGN KEY (`anio_academico_id`) REFERENCES `anio_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_matricula_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `matricula_curso`
--
ALTER TABLE `matricula_curso`
ADD CONSTRAINT `fk_matricula_curso_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_matricula_curso_matricula1` FOREIGN KEY (`matricula_id`) REFERENCES `matricula` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `perfil_opcion`
--
ALTER TABLE `perfil_opcion`
ADD CONSTRAINT `fk_perfil_opcion_opcion1` FOREIGN KEY (`opcion_id`) REFERENCES `opcion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_perfil_opcion_perfil1` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_carrera`
--
ALTER TABLE `usuario_carrera`
ADD CONSTRAINT `fk_usuario_carrera_carrera1` FOREIGN KEY (`carrera_id`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuario_carrera_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_curso`
--
ALTER TABLE `usuario_curso`
ADD CONSTRAINT `fk_usuario_curso_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuario_curso_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_info`
--
ALTER TABLE `usuario_info`
ADD CONSTRAINT `fk_info_usuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
