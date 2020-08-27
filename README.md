# maestrobet.site

### Configurando

Levantando o Docker
```
docker-compose up -d
```

Instalando dependências (Pode demorar alguns minutos)
```
docker-compose exec web composer install -n -d /var/www/html/
```

Gerando tabela
```
docker-compose exec web php /var/www/html/vendor/bin/doctrine-module orm:schema-tool:update --force
```

### Testes unitários

Alterando para ambiente *development*
```
docker-compose exec web composer development-enable -d /var/www/html/
```

Executanto os testes unitários
```
docker-compose exec web php /var/www/html/vendor/bin/phpunit --coverage-text
```

Representação gerada pelo PHPUnit para visualização dos testes
```
./data/log/codeCoverage/index.html
```
