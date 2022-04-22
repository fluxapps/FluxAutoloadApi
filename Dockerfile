FROM composer:latest AS build

RUN (mkdir -p /flux-autoload-api/libs/polyfill-php80 && cd /flux-autoload-api/libs/polyfill-php80 && wget -O - https://github.com/symfony/polyfill-php80/archive/main.tar.gz | tar -xz --strip-components=1 && composer install --no-dev)
RUN (mkdir -p /flux-autoload-api/libs/polyfill-php81 && cd /flux-autoload-api/libs/polyfill-php81 && wget -O - https://github.com/symfony/polyfill-php81/archive/main.tar.gz | tar -xz --strip-components=1 && composer install --no-dev)
COPY . /flux-autoload-api

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/flux-eco/flux-autoload-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /flux-autoload-api /flux-autoload-api

ARG COMMIT_SHA
LABEL org.opencontainers.image.revision="$COMMIT_SHA"
