import Vue from "vue"
import VueRouter from "vue-router"
import TranslatePage from "./pages/TranslatePage"
import HistoryPage from "./pages/HistoryPage"
import RegisterListPage from "./pages/RegisterListPage"

Vue.use(VueRouter)

export const router = new VueRouter({
    routes : [
        { path : "/", component : TranslatePage},
        { path : "/historyList", component : HistoryPage},
        { path : "/registerList", component : RegisterListPage},
        { path : "*", redirect : '/'}
    ]
})
