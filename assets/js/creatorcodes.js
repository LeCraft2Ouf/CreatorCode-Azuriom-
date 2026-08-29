(function () {
    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    function insertAfter(reference, node) {
        reference.parentNode.insertBefore(node, reference.nextSibling);
    }

    function mount(box) {
        var deluxeCat = document.querySelector('#shop .shop-nav-cat');
        var deluxeCard = deluxeCat && deluxeCat.closest('.card');

        if (deluxeCard && deluxeCard.parentNode) {
            insertAfter(deluxeCard, box);
            return;
        }

        var shopRoot = document.querySelector('#shop');
        var content = shopRoot
            || document.querySelector('.container.content')
            || document.querySelector('main .container')
            || document.querySelector('.container')
            || document.querySelector('main')
            || document.body;

        var heading = content.querySelector('h1, h2');

        if (heading) {
            insertAfter(heading, box);
            return;
        }

        content.insertBefore(box, content.firstChild);
    }

    ready(function () {
        var placeholder = document.getElementById('creatorcodes-mount');

        if (!placeholder) {
            return;
        }

        var alreadyMounted = Array.prototype.slice
            .call(document.querySelectorAll('[data-creatorcodes-box]'))
            .some(function (el) {
                return !placeholder.contains(el);
            });

        if (alreadyMounted) {
            placeholder.remove();
            return;
        }

        var box = placeholder.querySelector('[data-creatorcodes-box]');

        if (!box) {
            placeholder.remove();
            return;
        }

        mount(box);
        placeholder.remove();
    });
})();
