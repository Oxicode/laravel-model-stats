<template>
    <div id="model-stats-app">
        <loading ref="loading"/>

        <layout>
            <div>
                <alert @close="closeAlert"
                       class="mb-4"
                       :message="alert.message"
                       :type="alert.type"
                       :auto-close="alert.autoClose"
                       :confirmation-proceed="alert.confirmationProceed"
                       :confirmation-cancel="alert.confirmationCancel"
                       v-if="alert.type"></alert>
                <router-view/>
            </div>
        </layout>
    </div>
</template>

<script>
import Loading from './Loading'
import Layout from './Layout'

import axios from 'axios'
import {mapGetters} from "vuex";

export default {
    el: '#model-stats',

    components: {
        Loading, Layout
    },

    data: () => ({
        alert: {
            type: null,
            autoClose: 0,
            message: '',
            confirmationProceed: null,
            confirmationCancel: null,
        },
    }),

    mounted() {
        this.$loading = this.$refs.loading
        this.loadDashboards()
    },

    computed: {
        ...mapGetters({
            dashboard: 'dashboards/current',
        }),
    },

    methods: {
        closeAlert() {
            this.alert = {
                type: null,
                autoClose: 0,
                message: '',
                confirmationProceed: null,
                confirmationCancel: null,
            }
        },
        loadDashboards() {
            this.$store.commit('dashboards/loads')

            axios.get(this.apiPath + 'dashboards').then((response) => {
                this.$store.commit('dashboards/set', response.data)
                this.$store.commit('dashboards/stoppedLoading')

                // Set current
                if (this.dashboard == null && response.data.length) {
                    this.$store.commit('dashboards/setCurrentId', response.data[0].id)
                    this.$store.commit('widgets/set', this.dashboard.body.widgets)
                }
            })
        }
    }
}
</script>
