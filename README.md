# php-amp-update-cache

This is repository for updating Google AMP cache.

# How to deploy

1. Thoroughly read the official document: https://developers.google.com/amp/cache/update-cache

2. Generate a new RSA key pairs

```
openssl genrsa 2048 > private-key.pem
openssl rsa -in private-key.pem -pubout > public-key.pem
```
Change `public-key.pem` to `apikey.pub` and replace the key in `.well-known/amphtml` folder.
Replace `private-key.pem` in `amp` with the one just created.

3. Upload the 3 folders to root directory of your site.

Note!. If you already have an `composer.json`, please add `"phpseclib/phpseclib": "~2.0"` into your `composer.json`
run `composer install` and upload the your vendor folder instead of the one in this repository.
