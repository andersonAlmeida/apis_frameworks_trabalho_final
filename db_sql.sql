CREATE TABLE NIVEL
(
	COD_NIVEL SERIAL PRIMARY KEY,
	NOME VARCHAR(20) NOT NULL
);

CREATE TABLE ADMINISTRADOR
(
	COD_ADMIN SERIAL PRIMARY KEY,
	NOME VARCHAR(50),
	EMAIL VARCHAR(50) NOT NULL,
	SENHA VARCHAR(255) NOT NULL	
);

CREATE TABLE CLIENTE
(
	COD_CLIENTE SERIAL PRIMARY KEY,
    PONTUACAO INT DEFAULT 0,
	NOME VARCHAR(50),
	EMAIL VARCHAR(50) NOT NULL,
	SENHA VARCHAR(255) NOT NULL,
    COD_NIVEL INT
        REFERENCES NIVEL(COD_NIVEL)
);

CREATE TABLE ATRACAO_CATEGORIA
(
	COD_ATRACAO_CATEGORIA SERIAL PRIMARY KEY,
	NOME VARCHAR(20) NOT NULL
);

CREATE TABLE ATRACAO
(
	COD_ATRACAO SERIAL PRIMARY KEY,
    NOME VARCHAR(50) NOT NULL,
    DESCRICAO VARCHAR(250),
    DATA_INICIO TIMESTAMP,
    DATA_FIM TIMESTAMP,
    ENDERECO VARCHAR(200) NOT NULL,
    LAT FLOAT NOT NULL,
    LNG FLOAT NOT NULL,
	COD_ATRACAO_CATEGORIA INT 
		REFERENCES ATRACAO_CATEGORIA(COD_ATRACAO_CATEGORIA)
);

CREATE TABLE AVALIACAO
(
	COD_AVALIACAO SERIAL PRIMARY KEY,
	NOTA INT NOT NULL,
    COMENTARIO VARCHAR(500),
    COD_CLIENTE INT
        REFERENCES CLIENTE(COD_CLIENTE),
    COD_ATRACAO INT
        REFERENCES ATRACAO(COD_ATRACAO)
);

CREATE TABLE FOTO
(
	COD_FOTO SERIAL PRIMARY KEY,
	IMAGEM VARCHAR(250) NOT NULL,
	FOTOABLE_ID INT,
	FOTOABLE_TYPE VARCHAR(50)
);

CREATE TABLE CUPOM
(
	COD_CUPOM SERIAL PRIMARY KEY,
    DESCRICAO VARCHAR(100),
    DATA_CRIACAO TIMESTAMP NOT NULL,
    DATA_EXPIRACAO TIMESTAMP NOT NULL,
	COD_CLIENTE INT 
		REFERENCES CLIENTE(COD_CLIENTE)
);



