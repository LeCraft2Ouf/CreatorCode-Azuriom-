<div id="creatorcodes-mount" hidden>
    @include('creatorcodes::shop.box')
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
            || document.querySelector('main')
            || document.body;

        target.insertBefore(box, target.firstChild);
        mount.remove();
    });
</script>
