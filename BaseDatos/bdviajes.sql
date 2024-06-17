CREATE DATABASE bdviajes;

CREATE TABLE persona (
    idpersona bigint AUTO_INCREMENT,
    numDocumento int,
    nombre varchar(150),
    apellido varchar(150),
    telefono int,
/*  email varchar(150), */
    PRIMARY KEY (numDocumento)
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
    rnumDocumento bigint,
    PRIMARY KEY (rnumDocumento)
    FOREIGN KEY (rnumDocumento) REFERENCES persona (numDocumento) 
    ON UPDATE CASCADE 
    ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    pdocumento varchar(15),
    -- pnombre varchar(150), 
    -- papellido varchar(150), 
	-- ptelefono int, 
	idviaje bigint,
    PRIMARY KEY (pdocumento),
    FOREIGN KEY (pdocumento) REFERENCES Persona (numDocumento)
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
