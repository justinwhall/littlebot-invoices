const {
  data: {
    dispatch,
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
  useEffect(() => {
    // Open panel on load.
    dispatch('core/edit-post').toggleEditorPanelOpened(
      'littlebot-slot-settings/littlebot-doc-settings',
    );
  }, []);

  return (
    <PluginDocumentSettingPanel
      name="littlebot-doc-settings"
      title="Littlebot 🤖"
      className="littlebot-slot-settings"
    >
      Custom Panel Contents
    </PluginDocumentSettingPanel>
  );
};
registerPlugin(
  'littlebot-slot-settings',
  { render: PluginDocumentSettingPanelDemo },
);
