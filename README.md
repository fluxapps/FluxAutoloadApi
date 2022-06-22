# flux-autoload-api

PHP Autoload Api

## Installation

### Non-Composer

#### In docker

```dockerfile
COPY --from=docker-registry.fluxpublisher.ch/flux-autoload/api:%tag% /flux-autoload-api /%path%/libs/flux-autoload-api
```

or

```dockerfile
RUN (mkdir -p /%path%/libs/flux-autoload-api && cd /%path%/libs/flux-autoload-api && wget -O - https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-autoload/api.tar.gz?tag=%tag% | tar -xz --strip-components=1)
```

#### Other

Download https://docker-registry.fluxpublisher.ch/api/get-build-archive/flux-autoload/api.tar.gz?tag=%tag% and extract it to /%path%/libs/flux-autoload-api

Use `--content-disposition` with `wget` to get the correct file name

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
                "name": "flux/autoload-api",
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
        "flux/autoload-api": "*"
    }
}
```
