FROM alpine:latest AS build

RUN (mkdir -p /FluxAutoloadApi/libs/polyfill-php80 && cd /FluxAutoloadApi/libs/polyfill-php80 && wget -O - https://github.com/symfony/polyfill-php80/archive/main.tar.gz | tar -xz --strip-components=1)
COPY . /FluxAutoloadApi

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/fluxapps/FluxAutoloadApi"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /FluxAutoloadApi /FluxAutoloadApi
