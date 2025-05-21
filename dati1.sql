DROP DATABASE IF EXISTS MemoriaLinkDB;

-- Creazione Database
CREATE DATABASE MemoriaLinkDB;
USE MemoriaLinkDB;

-- Tabella utenti
CREATE TABLE utenti (
    id_utente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Tabella ricordi (con file_path)
CREATE TABLE ricordi (
    id_ricordo INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT NOT NULL,
    titolo VARCHAR(100) NOT NULL,
    testo TEXT NOT NULL,
    data_evento DATE NOT NULL,
    file_path VARCHAR(255),
    FOREIGN KEY (id_utente) REFERENCES utenti(id_utente) ON DELETE CASCADE
);

-- Tabella commenti
CREATE TABLE comments (
    id_commento INT AUTO_INCREMENT PRIMARY KEY,
    id_ricordo INT NOT NULL,
    id_utente INT NOT NULL,
    testo TEXT NOT NULL,
    data_commento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ricordo) REFERENCES ricordi(id_ricordo) ON DELETE CASCADE,
    FOREIGN KEY (id_utente) REFERENCES utenti(id_utente) ON DELETE CASCADE
);

-- Tabella "Mi Piace" ai ricordi
CREATE TABLE likes (
    id_like INT AUTO_INCREMENT PRIMARY KEY,
    id_ricordo INT NOT NULL,
    id_utente INT NOT NULL,
    FOREIGN KEY (id_ricordo) REFERENCES ricordi(id_ricordo) ON DELETE CASCADE,
    FOREIGN KEY (id_utente) REFERENCES utenti(id_utente) ON DELETE CASCADE
);

-- **Popolamento con alcuni utenti**
INSERT INTO utenti (nome, email, username, password) VALUES
('Giulia', 'giulia@example.com', 'GiuliaMemoria', 'password123'),
('Marco', 'marco@example.com', 'MarcoRicordi', 'securepass456');

-- **Popolamento con ricordi**
INSERT INTO ricordi (id_utente, titolo, testo, data_evento, file_path) VALUES
(1, 'Viaggio in Toscana', 'Passeggiata tra i vigneti del Chianti!', '2023-06-10', null),
(1, 'Festival Musicale', 'Concerto indimenticabile con amici!', '2024-04-23', null),
(2, 'Gita in bicicletta', 'Pedalato lungo il fiume Arno, tramonto spettacolare!', '2023-09-05', null);

-- **Verifica se i dati sono inseriti correttamente**
SELECT * FROM ricordi;
