/**
 * BLOCK: Line Item
 *
 */
import edit from './edit';
import attributes from './attributes';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('lb/lineitem', {
  title: __('Line Item'),
  icon: 'shield',
  category: 'common',
  keywords: [
    __('my-block — CGB Block'),
    __('CGB Example'),
    __('create-guten-block'),
  ],
  edit,
  attributes,
  save: () => null,
});
