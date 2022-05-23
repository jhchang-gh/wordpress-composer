// import external dependencies
import 'jquery';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import search from './routes/search';
import map from './routes/map';
import timeline from './routes/timeline';
import biographiesPage from './routes/biographiesPage';

/** Populate Router instance with DOM routes */
const routes = new Router({
  common,
  home,
  search,
  map,
  timeline,
  biographiesPage,
});

require('@fancyapps/fancybox');

// Load Events
jQuery(document).ready(() => routes.loadEvents());
