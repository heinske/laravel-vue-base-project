'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  SERVER: '"http://localhost:81"',
  NODE_ENV: '"development"',
  KEY_RECAPTCHA: '"6LeWYaUUAAAAAJ_0S4Yt8nm9Kov4kyhBYMxLbmXq"',
  ROOT_API1: '"http://localhost:81/"',
  URL_PORTAL: '"http://google.com.br"'
})
