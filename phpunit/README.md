Test run:
All test without excluded groups:
    php phpunit.phar -c phpunit.xml

Specific groups or files of tests:
    php phpunit.phar --group hard-loaded -c phpunit.xml tests/imagesTest.php
    php phpunit.phar --group full-redirection -c phpunit.xml tests/fullStatusAndRedirections.php /* report from test located in tests/reports */




TODO:
1. test newsletter