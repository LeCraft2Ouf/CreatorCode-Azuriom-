<style>
    .alert-success {
        background: #163528 !important;
        color: #c6f6d5 !important;
        border-color: #2f6f4e !important;
    }
    .alert-danger {
        background: #3a1c1c !important;
        color: #fecaca !important;
        border-color: #7f1d1d !important;
    }
</style>
<div id="creatorcodes-mount" hidden>
    @include('creatorcodes::shop.box', ['compact' => false])
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var mount = document.getElementById('creatorcodes-mount');
        if (!mount) {
            return;
        }

        var alreadyInPage = Array.prototype.slice.call(document.querySelectorAll('[data-creatorcodes-box]'))
            .some(function (el) {
                return !mount.contains(el);
            });

        if (alreadyInPage) {
            mount.remove();
            return;
        }

        var box = mount.querySelector('[data-creatorcodes-box]');
        if (!box) {
            mount.remove();
            return;
        }

        var shop = document.getElementById('shop');
        var target = (shop && (shop.querySelector('section') || shop))
            || document.querySelector('.card-body')
            || document.body;
        target.insertBefore(box, target.firstChild);
        mount.remove();
    });
</script>
