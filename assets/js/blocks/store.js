/**
 * Setup store
 */
import reducer from './reducer';
import actions from './actions';
import selectors from './selectors';

const { registerStore } = wp.data;

const store = registerStore('littlebot/lineitems', {
  reducer,
  actions,
  selectors,
});

window.store = store;

export default store;
