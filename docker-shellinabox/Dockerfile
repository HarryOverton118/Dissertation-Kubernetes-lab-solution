FROM ubuntu:latest

ENV SIAB_PORT=4200 \
    SIAB_ADDUSER=true \
    SIAB_USER=admin \
    SIAB_USERID=1000 \
    SIAB_GROUP=guest \
    SIAB_GROUPID=1000 \
    SIAB_PASSWORD=admin123pa55! \
    SIAB_SHELL=/bin/bash \
    SIAB_HOME=/home/guest \
    SIAB_SUDO=false \
    SIAB_SSL=true \
    SIAB_SERVICE=/:LOGIN \
    SIAB_PKGS=none \
    SIAB_SCRIPT=none

RUN apt-get update && apt-get install -y openssl curl openssh-client sudo shellinabox && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* 

EXPOSE 4200

VOLUME /etc/shellinabox /var/log/supervisor /home

ADD assets/entrypoint.sh /usr/local/sbin/

ENTRYPOINT ["entrypoint.sh"]
CMD ["shellinabox"]
