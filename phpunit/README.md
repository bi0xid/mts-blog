Test run:
All test without excluded groups:
    php phpunit.phar -c phpunit.xml

Specific groups or files of tests:
    php phpunit.phar --group hard-loaded -c phpunit.xml tests/imagesTest.php
    php phpunit.phar --group full-redirection -c phpunit.xml tests/fullStatusAndRedirections.php /* reports with errors from this test are located in tests/reports */



#!!!!!!!!not run please!!!!!!!#
php -d memory_limit=-1 -f fileCrawler.php with root user
php -d memory_limit=-1 -f urlCrawler.php with root user

TODO:
1. test newsletter