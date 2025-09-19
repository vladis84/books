FROM nginx:1.18.0

# Add user from .env file
ARG UID
ARG GID
ARG UNAME

RUN usermod -u ${UID} nginx
