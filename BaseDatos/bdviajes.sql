CREATE DATABASE bdviajes;

CREATE TABLE persona (
    idpersona bigint AUTO_INCREMENT,
    nrodoc int,
    nombre varchar(150),
    apellido varchar(150),
    telefono int,
    PRIMARY KEY (idpersona)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    ridpersona bigint,
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (ridpersona) REFERENCES persona (idpersona) 
    ON UPDATE CASCADE 
    ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, 
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa) ON UPDATE CASCADE
    ON DELETE CASCADE,
	FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    pidpersona bigint,
	idviaje bigint,
    PRIMARY KEY (pidpersona),
    FOREIGN KEY (pidpersona) REFERENCES Persona (idpersona) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje) ON UPDATE CASCADE ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
