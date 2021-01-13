/**
 * Entry point for all Littlebot gutenberg 🤖
 */

// Blocks.
import './blocks/store';
import './blocks/SideBar';
import './blocks/LineItem/index.js';
import './blocks/LineItems/index.js';
import './blocks/Totals/index.js';
// Slotfills.
import './slotfills/PostStatusInfo.js';
import './slotfills/LittleBotSettingsPanel.js';

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
