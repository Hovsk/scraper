...to run the application execute following commands
1. docker build -t scraper-img .
2. docker run -it --name scraper-container -v /your/file/path/scraper/reports:/usr/src/scraper/reports scraper-img
