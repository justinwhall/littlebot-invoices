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
  i18n: {
    __,
    setLocaleData,
  },
} = wp;

domReady(() => {
  console.log('domready');
  // eslint-disable-next-line no-undef
  const label = littlebotStatus === 'publish'
    ? __('Issued', 'littlebot-invoices')
    : __('Save', 'littlebot-invoices');
  setLocaleData({ Publish: [label] });
});
