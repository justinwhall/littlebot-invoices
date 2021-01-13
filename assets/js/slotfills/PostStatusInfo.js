/* eslint-disable camelcase */

const {
  data: {
    useDispatch,
    useSelect,
    select,
  },
  element: {
    useState,
    useEffect,
  },
  i18n: {
    __,
  },
  editPost: {
    PluginPostStatusInfo,
  },
  plugins: {
    registerPlugin,
  },
} = wp;

const PostStatusInfo = () => {
  // const {
  //   type,
  // } = select('core/editor').getCurrentPost();

  const {
    meta,
  } = useSelect((select) => ({
    meta: select('core/editor').getEditedPostAttribute('meta') || {},
  }));

  console.log(meta);

  const { editPost } = useDispatch('core/editor');
  // const [embedMeta, setEmbedMeta] = useState(
  //   knight_foundation_app_event_show_vid_after_event
  // );

  // useEffect(() => {
  //   editPost({
  //     meta: {
  //       ...meta,
  //       knight_foundation_app_event_show_vid_after_event: embedMeta,
  //     },
  //   });
  // }, [embedMeta]);

  return (
    <PluginPostStatusInfo>
      <div className="module--type-event-embed components-base-control">
        hello
      </div>
    </PluginPostStatusInfo>
  );
};

registerPlugin('littlebot-slot-status-info', { render: PostStatusInfo });
