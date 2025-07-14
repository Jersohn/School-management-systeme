FROM nginx:alpine
LABEL "Project"="sms"
LABEL "Author"="Jersohn"

RUN rm -rf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/conf.d/app.conf