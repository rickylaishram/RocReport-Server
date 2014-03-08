RocReport Server
=================

Part of rocreport that runs on the server


## Instruction
Set up .htaccess

#### .htaccess (sample)
	RewriteEngine on
	RewriteRule ^(static|v1|v2)($|/) - [L]
	RewriteCond $1 !^(index\.php|images|robots\.txt)
	RewriteRule ^(.*)$ index.php/$1 [L]


## Tables
Refer to table.md

License
================
GPL v3
