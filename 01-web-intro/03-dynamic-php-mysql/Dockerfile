# PHP 공식 이미지에는 MySQL 드라이버가 미포함이므로 직접 설치해야 한다
FROM php:8.3-fpm
# pdo: PHP Data Objects (DB 접근 추상화 계층)
# pdo_mysql: MySQL 전용 PDO 드라이버
RUN docker-php-ext-install pdo pdo_mysql
