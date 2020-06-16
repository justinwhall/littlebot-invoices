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

const LineItems = () => {
  useEffect(() => {
    // eslint-disable-next-line camelcase
    const { line_items } = select('core/editor').getEditedPostAttribute('meta');

    // Update store with initial lineitem value
    store.dispatch({
      type: 'UPDATE_LINE_ITEMS',
      lineItems: JSON.parse(line_items),
    });
  }, []);

  return (
    <div>
      add line items
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
