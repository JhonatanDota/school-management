FROM node:18.17.1

ARG USER_ID

ARG GROUP_ID

WORKDIR /app

COPY ./entrypoint.sh /opt/sbin/entrypoint.sh

RUN chmod +x /opt/sbin/entrypoint.sh

RUN chown -R $USER_ID:$GROUP_ID /app && chown -R $USER_ID:$GROUP_ID /opt/sbin

EXPOSE 3000

EXPOSE 6006

ENTRYPOINT [ "/opt/sbin/entrypoint.sh" ]