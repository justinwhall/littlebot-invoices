const {
  select,
} = wp.data;

/**
 * All actions
 */
const actions = {
  updateMyControlValue(value) {
    return {
      type: 'UPDATE_LINEITEMS',
      value,
    };
  },
  updateLineItems(clientId) {
    const { getBlockOrder, getBlock } = select('core/block-editor');
    const parentClientID = select('core/editor').getBlockHierarchyRootClientId(clientId);

    // get all innerBlockIds
    const innerBlockIds = getBlockOrder(parentClientID);
    const lineItemBlocks = innerBlockIds.map((id) => getBlock(id));
    const lineItems = lineItemBlocks.filter((item) => item);

    // Update meta
    // wp.data.dispatch('core/editor').editPost({ meta: { line_items: JSON.stringify(lineItems) } });

    return {
      type: 'UPDATE_LINEITEMS',
      lineItems,
    };
  },
};

export default actions;
