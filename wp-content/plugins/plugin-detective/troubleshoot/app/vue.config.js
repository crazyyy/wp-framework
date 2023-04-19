const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  filenameHashing: false,
  devServer: {
    proxy: {
      '/wp-': {
          target: 'http://plugindetective.localdev',
          changeOrigin: true
      },
      '/api': {
          target: 'http://plugindetective.localdev',
          changeOrigin: true,
      },
      '/api.php': {
          target: 'http://plugindetective.localdev/wp-content/plugins/plugin-detective/troubleshoot',
          changeOrigin: true
      },
      '/local-get-app.php': {
          target: 'http://plugindetective.localdev/wp-content/plugins/plugin-detective/troubleshoot/app',
          changeOrigin: true
      }
    }
  },

  assetsDir: 'static'
})
