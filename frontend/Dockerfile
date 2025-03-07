FROM node:lts-alpine AS base

WORKDIR /usr/src
COPY ./frontend/package*.json ./
RUN npm install
COPY ./frontend .

FROM base AS dev
EXPOSE 80
#CMD [ "npm", "run", "dev" ]
#EXPOSE 5173
CMD [ "npm", "run", "dev", "--", "--host", "0.0.0.0" ]

FROM bas AS build
RUN npm install build

FROM nginx:1.25.1-alpine AS prod
COPY --from=build /usr/src/dist /usr/share/nginx/html
COPY ./deployment/config/nginx-frontend.conf /etc/nginx/nginx.conf
EXPOSE 80
CMD [ "nginx", "-g", "daemon off;" ]