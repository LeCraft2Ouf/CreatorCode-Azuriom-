# Creator Codes for Azuriom

Plugin for the official [Shop](https://market.azuriom.com/resources/1) plugin. Players can enter a creator code when buying site money. The creator receives a bonus percentage **on top**. Nothing is deducted from the buyer.

Built according to the [Azuriom plugin documentation](https://azuriom.com/en/docs/plugins): Bootstrap 5 markup, Blade stacks (`styles`, `scripts` with `defer`, `footer-scripts`), `plugin_asset()`, and **no theme or Shop view edits**.

## Requirements

- Azuriom 1.2+ (`azuriom_api`: 1.2.0)
- Shop plugin (`dependencies.shop`)

## Install

1. The ZIP **must** have `plugin.json` at the root.
2. Extract to `plugins/creatorcodes` (folder name = plugin id).
3. Admin → Plugins → enable **Creator Codes**.
4. Grant `creatorcodes.manage` if the admin menu is missing.
5. Add creators (Azuriom username, code, percentage).

If you previously patched Shop or theme Blade files with `@include('creatorcodes::shop.box')`, remove those includes and run `php artisan optimize:clear`.

## License

Apache License 2.0
