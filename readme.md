# SIPRO - Sistema de Provas
Este projeto tem como objetivo principal prover um sistema de provas para professores e alunos.

## Observação
O projeto foi constituído em 2016 e está passando por atualizações para que o mesmo possa voltar ao ar.

## Requirimentos
- php ^7.1.3
- composer ^1.2.2

## Instalação

### Debian

- **Comandos**
  - sudo apt -y install lsb-release apt-transport-https ca-certificates
  - sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
  - echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php7.3.list
  - sudo apt install php7.3 php-mbstring php-zip php-xml php-gd
  - sudo apt install nodejs
  - npm install
  - php composer.phar install
- **Processos**
  - Copiar .env.example para .env
  - Configurar .env
