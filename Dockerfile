ARG COMPOSER_IMAGE=composer:latest
ARG POLYFILL_PHP80_SOURCE_URL=https://github.com/symfony/polyfill-php80/archive/main.tar.gz
ARG POLYFILL_PHP81_SOURCE_URL=https://github.com/symfony/polyfill-php81/archive/main.tar.gz

FROM $COMPOSER_IMAGE AS build
ARG POLYFILL_PHP80_SOURCE_URL
ARG POLYFILL_PHP81_SOURCE_URL

RUN (mkdir -p /flux-autoload-api/libs/polyfill-php80 && cd /flux-autoload-api/libs/polyfill-php80 && wget -O - $POLYFILL_PHP80_SOURCE_URL | tar -xz --strip-components=1 && composer install --no-dev)
RUN (mkdir -p /flux-autoload-api/libs/polyfill-php81 && cd /flux-autoload-api/libs/polyfill-php81 && wget -O - $POLYFILL_PHP81_SOURCE_URL | tar -xz --strip-components=1 && composer install --no-dev)
COPY . /flux-autoload-api

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/fluxapps/flux-autoload-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /flux-autoload-api /flux-autoload-api
