<template>
    <div class="kajla-wrapper">

        <router-link class="site-logo" to="/">
            <img src="assets/images/kajla-logo.png">
        </router-link>

        <Navigation />
        <Hero />
        <div class="container container--main">
            <router-view></router-view>
        </div>
        <Cookie :is-open="isCookieModalOpen" v-on:onClose="openCookieModal"/>
        <Ending :is-open="isEndingModalOpen" v-on:onClose="openEndingModal"/>
        <Footer />
        <cookie-law buttonText="Elfogadom">
            <div slot="message">
                Ez a honlap sütiket használ. A sütik elfogadásával kényelmesebbé teheti a böngészést. A honlap további használatával hozzájárulását adja a sütik használatához.
                <a @click.prevent="openCookieModal">További információ</a>
            </div>

        </cookie-law>

    </div>
</template>

<script>
import store from '../store'
import Hero from './hero'
import Footer from './footer'
import Navigation from './navigation'
import Cookie from './cookie'
import CookieLaw from 'vue-cookie-law'
import Ending from './ending'

export default {
    name: 'app',
    components: {
        'Hero': Hero,
        'Footer': Footer,
        'Navigation': Navigation,
        "CookieLaw": CookieLaw,
        "Ending": Ending,
        "Cookie": Cookie
    },
    data() {
        return {
            isCookieModalOpen: false,
            isEndingModalOpen: false,
        }
    },

    created() {
      window.addEventListener('load', function(event) {
            window.scroll(0, 0)
        })
    },


    methods: {
        openCookieModal() {
            store.CookieModalIsVisible = !store.CookieModalIsVisible
        },
        openEndingModal() {
            store.EndingModalIsVisible = !store.EndingModalIsVisible
        }
    },

    metaInfo: {
      // if no subcomponents specify a metaInfo.title, this title will be used
      // all titles will be injected into this template
      titleTemplate: '%s | Kajla Osztálydekor'
    }

}
</script>
