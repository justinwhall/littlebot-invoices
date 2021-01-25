import { useMeta } from '../util/useMeta';

const {
  components: {
    TextControl,
  },
  data: {
    dispatch,
    select,
  },
  editPost: {
    PluginDocumentSettingPanel,
  },
  element: {
    useState,
    useEffect,
  },
  plugins: {
    registerPlugin,
  },
} = wp;

const PluginDocumentSettingPanelDemo = () => {
  const postID = select('core/editor').getCurrentPostId();
  const { meta, updateMeta } = useMeta();

  useEffect(() => {
    // Open panel on load.
    const pluginSlug = 'littlebot-slot-settings/littlebot-doc-settings';
    const open = select('core/edit-post').getPreference('panels')[pluginSlug].opened; // eslint-disable-line max-len

    if (open) {
      return;
    }

    dispatch('core/edit-post').toggleEditorPanelOpened(
      pluginSlug,
    );
  }, []);

  console.log(meta);

  return (
    <PluginDocumentSettingPanel
      name="littlebot-doc-settings"
      title="Littlebot 🤖"
      className="littlebot-slot-settings"
    >
      <TextControl
        label="Invoice Number"
        value={meta.invoiceNumber || postID}
        type="number"
        onChange={(val) => updateMeta({ invoiceNumber: val })}
      />
    </PluginDocumentSettingPanel>
  );
};
registerPlugin(
  'littlebot-slot-settings',
  { render: PluginDocumentSettingPanelDemo },
);
