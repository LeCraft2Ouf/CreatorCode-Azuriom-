# Creator Codes for Azuriom

Azuriom shop plugin: players can enter a creator code when buying site money (neos). The creator receives a bonus percentage **on top**. Nothing is deducted from the buyer.

Requires the official [Shop](https://market.azuriom.com/resources/1) plugin.

The shop box is injected by the plugin on purchase pages. **Themes are not modified** (including Deluxe).

## Install

1. Copy this folder to `plugins/creatorcodes`.
2. Admin → Plugins → enable **Creator Codes**.
3. Grant `creatorcodes.manage` if the admin menu is missing.
4. Add creators (Azuriom username, code, percentage).

If you previously ran `patch-deluxe.php`, revert theme edits:

```sh
php plugins/creatorcodes/tools/unpatch-deluxe.php
php artisan optimize:clear
```
