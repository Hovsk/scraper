...to run the application execute following commands
1. ```composer install```
2. ```docker build -t scraper-img . ```
3. ```docker run -it --name scraper-container -v __**/your/host/path/**__ scraper/reports:/usr/src/scraper/reports scraper-img ```
