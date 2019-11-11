import Cookies from 'js-cookie';
import $ from 'jquery';

export default class ShowOnce {
    constructor(cookieName) {
        this.cookieName = cookieName;
    }

    hasBeenShown() {
        return Cookies.get(this.cookieName);
    }

    setAsShown(duration = 800, expires = 365) {
        Cookies.set(this.cookieName, 1, {expires: expires});
        $(this.modalId).hide(duration);
    }

    show(callback) {
        if (!this.hasBeenShown()) {
            callback();
        }
    }

    asyncShow(callback, timeout = 1000) {
        const promise = new Promise(resolve => setTimeout(resolve, timeout));
        promise.then(() => this.show(callback));
    }
}