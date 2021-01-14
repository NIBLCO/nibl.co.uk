import resolve from '@rollup/plugin-node-resolve';
import babel from '@rollup/plugin-babel';
import postcss from 'rollup-plugin-postcss'
import {terser} from "rollup-plugin-terser";

export default {
  input: 'assets/js/main.js',
  output: {
    file: 'public/static/main.js',
    format: 'cjs',
    compact: process.env.NODE_ENV === 'production'
  },
  plugins: [
    postcss({extract: true, config: true}),
    resolve(),
    babel({babelHelpers: 'bundled'}),
    (process.env.NODE_ENV === 'production' && terser()),
  ]
};
