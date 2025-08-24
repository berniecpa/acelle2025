FROM webdevops/php-apache:8.2

COPY . /app
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public

# Fix permissions with 775
RUN chmod -R 775 /app/storage /app/bootstrap/cache && \
    chown -R application:application /app/storage /app/bootstrap/cache && \
    chmod -R 775 /storage && \
    chown -R application:application /storage

EXPOSE 80