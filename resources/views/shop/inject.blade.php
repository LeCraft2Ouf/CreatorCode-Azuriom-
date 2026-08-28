<style>
    .alert-success {
        background: #163528 !important;
        color: #c6f6d5 !important;
        border-color: #2f6f4e !important;
    }
    .alert-danger {
        background: #3a1c1c !important;
        color: #fecaca !important;
    }
    .creatorcodes-box {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        max-width: 520px;
    }
</style>
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
        var section = shop && shop.querySelector('section');
        var row = section && section.querySelector('.row');
        var target = row || section || shop || document.querySelector('.card-body') || document.body;

        if (row && row.parentNode) {
            row.parentNode.insertBefore(box, row.nextSibling);
        } else {
            target.appendChild(box);
        }

        mount.remove();
    });
</script>
