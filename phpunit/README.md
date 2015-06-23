Test run:
All test without excluded groups: php phpunit.phar -c phpunit.xml
Specific groups or files of tests: php phpunit.phar --group hard-loaded -c phpunit.xml tests/imagesTest.php

Need to discuss how to test following rule:
# BEGIN W3TC Skip 404 error handling by WordPress for static files
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} !(robots\.txt|([a-z]+)?-?sitemap.xsl|sitemap(_index)?\.xml(\.gz)?|[a-z0-9_\-]+-sitemap([0-9]+)?\.xml(\.gz)?|sitemap(-+([a-zA-Z0-9_-]+))?\.xml(.gz)?|sitemap(-+([a-zA-Z0-9_-]+))?\.html(.gz)?)
    RewriteCond %{REQUEST_FILENAME} \.(css|htc|less|js|js2|js3|js4|html|htm|rtf|rtx|svg|svgz|txt|xsd|xsl|xml|asf|asx|wax|wmv|wmx|avi|bmp|class|divx|doc|docx|eot|exe|gif|gz|gzip|ico|jpg|jpeg|jpe|json|mdb|mid|midi|mov|qt|mp3|m4a|mp4|m4v|mpeg|mpg|mpe|mpp|otf|odb|odc|odf|odg|odp|ods|odt|ogg|pdf|png|pot|pps|ppt|pptx|ra|ram|svg|svgz|swf|tar|tif|tiff|ttf|ttc|wav|wma|wri|woff|xla|xls|xlsx|xlt|xlw|zip)$ [NC]
    RewriteRule .* - [L]
</IfModule>
# END W3TC Skip 404 error handling by WordPress for static files