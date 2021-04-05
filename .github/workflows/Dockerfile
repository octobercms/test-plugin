FROM aspendigital/octobercms:develop

# Default options
ENV INIT_OCTOBER="true"
ENV APP_DEBUG="true"

# Install the test plugin
COPY ./ /var/www/html/plugins/october/test

# Set admin password
RUN php /var/www/html/artisan october:passwd admin admin