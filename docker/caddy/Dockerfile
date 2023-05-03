FROM caddy:alpine

LABEL maintainer="Adrian Mejias"

ARG WWWGROUP

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apk add --no-cache bash \
    && apk add --no-cache nss-tools \
    && rm -rf /var/cache/apk/*

RUN addgroup -S $WWWGROUP
RUN adduser -G $WWWGROUP -u 1337 -S sail

COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
