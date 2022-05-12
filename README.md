# flux-autoload-api
sdsd

PHP Autoload Api

## Installation

```dockerfile
COPY --from=docker-registry.fluxpublisher.ch/flux-autoload/api:latest /flux-autoload-api /%path%/libs/flux-autoload-api
```

## Usage

```php
require_once __DIR__ . "/%path%/libs/flux-autoload-api/autoload.php";
```
