Netgen Block Manager & eZ Platform Site API integration installation instructions
=================================================================================

Use Composer to install the integration
---------------------------------------

Run the following command to install Netgen Block Manager & eZ Platform Site API
integration:

```
composer require netgen/block-manager-site-api:^1.0
```

Activating integration bundle
-----------------------------

After completing standard Block Manager and eZ Publish integration install
instructions, you also need to activate `NetgenSiteAPIBlockManagerBundle`. Make
sure it is activated after all other Block Manager bundles.

```
...

$bundles[] = new Netgen\Bundle\EzPublishBlockManagerBundle\NetgenEzPublishBlockManagerBundle();
$bundles[] = new Netgen\Bundle\SiteAPIBlockManagerBundle\NetgenSiteAPIBlockManagerBundle();

return $bundles;
```
