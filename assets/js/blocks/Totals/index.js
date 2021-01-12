/**
 * BLOCK: Totals
 *
 */

import edit from './edit';
import attributes from './attributes';

const {
  i18n: {
    __,
  },
  blocks: {
    registerBlockType,
  },
} = wp;

registerBlockType('littlebot/totals', {
  title: __('Totals'),
  icon: 'shield',
  category: 'common',
  keywords: [
    __('Littlebot', 'littlebot-invoices'),
  ],
  attributes,
  edit,
  save: () => null,
});
