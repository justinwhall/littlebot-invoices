import { hot, setConfig } from 'react-hot-loader';
import styled from '@emotion/styled';
import { toDollars } from '../../util/money';
import { useDidUpdate } from '../../hooks';

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
  element: {
    useEffect,
  },
  i18n: {
    __,
  },
} = wp;

const LineMeta = styled.div`
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  grid-gap: 20px;
`;

const LineItem = ({
  attributes, clientId, setAttributes, updateLineItems,
}) => {
  const {
    desc,
    percent,
    name,
    rate,
    qty,
    total,
  } = attributes;

  const handleChange = (val, key) => {
    const newAtts = {};
    let newVal = val;

    if (key === 'rate') {
      console.log('rate', val);
      newVal = parseInt(val * 100, 10);
    }

    if (['discount', 'qty'].includes(key)) {
      newVal = parseInt(val * 1, 10);
    }

    newAtts[key] = newVal;
    setAttributes(newAtts);
  };

  const setLineItemTotal = () => {
    const discount = qty * rate * (percent / 100);
    const newTotal = (rate * qty) - discount;
    // if (total !== parseInt(newTotal, 10)) {
    //   console.log('update');
    setAttributes({ total: parseInt(newTotal, 10) });
    // }
  };

  /**
   * Update lineItem total.
   */
  useEffect(() => {
    setLineItemTotal();
  }, [rate, qty, percent]);

  /**
   * Update store when total changes.
   */
  useDidUpdate(() => {
    updateLineItems(clientId);
  }, [total]);

  return (
    <>
      <TextControl
        label="Name"
        value={name}
        onChange={(val) => handleChange(val, 'name')}
      />
      <LineMeta>
        <TextControl
          label="Rate"
          type="number"
          min="0"
          step="0.01"
          value={toDollars(rate, false) || ''}
          onChange={(val) => handleChange(val, 'rate')}
        />
        <TextControl
          label="Qty"
          type="number"
          min="0"
          value={qty}
          onChange={(val) => handleChange(val, 'qty')}
        />
        <TextControl
          label="Discount %"
          type="number"
          min="0"
          max="100"
          value={percent}
          onChange={(val) => handleChange(val, 'percent')}
        />
        <div className="lb-line-total">{toDollars(total)}</div>
      </LineMeta>
      <RichText
        className="block__description"
        keepPlaceholderOnFocus
        onChange={(val) => handleChange(val, 'desc')}
        placeholder={__('Optional Description', 'littlebot-invoices')}
        tagName="p"
        value={desc}
      />
    </>
  );
};

export default compose([
  withDispatch((dispatch) => {
    const {
      updateLineItems,
    } = dispatch('littlebot/lineitems');

    return {
      updateLineItems,
    };
  }),
])(hot(module)(LineItem));
