import Vue from "vue"
import Vuex from "vuex"
import axios from "axios"

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        languages:[],
        forms:{
            target:{
                name:"targetForm",
                disabled:0,
                title:"Çeviri Metni",
                text:"",
                selected:"0"
            },
            result:{
                name:"resultForm",
                disabled:1,
                title:"Sonuç Metni",
                text:"",
                selected:"en"
            }
        },
        HeaderButtons : {
            changeBtn : {
                class : "btn m-3 btn-light",
                title : "Dili Değiştir",
                icon : "swap_horiz",
                action : "changeLanguage",
                text : 1,
                disabled : 0
            },
            translateBtn : {
                class : "btn m-3 btn-light",
                title : "Çevir",
                icon : "translate",
                action : "translate",
                text : 1,
                disabled : 0
            }
        },
        translate : {
            targetLanguage: "0",
            targetLanguageName : "",
            targetText : "",
            resultLanguage : "en",
            resultLanguageName : "",
            resultText : ""
        },
        translations : []
    },
    mounted(){
        if(localStorage.translations){
            this.translations = JSON.parse(localStorage.translations);
        }
    },
    mutations: {
        initLanguages(state, languages){
            state.languages = languages
        },
        updateTargetText(state, targetText){
            state.forms.target.text = targetText
            state.translate.targetText = targetText
        },
        updateResultText(state, resultText){
            state.forms.result.text = resultText
            state.translate.resultText = resultText
        },
        updateTargetLang(state, targetLang){
            state.forms.target.selected = targetLang
            state.translate.targetLanguage = targetLang
        },
        updateResultLang(state, resultLang){
            state.forms.result.selected = resultLang
            state.translate.resultLanguage = resultLang
        },
        updateTranslation(state, response){
            state.translate = response
            state.forms.result.text = response.resultText
            state.forms.target.selected = response.targetLanguage
        },
        translationAdd(state, response) {
            state.translations.push(response);
            localStorage.translations = JSON.stringify(state.translations);
        },
        changeLanguage(state,changeValue){
            const targetText = changeValue.targetText;
            const targetLanguage = changeValue.targetLanguage;
            state.forms.target.text = changeValue.resultText
            state.forms.target.selected = changeValue.resultLanguage
            state.forms.result.text = changeValue.targetText
            state.forms.result.selected = changeValue.targetLanguage
            state.translate.targetText = changeValue.resultText
            state.translate.targetLanguage = changeValue.resultLanguage
            state.translate.resultText = targetText
            state.translate.resultLanguage = targetLanguage

        },
        getLanguage(state,langCode){
            console.log(state.languages.code.indexOf(langCode))

        }
    },
    actions:{
        initApp(context){
        axios.get("http://127.0.0.1:8000/api/language")
            .then(response => {
                context.commit("initLanguages", response.data)
            })
        },
        updateTargetText(context, targetText){
            context.state.HeaderButtons.translateBtn.disabled = 0
            context.commit("updateTargetText", targetText)
        },
        updateResultText(context, resultText){
            context.commit("updateResultText", resultText)
        },
        updateTargetLang(context, targetLang){
            context.state.HeaderButtons.translateBtn.disabled = 0
            context.commit("updateTargetLang", targetLang)
        },
        updateResultLang(context, resultLang){
            context.state.HeaderButtons.translateBtn.disabled = 0
            context.commit("updateResultLang", resultLang)
        },
        translation(context, translate){
            context.state.HeaderButtons.translateBtn.disabled = 1
            axios.post("http://127.0.0.1:8000/api/translate",translate)
                .then(response => {
                    context.commit("updateTranslation", response.data)
                    context.commit("translationAdd", response.data)
                })
        },
        changeLanguage(context, translate){
            context.state.HeaderButtons.translateBtn.disabled = 0
            context.commit("changeLanguage", translate)
        }
    },
    getters:{
        getLanguages(state){
            return state.languages
        },
        getForms(state){
            return state.forms
        },
        getHeaderButtons(state){
            return state.HeaderButtons
        },
        getTranslations(state){
            if(localStorage.translations){
                state.translations = JSON.parse(localStorage.translations);
            }
            return state.translations
        }
    }
})

export default store