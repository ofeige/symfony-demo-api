# symfony-demo-api
Symfony Demo Project for REST API including DTO, Mapper, unified rest url handling  

## installation

``` 
git clone git@github.com:ofeige/symfony-demo-vagrant.git
cd symfony-demo-vagrant
git clone git@github.com:ofeige/symfony-demo-ui.git ui
git clone git@github.com:ofeige/symfony-demo-api.git api
``` 

read the README.md from vagrant project in this folder (or here https://github.com/ofeige/symfony-demo-vagrant/blob/master/README.md) and follow the instruction

after succesfull build of vagrant run:
``` 
vagrant ssh
cd /vagrant/ui
composer install
cd /vagrant/api
composer install
``` 

now we have to setup the database
``` 
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate -n
bin/console doctrine:fixtures:load -n
``` 

now create keys for JWTs
```
$ mkdir config/jwt
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

In case first openssl command forces you to input password use following to get the private key decrypted
```
$ openssl rsa -in config/jwt/private.pem -out config/jwt/private2.pem
$ mv config/jwt/private.pem config/jwt/private.pem-back
$ mv config/jwt/private2.pem config/jwt/private.pem
```

now you can call http://api.demo.test/api/doc with user basic:basic
