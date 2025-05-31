import Vue from 'vue'
import ModalField from './components/admin/ModalField.vue'
import LightboxField from './components/admin/LightboxField.vue'
import SEOLinkWrapper from './components/admin/SEOLinkWrapper.vue'
import ImageUploadGallery from './components/admin/ImageUploadGallery.vue'
import TabbedContentField from './components/admin/TabbedContentField.vue'

var adminApp = new Vue({
    el: '#admin-app',
    components: {
        'seo-links-field': SEOLinkWrapper,
        'modal-field': ModalField,
        'lightbox-field': LightboxField,
        'image-upload-gallery': ImageUploadGallery,
        'tabbed-content-field': TabbedContentField,
    },
})
