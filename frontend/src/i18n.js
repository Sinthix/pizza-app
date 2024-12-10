import { createI18n } from 'vue-i18n';
import en from './locales/en.json';
import pt from './locales/pt.json';

const i18n = createI18n({
  locale: 'en',
  messages: {
    en: en,
    pt: pt
  }
});

export default i18n;
