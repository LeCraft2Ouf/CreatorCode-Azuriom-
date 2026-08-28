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

Add this on the site-money purchase pages (gateway / offer selection), for example in your theme:

```blade
@if(plugins()->isEnabled('creatorcodes'))
    @include('creatorcodes::shop.box')
@endif
```

Deluxe theme files already patched on Neodium:

- `resources/themes/deluxe/views/plugins/shop/designs/1/offers/payment.blade.php`
- `resources/themes/deluxe/views/plugins/shop/designs/1/offers/select.blade.php`
- `resources/themes/deluxe/views/plugins/shop/designs/2/offers/payment.blade.php`
- `resources/themes/deluxe/views/plugins/shop/designs/2/offers/select.blade.php`

Paysafecard manual pay view can include the same box.

## Behaviour

Example: buyer purchases 1000 neos with code `SKYZZ` at 10%.

- Buyer: 1000 neos
- Creator: +100 neos
