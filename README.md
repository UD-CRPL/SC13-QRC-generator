SC13 QRC generator 
---------------------------

This software was used to generate the QRC placeholders used in the SC13 poster sessions. It makes use of the PHP QR Code library (http://phpqrcode.sourceforge.net/). 

Installation
---------------------------
You'll need an apache web server with PHP support. Copy the source directory somewhere where the web server can see it. 

Add full permissions to the tmp directory ( chmod 777 {source dir}/tmp )

Obtain a bit.ly access token key from:  https://bitly.com/a/oauth_apps                                                 

Copy the bit.ly api key into the action.php file on this line: $BITLY_ACCESS_TOKEN = "[YOUR BITLY API TOKEN]";

Usage
---------------------------

Point your web browser to the directory where you installed the scripts. The page has instructions on how to use the scripts. 

The form takes 5 pipe ( | ) separated values per line:
- Placeholder title (SC13 Technical Program - Poster). 
- QRC URL (http://example.com)
- Poster Number (#1 - if you want a pound sign you need to include it in the string)
- Poster section (ACM)
- Poster Title

The URL will automatically be shortened via bit.ly. Use Chrome or Safari for the best results when printing.