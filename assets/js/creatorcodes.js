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

    function isPaysafecardPage() {
        return /paysafecard/i.test(window.location.pathname);
    }

    function wrapAsCard(box) {
        var card = document.createElement('div');
        var header = document.createElement('div');
        var inner = document.createElement('div');
        var title = box.querySelector('[data-creatorcodes-title]');

        card.className = 'card mb-4';
        header.className = 'card-header';
        inner.className = 'card-body';

        if (title) {
            header.textContent = title.textContent;
            title.remove();
        }

        box.classList.remove('creatorcodes-inline', 'mb-4', 'pb-4');
        inner.appendChild(box);
        card.appendChild(header);
        card.appendChild(inner);

        return card;
    }

    function findPaymentCard() {
        var cards = document.querySelectorAll('.card');
        var i;
        var card;
        var header;
        var form;

        for (i = 0; i < cards.length; i++) {
            card = cards[i];

            if (card.querySelector('[data-creatorcodes-box]')) {
                continue;
            }

            header = card.querySelector('.card-header');

            if (header && /paysafecard/i.test(header.textContent)) {
                return card;
            }
        }

        for (i = 0; i < cards.length; i++) {
            card = cards[i];
            form = card.querySelector('form');

            if (form && !form.querySelector('[name="creator_code"]')) {
                return card;
            }
        }

        return null;
    }

    function insertIntoCard(card, box) {
        var body = card.querySelector('.card-body');
        var header = card.querySelector('.card-header');

        if (body) {
            body.insertBefore(box, body.firstChild);
            return;
        }

        if (header) {
            insertAfter(header, box);
            return;
        }

        card.insertBefore(box, card.firstChild);
    }

    function mount(box) {
        var paymentCard;

        if (isPaysafecardPage()) {
            paymentCard = findPaymentCard();

            if (paymentCard) {
                insertIntoCard(paymentCard, box);
                return;
            }
        }

        var deluxeCat = document.querySelector('#shop .shop-nav-cat');
        var deluxeCard = deluxeCat && deluxeCat.closest('.card');

        if (deluxeCard && deluxeCard.parentNode) {
            insertAfter(deluxeCard, wrapAsCard(box));
            return;
        }

        var content = document.querySelector('#shop')
            || document.querySelector('.container.content')
            || document.querySelector('main .container')
            || document.querySelector('.container')
            || document.querySelector('main')
            || document.body;

        paymentCard = findPaymentCard();

        if (paymentCard) {
            insertIntoCard(paymentCard, box);
            return;
        }

        content.insertBefore(wrapAsCard(box), content.firstChild);
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
