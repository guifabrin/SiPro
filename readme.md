# SIPRO - Sistema de Provas
O tema vislumbrará através de práticas computacionais e estudos teóricos: a necessidade, a viabilidade e criação de um sistema online auxiliador para docentes e discentes. Incumbirá, ideologicamente, desde a constituição dos sistemas avaliativos até o feedback de resolução destes questionários ou testes ou provas ou produções textuais.

## Observação
O projeto foi constituído em 2016 e passou por atualizações para que o mesmo possa voltar ao ar.

## Requirimentos
php ^7.1.3
composer ^1.2.2

## Instalação

### Debian
sudo apt -y install lsb-release apt-transport-https ca-certificates 
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php7.3.list
sudo apt-get install php7.3 php-mbstring php-zip php-xml php-gd


Install nodejs

npm install
php composer.phar install

Copy .env.example to .env
Configure .env
