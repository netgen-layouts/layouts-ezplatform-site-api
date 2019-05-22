# Netgen Layouts & eZ Platform Site API integration installation instructions

## Use Composer to install the integration

Run the following command to install Netgen Layouts & eZ Platform Site API
integration:

```
composer require netgen/layouts-ezplatform-site-api
```

## Activating integration bundle

After completing standard Netgen Layouts and eZ Platform integration install
instructions, you also need to activate `NetgenLayoutsEzPlatformSiteApiBundle`. Make
sure it is activated after all other Netgen Layouts bundles.

```
...

$bundles[] = new Netgen\Bundle\LayoutsEzPlatformBundle\NetgenLayoutsEzPlatformBundle();
$bundles[] = new Netgen\Bundle\LayoutsEzPlatformSiteApiBundle\NetgenLayoutsEzPlatformSiteApiBundle();

return $bundles;
```
