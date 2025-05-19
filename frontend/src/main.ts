import './assets/css/animate.min.css'
import './assets/css/bootstrap.min.css'
import './assets/css/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import * as Sentry from "@sentry/vue";

const app = createApp(App)

Sentry.init({
    app,
    dsn: "https://6338cfe6041c64ce329d20ff8ce40a94@o1118693.ingest.us.sentry.io/4509343165186048",
    // Setting this option to true will send default PII data to Sentry.
    // For example, automatic IP address collection on events
    sendDefaultPii: true
  });

app.use(createPinia())
app.use(router)

app.mount('#app')
