<template>
    <div class="modal" :class="{ 'is-active': modalIsVisible}">
        <div class="modal-background"></div>
        <div class="modal-inner">
            <div class="modal-content">
                <button class="modal-close-button" aria-label="close" @click.prevent="closeModal()"></button>
                <!-- FORM WITH v-if WILL BE SHOWN BUT THEN HIDDEN AFTER SUCCESS SUBMIT -->
                <form v-if="showForm" class="form">
                    <div class="form__description">
                        A kép feltöltéséhez kérjük adjátok meg az alábbi adatokat:
                    </div>
                    <div :class="errors.name ? 'form__input-container form__input-container--no-bottom-margin' : 'form__input-container'">
                        <label for="modalNameInput" class="form__label col-md-4 col-form-label text-md-right">Név</label>

                        <div class="col-md-6">
                            <!-- NOTICE v-model="formData.name" - THAT'S HOW IT GETS ATTACHED TO THE FIELD -->
                            <input v-model="formData.name" id="modalNameInput" type="text" class="form__input" name="name" required autocomplete autofocus>
                            <div class="form__input-error" v-if="errors.name">{{errors.name}}</div>
                        </div>
                    </div>

                    <div :class="errors.email ? 'form__input-container form__input-container--no-bottom-margin' : 'form__input-container'">
                        <label for="modalEmailInput" class="form__label col-md-4 col-form-label text-md-right">E-mail cím</label>

                        <div class="col-md-6">
                            <!-- NOTICE v-model="formData.name" - THAT'S HOW IT GETS ATTACHED TO THE FIELD -->
                            <input v-model="formData.email" id="modalEmailInput" type="text" class="form__input" name="email" required autocomplete >
                            <div class="form__input-error" v-if="errors.email">{{errors.email}}</div>
                        </div>
                    </div>

                    <div class="form__input-container form__input-container--full-width">
                        <label for="modalImageSchoolInput" class="form__label col-md-4 col-form-label text-md-right">Iskola neve</label>

                        <div class="col-md-6">
                            <!-- NOTICE v-model="formData.name" - THAT'S HOW IT GETS ATTACHED TO THE FIELD -->
                            <textarea v-model="formData.school" id="modalImageSchoolInput" maxlength="105" class="form__textarea form__textarea--full-width form__textarea--long-bg" name="school" rows="8" cols="80" required></textarea>
                            <div class="form__input-error" v-if="errors.school">{{errors.school}}</div>
                        </div>
                    </div>


                    <div class="form__input-container form__input-container--full-width">
                        <label for="modalImageClassInput" class="form__label col-md-4 col-form-label text-md-right">Osztály</label>

                        <div class="col-md-6">
                            <!-- NOTICE v-model="formData.name" - THAT'S HOW IT GETS ATTACHED TO THE FIELD -->
                            <input v-model="formData.class" id="modalImageClassInput" type="text" class="form__input form__input--full-width form__input--long-bg" name="class" required autocomplete >
                            <div class="form__input-error" v-if="errors.class">{{errors.class}}</div>
                        </div>
                    </div>

                    <div class="form__input-container form__input-container--full-width form__input-container--horizontal-centered">
                        <div class="col-md-6">
                            <div class="custom-file">
                                <!-- MOST IMPORTANT - SEE "ref" AND "@change" PROPERTIES -->
                                <input type="file" class="custom-file-input form__input--hidden" id="customFile" ref="file" @change="handleFileObject()">
                                <label class="form__input-button-container custom-file-label text-left" for="customFile">
                                    <span class="button is-primary form__input-button">Kép kiválasztása</span>

                                    <div class="form__image-preview-container" v-if="picture">
                                        <img :src="pictureUrl" class="form__image-preview">
                                    </div>
                                    <div class="form__input-error" v-if="errors.picture">{{errors.picture}}</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form__input-container form__input-container--full-width">
                        <label for="modalImageTitleInput" class="form__label col-md-4 col-form-label text-md-right">Kép címe</label>

                        <div class="col-md-6">
                            <!-- NOTICE v-model="formData.name" - THAT'S HOW IT GETS ATTACHED TO THE FIELD -->
                            <input v-model="formData.caption" id="modalImageTitleInput" type="text" class="form__input form__input--full-width form__input--long-bg" name="caption" required autocomplete >
                        </div>
                    </div>

                    <div class="form__input-container form__input-container--full-width ">
                        <label class="form__label form__label--checkbox">Megismertem, és elfogadom a <a @click.self.prevent="download(`docs/kajla-makett-mese-jatekszabalyzat.pdf`)">jatékszabályzatot és az adatkezelési tájékoztatót</a>
                    <input v-model="formData.terms" type="checkbox" class="form__checkbox" name="terms" value="1">
                    <span class="form__checkmark"></span>
                  </label>
                        <div class="form__input-error" v-if="errors.terms">{{errors.terms}}</div>
                    </div>



                    <div class="form__input-container form__input-container--full-width form__input-container--horizontal-centered form__input-container--bottom-offset">
                        <div class="col-md-6 offset-md-4 column">
                            <button @click.prevent="submit" type="submit" class="btn button is-secondary upload" :disabled="isLoading">
                      Feltöltés
                    </button>
                        </div>
                    </div>
                </form>

                <div v-if="upload" class="modal-success yellow-box">
                    <div class="yellow-box__inner">
                        <img class="modal-success-icon" :src="'/assets/svg/success-icon.svg'" alt="">
                        <div class="modal-success-header">A képet sikeresen megkaptuk, köszönjük!</div>
                        <div class="modal-success-notice">Publikálás előtt még gyorsan ellenőrizzük, e-mailben fogunk értesíteni, ha kikerült az oldalra.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import store from '../store.js';

import axios from 'axios'
import _ from 'lodash'

export default {
    props: {
        isOpen: Boolean,
        default: false,
    },
    data() {
        return {
            formData: {
                name: null,
                email: null,
                school: null,
                caption: null,
                class: null,
                terms: false
            },
            picture: null,
            pictureUrl: null,
            showForm: true,
            upload: null,
            errors: {},
            isLoading: false,
        }
    },
    methods: {
        submit() {
            this.errors = {}

            const isFromOk = this.checkForm();

            if (isFromOk) {
                let formData = new FormData()
                formData.append('picture', this.picture)
                this.isLoading = true;
                _.each(this.formData, (value, key) => {
                    formData.append(key, value)
                })
                axios.post('/api/upload-photo', formData, {
                    headers: {
                        'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                    }
                }).then(response => {
                    this.showForm = false
                    this.upload = response.data.data
                    this.isLoading = false;
                }).catch(err => {
                    if (err.response.status === 422) {
                        this.errors = {}

                        for (let [key, value] of Object.entries(err.response.data.errors)) {
                            this.errors[key] = value[0]
                        }

                    }
                        this.isLoading = false;
                });
            } else {
                return;
            }
        },

        checkForm() {
            this.errors = {};

            if (!this.formData.name) {
                this.errors.name = 'Kötelezően kitöltendő';
            }
            if (!this.formData.email) {
                this.errors.email = 'Kötelezően kitöltendő';
            }
            if (this.formData.email && !this.emailIsValid(this.formData.email)) {
                this.errors.email = 'Nem megfelelő e-mail cím';
            }
            if (!this.picture) {
                this.errors.picture = 'Nem adtál hozzá képet';
            }
            if (this.picture && !this.pictureFormatIsValid(this.picture)) {
                this.errors.picture = 'Megengedett képformátum: jpeg, jpg, png, gif, bmp';
            }
            if (!this.formData.terms) {
                this.errors.terms = 'Nem fogadtad el a feltételeket';
            }
            if (!this.formData.school) {
                this.errors.school = 'Kötelezően kitöltendő';
            }
            if (!this.formData.class) {
                this.errors.class = 'Kötelezően kitöltendő';
            }

            if (!this.formData.caption) {
                this.errors.caption = 'Kötelezően kitöltendő';
            }

            if (Object.keys(this.errors).length === 0) {
                return true;
            } else {
                return false;
            }
        },

        resetForm() {
            this.formData = {
                name: null,
                email: null,
                school: null,
                class: null,
                caption: null,
                terms: null
            }
            this.picture = null,
                this.pictureUrl = null,
                this.showForm = true,
                this.upload = null,
                this.errors = []
        },

        emailIsValid(email) {
            const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return emailRegex.test(email);
        },

        pictureFormatIsValid(picture) {
            const pictureFormatRegex = /\.(jpe?g|png|gif|bmp)$/i;
            return pictureFormatRegex.test(picture.name)
        },
        postcodeIsValid(postcode) {
            const postcodeRegex = /^[0-9]{4}?$/;
            return postcodeRegex.test(postcode);
        },

        handleFileObject() {
            this.picture = this.$refs.file.files[0]
            this.pictureUrl = URL.createObjectURL(this.picture);
        },
        closeModal() {
            this.resetForm()
            this.$emit('onClose')
        },
        download: function (url) {
          window.open(url, "_blank");
        }

    },
    computed: {
        modalIsVisible() {
            return store.photoUploadModalIsVisible
        }
    }

}
</script>
