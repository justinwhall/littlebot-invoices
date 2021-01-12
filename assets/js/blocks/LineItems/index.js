/**
 * BLOCK: LineItems
 *
 */

import edit from './edit';

const {
  i18n: {
    __,
  },
  blockEditor: {
    InnerBlocks,
  },
  blocks: {
    registerBlockType,
  },
} = wp;

registerBlockType('lb/lineitems', {
  title: __('Line Items'),
  icon: 'shield',
  category: 'common',
  keywords: [
    __('my-block — CGB Block'),
    __('Littlebot'),
  ],
  attributes: {
    metaLineItems: {
      type: 'string',
      source: 'meta',
      meta: 'line_items',
    },
    lineItems: {
      type: 'array',
      source: 'meta',
      meta: '_line_items',
    },
    taxRate: {
      // type: 'integer',
      source: 'meta',
      meta: '_tax_rate',
    },
  },
  edit,
  save: () => <InnerBlocks.Content />,
});
