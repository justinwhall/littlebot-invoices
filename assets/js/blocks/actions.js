/**
 * All actions
 */
const actions = {
  updateMyControlValue(value) {
    return {
      type: 'UPDATE_Lconstol',
      value,
    };
  },
  updateLineItems(clientId) {
    const { getBlockOrder, getBlock } = wp.data.select('core/block-editor');
    const parentClientID = wp.data.select('core/editor').getBlockHierarchyRootClientId(clientId);

    // get all innerBlockIds
    const innerBlockIds = getBlockOrder(parentClientID);
    const lineItems = innerBlockIds.map((id) => getBlock(id));

    // Update meta
    wp.data.dispatch('core/editor').editPost({ meta: { line_items: JSON.stringify(lineItems) } });

    return {
      type: 'UPDATE_LINEITEMS',
      lineItems,
    };
  },
};

export default actions;
