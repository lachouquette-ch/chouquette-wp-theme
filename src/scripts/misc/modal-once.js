import Cookies from 'js-cookie';
import jQuery from 'jquery';

class ModalOnce {
    constructor(cookieName, modalId) {
        this.cookieName = cookieName;
        this.modalId = modalId;
    }

    isAccepted() {
        return Cookies.get(this.cookieName);
    }

    accept(duration = 800, expires = 365) {
        Cookies.set(this.cookieName, 1, {expires: expires});
        jQuery(this.modalId).hide(duration);
    }

    show(duration = 1200) {
        if (!this.isAccepted()) {
            jQuery(this.modalId).show(duration);
        }

        jQuery(this.modalId).on('shown.bs.modal', function () {
            jQuery(`${this.modalId} input:first-of-type`).focus();
        })
    }

    asyncShow(timeout = 1000) {
        setTimeout(this.show, timeout);
    }
}

export const confidentialityModal = new ModalOnce("confidentialityWarningAccepted", "#confidentialityWarning");
window.confidentialityModal = confidentialityModal;
export const newsletterModal = new ModalOnce("newsletterModalShown", "#newsletterModal");
window.newsletterModal = newsletterModal;