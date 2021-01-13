/**
 * Entry point for all Littlebot blocks 🤖
 */
import './store';
import './SideBar';
import './LineItem/index.js';
import './LineItems/index.js';
import './Totals/index.js';
import './slotfills.js';

const {
  domReady,
  data: {
    dispatch,
  },
  i18n: {
    __,
    setLocaleData,
  },
} = wp;

domReady(() => {
  setLocaleData({ Publish: [__('Save', 'littlebot-invoices')] });
  dispatch('core/edit-post').toggleEditorPanelOpened('littlebot-slot-settings');
});
