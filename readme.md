# SIPRO - Sistema de Provas
Este projeto tem como objetivo principal prover um sistema de provas para professores e alunos.

# Badges
## Github
![tag](https://img.shields.io/github/tag/guifabrin/sipro.svg)
![issues](https://img.shields.io/github/issues/guifabrin/sipro.svg)
![contributors](https://img.shields.io/github/contributors/guifabrin/sipro.svg)
![license](https://img.shields.io/github/license/guifabrin/sipro.svg)
![code-size](https://img.shields.io/github/languages/code-size/guifabrin/sipro.svg)
![top-languages](https://img.shields.io/github/languages/top/guifabrin/sipro.svg)
![languages](https://img.shields.io/github/languages/count/guifabrin/sipro.svg)

### Social
![forks](https://img.shields.io/github/forks/guifabrin/sipro.svg?style=social)
![stars](https://img.shields.io/github/stars/guifabrin/sipro.svg?style=social)
![watchers](https://img.shields.io/github/watchers/guifabrin/sipro.svg?style=social)
![followers](https://img.shields.io/github/followers/guifabrin.svg?style=social)

## Others
[![BCH compliance](https://bettercodehub.com/edge/badge/guifabrin/sipro?branch=master)](https://bettercodehub.com/)
### Scrutinizer
[![Scrutinizer](https://scrutinizer-ci.com/g/guifabrin/sipro/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/guifabrin/sipro/badges/quality-score.png?b=master)
[![Build](https://scrutinizer-ci.com/g/guifabrin/sipro/badges/build.png?b=master)](https://scrutinizer-ci.com/g/guifabrin/sipro/badges/build.png?b=master)
[![Code intelligence](https://scrutinizer-ci.com/g/guifabrin/sipro/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/g/guifabrin/sipro/badges/code-intelligence.svg?b=master)

# Configuração básica do servidor e máquina de desenvolvimento

Ubuntu:
- sudo apt install lamp-server^
- sudo apt install git
- sudo apt install composer
- sudo apt install php-mbstring php-xml
- sudo apt install acl

# Configuração desenvolvimento
- Clonar repositório
- Instalar ruby 2.6.1p33
- Executar: bundle install
- Copiar arquivo .env para .env.example
- Executar: php composer install
- Executar: php artisan key:generate

# Configuração para deploy
## .env
Configurar as seguintes chaves:

- **DEPLOY_REPO**=URL SSH do GIT
- **DEPLOY_TO**=Pasta para quais os arquivos irão automaticamente
- **DEPLOY_PROD_HOST**=IP ou DNS do Servidor para qual irá o deploy
- **DEPLOY_PROD_USER**=Usuário da máquina com permissões para deploy
- **DEPLOY_PROD_PASS**=Senha do Usuário acima

## Capistrano
- Para testar executar: 'cap production deploy:check'
- Para deploy executar: 'cap production deploy'

## Configuração .env em produção caso primeira instalação
- Na pasta 'shared' após o primeiro deploy, criar o arquivo .env e adicionar a parte relacionada apenas ao Laravel.
- Configurar apache para apontar para a pasta 'current' do deploy.

# Sistema Online
> Atualmente o sistema está dispível em [https://guifabrin.dev/sipro](https://guifabrin.dev/sipro) é gratuíto e você pode usar quando quiser.

# Contribuições
Toda contribuição é bem vinda.