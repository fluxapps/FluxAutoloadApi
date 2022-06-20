FROM scratch

LABEL org.opencontainers.image.source="https://github.com/flux-eco/flux-autoload-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

COPY . /flux-autoload-api

ARG COMMIT_SHA
LABEL org.opencontainers.image.revision="$COMMIT_SHA"
