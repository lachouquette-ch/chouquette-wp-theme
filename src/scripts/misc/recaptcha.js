import {load as recaptchaV3Load} from 'recaptcha-v3'

export default class ReCaptcha {
    static load() {
        return recaptchaV3Load('6LeGzZoUAAAAAMfFh3ybAsEBM_ocOUWbPnDRbg0U', {
            useRecaptchaNet: true,
            autoHideBadge: true
        })
    }
}