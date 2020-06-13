const initialState = {
  lineItems: [
    'line item 1',
    'line item 2',
    'line item 3',
  ],
};

const reducer = (state = initialState, action) => {
  console.log('action', action);
  switch (action.type) {
    case 'UPDATE_LINEITEMS': {
      return {
        lineItems: {
          ...state.lineItems,
          value: action.value,
        },
      };
    }
    default:
      return state;
  }
};

export default reducer;
