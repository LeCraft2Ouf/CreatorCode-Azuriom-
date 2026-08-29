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

    function firstPageCard(root) {
        var cards = root.querySelectorAll('.card');
        var i;
        var card;

        for (i = 0; i < cards.length; i++) {
            card = cards[i];

            if (!card.closest('[data-creatorcodes-box]')) {
                return card;
            }
        }

        return null;
    }

    function mount(box) {
        var deluxeCat = document.querySelector('#shop .shop-nav-cat');
        var deluxeCard = deluxeCat && deluxeCat.closest('.card');

        if (deluxeCard && deluxeCard.parentNode) {
            insertAfter(deluxeCard, box);
            return;
        }

        var content = document.querySelector('#shop')
            || document.querySelector('.container.content')
            || document.querySelector('main .container')
            || document.querySelector('.container')
            || document.querySelector('main')
            || document.body;

        var paymentCard = firstPageCard(content);

        if (paymentCard && paymentCard.parentNode) {
            paymentCard.parentNode.insertBefore(box, paymentCard);
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
