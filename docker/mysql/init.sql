USE carteira;

DROP TABLE IF EXISTS tb_usuario;

CREATE TABLE tb_usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  email VARCHAR(100),
  senha VARCHAR(255),
  saldo   DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE tb_transacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_from_id INT,
    user_to_id INT,
    valor DECIMAL(10,2) NOT NULL,
    tipo VARCHAR(50),
    reversivel BOOLEAN DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_user_from FOREIGN KEY (user_from_id) REFERENCES tb_usuario(id),
    CONSTRAINT fk_user_to FOREIGN KEY (user_to_id) REFERENCES tb_usuario(id)
);


DROP PROCEDURE IF EXISTS sp_validar_login;

DELIMITER //

CREATE PROCEDURE sp_validar_login (
    IN p_email VARCHAR(100)
)
BEGIN
    SELECT 
        id,
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



DELIMITER //

CREATE  PROCEDURE sp_select_saldo(
  IN p_usuario_id INT 
  )
BEGIN
	SELECT 
		id,
        nome,
        email,
        senha,
        saldo
        FROM tb_usuario WHERE id = p_usuario_id;
END
//

DELIMITER ;


DELIMITER //

CREATE PROCEDURE sp_insert_transacao (
    IN p_user_from_id INT,
    IN p_user_to_id INT,
    IN p_valor DECIMAL(10,2),
    IN p_tipo VARCHAR(50),
    IN p_reversivel BOOLEAN
)
BEGIN
    INSERT INTO tb_transacoes (
        user_from_id,
        user_to_id,
        valor,
        tipo,
        reversivel,
        criado_em
    ) VALUES (
        p_user_from_id,
        p_user_to_id,
        p_valor,
        p_tipo,
        p_reversivel,
        NOW()
    );
END //

DELIMITER ;




DELIMITER //


CREATE  PROCEDURE sp_select_historico_transacoes (IN p_usuario_id INT)
BEGIN
	select
        user_from_id,
        user_to_id,
        valor,
        tipo,
        reversivel,
        criado_em
    from tb_transacoes where user_from_id = p_usuario_id;

END//

DELIMITER ;


DELIMITER //

CREATE PROCEDURE `sp_update_reverte_operacao` (
    IN p_user_id INT,
    IN p_valor_remover DECIMAL(10,2)
)
BEGIN
    DECLARE usuario_saldo DECIMAL(10,2);
    DECLARE novo_saldo DECIMAL(10,2);

    SELECT saldo INTO usuario_saldo
    FROM tb_usuario
    WHERE id = p_user_id;

    SET novo_saldo = usuario_saldo - p_valor_remover;

    UPDATE tb_usuario
    SET saldo = novo_saldo
    WHERE id = p_user_id;
END//

DELIMITER ;
