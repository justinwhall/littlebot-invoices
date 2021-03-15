import store from '../blocks/store';

const {
  data: {
    subscribe,
    select,
    dispatch,
  },
} = wp;

const getBlockList = () => select('core/block-editor').getBlocks();
let blockList = getBlockList();

const getLineItemBlocks = (items) => {
  const newLineItems = items.filter(
    (block) => block.name === 'lb/lineitems',
  );
  return newLineItems[0] || [];
};

/**
 * Determines if a lineitem block has been added/removed.
 * @param {array} newBlockList The latest list of blocks.
 * @returns The currest line items or false if unchanged.
 */
const lineItemsChanged = (newBlockList) => {
  const { getLineItems } = select('littlebot/lineitems');
  const storeLineItems = getLineItems();

  if (!storeLineItems) {
    return false;
  }

  const lineItems = getLineItemBlocks(blockList);
  const newLineItems = getLineItemBlocks(newBlockList);

  if (lineItems.innerBlocks.length !== newLineItems.innerBlocks.length) {
    return newLineItems.innerBlocks;
  }

  return false;
};

subscribe(() => {
  const postId = wp.data.select('core/editor').getCurrentPostId();
  const postType = wp.data.select('core/editor').getCurrentPostType();

  if (!postId || !['lb_invoice', 'lb_estimate'].includes(postType)) {
    return;
  }

  /**
   * Keep an eye on the current state of blocks
   */
  const newBlockList = getBlockList();

  /**
   * Make sure there is at least one line item.
   */
  if (
    newBlockList.length < blockList.length
    && newBlockList.every((block) => block.name !== 'lb/lineitem')
  ) {
    dispatch('core/block-editor').resetBlocks(blockList);
  }

  /**
   * Update totals if a line item is added/removed.
   */
  const lineItems = lineItemsChanged(newBlockList);

  /**
   * Update blocklist to avoid infinite loop.
   */
  blockList = newBlockList;

  /**
   * Finally, if we have new line items, update the store.
   */
  if (lineItems) {
    store.dispatch({
      type: 'UPDATE_LINEITEMS',
      lineItems,
    });
  }
});
