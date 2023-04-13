CREATE DATABASE senati;
USE senati;

CREATE TABLE cursos
(
	idcurso			INT AUTO_INCREMENT PRIMARY KEY,
	nombrecurso		VARCHAR(50)		NOT NULL,
	especialidad 	VARCHAR(70) 	NOT NULL,
	complejidad 	CHAR(1)			NOT NULL DEFAULT 'B',
	fechainicio		DATE 			NOT NULL,
	precio			DECIMAL(7,2)	NOT NULL,
	fechacreacion	DATETIME 		NOT NULL DEFAULT NOW(),
	fechaupdate 	DATETIME 		NULL,
	estado 			CHAR(1)			NOT NULL DEFAULT '1'
)ENGINE = INNODB;

INSERT INTO cursos (nombrecurso, especialidad, complejidad, fechainicio, precio) VALUES
	('Java', 'ETI', 'M', '2023-05-10', 180),
	('Desarrollo Web', 'ETI', 'B', '2023-04-20', 190),
	('Excel financiero', 'Administración', 'A', '2023-05-14', 250),
	('ERP SAP', 'Administración', 'A', '2023-05-11', 400),
	('Inventor', 'Mecánica', 'M', '2023-04-29', 380);

SELECT * FROM cursos;
UPDATE cursos SET estado = '1';


-- STORE PROCEDURE
-- Un procedimiento almacenado es un PROGRAMA que se ejecuta desde el
-- motor de BD, y que permite recibir valores de entrada, realizar
-- diferentes tipos de cálculos y entregar una salida.

-- DROP PROCEDURE spu_cursos_listar;
DELIMITER $$
CREATE PROCEDURE spu_cursos_listar()
BEGIN
	SELECT
		idcurso,
		nombrecurso,
		especialidad,
		complejidad,
		fechainicio,
		precio
	FROM cursos
	WHERE estado = '1'
	ORDER BY idcurso DESC;
END $$

CALL spu_cursos_listar();

-- Procedimiento registrar cursos
DELIMITER $$
CREATE PROCEDURE spu_cursos_registrar
(
	IN _nombrecurso	VARCHAR(50),
	IN _especialidad	VARCHAR(70),
	IN _complejidad	CHAR(1),
	IN _fechainicio	DATE,
	IN _precio			DECIMAL(7,2)
)
BEGIN
	INSERT INTO cursos (nombrecurso, especialidad, complejidad, fechainicio, precio) VALUES
		(_nombrecurso, _especialidad, _complejidad, _fechainicio, _precio);
END $$

CALL spu_cursos_registrar('Python para todos', 'ETI', 'B', '2023-05-10', 120);
CALL spu_cursos_registrar('C# para la web', 'ETI', 'A', '2023-05-11',320);
CALL spu_cursos_listar();


--  Eliminar curso
DELIMITER $$
CREATE PROCEDURE spu_cursos_eliminar(IN _idcurso INT)
BEGING
	UPDATE cursos 
	SET estado = '0' 
	WHERE idcurso = _idcurso;
END $$

-- Lunes 10 abril 2023
DELIMITER $$
CREATE PROCEDURE spu_cursos_recuperar_id(IN _idcurso INT)
BEGIN
	SELECT * FROM cursos WHERE idcurso =_idcurso;
END $$

CALL spu_cursos_recuperar_id(3);


--  Actualizar
DELIMITER $$
CREATE PROCEDURE spu_cursos_actualizar(
	IN _idcurso	INT,
	IN _nombrecurso	VARCHAR(50),
	IN _especialidad	VARCHAR(70),
	IN _complejidad	CHAR(1),
	IN _fechainicio	DATE,
	IN _precio			DECIMAL(7,2)
)
BEGIN
	UPDATE cursos SET
		nombrecurso = _nombrecurso,
		especialidad = _especialidad,
		complejidad = _complejidad,
		fechainicio = _fechainicio,
		precio = _precio,
		fechaupdate = NOW()
	WHERE idcurso = _idcurso;
END $$


SELECT * FROM cursos WHERE idcurso = 3;
CALL spu_cursos_actualizar(3,'Excel contadores','ETI','B','2023-06-20', 350);


CREATE TABLE usuarios
(
	idusuario		INT AUTO_INCREMENT PRIMARY KEY,
	nombreusuario	VARCHAR(30)		NOT NULL,
	claveacceso		VARCHAR(90)		NOT NULL,
	apellidos		VARCHAR(30)		NOT NULL,
	nombres			VARCHAR(30)		NOT NULL,
	nivelacceso 	CHAR(1)			NOT NULL DEFAULT 'A',
	estado			CHAR(1)			NOT NULL DEFAULT '1',
	fecharegistro	DATETIME			NOT NULL DEFAULT NOW(),
	fechaupdate		DATETIME			NULL,
	CONSTRAINT uk_nombreusuario_usa UNIQUE (nombreusuario)
)ENGINE = INNODB;


INSERT INTO usuarios (nombreusuario, claveacceso, apellidos, nombres)	VALUES
	('JHON', '123456', 'Francia Minaya','Jhon Edward'),
	('Nest', '123456', 'PQ','Nestor'),
	('JOEL','123456','Rojas Marcos','José Joel');
	
SELECT * FROM usuarios;


--  ACTUALIZAMOS  por clave encriptada
--  Defecto: SENATI
UPDATE usuarios SET
	claveacceso = '$2y$10$u.8fXT9uFZp/zbmsYp/liOVQGUPM9dDC4YxIWImmi6FEMjKl46TEW'
	WHERE idusuario = 1;
	
UPDATE usuarios SET
	claveacceso = '$2y$10$u.8fXT9uFZp/zbmsYp/liOVQGUPM9dDC4YxIWImmi6FEMjKl46TEW';
	
	
-- PROCEDIMIENTO LOGIN USUARIOS
DELIMITER $$
CREATE PROCEDURE spu_usuarios_login
(
	IN _nombreusuario VARCHAR(30)
)
BEGIN
	SELECT	idusuario, nombreusuario, claveacceso,
				apellidos,nombres,nivelacceso
		FROM usuarios
		WHERE nombreusuario = _nombreusuario AND estado = '1';
END $$

CALL spu_usuarios_login('JHON');

-- fin 
-- ====================================



--  PROCEDIMIENTOS ALMACENADO DE TABLA USARIO


-- REGISTRAR USUARIO
DELIMITER $$
CREATE PROCEDURE spu_usuarios_registrar
(
	IN _nombreusuario	VARCHAR(30),
	IN _nombres	VARCHAR(30),
	IN _apellidos	VARCHAR(30),
	IN _claveacceso	VARCHAR(90)		
)
BEGIN
	INSERT INTO usuarios (nombreusuario, nombres, apellidos, claveacceso) VALUES
		(_nombreusuario,_nombres, _apellidos, _claveacceso);
END $$


CALL spu_usuarios_registrar('LUI21', 'Luis', 'Mejia Atuncar', '123456');


--  MOSTRAR USUARIO
-- (puede ser modificado, despues de borrarlo)
DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()
BEGIN
	SELECT	
		idusuario,
		nombreusuario,
		nombres,
		apellidos,
		claveacceso
		FROM usuarios
		WHERE estado = '1'
		ORDER BY idusuario DESC;
END $$

CALL spu_usuarios_listar();


--  BORRAR USUARIOS
DELIMITER $$
CREATE PROCEDURE spu_usuarios_eliminar(IN _idusuario INT)
BEGIN
	UPDATE usuarios SET estado = '0' WHERE idusuario = _idusuario;
END $$

CALL spu_usuarios_eliminar(2);


--  ACTUALIZAR USUARIOS

DELIMITER $$
CREATE PROCEDURE spu_usuarios_actualizar(
	IN _idusuario	INT,  --  necesita el id por actualizar
	IN _nombreusuario	VARCHAR(30),
	IN _nombres	VARCHAR(30),
	IN _apellidos	VARCHAR(30),
	IN _claveacceso	VARCHAR(90)	
)
BEGIN
	UPDATE usuarios SET
		nombreusuario = _nombreusuario,
		nombres = _nombres,
		apellidos = _apellidos,
		claveacceso = _claveacceso
		
	WHERE idusuario = _idusuario;
END $$


CALL spu_usuarios_actualizar(4,'Manu77', 'Manuel', 'Marcos Rojas', '123456');


SELECT * FROM usuarios;

UPDATE usuarios SET claveacceso = '123456';
UPDATE usuarios SET estado = '1';
