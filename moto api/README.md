# API de Motos (PHP + MySQL via Docker Compose)

Esta API REST permite cadastrar, listar, atualizar e deletar informações de motos. 

## 🧱 Campos da Moto

- `marca`: Ex: Yamaha
- `modelo`: Ex: MT-07
- `ano`: Ex: 2021
- `cor`: Ex: Azul
- `quilometragem`: Ex: 15000

## 🚀 Como Executar

### Pré-requisitos

- Docker
- Docker Compose

### Passos

1. Clone o repositório:
   ```bash
   git clone https://github.com/barkfeld45/moto-api.git
   cd moto-api

2. Suba o ambiente:

docker-compose up -d

3. Acesse a API:

http://localhost:8080/index.php/motos

4. utilize postman para fazer CRUD


🧹 Encerrar o ambiente

docker-compose down