В Web-приложении используется Redis Server, необходимое для создания обмена между Laravel и клиентом сервера: sudo apt install redis-server
Для связки установите пакет: composer require predis/predis
Установка laravel-echo-server: sudo npm install -g laravel-echo-server
Конфигурационный файл: laravel-echo-server init
npm install --save laravel-echo socket.io-client