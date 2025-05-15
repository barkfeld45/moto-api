CREATE TABLE IF NOT EXISTS motos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  marca VARCHAR(100),
  modelo VARCHAR(100),
  ano INT,
  cor VARCHAR(50),
  quilometragem INT
);