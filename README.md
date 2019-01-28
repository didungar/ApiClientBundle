# NOT READY FOR USE !

## For install :

Add to composer the requirement
```php
    composer require "DidUngar/ApiServerBundle"
```

Add the service to config :
```yaml
    DidUngar\ApiClientBundle\Services\ApiClientService:
        public: true
        arguments:
            $api_url: '%api_url%'
        calls:
            - method: setAuth
              arguments:
                - '%http_auth_username%'
                - '%http_auth_password%'
```

If you using SF4 :
```yaml
    DidUngar\ApiClientBundle\Services\ApiClientService:
        public: true
        arguments:
            $api_url: '%env(PLANETGUARDIANS_SERVER_API)%'
```
