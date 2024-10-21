FROM node:23.0.0-alpine3.20 AS base
WORKDIR /usr/src
COPY ./frontend/package.* ./
RUN npm install
COPY ./frontend .

FROM base AS dev
EXPOSE 80
CMD [ "npm", "run", "serve" ]

FROM base AS build
RUN npm run build

FROM nginx:1.27.2-alpine AS prod
COPY --from=build /usr/src/dist /usr/share/nginx/html
COPY ./deployment/config/nginx-frontend.conf /etc/nginx/nginx.conf
EXPOSE 80
CMD [ "nginx", "-g", "daemon off;" ]
