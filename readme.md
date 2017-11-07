# SIPRO - Sistema de Provas
O tema vislumbrará através de práticas computacionais e estudos teóricos: a necessidade, a viabilidade e criação de um sistema online auxiliador para docentes e discentes. Incumbirá, ideologicamente, desde a constituição dos sistemas avaliativos até o feedback de resolução destes questionários ou testes ou provas ou produções textuais.

## Observação
O projeto foi constituído em 2016 e passará por atualizações para que o mesmo possa voltar ao ar.

## Passos Iniciais
1. Após instalar o composer executar o comando: composer create-project --prefer-dist laravel/laravel nomedoprojeto
2. Configurar acesso a base de dados no arquivo /.env
3. Instalar autenticação por redes sociais pelo comando: composer require laravel/socialite
3. composer require "laravelcollective/html":"^5.5.0"
4. chmod 755 -R *
4. chmod 777 storage/ -R
4. chmod 777 bootstrap/cache -R
4. mkdir public/assets/images/uploads/
4. chmod 777 public/assets/images/uploads/
4. remover arquivo 2014_10_12_100000_create_password_resets_table.php
4. remover arquivo 2014_10_12_000000_create_users_table.php
4. Sobrescrever com os arquivos do git.
5. php artisan migrate
5. executar composer install