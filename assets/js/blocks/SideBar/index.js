/* eslint-disable no-underscore-dangle */
import Tax from './Tax';

const {
  data: {
    withSelect,
    dispatch,
  },
  editPost: {
    PluginSidebar,
  },
  plugins: {
    registerPlugin,
  },
} = wp;

const mapSelectToProps = (select) => {
  const meta = select('core/editor').getEditedPostAttribute('meta');

  return {
    tax: meta.tax,
  };
};

const setMetaField = (metaKey, metaValue) => {
  const meta = {};
  meta[metaKey] = metaValue;

  dispatch('core/editor').editPost({ meta });
};

const SideBar = ({ tax }) => (
  <PluginSidebar
    name="littlebot-invoices-sidebar"
    icon="admin-post"
    title="LittleBot Invoices"
  >
    <Tax
      setMetaField={setMetaField}
      metaValue={tax}
    />
  </PluginSidebar>
);

registerPlugin('littlebot-invoices-sidebar', {
  render: withSelect(mapSelectToProps)(SideBar),
});
