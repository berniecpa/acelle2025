FROM webdevops/php-apache:8.2

COPY . /app
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public

EXPOSE 80