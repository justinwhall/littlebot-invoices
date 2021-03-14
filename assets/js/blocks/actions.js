const {
  select,
} = wp.data;

/**
 * All actions
 */
const actions = {
  updateTaxRate(taxRate) {
    return {
      type: 'UPDATE_TAXRATE',
      taxRate,
    };
  },
  updateLineItems(clientId) {
    console.log(clientId);
    const { getBlockOrder, getBlock } = select('core/block-editor');
    const parentClientID = select('core/editor')
      .getBlockHierarchyRootClientId(clientId);

    // get all innerBlockIds
    const innerBlockIds = getBlockOrder(parentClientID);
    const lineItemBlocks = innerBlockIds.map((id) => getBlock(id));
    const lineItems = lineItemBlocks.filter((item) => item);

    return {
      type: 'UPDATE_LINEITEMS',
      lineItems,
    };
  },
};

export default actions;
