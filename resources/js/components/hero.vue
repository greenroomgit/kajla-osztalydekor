<template>
    <section :class="[
                'section section-hero separator ',
                'hero--home',
                ]">
        <div class="container">
            <div class="hero-body" v-if="isHomepage">
                <h1 class="">
                    <b>Alkossatok csodát!</b>
                    Építsétek meg magyarország 3D-s térképét, és diszítsétek vele osztálytermeteket!
                </h1>
            </div>

          <div class="hero__family hero__family--left"></div>
          <div class="hero__family hero__family--right"></div>

        </div>

    </section>
</template>

<script>
    export default {
        name: 'hero',
        data() {
            return {
                isHome: false
            }
        },
        computed: {
            isHomepage() {
                return this.$route.path === '/';
            }
        }
    }
</script>
