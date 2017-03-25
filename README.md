# Mitt Feriested
School project in IT1 with Johannes Hansen Aas

## Installation:

* Download and install WAMP.
* Make sure it uses PHP 7 or later.
* Download this repository
* Make a virtual host for "src/"
* Run create_database.sql to create the database
* Make sure your sql editor of choice allows you to delete all rows in a table (For MySQLWorkbench, Go to Edit -> Preferences -> "SQL Editor" -> "Other" -> uncheck "Safe Updates". Then go to Query -> Reconnect to Server)
* Run create_attractions.sql
* In httpd.conf, set "ErrorDocument 404 /?page=notfound". (Find line and uncomment)

## To create SSL sertificate (HTTPS):

* Add "C:\wamp64\bin\apache\apache2.4.23\bin" (or the appropriate for your installation) to the PATH (google PATH Enviromental variable)
* Add "OPENSSL_CONF" as enviromental variable and assign it to "C:\wamp64\bin\apache\apache2.4.23\conf\openssl.cnf" (or the appropriate for your installation)
* Run openssl to verify that the config file has loaded properly
* Run "openssl req -x509 -new -out my.root.ca.crt -keyout my.root.ca.key -days 3650" to create certificate.
PEM pass phrase -> password1
Country Name -> NO
State / Province -> Møre og Romsdal
City -> Ålesund
Organization Name -> Faroe Adventures INC
Unit Name -> .
Common Name -> faroeadventures.com
Email Address -> [whatever appropriate]

* Run "openssl req -newkey rsa:2048 -out faroeadventures.com.csr -pubkey -new -keyout faroeadventures.com.key"
PEM pass phrase -> password1
Country Name -> NO
State / Province -> Møre og Romsdal
City -> Ålesund
Organization Name -> Faroe Adventures INC
Unit Name -> .
Common Name -> faroeadventures.com
Email Address -> [whatever appropriate]

A challenge password -> hello
An optional company name -> .

* Run "openssl x509 -req -in faroeadventures.com.csr -CA root.ca.crt -CAkey root.ca.key -CAcreateserial -out faroeadventures.com.crt -days 3650" (as administrator)
pass phrase -> password1

* Run "openssl rsa -in faroeadventures.com.key >> faroeadventures.com.nopass.key"
pass phrase -> password1

### To load into apache:

* Backup everything (config files esp.)

* Uncomment “;extension=php_openssl.dll” in the php.ini file. (if commented, wasn't for me)
* Uncomment “#LoadModule ssl_module modules/mod_ssl.so” in the httpd.conf file. (if commented, was for me)
* Uncomment “LoadModule socache_shmcb_module modules/mod_socache_shmcb.so” in the httpd.conf file. (if commented, was for me)
* Uncomment “#Include conf/extra/httpd-ssl.conf” in the httpd.conf file under #Secure (SSL/TLS) connections. (if commented, was for me)
* Uncomment IfModule ssl_module tags (if commented, wasn't for me)

* Open "httpd-ssl.conf" in the "conf/extra" folder
* Replace "c:/Apache24" with "c:/wamp64/bin/apache/apache2.4.23" (or whatever appropriate)
* Replace ServerName with "faroeadventures.com:443"
* Replace ServerAdmin with appropriate email
* Replace SSLCertificateFile, SSLCertificateKeyFile with the appropriate file paths ("C:/wamp64/www/mitt-feriested/faroeadventures.com.crt", "C:/wamp64/www/mitt-feriested/faroeadventures.com.nopass.key" resp.)
* Uncomment SSLCACertificateFile and replace value with appropriate ("C:/wamp64/www/mitt-feriested/root.ca.crt")
