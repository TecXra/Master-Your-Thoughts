// import axios from 'axios';

export default function ({$axios, redirect}) {
    $axios.onRequest(config => {
        config.headers['Content-Type'] = 'application/json';
        config.headers['Access-Control-Allow-Origin'] = "*";
    })

    $axios.create({
        baseURL: process.env.baseUrl
      })
}
