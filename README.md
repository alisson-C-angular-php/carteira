# 💰 Carteira Financeira - CodeIgniter 4

Este é um sistema de **carteira digital** desenvolvido com **CodeIgniter 4**, aplicando o padrão de arquitetura **hexagonal (Ports and Adapters)**. Ele permite:

- ✅ Cadastro de usuários
- 💵 Realização de depósitos e transferências
- ↩️ Reversão de transações
- 📊 Visualização de histórico e saldo

---

## 📁 Arquitetura Hexagonal

A estrutura segue o padrão hexagonal, separando as responsabilidades em camadas bem definidas:

- `App\Domain`: Interfaces e regras de negócio
- `App\Infrastructure`: Repositórios, models e implementação dos serviços
- `App\Controllers`: Pontos de entrada (adapters)

---

## ✅ Requisitos

- PHP 8.1+
- Composer
- Docker e Docker Compose


---

## ⚙️ Instalação

### 1. Clonando o Repositório

Clone o repositório:

```bash
git clone https://github.com/alisson-C-angular-php/carteira.git
cd carteira
docker-compose up -d
```

Para rodar os teste unitarios instale as dependencias com
```bash
composer intall
```

e execulte no terminal 

```bash

vendor/bin/phpunit           
```
