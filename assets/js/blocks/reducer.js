const initialState = {
  lineItems: [],
  taxRate: 0,
};

const reducer = (state = initialState, action) => {
  console.log('action', action);
  switch (action.type) {
    case 'UPDATE_LINEITEMS':
      return {
        ...state,
        lineItems: action.lineItems,
      };
    case 'UPDATE_TAXRATE':
      return {
        ...state,
        taxRate: action.taxRate,
      };
    default:
      return state;
  }
};

export default reducer;
