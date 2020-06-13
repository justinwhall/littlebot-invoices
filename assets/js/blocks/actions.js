/**
 * All actions
 */
const actions = {
  updateMyControlValue(value, index) {
    return {
      type: 'UPDATE_LINEITEMS',
      value,
      index,
    };
  },
};

export default actions;
