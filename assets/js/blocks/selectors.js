/**
 * All selectors
 */
const selectors = {
  getLineItems(state) {
    return state.lineItems;
  },
  getTaxRate(state) {
    return state.taxRate;
  },
};

export default selectors;
