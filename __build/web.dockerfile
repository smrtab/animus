FROM nginx
COPY ./__build/nginx.conf /etc/nginx/conf.d/default.conf