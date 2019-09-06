/* Confidentiality */
const confidentialityCookieName = "confidentialityWarningAccepted";

function showConfidentiality() {
    if (!Cookies.get(confidentialityCookieName)) {
        $("#confidentialityWarning").show(1200);
    }
};

function acceptConfidentiality() {
    Cookies.set(confidentialityCookieName, 1, {expires: 365});
    $("#confidentialityWarning").hide(800);
}