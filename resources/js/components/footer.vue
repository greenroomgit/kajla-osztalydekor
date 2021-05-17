<template>
    <footer class="footer has-text-centered-mobile">
        <div class="container">
            <p>Hol vagy Kajla © {{ new Date().getFullYear() }} Minden jog fenntartva</p>
            <a @click="download(`https://kajla.hu/doc/reszveteli_kajla_hu_210517.pdf`)">Általános részvételi szabályzat </a>
            <span></span>
            <a @click="download(`https://kajla.hu/doc/adatkezelesi_kajla_hu_210517.pdf`)">Adatkezelési nyilatkozat </a>
            <span></span>
            <a @click.prevent="openCookieModal">Süti kezelés</a>
            <span></span>
            <a @click="download(`https://www.kajla.hu`)">Kajla.hu </a>
        </div>
    </footer>
</template>

<script>
import store from '../store'

export default {
    data() {
        return {
            isCookieModalOpen: false,
        }
    },

    methods: {
        openCookieModal() {
            store.CookieModalIsVisible = !store.CookieModalIsVisible
        },
        download: function (url) {
          window.open(url, "_blank");
        }

    },


}
</script>
