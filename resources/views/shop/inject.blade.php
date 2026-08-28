<style>
    form[action*="/cart/giftcards"] { display: none !important; }
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
    @include('creatorcodes::shop.box', ['compact' => ! empty($compact)])
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

        var addForm = document.querySelector('form[action*="/cart/giftcards/add"]');

        if (addForm && addForm.parentNode) {
            var parent = addForm.parentNode;
            var after = addForm.nextElementSibling;
            var node = addForm.previousElementSibling;

            while (node && node.tagName !== 'HR') {
                var prev = node.previousElementSibling;
                node.parentNode.removeChild(node);
                node = prev;
            }

            document.querySelectorAll('form[action*="/cart/giftcards"]').forEach(function (form) {
                if (form.parentNode) {
                    form.parentNode.removeChild(form);
                }
            });

            parent.insertBefore(box, after);
        } else {
            var shop = document.getElementById('shop');
            var target = (shop && (shop.querySelector('section') || shop))
                || document.querySelector('.card-body')
                || document.body;
            target.insertBefore(box, target.firstChild);
        }

        mount.remove();
    });
</script>
