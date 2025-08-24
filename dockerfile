FROM webdevops/php-apache:8.2

COPY . /app
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public

RUN chmod -R 775 /app/storage /app/bootstrap/cache && \
    chown -R application:application /app

EXPOSE 80