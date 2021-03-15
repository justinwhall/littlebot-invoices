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
    let lineItemsBlockId;
    const { getBlockOrder, getBlock } = select('core/block-editor');
    const clientIdBlock = getBlock(clientId);

    // We need to get the lb/lineitems block client id.
    if (clientIdBlock.name === 'lb/lineitems') {
      lineItemsBlockId = clientIdBlock.clientId;
    } else {
      lineItemsBlockId = select('core/editor')
        .getBlockHierarchyRootClientId(clientId);
    }

    // get all innerBlockIds.
    const innerBlockIds = getBlockOrder(lineItemsBlockId);
    const lineItemBlocks = innerBlockIds.map((id) => getBlock(id));
    const lineItems = lineItemBlocks.filter((item) => item);

    return {
      type: 'UPDATE_LINEITEMS',
      lineItems,
    };
  },
};

export default actions;
