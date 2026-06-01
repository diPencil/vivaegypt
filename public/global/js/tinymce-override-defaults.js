(function () {
    if (typeof tinymce === 'undefined' || typeof tinymce.overrideDefaults !== 'function') {
        return;
    }
    tinymce.overrideDefaults({
        branding: false,
        promotion: false,
    });
})();
