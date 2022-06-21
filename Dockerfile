FROM alpine:latest AS build

COPY . /build/flux-autoload-api

RUN (cd /build && tar -czf flux-autoload-api.tar.gz flux-autoload-api)

FROM scratch

LABEL org.opencontainers.image.source="https://github.com/flux-eco/flux-autoload-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY --from=build /build /

ARG COMMIT_SHA
LABEL org.opencontainers.image.revision="$COMMIT_SHA"
