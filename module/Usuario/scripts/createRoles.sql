INSERT INTO
    Usuario_Banca(idUsuario, dataCriacao, status)
SELECT
    id,
    dataCriacao,
    status
FROM
    Usuario_Usuario
WHERE
    roles LIKE '%banca%';

INSERT INTO
    Usuario_Agente(idUsuario, dataCriacao, status)
SELECT
    id,
    dataCriacao,
    status
FROM
    Usuario_Usuario
WHERE
    roles LIKE '%agente%';

INSERT INTO
    Usuario_Cliente(idUsuario, dataCriacao, status)
SELECT
    id,
    dataCriacao,
    status
FROM
    Usuario_Usuario
WHERE
    roles LIKE '%cliente%';