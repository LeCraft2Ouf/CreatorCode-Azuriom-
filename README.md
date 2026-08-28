# Creator Codes for Azuriom

Azuriom shop plugin: players can enter a creator code when buying site money (neos). The creator receives a bonus percentage **on top**. Nothing is deducted from the buyer.

Requires the official [Shop](https://market.azuriom.com/resources/1) plugin.

## Install

1. Copy this folder to `plugins/creatorcodes` on your Azuriom site.
2. Admin → Plugins → enable **Creator Codes** (runs migrations).
3. Grant the `creatorcodes.manage` permission if the admin menu is missing.
4. Add creators (username, code, percentage, active).

The username must match an existing Azuriom account (neos are credited there).

## Shop UI

From the Azuriom root, after enabling the plugin:

```sh
php plugins/creatorcodes/tools/patch-deluxe.php
php artisan optimize:clear
```

This inserts the creator code box on Deluxe offer pages (designs 1 and 2), default shop views, and Paysafecard Manual.

You can also add it manually:

```blade
@if(plugins()->isEnabled('creatorcodes'))
    @include('creatorcodes::shop.box')
@endif
```


## Behaviour

Example: buyer purchases 1000 neos with code `SKYZZ` at 10%.

- Buyer: 1000 neos
- Creator: +100 neos
