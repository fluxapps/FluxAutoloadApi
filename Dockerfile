FROM alpine:latest AS build

RUN (mkdir -p /flux-autoload-api/libs/polyfill-php80 && cd /flux-autoload-api/libs/polyfill-php80 && wget -O - https://github.com/symfony/polyfill-php80/archive/main.tar.gz | tar -xz --strip-components=1)
COPY . /flux-autoload-api

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/fluxapps/flux-autoload-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /flux-autoload-api /flux-autoload-api
