# Guia de Instalação - Sysform em Ubuntu com Nginx

## 📋 Pré-requisitos

- Ubuntu 20.04 LTS ou superior
- Acesso root ou usuário com privilégios sudo
- Conexão com a internet

## 🔧 Passo 1: Atualizar o Sistema

```bash
sudo apt update
sudo apt upgrade -y
```

## 🔧 Passo 2: Instalar PHP e Extensões Necessárias

```bash
# Adicionar repositório PHP (opcional - para versão mais recente)
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update

# Instalar PHP 8.1+ (ou versão desejada)
sudo apt install -y php8.1-fpm php8.1-cli php8.1-pgsql php8.1-mysql php8.1-curl php8.1-xml php8.1-mbstring php8.1-zip php8.1-intl

# Verificar instalação
php --version
```

## 🔧 Passo 3: Instalar Nginx

```bash
sudo apt install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# Verificar status
sudo systemctl status nginx
```

## 🔧 Passo 4: Instalar Composer

```bash
# Download e instalação global
cd /tmp
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php

# Verificar instalação
composer --version
```

## 🔧 Passo 5: Clonar/Transferir o Projeto

```bash
# Criar diretório para a aplicação
sudo mkdir -p /var/www/sysform

# Se estiver transferindo via SCP:
scp -r /caminho/local/Sysform/* usuario@servidor:/var/www/sysform/

# Ou se estiver no servidor, fazer clone do repositório
cd /var/www/sysform
git clone <seu-repositorio> .

# Dar permissões corretas
sudo chown -R www-data:www-data /var/www/sysform
sudo chmod -R 755 /var/www/sysform
sudo chmod -R 775 /var/www/sysform/public
```

## 🔧 Passo 6: Instalar Dependências PHP

```bash
cd /var/www/sysform
composer install --no-dev
```

## 🔧 Passo 7: Configurar Banco de Dados

### Opção A: PostgreSQL (conforme phinx.php)

```bash
# Instalar PostgreSQL
sudo apt install -y postgresql postgresql-contrib

# Acessar PostgreSQL
sudo -u postgres psql

# No prompt do PostgreSQL, executar:
CREATE USER militar WITH PASSWORD 'forms3Mil';
CREATE DATABASE militar OWNER militar;
ALTER USER militar CREATEDB;
GRANT ALL PRIVILEGES ON DATABASE militar TO militar;
\q

# Se usar um esquema específico:
sudo -u postgres psql -d militar -c "CREATE SCHEMA forms_militar;"
sudo -u postgres psql -d militar -c "GRANT ALL PRIVILEGES ON SCHEMA forms_militar TO militar;"
```

### Opção B: MySQL/MariaDB

```bash
# Instalar MariaDB
sudo apt install -y mariadb-server

# Acessar MySQL
sudo mysql

# Executar:
CREATE DATABASE militar;
CREATE USER 'militar'@'localhost' IDENTIFIED BY 'forms3Mil';
GRANT ALL PRIVILEGES ON militar.* TO 'militar'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## 🔧 Passo 8: Executar Migrations do Banco de Dados

```bash
cd /var/www/sysform

# Listar migrations
vendor/bin/phinx status -e development

# Executar migrations
vendor/bin/phinx migrate -e development

# Ou executar seed (se necessário)
vendor/bin/phinx seed:run -e development
```

## 🔧 Passo 9: Configurar Nginx

Criar arquivo de configuração do Nginx:

```bash
sudo nano /etc/nginx/sites-available/sysform
```

Adicionar o seguinte conteúdo:

```nginx
server {
    listen 80;
    listen [::]:80;
    
    server_name seu-dominio.com;
    
    root /var/www/sysform/public;
    index index.php index.html;
    
    # Logs
    access_log /var/log/nginx/sysform_access.log;
    error_log /var/log/nginx/sysform_error.log;
    
    # Configurações de segurança
    client_max_body_size 100M;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    
    # Bloquear acesso a arquivos sensíveis
    location ~ /\. {
        deny all;
    }
    
    location ~ ~$ {
        deny all;
    }
}
```

**Nota:** Substitua `seu-dominio.com` pelo seu domínio real ou IP do servidor.

## 🔧 Passo 10: Ativar a Configuração do Nginx

```bash
# Criar link simbólico para ativar o site
sudo ln -s /etc/nginx/sites-available/sysform /etc/nginx/sites-enabled/

# Remover configuração padrão (opcional)
sudo rm /etc/nginx/sites-enabled/default

# Testar configuração do Nginx
sudo nginx -t

# Reiniciar Nginx
sudo systemctl restart nginx
```

## 🔧 Passo 11: Configurar SSL/TLS (Let's Encrypt - Opcional mas Recomendado)

```bash
# Instalar Certbot
sudo apt install -y certbot python3-certbot-nginx

# Gerar certificado
sudo certbot --nginx -d seu-dominio.com

# Auto-renovação
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer

# Testar renovação
sudo certbot renew --dry-run
```

## 🔧 Passo 12: Configurar Variáveis de Ambiente (se necessário)

```bash
# Criar arquivo .env na raiz do projeto (se a aplicação usar)
sudo nano /var/www/sysform/.env
```

Adicionar as configurações necessárias:

```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=militar
DB_USER=militar
DB_PASSWORD=forms3Mil
APP_ENV=production
APP_DEBUG=false
```

## ✅ Passo 13: Verificar a Instalação

1. Abrir navegador e acessar:
   ```
   http://seu-dominio.com
   ou
   http://seu-ip-do-servidor
   ```

2. Verificar logs em caso de erro:
   ```bash
   # Logs do Nginx
   sudo tail -f /var/log/nginx/sysform_error.log
   
   # Logs do PHP-FPM
   sudo tail -f /var/log/php8.1-fpm.log
   
   # Logs da aplicação (se houver)
   tail -f /var/www/sysform/logs/app.log
   ```

## 🔐 Passo 14: Configurações de Segurança Adicionais

```bash
# Criar arquivo .htaccess ou configurar Nginx para negar acesso a diretórios sensíveis
sudo nano /etc/nginx/sites-available/sysform

# Adicionar bloco de segurança adicional:
location ~ /vendor/ {
    deny all;
}

location ~ /db/ {
    deny all;
}

location ~ /(composer.json|phinx.php|.env)$ {
    deny all;
}
```

Reiniciar Nginx:
```bash
sudo systemctl restart nginx
```

## 📦 Estrutura de Diretórios Esperada

```
/var/www/sysform/
├── app/
├── db/
├── public/          # Raiz do Nginx
├── views/
├── vendor/
├── composer.json
├── phinx.php
├── index.php
└── .env (variáveis de ambiente)
```

## 🐛 Troubleshooting

### Erro 502 Bad Gateway
```bash
# Verificar se PHP-FPM está rodando
sudo systemctl status php8.1-fpm

# Reiniciar PHP-FPM
sudo systemctl restart php8.1-fpm
```

### Permissão Negada
```bash
# Restaurar permissões
sudo chown -R www-data:www-data /var/www/sysform
sudo chmod -R 755 /var/www/sysform
```

### Database Connection Error
```bash
# Verificar se banco está rodando
sudo systemctl status postgresql
# ou
sudo systemctl status mariadb

# Testar conexão
psql -h localhost -U militar -d militar
# ou
mysql -h localhost -u militar -p militar
```

### Arquivo .php não é processado
```bash
# Verificar se socket PHP-FPM está correto em /etc/nginx/sites-available/sysform
# Para encontrar o socket correto:
find /var/run -name "*.sock" | grep php
```

## 📝 Comandos Úteis Pós-Instalação

```bash
# Verificar versão do PHP
php --version

# Listar módulos PHP instalados
php -m

# Atualizar dependências Composer
composer update

# Limpar cache Composer
composer clear-cache

# Verificar status dos serviços
sudo systemctl status nginx
sudo systemctl status php8.1-fpm
sudo systemctl status postgresql

# Ver logs em tempo real
sudo tail -f /var/log/nginx/sysform_error.log
```

---

## 📞 Suporte

Caso encontre erros, verifique:
1. Logs do Nginx: `/var/log/nginx/sysform_error.log`
2. Logs do PHP: `/var/log/php8.1-fpm.log`
3. Permissões dos arquivos
4. Status dos serviços (Nginx, PHP-FPM, Database)
5. Conectividade do banco de dados

---

**Última atualização:** 4 de fevereiro de 2026
