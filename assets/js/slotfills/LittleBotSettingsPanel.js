const {
  editPost: {
    PluginDocumentSettingPanel,
  },
  plugins: {
    registerPlugin,
  },
} = wp;

const PluginDocumentSettingPanelDemo = () => (
  <PluginDocumentSettingPanel
    name="littlebot-doc-settings"
    title="Littlebot 🤖"
    className="littlebot-slot-settings"
  >
    Custom Panel Contents
  </PluginDocumentSettingPanel>
);
registerPlugin(
  'littlebot-slot-settings',
  { render: PluginDocumentSettingPanelDemo },
);
