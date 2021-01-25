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
  i18n: {
    __,
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
        label={__('Invoice Number', 'littlebot-invoices')}
        value={meta.invoiceNumber || postID}
        type="number"
        onChange={(val) => updateMeta({ invoiceNumber: val })}
      />
      <TextControl
        label={__('P.O. Number', 'littlebot-invoices')}
        value={meta.poNumber || ''}
        type="number"
        onChange={(val) => updateMeta({ poNumber: val })}
      />
      <TextControl
        label={__('Tax rate %', 'littlebot-invoices')}
        value={meta.taxRate || ''}
        type="number"
        onChange={(val) => updateMeta({ taxRate: val })}
      />
    </PluginDocumentSettingPanel>
  );
};
registerPlugin(
  'littlebot-slot-settings',
  { render: PluginDocumentSettingPanelDemo },
);
