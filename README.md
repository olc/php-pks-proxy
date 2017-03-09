# php-pks-proxy

Quick and dirty proxy for retrieving OpenPGP public key from a server which has not direct access to Internet.
This script just forward standard HKP requests to remote SKS OpenPGP.

Add this to the Apache configuration:
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^\.]+)$ $1.php [NC,L]
```

The script `lookup.php` must be located in a directory named `pks` (actually you must pay attention
that `/pks/lookup.php` reach the script).

Usage:
```
sudo add-apt-key -k hkp://<ip-or-fqdn-of-the-pks-proxy>:80 <key number>
```
