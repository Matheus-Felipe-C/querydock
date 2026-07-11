# ─── Stage 1: Build frontend assets ───────────────────────────────────────────
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ─── Stage 2: Production image ────────────────────────────────────────────────
FROM dunglas/frankenphp

WORKDIR /app

# Copy app source
COPY . .

# Copy compiled frontend assets from stage 1
COPY --from=frontend /app/public/build /app/public/build

# Install PHP extensions
RUN install-php-extensions \
    pdo_pgsql \
    zip

# Install Composer dependencies
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Copy Caddyfile
COPY Caddyfile /etc/caddy/Caddyfile

# config:cache REMOVED from here — needs APP_KEY at runtime

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]