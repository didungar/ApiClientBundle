# NOT READY FOR USE !

## For install :

Add to composer the requirement
```
    composer require "DidUngar/ApiServerBundle"
```

Add the service to config :
```
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
