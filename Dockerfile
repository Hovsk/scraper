FROM php:7.4-cli
COPY . /usr/src/scraper
WORKDIR /usr/src/scraper
VOLUME /usr/src/scraper/reports
CMD [ "php", "./scraper.php" ]
