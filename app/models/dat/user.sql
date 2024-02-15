create table users (
	login VARCHAR(30),
	passwd VARCHAR (30),
    Nombre VARCHAR(30),
    rol CHAR (1),
	CONSTRAINT pk_usuarios PRIMARY KEY(login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` (`login`, `passwd`, `Nombre`, `rol`) VALUES
('admin', 'admin', 'Administrador', 1),
('patata', '123456', 'Manolo', 1),
('user01', '12345', 'Pepe', 0);