import { hot, setConfig } from 'react-hot-loader';

setConfig({
  showReactDomPatchNotification: false,
});

const { InnerBlocks } = wp.blockEditor;
const { createBlock } = wp.blocks;
const { dispatch } = wp.data;
const { compose } = wp.compose;
const { withDispatch, withSelect } = wp.data;

const {
  // useState,
  useEffect,
} = wp.element;

const initialState = {
  lineItems: [
    'line item 1',
    'line item 2',
    'line item 3',
  ],
};

const LineItems = (props) => {
  useEffect(() => {
    initialState.lineItems.forEach((item, index) => {
      const nextBlock = createBlock('lb/lineitem', { lineItemTitle: item });
      dispatch('core/block-editor').insertBlock(nextBlock, index, props.clientId);
    });
  }, ['kj']);

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

const LineItemsRedux = compose([
  withDispatch((dispatch, props) => {
    // This function here is the action we created before.
    const { updateMyControlValue } = dispatch('littlebot/lineitems');

    return {
      updateMyControlValue,
    };
  }),
  withSelect((select, props) => {
    // This function here is the selector we created before.
    const { getMyControlValue } = select('littlebot/lineitems');
    // console.log( 'updateMyControlValue', getMyControlValue() );
    return {
      value: getMyControlValue(),
    };
  }),
])(LineItems);

export default hot(module)(LineItemsRedux);
