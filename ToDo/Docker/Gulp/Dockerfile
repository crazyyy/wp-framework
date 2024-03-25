FROM ubuntu:16.04

RUN apt-get update && apt-get -y install wget && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
    -o APT::AutoRemove::SuggestsImportant=false $buildDeps

RUN wget --no-check-certificate https://nodejs.org/dist/v8.9.4/node-v8.9.4-linux-x64.tar.gz && \
    tar --strip-components 1 -xzvf node-v* -C /usr/local

COPY ./entrypoint.sh /

WORKDIR /app

CMD ["./entrypoint.sh"]
