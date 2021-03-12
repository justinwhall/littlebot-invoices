import { hot, setConfig } from 'react-hot-loader';
import styled from '@emotion/styled';
import { useMeta } from '../../util/useMeta';

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

const Totals = ({ attributes, setAttributes, lineItems }) => {
  const { meta } = useMeta();

  const calcTotal = () => {
    const subTotal = lineItems.reduce((accum, item) => accum + item.attributes.total, 0);
    const total = subTotal + subTotal * (meta.taxRate / 100);
    // console.log(subTotal);
    setAttributes({ subTotal });
  };

  useEffect(() => {
    calcTotal();
  }, [lineItems]);

  return (
    <StyledTotal>
      <div>Sub total</div>
      <div>{attributes.total}</div>
      <div>Total</div>
      <div>{attributes.total}</div>
    </StyledTotal>
  );
};

export default compose([
  // eslint-disable-next-line no-shadow
  withSelect((select) => {
    // This function here is the selector we created before.
    const { getMyControlValue } = select('littlebot/lineitems');
    return {
      lineItems: getMyControlValue(),
    };
  }),
])(hot(module)(Totals));
