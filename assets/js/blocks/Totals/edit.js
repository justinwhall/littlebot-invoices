import { hot, setConfig } from 'react-hot-loader';
import styled from '@emotion/styled';
// import { useMeta } from '../../util/useMeta';
import { toDollars } from '../../util/money';
import { useDidUpdate } from '../../hooks';

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
    memo,
  },
} = wp;

const TotalsLineItems = memo((props) => (
  <StyledTotal>
    <div>
      Sub total
    </div>
    <div>{toDollars(props.subTotal)}</div>
    <div>Total</div>
    <div>{toDollars(props.total)}</div>
  </StyledTotal>
));

TotalsLineItems.displayName = 'TotalLineItems';

const Totals = ({
  attributes,
  setAttributes,
  lineItems,
  taxRate,
}) => {
  const calcTotal = () => {
    if (!lineItems || taxRate === false) {
      return;
    }

    const sub_total = lineItems.reduce(
      (accum, item) => accum + item.attributes.total, 0,
    );

    const total = parseInt(sub_total + (sub_total * (taxRate / 100)), 10);

    // Only update if the totals have changed.
    if (attributes.total !== total || attributes.sub_total !== sub_total) {
      setAttributes({ sub_total, total });
    }
  };

  useDidUpdate(() => {
    calcTotal();
  }, [lineItems, taxRate]);

  return (
    <TotalsLineItems subTotal={attributes.sub_total} total={attributes.total} />
  );
};

export default compose([
  withSelect((select) => {
    // This function here is the selector we created before.
    const { getLineItems, getTaxRate } = select('littlebot/lineitems');
    return {
      lineItems: getLineItems(),
      taxRate: getTaxRate(),
    };
  }),
])(hot(module)(Totals));
