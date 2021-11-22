window._ = require('lodash');
import axios from 'axios';
import Form from './utils/Form';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Form = Form;
