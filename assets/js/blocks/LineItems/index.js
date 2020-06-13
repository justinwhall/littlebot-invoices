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

registerBlockType('lb/lineitems', {
  title: __('Line Items'),
  icon: 'shield',
  category: 'common',
  keywords: [
    __('my-block — CGB Block'),
    __('Littlebot'),
  ],
  attributes: {
    lineItems: {
      default: {},
      type: 'object',
    },
  },
  edit,
  save: () => null,
});
