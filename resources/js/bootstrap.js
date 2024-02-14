import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const converTime = (seconds) => {
    const result = new Date(seconds * 1000)
        .toISOString()
        .slice(11, 19);
    return result;
}

window.converTime = converTime;
