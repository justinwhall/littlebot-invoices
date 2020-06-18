import { hot, setConfig } from 'react-hot-loader';

setConfig({
  showReactDomPatchNotification: false,
});

const {
  blockEditor: {
    RichText,
  },
  components: {
    TextControl,
  },
  compose: {
    compose,
  },
  data: {
    withDispatch,
  },
  i18n: {
    __,
  },
} = wp;

const LineItem = ({
  attributes, clientId, setAttributes, updateLineItems,
}) => {
  const handleChange = (val, attName) => {
    const numInputs = ['rate', 'qty', 'precent'];
    const newAtts = {};
    // newAtts[attName] = numInputs.includes(attName) ? parseInt(val, 10) || 0 : val;
    newAtts[attName] = val;

    console.log('newAtts', newAtts);

    setAttributes(newAtts);
    updateLineItems(clientId);
  };

  return (
    <>
      <TextControl
        label="Name"
        value={attributes.name}
        onChange={(val) => handleChange(val, 'name')}
      />
      <TextControl
        label="rate"
        type="number"
        value={attributes.rate}
        onChange={(val) => handleChange(val, 'rate')}
      />
      <TextControl
        label="Qty"
        value={attributes.qty}
        onChange={(val) => handleChange(val, 'qty')}
      />
      <TextControl
        label="%"
        value={attributes.percent}
        onChange={(val) => handleChange(val, 'percent')}
      />
      <RichText
        className="block__description"
        keepPlaceholderOnFocus
        onChange={(val) => handleChange(val, 'desc')}
        placeholder={__('Optional Description', 'littlebot-invoices')}
        tagName="p"
        value={attributes.desc}
      />
    </>
  );
};

export default compose([
  withDispatch((dispatch) => {
    const {
      updateMyControlValue,
      updateLineItems,
    } = dispatch('littlebot/lineitems');

    return {
      updateMyControlValue,
      updateLineItems,
    };
  }),
])(LineItem);
