USE carteira;

DROP TABLE IF EXISTS tb_usuario;

CREATE TABLE tb_usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  email VARCHAR(100),
  senha VARCHAR(255)
);

DROP PROCEDURE IF EXISTS sp_validar_login;

DELIMITER //

CREATE PROCEDURE sp_validar_login (
    IN p_email VARCHAR(100), 
    IN p_senha VARCHAR(255)
)
BEGIN
    SELECT 
        nome,
        email,
        senha
    FROM 
        tb_usuario
    WHERE 
        email = p_email;
END;
//

DELIMITER ;
