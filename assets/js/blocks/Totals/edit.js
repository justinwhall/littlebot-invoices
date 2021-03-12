import { hot, setConfig } from 'react-hot-loader';
import styled from '@emotion/styled';
import { useMeta } from '../../util/useMeta';
import { toDollars } from '../../util/money';

const StyledTotal = styled.div`
  display: grid;
  grid-template-columns: 100px auto;
`;

setConfig({
  showReactDomPatchNotification: false,
});

const {
  compose: {
    compose,
  },
  data: {
    withSelect,
  },
  element: {
    useEffect,
  },
} = wp;

const Totals = ({
  attributes, setAttributes, lineItems, taxRate,
}) => {
  // console.log(taxRate);
  const calcTotal = () => {
    const sub_total = lineItems.reduce(
      (accum, item) => accum + item.attributes.total, 0,
    );
    const total = parseInt(sub_total + (sub_total * (taxRate / 100)), 10);
    setAttributes({ sub_total, total });
  };

  useEffect(() => {
    calcTotal();
  }, [lineItems, taxRate]);

  return (
    <StyledTotal>
      <div>Sub total</div>
      <div>{toDollars(attributes.sub_total)}</div>
      <div>Total</div>
      <div>{toDollars(attributes.total)}</div>
    </StyledTotal>
  );
};

export default compose([
  withSelect((select) => {
    // This function here is the selector we created before.
    const { getMyControlValue, getTaxRate } = select('littlebot/lineitems');
    return {
      lineItems: getMyControlValue(),
      taxRate: getTaxRate(),
    };
  }),
])(hot(module)(Totals));
