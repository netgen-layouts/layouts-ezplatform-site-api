Netgen Layouts & eZ Platform Site API integration installation instructions
===========================================================================

Use Composer to install the integration
---------------------------------------

Run the following command to install Netgen Layouts & eZ Platform Site API
integration:

```
composer require netgen/block-manager-site-api:^1.0
```

Activating integration bundle
-----------------------------

After completing standard Netgen Layouts and eZ Platform integration install
instructions, you also need to activate `NetgenSiteAPIBlockManagerBundle`. Make
sure it is activated after all other Netgen Layouts bundles.

```
...

$bundles[] = new Netgen\Bundle\EzPublishBlockManagerBundle\NetgenEzPublishBlockManagerBundle();
$bundles[] = new Netgen\Bundle\SiteAPIBlockManagerBundle\NetgenSiteAPIBlockManagerBundle();

return $bundles;
```
