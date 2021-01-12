/* eslint-disable camelcase */
import { hot, setConfig } from 'react-hot-loader';
import store from '../store';

setConfig({
  showReactDomPatchNotification: false,
});

const {
  blockEditor: {
    InnerBlocks,
  },
  compose: {
    compose,
  },
  data: {
    withDispatch,
    select,
  },
  element: {
    useEffect,
  },
} = wp;

const LineItems = (props) => {
  useEffect(() => {
    const { line_items } = select('core/editor').getEditedPostAttribute('meta');

    if (line_items) {
      store.dispatch({
        type: 'UPDATE_LINEITEMS',
        lineItems: JSON.parse(line_items),
      });
    }
  }, []);

  return (
    <div>
      Line Items
      <InnerBlocks
        allowedBlocks={['lb/lineitem']}
        templateLock={false}
      />
    </div>
  );
};

export default compose([
  withDispatch((dispatch) => {
    const {
      updateLineItems,
    } = dispatch('littlebot/lineitems');

    return {
      updateLineItems,
    };
  }),
])(LineItems);
