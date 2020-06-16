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
  },
  edit,
  save: () => <InnerBlocks.Content />,
});
