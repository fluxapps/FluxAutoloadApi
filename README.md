# flux-autoload-api

PHP Autoload Api

## Installation

Hint: Use `latest` as `%tag%` (or omit it) for get the latest build

### Non-Composer

```dockerfile
COPY --from=docker-registry.fluxpublisher.ch/flux-autoload/api:%tag% /flux-autoload-api /%path%/libs/flux-autoload-api
```

or

```dockerfile
RUN (mkdir -p /%path%/libs/flux-autoload-api && cd /%path%/libs/flux-autoload-api && wget -O - https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-autoload/api.tar.gz?tag=%tag% | tar -xz --strip-components=1)
```

or

Download https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-autoload/api.tar.gz?tag=%tag% and extract it to `/%path%/libs/flux-autoload-api`

Hint: If you use `wget` without pipe use `--content-disposition` to get the correct file name

#### Usage

```php
require_once __DIR__ . "/%path%/libs/flux-autoload-api/autoload.php";
```

### Composer

```json
{
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "flux/flux-autoload-api",
                "version": "%tag%",
                "dist": {
                    "url": "https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-autoload/api.tar.gz?tag=%tag%",
                    "type": "tar"
                },
                "autoload": {
                    "files": [
                        "autoload.php"
                    ]
                }
            }
        }
    ],
    "require": {
        "flux/flux-autoload-api": "*"
    }
}
```
