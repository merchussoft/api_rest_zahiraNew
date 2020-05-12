-- se crea la tabla de modulos para tener mas control en cada modulo donde va a acceder el usuario
create table if not exists modulos(
  cod_modulo int auto_increment primary key,
  nombre varchar(100) unique not null,
  ubicacion varchar(150) unique,
  activo tinyint default 1,
  icono varchar(50)
);

-- ## se crea la tabla permisos y se relaciona con cada uno de las tablas que debe ir
create table if not exists permisos(
  cod_permiso int auto_increment primary key,
  cod_usuario int(11),
  cod_modulo int(11),
  createAt timestamp default CURRENT_TIMESTAMP ON update CURRENT_TIMESTAMP,
  FOREIGN KEY (cod_usuario) REFERENCES usuarios(cod_usuario),
  FOREIGN KEY (cod_modulo) REFERENCES modulos(cod_modulo)
);
