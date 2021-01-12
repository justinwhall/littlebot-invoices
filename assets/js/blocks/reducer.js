const initialState = {
  lineItems: [],
};

const reducer = (state = initialState, action) => {
  // console.log('action', action);
  switch (action.type) {
    case 'UPDATE_LINEITEMS':
      return {
        ...state,
        lineItems: action.lineItems,
      };
    default:
      return state;
  }
};

export default reducer;
