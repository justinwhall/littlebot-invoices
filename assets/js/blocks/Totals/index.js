/**
 * BLOCK: LineItems
 *
 */

import edit from './edit';

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
  attributes: {
    metaLineItems: {
      type: 'string',
      source: 'meta',
      meta: 'line_items',
    },
  },
  edit,
  save: () => null,
});
