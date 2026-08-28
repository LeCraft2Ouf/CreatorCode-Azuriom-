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
    .creatorcodes-box-input,
    [data-creatorcodes-box] .shop-nav-cat input {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        outline: none !important;
        color: inherit !important;
        flex: 1 1 auto;
        min-width: 0;
        padding: 0;
        font-weight: inherit;
    }
    [data-creatorcodes-box] .shop-nav-cat input::placeholder {
        color: inherit;
        opacity: 0.55;
    }
    [data-creatorcodes-box] .shop-nav-cat {
        cursor: default;
        width: 100%;
    }
    [data-creatorcodes-box] .shop-nav-cat.creatorcodes-invalid {
        box-shadow: inset 0 0 0 1px #f87171;
    }
    .creatorcodes-error {
        color: #fca5a5;
        font-size: 0.8rem;
    }
    .creatorcodes-icon-btn {
        background: transparent;
        border: 0;
        padding: 0;
        color: inherit;
        line-height: 1;
    }
    .creatorcodes-icon-btn:disabled {
        opacity: 0.5;
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

        var cat = document.querySelector('#shop .shop-nav-cat');
        var card = cat && cat.closest('.card');

        if (card && card.parentNode) {
            if (card.nextSibling) {
                card.parentNode.insertBefore(box, card.nextSibling);
            } else {
                card.parentNode.appendChild(box);
            }
        } else {
            var fallback = document.querySelector('#shop .shop-navigation')
                || document.querySelector('.card-body')
                || document.body;
            fallback.appendChild(box);
        }

        mount.remove();
    });
</script>
