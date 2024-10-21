CREATE DATABASE monitoramento_idosos;

USE monitoramento_idosos;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE monitoramento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    pressao VARCHAR(50),
    batimentos VARCHAR(50),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE medicamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nome VARCHAR(255),
    data DATE,
    hora TIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);


CREATE TABLE postagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    postagem_id INT NOT NULL,
    usuario_id INT NOT NULL,
    comentario TEXT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (postagem_id) REFERENCES postagens(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO postagens (titulo, conteudo) VALUES 
('Dica para Manter a Hidratação na Terceira Idade', 'ADM: Use Lembretes Visuais: Coloque garrafas de água em lugares visíveis da casa, como na mesa de café ou na cozinha, para lembrar de beber água.'),
('A Importância da Atividade Física Após os 60 Anos', 'Iniciar uma rotina de exercícios pode parecer desafiador, mas é importante lembrar que qualquer atividade conta. Caminhadas curtas, jardinagem, dançar ou até mesmo subir escadas são formas válidas de manter-se ativo. Antes de começar qualquer programa de exercícios, é sempre recomendável consultar um médico, especialmente para aqueles com condições de saúde pré-existentes.

A atividade física não apenas fortalece o corpo, mas também enriquece a vida, promovendo bem-estar físico e emocional. Portanto, nunca é tarde para começar!');
  
 ALTER TABLE comentarios ADD avaliacao INT(1) NOT NULL DEFAULT 0;
 
 
SELECT nome, data, hora FROM medicamentos WHERE usuario_id = henrique;

 










