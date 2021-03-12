/**
 * All selectors
 */
const selectors = {
  getMyControlValue(state) {
    return state.lineItems;
  },
  getTaxRate(state) {
    return state.taxRate;
  },
};

export default selectors;
