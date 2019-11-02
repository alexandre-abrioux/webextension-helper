FROM node:alpine

ENV NODE_ENV=production
ENV NPM_CONFIG_PREFIX=/home/node/.npm-global
ENV PATH=$PATH:/home/node/.npm-global/bin
WORKDIR /usr/src/app/
USER node

ENTRYPOINT ["web-ext"]
RUN npm install --global web-ext
