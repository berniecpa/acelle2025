FROM webdevops/php-apache:8.2

COPY . /app
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public

# Create directories if needed and fix permissions
RUN mkdir -p /storage /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache && \
    chmod -R 775 /storage && \
    chown -R application:application /app /storage

EXPOSE 80