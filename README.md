# PaymentService RESTful API

![logo](https://miro.medium.com/max/625/1*N2jWB3rcBQdBpxhVbM_ZLg.png)

## Description
Генерация файла отчета выполняется в jobs через очереди.
Транзакции обрабатываются командой transaction:handle, которую можно вызывать кроном в определенный интервал времени.
Берется первая транзакция из новых (со статусом NEW), отсортированных по дате по возрастанию.
Создается транзакция БД, в которой выполняются операции, добавления суммы операции к счету получателя, списание со счета
 отправителя, установка статуса в COMPLETE, добавление id транзакции в таблицу last_transactions. Если одна из операций
не сработает то, все откатывается.

Routes

| Verb   | Path                    | Comment                     |
| ------ | ----------------------- | ----------------------------|
| POST   | /api/v1/register        | Register user and get token |
| POST   | /api/v1/transfer        | Create transaction          |
| POST   | /api/v1/currency-rate   | Create currency rate        |
| GET    | /transactions           | Get transactions            |
| GET    | /jobs                   | Get jobs                    |
| GET    | /jobs/1                 | Get job by id 1             |

## Stack:
![](https://img.shields.io/badge/-Laravel_8.18.1-brightgreen.png)
![](https://img.shields.io/badge/-Sail-green.png)
![](https://img.shields.io/badge/-PHP_7.4-red.png)
![](https://img.shields.io/badge/-PHPUnit-blue.png)
![](https://img.shields.io/badge/-Nginx-important.png)
![](https://img.shields.io/badge/-MySQL-blueviolet.png)
![](https://img.shields.io/badge/-Redis-yellow.png)


## Requirements
1. Docker
2. Git

## Installation

```
$ cd 'your_projects_directory'
$ git clone git@github.com:gruzintsev/payment_system.git
$ cd payment_system
$ composer install
$ Настроить .env . Установить APP_URL. 
$ ./vendor/bin/sail up -d
$ ./vendor/bin/sail exec laravel.test php artisan key:generate
$ ./vendor/bin/sail exec laravel.test php artisan migrate
$ ./vendor/bin/sail exec laravel.test php artisan db:seed
$ ./vendor/bin/sail exec laravel.test php artisan passport:install --force
$ ./vendor/bin/sail exec laravel.test php artisan storage:link
$ ./vendor/bin/sail exec laravel.test ./vendor/bin/phpunit 
$ ./vendor/bin/sail exec laravel.test php artisan transaction:handle - для обработки транзакций. Эту задачу можно поставить срабатывать по крону
$ ./vendor/bin/sail exec laravel.test php artisan queue:work - для обработки jobs
```
Иногда возникают проблемы с Permission denied на папку storage. Не успел разобраться как лучше настроить. 
Временно можно выполнить комманду
`./vendor/bin/sail exec laravel.test chmod -R 777 storage/`

## Test result

![](http://joxi.ru/YmEaxPwSwK8WMm.jpg)

## Usage
Add host to /etc/hosts

1. #### Register user and copy token for the next requests
    ![screen shot](http://joxi.ru/E2p14OaT7Ql1vA.jpg)
2. #### Add currency rate
    ![screen shot](http://joxi.ru/J2bV8Pwh0DPyY2.jpg)
3. #### Make refill
    ![screen shot](http://joxi.ru/bmoz43lF38DWdr.jpg)
4. #### Make transfer
    ![screen shot](http://joxi.ru/D2PY5Pwuq90xvA.jpg)

## Contact
[gruzintsev@gmail.com](mailto:gruzintsev@gmail.com)

Copyright 2020 Gruzintsev Vladimir
