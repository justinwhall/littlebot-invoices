import { convertToCase } from './casing';

const {
  data: {
    useDispatch,
    select,
  },
  element: {
    useState,
    useEffect,
  },
} = wp;

export const useMeta = () => {
  const meta = select('core/editor').getEditedPostAttribute('meta') || {};
  const { editPost } = useDispatch('core/editor');
  const metaCamelCase = convertToCase(meta, 'camel');
  const [postMeta, setMeta] = useState(metaCamelCase);

  const updateMeta = (val) => setMeta({ ...postMeta, ...val });

  useEffect(() => {
    const metaUpdate = convertToCase(postMeta, 'snake');

    editPost({
      meta: {
        ...metaUpdate,
      },
    });
  }, [postMeta]);

  return {
    meta: postMeta,
    updateMeta,
  };
};
