import { hot, setConfig } from 'react-hot-loader';
import styled from '@emotion/styled';

const StyledTotal = styled.div`
  display: grid;
  grid-template-columns: auto auto;
`;

setConfig({
  showReactDomPatchNotification: false,
});

const {
  blockEditor: {
    InnerBlocks,
  },
  compose: {
    compose,
  },
  data: {
    withSelect,
    select,
  },
  element: {
    useEffect,
  },
} = wp;

const Totals = ({ attributes, setAttributes, lineItems }) => {
  const {
    subTotal,
    total,
  } = attributes;

  const calcTotal = () => {
    const total = lineItems.reduce((accum, item) => accum + item.attributes.total, 0);

    setAttributes({ total });
  };

  useEffect(() => {
    console.log('lineItems', lineItems);
    calcTotal();
  }, [lineItems]);

  return (
    <StyledTotal>
      <div>Total</div>
      <div>{attributes.total}</div>
    </StyledTotal>
  );
};

export default compose([
  withSelect((select, props) => {
    // This function here is the selector we created before.
    const { getMyControlValue } = select('littlebot/lineitems');
    return {
      lineItems: getMyControlValue(),
    };
  }),
])(hot(module)(Totals));
