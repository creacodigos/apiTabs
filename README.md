# apiTabs

Api resti ful para servir datos de tablaturas:

http://apitabs.creacodigos.com/

## Basada en SLIM 

## .htaccess

```
# Necesario para evitar error CORS

Header add Access-Control-Allow-Origin "*"
Header add Access-Control-Allow-Headers "origin, x-requested-with, content-type"
Header add Access-Control-Allow-Methods "PUT, GET, POST, DELETE, OPTIONS"


# Necesario para omitir api.php/ de la URL
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ api.php [QSA,L] 
```

### GET

`http://apitabs.creacodigos.com/partituras`

`http://apitabs.creacodigos.com/partitura/id`

### POST

`http://apitabs.creacodigos.com/partitura`

### PUT

`http://apitabs.creacodigos.com/partitura/id`

### DELETE

`http://apitabs.creacodigos.com/partitura/id`