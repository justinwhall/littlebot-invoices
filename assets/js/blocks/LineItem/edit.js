import { hot, setConfig } from 'react-hot-loader';

setConfig({
  showReactDomPatchNotification: false,
});

const { compose } = wp.compose;
const { withDispatch, withSelect } = wp.data;
const { TextControl } = wp.components;

const LineItem = ({
  attributes, clientId, setAttributes, updateLineItems,
}) => {
  const handleChange = (val) => {
    setAttributes({ lineItemTitle: val });
    updateLineItems(clientId, val);
  };

  return (
    <TextControl
      label="Line Item"
      type="text"
      value={attributes.lineItemTitle}
      onChange={(val) => handleChange(val)}
    />
  );
};

const LineItemRedux = compose([
  withDispatch((dispatch, ownProps, registry) => {
    const {
      updateMyControlValue,
      updateLineItems,
    } = dispatch('littlebot/lineitems');

    return {
      updateMyControlValue,
      updateLineItems,
    };
  }),
  withSelect((select, props) => {
    // This function here is the selector we created before.
    const { getMyControlValue } = select('littlebot/lineitems');
    return {
      value: getMyControlValue(),
    };
  }),
])(LineItem);

export default hot(module)(LineItemRedux);
