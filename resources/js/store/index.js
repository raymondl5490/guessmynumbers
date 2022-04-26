import Vuex from 'vuex';

import attempts from "./modules/attempts";
import games from "./modules/games";

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        attempts,
        games
    },
    strict: debug,
    plugins: debug ? [Vuex.createLogger()] : []
})
