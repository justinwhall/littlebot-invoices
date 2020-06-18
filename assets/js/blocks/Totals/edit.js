import { hot, setConfig } from 'react-hot-loader';
import store from '../store';

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
    withDispatch,
    select,
  },
  element: {
    useEffect,
  },
} = wp;

const Totals = () => {
  useEffect(() => {
  }, []);

  return (
    <div>
      Totals
    </div>
  );
};

export default Totals;
