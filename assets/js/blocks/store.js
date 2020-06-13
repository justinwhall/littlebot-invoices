/**
 * Setup store
 */
import reducer from './reducer';
import actions from './actions';
import selectors from './selectors';

const { registerStore } = wp.data;

registerStore('littlebot/lineitems', {
  reducer,
  actions,
  selectors,
});
