const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .vue()
    .sass("resources/sass/app.scss", "public/css")
    .version();

mix.webpackConfig({
    output: {
        chunkFilename: "js/[name].js?id=[chunkhash]",
    },
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
        },
    },
});

mix.options({
    processCssUrls: false,
});

mix.env({
    MIX_PUSHER_APP_KEY: process.env.MIX_PUSHER_APP_KEY,
    MIX_PUSHER_APP_CLUSTER: process.env.MIX_PUSHER_APP_CLUSTER,
});
